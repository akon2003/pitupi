<?php

class IndexAction extends AuthAction{
	//首页
    public function index(){
		$this->display();
    }

    //框架头
	public function top() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("adm_session",$adm_session);

		$navs = require_once APP_ROOT_PATH."system/admnav_cfg.php";		
		$config_access_list = $this->get_config_access_list();

        foreach($navs as $k_nav=>$v_menu){
			$auth = false;
			foreach ($config_access_list as $k=>$v) {
				if (preg_match("/^".$k_nav."/", $v)) {
					$auth = true; break; 
				}
			}
			if ($auth == false) { unset($navs[$k_nav]); }
        }

		$this->assign("navs",$navs);
		$this->display();
	}

	//框架左侧
	public function left() {
		$navs = require_once APP_ROOT_PATH."system/admnav_cfg.php";
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = intval($adm_session['adm_id']);
		
		$nav_key = strim($_REQUEST['key']);
		$nav_group = $navs[$nav_key]['groups'];
		$config_access_list = $this->get_config_access_list();

        foreach($nav_group as $k_menu=>&$v_menu){
			if (isset($v_menu['show']) && $v_menu['show'] == false) {
				unset($nav_group[$k_menu]);
			}
			$auth = false;
			foreach ($config_access_list as $k=>$v) {
				if (preg_match("/^".$nav_key.'\|'.$k_menu."\|/", $v)) {
					$auth = true;
				}
			}
			if ($auth == false) { 
				unset($nav_group[$k_menu]); 
			} else {
				$nodes = $v_menu['nodes'];
				foreach ($nodes as $k_node=>$v_node) {
					$auth_node = false;
					foreach ($config_access_list as $k=>$v) {	
						if (preg_match("/^".$nav_key.'\|'.$k_menu.'\|'.$v_node['module'].'\|'.$v_node['action']."$/", $v)) {
							$auth_node = true; break;
						}						
					}
					if ($auth_node == false) { unset($nav_group[$k_menu]['nodes'][$k_node]); }
				}
			}
        }

		$this->assign("menus",$nav_group);
		$this->display();
	}

	//载入框架左侧导航索引
	public function imap() {
		$navs = require_once APP_ROOT_PATH."system/admnav_cfg.php";
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = intval($adm_session['adm_id']);
		
		$nav_key = strim($_REQUEST['key']);
		$nav_group = $navs[$nav_key]['groups'];
		$config_access_list = $this->get_config_access_list();

        foreach($nav_group as $k_menu=>&$v_menu){
			if (isset($v_menu['show']) && $v_menu['show'] == false) {
				unset($nav_group[$k_menu]);
			}

			$auth = false;
			foreach ($config_access_list as $k=>$v) {
				if (preg_match("/^".$nav_key.'\|'.$k_menu."\|/", $v)) {
					$auth = true;
				}
			}
			if ($auth == false) { 
				unset($nav_group[$k_menu]); 
			} else {
				$nodes = $v_menu['nodes'];
				foreach ($nodes as $k_node=>$v_node) {
					$auth_node = false;
					foreach ($config_access_list as $k=>$v) {	
						if (preg_match("/^".$nav_key.'\|'.$k_menu.'\|'.$v_node['module'].'\|'.$v_node['action']."$/", $v)) {
							$auth_node = true; break;
						}						
					}
					if ($auth_node == false) { unset($nav_group[$k_menu]['nodes'][$k_node]); }
				}
			}
        }

		$this->assign("menus",$nav_group);
		$this->display();
	}

	//默认框架主区域
	public function main() {
		$navs = require_once APP_ROOT_PATH."system/admnav_cfg.php";		      
		$this->assign("navs",$navs);
		
		//会员统计
        //总用户数
		//$total_user = M("User")->where(" user_type in (0,1) and is_delete=0 ")->count();
		$total_user = $GLOBALS["db"]->getOne("select count(*) from ".DB_PREFIX."user where user_type in (0,1) and is_delete=0");
		//实际投资人数
        $total_load_user = $GLOBALS["db"]->getOne("select count(distinct user_id) from ".DB_PREFIX."deal_load");
		//今日新增会员
        $new_user_today = M("User")->where("user_type in (0,1) and create_time>".strtotime(date('Y-m-d',TIME_UTC)))->count();
		//本周新增会员
        $new_user_this_week = M("User")->where("user_type in (0,1) and create_time>".strtotime(date('Y-m-d',(TIME_UTC-(date('w')+1)*24*3600))))->count();
		//本周活跃会员
        $active_user_this_week = M("User")->where("user_type in (0,1) and login_time>".strtotime(date('Y-m-d',(TIME_UTC-(date('w')+1)*24*3600))))->count();
		//有效会员
        $total_verify_user = M("User")->where("is_effect=1 AND user_type in (0,1) ")->count();
		//通过实名认证会员
        $total_idcardpassed_user = M("User")->where("is_effect=1 AND idcardpassed=1 AND user_type in (0,1) ")->count();
        //密码错误超过2次
        $error_password_input = M("User")->where("is_effect=1 AND sohu_id>2 AND user_type in (0,1) ")->count();
        //密码锁定
        $password_lock = M("User")->where("is_effect=1 AND sohu_id>4 AND user_type in (0,1) ")->count();

		$this->assign("total_user",$total_user);
		$this->assign("total_load_user",$total_load_user);
		$this->assign("new_user_today",$new_user_today);
		$this->assign("new_user_this_week",$new_user_this_week);
		$this->assign("active_user_this_week",$active_user_this_week);
		$this->assign("total_verify_user",$total_verify_user);
		$this->assign("total_idcardpassed_user",$total_idcardpassed_user);
		$this->assign("error_password_input",$error_password_input);
		$this->assign("password_lock",$password_lock);

        //资金统计
		//今日充值
        $total_inchareg = $GLOBALS["db"]->getOne("select sum(money) from ".DB_PREFIX."payment_notice where is_paid=1 and create_time>".strtotime(date('Y-m-d',TIME_UTC)));
		//今日提现
        $total_carry = $GLOBALS["db"]->getOne("select sum(money) from ".DB_PREFIX."user_carry where status=1 and update_time>".strtotime(date('Y-m-d',TIME_UTC)));
        //累计投资额
        $total_deal_load = $GLOBALS["db"]->getOne("select sum(dl.money) from ".DB_PREFIX."deal_load dl left join ".DB_PREFIX."deal d on d.id=dl.deal_id where d.is_removed<>1");
        //用户总利息收益
		$total_interest_money = $GLOBALS['db']->getOne("SELECT sum(dr.interest_money) FROM ".DB_PREFIX."deal_repay dr left join ".DB_PREFIX."deal d on dr.deal_id=d.id where dr.has_repay=1 and d.is_removed<>1");
		$total_interest_money += $GLOBALS['db']->getOne("SELECT sum(dr.interest_money) FROM ".DB_PREFIX."deal_repay_ext dr left join ".DB_PREFIX."deal d on dr.deal_id=d.id where dr.has_repay=1");

        //已还本息总额
		$true_repay_money = $GLOBALS['db']->getOne("SELECT sum(dr.true_repay_money) FROM ".DB_PREFIX."deal_repay dr left join ".DB_PREFIX."deal d on dr.deal_id=d.id where dr.has_repay=1 and d.is_removed<>1");
        //待还利息
		$wait_interest_money = $GLOBALS['db']->getOne("SELECT sum(dr.interest_money) FROM ".DB_PREFIX."deal_repay dr left join ".DB_PREFIX."deal d on dr.deal_id=d.id where dr.has_repay=0 and d.is_removed<>1");
        //待还本金
		$wait_self_money = $GLOBALS['db']->getOne("SELECT sum(dr.self_money) FROM ".DB_PREFIX."deal_repay dr left join ".DB_PREFIX."deal d on dr.deal_id=d.id where dr.has_repay=0 and d.is_removed<>1");
        //用户账户总余额
		$user_total_money = $GLOBALS['db']->getOne("SELECT sum(lock_money+AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."')) FROM ".DB_PREFIX."user");

        $this->assign("total_inchareg",$total_inchareg);
		$this->assign("total_carry",$total_carry);
		$this->assign("total_deal_load",$total_deal_load);
		$this->assign("total_interest_money",$total_interest_money);
		$this->assign("true_repay_money",$true_repay_money);
		$this->assign("wait_interest_money",$wait_interest_money);
		$this->assign("wait_self_money",$wait_self_money);
		$this->assign("user_total_money",$user_total_money);

        
        //待办事项
        //借款待初审
		$publis_wait_first = M("Deal")->where("is_effect=1 AND publish_wait in (1,3) AND is_delete = 0")->count();
        //借款待复审
		$publis_wait_second = M("Deal")->where("is_effect=1 AND publish_wait in (2,5) AND is_delete = 0")->count();
        //借款待三审
		$publis_wait_third = M("Deal")->where("is_effect=1 AND publish_wait in (4) AND is_delete = 0")->count();
        //借款待发布
		$publis_wait_four = M("Deal")->where("is_effect=1 AND publish_wait in (6) AND is_delete = 0")->count();
		//满标待审
		$suc_deal_count = M("Deal")->where("is_effect=1 AND publish_wait = 0 AND is_delete = 0 AND deal_status = 2")->count();

		$this->assign("publis_wait_first",$publis_wait_first);
		$this->assign("publis_wait_second",$publis_wait_second);
		$this->assign("publis_wait_third",$publis_wait_third);
		$this->assign("publis_wait_four",$publis_wait_four);
		$this->assign("suc_deal_count",$suc_deal_count);

		
		//等待材料的借款
		$info_deal_count = M("Deal")->where("is_effect=1 AND publish_wait = 0 AND is_delete = 0 AND deal_status=0")->count();
		//等待审核的申请额度
		$quota_count = M("QuotaSubmit")->where("status=0")->count();
		//等待审核的授信额度
		$deal_quota_count = M("DealQuotaSubmit")->where("status=0")->count();
		
		//未处理举报
		$reportguy_count = M("Reportguy")->where("status = 0")->count();
		//注册待审核
		$register_count = M("User")->where("login_time = 0 and login_ip='' and is_effect=0 and is_delete=0 and user_type=0 and is_black=0")->count();
		$company_register_count = M("User")->where("login_time = 0 and login_ip='' and is_effect=0 and is_delete=0 and user_type=1 and is_black=0")->count();

		$this->assign("register_count",$register_count);
		$this->assign("company_register_count",$company_register_count);
		
		//未处理续约申请
		$generation_repay_submit = M("GenerationRepaySubmit")->where("status = 0")->count();
		$this->assign("info_deal_count",$info_deal_count);
		$this->assign("deal_quota_count",$deal_quota_count);
		$this->assign("quota_count",$quota_count);
		$this->assign("reportguy_count",$reportguy_count);
		$this->assign("generation_repay_submit",$generation_repay_submit);
		
		$topic_count = M("Topic")->where("is_effect = 1 and fav_id = 0")->count();		
		$msg_count = M("Message")->where("is_buy = 0")->count();
		$buy_msg_count = M("Message")->count();
		
		$this->assign("topic_count",$topic_count);
		$this->assign("msg_count",$msg_count);
		$this->assign("buy_msg_count",$buy_msg_count);
		
		//提现申请
		$carry_count = D("UserCarry")->where("status = 0")->count();
		//提现待查询
		$carry_waitquery = D("UserCarry")->where("status in (3,5)")->count();

		$this->assign("carry_count",$carry_count);
		$this->assign("carry_waitquery",$carry_waitquery);
		
		//还款中
		$repay_inrepay = M("Deal")->where("is_effect=1 AND is_delete = 0 AND deal_status=4")->count();
		//已还清
		$repay_over = M("Deal")->where("is_effect=1 AND is_delete = 0 AND deal_status=5")->count();
		//三日要还款的借款
		$threeday_repay_count = M("DealRepay")->where("((repay_time - ".TIME_UTC." +  24*3600 -1)/24/3600 between 0 AND 3) and has_repay=0 ")->count();
		//逾期未还款的
		$yq_repay_count = M("DealRepay")->where(" (".TIME_UTC." - repay_time  -  24*3600 +1 )/24/3600 > 0 and has_repay=0 ")->count();
		$this->assign("repay_inrepay",$repay_inrepay);
		$this->assign("repay_over",$repay_over);
		$this->assign("threeday_repay_count",$threeday_repay_count);
		$this->assign("yq_repay_count",$yq_repay_count);

		//充值单数
		$incharge_order_buy_count = M("PaymentNotice")->where("is_paid=1")->count();
		$this->assign("incharge_order_buy_count",$incharge_order_buy_count);
		
		
		$reminder = M("RemindCount")->find();
		$reminder['topic_count'] = intval(M("Topic")->where("is_effect = 1 and relay_id = 0 and fav_id = 0 and create_time >".$reminder['topic_count_time'])->count());
		$reminder['msg_count'] = intval(M("Message")->where("create_time >".$reminder['msg_count_time'])->count());
		/*$reminder['buy_msg_count'] = intval(M("Message")->where("create_time >".$reminder['buy_msg_count_time'])->count());
		$reminder['order_count'] = intval(M("DealOrder")->where("is_delete = 0 and type = 0 and pay_status = 2 and create_time >".$reminder['order_count_time'])->count());
		$reminder['refund_count'] = intval(M("DealOrder")->where("is_delete = 0 and refund_status = 1 and create_time >".$reminder['refund_count_time'])->count());
		$reminder['retake_count'] = intval(M("DealOrder")->where("is_delete = 0 and retake_status = 1 and create_time >".$reminder['retake_count_time'])->count());*/
		$reminder['incharge_count'] = intval(M("PaymentNotice")->where("is_paid = 1 and pay_date=".to_date(TIME_UTC,"Y-m-d")." ")->count());
		
		M("RemindCount")->save($reminder);
		$this->assign("reminder",$reminder);
		
		//待审核认证资料
		$auth_count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user_credit_file where status = 0 ");
		$this->assign("auth_count",$auth_count);
		
		//待补还项目
		$after_repay_count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal as d where publish_wait=0 and is_delete =0 AND deal_status in(4,5) AND (repay_money > round((SELECT sum(repay_money) FROM ".DB_PREFIX."deal_load_repay WHERE has_repay=1 and deal_id = d.id),2) + 1 or (repay_money >0  and (SELECT count(*) FROM ".DB_PREFIX."deal_load_repay WHERE has_repay =1 and deal_id = d.id) = 0))");
		$this->assign("after_repay_count",$after_repay_count);
		$this->display();
	}	
	
	public function map(){
		$navs = require_once APP_ROOT_PATH."system/admnav_cfg.php";		
		
		//暂时关闭非管理员的显示
		//XHF 2016/9/5
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = intval($adm_session['adm_id']);
		if ($adm_id == 47 || $adm_id == 48 || $adm_id == 51 || $adm_id == 62 || $adm_id == 64 || $adm_id == 1) {
			$this->assign("navs",$navs);
		} else {
			$this->assign("navs",array());		
		}
		
		$this->display();
	}
	
	//底部
	public function footer() {
		$this->display();
	}

	//修改管理员密码
	public function information() {
		$this->assign("main_title", "个人信息");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_data = $GLOBALS['db']->getRow("select id,adm_name,real_name,mobile,pid,role_id,authority_id,login_time,login_ip from ".DB_PREFIX."admin where id=".$adm_session['adm_id']);

		//角色名称
		$adm_data['role_name'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."role where id=".$adm_data['role_id']);
		//所属部门
		$adm_data['department_name'] = $GLOBALS['db']->getOne("select adm_name from ".DB_PREFIX."admin where id=".$adm_data['pid']);
		//授权中心
		$adm_data['authority_name'] = $GLOBALS['db']->getOne("select adm_name from ".DB_PREFIX."admin where id=".$adm_data['authority_id']);

		$operate_authority = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."operate where adm_id=".$adm_data['id']);

		if ($operate_authority) {
			$adm_data['operate_authority'] = '权限已分配';
			if ($operate_authority['password'] == '') {
				$adm_data['operate_authority'] = ' | 密码未设置';
			}
		} else {
			$adm_data['operate_authority'] = '';
		}

		$this->assign("adm_data",$adm_data);
		$this->display();
	}
	
	//修改管理员密码
	public function change_password() {
		$this->assign("main_title", "修改登录密码");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("adm_data",$adm_session);
		$this->display();
	}

	public function do_change_password() {
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];
		if(!check_empty($_REQUEST['adm_password'])) {
			$this->error(L("ADM_PASSWORD_EMPTY_TIP"));
		}
		if(!check_empty($_REQUEST['adm_new_password'])) {
			$this->error(L("ADM_NEW_PASSWORD_EMPTY_TIP"));
		}
		if($_REQUEST['adm_password']==$_REQUEST['adm_new_password']) {
			$this->error("新密码不能与原密码相同");
		}
		if($_REQUEST['adm_confirm_password']!=$_REQUEST['adm_new_password']) {
			$this->error(L("ADM_NEW_PASSWORD_NOT_MATCH_TIP"));
		}		
		if(M("Admin")->where("id=".$adm_id)->getField("adm_password")!=md5($_REQUEST['adm_password'])) {
			$this->error(L("ADM_PASSWORD_ERROR"));
		}
		M("Admin")->where("id=".$adm_id)->setField("adm_password",md5($_REQUEST['adm_new_password']));
		save_log(M("Admin")->where("id=".$adm_id)->getField("adm_name").L("CHANGE_SUCCESS"),1);
		$this->success(L("CHANGE_SUCCESS"));
	}
	
	//修改操作密码
	public function change_password_operate() {
		$this->assign("main_title", "修改操作密码");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("adm_data",$adm_session);
		$this->display();
	}

	public function do_change_password_operate() {
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];

		//判断用户是否有操作权限
		$operate_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."operate where adm_id=".$adm_id);
		if (!$operate_id) {
			$this->assign("jumpUrl",u(MODULE_NAME."/information"));
			$this->error("没有操作权限");
		}
		if(!check_empty($_REQUEST['adm_password'])) {
			$this->error("原操作密码不能为空");
		}
		if(!check_empty($_REQUEST['adm_new_password'])) {
			$this->error("新操作密码不能为空");
		}
		if($_REQUEST['adm_password']==$_REQUEST['adm_new_password']) {
			$this->error("新密码不能与原密码相同");
		}
		if($_REQUEST['adm_confirm_password']!=$_REQUEST['adm_new_password']) {
			$this->error("确认操作密码不符");
		}		
		if(M("Operate")->where("adm_id=".$adm_id)->getField("password")!=md5(md5($_REQUEST['adm_password']))) {
			$this->error("原操作密码错误");
		}

		M("Operate")->where("adm_id=".$adm_id)->setField("password",md5(md5($_REQUEST['adm_new_password'])));
		save_log(M("Admin")->where("id=".$adm_id)->getField("adm_name").'操作密码修改成功',1);
		$this->success(L("CHANGE_SUCCESS"));
	}

	//重置操作密码
	public function change_password_reset() {
		$this->assign("main_title", "重置操作密码");
		$adm_data = es_session::get(md5(conf("AUTH_KEY")));
		$adm_data['mobile']= $GLOBALS['db']->getOne("select mobile from ".DB_PREFIX."admin where id=".$adm_data['adm_id']);

		$this->assign("adm_data",$adm_data);
		$this->display();
	}

	public function do_change_password_reset() {
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];

		//判断用户是否有操作权限
		$operate_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."operate where adm_id=".$adm_id);
		if (!$operate_id) {
			$this->assign("jumpUrl",u(MODULE_NAME."/information"));
			$this->error("没有操作权限");
		}

		//判断验证码是否有效
		$verify_code = $_REQUEST['verify_code'];
		if(!check_empty($verify_code)) {
			$this->error("验证码不能为空");
		}
		$operate_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."operate where verify_code='".$verify_code."' and adm_id=".$adm_id);
		if (!$operate_id) {
			$this->error("验证码错误或已失效");
		}

		if(!check_empty($_REQUEST['password'])) {
			$this->error("密码不能为空");
		}

		$data['id'] = $operate_id;
		$data['password'] = md5(md5($_REQUEST['password']));
		$data['verify_code'] = '';
		$data['update_time'] = TIME_UTC;
	
		M("Operate")->save($data);

		save_log(M("Admin")->where("id=".$adm_id)->getField("adm_name").'操作密码重置成功',1);
		$this->success(L("CHANGE_SUCCESS"));
	}

	public function reset_sending() {
		$this->check_has_auth();
		$field = trim($_REQUEST['field']);
		if($field=='DEAL_MSG_LOCK'||$field=='PROMOTE_MSG_LOCK'||$field=='APNS_MSG_LOCK') {
			M("Conf")->where("name='".$field."'")->setField("value",'0');
			$this->success(L("RESET_SUCCESS"),1);
		} else {
			$this->error(L("INVALID_OPERATION"),1);
		}
	}
	
	function manage_carry(){
		$this->check_has_auth();
		$id = intval($_REQUEST['id']);
		$manage_carry_list = $GLOBALS['db']->getAll( "select * from ".DB_PREFIX."admin_carry");
		$this->assign("manage_carry_list",$manage_carry_list);
		$this->display();
	}

	public function de_manage_carry() {
		$this->check_has_auth();
		$id = intval($_REQUEST['id']);
		
		$list = M("AdminCarry")->where('id='.$id)->delete(); // 删除
	
		if(!$list){
			$this->error("删除失败");
		}else{
			$this->success("删除成功");
		}
	}

	public function add_manage_carry() {	
		$this->check_has_auth();
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$this->assign("adm_session",$adm_session);
		$this->display();
	}

	public function insert_carry() {
		$this->check_has_auth();
		$admin_id = intval($_REQUEST['admin_id']);
		$admin_name = $_REQUEST['admin_name'];
		$money = floatval($_REQUEST['money']);
		$memo = $_REQUEST['memo'];
		
		//$creat_time = to_date($_REQUEST['creat_time']);
		$creat_time = TIME_UTC;
		$admin_carry = array();
		$admin_carry['admin_id'] = $admin_id;
		$admin_carry['admin_name'] = $admin_name;
		$admin_carry['money'] = $money;
		$admin_carry['memo'] = $memo;
		$admin_carry['create_time'] = $creat_time;
		 
		M("AdminCarry")->add($admin_carry);
		
		$this->assign("jumpUrl",u(MODULE_NAME."/manage_carry"));
		$this->success(L("INSERT_SUCCESS"));
	}
	
	//统计信息
	function statistics(){
		//总的用户
		$user_count =  M("User")->where("user_type in(0,1)")->count();
		$this->assign("user_count",$user_count);
		//有效的未删除的
		$effect_user = $GLOBALS['db']->getAll("SELECT is_effect,count(*) as total_user FROM ".DB_PREFIX."user where is_delete = 0 and user_type in(0,1) group by is_effect ORDER BY is_effect DESC");
		$this->assign("effect_user",$effect_user);
		//回收站用户
		$trash_user_count = M("User")->where("is_delete=1 and user_type in(0,1)")->count();
		$this->assign("trash_user_count",$trash_user_count);
		
		//认证
		$credit_types = load_auto_cache("credit_type");
		$tcredit_files = $GLOBALS['db']->getAll("SELECT `type`,count(*) as total_user FROM ".DB_PREFIX."user_credit_file where status = 1 and passed=1 group by `type` ");
		$credit_files = array();
		foreach($tcredit_files as $k=>$v){
			$credit_files[$v['type']] = $v['total_user'];
		}
		unset($tcredit_files);
		$credit_types = $credit_types['list'];
		foreach($credit_types as $k=>$v){
			
			if($credit_files[$v['type']] > 0){
				$credit_types[$k]['user_count'] = $credit_files[$v['type']];
			}
			else{
				unset($credit_types[$k]);
			}
		}
		unset($credit_files);
		$this->assign("credit_types",$credit_types);
		
		//线上充值
		$online_pay = floatval($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."payment_notice where is_paid = 1 and payment_id not in (SELECT id from ".DB_PREFIX."payment where class_name='Otherpay') "));
		$this->assign("online_pay",$online_pay);
		//线下充值金额
		$below_pay = floatval($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."payment_notice where is_paid = 1 and payment_id in (SELECT id from ".DB_PREFIX."payment where class_name='Otherpay') "));
		$this->assign("below_pay",$below_pay);
		
		//线下充值ID
		$below_pay_id = $GLOBALS['db']->getOne("SELECT id from ".DB_PREFIX."payment where class_name='Otherpay'");
		$this->assign("below_pay_id",$below_pay_id);
		
		//管理员充值  （user_log管理员编辑账户）
		$manage_recharge = floatval($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."user_money_log where `type`='13'"));
		$this->assign("manage_recharge",$manage_recharge);
		
		//管理员提现
		$manage_carry = floatval($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."admin_carry "));
		$this->assign("manage_carry",$manage_carry);
		
		
		//成功提现
		$carry_amount = M("UserCarry")->where("status=1")->sum("money");
		$this->assign("carry_amount",$carry_amount);
		
		//总计
		$total_usre_money = $online_pay + $below_pay + $manage_recharge - $carry_amount;
		$this->assign("total_usre_money",$total_usre_money);
		
		/**
		 * 成功借出总额 total_borrow_amount
		 * 冻结中的保证金 借款人 freezen_amt
		 * 冻结中的保证金 担保人 grt_freezen_amt
		 * 成功借款投标奖励总额 rebate_amount
		 */
		$total_borrow_amount = $GLOBALS['db']->getOne("SELECT sum(borrow_amount) as total_borrow_amount FROM ".DB_PREFIX."deal where publish_wait = 0 and is_effect = 1 and is_delete = 0 and deal_status >=4 ");
		$this->assign("borrow_amount",$total_borrow_amount);
		
		//已还款总额
		$has_repay_amount = floatval($GLOBALS['db']->getOne("SELECT sum(self_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 1 "));
		$this->assign("has_repay_amount",$has_repay_amount);
		
		//未还总额
		$need_repay_amount = floatval($GLOBALS['db']->getOne("SELECT sum(self_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 0 "));
		$this->assign("need_repay_amount",$need_repay_amount);
		
		//冻结中的保证金 借款人
		$freezen_amt = $GLOBALS['db']->getOne("SELECT (sum(real_freezen_amt)-sum(un_real_freezen_amt) ) as freezen_amt FROM ".DB_PREFIX."deal where publish_wait = 0 and is_effect = 1 and is_delete = 0 and deal_status >=4 AND ips_bill_no<>'' ");
		$this->assign("freezen_amt",$freezen_amt);
		//冻结中的保证金 担保人
		$grt_freezen_amt = $GLOBALS['db']->getOne("SELECT (guarantor_real_freezen_amt - un_guarantor_real_freezen_amt) as grt_freezen_amt FROM ".DB_PREFIX."deal where publish_wait = 0 and is_effect = 1 and is_delete = 0 and deal_status >=4 AND ips_bill_no<>'' ");
		$this->assign("grt_freezen_amt",$grt_freezen_amt);
		
		//成功借款利息总额
		$load_rate_amount = floatval($GLOBALS['db']->getOne("SELECT sum(repay_money - self_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 1 "));
		$this->assign("load_rate_amount",$load_rate_amount);
		
		//成功借款投标奖励总额
		$rebate_amount = $GLOBALS['db']->getOne("SELECT sum(borrow_amount*CONVERT(user_bid_rebate,DECIMAL)*0.01) as rebate_amount FROM ".DB_PREFIX."deal where publish_wait = 0 and is_effect = 1 and is_delete = 0 and deal_status >=4 ");
		$this->assign("rebate_amount",$rebate_amount);
		
		//注册奖励冻结资金
		$register_lock_money = floatval($GLOBALS['db']->getOne("SELECT sum(lock_money) FROM ".DB_PREFIX."user_lock_money_log where `type` = 18 "));
		$this->assign("register_lock_money",$register_lock_money);
		
		//逾期还款总额
		$yq_repay_amount = floatval($GLOBALS['db']->getOne("SELECT sum(repay_manage_impose_money + impose_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 1 and status in(2,3)"));
		$this->assign("yq_repay_amount",$yq_repay_amount);
		//逾期未还款总额
		$yq_norepay_amount = floatval($GLOBALS['db']->getOne("SELECT sum(repay_manage_impose_money + impose_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 0 and status in(2,3)"));
		$this->assign("yq_norepay_amount",$yq_norepay_amount);
		
		//逾期罚息总额
		$yq_all_amount = floatval($GLOBALS['db']->getOne("SELECT sum(impose_money) FROM ".DB_PREFIX."deal_load_repay where status in(2,3)"));
		$this->assign("yq_all_amount",$yq_all_amount);
		
		//借款者成交服务费
		$success_service_fee = $GLOBALS['db']->getOne("SELECT sum(borrow_amount*CONVERT(services_fee,DECIMAL)*0.01)  FROM ".DB_PREFIX."deal where publish_wait = 0 and is_effect = 1 and is_delete = 0 and deal_status >=4 ");
		$this->assign("success_service_fee",$success_service_fee);
		
		//借款者成交管理费
		$success_manage_fee = $GLOBALS['db']->getOne("SELECT sum(manage_money) FROM ".DB_PREFIX."deal_repay where has_repay=1 )");
		$this->assign("success_manage_fee",$success_manage_fee);
		
		//投资者成交管理费
		$load_success_manage_fee = $GLOBALS['db']->getOne("SELECT sum(true_manage_money) FROM ".DB_PREFIX."deal_load_repay where has_repay=1 )");
		$this->assign("load_success_manage_fee",$load_success_manage_fee);
		
		//提现手续费
		$carry_manage_fee = $GLOBALS['db']->getOne("SELECT sum(fee) FROM ".DB_PREFIX."user_carry where status = 1 ");
		$this->assign("carry_manage_fee",$carry_manage_fee);
		
		$peizi = array();
		$peizi["verify_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order where status = 1 ");
		$peizi["raise_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order where status = 2 ");
		$peizi["open_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order where status = 4 ");
		$peizi["raise_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order where status = 2 ");
		
		$peizi["investor_verify_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order_op where op_status = 0 and op_type in (1,2) ");
		$peizi["platform_verify_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order_op where op_status = 0 and op_type in (0,3,4,5) ");
		$peizi["review_verify_num"] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."peizi_order_op where op_status = 1");
		
		$this->assign("peizi",$peizi);
		
		//理财总计
		$licai["verify_count"] = M("Licai")->where('verify in (0,2)')->count();
		$licai["count"] = M("Licai")->where('verify = 1')->count();			
		$licai["order_count"] = M("LicaiOrder")->count();			
		$licai["advance_count"] = M("LicaiAdvance")->count();
		$licai["redempte_count"] = M("LicaiRedempte")->where("type = 1 and status in (0,1,2)")->count();
		$licai["wait_redempte_count"] = M("LicaiRedempte")->where("type = 0 and status in (0,1,2)")->count();
		$licai["near_count"] = $GLOBALS["db"]->getOne("select count(*) from ".DB_PREFIX."licai_order lco
	 left join ".DB_PREFIX."licai lc on lco.licai_id = lc.id where lco.status in (1,2) and lco.end_interest_date >='".to_date(TIME_UTC-15*24*3600,"Y-m-d")."' and lco.end_interest_date <='".to_date(TIME_UTC,"Y-m-d")."'");
		$licai["send_count"] = $GLOBALS["db"]->getOne("select count(*) from ".DB_PREFIX."licai_order lco
	 left join ".DB_PREFIX."licai lc on lco.licai_id = lc.id where lco.status =3");
		
		$this->assign("licai",$licai);		
		$this->display();
	}

	/**
	 * 发送提示信息
	 */
	public function tip() {
	}

	public function send_operate_pwd_verify_code() {		
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		if(app_conf("SMS_ON")==0) {
			$this->error("短信接口未开启",1);	
		}

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];

		$mobile = $_REQUEST['mobile'];
		if (!preg_match("/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/i", $mobile)) {
			$this->error("手机号码格式不正确");
		}

		//手机号码是否正确
		if ($GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."admin where mobile='".$mobile."' and id=".$adm_id) == 0) {
			$this->error("手机号码不正确");
		}

		require_once APP_ROOT_PATH."system/utils/es_sms.php";
		$sms = new sms_sender();

		//测试模板ID=1 YTX
		$code = rand(100000,999999);
		$time = intval(SMS_EXPIRESPAN / 60);
		$content = "您的验证码为{$code}，请于{$time}分钟内正确输入，如非本人操作，请忽略此短信。";
		$result = $sms->sendTemplateSMS($mobile,serialize(array('code'=>$code,'time'=>$time)),'-1',$content);
		//end

		if($result['status']) {
			$this->success(l("SEND_SUCCESS"),1);
			//写入验证码
			$GLOBALS['db']->query("update ".DB_PREFIX."operate set verify_code='".$code."' where adm_id=".$adm_id);
		} else {			
			$this->error(l("ERROR_INFO") . $result['msg'],1);
		}
	}

	protected function write_log($msg='') {
		switch (ACTION_NAME) {
			case 'index':
			case 'imap':
			case 'drag':
			case 'left':
			case 'top':
			case 'footer':
			case 'tip':
				return true; break;
			default:
		}
		parent::write_log($msg);
	}
}
?>