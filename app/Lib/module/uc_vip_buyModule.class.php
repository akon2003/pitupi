<?php
require APP_ROOT_PATH.'app/Lib/uc.php';
class uc_vip_buyModule  extends SiteBaseModule {

     public function index() {
    	
		
		$vip_id = intval($GLOBALS['user_info']['vip_id']);
		$GLOBALS['tmpl']->assign("vip_id",$vip_id);
		$now_vip_grade = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."vip_setting v LEFT JOIN ".DB_PREFIX."vip_type vt ON v.vip_id=vt.id  where v.id = '$vip_id'  ");
		$GLOBALS['tmpl']->assign("now_vip_grade",$now_vip_grade);
		
		$max_vip = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."vip_type order by id desc limit 1 ");
		$GLOBALS['tmpl']->assign("max_vip",$max_vip);
		
		
		if($max_vip['id'] == $vip_id){
			$vip_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."vip_setting v LEFT JOIN ".DB_PREFIX."vip_type vt ON v.vip_id=vt.id  where v.id = '$vip_id'  ");
			$vip_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."vip_setting v LEFT JOIN ".DB_PREFIX."vip_type vt ON v.vip_id=vt.id  where v.id = '$vip_id' order by v.id limit 1  ");
		}else{
			$vip_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."vip_setting v LEFT JOIN ".DB_PREFIX."vip_type vt ON v.vip_id=vt.id  where v.id > '$vip_id' order by v.id limit 1  ");
			$vip_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."vip_setting v LEFT JOIN ".DB_PREFIX."vip_type vt ON v.vip_id=vt.id  where v.id > '$vip_id'  ");
		}
		$vip_data = $vip_list;
		
		$GLOBALS['tmpl']->assign("vip_info",$vip_info);
		
		$GLOBALS['tmpl']->assign("vip_list",$vip_list);
		
		$GLOBALS['tmpl']->assign("vip_data",json_encode($vip_data));
		
		
		$GLOBALS['tmpl']->assign("page_title","VIP等级购买");
		$GLOBALS['tmpl']->assign("inc_file","inc/uc/uc_vip_buy.html");
		$GLOBALS['tmpl']->display("page/uc.html");
    	
    }
    
    public function savevipbuy(){
    	
    	if($GLOBALS['user_info']['id'] > 0){
			require_once APP_ROOT_PATH.'app/Lib/uc_func.php';
			
			$paypassword = strim(FW_DESPWD($_REQUEST['paypassword']));
			$amount = intval($_REQUEST['years']);
			$vip_id = intval($_REQUEST['vip_id']);
			
			$status = getUcSaveVipBuy($amount,$paypassword,$vip_id);
			
			if($status['status'] == 0){
				showErr($status['show_err']);
			}
			else{
				showSuccess($status['show_err']);
			}
			
		}else{
			app_redirect(url("index","user#login"));
		}
    	
    }
    
    public function vip_buy_log(){
    	$page = intval($_REQUEST['p']);
		if($page==0)
			$page = 1;
		$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
		
    	$vip_buy_log_list = $GLOBALS['db']->getAll("select vbl.*,vt.vip_grade from ".DB_PREFIX."vip_buy_log vbl LEFT JOIN ".DB_PREFIX."vip_type vt ON vbl.vip_id=vt.id  where vbl.user_id = ".intval($GLOBALS['user_info']['id'])." order by vbl.id desc limit $limit ");
		$log_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."vip_buy_log  where user_id = ".intval($GLOBALS['user_info']['id'])." ");
		$GLOBALS['tmpl']->assign("vip_buy_log_list",$vip_buy_log_list);
		
		$page = new Page($log_count,app_conf("PAGE_SIZE"));   //初始化分页对象 		
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		
    	$GLOBALS['tmpl']->assign("page_title","VIP购买日志");
		$GLOBALS['tmpl']->assign("inc_file","inc/uc/uc_vip_buy_log.html");
		$GLOBALS['tmpl']->display("page/uc.html");
		
    }
    
}
?>