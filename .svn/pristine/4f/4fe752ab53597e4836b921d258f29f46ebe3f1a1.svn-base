<?php

/**
 * 梦想计划相关信息处理
 * 
 * TPL_SMS_DREAM_LOAD
 * 尊敬的用户${sh_notice.user_name}，您于${sh_notice.time}为梦想计划“${sh_notice.deal_name}”，存入金额${sh_notice.money}元。
 * TPL_SMS_DREAM_END
 * 尊敬的用户${sh_notice.user_name}，您于${sh_notice.time}结束梦想计划“${sh_notice.deal_name}”，收回本金${sh_notice.interest_money}元，收益${sh_notice.self_money}元。
 * TPL_SMS_DREAM_END_NOTICE
 * 尊敬的用户${sh_notice.dream_to_user_name}，梦想计划用户${sh_notice.user_name}结束一个计划“${sh_notice.deal_name}”，收回本金${sh_notice.interest_money}元，收益${sh_notice.self_money}元。
 * 
 * 用户资金日志类别:
 * 梦想存钱,57
 * 梦想转账,58
 * 梦想结存,59
 * 梦想收益结存,60
 * 
 * 常量定义 DREAM_OPEN=1
 * public/sys_config.php
 * uc/uc_cate.html,uc_dream_index.html,uc_dream_list.html,module/uc_dream.php
 * SHOW_DREAM
 * 
 */

/** 
 * @author Admin 
 * Date: 2016/8/12
 *
 * 添加个人梦想计划相关函数
 * Date: 2016-7-25
 */ 


require_once 'deal_func.php';
require_once APP_ROOT_PATH."system/libs/user.php";

/**
 * 个人梦想计划处理函数
 * Admin 2016/8/12
 */
function dobid2_dream($deal_id,$bid_money,$bid_paypassword,$is_pc=0){
	$root = check_dobid2_dream($deal_id,$bid_money,$bid_paypassword,$is_pc);

	if ($root["status"] == 0){
		return $root;
	} elseif($root["status"] == 2){
		$root['jump'] = APP_ROOT."/index.php?ctl=collocation&act=RegisterCreditor&deal_id=$deal_id&user_id=".$GLOBALS['user_info']['id']."&bid_money=".$root['bid_money']."&bid_paypassword=$bid_paypassword"."&from=".$GLOBALS['request']['from']."&ecv_id=0";		
		$root['jump'] = str_replace("/mapi", "", SITE_DOMAIN.$root['jump']);
		return $root;
	}

	$root["status"] = 0;
	$bid_money = $root['bid_money'];
	$bid_paypassword = strim($bid_paypassword);

	if($bid_money > $GLOBALS['user_info']['money']){
		$root["status"] = 3;
		$root["show_err"] = "账户余额不足";
		return $root;
	}

	$data['deal_id'] = $deal_id;
	$data['user_id'] = $GLOBALS['user_info']['id'];
	$data['user_name'] = $GLOBALS['user_info']['user_name'];
	$data['index'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream_load where deal_id=".$deal_id." and user_id=".$GLOBALS['user_info']['id'])+1;
	$data['money'] = $bid_money;
	$data['create_time'] = TIME_UTC;
	$data['create_date'] = date('Y-m-d', TIME_UTC);

	$GLOBALS['db']->autoExecute(DB_PREFIX."deal_dream_load",$data,"INSERT");
	$load_id = $GLOBALS['db']->insert_id();

	if($load_id > 0){
		//更改用户资金记录
		$user_msg = '梦想计划存钱:'.$root['deal']['name'];
		modify_account(array('money'=>-($bid_money)),$GLOBALS['user_info']['id'],$user_msg,57);
		//资金转账至关联用户
		$dream_to_user_msg = '用户'.$GLOBALS['user_info']['user_name'].'梦想计划存钱:'.$root['deal']['name'];
		modify_account(array('money'=>+($bid_money)),$root['deal']['dream_to_user'],$dream_to_user_msg,58);
		
		//用户资金变动通知
		if(app_conf('SMS_ON')==1){
			//尊敬的用户${sh_notice.user_name}，您于${sh_notice.time}为梦想计划“${sh_notice.deal_name}”，存入金额${sh_notice.money}元。
			$load_tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_DREAM_LOAD'",false);
			$tmpl_content = $load_tmpl['content'];
			$notice['user_name'] = $GLOBALS['user_info']['user_name'];
			$notice['deal_name'] = $root['deal']['name'];
			$notice['money'] = number_format($bid_money);
			$notice['time'] = to_date(TIME_UTC,"Y年m月d日 H:i");
			
			$GLOBALS['tmpl']->assign("notice",$notice);
			
			$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest'] = $GLOBALS['user_info']['mobile'];
			$msg_data['send_type'] = 0;
			$msg_data['title'] = $root['deal']['name']."梦想计划通知";
			$msg_data['content'] = addslashes($msg);
			$msg_data['send_time'] = 0;
			$msg_data['is_send'] = 0;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['user_id'] =  $GLOBALS['user_info']['id'];
			$msg_data['is_html'] = $load_tmpl['is_html'];

			$msg_data['template_id'] = $tmpl['id'];
			$msg_data['datas'] = serialize(array(
				'user_name' => $notice['user_name'],
				'time' => $notice['time'],
				'deal_name' => $notice['deal_name'],
				'money' => $notice['money']
			));

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
		}

		//更改个人梦想数据
		$data_dream['update_time'] = TIME_UTC;
		$data_dream['update_date'] = date('Y-m-d',TIME_UTC);
		$data_dream['load_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_dream_load where deal_id=".$deal_id);
		if ($data_dream['load_money'] == $root['deal']['dream_amount']) {
			$data_dream['status'] = 2;
			$data_dream['success_time'] = $data_dream['update_time'];
			$data_dream['success_date'] = $data_dream['update_date'];
		}
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal_dream",$data_dream,"UPDATE","id=".$deal_id);

		$root["show_err"] = "处理成功";
		$root["status"] = 1;//0:出错;1:正确;
		return $root;
	} else {
		$root["show_err"] = "服务器忙";
		return $root;
	}
}

/**
 * 个人梦想计划检测函数
 * Admin 2016/8/12
 */
function check_dobid2_dream($deal_id,$bid_money,$bid_paypassword,$is_pc=0){	
	$root = array();
	$root["status"] = 0;//0:出错;1:正确;

	$bid_paypassword = strim($bid_paypassword);

	if(!$GLOBALS['user_info']){
		$root['status'] = 2;
		$root["show_err"] = $GLOBALS['lang']['PLEASE_LOGIN_FIRST'];
		return $root;
	}

	if($bid_paypassword==""){
		$root["show_err"] = $GLOBALS['lang']['PAYPASSWORD_EMPTY'];
		return $root;
	}
	
	if(md5($bid_paypassword) != $GLOBALS['user_info']['paypassword']){
		$root["show_err"] = $GLOBALS['lang']['PAYPASSWORD_ERROR'];
		return $root;
	}
	
	if(!check_ipop_limit(CLIENT_IP,"deal_dobid",intval(app_conf("SUBMIT_DELAY")))) {
		$root["show_err"] =  $GLOBALS['lang']['SUBMIT_TOO_FAST'];
	}
	
	$deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_dream where is_effect=1 and is_delete=0 and id=".$deal_id." and user_id=".$GLOBALS['user_info']['id']);
	if(!$deal){
		$root["show_err"] = "无效的梦想计划";
		return $root;
	}


	if ($deal['status'] > 1 || $deal['load_money'] >= $deal['dream_amount']) {
		$root["show_err"] = "已完成的梦想计划";
		return $root;
	}
	
	if ($deal['min_loan_money'] > 0 && $bid_money < $deal['min_loan_money']) {
		$root["show_err"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
		return $root;
	} else if ($bid_money <= 0){
		$root["show_err"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
		return $root;
	}

	if(($bid_money * 100) % 100 != 0){
		$root["show_err"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
		return $root;
	}

	if(floatval($deal['max_loan_money']) >0){
		if($bid_money > floatval($deal['max_loan_money'])){
			$root["show_err"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
			return $root;
		}
	}


	//判断所投的钱是否超过了剩余投标额度
	$remain_money = $deal['dream_amount'] - $deal['load_money'];
	if($bid_money > $remain_money) {
		$root["show_err"] = "超过了剩余额度,".number_format($remain_money,2)."元";
		return $root;
	}
	
	$root["bid_money"] = $bid_money;	
	$root['status'] = 1;
	$root["deal"] = $deal;

	return $root;
}

/**
 * 个人梦想计划结束处理函数
 * Admin 2016/8/15
 */
function doend_dream($deal_id){
	$root = array();
	$root["status"] = 0;//0:出错;1:正确;

	if(!$GLOBALS['user_info']){
		$root['status'] = 2;
		$root["show_err"] = $GLOBALS['lang']['PLEASE_LOGIN_FIRST'];
		return $root;
	}
	
	if(!check_ipop_limit(CLIENT_IP,"deal_dobid",intval(app_conf("SUBMIT_DELAY")))) {
		$root["show_err"] =  $GLOBALS['lang']['SUBMIT_TOO_FAST'];
	}
	
	$deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_dream where is_effect=1 and is_delete=0 and id=".$deal_id." and user_id=".$GLOBALS['user_info']['id']);
	if(!$deal){
		$root["show_err"] = "无效的梦想计划";
		return $root;
	}

	if ($deal['status'] != 2) {
		$root["show_err"] = "无法进行当前操作";
		return $root;
	}


	$deal_loads = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_dream_load where deal_id=".$deal_id." and user_id=".$GLOBALS['user_info']['id']);
	$interest_money = 0;

	//梦想计划存入明细更新
	foreach ($deal_loads as $k=>$v) {
		$space = interval_monnth_and_days($v['create_time'], TIME_UTC);
		$data['space_total_days'] = $space['total_days'];
		$data['space_month'] = $space['month'];
		$data['space_days'] = $space['days'];
		$data['end_time'] = TIME_UTC;
		$data['end_date'] = date('Y-m-d', TIME_UTC);
		$data['interest_money'] = $space['total_days'] * $v['money'] * $deal['rate'] / (100*12*30);
		$data['is_over'] = 1;
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal_dream_load",$data,"UPDATE","id=".$v['id']);

		$interest_money += $data['interest_money'];
	}

	//梦想计划数据更新
	$data_dream['update_time'] = TIME_UTC;
	$data_dream['update_date'] = date('Y-m-d', TIME_UTC);
	$data_dream['end_time'] = $data_dream['update_time'];
	$data_dream['end_date'] = $data_dream['update_date'];
	$data_dream['status'] = 0;
	$data_dream['is_normal'] = 1;

	$GLOBALS['db']->autoExecute(DB_PREFIX."deal_dream",$data_dream,"UPDATE","id=".$deal_id);


	if($GLOBALS['db']->affected_rows() > 0) {
		$user_msg = '梦想计划结存:'.$deal['name'];
		modify_account(array('money'=>($deal['dream_amount'])),$GLOBALS['user_info']['id'],$user_msg,59);
		modify_account(array('money'=>($interest_money)),$GLOBALS['user_info']['id'],$user_msg,60);

		
		if(app_conf('SMS_ON')==1){
			//尊敬的用户${sh_notice.user_name}，您于${sh_notice.time}结束梦想计划“${sh_notice.deal_name}”，收回本金${sh_notice.self_money}元，收益${sh_notice.interest_money}元。
			$load_tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_DREAM_END'",false);
			$tmpl_content = $load_tmpl['content'];
			$notice['user_name'] = $GLOBALS['user_info']['user_name'];
			$notice['deal_name'] = $deal['name'];
			$notice['interest_money'] = number_format($interest_money);
			$notice['self_money'] = number_format($deal['dream_amount']);
			$notice['time'] = to_date(TIME_UTC,"Y年m月d日 H:i");
			
			$GLOBALS['tmpl']->assign("notice",$notice);
			
			$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest'] = $GLOBALS['user_info']['mobile'];
			$msg_data['send_type'] = 0;
			$msg_data['title'] = $root['deal']['name']."梦想计划通知";
			$msg_data['content'] = addslashes($msg);
			$msg_data['send_time'] = 0;
			$msg_data['is_send'] = 1;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['user_id'] =  $GLOBALS['user_info']['id'];
			$msg_data['is_html'] = $load_tmpl['is_html'];

			$msg_data['template_id'] = $tmpl['id'];
			$msg_data['datas'] = serialize(array(
				'user_name' => $notice['user_name'],
				'time' => $notice['time'],
				'deal_name' => $notice['deal_name'],
				'interest_money' => $notice['interest_money'],
				'self_money' => $notice['self_money']
			));

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
		}


		//梦想计划关联用户资金修改
		$dream_to_user_msg = '用户'.$GLOBALS['user_info']['user_name'].'梦想计划结存:'.$deal['name'];
		modify_account(array('money'=>-($deal['dream_amount'])),$deal['dream_to_user'],$dream_to_user_msg,58);

		if(app_conf('SMS_ON')==1){
			//尊敬的用户${sh_notice.dream_to_user_name}，梦想计划用户${sh_notice.user_name}结束一个计划“${sh_notice.deal_name}”，收回本金${sh_notice.self_money}元，收益${sh_notice.interest_money}元。
			$load_tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_DREAM_END_NOTICE'",false);
			$tmpl_content = $load_tmpl['content'];
			$notice['dream_to_user_name'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$deal['dream_to_user']);
			$notice['user_name'] = $GLOBALS['user_info']['user_name'];
			$notice['deal_name'] = $deal['name'];
			$notice['interest_money'] = number_format($interest_money);
			$notice['self_money'] = number_format($deal['dream_amount']);
			$notice['time'] = to_date(TIME_UTC,"Y年m月d日 H:i");
			
			$GLOBALS['tmpl']->assign("notice",$notice);
			
			$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest'] = $GLOBALS['db']->getOne("select mobile from ".DB_PREFIX."user where id=".$deal['dream_to_user']);
			$msg_data['send_type'] = 0;
			$msg_data['title'] = $root['deal']['name']."梦想计划通知";
			$msg_data['content'] = addslashes($msg);
			$msg_data['send_time'] = 0;
			$msg_data['is_send'] = 1;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['user_id'] =  $deal['dream_to_user'];
			$msg_data['is_html'] = $load_tmpl['is_html'];

			$msg_data['template_id'] = $tmpl['id'];
			$msg_data['datas'] = serialize(array(
				'dream_to_user_name' => $notice['dream_to_user_name'],
				'user_name' => $notice['user_name'],
				'time' => $notice['time'],
				'deal_name' => $notice['deal_name'],
				'interest_money' => $notice['interest_money'],
				'self_money' => $notice['self_money']
			));

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
		}


		$root["show_err"] = "处理成功";
		$root["status"] = 1;//0:出错;1:正确;
		return $root;
	} else {
		$root["show_err"] = "服务器忙";
		return $root;
	}
}

?>