<?php

require_once APP_ROOT_PATH.'app/Lib/uc.php';
require_once APP_ROOT_PATH.'system/libs/learn.php';
require_once APP_ROOT_PATH.'app/Lib/page.php';

class learn_activityModule extends SiteBaseModule {

    public function index() {
    	$now_time = to_date(TIME_UTC,"Y-m-d H:i:s");
    	$user_id = intval($GLOBALS['user_info']['id']);
    	$page = intval($_REQUEST['p']);
		if($page==0)
		$page = 1;
		$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
		
    	$learn_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."learn where is_effect = 1 order by id desc limit ".$limit);
    	$learn_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."learn where is_effect = 1 ");
    	
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
		
		$page = new Page($learn_count,app_conf("PAGE_SIZE"));  
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);	
		
    	$GLOBALS['tmpl']->assign("learn_list",$learn_list);
    	$GLOBALS['tmpl']->assign("page_title","理财体验金");
    	$GLOBALS['tmpl']->assign("user_id",$user_id);
		$GLOBALS['tmpl']->display("learn/learn_activity_index.html");
		
    }
    
    public function detail() {
    	
    	$id = intval($_REQUEST['id']);
    	$now_time = to_date(TIME_UTC,"Y-m-d H:i:s");
    	$type = $_REQUEST['type'];
    	$learn_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."learn where is_effect = 1 and id =".$id);
    	
    	$learn_cmoney = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load  where learn_id = '".$id);
    	
    	$user_id = intval($GLOBALS['user_info']['id']);
    	
    	$learn_begin_time= explode(" ",$learn_info['begin_time']);
    	$learn_begin_date = $learn_begin_time['0'];
    	$begin_time = strtotime($learn_info['begin_time']);
    	
    	$learn_end_time= explode(" ",$learn_info['end_time']);
    	$learn_end_date = $learn_end_time['0'];
    	$end_time = strtotime($learn_info['end_time']);
    	
    	$learn_limit=ceil(($end_time-$begin_time)/86400); 
    	
    	
    	$learn_balance = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_send_list WHERE is_use = 0 and begin_time < '$now_time' and '$now_time' < end_time and user_id='".intval($GLOBALS['user_info']['id'])."' and is_recycle = 0 ");
    	if(empty($learn_balance) || $learn_balance == 0){
			$learn_balance = 0.00;
		}
		
		$has_invest = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load WHERE learn_id =".$id);
		
		if(empty($has_invest) || $has_invest == 0){
			$has_invest = 0;
			
		}
		
		$GLOBALS['tmpl']->assign("id",$id);
		
		$GLOBALS['tmpl']->assign("type",$type);
		
		$GLOBALS['tmpl']->assign("user_id",$user_id);
		
		$GLOBALS['tmpl']->assign("now_time",$now_time);
		$GLOBALS['tmpl']->assign("learn_cmoney",$learn_cmoney);
		
		$GLOBALS['tmpl']->assign("begin_time",$begin_time);
		$GLOBALS['tmpl']->assign("end_time",$end_time);
		
		$GLOBALS['tmpl']->assign("learn_limit",$learn_limit);
		
    	$GLOBALS['tmpl']->assign("learn_begin_date",$learn_begin_date);
    	$GLOBALS['tmpl']->assign("learn_end_date",$learn_end_date);
    	
    	$GLOBALS['tmpl']->assign("learn_info",$learn_info);
    	$GLOBALS['tmpl']->assign("learn_balance",$learn_balance);
    	$GLOBALS['tmpl']->assign("page_title","理财体验金投资");
    	$GLOBALS['tmpl']->assign("has_invest",$has_invest);
    	
		$GLOBALS['tmpl']->display("learn/learn_activity_detail.html");
    }
    
    public function rule() {
    	$user_id = intval($GLOBALS['user_info']['id']);
    	
    	$GLOBALS['tmpl']->assign("user_id",$user_id);
    	
    	$GLOBALS['tmpl']->caching = true;
		$GLOBALS['tmpl']->cache_lifetime = 6;  //首页缓存10分钟
		$name = trim($_REQUEST['u']) == "" ? "learnurule" : trim($_REQUEST['u']);
		$cache_id  = md5(MODULE_NAME.ACTION_NAME.$name);	
		if (!$GLOBALS['tmpl']->is_cached("learn/learn_activity_rule.html", $cache_id))
		{	
			$info = get_article_buy_uname($name);
			$info['content']=$GLOBALS['tmpl']->fetch("str:".$info['content']);
			$GLOBALS['tmpl']->assign("info",$info);
		}
    	$GLOBALS['tmpl']->assign("page_title","理财体验金活动规则");
		$GLOBALS['tmpl']->display("learn/learn_activity_rule.html",$cache_id);
    }
    
    public function do_invest(){
		$learn_id = intval($_REQUEST['learn_id']);
		$money = intval($_REQUEST['money']);
		
		$learn_invest_list = learn_invest($learn_id,$money);
		if($learn_invest_list == 1 ){
			showSuccess("投资成功",1);
		}else{
			showErr("投资失败",1);
		}
		
	}
	
	public function invite_link(){
		$user_id = intval($GLOBALS['user_info']['id']);
		
		$total_referral_money = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."referrals where rel_user_id = ".$GLOBALS['user_info']['id']." and pay_time > 0");
		
		$GLOBALS['tmpl']->assign("total_referral_money",$total_referral_money);
		
		$referral_user = get_user_info("count(*)","pid = ".$GLOBALS['user_info']['id']." and is_effect=1 and is_delete=0 AND user_type in(0,1) ","ONE");
		$GLOBALS['tmpl']->assign("referral_user",$referral_user);
		
		$learn_invite = $GLOBALS['db']->getOne("select sum(lsl.money) from ".DB_PREFIX."learn_send_list lsl left join ".DB_PREFIX."learn_type lt on lsl.type_id = lt.id where lt.type = 1 and lsl.is_effect = 1 and lsl.user_id ='".$user_id."' ");
		
		$GLOBALS['tmpl']->assign("learn_invite",$learn_invite);
		
		if(intval(app_conf("URL_MODEL")) == 0)
			$depart="&";
		else
			$depart="?";	
		$share_url = SITE_DOMAIN.url("index","user#register");
		if($GLOBALS['user_info']){
			$share_url_mobile = $share_url.$depart."r=".base64_encode($GLOBALS['user_info']['mobile']);
			$share_url_username = $share_url.$depart."r=".base64_encode($GLOBALS['user_info']['user_name']);
			$GLOBALS['tmpl']->assign("share_url_mobile",$share_url_mobile);
			$GLOBALS['tmpl']->assign("share_url_username",$share_url_username);	
		}
		
		
		$GLOBALS['tmpl']->caching = true;
		$GLOBALS['tmpl']->cache_lifetime = 6;  //首页缓存10分钟
		$name = trim($_REQUEST['u']) == "" ? "learnsrule" : trim($_REQUEST['u']);
		$cache_id  = md5(MODULE_NAME.ACTION_NAME.$name);	
		if (!$GLOBALS['tmpl']->is_cached("learn/learn_activity_invite_link.html", $cache_id))
		{	
			$info = get_article_buy_uname($name);
			$info['content']=$GLOBALS['tmpl']->fetch("str:".$info['content']);
			$GLOBALS['tmpl']->assign("info",$info);
		}
		
		$GLOBALS['tmpl']->assign("page_title","理财体验金邀请");
		
		$GLOBALS['tmpl']->assign("user_id",$user_id);
		$GLOBALS['tmpl']->display("learn/learn_activity_invite_link.html");
		
	}
	
    
}
?>