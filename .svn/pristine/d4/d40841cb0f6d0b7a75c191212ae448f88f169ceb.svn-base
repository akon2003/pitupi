<?php

require APP_ROOT_PATH.'app/Lib/deal.php';
class deal
{
	public function index(){
		
		$root = array();
		
		$id = intval($GLOBALS['request']['id']);
	
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			
			$root['is_faved'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_collect WHERE deal_id = ".$id." AND user_id=".$user_id);	
		}else{
			$root['is_faved'] = 0;//0：未关注;>0:已关注
		}
		$root['response_code'] = 1;
		$deal = get_deal($id);	
		//format_deal_item($deal,$email,$pwd);
		//print_r($deal);
		//exit;		
		$root['deal'] = $deal;
		$root['open_ips'] = intval(app_conf("OPEN_IPS"));
		$root['ips_acct_no'] = $user['ips_acct_no'];
		$root['ips_bill_no'] = $deal['ips_bill_no'];
		
//		function bid_calculate(){
//			require_once APP_ROOT_PATH."app/Lib/deal_func.php";
//			echo bid_calculate($_POST);
//		}
		
		$root['ecv_list'] = array();
		if($deal['use_ecv'] == 1){
			//红包抵用
			$user_id = intval($GLOBALS['user_info']['id']);
			$sql = "select e.*,et.name from ".DB_PREFIX."ecv as e left join ".DB_PREFIX."ecv_type as et on e.ecv_type_id = et.id where e.user_id = ".$user_id." AND if(e.use_limit > 0 ,(e.use_limit - e.use_count) > 0,1=1) AND if(e.begin_time >0 , e.begin_time < ".TIME_UTC.",1=1) AND if(e.end_time>0,(e.end_time + 24*3600 - 1) > ".TIME_UTC.",1=1)  order by e.id desc ";
			$root['ecv_list'] = $GLOBALS['db']->getAll($sql);
			
		}
		
		if (!empty($root['ips_bill_no'])){
			//第三方托管标
			if (!empty($user['ips_acct_no'])){
				$result = GetIpsUserMoney($user_id,0);
					
				$root['user_money'] = $result['pBalance'];
			}else{
				$root['user_money'] = 0;
			}
		}else{
			$root['user_money'] = $user['money'];
		}
			
		$root['user_money_format'] = format_price($user['user_money']);//用户金额
		
		//data.deal.name
		$root['program_title'] = "投标详情";
		output($root);		
	}
}
?>

