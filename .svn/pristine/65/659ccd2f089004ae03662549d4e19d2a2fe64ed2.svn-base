<?php

/**
 * 新增模块,个人梦想创建
 */
require_once APP_ROOT_PATH.'app/Lib/uc.php';
require_once APP_ROOT_PATH.'app/Lib/deal_dream.php';
class uc_dreamModule extends SiteBaseModule
{
	/**
	 * 显示个人梦想计划列表
	 */
	public function index()
	{
		$GLOBALS['tmpl']->assign("page_title","梦想计划");
		$GLOBALS['tmpl']->assign("post_title","梦想计划");	
		//分页
		$page = intval($_REQUEST['p']);
		if($page==0) { $page = 1; }

		$page_size = app_conf("DREAM_PAGE_SIZE");

		$limit = (($page-1)*$page_size).",".$page_size;
		$user_id = intval($GLOBALS['user_info']['id']);
		$extw = " is_delete = 0 and is_effect=1 and user_id=".$user_id;

		$count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where ".$extw);

		$list = array();
		if($count > 0){
			$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_dream where ".$extw." order by id desc limit ".$limit);			
			foreach($list as $k=>&$v)			
			{
				$v['index'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where ".$extw." and id<=".$v['id']);
				$v['create_time_format'] = date('Y-m-d H:i', $v['create_time']);
				$v['dream_money_format'] = number_format($v['dream_amount'], 0).'元';
				$v['load_money_format'] = number_format($v['load_money'], 0).'元';
				$v['progress'] = number_format(100 * ($v['load_money']/$v['dream_amount']),1).'%';
				//计算收益
				$dream_load_list = $GLOBALS['db']->getAll("select money,create_time,interest_money from ".DB_PREFIX."deal_dream_load where deal_id=".$v['id']);
				$interest_money = 0;
				for ($i=0; $i<count($dream_load_list); $i++) {
					if ($v['status'] == 1 || $v['status'] == 2) {
						$days = interval_days($dream_load_list[$i]['create_time'], TIME_UTC);
						$money = $dream_load_list[$i]['money'];
						$interest_money += $days * $money * $v['rate'] / (100*12*30); 
					} else {
						$interest_money += $dream_load_list[$i]['interest_money']; 
					}
				}
				$v['interest_money_format'] = number_format($interest_money, 2).'元';
			}
		}
		$page = new Page($count,$page_size);   //初始化分页对象 		
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		$GLOBALS['tmpl']->assign("dream_list",$list);
		$GLOBALS['tmpl']->assign("user_money",$GLOBALS['user_info']['money']);
	
		$GLOBALS['tmpl']->assign("inc_file","inc/uc/uc_dream_index.html");
		$GLOBALS['tmpl']->display("page/uc.html");	
	}
	

	/**
	 * 显示单条梦想相关记录
	 */
	public function item()
	{
		$id = intval($_REQUEST['id']);
		if ($id<0) {
			//
		}

		$GLOBALS['tmpl']->assign("page_title","梦想进度");
		$GLOBALS['tmpl']->assign("post_title","梦想进度");	
		
		//分页
		$page = intval($_REQUEST['p']);
		if($page==0)
		$page = 1;
		$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
		$user_id = intval($GLOBALS['user_info']['id']);
		$extw = "";

		$sql_count = "select count(*) from ".DB_PREFIX."deal_dream_load where deal_id=".$id;
		$sql = "select * from ".DB_PREFIX."deal_dream_load where deal_id=".$id." order by id desc limit ".$limit;

		$count = $GLOBALS['db']->getOne($sql_count);
		$total_money = 0; //累计金额

		//第几个
		$index = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where id<=".$id." and user_id=".$GLOBALS['user_info']['id']);
		//梦想名称
		$deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_dream where id=".$id);
		//待存金额
		$deal['load_remain'] = $deal['dream_amount'] - $deal['load_money'];
		//用户余额
		$deal['user_money'] = $GLOBALS['db']->getOne("select AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') from ".DB_PREFIX."user where id=".$user_id);
		

		$list = array();
		if($count > 0){
			$list = $GLOBALS['db']->getAll($sql);			
			foreach($list as $k=>&$v)			
			{
				$v['index'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream_load where id<=".$v['id']." and deal_id=".$id);
				$v['create_time_format'] = date('Y-m-d H:i', $v['create_time']);
				$v['money_format'] = number_format($v['money'], 2).'元';
				$total_money = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_dream_load where deal_id=".$id." and id <= ".$v['id']);
				$v['total_money_format'] = number_format($total_money, 2).'元';
				if ($deal['status'] == 1 || $deal['status'] == 2) {
					$interest_money = interval_days($v['create_time'], TIME_UTC) * $v['money'] * $deal['rate'] / (100*12*30);
				} else {
					$interest_money = $v['interest_money'];
				}				
				$v['interest_money_format'] = number_format($interest_money, 3).'元';
			}
		}

		$page = new Page($count,app_conf("PAGE_SIZE"));   //初始化分页对象
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		$GLOBALS['tmpl']->assign("list",$list);
		$GLOBALS['tmpl']->assign("id",$id);
		$GLOBALS['tmpl']->assign("index",$index);
		$GLOBALS['tmpl']->assign("deal",$deal);
	
		$GLOBALS['tmpl']->assign("inc_file","inc/uc/uc_dream_list.html").'%';
		$GLOBALS['tmpl']->display("page/uc.html");	
	}


	/**
	 * 添加个人梦想
	 */
	public function create() {
		$ajax = intval($_REQUEST["ajax"]);
		$step = trim($_REQUEST["step"]);
		$dream_name = trim($_REQUEST['dream_name']);
		$dream_amount = intval(trim($_REQUEST['dream_amount']));
		$save_money = intval(trim($_REQUEST['save_money']));

	    $status = array('status'=>0, 'show_err'=>'', 'info'=>'');

		//验证数据是否合法
		$dream_name_encode = unicode_encode($dream_name);

		if ($dream_name == "") {
			$status['info'] = "梦想名称不能为空";
			ajax_return($status);
		} else if (preg_match("/[`~!@#$%^&*\(\)\{\}\[\]\:\;\'\"\?\<\>]/u", $dream_name_encode)) {
			$status['info'] = "请输入4-20个中文,字母,数字等合法字符";
			ajax_return($status);
		}
		//梦想名称是否重复
		if ($GLOBALS['db']->getOne("select id from ".DB_PREFIX."deal_dream where name='".$dream_name."' and user_id=".$GLOBALS['user_info']['id']." order by id desc") > 0) {
			$status['info'] = "不能创建相同的梦想名称";
			ajax_return($status);
		}

		if ($dream_amount == 0) {
			$status['info'] = "梦想预算不能为0";
			ajax_return($status);
		}
		if ($save_money < 0) {
			$status['info'] = "启动金额不正确";
			ajax_return($status);
		}
		if ($save_money > $dream_amount) {
			$status['info'] = "启动金额能大于梦想预算";
			ajax_return($status);
		}


		if ($step == "one") {
			$GLOBALS['tmpl']->assign("dream_name", $dream_name);
			$GLOBALS['tmpl']->assign("dream_amount", $dream_amount);
			$GLOBALS['tmpl']->assign("bidmoney", $save_money);
			$status['status'] = 1;
			$status['jump'] = $GLOBALS['tmpl']->fetch("page/bid.html");

			ajax_return($status);
		} else if ($step == "two") {
			//判断用户是否登录	
			if(!$GLOBALS['user_info']){
				$status['status'] = 2;
				$status['info'] = $GLOBALS['lang']['PLEASE_LOGIN_FIRST'];
				ajax_return($status); 
			}

			$bid_money = trim($_REQUEST["bid_money"]);
			$bid_paypassword = strim(FW_DESPWD($_REQUEST['bid_paypassword']));

			//支付密码判断
			if($bid_paypassword==""){
				$status['info'] = $GLOBALS['lang']['PAYPASSWORD_EMPTY'];
				ajax_return($status); 
			}
			
			if(md5($bid_paypassword) != $GLOBALS['user_info']['paypassword']){
				$status['info'] = $GLOBALS['lang']['PAYPASSWORD_ERROR'];
				ajax_return($status); 
			}

			//支付金额判断
			if(($bid_money * 100) % 100 != 0){
				$status['info'] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
				ajax_return($status);
			}

			if($bid_money > $GLOBALS['user_info']['money']){
				$status["status"] = 3;
				$status['info'] = "余额不足，请先去充值";
				$status['jump'] = url("index","uc_money#incharge");
				ajax_return($status);
			}


			//创建编号
	        $last_dream_sn = $GLOBALS['db']->getOne("select dream_sn from ".DB_PREFIX."deal_dream order by id desc limit 1");
			$latest_sn = rand(1,9);

	        if ($last_dream_sn) {
	            if (preg_match("/".date('Ymd',TIME_UTC)."/",str_replace("DM","20",$last_dream_sn))) {
	                $latest_sn = intval(substr($last_dream_sn,9))+1;
	            }
	        }
	        $dream_sn = 'DM'.date('Ymd',TIME_UTC).str_pad($latest_sn,3,0,STR_PAD_LEFT);
	        $dream_sn = str_replace("DM20","DM",$dream_sn);

			//创建一个梦想计划
			$data['name'] = $dream_name;
			$data['user_id'] = $GLOBALS['user_info']['id'];
			$data['dream_to_user'] = app_conf("DREAM_TO_USER");
			$data['dream_amount'] = $dream_amount;
			$data['index'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where user_id=".$GLOBALS['user_info']['id']) + 1;
			$data['create_time'] = TIME_UTC;
			$data['create_date'] = date('Y-m-d', TIME_UTC);
			$data['rate'] = app_conf("DREAM_DEFAULT_RATE");
			$data['dream_sn'] = $dream_sn;
			$data['update_time'] = $data['create_time'];
			$data['update_date'] = $data['create_date'];

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_dream",$data,"INSERT","");
	    	if(!$GLOBALS['db']->affected_rows()){
	    		$status['info'] = "服务器忙，请稍后再试！";
				ajax_return($status);
	    	}

	    	$id = $GLOBALS['db']->insert_id();
			$status = dobid2_dream($id,$bid_money,$bid_paypassword,1);


			$status['info'] = $status['show_err'];

			//0错误 1正常 2未登录 3余额不足
			if ($status['status'] == 1) {
				$status['info'] = "创建成功";
			} else if($status['status'] == 3) {
				$status['info'] = "余额不足，请先去充值";
				$status['jump'] = url("index","uc_money#incharge");
			}

			ajax_return($status);
		}
	}


	/**
	 * 为梦想计划存钱
	 */
	public function dosave(){
		$ajax = intval($_REQUEST["ajax"]);

		$id = intval($_REQUEST['id']);
		$step = isset($_REQUEST['step'])? trim($_REQUEST['step']) : "";
		$save_money = intval($_REQUEST['save_money']);

		if ($step == "one") {
			$GLOBALS['tmpl']->assign("bidmoney", $save_money);
			$GLOBALS['tmpl']->assign("id", $id);
			$status['status'] = 1;
			$status['jump'] = $GLOBALS['tmpl']->fetch("page/bid.html");

			ajax_return($status);
		} else if ($step == "two") {
			$bid_id = trim($_REQUEST["bid_id"]);
			$bid_money = trim($_REQUEST["bid_money"]);
			$bid_paypassword = strim(FW_DESPWD($_REQUEST['bid_paypassword']));
			$status = dobid2_dream($bid_id,$bid_money,$bid_paypassword,1);

			$status['info'] = $status['show_err'];

			//0错误 1正常 2未登录 3余额不足
			if ($status['status'] == 1) {
				$status['info'] = "存入成功";
			} elseif($status['status'] == 3) {
				$status['info'] = "余额不足，请先去充值";
				$status['jump'] = url("index","uc_money#incharge");
			}

			ajax_return($status);
		}
	}


	/**
	 * 结束一个梦想计划
	 */
	public function doend(){
		$ajax = intval($_REQUEST["ajax"]);

		$id = intval($_REQUEST['id']);

		$status = doend_dream($id);
		$status['info'] = $deal['show_err'];

		if ($status['status'] == 1) {
			$status['info'] = "操作成功";
		}

		ajax_return($status); 
	}
}
?>