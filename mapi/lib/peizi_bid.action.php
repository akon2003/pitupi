<?php

class peizi_bid
{
	public function index(){
		
		$root = array();

		$id = intval($GLOBALS['request']['id']);
		$paypassword =  FW_DESPWD($GLOBALS['request']['paypassword']);
		$user_id = intval($GLOBALS['user_info']['id']);
//		$user =  $GLOBALS['user_info'];
//		$root['session_id'] = es_session::id();
//		$user_id  = intval($user['id']);
		
		require_once APP_ROOT_PATH.'system/libs/peizi.php';
		$result = dopeizi_bid($id,$user_id,$paypassword);
		//ajax_return($result);
		$root['result'] = $result;
			
		$root['program_title'] = "配资投资";
		output($root);		
	}
}
?>
