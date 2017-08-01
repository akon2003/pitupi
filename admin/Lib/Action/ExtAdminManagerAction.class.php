<?php

/**
 * 市场运营/客服
 */

class ExtAdminManagerAction extends ExtAdminCustomerAction{
	public function getActionName() {
		return 'User';
	}
	
	//全部会员
	public function all() {
		$this->assign("main_title","全部会员");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.authority_id'] = $adm_session['authority_id']>0? $adm_session['authority_id'] : '-1';
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}
	//我的会员
	public function index() {
		$this->assign("main_title","我的会员");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.authority_id'] = $adm_session['authority_id']>0? $adm_session['authority_id'] : '-1';
		$map[DB_PREFIX.'user.admin_id'] = $adm_session['adm_id'];
		$this->getUserList(0,0,$map);
		$this->display ();
	}

	//VIP会员
	public function vip() {
		$this->assign("main_title","VIP会员");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.authority_id'] = $adm_session['authority_id']>0? $adm_session['authority_id'] : '-1';
		$map[DB_PREFIX.'user.vip_id'] = array("gt", 0);
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}

	//密码锁定
	public function lock() {	
		$this->assign("main_title","密码错误");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.authority_id'] = $adm_session['authority_id']>0? $adm_session['authority_id'] : '-1';
		$map[DB_PREFIX.'user.sohu_id'] = array("gt", 2);
		$this->getUserList(0,0,$map);
		$this->display ();
	}

	// 会员维护记录列表
	public function visit_log() {
		$this->assign("main_title", "维护日志");		
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		if ($adm_session['authority_id'] > 0) {
			$extwhere = " and u.authority_id=".$adm_session['authority_id'];
		} else {
			$extwhere = " and u.authority_id=-1";
		}
		$this->get_visit_log($extwhere);
		$this->display ();
	}

	//会员维护
	public function customer() {
		$this->assign("main_title","会员维护");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));

		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "adm_name":
				$order ="u.admin_id"; break;
			default : 
				$order =$sorder; break;
		}
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "desc";
		}
		
		//开始加载搜索条件
		$condition =" 1=1 and u.authority_id=".$adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1' ";
		$condition .= " and u.is_effect = 1 and u.is_delete = 0 and u.user_type in (0) ";

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		if ($adm_session['authority_id'] > 0) {
			$condition .= " and u.authority_id =".$adm_session['authority_id'];
		}
		
		$admin_names  = !isset($_REQUEST['adm_names'])? -3 : intval($_REQUEST['adm_names']);
		$_REQUEST['adm_names'] = $admin_names;
		
		// -2：未分配 ，  -1：已分配
		if($admin_names==-2){
			$condition .=" AND u.admin_id = 0 "; 
		} elseif($admin_names == -1){
			$condition .=" AND u.admin_id > 0 ";
		} elseif($admin_names > 0){
			$condition .=" AND u.admin_id = $admin_names  ";
		}
		
		if(isset($_REQUEST['name']) && strim($_REQUEST['name'])!=""){
			$q = strim($_REQUEST['name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			if ($user_list && count($user_list)) {
				$user_id_str = " and u.id in(";
				for ($i=0; $i<count($user_list); $i++) {
					$user_id_str .= $user_list[$i]['id'];
					if ($i < count($user_list)-1) {
						$user_id_str .= ",";
					} else {
						$user_id_str .= ")";
					}
				}
				$condition .= $user_id_str;
			}
		}

		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."user u left join ".DB_PREFIX."admin a on u.admin_id = a.id  WHERE $condition ";

		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
            // XHF 2016-7-22 加入账户总余额
			$sql_list =  " SELECT u.*,AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(u.email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(u.idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."')+u.lock_money as total_money,AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,a.adm_name,c.name as cname FROM ".DB_PREFIX."user u left join ".DB_PREFIX."admin a on u.admin_id = a.id left join ".DB_PREFIX."customer c on c.id = u.customer_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}

		$admin_cate = $GLOBALS['db']->getAll("select id,adm_name,real_name from ".DB_PREFIX."admin where is_effect = 1 and is_delete = 0 and is_department = 0 and pid > 0 and authority_id=".$adm_session['authority_id']);
		foreach ($admin_cate as $k=>$v) {
			if ($v['real_name'] != "") { 
				$admin_cate[$k]['show_name'] = $v['adm_name'].' 【'.$v['real_name'].'】'; 
			} else {
				$admin_cate[$k]['show_name'] = $v['adm_name'];
			}
		}
		$this->assign ( 'admin_cate', $admin_cate );
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display();
	}

	//所有充值
	public function payment() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "所有充值");
		$payment_list = M("Payment")->where("is_effect=1 and class_name<>'Otherpay'")->field("id,name")->findAll();
		$this->assign("payment_list",$payment_list);

		if(isset($_REQUEST['payment_id']) && intval($_REQUEST['payment_id']) > 0){
			$map['payment_id'] = array("eq",intval($_REQUEST['payment_id']));
		} else {
			foreach ($payment_list as $key=>$value) {
				$payment_id[$key] = $value['id'];
			}
			$map['payment_id'] = array("in", $payment_id);
		}

		$user_id = M("User")->where("is_effect=1 and is_delete=0 and authority_id=".($adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1'"))->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$map['user_id'] = array("in", $user_id);
		} else {
			$map['user_id'] = array("in", '-1');
		}
	
		$this->get_payment_list($map);
		$this->display ();
	}

	//POS充值记录
	public function posline() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "POS充值记录");
		$map['payment_id'] = M("Payment")->where("class_name='AllinpayPos'")->getField("id");
		$adm_id = M("Admin")->where("is_effect=1 and is_delete=0 and authority_id>0 and authority_id=".($adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1'"))->field("id")->findAll();
		if ($adm_id && count($adm_id)) {
			foreach ($adm_id as $k=>$v) { $adm_id[$k] = $v['id']; }
			$map['input_user_id'] = array("in", $adm_id);
		} else {
			$map['input_user_id'] = array("in", '-1');
		}

		$this->get_payment_list($map);
		$this->display ();
	}

	//提现记录
	public function carry() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "提现记录");

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and admin_id=".$adm_session['adm_id'])->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$map['user_id'] = array("in", $user_id);
		} else {
			$map['user_id'] = array("in", '-1');
		}
		$this->get_carry_list($map);
		$this->display ();
	}

	//提现失败
	public function carry_fail() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "提现失败");

		$user_id = M("User")->where("is_effect=1 and is_delete=0 and authority_id>0 and authority_id=".($adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1'"))->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$map['user_id'] = array("in", $user_id);
		} else {
			$map['user_id'] = array("in", '-1');
		}
		$map['status'] = array("not in", array(1,4));
		$this->get_carry_list($map);
		$this->display ("carry");
	}

	//投标记录
    public function loads() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "投标记录");

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and id<>2808 and authority_id=".($adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1'"))->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$extwhere = " and dl.user_id in (".implode(',',$user_id).") ";
		} else {
			$extwhere = " and dl.user_id=0 ";
		}
    	$this->get_loads_list($extwhere);
		$this->display();
    }

	//回款信息
    public function repay() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "回款信息");

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and authority_id=".($adm_session['authority_id']>0? $adm_session['authority_id'] : "'-1'"))->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$extwhere = " and dlr.user_id in (".implode(',',$user_id).") ";
		} else {
			$extwhere = " and dlr.user_id=0 ";
		}
		
    	$this->get_repay_list($extwhere);
		$this->display();
    }

	//非支持提现银行卡
    public function unrec_bank() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "非支持提现银行卡");

		$user_id = $GLOBALS['db']->getAll("select distinct(ub.user_id) from ".DB_PREFIX."user_bank ub left join ".DB_PREFIX."bank b on ub.bank_id=b.id left join ".DB_PREFIX."user u on u.id=ub.user_id where b.is_rec=0 and u.authority_id=".$adm_session['authority_id']);
		if ($user_id) {
			foreach ($user_id as $k=>$v) {
				$user_id[$k] = $v['user_id'];
			}
			$list = $GLOBALS['db']->getAll("select ub.*,b.name,b.is_rec,u.mobile,u.admin_id,u.pid from ".DB_PREFIX."user_bank ub left join ".DB_PREFIX."bank b on ub.bank_id=b.id left join ".DB_PREFIX."user u on ub.user_id=u.id where ub.user_id in (".implode(',',$user_id).") order by ub.user_id");
			foreach ($list as $k=>&$v) {
				$v['bankcard'] = preg_replace('/\s+/','',$v['bankcard']);
				$v['bankcard'] = substr($v['bankcard'],0,6).'****'.substr($v['bankcard'],(strlen($v['bankcard'])-5),4);
				$v['is_rec'] = $v['is_rec']==1? '支持':'';
			}
			$this->assign("list", $list);
		}
		$this->display();
    }

	//手机验证码查询
	public function verify_sms() {
		$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."mobile_verify_code where create_time>".(TIME_UTC-30*60)." order by create_time desc");
		$this->assign("list",$list);
		$this->assign("main_title","短信验证码");
		$this->display();
	}

	public function user_admin() {		
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$id = trim($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm'])) {
			//系统安全选项检测
			$this->check_safe_item();

			if (trim($_REQUEST ['admin_id']) != "") {
                $admin_id = intval($_REQUEST ['admin_id']);
            } else {
                $admin_id = 0;
            }

            $user_info['admin_id'] = $admin_id;
            $list = $GLOBALS['db']->query("update ".DB_PREFIX."user set admin_id=".$admin_id." where id in (".$id.")");

            $log_info = "用户编号 ".$id." 分配专属客服";
            if (false !== $list) {
                //成功提示
                save_log($log_info.L("INSERT_SUCCESS"),1);
                $this->success(L("INSERT_SUCCESS"));
            } else {
                //错误提示
                save_log($log_info.L("INSERT_FAILED"),0);
                $this->error(L("INSERT_FAILED"));
            }
        } else {
			$list = $GLOBALS['db']->getAll("select id,user_name,real_name,pid,admin_id from ".DB_PREFIX."user where id in (".$id.")");
			foreach ($list as $k=>$v) {
				$list[$k]['user_referer'] = $v['pid']>0? $GLOBALS['db']->getOne("select real_name from ".DB_PREFIX."user where id=".$v['pid']) : '无';
				$list[$k]['admin_real_name'] = $v['admin_id']>0? $GLOBALS['db']->getOne("select real_name from ".DB_PREFIX."admin where id=".$v['admin_id']) : '无';
				$list[$k]['real_name'] = $v['real_name']? $v['real_name'] : '无';
			}
            $this->assign ( 'list', $list );
            $this->assign ( 'id', $id );

            //管理员列表
            $adm_list = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 0 and pid > 0 and authority_id=".$adm_session['authority_id']);
            foreach ($adm_list as $k=>$v) {
                if ($v['real_name'] != "") { 
                    $adm_list[$k]['show_name'] = $v['adm_name'].' 【'.$v['real_name'].'】'; 
                } else {
                    $adm_list[$k]['show_name'] = $v['adm_name'];
                }
            }

            $this->assign ( 'admins', $adm_list );
            $this->display();
        }
    }

	public function user_reset_password() {		
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm']) && trim($_REQUEST ['password']) != "") {
			//系统安全选项检测
			$this->check_safe_item();

            $password = md5(trim($_REQUEST ['password']));
            $user_info['user_pwd'] = $password;
            $user_info['sohu_id'] = 0;
            $list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

            $log_info = "用户编号".$id."重置密码";
            if (false !== $list) {
                //成功提示
                save_log($log_info.L("INSERT_SUCCESS"),1);
                $this->success(L("INSERT_SUCCESS"));
            } else {
                //错误提示
                save_log($log_info.L("INSERT_FAILED"),0);
                $this->error(L("INSERT_FAILED"));
            }
        } else {
            $vo = get_user_info("*","is_delete=0 and id=".$id);
            $src = isset($_REQUEST ['src'])? trim($_REQUEST ['src']):'';
            $this->assign ('src', $src);
            $this->assign ( 'vo', $vo );
            $this->display();
        }
    }

	public function user_unlock_password() {		
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm']) && trim($_REQUEST ['unlock']) == 1) {
			//系统安全选项检测
			$this->check_safe_item();

			$user_info['sohu_id'] = 0;
            $list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

            $log_info = "用户编号".$id."密码解锁";
            if (false !== $list) {
                //成功提示
                save_log($log_info.L("INSERT_SUCCESS"),1);
                $this->success(L("INSERT_SUCCESS"));
            } else {
                //错误提示
                save_log($log_info.L("INSERT_FAILED"),0);
                $this->error(L("INSERT_FAILED"));
            }
        } else {
            $vo = get_user_info("*","is_delete=0 and id=".$id);
            $src = isset($_REQUEST ['src'])? trim($_REQUEST ['src']):'';
            $this->assign ('src', $src);
            $this->assign ( 'vo', $vo );
            $this->display();
        }
    }
}
?>