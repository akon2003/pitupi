<?php

require APP_ROOT_PATH.'app/Lib/deal.php';
class signin
{
	public function index(){
		
		$root = array();
		
		$id = intval($GLOBALS['request']['id']);
	
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			$root['result'] = signin($user_id);
			$root['response_code'] = 1;
			$root['show_err'] = '';
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		
		//data.deal.name
		$root['program_title'] = "签到";
		output($root);		
	}
}
?>

