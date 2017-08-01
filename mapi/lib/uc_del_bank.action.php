<?php

class uc_del_bank
{
	public function index(){
		
		$root = array();
		
		$id = strim($GLOBALS['request']['id']);
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){

			$root['user_login_status'] = 1;
			
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."user_bank where user_id=".intval($GLOBALS['user_info']['id'])." and id in (".$id.")");
			
			if($GLOBALS['db']->affected_rows()){
				$root['response_code'] = 1;
				$root['show_err'] = $GLOBALS['lang']['DELETE_SUCCESS'];
			}else{
				$root['response_code'] = 0;
				$root['show_err'] = "删除失败";
			}		
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		output($root);		
	}
}
?>
