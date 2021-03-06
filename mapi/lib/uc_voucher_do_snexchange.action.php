<?php

class uc_voucher_do_snexchange
{
	public function index(){
		
		$root = array();
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			
			$root['user_login_status'] = 1;		
			$root['response_code'] = 1;
			
			$sn = strim($GLOBALS['request']['sn']);
			$ecv_type = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."ecv_type where exchange_sn = '".$sn."'");
			if(!$ecv_type)
			{
				$root['status']=0;
				$root['response_code'] = 0;
				$root['show_err'] =$GLOBALS['lang']['INVALID_VOUCHER'];
				$root['user_login_status'] = 0;
			}
			else
			{
				$exchange_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."ecv where ecv_type_id = ".$ecv_type['id']." and user_id = ".intval($GLOBALS['user_info']['id']));
				if($ecv_type['exchange_limit']>0&&$exchange_count>=$ecv_type['exchange_limit'])
				{
					$msg = sprintf($GLOBALS['lang']['EXCHANGE_VOUCHER_LIMIT'],$ecv_type['exchange_limit']);
					$root['status']=0;
					$root['response_code'] = 0;
					$root['show_err'] =$msg;
					$root['user_login_status'] = 0;
				}
				else
				{
					require_once APP_ROOT_PATH."system/libs/voucher.php";
					$rs = send_voucher($ecv_type['id'],$GLOBALS['user_info']['id'],1);
					if($rs)
					{
						$root['status']=1;
						$root['response_code'] = 1;
						$root['show_err'] =$GLOBALS['lang']['EXCHANGE_SUCCESS'];
						$root['user_login_status'] = 0;
					}
					else
					{
						$root['status']=0;
						$root['response_code'] = 0;
						$root['show_err'] =$GLOBALS['lang']['EXCHANGE_FAILED'];
						$root['user_login_status'] = 0;
					}
				}
			}
			
		}else{
			$root['status']=0;
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		$root['program_title'] = "我的红包";
		output($root);		
	}
}
?>
