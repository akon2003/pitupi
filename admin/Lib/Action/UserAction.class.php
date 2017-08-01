<?php

class UserAction extends CommonAction{
	public function __construct() {	
		parent::__construct();
		require_once APP_ROOT_PATH."/system/libs/user.php";
	}
	
	public function all() {
		$this->assign("main_title", "全部会员");
		$this->assign("user_type", -1);
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(-1,0,$map);
		$this->display ("index");
	}
	
	public function mycustomer() {
		$this->assign("main_title", "我的会员");
		$this->assign("user_type", -1);
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_session['adm_id']);

		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
			
		}
		$this->getUserList(-1,0,$map);
		$this->display ("index");
	}

	public function index() {
		$this->assign("main_title", "个人客户");
		$this->assign("user_type", 0);
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(0,0,$map);
		$this->display ();
	}
	
	public function company_index() {
		$this->assign("main_title", "企业客户");
		$this->assign("user_type", 1);
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(1,0,$map);
		$this->display ("index");
	}

    public function vip() {
		$this->assign("main_title", "VIP会员");
		$this->assign("user_type", 0);
		$map[DB_PREFIX.'user.is_effect'] = array('eq',1);
		$map[DB_PREFIX.'user.vip_id'] = array('gt',0);
		$this->getUserList(0,0,$map);
		$this->display ("index");
    }

    // XHF 2016-7-14
    // 新增平台数据统计
	// XHF 2016/8/4 加入今日网站收益统计
    public function account_report() {
        $this->assign("main_title", "平台数据汇总");
        $today = strtotime(date('Y-m-d',TIME_UTC));

		//网站收益
		$vo = $GLOBALS['db']->getRow(" SELECT sum(money) as report_money, sum(checkout_fee) as checkout_fee, sum(xiwei_fee) as xiwei_fee, sum(service_fee) as service_fee, sum(loan_fee) as loan_fee FROM ".DB_PREFIX."site_money_report where report_date<>'".$today."'");
        $vo['site_money'] = $vo['report_money'] - $vo['checkout_fee'];
        //提现
        $vo['carry_fee'] = $GLOBALS['db']->getOne("select sum(fee) from ".DB_PREFIX."user_carry where status=1");
        //申购期利息
        $vo['user_money_55'] = (-1)*$GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type=55");
        //投资返现
        $vo['user_money_56'] = (-1)*$GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type=56");

        //余额
        $vo['used_money'] = $GLOBALS['db']->getOne("select sum(AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."')) from ".DB_PREFIX."user where 1=1");
        $vo['lock_money'] = $GLOBALS['db']->getOne("select sum(lock_money) from ".DB_PREFIX."user where 1=1");
        $vo['nmc_money'] = $GLOBALS['db']->getOne("select sum(nmc_money) from ".DB_PREFIX."user where 1=1");
        $vo['account_money'] = $vo['used_money'] + $vo['lock_money'] + $vo['nmc_money'];

        //今日充值
        $vo['payment_pos'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id=47 and is_paid=1 and pay_time>= '".$today."'");
        $vo['payment_online'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id=43 and is_paid=1 and pay_time>= '".$today."'");
        $vo['payment_allinpay'] = $vo['payment_pos'] + $vo['payment_online'];
		//今日收益
        $vo['site_money_today'] = (-1) * $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type in(10,14,52) and create_time_ymd='".date('Y-m-d',TIME_UTC)."'");
		//XHF 2016/8/31 活动返现
        $vo['user_activity_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type in(57)");
		//注册奖励
        //$vo['register_reward'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type in(18)");
		//推荐奖励
        $vo['user_refer_award_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type in(65)");

		//用户申购期收益
        $vo['user_money_54'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_money_log where type=54");
		//b包含注册奖励
		//$diff_money = $vo['site_money'] + $vo['site_money_today'] + $vo['carry_fee'] + $vo['user_money_55'] + $vo['user_money_56'] + $vo['account_money'] - $vo['payment_allinpay'] - $vo['user_money_54'] - $vo['register_reward'];
		$diff_money = $vo['site_money'] + $vo['site_money_today'] + $vo['carry_fee'] + $vo['user_money_55'] + $vo['user_money_56'] + $vo['account_money'] - $vo['payment_allinpay'] - $vo['user_money_54'] - $vo['user_activity_money'] - $vo['user_refer_award_money'];
        $vo['diff_money'] = $diff_money;

        $this->assign("vo", $vo);
        $this->display();
    }

    // 按天统计平台交易
    public function daily_report() {
		$begin_time  = trim($_REQUEST['begin_time'])==''?strtotime(date('Y-m-d',TIME_UTC-30*24*3600)):to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?strtotime(date('Y-m-d',TIME_UTC)):to_timespan($_REQUEST['end_time']);

        $date_range = range($end_time,$begin_time,-24*3600);

        $count = array('payment_money'=>0, 'online_money'=>0, 'pos_money'=>0, 'offline_money'=>0, 'carry_money'=>0);
        $list = array();
        for ($i=0; $i<count($date_range); $i++) {
            $begin_time = $date_range[$i]; $end_time = $date_range[$i] + 24*3600;
            $item['submit_date'] = $begin_time;
            $item['check_date'] = $end_time;
            $item['payment_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."payment_notice where is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_online_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."payment_notice where payment_id=43 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_online_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id=43 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_pos_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."payment_notice where payment_id=47 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_pos_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id=47 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_allinpay'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id in (47,43) and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_offline_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."payment_notice where payment_id=34 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['payment_offline_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."payment_notice where payment_id=34 and is_paid=1 and create_time between $begin_time and $end_time");
            $item['carry_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_carry where status=1 and update_time between $begin_time and $end_time");
            $item['carry_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_carry where status=1 and update_time between $begin_time and $end_time");

            if ($item['payment_money'] == 0 && $item['carry_money'] == 0) { continue; }

            $count['payment_money']     += $item['payment_money'];
            $count['online_money']      += $item['payment_online_money'];
            $count['pos_money']         += $item['payment_pos_money'];
            $count['offline_money']     += $item['payment_offline_money'];
            $count['carry_money']       += $item['carry_money'];

            $list[] = $item;
        }

        $this->assign("count", $count);
        $this->assign("list", $list);
     
        $this->display();
    }

	public function customer_acct_list() {
		$condition = " 1=1";
		$map[DB_PREFIX.'user.user_type'] = array("in", array(0,1));
		$condition .= " and user_type in (0,1)";
		$map[DB_PREFIX.'user.is_delete'] = 0;
		$condition .= " and is_delete=0";
		
		if(trim($_REQUEST['user_name'])!='') {
			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			if ($users && count($users)) {
				foreach ($users as $user) {
					$user_ids[] = $user['id'];
				}
			}

			$map[DB_PREFIX.'user.id'] = array('in',$user_ids);
			$condition .= " and id in (".implode(',',$user_ids).")";
		}

		if(trim($_REQUEST['adm_name'])!='') {
			$q = trim($_REQUEST['adm_name']);
			$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%'")->field("id")->findAll();
			if ($adm_users && count($adm_users)) {
				foreach ($adm_users as $k=>$user) {
					$adm_users[$k] = $user['id'];
				}
			}
			$map[DB_PREFIX.'user.admin_id'] = array("in", $adm_users);
			$condition .= " and admin_id in (".implode(',',$adm_users).")";
		}
		if(trim($_REQUEST['user_name'])=='' && trim($_REQUEST['adm_name'])=='') {
			$condition = str_replace("is_delete=0","is_delete in (0,1)",$condition);
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map ,'' ,false , "*,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile");
		}
		
		$list = $this->get("list");
		foreach($list as $k=>$v){
			if($v['email'] ==  get_site_email($v['id'])){
				$list[$k]['email']="";
			}
		}

		// user account money
		$sum = $GLOBALS['db']->getRow("select sum(AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."')) as total_money,sum(lock_money) as total_lock_money from ".DB_PREFIX."user where ".$condition);
		// today incharge
		$incharge = $GLOBALS['db']->getRow("select sum(money) as incharge from ".DB_PREFIX."payment_notice where is_paid=1 and pay_time > ".strtotime(date('Y-m-d')));
		$sum['total'] = $sum['total_money'] + $sum['total_lock_money'];
		$sum['incharge'] = $incharge['incharge'];

		$this->assign("list",$list);
		$this->assign("sum",$sum);
		$this->display ();
	}

	public function export_csv_customer_acct_list($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));

		if(trim($_REQUEST['user_name'])!='') {
			$user_ids = array(); $q = trim($_REQUEST['user_name']);

			$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			if ($users && count($users)) {
				foreach ($users as $user) {
					$user_ids[] = $user['id'];
				}
			}

			$condition['id'] = array('in',$user_ids);
		}

		if(trim($_REQUEST['adm_name'])!='') {
			$q = trim($_REQUEST['adm_name']);
			$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%'")->field("id")->findAll();
			if ($adm_users && count($adm_users)) {
				foreach ($adm_users as $k=>$user) {
					$adm_users[$k] = $user['id'];
				}
			}
			$condition['admin_id'] = array("in", $adm_users);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$list = M("User")->where($map)
			->field("*,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile")
			->limit($limit)->findAll();

		if($list) {
			register_shutdown_function(array(&$this, 'export_csv_customer_acct_list'), $page+1);
			
			$user_value = array('id'=>'""','user_name'=>'""','real_name'=>'""','money'=>'""','lock_money'=>'""','sex'=>'""','mobile'=>'""','pid'=>'""','admin_id'=>'""','qq_id'=>'""','score'=>'""','create_time'=>'""');
			if($page == 1){
				$content = iconv("utf-8","gbk","编号,会员ID,用户名,可用余额,冻结金额,性别,手机,推荐人,专属客服,QQ号码,积分余额,注册时间");
				$content = $content . "\n";
			}
			for ($i=count($list)-1; $i>=0; $i--) {
				$k = $i; $v = $list[$i];
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['real_name'] = iconv('utf-8','gbk','" '.$v['real_name'] .' "');
				$user_value['money'] = iconv('utf-8','gbk','"' .  number_format($v['money'],2) . '"');
				$user_value['lock_money'] = iconv('utf-8','gbk','"' .  number_format($v['lock_money'],2) . '"');
				$user_value['sex'] = iconv('utf-8','gbk','"' . get_sex($v['sex']) . '"');
				$user_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$user_value['pid'] = iconv('utf-8','gbk','"' . get_user_real_name($v['pid']) . '"');
				$user_value['admin_id'] = iconv('utf-8','gbk','"' . get_admin_real_name($v['admin_id']) . '"');
				$user_value['qq_id'] = iconv('utf-8','gbk','"' . $v['qq_id'] . '"');
				$user_value['score'] = iconv('utf-8','gbk','"' . $v['score'] . '"');
				$user_value['create_time'] = iconv('utf-8','gbk','"' . date('Y-m-d H:i:s', $v['create_time']) . '"');
			
				$content .= implode(",", $user_value) . "\n";
			}	
					
			header("Content-Disposition: attachment; filename=user_list.csv");
	    	echo $content;  
		}
	}

	/** 
	 * XHF 2016/7/28 加入会员回访记录
	 */
	public function view() {
		$user_id = trim($_REQUEST['user_id']);
		if ($user_id == 0) { $this->error("会员用户名提交错误!"); }
		$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user where id=".$user_id);
		if (!$list || !count($list)) {
			$this->error("该会员信息不存在!");
		}

		// 显示信息内容格式化
		$show_item = array(
			array('key'=>'visit_info', 'title'=>'回访记录'),
			array('key'=>'user_info', 'title'=>'会员信息'),
			array('key'=>'load_info', 'title'=>'投资信息'),
			array('key'=>'deal_info', 'title'=>'借款信息'),
			array('key'=>'payment_info', 'title'=>'充值记录'),
			array('key'=>'carry_info', 'title'=>'提现记录'),
			array('key'=>'money_info', 'title'=>'资金流水'),
			array('key'=>'score_info', 'title'=>'积分明细'),
			array('key'=>'bribery_money', 'title'=>'红包明细'),
			array('key'=>'recom_level_1', 'title'=>'一级推荐客户'),
			array('key'=>'recom_level_2', 'title'=>'二级推荐客户'),
		); 
		$this->assign("show_item", $show_item);

		// 会员信息格式化
		$list = $list[0];
		$user_info = array(
			array('key'=>'id', 'title'=>'会员编号', 'value'=>$list['id']),
			array('key'=>'user_type', 'title'=>'会员类型', 'value'=>$list['user_type'] == 0? '个人客户' : '企业客户'),
			array('key'=>'user_name', 'title'=>'用户名', 'value'=>$list['user_name']),
			array('key'=>'idno', 'title'=>'身份证号', 'value'=>$list['idno']),
			array('key'=>'real_name', 'title'=>'会员名称', 'value'=>$list['real_name']),
			array('key'=>'none'),
			array('key'=>'sex', 'title'=>'性别', 'value'=>$list['sex']==0?'女':($list['sex']==1?'男':'未设置')),
			array('key'=>'user_type', 'title'=>'生日', 'value'=>date('Y/m/d',strtotime($list['byear'].'/'.$list['bmonth'].'/'.$list['bday']))),
			array('key'=>'age', 'title'=>'年龄', 'value'=>intval(date('Y',TIME_UTC)-$list['byear']).'岁'),
			array('key'=>'email', 'title'=>'电子邮箱', 'value'=>$list['email']),
			array('key'=>'mobile', 'title'=>'手机', 'value'=>$list['mobile']),
			array('key'=>'qq_id', 'title'=>'QQ', 'value'=>$list['qq_id']),
			array('key'=>'region_1', 'title'=>'省市', 'value'=>''),
			array('key'=>'region_2', 'title'=>'地区', 'value'=>''),
			array('key'=>'region_3', 'title'=>'区县', 'value'=>''),
			array('key'=>'graduation', 'title'=>'学历', 'value'=>''),
			array('key'=>'income', 'title'=>'月收入', 'value'=>''),
			array('key'=>'marriage', 'title'=>'婚姻状况', 'value'=>''),
			array('key'=>'hashouse', 'title'=>'住房条件', 'value'=>''),
			array('key'=>'haschild', 'title'=>'有无子女', 'value'=>''),
			array('key'=>'a1', 'title'=>'是否有社保', 'value'=>''),
			array('key'=>'a2', 'title'=>'社保电脑号', 'value'=>''),
			array('key'=>'a3', 'title'=>'是否购车', 'value'=>''),
			array('key'=>'a4', 'title'=>'是否逾期记录', 'value'=>''),
		);
		$this->assign("user_info", $user_info);

		// 加载用户的维护记录
		$visit_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_visit_log where user_id='".$_REQUEST['user_id']."' order by id desc");
		foreach ($visit_list as &$v) {
			$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
		}

		// 加载用户的投资信息
		$load_list = $GLOBALS['db']->getAll("select dl.*,d.deal_sn,d.name as deal_name,d.user_id as deal_user_id,d.rate,d.repay_time,d.repay_time_type,d.borrow_amount,d.loantype,d.type_id,d.cate_id from ".DB_PREFIX."deal_load dl left join ".DB_PREFIX."deal d on dl.deal_id=d.id left join ".DB_PREFIX."user u on dl.user_id=u.id where u.id='".$_REQUEST['user_id']."' order by dl.id desc");
		foreach ($load_list as &$v) {
			$v['create_time_format'] = date('Y-m-d', $v['create_time']);
			$v['deal_user_name'] = get_user_real_name($v['deal_user_id']);
			$v['repay_time_format'] = $v['repay_time'].($v['repay_time_type']==1?'个月':'天');
			$v['deal_type'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_loan_type where id=".$v['type_id']);
			$v['cate_name'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$v['cate_id']);
			$v['loantype_format'] = $v['loantype']==0?'等额本息':($v['loantype']==1?'付息还本':($v['loantype']==2?'到期还本息':('等本等息')));
		} 

		// 加载用户借款信息
		$deal_list = $GLOBALS['db']->getAll("select d.* from ".DB_PREFIX."deal d left join ".DB_PREFIX."user u on d.user_id=u.id where d.is_delete=0 and u.id='".$_REQUEST['user_id']."' order by d.id desc");
		foreach ($deal_list as &$v) {
			$v['create_time_format'] = date('Y-m-d', $v['create_time']);
			$v['deal_user_name'] = get_user_real_name($v['user_id']);
			$v['repay_time_format'] = $v['repay_time'].($v['repay_time_type']==1?'个月':'天');
			$v['deal_type'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_loan_type where id=".$v['type_id']);
			$v['cate_name'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$v['cate_id']);
			$v['loantype_format'] = $v['loantype']==0?'等额本息':($v['loantype']==1?'付息还本':($v['loantype']==2?'到期还本息':('等本等息')));
		} 

		// 加载充值记录
		$payment_notice_list = $GLOBALS['db']->getAll("select pn.* from ".DB_PREFIX."payment_notice pn left join ".DB_PREFIX."user u on pn.user_id=u.id where pn.is_paid=1 and u.id='".$_REQUEST['user_id']."' order by pn.id desc");
		foreach ($payment_notice_list as &$v) {
			$v['pay_time_format'] = date('Y-m-d H:i:s', $v['pay_time']);
			$v['user_name'] = get_user_real_name($v['user_id']);
			$v['account_money'] = get_user_money($v['user_id']);
			$v['payment_type'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."payment where id=".$v['payment_id']);
		} 

		// 加载提现记录
		$user_carry_list = $GLOBALS['db']->getAll("select uc.* from ".DB_PREFIX."user_carry uc left join ".DB_PREFIX."user u on uc.user_id=u.id where uc.status=1 and u.id='".$_REQUEST['user_id']."' order by uc.id desc");
		foreach ($user_carry_list as &$v) {
			$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
			$v['user_name'] = get_user_real_name($v['user_id']);
			$v['account_money'] = get_user_money($v['user_id']);
		} 

		// 加载资金流水
		$user_money_log_list = $GLOBALS['db']->getAll("select uml.* from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id where u.id='".$_REQUEST['user_id']."' order by uml.id desc");
		foreach ($user_money_log_list as &$v) {
			$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
			$v['user_name'] = get_user_real_name($v['user_id']);
			$v['type_format'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."money_type where class='money' and type=".$v['type']);
			$v['input_user_name'] = get_admin_real_name($v['input_user_id']);
		} 

		// 加载一级推荐客户
		$recom_level_1_list = $GLOBALS['db']->getAll("select id,user_name,real_name,sex,idno,mobile,pid,orgNo,admin_id,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,lock_money,qq_id,score,create_time from ".DB_PREFIX."user where pid='".$_REQUEST['user_id']."' order by id desc");
		$recom_level_1_id = array();
		foreach ($recom_level_1_list as &$v) {
			$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
			$v['refer_user_name'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$v['pid']);
			$v['refer_user_real_name'] = $GLOBALS['db']->getOne("select real_name from ".DB_PREFIX."user where id=".$v['pid']);
			$v['admin_real_name'] = get_admin_real_name($v['admin_id']);
			$v['money'] = number_format($v['money'],2);
			$v['lock_money'] = number_format($v['lock_money'],2);
			$v['account_money'] = number_format($v['money'] + $v['lock_money'], 2);
			$v['loan_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_load where user_id=".$v['id']);
			$v['sex'] = $v['sex']==0?'女':($v['sex']==1?'男':'');
			$recom_level_1_id[] = $v['id'];
		} 

		// 加载二级推荐客户
		$recom_level_1_id = array();

		if (count($recom_level_1_id)) {
			$recom_level_2_list = $GLOBALS['db']->getAll("select id,user_name,real_name,sex,idno,mobile,pid,orgNo,admin_id,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,lock_money,qq_id,score,create_time from ".DB_PREFIX."user where pid in (".implode(',',$recom_level_1_id).") order by id desc");
			foreach ($recom_level_2_list as &$v) {
				$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
				$v['refer_user_name'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$v['pid']);
				$v['refer_user_real_name'] = $GLOBALS['db']->getOne("select real_name from ".DB_PREFIX."user where id=".$v['pid']);
				$v['admin_real_name'] = get_admin_real_name($v['admin_id']);
				$v['money'] = number_format($v['money'],2);
				$v['lock_money'] = number_format($v['lock_money'],2);
				$v['account_money'] = number_format($v['money'] + $v['lock_money'], 2);
				$v['loan_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_load where user_id=".$v['id']);
				$v['sex'] = $v['sex']==0?'女':($v['sex']==1?'男':'');
			}
		} else {
			$recom_level_2_list = array();
		}

		// 变量分配
		$this->assign("user_id", $user_id);
		$this->assign("load_list", $load_list);
		$this->assign("visit_list", $visit_list);
		$this->assign("deal_list", $deal_list);
		$this->assign("payment_notice_list", $payment_notice_list);
		$this->assign("user_carry_list", $user_carry_list);
		$this->assign("user_money_log_list", $user_money_log_list);
		$this->assign("recom_level_1_list", $recom_level_1_list);
		$this->assign("recom_level_2_list", $recom_level_2_list);

		$this->display ("view");
	}

	/**
	 * 添加客服维护记录
	 * XHF 2016/7/28
	 */
	public function add_visit() {
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		B('FilterString');
		$data = M('UserVisitLog')->create ();

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$data['customer'] = get_admin_real_name($adm_session['adm_id']);

		//visit_time,content不能为空
		if ($data['visit_date'] != "" || $data['content'] != "") {
			//插入回访记录
			$data['create_time'] = TIME_UTC;
			$data['visit_time'] =  trim($data['next_visit_date'])!=0? strtotime(trim($data['visit_date'])) : 0;
			$data['next_visit_time'] = trim($data['next_visit_date'])!=0? strtotime(trim($data['next_visit_date'])) : 0;

			$list=M('UserVisitLog')->add($data);
			
			$log_info = '用户编号:'.$data['user_id'].'回访记录';

			if (false !== $list) {
				require_once(APP_ROOT_PATH."app/Lib/common.php");
				//成功提示
				save_log("编号：$list，".$log_info.L("INSERT_SUCCESS"),1);
				$this->success(L("INSERT_SUCCESS"));
			} else {
				//错误提示
				$dbErr = M()->getDbError();
				save_log($log_info.L("INSERT_FAILED").$dbErr,0);
				$this->error(L("INSERT_FAILED").$dbErr);
			}
		} else {
			$this->error("回访时间和内容不能为空");
		}

		$this->view();
	}

	/**
	 * 会员维护记录列表
	 * XHF 2016/7/28
	 */
	public function visit_log() {
		$this->assign("main_title", "维护日志");
		
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		//获取角色id
		$role_id = $GLOBALS['db']->getOne("select role_id from ".DB_PREFIX."admin where id=".$adm_session['adm_id']);

		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
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
		}
		else{
			$sort = "desc";
		}
	
		//开始加载搜索条件
		$condition =" 1=1 ";

		if ($role_id == 3) {
			$condition .= " and u.admin_id=".$adm_session['adm_id'];
		}

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and uvl.visit_time >= $begin_time ";	
			}
			else
			{
				$condition .= " and uvl.visit_time between $begin_time and $end_time ";	
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");

		if(trim($_REQUEST['user_name'])!='')
		{
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
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."user_visit_log uvl LEFT JOIN ".DB_PREFIX."user u ON uvl.user_id=u.id WHERE $condition ";

		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT uvl.*,u.user_name,u.real_name,u.mobile,u.pid,u.admin_id FROM ".DB_PREFIX."user_visit_log uvl LEFT JOIN ".DB_PREFIX."user u ON uvl.user_id=u.id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
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
		$this->display ();
	}
	
	/**
	 * 导出会员维护记录列表
	 * XHF 2016/7/28
	 */
    public function export_csv_visit_log($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
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
		}
		else{
			$sort = "desc";
		}
	
		//开始加载搜索条件
		$condition =" 1=1 ";
		
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and uvl.visit_time >= $begin_time ";	
			}
			else
			{
				$condition .= " and uvl.visit_time between $begin_time and $end_time ";	
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");

		if(trim($_REQUEST['user_name'])!='')
		{
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
			} else if ($role_id == 3) {
				$condition .= " and u.admin_id=".$adm_session['adm_id'];
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

		$sql_list =  " SELECT uvl.*,u.user_name,u.real_name,u.mobile,u.pid,u.admin_id FROM ".DB_PREFIX."user_visit_log uvl LEFT JOIN ".DB_PREFIX."user u ON uvl.user_id=u.id WHERE $condition ORDER BY $order $sort LIMIT ".$limit;
		$list = $GLOBALS['db']->getAll($sql_list);

		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv_visit_log'), $page+1);
	
			$export_value = array('id'=>'""','user_name'=>'""','real_name'=>'""','mobile'=>'""','pid'=>'""','admin_id'=>'""','visit_date'=>'""','content'=>'""','remark'=>'""','next_visit_date'=>'""','customer'=>'""','create_time'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,会员ID,会员名,手机号码,推荐人,专属客服,回访时间,内容,评估,下次回访时间,维护人,创建时间");
	
			if($page==1)
				$content = $content . "\n";

			foreach($list as $k=>$v)
			{
				$export_value = array();
				$export_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$export_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$export_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$export_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$export_value['pid'] = iconv('utf-8','gbk','"' . get_user_real_name($v['pid']) . '"');
				$export_value['admin_id'] = iconv('utf-8','gbk','"' . get_admin_real_name($v['admin_id']) . '"');
				$export_value['visit_date'] = iconv('utf-8','gbk','"' . $v['visit_date'] . '"');
				$export_value['content'] = iconv('utf-8','gbk','"' . $v['content'] . '"');
				$export_value['remark'] = iconv('utf-8','gbk','"' . $v['remark'] . '"');
				$export_value['next_visit_date'] = iconv('utf-8','gbk','"' . $v['next_visit_date'] . '"');
				$export_value['customer'] = iconv('utf-8','gbk','"' . $v['customer'] . '"');
				$export_value['create_time'] = iconv('utf-8','gbk','"' . date('Y-m-d H:i:s', $v['create_time']) . '"');
				$content .= implode(",", $export_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=会员维护日志.csv");
			echo $content;
		}
		else
		{
			if($page==1) {
				$this->error(L("NO_RESULT"));
			}
		}	
	}

	public function black() {
        $this->assign("main_title","黑名单管理");
		$this->assign("user_type", -1);
		$map[DB_PREFIX.'user.is_black'] = array('eq',1);
		$this->getUserList(-1,0,$map);
		$this->display ("index");
	}

	public function lock() {
        $this->assign("main_title","已锁定会员");
		$this->assign("user_type", -1);
		$map[DB_PREFIX.'user.is_effect'] = array('eq',0);
		$this->getUserList(-1,0,$map);
		$this->display ("index");
	}
	
	public function company_black() {
		$map[DB_PREFIX.'user.is_black'] = array('eq',1);
		
		$this->getUserList(1,0,$map);
		$this->display ("index");
	}
	
	public function register() {
		$map[DB_PREFIX.'user.is_effect'] = array('eq',0);
		$map[DB_PREFIX.'user.login_time'] = array('eq',0);
		$map[DB_PREFIX.'user.login_ip'] = array('eq','');
		
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}
	
	public function company_register()
	{
		$map[DB_PREFIX.'user.is_effect'] = array('eq',0);
		$map[DB_PREFIX.'user.login_time'] = array('eq',0);
		$map[DB_PREFIX.'user.login_ip'] = array('eq','');
		
		$this->getUserList(1,0,$map);
		$this->display ("index");
	}
	
	public function info()
	{
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(0,0,$map);
		$this->display ();
	}
	
	public function company_info()
	{
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(1,0,$map);
		$this->display ("info");
	}
	
	
	public function trash()
	{
		$this->getUserList(0,1,array());
		$this->display ();
	}
	
	public function company_trash()
	{
		$this->getUserList(1,1,array());
		$this->display ("trash");
	}
	
	//坏账会员列表
	public function bad_member()
	{
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		
		$bad_id = $GLOBALS['db']->getAll("SELECT DISTINCT user_id FROM  ".DB_PREFIX."user_sta WHERE  bad_count > 0");
	
		$flatmap = array_map("array_pop",$bad_id);
		$bad_id=implode(',',$flatmap);

		$map[DB_PREFIX.'user.id']  = array("exp","in (".$bad_id.")");
		
		//当前登录管理员所属会员
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);
		
		$is_department = M("Admin")->where("id=".$adm_id)->getField("is_department");
		
		if( $is_department == 0){
			$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_id);
		}elseif($is_department == 1)
		{
			$adm_pid = $GLOBALS['db']->getAll("SELECT id FROM  ".DB_PREFIX."admin WHERE  pid = ".$adm_id);
			$flatmap = array_map("array_pop",$adm_pid);
			$adm_pid=implode(',',$flatmap);
			$map[DB_PREFIX.'user.admin_id']  = array("exp","in (".$adm_id.",".$adm_pid.")");
		}
		
		
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}
	
	//借款会员列表
	public function borrowing_member()
	{
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
	
		$user_id = $GLOBALS['db']->getAll("SELECT DISTINCT user_id FROM  ".DB_PREFIX."deal");
		$flatmap = array_map("array_pop",$user_id);
		$user_id=implode(',',$flatmap);
		$map[DB_PREFIX.'user.id']  = array("exp","in (".$user_id.")");
	
		//当前登录管理员所属会员
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);
		
		$is_department = M("Admin")->where("id=".$adm_id)->getField("is_department");
		
		
		if( $is_department == 0){
			$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_id);
		}elseif($is_department == 1)
		{
			$adm_pid = $GLOBALS['db']->getAll("SELECT id FROM  ".DB_PREFIX."admin WHERE  pid = ".$adm_id);
			$flatmap = array_map("array_pop",$adm_pid);
			$adm_pid=implode(',',$flatmap);
			$map[DB_PREFIX.'user.admin_id']  = array("exp","in (".$adm_id.",".$adm_pid.")");
		}
		
		$this->getUserList(0,0,$map);
		$this->display ("index");
	}
	
	/*
	 * $user_type  0普通会员 1企业会员
	 */
	protected function getUserList($user_type=0,$is_delete = 0,$map){
		//授权中心自动分配
		$this->_authority_assign();

		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		if ($user_type == -1) {
			$map[DB_PREFIX.'user.user_type'] = array("in", array(0,1));
		} else {
			$map[DB_PREFIX.'user.user_type'] = $user_type;
		}

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == "mycustomer") {
			$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_session['adm_id']);
		}

		//定义条件
		$map[DB_PREFIX.'user.is_delete'] = $is_delete;

		if(intval($_REQUEST['group_id'])>0)
		{
			$map[DB_PREFIX.'user.group_id'] = intval($_REQUEST['group_id']);
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
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
		if(!isset($_REQUEST['is_user'])) {
			$_REQUEST['is_user'] = 1;
		}
		
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time']);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$map[DB_PREFIX.'user.create_time'] = array('egt',$begin_time);
			}
			else
            {
				$map[DB_PREFIX.'user.create_time']= array("between",array($begin_time,$end_time));
            }
		}
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map ,'' ,false , "*,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile");
		}
		
		$list = $this->get("list");
		foreach($list as $k=>$v){
			if($v['email'] ==  get_site_email($v['id'])){
				$list[$k]['email']="";
			}
			$list[$k]['total_money']=$v['money']+$v['lock_money'];
			$list[$k]['loan_money']=$GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_load where user_id=".$v['id']);			
		}
		$this->assign("list",$list);
	}

	//授权中心自动分配
	protected function _authority_assign() {
		$users = $GLOBALS['db']->getAll("select id,user_name,pid from ".DB_PREFIX."user where authority_id=0 and pid<>672 and user_type=0 and pid>0");
		if ($users && count($users)) {
			foreach ($users as $v) {
				$p_authority_id = $GLOBALS['db']->getOne("select authority_id from ".DB_PREFIX."user where id=".$v['pid']);
				$GLOBALS['db']->query("update ".DB_PREFIX."user set authority_id=".$p_authority_id." where id=".$v['id']);
			}
		}
	}
	
	public function add() {
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		$cate_list = M("TopicTagCate")->findAll();
		$this->assign("cate_list",$cate_list);
		
		$field_list = M("UserField")->order("sort desc")->findAll();
		foreach($field_list as $k=>$v)
		{
			$field_list[$k]['value_scope'] = preg_split("/[ ,]/i",$v['value_scope']);
		}
		
		//地区列表
		
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		$this->assign("region_lv2",$region_lv2);
		
		$this->assign("field_list",$field_list);
		$this->display();
	}
	
	public function insert() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$ajax = intval($_REQUEST['ajax']);
		$data = M(MODULE_NAME)->create ();

		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/add"));
	
		if(!check_empty($data['user_pwd']))
		{
			$this->error(L("USER_PWD_EMPTY_TIP"));
		}	
		if($data['user_pwd']!=$_REQUEST['user_confirm_pwd'])
		{
			$this->error(L("USER_PWD_CONFIRM_ERROR"));
		}
		$res = save_user($_REQUEST);
		$this->user_save_tip($res);
		$user_id = intval($res['user_id']);
		foreach($_REQUEST['auth'] as $k=>$v)
		{
			foreach($v as $item)
			{
				$auth_data = array();
				$auth_data['m_name'] = $k;
				$auth_data['a_name'] = $item;
				$auth_data['user_id'] = $user_id;
				M("UserAuth")->add($auth_data);
			}
		}
		
		
		foreach($_REQUEST['cate_id'] as $cate_id)
		{
			$link_data = array();
			$link_data['user_id'] = $user_id;
			$link_data['cate_id'] = $cate_id;
			M("UserCateLink")->add($link_data);
		}
		
		// 更新数据
		$log_info = $data['user_name'];
		save_log($log_info.L("INSERT_SUCCESS"),1);
		$this->success(L("INSERT_SUCCESS"));
		
	}
	public function edit() {		
		$id = intval($_REQUEST ['id']);
		
		$vo = get_user_info("*","is_delete=0 and id=".$id);
		if($vo['email'] ==  get_site_email($vo['id'])){
			$vo['email']="";
		}
		$this->assign ( 'vo', $vo );

		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
			
		$field_list = M("UserField")->order("sort desc")->findAll();
		foreach($field_list as $k=>$v)
		{
			$field_list[$k]['value_scope'] = preg_split("/[ ,]/i",$v['value_scope']);
			$field_list[$k]['value'] = M("UserExtend")->where("user_id=".$id." and field_id=".$v['id'])->getField("value");
		}
		$this->assign("field_list",$field_list);
		
		$rs = M("UserAuth")->where("user_id=".$id." and rel_id = 0")->findAll();
		foreach($rs as $row)
		{
			$auth_list[$row['m_name']][$row['a_name']] = 1;
		}
		
		//地区列表
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		foreach($region_lv2 as $k=>$v)
		{
			if($v['id'] == intval($vo['province_id']))
			{
				$region_lv2[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv2",$region_lv2);
		
		$region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['province_id']));  //三级地址
		foreach($region_lv3 as $k=>$v)
		{
			if($v['id'] == intval($vo['city_id']))
			{
				$region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv3",$region_lv3);
		
		$n_region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['n_province_id']));  //三级地址
		foreach($n_region_lv3 as $k=>$v)
		{
			if($v['id'] == intval($vo['n_city_id']))
			{
				$n_region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("n_region_lv3",$n_region_lv3);
		
		$this->assign("auth_list",$auth_list);
		$this->display ();
	}
	public function delete() {
		//系统安全选项检测
		$this->check_safe_item();

		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
			$deal_condition = array ('user_id' => array ('in', explode ( ',', $id ) ) );
			if(M("Deal")->where($deal_condition)->count() > 0){
				$this->error ("删除的会员有借款记录",$ajax);
			}
			//删除验证
			if(M("DealOrder")->where(array ('user_id' => array ('in', explode ( ',', $id ) ) ))->count()>0)
			{
				$this->error (l("ORDER_EXIST_DELETE_FAILED"),$ajax);
			}
			$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
			$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
			foreach($rel_data as $data)
			{
				$info[] = $data['user_name'];	
			}
			if($info) $info = implode(",",$info);
			$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 1 );
			if ($list!==false) {
				//把信息屏蔽
				M("Topic")->where("user_id in (".$id.")")->setField("is_effect",0);
				M("Message")->where("user_id in (".$id.")")->setField("is_effect",0);
				save_log($info.l("DELETE_SUCCESS"),1);
				$this->success (l("DELETE_SUCCESS"),$ajax);
			} else {
				save_log($info.l("DELETE_FAILED"),0);
				$this->error (l("DELETE_FAILED"),$ajax);
			}
		} else {
			$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	
	public function restore() {
		//系统安全选项检测
		$this->check_safe_item();

		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
			$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
			$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
			foreach($rel_data as $data)
			{
				$info[] = $data['user_name'];						
			}
			if($info) $info = implode(",",$info);
			$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 0 );
			if ($list!==false) {
				//把信息屏蔽
				M("Topic")->where("user_id in (".$id.")")->setField("is_effect",1);
				M("Message")->where("user_id in (".$id.")")->setField("is_effect",1);
				save_log($info.l("RESTORE_SUCCESS"),1);
				$this->success (l("RESTORE_SUCCESS"),$ajax);
			} else {
				save_log($info.l("RESTORE_FAILED"),0);
				$this->error (l("RESTORE_FAILED"),$ajax);
			}
		} else {
			$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	
	public function foreverdelete() {
		//系统安全选项检测
		$this->check_safe_item();

		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
			$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
			$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
			foreach($rel_data as $data)
			{
				$info[] = $data['user_name'];	
			}
			if($info) $info = implode(",",$info);
			$ids = explode ( ',', $id );
			foreach($ids as $uid)
			{
				delete_user($uid);
			}
			save_log($info.l("FOREVER_DELETE_SUCCESS"),1);
			clear_auto_cache("consignee_info");
			$this->success (l("FOREVER_DELETE_SUCCESS"),$ajax);
			
		} else {
			$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}
	
	public function update() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$data = M(MODULE_NAME)->create ();
		
		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("user_name");
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/edit",array("id"=>$data['id'])));
		if(!check_empty($data['user_pwd'])&&$data['user_pwd']!=$_REQUEST['user_confirm_pwd'])
		{
			$this->error(L("USER_PWD_CONFIRM_ERROR"));
		}
		
		$res = save_user($_REQUEST,'UPDATE');
		
		$this->user_save_tip($res);
		
		//更新权限
		
		M("UserAuth")->where("user_id=".$data['id']." and rel_id = 0")->delete();
		foreach($_REQUEST['auth'] as $k=>$v) {
			foreach($v as $item) {
				$auth_data = array();
				$auth_data['m_name'] = $k;
				$auth_data['a_name'] = $item;
				$auth_data['user_id'] = $data['id'];
				M("UserAuth")->add($auth_data);
			}
		}
		//开始更新is_effect状态
		M("User")->where("id=".intval($_REQUEST['id']))->setField("is_effect",intval($_REQUEST['is_effect']));
		$user_id = intval($_REQUEST['id']);		
		M("UserCateLink")->where("user_id=".$user_id)->delete();
		foreach($_REQUEST['cate_id'] as $cate_id)
		{
			$link_data = array();
			$link_data['user_id'] = $user_id;
			$link_data['cate_id'] = $cate_id;
			M("UserCateLink")->add($link_data);
		}
		save_log($log_info.L("UPDATE_SUCCESS"),1);
		$this->success(L("UPDATE_SUCCESS"));
		
	}

	public function set_effect() {
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("user_name");
		$c_is_effect = M(MODULE_NAME)->where("id=".$id)->getField("is_effect");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_effect",$n_is_effect);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	
	public function set_black() {
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("user_name");
		$c_is_effect = M(MODULE_NAME)->where("id=".$id)->getField("is_black");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_black",$n_is_effect);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	
	public function account() {
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$this->assign("user_info",$user_info);
		$this->display();
	}
	
	public function modify_account() {
		//系统安全选项检测
		$this->check_safe_item();

		$user_id = intval($_REQUEST['id']);
		$money = 0;
		$score = intval($_REQUEST['score']);
		$point = intval($_REQUEST['point']);
		$quota = floatval($_REQUEST['quota']);
		$lock_money = floatval($_REQUEST['lock_money']);
		
		if($lock_money!=0){
			if($lock_money > 0 && $lock_money > D("User")->where('id='.$user_id)->getField("money")){
				$this->error("输入的冻结资金不得超过账户总余额"); 
			}
			
			if($lock_money < 0 && $lock_money < -D("User")->where('id='.$user_id)->getField("lock_money")){
				$this->error("输入的解冻资金不得大于已冻结的资金"); 
			}
			
			$money -=$lock_money;
		}
		
		$msg = trim($_REQUEST['msg'])==''?l("ADMIN_MODIFY_ACCOUNT"):trim($_REQUEST['msg']);
		modify_account(array('money'=>$money,'score'=>$score,'point'=>$point,'quota'=>$quota,'lock_money'=>$lock_money),$user_id,$msg,13);
		if(floatval($_REQUEST['quota'])!=0){
			//$content = "您好，".app_conf("SHOP_TITLE")."审核部门经过综合评估您的信用资料及网站还款记录，将您的信用额度调整为：".D("User")->where("id=".$user_id)->getField('quota')."元";
			
			$group_arr = array(0,$user_id);
			sort($group_arr);
			$group_arr[] =  4;
			
			$sh_notice['shop_title'] = app_conf("SHOP_TITLE");							  // 网站名称
			$sh_notice['quota'] = D("User")->where("id=".$user_id)->getField('quota');    // 信用额度
			$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
			$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_QUOTA_TZ'",false);
			$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
			
			$msg_data['content'] = $sh_content;
			$msg_data['to_user_id'] = $user_id;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['type'] = 0;
			$msg_data['group_key'] = implode("_",$group_arr);
			$msg_data['is_notice'] = 4;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
			$id = $GLOBALS['db']->insert_id();
			$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
		}
		save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
		$this->success(L("UPDATE_SUCCESS")); 
	}
	
	public function account_detail() {
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$log_begin_time  = trim($_REQUEST['log_begin_time'])==''?0:to_timespan($_REQUEST['log_begin_time']);
		$log_end_time  = trim($_REQUEST['log_end_time'])==''?0:to_timespan($_REQUEST['log_end_time']);
		$t= trim($_REQUEST['t']) =="" ? "money": trim($_REQUEST['t']);
		if($user_id)
		{
			$map['user_id'] = $user_id;
		}
		if(trim($_REQUEST['log_info'])!='')
		{
			if($t=="" || $t=="quota")
			{
				$map['log_info'] = array('like','%'.trim($_REQUEST['log_info']).'%');	
			}else {
				$map['memo'] = array('like','%'.trim($_REQUEST['log_info']).'%');
			}		
		}
		
		if($log_end_time==0)
		{
			if($t=="" || $t=="quota")
			{
				$map['log_time'] = array('gt',$log_begin_time);	
			}else {
				$map['create_time'] = array('gt',$log_begin_time);
			}
		}
		elseif($log_begin_time > 0 || $log_end_time > 0){
			if($t==""  || $t=="quota")
			{
				$map['log_time'] = array('between',array($log_begin_time,$log_end_time));	
			}else {
				$map['create_time'] = array('between',array($log_begin_time,$log_end_time));
			}
		}
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		if($t=="money")
		{	//资金日志
			$model = M ("UserMoneyLog");
		}elseif($t=="point"){
			$model = M ("UserPointLog");
			//信用积分日志
		}elseif($t=="score"){
			$model = M ("UserScoreLog");
			//积分日志
		}elseif($t=="freeze"){
			$model = M ("UserLockMoneyLog");
		}elseif($t=="nmc_amount"){
			$model = M ("UserNmcMoneyLog");
			$map['type'] = array('in',array(18,22,28,29));
			//不可提现资金
		}else{
			$map['quota'] = array('neq',0);
			$model = M ("UserLog");
		}
		
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		
		
		$this->assign("t",$t);
		$this->assign("user_id",$user_id);
		$this->assign("user_info",$user_info);
		$this->display ();
		return;
	}
	
	//收货地址
	public function address() {
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		
		$map['user_id'] = $user_id;
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		$model = M ("UserAddress");
		
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
	
		$this->assign("user_info",$user_info);
		$this->display ();
		return;
	}
	
	public function address_add() {
		$this->display ("address_add");
	}
	
	public function address_insert() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$data = M("UserAddress")->create ();
		//开始验证有效性
		
		//$this->assign("jumpUrl",u("UserAddress"."/add"));
		if($data['name']=="")
		{
			$this->error("收货姓名不能为空");
		}
		if($data['address']=="")
		{
			$this->error("收货地址不能为空");
		}
		if($data['phone']=="")
		{
			$this->error("收货电话不能为空");
		}
		// 更新数据
		
		$user_name = trim($_REQUEST['user_name']);
		$user_id = M("User")->where("user_name='".$user_name."'")->getField("id"); 
		
		if($user_id==0)
		{
			$this->error("该用户不存在");
		}
		
		$data['user_id'] = intval($user_id);
	
		$list=M("UserAddress")->add($data);
		if (false !== $list) {
			//成功提示
			if($data['is_default'] == 1){
				$GLOBALS['db']->query("update ".DB_PREFIX."user_address set is_default = 0 where id != ".$list);
			}
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}
	
	public function address_edit() {
		$address_id = intval($_REQUEST['address_id']);
		$condition['id'] = $address_id;		
		$vo = M("UserAddress")->where($condition)->find();
		$this->assign ( 'vo', $vo );
		$this->display ("address_edit");
	}
	
	public function address_update() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$data = M("UserAddress")->create ();
		// 更新数据
		$list=M("UserAddress")->save ($data);
		
		if($data['is_default'] == 1){
			$GLOBALS['db']->query("update ".DB_PREFIX."user_address set is_default = 0 where id != ".$data['id']);
		}
		if (false !== $list) {
			//成功提示
			save_log($data['name'].L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($data['name'].L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$data['name'].L("UPDATE_FAILED"));
		}
	}

	public function address_del() {
		//系统安全选项检测
		$this->check_safe_item();

		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {

			$condition = array ();
			$condition['id'] = array ('in', explode ( ',', $id ) );
			/*
			$rel_data = M("UserAddress")->where($condition)->findAll();
			foreach($rel_data as $k=>$v){
				$info[] =$v['name'];
			}
			if($info) $info = implode(",",$info);
			*/
			$list = M("UserAddress")->where ( $condition )->delete();
			if ($list!==false) {
				save_log($info.l("DELETE_SUCCESS"),1);
				$this->success (l("DELETE_SUCCESS"),$ajax);
			} else {
				save_log($info.l("DELETE_FAILED"),0);
				$this->error (l("DELETE_FAILED"),$ajax);
			}
			
		} else {
			$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}
	
		
	public function passed(){
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		
		$field_array = array(
			"credit_identificationscanning"=>"idcardpassed",
			"credit_contact"=>"workpassed",
			"credit_credit"=>"creditpassed",
			"credit_incomeduty"=>"incomepassed",
			"credit_house"=>"housepassed",
			"credit_car"=>"carpassed",
			"credit_marriage"=>"marrypassed",
			"credit_titles"=>"skillpassed",
			"credit_videoauth"=>"videopassed",
			"credit_mobilereceipt"=>"mobiletruepassed",
			"credit_residence"=>"residencepassed",
			"credit_seal"=>"sealpassed",
		);
		
		$this->assign("user_info",$user_info);
		
		$t_credit_file = M("UserCreditFile")->where("user_id=".$user_id)->findAll();
		foreach($t_credit_file as $k=>$v){
    		$file_list = array();
    		if($v['file'])
    			$file_list = unserialize($v['file']);
    		
    		if(is_array($file_list)) 
    			$v['file_list']= $file_list;
    		
    		$credit_file[$v['type']] = $v;
    	}
    	
    	
    	$loantype = intval($_REQUEST['loantype']);
    	$needs_credits = array();
		if($loantype > 0){
			$loantypeinfo = M("DealLoanType")->getById($loantype);
			if($loantypeinfo['credits']!=""){
				$needs_credits = unserialize($loantypeinfo['credits']);
			}
		}
    	
    	$credit_type= load_auto_cache("credit_type");
    	$credit_list = array();
    	foreach($credit_type['list'] as $k=>$v){
    		
    		if($v['must']==1 || $loantype == 0 || (count($needs_credits)>0 && in_array($v['type'],$needs_credits))){
    			$credit_list[$v['type']] = $credit_type['list'][$v['type']];
	    		$credit_list[$v['type']]['credit'] = $credit_file[$v['type']];
	    		
	    		//User表里面的数据
	    		if($user_info[$field_array[$v['type']]]){
	    			$credit_list[$v['type']]['credit']['passed'] = $user_info[$field_array[$v['type']]];
	    		}
    		}
    	}
		
		$this->assign("credits",$credit_list);
		
		$this->display ();
		return;
	}
	
	public function agencies_passed(){
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		
		$field_array = array(
			"credit_identificationscanning"=>"idcardpassed"
		);
		

		$this->assign("user_info",$user_info);
		
		$t_credit_file = M("UserCreditFile")->where("user_id=".$user_id)->findAll();

		foreach($t_credit_file as $k=>$v){
    		$file_list = array();
			
    		if($v['file'])
			{
    			$file_list = unserialize($v['file']);
			}
    		if(is_array($file_list)) 
    			$v['file_list']= $file_list;
    		
    		$credit_file[$v['type']] = $v;
    	}
    	
    	
    	$loantype = intval($_REQUEST['loantype']);
    	$needs_credits = array();
		if($loantype > 0){
			$loantypeinfo = M("DealLoanType")->getById($loantype);
			if($loantypeinfo['credits']!=""){
				$needs_credits = unserialize($loantypeinfo['credits']);
			}
		}
    	$credit_type= load_auto_cache("credit_type");
    	$credit_list = array();
		
    	foreach($credit_type['list'] as $k=>$v){
			if($v["type"]=="credit_identificationscanning")
			{
				if($v['must']==1 || $loantype == 0 || (count($needs_credits)>0 && in_array($v['type'],$needs_credits))){
					$credit_list[$v['type']] = $credit_type['list'][$v['type']];
					$credit_list[$v['type']]['credit'] = $credit_file[$v['type']];
					
					//User表里面的数据
					if($user_info[$field_array[$v['type']]]){
						$credit_list[$v['type']]['credit']['passed'] = $user_info[$field_array[$v['type']]];
					}
				}
			}
    	}
		
		
		$this->assign("credits",$credit_list);
		
		$this->display ();
		return;
	}
	
	public function export_csv($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		//定义条件
		$map[DB_PREFIX.'user.is_delete'] = 0;

		if(intval($_REQUEST['group_id'])>0)
		{
			$map[DB_PREFIX.'user.group_id'] = intval($_REQUEST['group_id']);
		}

		if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == "mycustomer") {
			$adm_session = es_session::get(md5(conf("AUTH_KEY")));
			$map[DB_PREFIX.'user.admin_id'] = array('eq',$adm_session['adm_id']);
		}
		if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == "black") {
			$map[DB_PREFIX.'user.is_black'] = 1;
		}
		if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == "lock") {
			$map[DB_PREFIX.'user.is_effect'] = 0;
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
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
	
	
	function lock_money(){
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$this->assign("user_info",$user_info);
		$this->display();
	}
	
	function check_merchant_name() {
		$merchant_name = addslashes(trim($_REQUEST['merchant_name']));
		$ajax = intval($_REQUEST['ajax']);
		$result = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."supplier_account where account_name = '".$merchant_name."'");
		if(intval($result)==0)
		$this->error(l("MERCHANT_NAME_NOT_EXIST"),$ajax);
		else
		$this->success("",$ajax);
	}
	
	function info_down(){
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		
		$this->assign("user_info",$user_info);
		
		$this->display();
	}
	
	function modify_info_down(){
		//系统安全选项检测
		$this->check_safe_item();

		if(intval($_REQUEST['id'])==0){
			$this->error("会员不存在！");
			exit();
		}
		$is_delete = intval($_REQUEST['is_delete']);
		$file = $_FILES['file']['name'];
		
		if($file=="" && $is_delete==0){
			$this->error("请选择要上传的文件！");
			exit();
		}
		
		$file = pathinfo($file);
		
		if(
			strpos($file['extension'],"asp")!==false
			||
			strpos($file['extension'],"aspx")!==false
			||
			strpos($file['extension'],"php")!==false
			||
			strpos($file['extension'],"jsp")!==false
		){
			$this->error("非法文件格式！");
			exit();
		}
		
		
		
		if($is_delete == 1){
			$data['info_down'] = "";
		}
		
		if($file['error']==0 && $_FILES['file']['name']!=""){
			if(!file_exists(APP_ROOT_PATH."/public/info_down"))
				@mkdir(APP_ROOT_PATH."/public/info_down",0777);
		
			$time = to_date(TIME_UTC,"Ym");
			if(!file_exists(APP_ROOT_PATH."/public/info_down/".$time))
				@mkdir(APP_ROOT_PATH."/public/info_down/".$time,0777);
		
			$file_name = md5(TIME_UTC.$_REQUEST['id']).".".$file['extension'];
			//@file_put_contents(APP_ROOT_PATH."/public/info_down/".$time."/".$file_name,$_FILES['file']['tmp_name']);
			move_uploaded_file($_FILES['file']['tmp_name'],APP_ROOT_PATH."/public/info_down/".$time."/".$file_name);
			
			if(!file_exists(APP_ROOT_PATH."/public/info_down/".$time."/".$file_name)){
				$this->error("上传资料失败！");
			}
	
			$data['info_down'] = "./public/info_down/".$time."/".$file_name;
		}
		
		
		if($GLOBALS['db']->autoExecute(DB_PREFIX."user",$data,"UPDATE","id=".$_REQUEST['id'])){
			if($_REQUEST['old_info_down']){
				@unlink(APP_ROOT_PATH.$_REQUEST['old_info_down']);
			}
			if($is_delete == 1){
				$this->success("操作成功！");
			}
			else{
				$this->success("上传资料成功！");
			}
		} else{
			$this->error("上传资料失败！");
		}
		
	}
	
	function view_info(){
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$old_imgdata_str = unserialize($user_info['view_info']);
		$this->assign("user_info",$user_info);
		$this->assign("old_imgdata_str",$old_imgdata_str);
		$this->display();
	}
	
	function modify_view_info(){
		
		if(intval($_REQUEST['id'])==0){
			$this->error("会员不存在！");
			exit();
		}
		
		$view_down_data = array();
		foreach($_FILES['img_data']['name'] as $k=>$v){
			$file = pathinfo($v);
			
			if($file['error'] == 0){
				if(!file_exists(APP_ROOT_PATH."/public/view_info"))
					@mkdir(APP_ROOT_PATH."/public/view_info",0777);
			
				$time = to_date(TIME_UTC,"Ym");
				if(!file_exists(APP_ROOT_PATH."/public/view_info/".$time))
					@mkdir(APP_ROOT_PATH."/public/view_info/".$time,0777);
			
				$file_name = md5(TIME_UTC.$_REQUEST['id'].$v.$k).".".$file['extension'];
				
				move_uploaded_file($_FILES['img_data']['tmp_name'][$k],APP_ROOT_PATH."/public/view_info/".$time."/".$file_name);
				
				if(file_exists(APP_ROOT_PATH."/public/view_info/".$time."/".$file_name)){
					$view_down_data[$k]['img'] = "./public/view_info/".$time."/".$file_name;
					$view_down_data[$k]['name'] = trim($_REQUEST['file_name'][$k]);
				}
			
			}
			
		}
		
		$new_view_info_arr= array();
		$old_view_info = M("User")->where("id=".intval($_REQUEST['id']))->getField("view_info");
		if($old_view_info !=""){
			$old_view_info_arr = unserialize($old_view_info);
			
			foreach($old_view_info_arr as $k=>$v){
				$new_view_info_arr[$k] = $v;
			}
		}
		
		foreach($view_down_data as $k=>$v){
			$new_view_info_arr[] = $v;
		}
	
		
		$data['view_info'] = serialize($new_view_info_arr);
		
	
		if($GLOBALS['db']->autoExecute(DB_PREFIX."user",$data,"UPDATE","id=".$_REQUEST['id'])){
			$this->success("上传资料成功！");
		} else{
			$this->error("上传资料失败！");
		}	
	}
	
	function view_info_del_img(){
		if(intval($_REQUEST['id'])==0){
			$this->error("会员不存在！");
			exit();
		}
		
		if(trim($_REQUEST['src'])==""){
			$this->error("删除的文件不存在！");
			exit();
		}
		
		$old_view_info = M("User")->where("id=".intval($_REQUEST['id']))->getField("view_info");
		if($old_view_info !=""){
			$old_view_info_arr = unserialize($old_view_info);
			foreach($old_view_info_arr as $k=>$v){
				if($v['img'] == trim($_REQUEST['src'])){
					@unlink(APP_ROOT_PATH.$v['img']);
					unset($old_view_info_arr[$k]);
				}
			}
		}
		$data['view_info'] = serialize($old_view_info_arr);
		
		if($GLOBALS['db']->autoExecute(DB_PREFIX."user",$data,"UPDATE","id=".$_REQUEST['id'])){
			$this->success("删除成功！");
		}
		else{
			$this->error("删除失败！");
		}
	}
	
	public function company_manage() {
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "user_id";
		}
		
		
		switch($sorder){
			case "user_name": 
				$order ="u.".$sorder;
				break;
			default : 
				$order ="c.".$sorder;
				break;
		}
		
		$extWhere = " 1=1 ";
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$extWhere .= " AND u.user_name like '%".trim($_REQUEST['user_name'])."%' ";
		}
		
		$id = intval($_REQUEST['id']);
		if($id > 0){
			$extWhere = " and c.user_id = $id ";
			$_REQUEST['user_name'] = M("User")->where("id=".$id)->getField("user_name");
		}
		
		
		$rs_count = $GLOBALS['db']->getOne("select count(DISTINCT c.user_id) from ".DB_PREFIX."user_company c LEFT JOIN ".DB_PREFIX."user u ON u.id=c.user_id where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			
 			$list = $GLOBALS['db']->getAll("select c.*,u.user_name from ".DB_PREFIX."user_company c LEFT JOIN ".DB_PREFIX."user u ON u.id=c.user_id where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			$this->assign ( "page", $page );
		}
		
		$this->assign("list",$list);
		$this->display();
	}
	
	
	public function company() {
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$this->assign("user_info",$user_info);
		$company = M("UserCompany")->where("user_id=".$user_id)->find();
		$this->assign("company",$company);
		
		
		$this->display();
	}
	
	public function modify_company() {
		//系统安全选项检测
		$this->check_safe_item();

		$data['user_id'] = intval($_REQUEST['id']);
		$data['company_name'] = trim($_REQUEST['company_name']);
		$data['contact'] = trim($_REQUEST['contact']);
		$data['officetype'] = trim($_REQUEST['officetype']);
		$data['officedomain'] = trim($_REQUEST['officedomain']);
		$data['officecale'] = trim($_REQUEST['officecale']);
		$data['register_capital'] = trim($_REQUEST['register_capital']);
		$data['asset_value'] = trim($_REQUEST['asset_value']);
		$data['officeaddress'] = trim($_REQUEST['officeaddress']);
		$data['description'] = trim($_REQUEST['description']);
		$data['enterpriseName'] = trim($_REQUEST['enterpriseName']);;
		$data['bankLicense'] = trim($_REQUEST['bankLicense']);;
		$data['orgNo'] = trim($_REQUEST['orgNo']);;
		$data['businessLicense'] = trim($_REQUEST['businessLicense']);;
		$data['taxNo'] = trim($_REQUEST['taxNo']);;
		
		
		if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user_company WHERE user_id=".$data['user_id'])==0){
			//添加
			$GLOBALS['db']->autoExecute(DB_PREFIX."user_company",$data,"INSERT");
		}
		else{
			//编辑
			$GLOBALS['db']->autoExecute(DB_PREFIX."user_company",$data,"UPDATE","user_id=".$data['user_id']);
		}
		if($GLOBALS['db']->affected_rows() > 0){
			$user_info_re = array();
			$user_info_re['enterpriseName'] = $data['enterpriseName'];
			$user_info_re['bankLicense'] = $data['bankLicense'];
			$user_info_re['orgNo'] = $data['orgNo'];
			$user_info_re['businessLicense'] = $data['businessLicense'];
			$user_info_re['taxNo'] = $data['enterpriseName'];
			$GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info_re,"UPDATE","id=".intval($data['user_id']));
		}
		save_log("编辑".$data['user_id']."公司信息",1);
		$this->success(L("UPDATE_SUCCESS")); 
	}
	
	public function work_manage() {
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "user_id";
		}
		
		
		switch($sorder){
			case "user_name": 
				$order ="u.".$sorder;
				break;
			default : 
				$order ="c.".$sorder;
				break;
		}
		
		$extWhere = " 1=1 ";
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$extWhere .= " AND u.user_name like '%".trim($_REQUEST['user_name'])."%' ";
		}
		
		$id = intval($_REQUEST['id']);
		if($id > 0){
			$extWhere = " and c.user_id = $id ";
			$_REQUEST['user_name'] = M("User")->where("id=".$id)->getField("user_name");
		}
		
		
		$rs_count = $GLOBALS['db']->getOne("select count(DISTINCT c.user_id) from ".DB_PREFIX."user_work c LEFT JOIN ".DB_PREFIX."user u ON u.id=c.user_id where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			
 			$list = $GLOBALS['db']->getAll("select c.*,u.user_name from ".DB_PREFIX."user_work c LEFT JOIN ".DB_PREFIX."user u ON u.id=c.user_id where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			$this->assign ( "page", $page );
		}
		
		$this->assign("list",$list);
		$this->display();
	}
	
	public function work() {
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$this->assign("user_info",$user_info);
		$work_info = M("UserWork")->where("user_id=".$user_id)->find();
		$this->assign("work_info",$work_info);
		
		//地区列表
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		if($work_info){
			foreach($region_lv2 as $k=>$v)
			{
				if($v['id'] == intval($work_info['province_id']))
				{
					$region_lv2[$k]['selected'] = 1;
					break;
				}
			}
		}
		$this->assign("region_lv2",$region_lv2);
		
		if($work_info){
			$region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($work_info['province_id']));  //三级地址
			
			foreach($region_lv3 as $k=>$v)
			{
				if($v['id'] == intval($work_info['city_id']))
				{
					$region_lv3[$k]['selected'] = 1;
					break;
				}
			}
			
			$this->assign("region_lv3",$region_lv3);
		
		}
		$this->display();
	}
	
	public function modify_work() {
		//系统安全选项检测
		$this->check_safe_item();

		$data['user_id'] = intval($_REQUEST['id']);
		$data['office'] = trim($_REQUEST['office']);
		$data['jobtype'] = trim($_REQUEST['jobtype']);
		$data['province_id'] = intval($_REQUEST['province_id']);
		$data['city_id'] = intval($_REQUEST['city_id']);
		$data['officetype'] = trim($_REQUEST['officetype']);
		$data['officedomain'] = trim($_REQUEST['officedomain']);
		$data['officecale'] = trim($_REQUEST['officecale']);
		$data['position'] = trim($_REQUEST['position']);
		$data['salary'] = trim($_REQUEST['salary']);
		$data['workyears'] = trim($_REQUEST['workyears']);
		$data['workphone'] = trim($_REQUEST['workphone']);
		$data['workemail'] = trim($_REQUEST['workemail']);
		$data['officeaddress'] = trim($_REQUEST['officeaddress']);
		
		if(isset($_REQUEST['urgentcontact']))
			$data['urgentcontact'] = trim($_REQUEST['urgentcontact']);
		if(isset($_REQUEST['urgentrelation']))
			$data['urgentrelation'] = trim($_REQUEST['urgentrelation']);
		if(isset($_REQUEST['urgentmobile']))
			$data['urgentmobile'] = trim($_REQUEST['urgentmobile']);
		if(isset($_REQUEST['urgentcontact2']))
			$data['urgentcontact2'] = trim($_REQUEST['urgentcontact2']);
		if(isset($_REQUEST['urgentrelation2']))
			$data['urgentrelation2'] = trim($_REQUEST['urgentrelation2']);
		if(isset($_REQUEST['urgentmobile2']))
			$data['urgentmobile2'] = trim($_REQUEST['urgentmobile2']);
		
		if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user_work WHERE user_id=".$data['user_id'])==0){
			//添加
			$GLOBALS['db']->autoExecute(DB_PREFIX."user_work",$data,"INSERT");
		}
		else{
			//编辑
			$GLOBALS['db']->autoExecute(DB_PREFIX."user_work",$data,"UPDATE","user_id=".$data['user_id']);
		}
		$msg = trim($_REQUEST['msg'])==''?l("ADMIN_MODIFY_ACCOUNT_WORK"):trim($_REQUEST['msg']);
		
		save_log(l("ADMIN_MODIFY_ACCOUNT_WORK"),1);
		$this->success(L("UPDATE_SUCCESS")); 
	}
	
	/*银行卡管理*/
	public function bank_manage() {
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		
		switch($sorder){
			case "user_name": 
				$order ="u.".$sorder;
				break;
			case "bank_name":
				$order ="b.".$sorder;
				break;
			default : 
				$order ="a.".$sorder;
				break;
		}
		
		$extWhere = " 1=1 ";
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$extWhere .= " AND u.user_name like '%".trim($_REQUEST['user_name'])."%' ";
		}
		
		$id = intval($_REQUEST['id']);
		if($id > 0){
			$extWhere .= " and a.user_id = $id ";
			$_REQUEST['user_name'] = M("User")->where("id=".$id)->getField("user_name");
		}
		
		
		$rs_count = $GLOBALS['db']->getOne("select count(DISTINCT a.id) from ".DB_PREFIX."user_bank a LEFT JOIN ".DB_PREFIX."bank b ON a.bank_id=b.id LEFT JOIN ".DB_PREFIX."user u ON u.id=a.user_id where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			
 			$list = $GLOBALS['db']->getAll("select a.*,b.name as bank_name,u.user_name from ".DB_PREFIX."user_bank a LEFT JOIN ".DB_PREFIX."bank b ON a.bank_id=b.id LEFT JOIN ".DB_PREFIX."user u ON u.id=a.user_id where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			$this->assign ( "page", $page );
		}
		
		$this->assign("list",$list);
		$this->display();
	}
	public function de_bank() {
		$id = intval($_REQUEST['id']);
		$list = M("UserBank")->where('id='.$id)->delete(); // 删除
	
		if(!$list){
			$this->error("删除失败");
		}else{
			$this->success("删除成功");
		}
	}
	
	public function fund_management() {
		/*$title_arrays = array(
				"0" => "结存",
				"1" => "充值",
				"2" => "投标成功",
				"3" => "招标成功",
				"4" => "偿还本息",
				"5" => "回收本息",
				"6" => "提前还款",
				"7" => "提前回收",
				"8" => "申请提现",
				"9" => "提现手续费",
				"10" => "借款管理费",
				"11" => "逾期罚息",
				"12" => "逾期管理费",
				"13" => "人工操作",
				"14" => "借款服务费",
				"15" => "出售债权",
				"16" => "购买债权",
				"17" => "债权转让管理费",
				"18" => "开户奖励",
				"19" => "流标还返",
				"20" => "投标管理费",
				"21" => "投标逾期收入",
				"22" => "兑换",
				"23" => "邀请返利",
				"24" => "投标返利",
				"25" => "签到成功",
				"26" => "逾期罚金（垫付后）",
				"27" => "其他费用",
				"28" => "投资奖励",
				"26" => "红包奖励",
		);*/
		$title_arrays = load_auto_cache("cache_money_type",array("class"=>"money"));
		$this->assign ("title_array", $title_arrays );
		
		$cate =isset($_REQUEST ['cate'])? (intval($_REQUEST ['cate']) >= 0 ? intval($_REQUEST['cate']) : -1) : -1;
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_name":
				$order ="user_id";
				break;
			case "type_format":
				$order ="type";
				break;
			default :
				$order =$sorder;
				break;
		}
		$order = 'uml.'.$order;
		
		$extWhere = " 1=1 ";
		if(intval($_REQUEST["is_success"]))
		{
			$extWhere .= "";
		}
		if($cate>=0)
		{
			$extWhere .= " AND uml.type = ".$cate;
		}
		
		if(trim($_REQUEST['user_names'])!='')
		{
			$q = trim($_REQUEST['user_names']);
			$extWhere .= " and (u.user_name like '%".$q."%' or u.phone like '%".$q."%' or  AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%')";
		}

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d")+1*24*3600);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$extWhere .= " and uml.create_time >= $begin_time ";	
			} else if($begin_time==0) {
				$extWhere .= " and uml.create_time <= $end_time ";	
			} else {
				$extWhere .= " and uml.create_time between $begin_time and $end_time ";	
			}
		}
		
		$rs_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			$list = $GLOBALS['db']->getAll("select uml.*,u.user_name  from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			foreach($list as $k=>$v){
				$n=$list[$k]['type'];
				$list[$k]['type_format'] = $title_arrays[$n];
			}

			//总金额
			$sum['money'] = $GLOBALS['db']->getOne("select sum(uml.money) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			$this->assign ( "sum", $sum );		
			
			$this->assign ( "page", $page );
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'cate', $cate );
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display();
	}
		
	public function fund_management_deduct() {
		$this->assign ("main_title", '快速扣费日志' );
		$title_arrays = array('10'=>'融资风险管理费','14'=>'融资服务费','52'=>'尽职调查费','26'=>'逾期罚金（垫付后）', '27'=>'其他费用','55'=>'申购期利息','56'=>'投资活动返现');
		$this->assign ("title_array", $title_arrays );
		
		$cate =isset($_REQUEST ['cate'])? (intval($_REQUEST ['cate']) >= 0 ? intval($_REQUEST['cate']) : -1) : -1;
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_name":
				$order ="user_id";
				break;
			case "type_format":
				$order ="type";
				break;
			default :
				$order =$sorder;
				break;
		}

		$order = 'uml.'.$order;
		
		$extWhere = " 1=1 ";
		if(intval($_REQUEST["is_success"]))
		{
			$extWhere .= "";
		}
		if($cate>=0) {
			$extWhere .= " AND uml.type = ".$cate;
		} else {
			$extWhere .= " AND uml.type in(10,14,52,26,27,55,56)";
		}
		
		if(trim($_REQUEST['user_names'])!='')
		{
			$q = trim($_REQUEST['user_names']);
			$extWhere .= " and (u.user_name like '%".$q."%' or u.phone like '%".$q."%' or  AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%')";
		}

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d")+1*24*3600);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$extWhere .= " and uml.create_time >= $begin_time ";	
			} else if($begin_time==0) {
				$extWhere .= " and uml.create_time <= $end_time ";	
			} else {
				$extWhere .= " and uml.create_time between $begin_time and $end_time ";	
			}
		}
		
		$rs_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
		
			
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			$list = $GLOBALS['db']->getAll("select uml.*,u.user_name  from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			foreach($list as $k=>$v){
				$n=$list[$k]['type'];
				$list[$k]['type_format'] = $title_arrays[$n];
			}
			
			//总金额
			$sum['money'] = $GLOBALS['db']->getOne("select sum(uml.money) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			$this->assign ( "sum", $sum );		
				
			$this->assign ( "page", $page );
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'cate', $cate );
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display();
	}
		
    //申购期利息
	public function fund_management_wait() {
		$this->assign ("main_title", '申购期利息' );
        $title_arrays = array('55'=>'申购期利息');
        $type_str = '55';
        $this->list_other_fee($title_arrays, $type_str);
        $this->display('list_other_fee');
	}

    //申购期利息
	public function fund_management_user() {
		$this->assign ("main_title", '申购期收益' );
        $title_arrays = array('54'=>'申购期收益');
        $type_str = '54';

		// XHF 2016-7-17
		// 关联借款标的id从190开始
        $deal_list = $GLOBALS['db']->getAll("select id,name from ".DB_PREFIX."deal where id >=190 and deal_status in (4,5) order by id desc");
        if (!$deal_list && !count($deal_list)) {
            $deal_list = '';
        }
		$deal_id = isset($_REQUEST['deal_id'])? intval($_REQUEST['deal_id']) : -1;
		$this->assign ("deal_id", $deal_id );
		$this->assign ("deal_list", $deal_list );

        $this->list_other_fee($title_arrays, $type_str);
        $this->display('list_other_fee');
	}

    //投资活动返现
	public function fund_management_back() {
		$this->assign ("main_title", '投资活动返现' );
        $title_arrays = array('56'=>'投资活动返现');
        $type_str = '56';
        $this->list_other_fee($title_arrays, $type_str);
        $this->display('list_other_fee');
	}

    //提现手续费
    public function carry_fee() {
		$this->assign ("main_title", '提现手续费' );
		$title_arrays = array('9'=>'提现手续费');
        $type_str = '9';
        $this->list_other_fee($title_arrays, $type_str);
        $this->display('list_other_fee');
    }

    //其他费用列表
	public function list_other_fee($title_arrays, $type_str, $extW='') {
		$this->assign ("title_array", $title_arrays );
		$cate =isset($_REQUEST ['cate'])? (intval($_REQUEST ['cate']) >= 0 ? intval($_REQUEST['cate']) : -1) : -1;
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_name":
				$order ="user_id";
				break;
			case "type_format":
				$order ="type";
				break;
			default :
				$order =$sorder;
				break;
		}
		
		$extWhere = " 1=1 ".$extW;
		if(intval($_REQUEST["is_success"]))
		{
			$extWhere .= "";
		}

		$extWhere .= " AND type in ($type_str)";

        if (isset($_REQUEST['deal_id']) && intval($_REQUEST['deal_id'])>0) {
    		$extWhere .= " AND deal_id=".intval($_REQUEST['deal_id']);
        } else {
            $_REQUEST['deal_id'] = -1;
        }

		if(trim($_REQUEST['user_names'])!='')
		{
			$q = trim($_REQUEST['user_names']);
			$extWhere .= " and (u.user_name like '%".$q."%' or u.phone like '%".$q."%' or  AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%')";
		}

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d")+1*24*3600);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$extWhere .= " and uml.create_time >= $begin_time ";	
			} else if($begin_time==0) {
				$extWhere .= " and uml.create_time <= $end_time ";	
			} else {
				$extWhere .= " and uml.create_time between $begin_time and $end_time ";	
			}
		}
		
		$rs_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere");
        $money_count = $GLOBALS['db']->getOne("select sum(uml.money) from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			$list = $GLOBALS['db']->getAll("select uml.*,u.user_name  from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			foreach($list as $k=>$v){
				$n=$list[$k]['type'];
				$list[$k]['type_format'] = $title_arrays[$n];
			}
			
			$this->assign ( "page", $page );
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'cate', $cate );
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		$this->assign ( 'money_count', $money_count );
		
		$this->assign("list",$list);
		return;
	}

    //手动操作-快速充值
	public function hand_recharge() {
		$type_list = array(
			array('id'=>13, 'name'=>'线下充值'),
			array('id'=>57, 'name'=>'节假日活动返现'),
			array('id'=>64, 'name'=>'代提现'),
			array('id'=>65, 'name'=>'推荐奖励'),
			array('id'=>66, 'name'=>'其他'),
		);
		$this->assign("type_list", $type_list);
		$this->display();
	}
	
	//手动操作-POS充值
	public function pos_recharge() {
		if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
			$type = $_REQUEST['type'];
			if ($type == "confirm") {
				$this->update_pos_recharge();
			} else if ($type == "query") {
				$this->query_pos_recharge();
			}
		} else {
			$map[DB_PREFIX.'user.is_effect'] = array('eq',1);
			$this->getUserList(0,0,$map);
			$this->display();
		}
	}

	public function update_hand_recharge(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$type = intval($_REQUEST['type']);	//预留
		$money = floatval($_REQUEST['money']);
		$memo =trim($_REQUEST['memo']);

		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		
		if(trim($_REQUEST['money'])==""){
			$this->error(L("金额不能为空"));
		}
		
		if($money <= 0) {
			$this->error(L("金额应为正数"));
		}

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
	
		if($user_id>0) {
			//XHF 2016/9/10 线下充值接口创建订单
			if ($type == 13 || $type == 64) {
				// 查询系统中线下充值接口
				$payment_id = M("Payment")->where("class_name='Otherpay'")->getField("id");
				if (!$payment_id) {
					$this->error(L("线下充值接口不存在或未启用，请联系管理员"));
				}

				$order = array();
				$order['memo'] = $memo;
				$order['money'] = $money;
				$order['user_id'] = $user_id;
				$order['payment_id'] = $payment_id;
				$order['input_user_id'] = $adm_session['adm_id'];

				//开始生成订单
				$now = TIME_UTC;			
				$order['create_time'] = $now;
				$order['pay_time'] = $now;
				$order['create_date'] = to_date(TIME_UTC,"Y-m-d");
				$order['pay_date'] = to_date(TIME_UTC,"Y-m-d");
				$order['is_paid'] = 1;

				do {
					$order['notice_sn'] = TIME_UTC.rand(100,999);			
					$GLOBALS['db']->autoExecute(DB_PREFIX."payment_notice",$order,'INSERT','','SILENT');
					$order_id = intval($GLOBALS['db']->insert_id());
				} while($order_id==0);
			}

			$msg = trim($memo)==''?l("ADMIN_MODIFY_ACCOUNT"):trim($memo);
			modify_account(array('money'=>$money),$user_id,$msg,$type,$adm_session['adm_id']);

			save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			$this->error(L("用户不存在，或用户名输入错误"));
		}
	}
	
	// POS充值操作
	public function update_pos_recharge(){		
		//系统安全选项检测
		$this->check_safe_item(array('system_repair_mode'=>array()));

		$result = array('status'=>0, 'info'=>'');

		$user_name = trim($_REQUEST['user_name']); //系统唯一用户名
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		if(!$user_id) {
			$result['info'] = "用户不存在，或用户名输入错误";
			echo json_encode($result); exit;
		}

		if(trim($_REQUEST['money'])==""){
			$result['info'] = "金额不能为空";
			echo json_encode($result); exit;
		}
		$money = floatval($_REQUEST['money']);
		if($money <= 0){
			$result['info'] = "金额应为正数";
			echo json_encode($result); exit;
		}

		// 查询系统中有效的POS机支付接口
		$payment_id = M("Payment")->where("is_effect=1 and class_name='AllinpayPos'")->getField("id");
		if (!$payment_id) {
			$result['info'] = "POS机支付接口不存在或未启用，请联系管理员";
			echo json_encode($result); exit;
		}

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));

		$status = array('status'=>0,'info'=>'');
		$order = array();
		$order['memo'] = addslashes(htmlspecialchars(trim($_REQUEST['memo'])));
		$order['money'] = $money;
		$order['user_id'] = $user_id;
		$order['payment_id'] = $payment_id;
		$order['input_user_id'] = $adm_session['adm_id'];

		//开始生成订单
		$now = TIME_UTC;			
		$order['create_time'] = $now;
		$order['create_date'] = to_date(TIME_UTC,"Y-m-d");

		do {
			$order['notice_sn'] = TIME_UTC.rand(100,999);			
			$GLOBALS['db']->autoExecute(DB_PREFIX."payment_notice",$order,'INSERT','','SILENT');
			$order_id = intval($GLOBALS['db']->insert_id());
		}
		while($order_id==0);
	
		$result['status'] = 1;
		$result['info'] = $order['notice_sn'];
		echo json_encode($result); exit;
	}

	// POS充值结果查询
	public function query_pos_recharge() {
		$notice_sn = $_REQUEST['notice_sn'];

		// 查询订单号是否存在
		$res = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where notice_sn='{$notice_sn}' and is_paid=1");
		if ($res && count($res)) {
			$result['status'] = 1;
			$result['info']['pay_time'] = date("Y-m-d H:i", $res['pay_time']);
			$result['info']['outer_notice_sn'] = $res['outer_notice_sn'];
		}
		echo json_encode($result); exit;
	}

	//手动操作-快速扣款
	public function hand_overdue() {
		$this->display();
	}
	
	public function update_hand_overdue(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$type = intval($_REQUEST['type']);	
		$money = floatval($_REQUEST['money']);
		$memo =trim($_REQUEST['memo']);
		
		if(!in_array($type,array(10,14,27,52,53,55,56))){
			$this->error(L("不允许的类型"));
		}
		
		if($money <= 0){
			$this->error(L("金额应为正数"));
		}
		
		$money = -$money ;
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		
		if(trim($_REQUEST['money'])==""){
			$this->error(L("金额不能为空"));
		}
		
		if($user_id>0) {
			$msg = trim($memo)==''?l("ADMIN_MODIFY_ACCOUNT"):trim($memo);
			modify_account(array('money'=>$money),$user_id,$msg,$type);
				
			save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			$this->error(L("用户不存在，或用户名输入错误"));
		}
	}
	
	//手动操作-冻结资金
	public function hand_freeze() {
		$this->display();
	}
	
	/**
     * 添加冻结/解冻资金记录 XHF 2016-7-12
     */
	public function hand_freeze_index() {
        $this->assign("main_title", "冻结/解冻记录");
		$title_arrays = load_auto_cache("cache_money_type",array("class"=>"lock_money"));
		$this->assign ("title_array", $title_arrays );
		
        // XHF 2016-07-17
        // 资金冻结记录选择人工操作类型
		$cate =13;
		
        $status = isset($_REQUEST ['status'])? intval($_REQUEST ['status']) : -1;

		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}

		switch($sorder){
			case "user_name":
				$order ="user_id";
				break;
			case "type_format":
				$order ="type";
				break;
			default :
				$order =$sorder;
				break;
		}
		
		$extWhere = " 1=1 ";
		if(intval($_REQUEST["is_success"]))
		{
			$extWhere .= "";
		}
		if($cate>=0)
		{
			$extWhere .= " AND type = ".$cate;
		}
        if ($status == 1) {
			$extWhere .= " AND uml.lock_money >= 0";
        } else if ($status == 2) {
			$extWhere .= " AND uml.lock_money < 0";
        }
		
		if(trim($_REQUEST['user_names'])!='')
		{
			$q = trim($_REQUEST['user_names']);
			$extWhere .= " and (u.user_name like '%".$q."%' or u.phone like '%".$q."%' or  AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%')";
		}

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d")+1*24*3600);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$extWhere .= " and uml.create_time >= $begin_time ";	
			} else if($begin_time==0) {
				$extWhere .= " and uml.create_time <= $end_time ";	
			} else {
				$extWhere .= " and uml.create_time between $begin_time and $end_time ";	
			}
		}
		
		$rs_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_lock_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id where $extWhere");
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			$page = $p->show();
			$list = $GLOBALS['db']->getAll("select uml.*,u.user_name  from ".DB_PREFIX."user_lock_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows);
			
			foreach($list as $k=>$v){
				$n=$list[$k]['type'];
				$list[$k]['type_format'] = $title_arrays[$n];
			}
			
			$this->assign ( "page", $page );
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'cate', $cate );
		$this->assign ( 'status', $status );
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display("freeze");
	}

    public function update_hand_freeze(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$lock_money = floatval($_REQUEST['lock_money']);
		//XHF 2016/9/10 加入状态 62冻结63解冻
		$type = $lock_money>0? 62 : 63;
		
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		
		if($lock_money!=0){
			if($lock_money > 0 && $lock_money > D("User")->where('id='.$user_id)->getField("AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money")){
				$this->error("输入的冻结资金不得超过账户总余额");
			}
				
			if($lock_money < 0 && $lock_money < -D("User")->where('id='.$user_id)->getField("lock_money")){
				$this->error("输入的解冻资金不得大于已冻结的资金");
			}
				
			$money -=$lock_money;
		}
		
		$msg = trim($_REQUEST['msg'])==''?l("ADMIN_MODIFY_ACCOUNT"):trim($_REQUEST['msg']);
		modify_account(array('money'=>$money,'lock_money'=>$lock_money),$user_id,$msg,$type);
		if(floatval($_REQUEST['quota'])!=0){
			//$content = "您好，".app_conf("SHOP_TITLE")."审核部门经过综合评估您的信用资料及网站还款记录，将您的信用额度调整为：".D("User")->where("id=".$user_id)->getField('quota')."元";
				
			$group_arr = array(0,$user_id);
			sort($group_arr);
			$group_arr[] =  4;
				
			$sh_notice['shop_title'] = app_conf("SHOP_TITLE");							  // 网站名称
			$sh_notice['quota'] = D("User")->where("id=".$user_id)->getField('quota');    // 信用额度
			$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
			$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_QUOTA_TZ'",false);
			$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
			
			$msg_data['content'] = $sh_content;
			$msg_data['to_user_id'] = $user_id;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['type'] = 0;
			$msg_data['group_key'] = implode("_",$group_arr);
			$msg_data['is_notice'] = 4;
				
			$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
			$id = $GLOBALS['db']->insert_id();
			$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
		}
		save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
		$this->success(L("UPDATE_SUCCESS"));
	}
	
	//手动操作-信用积分
	public function hand_integral() {
		$this->display();
	}
	
	//手动操作-积分操作
	public function hand_integrals() {
		$this->display();
	}
	
	public function update_hand_integral(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$point = intval($_REQUEST['point']);
		$msg =trim($_REQUEST['msg']);
		
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		
		
		if($user_id>0)
		{
			$msg = trim($msg)==''?l("ADMIN_MODIFY_ACCOUNT"):trim($msg);
			modify_account(array('point'=>$point),$user_id,$msg,13);
				
			save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
			$this->success(L("UPDATE_SUCCESS"));
		}
		else
			$this->error(L("用户不存在，或用户名输入错误"));
	}
	
	public function update_hand_integrals(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$score = intval($_REQUEST['point']);
		$msg =trim($_REQUEST['msg']);
	
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
	
		if($user_id>0)
		{
			$msg = trim($msg)==''?l("ADMIN_MODIFY_ACCOUNT"):trim($msg);
			modify_account(array('score'=>$score),$user_id,$msg,13);
	
			save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
			$this->success(L("UPDATE_SUCCESS"));
		}
		else
			$this->error(L("用户不存在，或用户名输入错误"));
	}
	
	//手动操作-信用额度
	public function hand_quota() {
		$this->display();
	}
	
	public function update_hand_quota(){
		//系统安全选项检测
		$this->check_safe_item();

		$user_name = trim($_REQUEST['user_name']);
		$quota = floatval($_REQUEST['quota']);
		$msg =trim($_REQUEST['msg']);
		
		$user_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."user where user_name = '".$user_name."'");
		
		if($user_id>0)
		{
			$msg = trim($msg)==''?l("ADMIN_MODIFY_ACCOUNT"):trim($msg);
			modify_account(array('quota'=>$quota),$user_id,$msg,13);
				
			save_log(l("ADMIN_MODIFY_ACCOUNT"),1);
			$this->success(L("UPDATE_SUCCESS"));
		}
		else
			$this->error(L("用户不存在，或用户名输入错误"));
	}
	
	/*授权服务机构*/
	public function agencies_index()
	{
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(3,0,$map);
		$this->display ("agencies_index");
	}
	
	public function agencies_register()
	{
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		$cate_list = M("TopicTagCate")->findAll();
		$this->assign("cate_list",$cate_list);
		
		$field_list = M("UserField")->order("sort desc")->findAll();
		foreach($field_list as $k=>$v)
		{
			$field_list[$k]['value_scope'] = preg_split("/[ ,]/i",$v['value_scope']);
		}
		
		//地区列表
		
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		$this->assign("region_lv2",$region_lv2);
		
		$this->assign("field_list",$field_list);
		$this->display ("agencies_add");
	}
	
	public function agencies_insert() {
		//系统安全选项检测
		$this->check_safe_item();
		
		B('FilterString');
		$ajax = intval($_REQUEST['ajax']);
		$data = M(MODULE_NAME)->create ();

		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/agencies_add"));
	
		if(!check_empty($data['user_pwd']))
		{
			$this->error(L("USER_PWD_EMPTY_TIP"));
		}	
		if($data['user_pwd']!=$_REQUEST['user_confirm_pwd'])
		{
			$this->error(L("USER_PWD_CONFIRM_ERROR"));
		}
		
		if(!check_empty($data['idno']))
		{
			$this->error(sprintf(L("USER_EMPTY_ERROR"),L("IPS_IDENT_TYPE_1")));
		}
		
		if(!check_empty($data['real_name']))
		{
			$this->error(sprintf(L("USER_EMPTY_ERROR"),L("REAL_NAME")));
		}
		
		$_REQUEST ["user_type"] = 3 ;
		$_REQUEST ["idcardpassed"] = 1;
		$_REQUEST ["idcardpassed_time"] = TIME_UTC;
		
		$res = save_user($_REQUEST);
		$this->user_save_tip($res);
		$user_id = intval($res['user_id']);
		foreach($_REQUEST['auth'] as $k=>$v)
		{
			foreach($v as $item)
			{
				$auth_data = array();
				$auth_data['m_name'] = $k;
				$auth_data['a_name'] = $item;
				$auth_data['user_id'] = $user_id;
				M("UserAuth")->add($auth_data);
			}
		}
		
		
		foreach($_REQUEST['cate_id'] as $cate_id)
		{
			$link_data = array();
			$link_data['user_id'] = $user_id;
			$link_data['cate_id'] = $cate_id;
			M("UserCateLink")->add($link_data);
		}
		
		// 更新数据
		$log_info = $data['user_name'];
		save_log($log_info.L("INSERT_SUCCESS"),1);
		$this->success(L("INSERT_SUCCESS"));
	}
	
	public function agencies_edit() {		
		$id = intval($_REQUEST ['id']);
			
		$vo = get_user_info("*","id=".$id." AND is_delete= 0 ");
		$this->assign ( 'vo', $vo );

		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
			
		$field_list = M("UserField")->order("sort desc")->findAll();
		foreach($field_list as $k=>$v)
		{
			$field_list[$k]['value_scope'] = preg_split("/[ ,]/i",$v['value_scope']);
			$field_list[$k]['value'] = M("UserExtend")->where("user_id=".$id." and field_id=".$v['id'])->getField("value");
		}
		$this->assign("field_list",$field_list);
		
		$rs = M("UserAuth")->where("user_id=".$id." and rel_id = 0")->findAll();
		foreach($rs as $row)
		{
			$auth_list[$row['m_name']][$row['a_name']] = 1;
		}
		
		//地区列表
		$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
		foreach($region_lv2 as $k=>$v)
		{
			if($v['id'] == intval($vo['province_id']))
			{
				$region_lv2[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv2",$region_lv2);
		
		$region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['province_id']));  //三级地址
		foreach($region_lv3 as $k=>$v)
		{
			if($v['id'] == intval($vo['city_id']))
			{
				$region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("region_lv3",$region_lv3);
		
		$n_region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($vo['n_province_id']));  //三级地址
		foreach($n_region_lv3 as $k=>$v)
		{
			if($v['id'] == intval($vo['n_city_id']))
			{
				$n_region_lv3[$k]['selected'] = 1;
				break;
			}
		}
		$this->assign("n_region_lv3",$n_region_lv3);
		
		$this->assign("auth_list",$auth_list);
		$this->display ("agencies_edit");
	}
	
	public function agencies_update() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		
		$log_info = M(MODULE_NAME)->where("id=".intval($_REQUEST['id']))->getField("user_name");
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/agencies_edit",array("id"=>$_REQUEST['id'])));
		if(!check_empty($_REQUEST['user_pwd'])&&$_REQUEST['user_pwd']!=$_REQUEST['user_confirm_pwd'])
		{
			$this->error(L("USER_PWD_CONFIRM_ERROR"));
		}
		
		if(!check_empty($_REQUEST['idno']))
		{
			$this->error(sprintf(L("USER_EMPTY_ERROR"),L("IPS_IDENT_TYPE_1")));
		}
		
		if(!check_empty($_REQUEST['real_name']))
		{
			$this->error(sprintf(L("USER_EMPTY_ERROR"),L("REAL_NAME")));
		}
		
		$_REQUEST ["user_type"] = 3 ;
		$_REQUEST ["idcardpassed"] = 1;
		$_REQUEST ["idcardpassed_time"] = TIME_UTC;

		$res = save_user($_REQUEST,'UPDATE');
		$this->user_save_tip($res);
		
		//更新权限
		
		M("UserAuth")->where("user_id=".$data['id']." and rel_id = 0")->delete();
		foreach($_REQUEST['auth'] as $k=>$v)
		{
			foreach($v as $item)
			{
				$auth_data = array();
				$auth_data['m_name'] = $k;
				$auth_data['a_name'] = $item;
				$auth_data['user_id'] = $data['id'];
				M("UserAuth")->add($auth_data);
			}
		}
		//开始更新is_effect状态
		M("User")->where("id=".intval($_REQUEST['id']))->setField("is_effect",intval($_REQUEST['is_effect']));
		$user_id = intval($_REQUEST['id']);		
		M("UserCateLink")->where("user_id=".$user_id)->delete();
		foreach($_REQUEST['cate_id'] as $cate_id)
		{
			$link_data = array();
			$link_data['user_id'] = $user_id;
			$link_data['cate_id'] = $cate_id;
			M("UserCateLink")->add($link_data);
		}
		save_log($log_info.L("UPDATE_SUCCESS"),1);
		$this->success(L("UPDATE_SUCCESS"));
	}

	
	public function agencies_info() {
		if(intval($_REQUEST['is_effect'])!=-1 && isset($_REQUEST['is_effect']))
		{
			$map[DB_PREFIX.'user.is_effect'] = array('eq',intval($_REQUEST['is_effect']));
		}
		$this->getUserList(3,0,$map);
		$this->display ("agencies_info");
	}
	
	public function agencies_trash()
	{
		$this->getUserList(3,1,array());
		$this->display ("agencies_trash");
	}
	public function agencies_export_csv($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		//定义条件
		$map[DB_PREFIX.'user.is_delete'] = 0;

		if(intval($_REQUEST['group_id'])>0)
		{
			$map[DB_PREFIX.'user.group_id'] = intval($_REQUEST['group_id']);
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$map[DB_PREFIX.'user.user_name'] = array('like','%'.trim($_REQUEST['user_name']).'%');
		}
		if(trim($_REQUEST['email'])!='')
		{
			$map[DB_PREFIX.'user.email'] = array('like','%'.trim($_REQUEST['email']).'%');
		}
		if(trim($_REQUEST['mobile'])!='')
		{
			$map[DB_PREFIX.'user.mobile'] = array('like','%'.trim($_REQUEST['mobile']).'%');
		}
		if(trim($_REQUEST['pid_name'])!='')
		{
			$pid = M("User")->where("user_name='".trim($_REQUEST['pid_name'])."'")->getField("id");
			$map[DB_PREFIX.'user.pid'] = $pid;
		}
		
		$map[DB_PREFIX.'user.user_type'] = 3;
		
		$list = M(MODULE_NAME)
				->where($map)
				->join(DB_PREFIX.'user_level ON '.DB_PREFIX.'user.level_id = '.DB_PREFIX.'user_level.id')
				->field(DB_PREFIX.'user.*,'.DB_PREFIX.'user_level.name')
				->limit($limit)->findAll();


		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$user_value = array('id'=>'""','user_name'=>'""','money'=>'""','lock_money'=>'""','email'=>'""','mobile'=>'""','idno'=>'""','level_id'=>'""');
			if($page == 1)
	    	$content = iconv("utf-8","gbk","编号,用户名,可用余额,冻结金额,电子邮箱,手机号,身份证,会员等级");
	    	
	    	
	    	//开始获取扩展字段
	    	$extend_fields = M("UserField")->order("sort desc")->findAll();
	    	foreach($extend_fields as $k=>$v)
	    	{
	    		$user_value[$v['field_name']] = '""';
	    		if($page==1)
	    		$content = $content.",".iconv('utf-8','gbk',$v['field_show_name']);
	    	}   
	    	if($page==1) 	
	    	$content = $content . "\n";
	    	
	    	foreach($list as $k=>$v)
			{	
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['money'] = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
				$user_value['lock_money'] = iconv('utf-8','gbk','"' . number_format($v['lock_money'],2) . '"');
				$user_value['email'] = iconv('utf-8','gbk','"' . $v['email'] . '"');
				$user_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$user_value['idno'] = iconv('utf-8','gbk','"' . $v['idno'] . '"');
				$user_value['level_id'] = iconv('utf-8','gbk','"' . $v['name'] . '"');

				//取出扩展字段的值
				$extend_fieldsval = M("UserExtend")->where("user_id=".$v['id'])->findAll();
				foreach($extend_fields as $kk=>$vv)
				{
					foreach($extend_fieldsval as $kkk=>$vvv)
					{
						if($vv['id']==$vvv['field_id'])
						{
							$user_value[$vv['field_name']] = iconv('utf-8','gbk','"'.$vvv['value'].'"');
							break;
						}
					}
					
				}
			
				$content .= implode(",", $user_value) . "\n";
			}	
			
			
			header("Content-Disposition: attachment; filename=user_list.csv");
	    	echo $content;  
		}
		else
		{
			if($page==1)
			$this->error(L("NO_RESULT"));
		}
		
	}
	
	public function agencies_account_detail()
	{
		$user_id = intval($_REQUEST['id']);
		$user_info = M("User")->getById($user_id);
		$log_begin_time  = trim($_REQUEST['log_begin_time'])==''?0:to_timespan($_REQUEST['log_begin_time']);
		$log_end_time  = trim($_REQUEST['log_end_time'])==''?0:to_timespan($_REQUEST['log_end_time']);
		$t= trim($_REQUEST['t']) =="" ? "money": trim($_REQUEST['t']);
		
		$map['user_id'] = $user_id;
		if(trim($_REQUEST['log_info'])!='')
		{
			if($t=="" || $t=="quota")
			{
				$map['log_info'] = array('like','%'.trim($_REQUEST['log_info']).'%');	
			}else {
				$map['memo'] = array('like','%'.trim($_REQUEST['log_info']).'%');
			}		
		}
		
		if($log_end_time==0)
		{
			if($t=="" || $t=="quota")
			{
				$map['log_time'] = array('gt',$log_begin_time);	
			}else {
				$map['create_time'] = array('gt',$log_begin_time);
			}
		}
		elseif($log_begin_time > 0 || $log_end_time > 0){
			if($t==""  || $t=="quota")
			{
				$map['log_time'] = array('between',array($log_begin_time,$log_end_time));	
			}else {
				$map['create_time'] = array('between',array($log_begin_time,$log_end_time));
			}
		}
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		if($t=="money")
		{	//资金日志
			$model = M ("UserMoneyLog");
		}elseif($t=="freeze"){
			$model = M ("UserLockMoneyLog");
		}
		
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		
		
		$this->assign("t",$t);
		$this->assign("user_id",$user_id);
		$this->assign("user_info",$user_info);
		$this->display ();
		return;
	}
	
	
	

	public function fund_export_csv($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		//定义条件
		/*$title_arrays = array(
				"0" => "结存",
				"1" => "充值",
				"2" => "投标成功",
				"3" => "招标成功",
				"4" => "偿还本息",
				"5" => "回收本息",
				"6" => "提前还款",
				"7" => "提前回收",
				"8" => "申请提现",
				"9" => "提现手续费",
				"10" => "借款管理费",
				"11" => "逾期罚息",
				"12" => "逾期管理费",
				"13" => "人工操作",
				"14" => "借款服务费",
				"15" => "出售债权",
				"16" => "购买债权",
				"17" => "债权转让管理费",
				"18" => "开户奖励",
				"19" => "流标还返",
				"20" => "投标管理费",
				"21" => "投标逾期收入",
				"22" => "兑换",
				"23" => "邀请返利",
				"24" => "投标返利",
				"25" => "签到成功",
				"26" => "逾期罚金（垫付后）",
				"27" => "其他费用",
				"28" => "投资奖励",
				"26" => "红包奖励",
		);*/
		$title_arrays = load_auto_cache("cache_money_type",array("class"=>"money"));
		
		$cate =isset($_REQUEST ['cate'])? (intval($_REQUEST ['cate']) >= 0 ? intval($_REQUEST['cate']) : -1) : -1;
		$extWhere = " 1=1 ";
		
		if($cate>=0)
		{
			$extWhere .= " AND type = ".$cate;
		}
		
		if(trim($_REQUEST['user_names'])!='')
		{
			$extWhere .= " and u.user_name like '%".trim($_REQUEST['user_names'])."%'";
		}
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$extWhere .= " and uml.create_time >= $begin_time";
			} else if ($begin_time==0) {
				$extWhere .= " and uml.create_time <= $end_time";
			} else {
				$extWhere .= " and uml.create_time between $begin_time and $end_time";
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
		$list = $GLOBALS['db']->getAll("select uml.*,u.user_name  from ".DB_PREFIX."user_money_log uml left join ".DB_PREFIX."user u on uml.user_id=u.id  where $extWhere order by id desc  LIMIT ".$limit);
			
		foreach($list as $k=>$v){
			$n=$list[$k]['type'];
			$list[$k]['type_format'] = $title_arrays[$n];
		}
		if($list)
		{
			register_shutdown_function(array(&$this, 'fund_export_csv'), $page+1);
			$user_value = array('id'=>'""','user_id'=>'""','type_format'=>'""','money'=>'""','account_money'=>'""','memo'=>'""','create_time_ymd'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,会员名,类型,操作金额,余额,备注,操作时间");
			$content = $content . "\n";
			foreach($list as $k=>$v)
			{
				$fund_list = array();
				$fund_list['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$fund_list['user_name'] = iconv('utf-8','gbk','"' . get_user_name_reals($v['user_id']) . '"');
				$fund_list['type_format'] = iconv('utf-8','gbk','"' . $v['type_format'] . '"');
				$fund_list['money'] = iconv('utf-8','gbk','"' . format_price($v['money']) . '"');
				$fund_list['account_money'] = iconv('utf-8','gbk','"' . format_price($v['account_money']) . '"');
				$fund_list['memo'] = iconv('utf-8','gbk','"' . $v['memo'] . '"');
				$fund_list['create_time_ymd'] = iconv('utf-8','gbk','"' . $v['create_time_ymd'] . '"');
			
				$content .= implode(",", $fund_list) . "\n";
			}
			header("Content-Disposition: attachment; filename=fund_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	}
	
	private function user_save_tip($res){
		if($res['status']==0)
		{
			$error_field = $res['data'];
			if($error_field['error'] == EMPTY_ERROR)
			{
				if($error_field['field_name'] == 'user_name')
				{
					$this->error(L("USER_NAME_EMPTY_TIP"));
				}
				elseif($error_field['field_name'] == 'email')
				{
					$this->error(L("USER_EMAIL_EMPTY_TIP"));
				}
				elseif($error_field['field_name'] == 'mobile')
				{
					$this->error(L("USER_MOBILE_EMPTY_TIP"));
				}
				else
				{
					$this->error(sprintf(L("USER_EMPTY_ERROR"),$error_field['field_show_name']));
				}
			}
			if($error_field['error'] == FORMAT_ERROR)
			{
				if($error_field['field_name'] == 'user_name')
				{
					$this->error(L("USER_NAME_FORMAT_TIP"));
				}
				if($error_field['field_name'] == 'email')
				{
					$this->error(L("USER_EMAIL_FORMAT_TIP"));
				}
				if($error_field['field_name'] == 'mobile')
				{
					$this->error(L("USER_MOBILE_FORMAT_TIP"));
				}
				if($error_field['field_name'] == 'idno')
				{
					$this->error(L("USER_IDNO_FORMAT_TIP"));
				}
			}
			
			if($error_field['error'] == EXIST_ERROR)
			{
				if($error_field['field_name'] == 'user_name')
				{
					$this->error(L("USER_NAME_EXIST_TIP"));
				}
				if($error_field['field_name'] == 'email')
				{
					$this->error(L("USER_EMAIL_EXIST_TIP"));
				}
				if($error_field['field_name'] == 'mobile')
				{
					$this->error(L("USER_MOBILE_EXIST_TIP"));
				}
				if($error_field['field_name'] == 'idno')
				{
					$this->error(L("USER_IDNO_EXIST_TIP"));
				}
			}
		}
	}
	
	protected function write_log($msg='') {
		switch (ACTION_NAME) {
			case 'pos_recharge':
				return true; break;
			default:
		}
		parent::write_log($msg);
	}
}
?>