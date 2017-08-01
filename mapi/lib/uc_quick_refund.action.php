<?php

class uc_quick_refund
{
	public function index(){
		
		$root = array();
		
		$id = intval($GLOBALS['request']['id']);
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			require APP_ROOT_PATH.'app/Lib/deal.php';
			
			$root['user_login_status'] = 1;
									
			$deal = get_deal($id);
			if(!$deal || $deal['user_id'] != $user_id || $deal['deal_status'] != 4){				
				$root['show_err'] = "操作失败！";
				$root['response_code'] = 0;
			}else{
				//还款列表
				$loan_list = get_deal_load_list($deal);
				
				$flag = 1;
				foreach ($loan_list as $k=>$v)
				{
					if($loan_list[$k]['has_repay'] == 0 && $flag ==1 )
					{
						$loan_list[$k]["flag"]= $flag;
						$flag = 0;
					}
					
				}
				
				
				$root['loan_list'] = $loan_list;
				$root['deal'] = $deal;
//				$durl = "/wap/index.php?ctl=deal_contract&id=" . $id;
//				$root['agree_url'] = str_replace ( "/mapi", "", SITE_DOMAIN . APP_ROOT . $durl );
				$durl = "/index.php?ctl=deal_contract&act=contract&is_sj=1&id=" . $id;
				$root['agree_url'] = str_replace ( "/mapi", "", SITE_DOMAIN . APP_ROOT . $durl );
				
				$root['response_code'] = 1;
				$root['show_err'] = '';
			}
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		$root['program_title'] = "还款详情";
		output($root);		
	}
}
?>
