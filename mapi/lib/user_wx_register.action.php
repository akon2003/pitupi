<?php

class user_wx_register
{	
	
	public function index(){

//		$user =  $GLOBALS['user_info'];
//		$root['session_id'] = es_session::id();
//		$id = intval($GLOBALS['request']['id']);//商品ID
//		$city_name =strim($GLOBALS['request']['city_name']);//城市名称
//		$user_id = intval($user['id']);

		$email = addslashes(trim($GLOBALS['request']['email']));//用户名或邮箱
		$pwd = trim($GLOBALS['request']['pwd']);//密码
		$id = intval($GLOBALS['request']['id']);//商品ID
		$city_name =strim($GLOBALS['request']['city_name']);//城市名称
		$user = user_check($email,$pwd,false);
		$user_id = intval($user['id']);
		if($user_id>0){
			app_redirect(wap_url("index#index"));
		}
		
		$root['city_name']=$city_name;
		$root['program_title']="绑定帐户";
		output($root);
		
	}
	
	
}
?>
