<?php

/**
 * XHF 2016-7-22 加入账户总余额: getUserList()
 */

class MyCustomerAction extends CommonAction{
	private function auth(){
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		return $adm_session;
	}

	public function index() {	
		$this->assign("normal","index");
		$this->assign("main_title","会员维护");
		$this->getUserList();
		$this->display ();
	}

	//密码锁定|密码错误超过2次
	public function lock() {	
		$this->assign("main_title","密码错误");
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "adm_name":
					$order ="u.admin_id";
				break;
			
			default : 
				$order =$sorder;
				break;
		}

        //开始加载搜索条件
		$condition =" 1=1 ";
		$condition .= " and u.is_effect = 1 and u.is_delete = 0 and u.user_type in(0,1) and u.sohu_id>2";
	
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
			
			$sql_list =  " SELECT u.*,AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(u.email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(u.idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,a.adm_name,c.name as cname FROM ".DB_PREFIX."user u left join ".DB_PREFIX."admin a on u.admin_id = a.id left join ".DB_PREFIX."customer c on c.id = u.customer_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			$page = $p->show();
			$this->assign ( "page", $page );
		}

		$admin_cate = $GLOBALS['db']->getAll("select id,adm_name,real_name from ".DB_PREFIX."admin where is_effect = 1 and is_delete = 0 and is_department = 0 and pid > 0 ");
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
		$this->display ("lock");
	}

	//未分配授权中心
	public function authority() {
		$this->assign("main_title","未分配授权中心");
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "adm_name":
				$order ="u.admin_id";
				break;
			
			default : 
				$order =$sorder;
				break;
		}

        //开始加载搜索条件
		$condition =" 1=1 ";
		$condition .= " and u.is_effect = 1 and u.is_delete = 0 and u.user_type in(0,1) and u.authority_id=0 and u.pid<>672 ";
	
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
			
			$sql_list =  " SELECT u.*,AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(u.email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(u.idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,a.adm_name,c.name as cname FROM ".DB_PREFIX."user u left join ".DB_PREFIX."admin a on u.admin_id = a.id left join ".DB_PREFIX."customer c on c.id = u.customer_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			$page = $p->show();
			$this->assign ( "page", $page );
		}

		$admin_cate = $GLOBALS['db']->getAll("select id,adm_name,real_name from ".DB_PREFIX."admin where is_effect = 1 and is_delete = 0 and is_department = 0 and pid > 0 ");
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
		$this->display ();
	}

    public function getUserList() {	
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
		$condition =" 1=1 ";
		$condition .= " and u.is_effect = 1 and u.is_delete = 0 and u.user_type in (0,1) ";

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

		$admin_cate = $GLOBALS['db']->getAll("select id,adm_name,real_name from ".DB_PREFIX."admin where is_effect = 1 and is_delete = 0 and is_department = 0 and pid > 0 ");
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
		return;
	}
	
	public function edit() {
		$id = intval($_REQUEST ['id']);
		
		require_once APP_ROOT_PATH."app/Lib/common.php";
		$user_info = get_user_info( "*","id=".$id);
		$this->assign ( 'user_info', $user_info );
		
		//管理员列表
		$adm_sql =  " SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 0 and pid > 0 ";
		$adm_list = $GLOBALS['db']->getAll($adm_sql);
		foreach ($adm_list as $k=>$v) {
			if ($v['real_name'] != "") { 
				$adm_list[$k]['show_name'] = $v['adm_name'].' 【'.$v['real_name'].'】'; 
			} else {
				$adm_list[$k]['show_name'] = $v['adm_name'];
			}
		}
		$this->assign ( 'admins', $adm_list );
		
		$this->display ();
	}
	
	public function update() {
		//系统安全选项检测
		$this->check_safe_item();

		$id = intval($_REQUEST ['id']);
		$admin_id = intval($_REQUEST ['admin_id']);
		$user_name = $_REQUEST ['user_name'];
		$user_info = array();
		$user_info['admin_id'] = $admin_id;

		if ($user_name != "") {
			$refer = $GLOBALS['db']->getRow("SELECT id FROM ".DB_PREFIX."user WHERE user_name='".$user_name."'");
			if ($refer) {
				$user_info['pid'] = $refer['id'];
			}
		} else {
			$user_info['pid'] = 0;
		}

		$list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

		if (false !== $list) {
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}
	
	public function updates() { //更新标所属的客服/管理员
		//系统安全选项检测
		$this->check_safe_item();

		$id = intval($_REQUEST ['id']);
		$admin_id = intval($_REQUEST ['admin_id']);
		$customers_id = intval($_REQUEST ['customers_id']);
	
		$deal_info = array();
		if($admin_id) {
            $deal_info['admin_id'] = $admin_id;
        }
		if($customers_id) {
            $deal_info['customers_id'] = $customers_id;
        }
		
		$list = $GLOBALS['db']->autoExecute(DB_PREFIX."deal",$deal_info,"UPDATE","id=".$id);
	
		if (false !== $list) {
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
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

	public function user_black() {		
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm']) && trim($_REQUEST ['is_black']) == 1) {
			//系统安全选项检测
			$this->check_safe_item();

            $user_info['is_black'] = 1;
            $list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

            $log_info = "用户编号".$id."添加黑名单";
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
            $this->assign ( 'vo', $vo );
            $this->display();
        }
    }

	public function user_ineffect() {		
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm']) && trim($_REQUEST ['ineffect']) == 1) {
			//系统安全选项检测
			$this->check_safe_item();

            $user_info['is_effect'] = 0;
            $list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

            $log_info = "用户编号".$id."设置无效操作";
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
            $this->assign ( 'vo', $vo );
            $this->display();
        }
    }

    public function user_edit() {		
		$id = intval($_REQUEST ['id']);
		
		$vo = get_user_info("*","is_delete=0 and id=".$id);
		if($vo['email'] ==  get_site_email($vo['id'])){
			$vo['email']="";
		}
		$this->assign ( 'vo', $vo );

		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
			
		$field_list = M("UserField")->order("sort desc")->findAll();
		foreach($field_list as $k=>$v) {
			$field_list[$k]['value_scope'] = preg_split("/[ ,]/i",$v['value_scope']);
			$field_list[$k]['value'] = M("UserExtend")->where("user_id=".$id." and field_id=".$v['id'])->getField("value");
		}
		$this->assign("field_list",$field_list);
		
		$rs = M("UserAuth")->where("user_id=".$id." and rel_id = 0")->findAll();
		foreach($rs as $row) {
			$auth_list[$row['m_name']][$row['a_name']] = 1;
		}
		
		//地区列表
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		foreach($region_lv2 as $k=>$v) {
			if($v['id'] == intval($vo['province_id'])) {
				$region_lv2[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv2",$region_lv2);
		
		$region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['province_id']));  //三级地址
		foreach($region_lv3 as $k=>$v) {
			if($v['id'] == intval($vo['city_id'])) {
				$region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv3",$region_lv3);
		
		$n_region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['n_province_id']));  //三级地址
		foreach($n_region_lv3 as $k=>$v) {
			if($v['id'] == intval($vo['n_city_id'])) {
				$n_region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("n_region_lv3",$n_region_lv3);
		
		$this->assign("auth_list",$auth_list);
		$this->display ();
	}

	public function user_edit_update() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$data = M('User')->create ();

		$log_info = "用户编号".$id."内容修改";
		//开始验证有效性
		if(!check_empty($data['user_pwd'])&&$data['user_pwd']!=$_REQUEST['user_confirm_pwd']) {
			$this->error(L("USER_PWD_CONFIRM_ERROR"));
		}

        require_once(APP_ROOT_PATH."system/libs/user.php");
		$res = save_user($_REQUEST,'UPDATE');
		
        if (false !== $res['status']) {
            //成功提示
            save_log($log_info.L("INSERT_SUCCESS"),1);
            $this->success(L("INSERT_SUCCESS"));
        } else {
            //错误提示
            save_log($log_info.L("INSERT_FAILED"),0);
            $this->error(L("INSERT_FAILED"));
        }
	}

	public function user_referer() {
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm'])) {
			//系统安全选项检测
			$this->check_safe_item();

            if (trim($_REQUEST ['user_referer']) != "") {
                $pid = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name='".trim($_REQUEST ['user_referer'])."'");
                if (!$pid) {
                    $this->error("无效的推荐人ID");
                }
            } else {
                $pid = 0;
            }

            $user_info['pid'] = $pid;
            $list = $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info,"UPDATE","id=".$id);

            $log_info = "用户编号".$id."维护推荐人";
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
            $vo['user_referer'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$vo['pid']);
            $this->assign ( 'vo', $vo );
            $this->display();
        }
    }

	public function user_admin() {		
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
            $adm_list = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 0 and pid > 0");
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

	//分配授权中心
	public function user_authority() {		
		$id = intval($_REQUEST ['id']);
        if (isset($_REQUEST ['confirm'])) {
			//系统安全选项检测
			$this->check_safe_item();

			if (trim($_REQUEST ['authority_id']) != "") {
                $authority_id = intval($_REQUEST ['authority_id']);
            } else {
                $authority_id = 0;
            }

            $user_info['authority_id'] = $authority_id;
            $list = $GLOBALS['db']->query("update ".DB_PREFIX."user set authority_id=".$authority_id." where id=".$id);

            $log_info = "用户编号 ".$id." 分配授权中心";
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
            $vo['user_referer'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$vo['pid']);
            $this->assign ( 'vo', $vo );

			//授权中心
			$authority_list = $GLOBALS['db']->getAll(" SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 1 and is_authority=1 ");
            $this->assign ( 'authorities', $authority_list );

            $this->display();
        }
    }
}
?>