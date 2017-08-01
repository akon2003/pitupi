<?php

/**
 * 市场运营/客服
 */

class ExtAdminCustomerAction extends UserAction{
	public function getActionName() {
		return 'User';
	}

	public function index() {
		$this->assign("main_title","我的会员");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.admin_id'] = $adm_session['adm_id'];
		$this->getUserList(0,0,$map);
		$this->display ();
	}

	//VIP会员
	public function vip() {
		$this->assign("main_title","VIP会员");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.admin_id'] = $adm_session['adm_id'];
		$map[DB_PREFIX.'user.vip_id'] = array("gt", 0);
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}

	//密码锁定
	public function lock() {	
		$this->assign("main_title","密码错误");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.admin_id'] = $adm_session['adm_id'];
		$map[DB_PREFIX.'user.sohu_id'] = array("gt", 2);
		$this->getUserList(0,0,$map);
		$this->display ();
	}

	// 会员维护记录列表
	public function visit_log() {
		$this->assign("main_title", "维护日志");		
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$extwhere = " and u.admin_id=".$adm_session['adm_id'];
		$this->get_visit_log($extwhere);
		$this->display ();
	}

	//所有充值
	public function payment() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("main_title", "所有充值");
		$payment_list = M("Payment")->where("is_effect = 1 and class_name<>'Otherpay'")->field("id,name")->findAll();
		$this->assign("payment_list",$payment_list);

		if(isset($_REQUEST['payment_id']) && intval($_REQUEST['payment_id']) > 0){
			$map['payment_id'] = array("eq",intval($_REQUEST['payment_id']));
		} else {
			foreach ($payment_list as $key=>$value) {
				$payment_id[$key] = $value['id'];
			}
			$map['payment_id'] = array("in", $payment_id);
		}

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and admin_id=".$adm_session['adm_id'])->field("id")->findAll();
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
		$map['input_user_id'] = $adm_session['adm_id'];
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

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and admin_id=".$adm_session['adm_id'])->field("id")->findAll();
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

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and admin_id=".$adm_session['adm_id'])->field("id")->findAll();
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

		$user_id = M("User")->where("is_effect = 1 and is_delete=0 and admin_id=".$adm_session['adm_id'])->field("id")->findAll();
		if ($user_id && count($user_id)) {
			foreach ($user_id as $k=>$v) { $user_id[$k] = $v['id']; }
			$extwhere = " and dlr.user_id in (".implode(',',$user_id).") ";
		} else {
			$extwhere = " and dlr.user_id=0 ";
		}
		
    	$this->get_repay_list($extwhere);
		$this->display();
    }

	//手机验证码查询
	public function verify_sms() {
		$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."mobile_verify_code where create_time >".(TIME_UTC-30*60)." order by id desc");
		$this->assign("list",$list);
		$this->assign("main_title","短信验证码(注册时间半小时内)");
		$this->display();
	}

	//导出会员记录
	public function export_csv($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		
		//定义条件
		$map[DB_PREFIX.'user.is_delete'] = 0;
		$map[DB_PREFIX.'user.admin_id'] = $adm_session['adm_id'];
		
		if(trim($_REQUEST['user_name'])!='') {
			if(!isset($_REQUEST['is_user'])) {
				$is_user = 1;
			} else {
				$is_user = intval($_REQUEST['is_user']);
			}

			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			if ($is_user == 1) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $user) {
						$user_ids[] = $user['id'];
					}
				}
				$map[DB_PREFIX.'user.id'] = array('in',$user_ids);
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
				$map[DB_PREFIX.'user.pid'] = array('in',$users);
			} else if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == "mycustomer") {
				$adm_session = es_session::get(md5(conf("AUTH_KEY")));
				$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_session['adm_id']);
			} else {
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
				$map[DB_PREFIX.'user.admin_id'] = array('in',$adm_users);
			}
		}

		if(trim($_REQUEST['email'])!='')
		{
			if(intval($_REQUEST['is_mohu'])==0)
				$map['_string'] = " AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."')  = '".trim($_REQUEST['email'])."'";
			else
				$map['_string'] = " AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') like '%".trim($_REQUEST['email'])."%'";
		}
		if(trim($_REQUEST['mobile'])!='')
		{
			if(intval($_REQUEST['is_mohu'])==0)
				$map['_string'] = " AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."')  = '".trim($_REQUEST['mobile'])."'";
			else
				$map['_string'] = " AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".trim($_REQUEST['mobile'])."%'";
		}
		
		if(trim($_REQUEST['pid_name'])!='')
		{
			$pid = M("User")->where("user_name='".trim($_REQUEST['pid_name'])."'")->getField("id");
			$map[DB_PREFIX.'user.pid'] = $pid;
		}
		
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time']);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$map[DB_PREFIX.'user.create_time'] = array('egt',$begin_time);
			}
			else
				$map[DB_PREFIX.'user.create_time']= array("between",array($begin_time,$end_time));
		}
		
		if (isset($_REQUEST['user_type'])) {
			if ($_REQUEST['user_type'] == -1) {
				$map[DB_PREFIX.'user.user_type'] = array("in",array(0,1));
			} else if ($_REQUEST['user_type'] == 1) {
				$map[DB_PREFIX.'user.user_type'] = array("eq",1);
			} else {
				$map[DB_PREFIX.'user.user_type'] = array("eq",0);
			}
		} else {
			$map[DB_PREFIX.'user.user_type'] = array("eq",0);
		}

		$list = M(MODULE_NAME)
				->where($map)
				->join(DB_PREFIX.'user_level ON '.DB_PREFIX.'user.level_id = '.DB_PREFIX.'user_level.id')
				->field(DB_PREFIX.'user.*,AES_DECRYPT('.DB_PREFIX.'user.real_name_encrypt,\''.AES_DECRYPT_KEY.'\') as real_name,AES_DECRYPT('.DB_PREFIX.'user.email_encrypt,\''.AES_DECRYPT_KEY.'\') as email,AES_DECRYPT('.DB_PREFIX.'user.idno_encrypt,\''.AES_DECRYPT_KEY.'\') as idno,AES_DECRYPT('.DB_PREFIX.'user.money_encrypt,\''.AES_DECRYPT_KEY.'\') as money,AES_DECRYPT('.DB_PREFIX.'user.mobile_encrypt,\''.AES_DECRYPT_KEY.'\') as mobile,'.DB_PREFIX.'user_level.name')
				->limit($limit)->findAll();

		if($list) {
			foreach($list as $k=>$v){
				if($v['email'] ==  get_site_email($v['id'])){
					$list[$k]['email']="";
				}
				$list[$k]['total_money']=$v['money']+$v['lock_money'];
				$list[$k]['loan_money']=$GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_load where user_id=".$v['id']);
			}
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$user_value = array('id'=>'""','user_name'=>'""','user_type'=>'""','real_name'=>'""','sex'=>'""','idno'=>'""','mobile'=>'""','idcardpassed'=>'""', 'refer_user_name'=>'""','admin_user_name'=>'""','total_money'=>'""','money'=>'""','lock_money'=>'""','loan_money'=>'""','qq_id'=>'""','score'=>'""','create_time'=>'""','channel'=>'""');
			if($page == 1)
	    	$content = iconv("utf-8","gbk","编号,用户ID,用户类型,姓名,性别,身份证号码,手机,实名认证,推荐人,专属客服,账户总余额,账户余额,冻结金额,累计投资金额,QQ号码,积分余额,注册时间,渠道名称");

	    	//开始获取扩展字段
	    	$extend_fields = M("UserField")->order("sort desc")->findAll();
	    	foreach($extend_fields as $k=>$v) {
	    		$user_value[$v['field_name']] = '""';
	    		if($page==1)
	    		$content = $content.",".iconv('utf-8','gbk',$v['field_show_name']);
	    	}   
	    	if($page==1) 	
	    	$content = $content . "\n";
	    	
	    	foreach($list as $k=>$v) {	
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['user_type'] = iconv('utf-8','gbk','"' . ($v['user_type']==0?'个人客户':'企业客户') . '"');
				$user_value['real_name'] = iconv('utf-8','gbk','"' . get_user_real_name($v['id']) . '"');
				$user_value['sex'] = iconv('utf-8','gbk','"' . ($v['sex']==0?'女':($v['sex']==1?'男':'')) . '"');
				$user_value['idno'] = iconv('utf-8','gbk','"' . ($v['idno']==""?"":"\'".$v['idno']) . '"');
				$user_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$user_value['idcardpassed'] = iconv('utf-8','gbk','"' . ($v['idcardpassed']==0?'':'已认证') . '"');
				$user_value['refer_user_name'] = iconv('utf-8','gbk','"' . get_refer_user_name($v['id']) . '"');
				$user_value['admin_user_name'] = iconv('utf-8','gbk','"' . get_service_user_name($v['id']) . '"');
				$user_value['total_money'] = iconv('utf-8','gbk','"' . number_format($v['total_money'],2) . '"');
				$user_value['money'] = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
				$user_value['lock_money'] = iconv('utf-8','gbk','"' . number_format($v['lock_money'],2) . '"');
				$user_value['loan_money'] = iconv('utf-8','gbk','"' . number_format($v['loan_money'],2) . '"');
				$user_value['qq_id'] = iconv('utf-8','gbk','"' . $v['qq_id'] . '"');
				$user_value['score'] = iconv('utf-8','gbk','"' . $v['score'] . '"');
				$user_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				$user_value['channel'] = iconv('utf-8','gbk','"' . "" . '"');

				//取出扩展字段的值
				$extend_fieldsval = M("UserExtend")->where("user_id=".$v['id'])->findAll();
				foreach($extend_fields as $kk=>$vv) {
					foreach($extend_fieldsval as $kkk=>$vvv) {
						if($vv['id']==$vvv['field_id']) {
							$user_value[$vv['field_name']] = iconv('utf-8','gbk','"'.$vvv['value'].'"');
							break;
						}
					}
				}
			
				$content .= implode(",", $user_value) . "\n";
			}	
			
			header("Content-Disposition: attachment; filename=user_list.csv");
	    	echo $content;  
		} else {
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}
		
	//获取充值记录
	protected function get_payment_list($map=array()) {
		$condition = array();

		if(trim($_REQUEST['user_name'])!='') {
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt", $start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}

		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$condition = array_merge($condition, $map);

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
	}

	//获取提现记录
	protected function get_carry_list($map=array()){
		$condition = array();

		if(trim($_REQUEST['user_name'])!='') {
			//支持模糊搜索
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			// 获取时区
			$timezone = intval(app_conf('TIME_ZONE'));

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt", $start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt", $end_time);
			}
		}

		$condition = array_merge($condition, $map);
		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("UserCarry");
		if (! empty ( $model )) {
			$this->_list ( $model, $map);
		}
	}

	//获取投标记录
    protected function get_loads_list($extwhere){
		//借款名称
		$deal_list = M("Deal")->where(' 1=1 and '.DB_PREFIX.'deal.deal_status=4 or '.DB_PREFIX.'deal.deal_status=5 order by id desc')->field('id,name')->findAll();
		$this->assign("deal_list",$deal_list);
		
		$condition = " 1=1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0) {
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
			case "rate":
			case "repay_time":
			case "loantype":
				$order ="d.".$sorder;
				break;
			case "user_name":
			case "real_name":
			case "pid":
			case "admin_id":
				$order ="u.".$sorder;
				break;
			default : 
				$order = "dl.".$sorder;
				break;
		}
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "desc";
		}
		
		if(trim($_REQUEST['user_name'])!='') {
			if(!isset($_REQUEST['is_user'])) {
				$is_user = 1;
			} else {
				$is_user = intval($_REQUEST['is_user']);
			}

			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			if ($is_user == 1) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $user) {
						$user_ids[] = $user['id'];
					}
				}
				$condition .= " and u.id in (".implode(",",$user_ids).")";
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
				$condition .= " and u.pid in (".implode(",",$users).")";
			} else {
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
				$condition .= " and u.admin_id in (".implode(",",$adm_users).")";
			}
		}

		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.create_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dl.create_time <= $end_time ";	
			} else {
				$condition .= " and dl.create_time between $begin_time and $end_time ";	
			}
		}
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u on dl.user_id=u.id where $condition $extwhere ORDER BY dl.id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition $extwhere ORDER BY ".$order." ".$sort." limit  ".$p->firstRow . ',' . $p->listRows);
			$this->assign("list",$list);
		}
		$page = $p->show();
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		$this->assign ( "page", $page );
	}

	//获取收款信息
    protected function get_repay_list($extwhere){
		//借款名称
		$deal_list = M("Deal")->where(' 1=1 and '.DB_PREFIX.'deal.deal_status=4 or '.DB_PREFIX.'deal.deal_status=5 order by id desc')->field('id,name')->findAll();
		$this->assign("deal_list",$deal_list);
		
		$condition = " 1=1 and dlr.has_repay<>1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0) {
			$condition .= " and dlr.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "repay_time";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
			case "rate":
			case "loantype":
				$order ="d.".$sorder;
				break;
			case "user_name":
			case "real_name":
			case "pid":
			case "admin_id":
				$order ="u.".$sorder;
				break;
			default : 
				$order = "dlr.".$sorder;
				break;
		}
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "asc";
		}
		
		if(trim($_REQUEST['user_name'])!='') {
			if(!isset($_REQUEST['is_user'])) {
				$is_user = 1;
			} else {
				$is_user = intval($_REQUEST['is_user']);
			}

			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			if ($is_user == 1) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $user) {
						$user_ids[] = $user['id'];
					}
				}
				$condition .= " and u.id in (".implode(",",$user_ids).")";
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
				$condition .= " and u.pid in (".implode(",",$users).")";
			} else {
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
				$condition .= " and u.admin_id in (".implode(",",$adm_users).")";
			}
		}

		$begin_time  = trim($_REQUEST['begin_time'])==''? 0 : to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''? (TIME_UTC+30*24*3600) : to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dlr.repay_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dlr.repay_time <= $end_time ";	
			} else {
				$condition .= " and dlr.repay_time between $begin_time and $end_time ";	
			}
		}
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load_repay dlr LEFT JOIN ".DB_PREFIX."deal d ON d.id =dlr.deal_id LEFT JOIN ".DB_PREFIX."user u on dlr.user_id=u.id where $condition $extwhere");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT dlr.*,d.name as deal_name,d.repay_time as deal_repay_time,d.repay_time_type as deal_repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.admin_id, AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as account_money FROM ".DB_PREFIX."deal_load_repay dlr LEFT JOIN ".DB_PREFIX."deal d ON d.id =dlr.deal_id LEFT JOIN ".DB_PREFIX."user u ON dlr.user_id=u.id where $condition $extwhere ORDER BY ".$order." ".$sort." limit ".$p->firstRow.','.$p->listRows);

			foreach ($list as $k=>&$v) {
				$v['l_key_index'] = '第 '.($v['l_key']+1).' 期';
				$v['l_key_total'] = $v['deal_repay_time_type']==0? '共 1 期' : '共 '.$v['deal_repay_time'].' 期';
				$v['load_money'] = $GLOBALS['db']->getOne("SELECT money FROM ".DB_PREFIX."deal_load where user_id=".$v['user_id']);
				$v['self_money'] = $v['self_money']>0? '￥'.number_format($v['self_money'], 2) : '';
				$v['interest_money'] = $v['interest_money']>0? '￥'.number_format($v['interest_money'], 2) : '';
			}

			$this->assign("list",$list);
		}

		$page = $p->show();
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		$this->assign ( "page", $page );
	}

	//获取维护日志
	protected function get_visit_log($extwhere){
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_name":
			case "real_name":
			case "mobile":
			case "admin_id":
			case "pid":
					$order ="u.".$sorder;
				break;
			default : 
				$order ="uvl.".$sorder;
				break;
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

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and uvl.visit_time >= $begin_time ";	
			} else {
				$condition .= " and uvl.visit_time between $begin_time and $end_time ";	
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");

		if(trim($_REQUEST['user_name'])!='') {
			if(!isset($_REQUEST['is_user'])) {
				$is_user = 1;
			} else {
				$is_user = intval($_REQUEST['is_user']);
			}

			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			if ($is_user == 1) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $user) {
						$user_ids[] = $user['id'];
					}
				}
				$condition .= " and u.id in (".implode(',', $user_ids).")";	
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
				$condition .= " and u.pid in (".implode(',', $users).")";
			} else {
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
				$condition .= " and u.admin_id in (".implode(',', $adm_users).")";
			}
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."user_visit_log uvl LEFT JOIN ".DB_PREFIX."user u ON uvl.user_id=u.id WHERE $condition $extwhere";

		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT uvl.*,u.user_name,u.real_name,u.mobile,u.pid,u.admin_id FROM ".DB_PREFIX."user_visit_log uvl LEFT JOIN ".DB_PREFIX."user u ON uvl.user_id=u.id WHERE $condition $extwhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);

			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );		
		$this->assign("list",$list);
	}
}
?>