<?php

/**
 * XHF 2016-7-13
 * 新增控制器,新手专享标,购买即完成计划表创建
 * 参考U计划
 * deal表 ext 字段名为 newe
 */

require APP_ROOT_PATH.'app/Lib/deal.php';
require 'dealModule.class.php';
class neweModule extends dealModule
{
	function index(){		
		$id = intval($_REQUEST['id']);
		
		$deal = get_deal($id);

		if(!$deal || $deal['ext'] != 'newe' || $deal['is_new'] == 0)
			app_redirect(url("index")); 
	
		//产品列表
		$load_list = $GLOBALS['db']->getAll("SELECT deal_id,user_id,user_name,money,is_auto,create_time FROM ".DB_PREFIX."deal_load WHERE deal_id = ".$id." order by id ASC ");
		//产品总额
		$load_total_money = 0;
		foreach ($load_list as $load) {
			$load_total_money += $load['money'];
		}
		
		$u_info = $deal['user'];
		
		if($deal['view_info']!=""){
			$view_info_list = unserialize($deal['view_info']);
			$GLOBALS['tmpl']->assign('view_info_list',$view_info_list);
		}
		
		//可用额度
		$can_use_quota = get_can_use_quota($deal['user_id']);
		$GLOBALS['tmpl']->assign('can_use_quota',$can_use_quota);
		
		$credit_file = get_user_credit_file($deal['user_id'],$u_info);
		$deal['is_faved'] = 0;
		if($GLOBALS['user_info']){
			if($u_info['user_type']==1)
				$company = $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."user_company WHERE user_id=".$u_info['id']);
			
			$deal['is_faved'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_collect WHERE deal_id = ".$id." AND user_id=".intval($GLOBALS['user_info']['id']));

			$user_statics = sys_user_status($deal['user_id'],true);
			$GLOBALS['tmpl']->assign("user_statics",$user_statics);
			$GLOBALS['tmpl']->assign("company",$company);
			
			
			if($deal['uloadtype'] == 1){
				$has_bid_money = $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id);
				$GLOBALS['tmpl']->assign("has_bid_money",$has_bid_money);
				$GLOBALS['tmpl']->assign("has_bid_portion",intval($has_bid_money)/($deal['borrow_amount']/$deal['portion']));
			}
		}
		
		$GLOBALS['tmpl']->assign("load_list",$load_list);	
		$GLOBALS['tmpl']->assign("load_total_money",$load_total_money);	
		$GLOBALS['tmpl']->assign("u_info",$u_info);

		//投资服务协议编号
        //后台平台推广文章列表
		$load_service_agreement = 135;
		$GLOBALS['tmpl']->assign("load_service_agreement",$load_service_agreement['value']);

		$GLOBALS['tmpl']->assign("deal",$deal);
		$GLOBALS['tmpl']->display("page/newe.html");
	}
	
	function bid(){
		//检测是否系统维护模式
		$this->forbid_system_repair_mode(true);

		$id = intval($_REQUEST['id']);
		$bidmoney = strim($_REQUEST['bidmoney']);
		
		$return = array("status"=>0,"info"=>"");

		//投资金额10的倍数
		if($bidmoney%10 != 0){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
			ajax_return($return);
		}		

		if(!$GLOBALS['user_info']){
			$return["status"] = 2;
			$return["info"] = $GLOBALS['lang']['PLEASE_LOGIN_FIRST'];
			$return["jump"] = url("index","user#login"); 
			ajax_return($return);
		}

		if(!$_REQUEST['agreement']){
			$return["status"] = 0;
			$return["info"] = "请同意 委托投资协议";
			ajax_return($return);
		}
		
		
		if(floatval($bidmoney)<=0){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
			ajax_return($return);
		}
		
		
		$deal = get_deal($id);		
		if(!$deal){
			$return["status"] = 0;
			$return["info"] = "产品不存在";
			ajax_return($return);
		}

		if(trim($deal['mer_bill_no']) != ""){
			$mer_bill_no = trim($deal['mer_bill_no']);
			$password = trim($_REQUEST['password']);
			if ($mer_bill_no != $password) {
				$return["status"] = 0;
				$return["info"] = "密码输入错误，请重新输入";
				ajax_return($return);
			}
		}

		if($deal['user_id'] == $GLOBALS['user_info']['id']){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['CANT_BID_BY_YOURSELF'];
			ajax_return($return);
		}

		//判断是否已投过新手标
		if(($deal['is_new']==1 || $deal['ext'] == 'newe') && $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load  WHERE user_id=".$GLOBALS['user_info']['id']." ") > 0){
			$return["status"] = 0;
			$return["info"] = "此标为新手专享标，您已经投过了";
			ajax_return($return);
		}	

		$has_bid_money = $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id);
		if($deal['uloadtype'] == 1 ){
			if(floatval($bidmoney)%intval($bidmoney)!=0){
				$return["status"] = 0;
				$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
				ajax_return($return);
			}
			$bidmoney = $bidmoney*($deal['borrow_amount']/$deal['portion']);
		}
		elseif($deal['uloadtype'] == 0)
		{
			if(((int)app_conf('DEAL_BID_MULTIPLE') > 0 && floatval($bidmoney)%app_conf('DEAL_BID_MULTIPLE')!=0) || floatval($bidmoney)< $deal['min_loan_money'] || ($deal['max_loan_money'] > 0 && floatval($bidmoney)>$deal['max_loan_money'])){
				$return["status"] = 0;
				$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
				ajax_return($return);
			}
		}
	
		$GLOBALS['tmpl']->assign("deal",$deal);
		$GLOBALS['tmpl']->assign("bidmoney",$bidmoney);
		
		if($deal['use_ecv'] == 1){
			//红包抵用
			$user_id = intval($GLOBALS['user_info']['id']);
			$sql = "select e.*,et.name from ".DB_PREFIX."ecv as e left join ".DB_PREFIX."ecv_type as et on e.ecv_type_id = et.id where e.user_id = ".$user_id." AND if(e.use_limit > 0 ,(e.use_limit - e.use_count) > 0,1=1) AND if(e.begin_time >0 , e.begin_time < ".TIME_UTC.",1=1) AND if(e.end_time>0,(e.end_time + 24*3600 - 1) > ".TIME_UTC.",1=1)  order by e.id desc ";
			$ecv_list = $GLOBALS['db']->getAll($sql);
			$GLOBALS['tmpl']->assign("ecv_list",$ecv_list);
		}
		
		$return["status"] = 1;
		$return["info"] = $GLOBALS['tmpl']->fetch("page/deal_bid.html");
		ajax_return($return);
	}
	
	function dobid(){
		//检测是否系统维护模式
		$this->forbid_system_repair_mode(true);

		$ajax = intval($_REQUEST["ajax"]);

		$id = intval($_REQUEST["id"]);		
		$bid_money = floatval($_REQUEST["bid_money"]);
		$bid_paypassword = strim(FW_DESPWD($_REQUEST['bid_paypassword']));
		$ecv_id = intval($_REQUEST["ecv_id"]);
		
	    $status = dobid2($id,$bid_money,$bid_paypassword,1,$ecv_id);

		if($status['status'] == 0){
			showErr($status['show_err'],$ajax);
		}elseif($status['status'] == 2){
			ajax_return($status);
		}elseif($status['status'] == 3){
			showSuccess("余额不足，请先去充值",$ajax,url("index","uc_money#incharge"));
		}elseif($status['status'] == 4) {
			$status['info'] = "余额不足，无法投标，立即去充值";
			$status['jump'] = "member.php?ctl=uc_money&act=incharge";
			ajax_return($status);
		}else{
            require_once APP_ROOT_PATH.'system/libs/user.php';
            require_once APP_ROOT_PATH.'system/common_ext.php';
            require_once APP_ROOT_PATH.'app/Lib/common.php';

            // 生成还款计划与回款计划
            $result = do_loans_new($id,TIME_UTC,0,$GLOBALS['user_info']['id'],$bid_money);
            if ($result['status'] == 1) {
    			showSuccess($GLOBALS['lang']['DEAL_BID_SUCCESS'],$ajax,url("index"));
            } else {
    			showErr("还款回款计划生成失败",$ajax,url("index"));
            }
		}
	}
}
?>