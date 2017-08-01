<?php

class msg
{
	public function index(){
		$root = array();
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);//user_id
		if ($user_id >0){
			
			$rel_id = intval($GLOBALS['request']['rel_id']);   //deal_id  投资项目id
			//insert into fanwe_message (title,content,create_time,rel_table,rel_id,user_id,is_effect) values ('我是一只小狼狗','啦啦啦啦啦','1400616627','deal','102','44','1');
		
			$data['user_id'] = $user_id;
			$data['rel_id'] = $rel_id;
			$data['title'] = $GLOBALS['request']['title'];
			$data['content'] = $GLOBALS['request']['content'];
			
			$data['create_time'] = TIME_UTC;
			$data['rel_table'] = strim($GLOBALS['request']['rel_table']);
			$data['is_effect'] = 1;
			
			if ($data['rel_id'] > 0){
				$GLOBALS['db']->autoExecute(DB_PREFIX."message",$data,"INSERT");
			}
			
			if($GLOBALS['db']->affected_rows()){
				$root['response_code'] = 1;
				$root['show_err'] = "留言成功";
			}else{
				$root['response_code'] = 0;
				$root['show_err'] = "留言失败";
			}
			//$message_list = $GLOBALS['db']->getAll("SELECT title,content,a.create_time,rel_id,a.user_id,a.is_effect,b.user_name FROM ".DB_PREFIX."message as a left join ".DB_PREFIX."user as b on  a.user_id = b.id WHERE rel_id = ".$id);
			//$root['message']= $message_list;
			
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		output($root);		
	}
}
?>

