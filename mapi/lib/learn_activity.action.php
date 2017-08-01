<?php

class learn_activity
{
	public function index(){
		
		$root = array();
		$page = intval($GLOBALS['request']['page']);
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		$status = intval($GLOBALS['request']['status']);
		$root['user_id'] = $user_id;
		
		require APP_ROOT_PATH.'app/Lib/uc_func.php';
		
		$root['user_login_status'] = 1;
		$root['response_code'] = 1;
		
		if($status == 1){
			
			$root['user_id'] = $user_id;
			$total_referral_money = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."referrals where rel_user_id = ".$GLOBALS['user_info']['id']." and pay_time > 0");
			
			$root['total_referral_money'] = $total_referral_money;
			
			$referral_user = get_user_info("count(*)","pid = ".$user_id." and is_effect=1 and is_delete=0 AND user_type in(0,1) ","ONE");
			$root['referral_user'] = $referral_user;
			
			$learn_invite = $GLOBALS['db']->getOne("select sum(lsl.money) from ".DB_PREFIX."learn_send_list lsl left join ".DB_PREFIX."learn_type lt on lsl.type_id = lt.id where lt.type = 1 and lsl.is_effect = 1 and lsl.user_id ='".$user_id."' ");
			
			$root['learn_invite'] = $learn_invite;
			
			if(intval(app_conf("URL_MODEL")) == 0)
				$depart="&";
			else
				$depart="?";	
			$share_url = SITE_DOMAIN.url("index","register");
			if($user){
				$share_url_mobile = $share_url.$depart."r=".base64_encode($user['mobile']);
				$share_url_username = $share_url.$depart."r=".base64_encode($user['user_name']);
				$root['share_url_mobile'] = $share_url_mobile;
				$root['share_url_username'] = $share_url_username;
			}
			
			$GLOBALS['tmpl']->caching = true;
			$GLOBALS['tmpl']->cache_lifetime = 6;  //首页缓存10分钟
			$name = trim($GLOBALS['request']['u']) == "" ? "learnsrule" : trim($GLOBALS['request']['u']);
			$cache_id  = md5(MODULE_NAME.ACTION_NAME.$name);	
			
			$info = get_article_buy_uname($name);
			$info['content']=$GLOBALS['tmpl']->fetch("str:".$info['content']);
			$root['activity_info'] = $info;
			
			
		}elseif($status == 2){
	    	
	    	$root['user_id'] = $user_id;
	    	$GLOBALS['tmpl']->caching = true;
			$GLOBALS['tmpl']->cache_lifetime = 6;  //首页缓存10分钟
			$name = trim($GLOBALS['request']['u']) == "" ? "learnurule" : trim($GLOBALS['request']['u']);
			$cache_id  = md5(MODULE_NAME.ACTION_NAME.$name);	
			
			$info = get_article_buy_uname($name);
			$info['content']=$GLOBALS['tmpl']->fetch("str:".$info['content']);
			$root['activity_info'] = $info;
			
			
		}else{
			$status == 0;
			if($page==0)
			$page = 1;
			$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
			$now_time = to_date(TIME_UTC,"Y-m-d H:i:s");
			
	    	$learn_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."learn where is_effect = 1 order by id desc limit ".$limit);
	    	$learn_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."learn where is_effect = 1 ");
	    	
	    	$learn_balance = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_send_list WHERE is_use = 0 and begin_time < '$now_time' and '$now_time' < end_time and user_id='$user_id' and is_recycle = 0 ");
	    	if(empty($learn_balance) || $learn_balance == 0){
				$learn_balance = 0.00;
			}
		
	    	foreach($learn_list as $k => $v)
			{
				$learn_list[$k]['cmoney'] = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load  where learn_id = '".$v['id']."' ");
				if($v['begin_time'] > $now_time ){
					$learn_list[$k]['status'] = 0;
				}elseif($v['begin_time'] < $now_time && $v['end_time'] > $now_time && $learn_list[$k]['cmoney'] < $v['load_money']){
					$learn_list[$k]['status'] = 1;
				}elseif($v['end_time'] < $now_time){
					$learn_list[$k]['status'] = 2;
				}else{
					$learn_list[$k]['status'] = 3;
				}
			}
			
			$root['learn_balance'] = $learn_balance;
	    	$root['learn_list'] = $learn_list;
			$root['user_id'] = $user_id;
	
			$root['page'] = array("page"=>$page,"page_total"=>ceil($learn_count/app_conf("PAGE_SIZE")),"page_size"=>app_conf("PAGE_SIZE"));
		}
		$root['status'] = $status;
		
		$root['program_title'] = "新手体验区";
		output($root);		
	}
}
?>
