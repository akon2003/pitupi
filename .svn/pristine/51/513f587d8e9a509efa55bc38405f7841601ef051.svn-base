<?php

/** 
 * common.php 扩展
 * 
 * 此文件添加基于 common.php 函数的扩展
 *
 * @author Admin 
 * Date: 2016-7-13
 */ 

require_once 'common.php';


/**
 * 生成还款计划和回款计划
 * 基于 make_repay_plan 修改
 * 针对新手专享标,区别于普通标,投标时即生成还款计划和回款计划
 * @user_id 投标用户
 * 标的无放款时间,需要另行设置
 * 另行建表 deal_repay_ext
 * Admin 2016-7-13
 */
function make_repay_plan_new($deal,$user_id){
    if (!$user_id) { return; }
	$loantype = intval($deal['loantype']);
	$LoanModule = LoadLoanModule($loantype);

	$list = $LoanModule->make_repay_plan($deal);

	$total_money = array();
	foreach($list as $i=>$load_repay){
		if($old_info = $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."deal_repay_ext WHERE deal_id=".$deal['id']." AND repay_time=".$load_repay['repay_time']." and to_user_id=".$user_id." ")){
			$repay_id = $old_info['id'];
			if($old_info['has_repay']==0){
				$load_repay['l_key'] = $i;
				$load_repay['status'] = 0;
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."deal_repay_ext",$load_repay,"UPDATE","deal_id=".$deal['id']." AND repay_time=".$load_repay['repay_time']." AND to_user_id=".$user_id);
			}
			else{
				unset($load_repay['self_money']);
				unset($load_repay['repay_money']);
				unset($load_repay['has_repay']);
				unset($load_repay['manage_money']);
				unset($load_repay['manage_money_rebate']);
				$GLOBALS['db']->query("UPDATE FROM ".DB_PREFIX."deal_repay_ext SET l_key='".$i."' WHERE deal_id=".$deal['id']." AND repay_time=".$load_repay['repay_day']." AND to_user_id=".$user_id);
			}
		}
		else{
			$load_repay['l_key'] = $i;
			$load_repay['status'] = 0;
			$load_repay['has_repay'] = 0;
			$load_repay['to_user_id'] = $user_id;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_repay_ext",$load_repay,"INSERT");
			$repay_id = $GLOBALS['db']->insert_id();
		}
		make_user_repay_plan_new($deal,$i,$load_repay['repay_time'],$old_info['true_repay_time'],$repay_id,$total_money,$user_id);
	}
}


/**
 * 生成投标者的回款计划
 * 基于 make_user_repay_plan 修改
 * 针对新手专享标,区别于普通标,投标时即生成还款计划和回款计划
 * @user_id 投标用户
 * 标的无放款时间,需要另行设置
 */
 * Admin 2016-7-13

function make_user_repay_plan_new($deal,$idx,$repay_day,$true_time,$repay_id,&$total_money,$user_id){
	static $fload_users;
	if(!isset($fload_users[$deal['id']])){
		$fload_users[$deal['id']] = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$deal['id']." and user_id=".$user_id." ORDER BY id ASC ");
	}
	
	$loantype = intval($deal['loantype']);
	$LoanModule = LoadLoanModule($loantype);
	
	$load_users = $LoanModule->make_user_repay_plan($deal,$idx,$repay_day,$true_time,$repay_id,$fload_users[$deal['id']],$total_money);

	foreach($load_users as $kk=>$vv){
		$repay_data =array();
		$repay_data = $vv;
		
		if($old_info = $GLOBALS['db']->getRow("SELECT id,has_repay FROM ".DB_PREFIX."deal_load_repay WHERE deal_id=".$vv['deal_id']." AND u_key=$kk and l_key= $idx and user_id=$user_id")){
			if($old_info['has_repay']==1)
			{
				unset($repay_data['self_money']);
				unset($repay_data['repay_money']);
				unset($repay_data['interest_money']);
				unset($repay_data['manage_money']);
				unset($repay_data['repay_manage_money']);
				unset($repay_data['manage_interest_money']);
				unset($repay_data['manage_interest_money_rebate']);
				unset($repay_data['has_repay']);
			}
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_load_repay",$repay_data,"UPDATE","id=".$old_info['id']);
		}
		else{
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_load_repay",$repay_data,"INSERT");
		}
	}
}


/**
 * 新手标放款
 * @user_id 投标用户
 * @money 投标金额
 */
function do_loans_new($id,$repay_start_time,$type=0,$user_id,$money){
 	$return = array("status"=>0,"info"=>"");
    if (!$user_id && !$money) { return $return; }

	if($id==0){
		$return['info'] = "放款失败，借款不存在";
		return $return;
	}
	require_once(APP_ROOT_PATH."app/Lib/deal.php");
	
	$deal_info = get_deal($id);

    if ($deal_info['ext'] != 'newe') {
		$return['info'] = "不是新手标";
		return $return;
    }

    $deal_info['borrow_amount'] = $money;
    $deal_info['repay_start_time'] = $repay_start_time;
	
	if(!$deal_info){
		$return['info'] = "放款失败，借款不存在";
		return $return;
	}

	$loan_data['repay_start_time'] = $repay_start_time;
	$loan_data['repay_time'] = next_replay_month($loan_data['repay_start_time']);
	$loan_data['next_repay_time'] = next_replay_month($loan_data['repay_start_time']);
	$loan_data['is_has_loans'] = 1;
	$loan_data['repay_start_date'] = to_date($loan_data['repay_start_time'],"Y-m-d");
	
	//放款的时候设置成无效
	$loan_data['is_effect'] = 0;
	
	if($deal_info['ext']=='newe' && $user_id>0){
		format_deal_item($deal_info);
		require_once APP_ROOT_PATH."system/libs/user.php";
		if($type == 0){
			modify_account(array("money"=>$deal_info['borrow_amount']),$deal_info['user_id'],"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],招标成功",3);
		}
		
		$load_list = $GLOBALS['db']->getAll("SELECT id,user_id,`money`,`is_old_loan`,`rebate_money`,`bid_score`,`is_winning`,`income_type`,`income_value`,`create_time` FROM ".DB_PREFIX."deal_load where deal_id=".$id." and is_rebate = 0 and user_id=".$user_id);

		foreach($load_list as $lk=>$lv){
			//扣除冻结资金
			if($type == 0){
				$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_load SET is_has_loans =1 WHERE id=".$lv['id']." AND is_has_loans = 0 AND user_id=".$lv['user_id']);
				if($GLOBALS['db']->affected_rows()){
					if($lv['is_old_loan']==0)
						modify_account(array("lock_money"=>-$lv['money']),$lv['user_id'],"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],投标成功",2);
				}
			}
		}
		
		make_repay_plan_new($deal_info,$user_id);
		
		//放完款的时候重新设置成有效
		$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal SET is_effect=1 WHERE id=".$id);
		
		//发借款成功邮件
		//send_deal_success_mail_sms($id,$deal_info);
		//发借款成功站内信
		send_deal_success_site_sms($id,$deal_info);
		
		//借款协议范本
		//send_deal_contract_email($id,$deal_info,$deal_info['user_id']);
		
		$return['status'] = 1;
		$return['info'] = "放款成功";
		return $return;
	}
	else{
		$return['info'] = "放款失败";
		return $return;
	}
}
 
?>