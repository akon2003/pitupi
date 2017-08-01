<?php

/**
 * U计划,新增模块
 */
require APP_ROOT_PATH.'app/Lib/deal.php';
require 'dealModule.class.php';
class uplanModule extends dealModule
{
	public function index(){
		$id = intval($_REQUEST['id']);
		
		$deal = get_deal($id);
		//定向标密码修改
		$deal['direction'] = 0;
		$deal['direction_pass'] = '';
		if ($deal['mer_bill_no'] != "") {
			$deal['direction'] = 1;
			$deal['direction_pass'] = md5(md5($deal['mer_bill_no']));
		}

		if(!$deal || $deal['ext'] != 'uplan')
			app_redirect(url("index")); 
	
		//借款列表
		$load_list = $GLOBALS['db']->getAll("SELECT deal_id,user_id,user_name,money,is_auto,create_time FROM ".DB_PREFIX."deal_load WHERE deal_id = ".$id." order by id ASC ");
		//借款总额
		$load_total_money = 0;
		foreach ($load_list as $load) {
			$load_total_money += $load['money'];
		}
		
		$u_info = $deal['user'];
		
		if($deal['view_info']!=""){
			$view_info_list = unserialize($deal['view_info']);
			$GLOBALS['tmpl']->assign('view_info_list',$view_info_list);
		}
		
		
		//可用额度
		$can_use_quota = get_can_use_quota($deal['user_id']);
		$GLOBALS['tmpl']->assign('can_use_quota',$can_use_quota);
		
		$credit_file = get_user_credit_file($deal['user_id'],$u_info);
		$deal['is_faved'] = 0;
		if($GLOBALS['user_info']){
			if($u_info['user_type']==1)
				$company = $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."user_company WHERE user_id=".$u_info['id']);
			
			$deal['is_faved'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_collect WHERE deal_id = ".$id." AND user_id=".intval($GLOBALS['user_info']['id']));
			
			if($deal['deal_status'] >=4){
				//还款列表
				$loan_repay_list = get_deal_load_list($deal);
				$GLOBALS['tmpl']->assign("loan_repay_list",$loan_repay_list);
				
				if($loan_repay_list){
					$temp_self_money_list = $GLOBALS['db']->getAll("SELECT sum(self_money) as total_money,u_key FROM ".DB_PREFIX."deal_load_repay WHERE has_repay=1 AND deal_id=".$id." group by u_key ");
					$self_money_list = array();
					foreach($temp_self_money_list as $k=>$v){
						$self_money_list[$v['u_key']]= $v['total_money'];
					}
					
					foreach($load_list as $k=>$v){
						$load_list[$k]['remain_money'] = $v['money'] -$self_money_list[$k];
						if($load_list[$k]['remain_money'] <=0){
							$load_list[$k]['remain_money'] = 0;
							$load_list[$k]['status'] = 1;
						}
					}
				}
			}	

			$user_statics = sys_user_status($deal['user_id'],true);
			$GLOBALS['tmpl']->assign("user_statics",$user_statics);
			$GLOBALS['tmpl']->assign("company",$company);
			
			
			if($deal['uloadtype'] == 1){
				$has_bid_money = $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id);
				$GLOBALS['tmpl']->assign("has_bid_money",$has_bid_money);
				$GLOBALS['tmpl']->assign("has_bid_portion",intval($has_bid_money)/($deal['borrow_amount']/$deal['portion']));
			}
		}
		
		$GLOBALS['tmpl']->assign("load_list",$load_list);	
		$GLOBALS['tmpl']->assign("load_total_money",$load_total_money);	
		$GLOBALS['tmpl']->assign("credit_file",$credit_file);
		$GLOBALS['tmpl']->assign("u_info",$u_info);
				
		if($deal['type_match_row'])
			$seo_title = $deal['seo_title']!=''?$deal['seo_title']:$deal['type_match_row'] . " - " . $deal['name'];
		else
			$seo_title = $deal['seo_title']!=''?$deal['seo_title']: $deal['name'];
			
		$GLOBALS['tmpl']->assign("page_title",$seo_title);
		$seo_keyword = $deal['seo_keyword']!=''?$deal['seo_keyword']:$deal['type_match_row'].",".$deal['name'];
		$GLOBALS['tmpl']->assign("page_keyword",$seo_keyword.",");
		$seo_description = $deal['seo_description']!=''?$deal['seo_description']:$deal['name'];
		$GLOBALS['tmpl']->assign("seo_description",$seo_description.",");
		
		//留言
		require APP_ROOT_PATH.'app/Lib/message.php';
		require APP_ROOT_PATH.'app/Lib/page.php';
		
		$rel_table = 'deal';
		
		$message_type = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."message_type where type_name='".$rel_table."'");
		$condition = "rel_table = '".$rel_table."' and rel_id = ".$id;
	
		if(app_conf("USER_MESSAGE_AUTO_EFFECT")==0)
		{
			$condition.= " and user_id = ".intval($GLOBALS['user_info']['id']);
		}
		else 
		{
			if($message_type['is_effect']==0)
			{
				$condition.= " and user_id = ".intval($GLOBALS['user_info']['id']);
			}
		}
		
		//message_form 变量输出
		$GLOBALS['tmpl']->assign('rel_id',$id);
		$GLOBALS['tmpl']->assign('rel_table',$rel_table);
		
		//分页
		$page = intval($_REQUEST['p']);
		if($page==0)
		$page = 1;
		$limit = (($page-1)*app_conf("PAGE_SIZE")).",".app_conf("PAGE_SIZE");
		$msg_condition = $condition." AND is_effect = 1 ";
		$message = get_message_list($limit,$msg_condition);
		
		$page = new Page($message['count'],app_conf("PAGE_SIZE"));   //初始化分页对象 		
		$p  =  $page->show();
		$GLOBALS['tmpl']->assign('pages',$p);
		
		foreach($message['list'] as $k=>$v){
			$msg_sub = get_message_list("","pid=".$v['id'],false);
			$message['list'][$k]["sub"] = $msg_sub["list"];
		}
		
		$GLOBALS['tmpl']->assign("message_list",$message['list']);
		if(!$GLOBALS['user_info'])
		{
			$GLOBALS['tmpl']->assign("message_login_tip",sprintf($GLOBALS['lang']['MESSAGE_LOGIN_TIP'],url("shop","user#login"),url("shop","user#register")));
		}
		
		//配资列表
    	$sql_str = "select pc.name as conf_type_name,a.*,AES_DECRYPT(a.stock_pwd_encrypt,'".AES_DECRYPT_KEY."') as stock_pwd, u.user_name, AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as user_money, m.adm_name, a.cost_money+a.borrow_money as total_money
					,iu.user_name as invest_user_name from ".DB_PREFIX."peizi_order a
					LEFT JOIN ".DB_PREFIX."user u on u.id = a.user_id
					LEFT JOIN ".DB_PREFIX."user iu on iu.id = a.invest_user_id
					LEFT JOIN ".DB_PREFIX."peizi_conf pc on pc.id = a.peizi_conf_id
					LEFT JOIN ".DB_PREFIX."admin m on m.id = a.admin_id  where 1 = 1 AND a.deal_id =".$id;
		$peizi_list = $GLOBALS['db']->getAll($sql_str,false);
		if($peizi_list){
			require_once APP_ROOT_PATH."/system/libs/peizi.php";
			foreach ($peizi_list as $k => $v) {
				//配资类型 
				$peizi_list[$k] = get_peizi_order_fromat($v);
				if($v["rate_money"] == 0)
				{
					$peizi_list[$k]["last_fee_date"] = $v["next_fee_date"];
				}
			}
			$GLOBALS['tmpl']->assign("peizi_list",$peizi_list);
		}

		//投资服务协议编号
		$load_service_agreement = $GLOBALS['db']->getRow("SELECT value FROM ".DB_PREFIX."conf WHERE is_effect=1 and name = 'LOAD_SERVICE_AGREEMENT'");
		//借款合同编号
		$deal_load_agreement = $GLOBALS['db']->getRow("SELECT value FROM ".DB_PREFIX."conf WHERE is_effect=1 and name = 'DEAL_LOAD_AGREEMENT'");
		$GLOBALS['tmpl']->assign("load_service_agreement",$load_service_agreement['value']);
		$GLOBALS['tmpl']->assign("deal_load_agreement",$deal_load_agreement['value']);

		$GLOBALS['tmpl']->assign("deal",$deal);

		//获取其他U计划列表
		//XHF 2016/7/29
		$limit = " 0,10";
		$n_cate_id = 0;
		$condition = " publish_wait = 0 and is_hidden = 0 and id<>".$id." and deal_status in (1,2,4,5)";
		$orderby = " id desc";
		$uplans = get_deal_list("0,10",0,$condition,$orderby,'','',false,'uplan');
		$GLOBALS['tmpl']->assign("deal_list",$uplans['list']);
		//end

		$GLOBALS['tmpl']->display("page/uplan.html");
	}
	
	function bid(){
		//检测是否系统维护模式
		$this->forbid_system_repair_mode(true);

		$id = intval($_REQUEST['id']);
		$bidmoney = strim($_REQUEST['bidmoney']);
		
		$return = array("status"=>0,"info"=>"");

		//投资金额10的倍数
		if($bidmoney%10 != 0){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
			ajax_return($return);
		}		
		
		if(!$GLOBALS['user_info']){
			$return["status"] = 2;
			$return["info"] = $GLOBALS['lang']['PLEASE_LOGIN_FIRST'];
			$return["jump"] = url("index","user#login"); 
			ajax_return($return);
		}

		if(!$_REQUEST['agreement']){
			$return["status"] = 0;
			$return["info"] = "请同意 委托投资协议";
			ajax_return($return);
		}
	
		if(floatval($bidmoney)<=0){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
			ajax_return($return);
		}
		
		$deal = get_deal($id);		
		if(!$deal){
			$return["status"] = 0;
			$return["info"] = "借款不存在";
			ajax_return($return);
		}

		if(trim($deal['mer_bill_no']) != ""){
			$mer_bill_no = trim($deal['mer_bill_no']);
			$password = trim($_REQUEST['password']);
			if ($mer_bill_no != $password) {
				$return["status"] = 0;
				$return["info"] = "密码输入错误，请重新输入";
				ajax_return($return);
			}
		}

		if($deal['user_id'] == $GLOBALS['user_info']['id']){
			$return["status"] = 0;
			$return["info"] = $GLOBALS['lang']['CANT_BID_BY_YOURSELF'];
			ajax_return($return);
		}
		
		if($deal['ips_bill_no']!="" && $GLOBALS['user_info']['ips_acct_no']==""){
			$return["status"] = 0;
			$return["info"] = "此标为第三方托管标，请先绑定第三方托管账户";
			$return["jump"] = url("index","uc_center");
			ajax_return($return);
		}
		
		//判断是否是新手专享
		if($deal['is_new']==1 &&  $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load  WHERE user_id=".$GLOBALS['user_info']['id']." ") > 0){
			$return["status"] = 0;
			$return["info"] = "此标为新手专享标，您已经投过了";
			ajax_return($return);
		}
		
		$has_bid_money = $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id);
		if($deal['uloadtype'] == 1 ){
			if(floatval($bidmoney)%intval($bidmoney)!=0){
				$return["status"] = 0;
				$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
				ajax_return($return);
			}
			else{
				$has_bid_portion = intval($has_bid_money)/($deal['borrow_amount']/$deal['portion']);
				if ($deal['max_portion'] > 0 ){
					if(intval($bidmoney) > ($deal['max_portion'] - $has_bid_portion)){
						$return["status"] = 0;
						$return["info"] = "您已经购买了{$has_bid_portion}份，还能购买".($deal['max_portion'] - $has_bid_portion)."份";
						ajax_return($return);
					}
				}
				elseif(intval($bidmoney) > $deal['need_portion']){
					$return["status"] = 0;
					$return["info"] = "您已经购买了{$has_bid_portion}份，还能购买".($deal['need_portion'])."份";
					ajax_return($return);
				}
			}
			$bidmoney = $bidmoney*($deal['borrow_amount']/$deal['portion']);
		} elseif($deal['uloadtype'] == 0) {
			if(((int)app_conf('DEAL_BID_MULTIPLE') > 0 && floatval($bidmoney)%app_conf('DEAL_BID_MULTIPLE')!=0) || floatval($bidmoney)< $deal['min_loan_money'] || ($deal['max_loan_money'] > 0 && floatval($bidmoney)>$deal['max_loan_money'])){
				$return["status"] = 0;
				$return["info"] = $GLOBALS['lang']['BID_MONEY_NOT_TRUE'];
				ajax_return($return);
			}
		}
	
		$GLOBALS['tmpl']->assign("deal",$deal);
		$GLOBALS['tmpl']->assign("bidmoney",$bidmoney);
		
		if($deal['use_ecv'] == 1){
			//红包抵用
			$user_id = intval($GLOBALS['user_info']['id']);
			$sql = "select e.*,et.name from ".DB_PREFIX."ecv as e left join ".DB_PREFIX."ecv_type as et on e.ecv_type_id = et.id where e.user_id = ".$user_id." AND if(e.use_limit > 0 ,(e.use_limit - e.use_count) > 0,1=1) AND if(e.begin_time >0 , e.begin_time < ".TIME_UTC.",1=1) AND if(e.end_time>0,(e.end_time + 24*3600 - 1) > ".TIME_UTC.",1=1)  order by e.id desc ";
			$ecv_list = $GLOBALS['db']->getAll($sql);
			$GLOBALS['tmpl']->assign("ecv_list",$ecv_list);
		}
		
		$return["status"] = 1;
		$return["info"] = $GLOBALS['tmpl']->fetch("page/deal_bid.html");
		ajax_return($return);
	}	
}
?>
