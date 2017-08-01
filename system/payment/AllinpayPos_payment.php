<?php

$payment_lang = array(
	'name'	=>	'POS机充值接口',
	'merchant_id'	=>	'商户号',
	'agree_password'	=>	'约定密码',
);

$config = array( 
	'merchant_id'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //商户号:
	'agree_password'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //约定的密码
);

/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == TRUE)
{
    $module['class_name']    = 'AllinpayPos';

    /* 名称 */
    $module['name']    = $payment_lang['name'];


    /* 支付方式：1：在线支付；0：线下支付；4：POS机支付*/
    $module['online_pay'] = '4';
    
     /* 配送 */
    $module['config'] = $config;
    
    $module['lang'] = $payment_lang;
       
    return $module;
}

// 通联支付模型
require_once(APP_ROOT_PATH.'system/libs/payment.php');
require_once APP_ROOT_PATH."system/libs/user.php";
class AllinpayPos_payment implements payment {
	
	public function get_payment_code($payment_notice_id)
	{
		//
	}
	
	public function get_display_code(){
    	//
    }
	
	public function response($request)
	{
		//
	}

	public function notify($request)
	{
		//
	}

	public function pay_confirm($xml_data) 
	{
		$data = simplexml_load_string($xml_data);
		$trxId =  $data->trxId; //交易流水号
        $timestamp = $data->timestamp;//交易时间,Yyyymmddhhmmss
        $bizseq =  $data->bizseq; //业务流水号,协议号,订单号
        $amount = $data->amount/100;//金额,原始单位分 转换为元
        $payseq = $data->payseq;//检索参考号
        $batchid = $data->batchid;//批次号
        $acctinst =$data->acctinst;//支付账户所属银行号

		$pay_time = strtotime($timestamp);
		$pay_date = date('Y-m-d',$pay_time);

		// POS充值单更新
		$sql = "update ".DB_PREFIX."payment_notice set sign='".$xml_data."', pay_time=".$pay_time. ",pay_date='".$pay_date."', outer_notice_sn='{$payseq}', is_paid=1 where notice_sn='{$bizseq}'";
		
		$GLOBALS['db']->query($sql);

		$res = $GLOBALS['db']->getRow("select id, user_id, input_user_id from ".DB_PREFIX."payment_notice where notice_sn='{$bizseq}'");

		// 修改用户的账户金额
		modify_account(array('money'=>$amount),$res['user_id'],'POS机充值',1,$res['input_user_id']);
		return;
	}	

	public function query_order($bizseq) 
	{
		// 查询订单号是否存在
		$result = $GLOBALS['db']->getRow("select id, notice_sn, money from ".DB_PREFIX."payment_notice where notice_sn='{$bizseq}' and is_paid=0");
		if ($result && count($result)) {
			return $result; 
		} else {
			return false; 
		}
	}

	public function get_agree_password () 
	{
		$payment_info = $GLOBALS['db']->getRow("select id,config,logo from ".DB_PREFIX."payment where class_name='AllinpayPos'");
		$payment_info['config'] = unserialize($payment_info['config']);
		return $payment_info['config']['agree_password'];
	}
}
?>