<?php

require_once APP_ROOT_PATH.'app/Lib/uc.php';
require_once APP_ROOT_PATH.'system/libs/learn.php';
require_once APP_ROOT_PATH.'app/Lib/page.php';

class uc_learnModule extends SiteBaseModule {

    //首页
	public function index()
	{
		$now_time = to_date(TIME_UTC,"Y-m-d H:i:s");
		
		$user_info = $GLOBALS['user_info'];
		
		$GLOBALS['tmpl']->assign('user_data',$user_info);
		
		$learn_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."learn where is_effect = 1 and begin_time < '$now_time' and '$now_time' < end_time order by id desc limit 1 ");
		
		$has_send_money = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load WHERE learn_id ='".$learn_info['id']."'  ");
		
		if((int)$has_send_money == (int)$learn_info['load_money']){
				$learn_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."learn where is_effect = 1 and begin_time < '$now_time' and '$now_time' < end_time and id < '".$learn_info['id']."' order by id desc limit 1 ");
				$has_send_money = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load WHERE learn_id ='".$learn_info['id']."'  ");
				if((int)$has_send_money == (int)$learn_info['load_money']){
					$learn_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."learn where is_effect = 1 and begin_time < '$now_time' and '$now_time' < end_time and id < '".$learn_info['id']."' order by id desc limit 1 ");
					$has_send_money = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_load WHERE learn_id ='".$learn_info['id']."'  ");
				}
		}
			
		$learn_balance = $GLOBALS['db']->getOne("select sum(money) FROM ".DB_PREFIX."learn_send_list WHERE is_use = 0 and user_id='".intval($GLOBALS['user_info']['id'])."' and is_recycle = 0 and begin_time < '$now_time' and '$now_time' < end_time  and is_effect = 1 ");
		
		if(empty($learn_balance) || $learn_balance == 0){
			$learn_balance = 0.00;
		}
		
		$learn_id = $learn_info['id'];
		$is_interest = $GLOBALS['db']->getOne("select count(*) FROM ".DB_PREFIX."learn_load WHERE learn_id = $learn_id and user_id='".intval($GLOBALS['user_info']['id'])."' ");
		
		$today=to_date(TIME_UTC,"Y-m-d");
		//$uc_interest = intval($learn_balance * $learn_info['rate'] * 0.01 * $learn_info['time_limit']/365); 
		$uc_interest = $learn_balance * $learn_info['rate'] * 0.01 * $learn_info['time_limit']/365; 
		
		$has_lead_interest = $GLOBALS['db']->getOne("select sum(interest) FROM ".DB_PREFIX."learn_load WHERE is_send = 1 and user_id='".intval($GLOBALS['user_info']['id'])."' ");
		if(empty($has_lead_interest) || $has_lead_interest == 0){
			$has_lead_interest = 0.00;
		}
		
		//$no_lead_interest = $GLOBALS['db']->getOne("select sum(interest) FROM ".DB_PREFIX."learn_load WHERE is_send = 0 and DATE_ADD(create_date,INTERVAL time_limit DAY) < '$today' and  DATE_ADD(create_date,INTERVAL time_expire_limit DAY) > '$today' and user_id='".intval($GLOBALS['user_info']['id'])."' ");
		$no_lead_interest = $GLOBALS['db']->getOne("select sum(interest) FROM ".DB_PREFIX."learn_load WHERE is_send = 0 and DATE_ADD(create_date,INTERVAL time_limit DAY) <= '$today' and  DATE_ADD(create_date,INTERVAL (time_expire_limit+time_limit) DAY) > '$today'  and user_id='".intval($GLOBALS['user_info']['id'])."' ");
		
		
		if(empty($no_lead_interest) || $no_lead_interest == 0){
			$no_lead_interest = 0.00;
		}
		
		$page = intval($_REQUEST['p']);
		if($page==0)
		$page = 1;
		$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
		
		$t = strim($_REQUEST['t']); 
		$GLOBALS['tmpl']->assign("t",$t);
		if($t=="load"){
			$learn_load_list = $GLOBALS['db']->getAll("select ll.*,l.name from ".DB_PREFIX."learn_load ll left join ".DB_PREFIX."learn l on ll.learn_id = l.id where  ll.user_id = ".intval($GLOBALS['user_info']['id'])." order by id desc  limit ".$limit);		
			$learn_load_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."learn_load where user_id = ".intval($GLOBALS['user_info']['id']));
			$learn_count = $learn_load_count;
			foreach($learn_load_list as $k => $v)
			{
				$learn_end_time[$k] = strtotime($learn_load_list[$k]['create_date']) + $learn_load_list[$k]['time_limit'] * 24 * 3600 ;
				$learn_load_list[$k]['end_date'] = to_date($learn_end_time[$k],'Y-m-d');
				if($today<$learn_load_list[$k]['end_date']){
					$learn_load_list[$k]['state'] = "理财中";
				}else{
					$learn_load_list[$k]['state'] = "已结束";
				}
				
			}
			
		}else{
			$learn_send_list = $GLOBALS['db']->getAll("select lsl.*,lt.type from ".DB_PREFIX."learn_send_list lsl left join ".DB_PREFIX."learn_type lt on lsl.type_id = lt.id where lt.is_effect = 1 and  lsl.user_id = ".intval($GLOBALS['user_info']['id'])." order by id desc  limit ".$limit);	
			$learn_send_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."learn_send_list  where user_id = ".intval($GLOBALS['user_info']['id']));	
			$learn_count = $learn_send_count;
			foreach($learn_send_list as $k => $v)
			{
				$learn_begin_time[$k] = explode(" ",$learn_send_list[$k]['begin_time']);
				$learn_send_list[$k]['begin_date'] = $learn_begin_time[$k]['0'];
				$learn_end_time[$k] = explode(" ",$learn_send_list[$k]['end_time']);
				$learn_send_list[$k]['end_date'] = $learn_end_time[$k]['0'];
			}
		}
		$page = new Page($learn_count,app_conf("PAGE_SIZE"));  
		
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		
		$GLOBALS['tmpl']->assign("uc_interest",$uc_interest);
		
		$GLOBALS['tmpl']->assign("has_send_money",$has_send_money);
		
		$GLOBALS['tmpl']->assign("has_lead_interest",$has_lead_interest);
		
		$GLOBALS['tmpl']->assign("no_lead_interest",$no_lead_interest);
		
		$GLOBALS['tmpl']->assign("learn_balance",$learn_balance);
		
		$GLOBALS['tmpl']->assign("learn_info",$learn_info);
		
		$GLOBALS['tmpl']->assign("is_interest",$is_interest);
		
		
		$GLOBALS['tmpl']->assign("learn_send_list",$learn_send_list);
		$GLOBALS['tmpl']->assign("learn_load_list",$learn_load_list);
		
		$GLOBALS['tmpl']->assign("page_title","理财体验金");
		
		$GLOBALS['tmpl']->assign("inc_file","learn/learn_index.html");
		$GLOBALS['tmpl']->display("page/uc.html");
		
	}
	
	/**
	 * 领取收益
	 */
	public function do_interest(){
		$dltid = intval($_REQUEST['dltid']);
		do_receive_benefits();
		
		//showSuccess("领取收益成功",1);
		
	}
	
	/**
	 * 体验金投资
	 */
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
	
	

}
?>