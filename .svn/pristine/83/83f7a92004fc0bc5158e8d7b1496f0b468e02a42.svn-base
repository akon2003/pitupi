<?php

class register_idno{
	public function index()
	{	
		require_once APP_ROOT_PATH."system/common.php";
		$root = array();
		$root['status']=0;
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
				
			$root['user_login_status'] = 1;

			
			$real_name = strim($GLOBALS['request']['real_name']);
			$idno = strim($GLOBALS['request']['idno']);
			
			if(!$real_name)
			{				
				$root['response_code'] = 0;
				$root['show_err'] = "请输入真实姓名";
				output($root);
			}
			
			
			if($idno==""){				
				$root['response_code'] = 0;
				$root['show_err'] = "请输入身份证号";
				output($root);
			}
			
			if(getIDCardInfo($idno)==0){				
				$root['response_code'] = 0;
				$root['show_err'] = "身份证号码错误！";
				output($root);
			}
			//判断该实名是否存在
			if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user where idno_encrypt = AES_ENCRYPT('".$idno."','".AES_DECRYPT_KEY."') and id<> $user_id") > 0 ){
				$root['response_code'] = 0;
				$root['show_err'] = "该实名已被其他用户认证，非本人请联系客服";
				output($root);
			}
			
			$verify = idCardVerify($real_name, $idno);
    		if($verify['status'] == 0){
 				$root['response_code'] = 0;
				$root['show_err'] = "认证请求失败，请稍后再试！";
				output($root);
    		}
			if($verify['isok'] == false){
 				$root['response_code'] = 0;
				$root['show_err'] = "身份证跟姓名不匹配！";
				output($root);
    		}

			$user_info_re = array();
			$user_info_re['real_name'] = $real_name;
			$user_info_re['idno'] = $idno;
    		$user_info_re['real_name_encrypt'] = "AES_ENCRYPT('".$real_name."','".AES_DECRYPT_KEY."')";
    		$user_info_re['idno_encrypt'] = "AES_ENCRYPT('".$idno."','".AES_DECRYPT_KEY."')";
			$user_info_re['idcardpassed'] = 1;

			$id_card_info = idCardSubInfo($_REQUEST['idno']);
    		$user_info_re['sex'] = $id_card_info['sex'];
    		$user_info_re['byear'] = $id_card_info['byear'];
    		$user_info_re['bmonth'] = $id_card_info['bmonth'];
    		$user_info_re['bday'] = $id_card_info['bday'];

			$GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_info_re,"UPDATE","id=".$user_id);
			$GLOBALS['db']->query("UPDATE ".DB_PREFIX."user set real_name_encrypt = AES_ENCRYPT('".$real_name."','".AES_DECRYPT_KEY."'),idno_encrypt = AES_ENCRYPT('".$idno."','".AES_DECRYPT_KEY."') where id=".$user_id);
		
			if(intval(app_conf("OPEN_IPS")) > 0){
				$app_url = APP_ROOT."/index.php?ctl=collocation&act=CreateNewAcct&user_type=0&is_pc=1&user_id=".$user_id."&from=".$GLOBALS['request']['from'];
				$root['app_url'] = str_replace("/mapi", "", SITE_DOMAIN.$app_url);				
				$root['acct_url'] = $root['app_url'];
			}
			
			$root['open_ips'] = intval(app_conf("OPEN_IPS"));
			$root['response_code'] = 1;
			$root['show_err'] ="验证成功";
			$root['status']=1;
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
			
		$root['program_title'] = "身份证验证";
		output($root);
	}
}
?>