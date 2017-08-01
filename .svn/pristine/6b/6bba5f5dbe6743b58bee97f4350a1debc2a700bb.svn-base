<?php

/**
 * XHF 2016/8/25
 * 新增控制器,投资有礼,购买即完成计划表创建
 * deal表 ext 字段名为 presents
 * deal表增加字段 reserve1 保存相关设置
 */

require APP_ROOT_PATH.'app/Lib/deal.php';
require 'dealModule.class.php';
class presentModule extends dealModule
{
	function index(){		
		$id = intval($_REQUEST['id']);
		
		$deal = get_deal($id);

		if(!$deal || $deal['ext'] != 'present') {
			app_redirect(url("index")); 
		}

		//选择商品
		$present_id = intval($_REQUEST['present_id']);
		$present = $this->get_present($id, $present_id);
		
		//产品列表
		$load_list = $GLOBALS['db']->getAll("SELECT deal_id,user_id,user_name,money,is_auto,create_time FROM ".DB_PREFIX."deal_load WHERE deal_id = ".$id." order by id ASC ");
		//产品总额
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

			$user_statics = sys_user_status($deal['user_id'],true);
			$GLOBALS['tmpl']->assign("user_statics",$user_statics);
			$GLOBALS['tmpl']->assign("company",$company);
			
			
			if($deal['uloadtype'] == 1){
				$has_bid_money = $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id);
				$GLOBALS['tmpl']->assign("has_bid_money",$has_bid_money);
				$GLOBALS['tmpl']->assign("has_bid_portion",intval($has_bid_money)/($deal['borrow_amount']/$deal['portion']));
			}
		}
		
		$user_address = $GLOBALS['db']->getAll("SELECT * from ".DB_PREFIX."user_address where user_id = ".$GLOBALS['user_info']['id']);

		$GLOBALS['tmpl']->assign("load_list",$load_list);	
		$GLOBALS['tmpl']->assign("load_total_money",$load_total_money);	
		$GLOBALS['tmpl']->assign("u_info",$u_info);
		$GLOBALS['tmpl']->assign("user_address",$user_address);

		//投资服务协议编号
        //后台平台推广文章列表
		$load_service_agreement = 135;
		$GLOBALS['tmpl']->assign("load_service_agreement",$load_service_agreement['value']);

		$GLOBALS['tmpl']->assign("deal",$deal);
		$GLOBALS['tmpl']->assign("present",$present);
		$GLOBALS['tmpl']->display("page/present.html");
	}
	
	function bid(){
		$id = intval($_REQUEST['id']);
		$present_id = intval($_REQUEST['present_id']);
		$bidmoney = strim($_REQUEST['bidmoney']);
		
		$return = array("status"=>0,"info"=>"");
		
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
			$return["info"] = "产品不存在";
			ajax_return($return);
		}

		//判断最小投资金额
		$present = $this->get_present($id, $present_id);
		if (!$present) {
			$return["status"] = 0;
			$return["info"] = $id."无效的关联礼品".$present_id;
			ajax_return($return);
		}

		if (intval($bidmoney) < intval($present)) {
			$return["status"] = 0;
			$return["info"] = "最小认购金额不正确";
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

		//判断是否已投过新手标
		if(($deal['is_new']==1 || $deal['ext'] == 'newe') && $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load  WHERE user_id=".$GLOBALS['user_info']['id']." ") > 0){
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
			$bidmoney = $bidmoney*($deal['borrow_amount']/$deal['portion']);
		}
		elseif($deal['uloadtype'] == 0)
		{
			if(((int)app_conf('DEAL_BID_MULTIPLE') > 0 && floatval($bidmoney)%app_conf('DEAL_BID_MULTIPLE')!=0) || floatval($bidmoney)< $deal['min_loan_money'] || ($deal['max_loan_money'] > 0 && floatval($bidmoney)>$deal['max_loan_money']) || $bidmoney%100 != 0){
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
	
	function dobid(){
		$ajax = intval($_REQUEST["ajax"]);

		$id = intval($_REQUEST["id"]);		
		$bid_money = floatval($_REQUEST["bid_money"]);
		$bid_paypassword = strim(FW_DESPWD($_REQUEST['bid_paypassword']));
		$ecv_id = intval($_REQUEST["ecv_id"]);
		
		//判断最小投资金额
		$present = $this->get_present($id, $present_id);
		if (intval($bidmoney) < intval($present)) {
			$return["status"] = 0;
			$return["info"] = "最小认购金额不正确";
			ajax_return($return);
		}

		$status = dobid2($id,$bid_money,$bid_paypassword,1,$ecv_id);

		if($status['status'] == 0){
			showErr($status['show_err'],$ajax);
		}elseif($status['status'] == 2){
			ajax_return($status);
		}elseif($status['status'] == 3){
			showSuccess("余额不足，请先去充值",$ajax,url("index","uc_money#incharge"));
		}elseif($status['status'] == 4) {
			$status['info'] = "余额不足，无法投标，立即去充值";
			$status['jump'] = "member.php?ctl=uc_money&act=incharge";
			ajax_return($status);
		}else{
            require_once APP_ROOT_PATH.'system/libs/user.php';
            require_once APP_ROOT_PATH.'system/common_ext.php';
            require_once APP_ROOT_PATH.'app/Lib/common.php';

            // 生成还款计划与回款计划
            $result = do_loans_new($id,TIME_UTC,0,$GLOBALS['user_info']['id'],$bid_money);
            if ($result['status'] == 1) {
				//创建投资礼品订单
				$result = $this->create_present_order();
				if ($result['status'] == 1) {
					showSuccess("投标成功，礼品发放成功",$ajax,url("index"));
				} else {
					showErr("投标成功，礼品发放失败",$ajax,url("index"));
				}
            } else {
    			showErr("还款回款计划生成失败",$ajax,url("index"));
            }
		}
	}

	//创建投资礼品订单信息
	function create_present_order() {
		$status = array('status'=>1, 'info'=>'');

		$present_id = intval($_REQUEST["present_id"]);
		$data_addr = array();
		//获取用户的地址信息
		if (isset($_REQUEST["address_id"]) && intval($_REQUEST["address_id"]) > 0) {
			$address_id = intval($_REQUEST["address_id"]);
			$data_addr = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_address where id=".$address_id);
		} else {
			$data_addr['user_id'] = $GLOBALS['user_info']['id'];
			$data_addr['name'] = trim($_REQUEST["address_name"]);
			$data_addr['address'] = trim($_REQUEST["address_address"]);
			$data_addr['phone'] = trim($_REQUEST["address_phone"]);
			$data_addr['is_default'] = 1;
			$data_addr['zip_code'] = isset($_REQUEST["address_zip_code"])? trim($_REQUEST["address_zip_code"]) : '';
			//添加新的收货地址
			$list = $GLOBALS['db']->autoExecute(DB_PREFIX."user_address",$data_addr,"INSERT");

			if (!$list) {
				$status['status'] = 0;
				$status['info'] = '收货地址信息添加失败';
				return $status;
			}
		}

		//投资礼品
		$data_order['order_sn'] = date('YmdHis',TIME_UTC).rand(10,99);
		$data_order['goods_id'] = $present_id;
		$data_order['goods_name'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."goods where ext='present' and id=".$present_id);
		$data_order['score'] = 0;
		$data_order['total_score'] = 0;
		$data_order['number'] = 1;
		$data_order['order_status'] = 0;
		$data_order['user_id'] = $GLOBALS['user_info']['id'];
		$data_order['ex_time'] = TIME_UTC;
		$data_order['ex_date'] = date('Y-m-d', TIME_UTC);
		$data_order['delivery_time'] = 0;
		$data_order['delivery_date'] = '';
		$data_order['delivery_addr'] = $data_addr['address'];
		$data_order['delivery_tel'] = $data_addr['phone'];
		$data_order['delivery_name'] = $data_addr['name'];
		$data_order['is_delivery'] = 1;
		$data_order['attr_stock_id'] = 0;
		$data_order['memo'] = isset($_REQUEST["address_comment"])? trim($_REQUEST["address_comment"]) : '';
		$data_order['loan_money'] = floatval($_REQUEST["bid_money"]);
		$data_order['ext'] = 'present';

		//创建订单信息
		$list = $GLOBALS['db']->autoExecute(DB_PREFIX."goods_order",$data_order,"INSERT");

		if (false !== $list) {
			$status['status'] = 1;
			$status['info'] = '订单创建成功';
			return $status;
		} else {
			$status['status'] = 0;
			$status['info'] = '订单创建失败';
			return $status;
		}

		return $status;
	}

	//获取present信息
	function get_present($deal_id, $present_id) {
		$deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where ext='present' and id=".$deal_id);

		if (!$deal) { return null; }

		$deal['present'] = unserialize($deal['reserve1']);
		//选择商品
		$present = null;
		foreach ($deal['present'] as $v) {
			if ($v['id'] != $present_id) { continue; }
			$present = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."goods where ext='present' and id=".$present_id);
			$present['min_loan_money'] = $v['min_loan_money'];
			break;
		}

		return $present;
	}
}
?>