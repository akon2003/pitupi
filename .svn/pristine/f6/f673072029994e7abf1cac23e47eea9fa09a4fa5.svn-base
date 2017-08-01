<?php

$payment_lang = array(
	'name'	=>	'通联支付',
	'merchant_id'	=>	'商户号',
	'md5_key'		=>	'MD5校验码',
	'GO_TO_PAY'		=>	'前往通联支付',
	'VALID_ERROR'	=>	'支付验证失败',
	'PAY_FAILED'	=>	'支付失败',
	'allinpay_gateway'		=>	'支持的银行',
	'allinpay_gateway_cmb'	=>	'招商银行(支持借、贷)',
	'allinpay_gateway_icbc'	=>	'工商银行(支持借、贷)',
	'allinpay_gateway_ccb'	=>	'建设银行(支持借、贷)',
	'allinpay_gateway_abc'	=>	'农业银行(支持借、贷)',
	'allinpay_gateway_cmbc'	=>	'民生银行(支持借、贷)',
	'allinpay_gateway_spdb'	=>	'浦发银行(支持借、贷)',
	'allinpay_gateway_hxb'	=>	'华夏银行(支持借、贷)',
	'allinpay_gateway_cgb'	=>	'广发银行(支持借)',
	'allinpay_gateway_cib'	=>	'兴业银行(支持借、贷)',
	'allinpay_gateway_ceb'	=>	'光大银行(支持借、贷)', //无安全链接
	'allinpay_gateway_comm'	=>	'交通银行(支持借、贷)', //未找到符合条件的路由
	'allinpay_gateway_boc'	=>	'中国银行(支持借、贷)', //无安全链接
	'allinpay_gateway_citic'	=>	'中信银行(支持借、贷)',
	'allinpay_gateway_bos'		=>	'上海银行(支持借)',
	'allinpay_gateway_pingan'	=>	'平安银行(支持借)',
	'allinpay_gateway_psbc'		=>	'邮政储蓄(支持借、贷)',
	'allinpay_gateway_b1669'	=>	'枣庄银行(支持借、贷)',
	'allinpay_gateway_b1552'	=>	'汉口银行(支持借、贷)',
	'allinpay_gateway_b1608'	=>	'齐商银行(支持借)',
	'allinpay_gateway_b1629'	=>	'泰安银行(支持借)',
);

$config = array( 
	'merchant_id'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //商户号:
	'md5_key'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //校验码
	'allinpay_gateway'	=>	array(
		'INPUT_TYPE'	=>	'3',
		'VALUES'	=>	array(
			'cmb',//'招商银行',
			'icbc',//'工商银行',
			'ccb',//'建设银行',
			'abc',//'农业银行',
			'cmbc',//'民生银行',
			'spdb',//'浦发银行',
			'hxb',//'华夏银行',
			'cgb',//'广发银行',
			'cib',//'兴业银行',
			'ceb',//'光大银行',
			'comm',//'交通银行',
			'boc',//'中国银行',
			'citic',//'中信银行',
			'bos',//'上海银行',
			'pingan',//'平安银行',
			'psbc',//'邮政储蓄',
			'b1669',//'枣庄银行',
			'b1552',//'汉口银行',
			'b1608',//'齐商银行',
			'b1629',//'泰安银行',
			//'vbank',//'虚拟银行',
		)
	), //可选的银行网关
);

/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == TRUE)
{
    $module['class_name']    = 'Allinpay';

    /* 名称 */
    $module['name']    = $payment_lang['name'];


    /* 支付方式：1：在线支付；0：线下支付 */
    $module['online_pay'] = '1';
    
     /* 配送 */
    $module['config'] = $config;
    
    $module['lang'] = $payment_lang;
       
    return $module;
}

// 通联支付模型
require_once(APP_ROOT_PATH.'system/libs/payment.php');
class Allinpay_payment implements payment {
	
	public function get_payment_code($payment_notice_id)
	{
		$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where id = ".$payment_notice_id);
		$money = round($payment_notice['money'],2);
		$bank_id = $payment_notice['bank_id'];
		$payment_info = $GLOBALS['db']->getRow("select id,config,logo from ".DB_PREFIX."payment where id=".intval($payment_notice['payment_id']));
		$payment_info['config'] = unserialize($payment_info['config']);
				
		$data_return_url = SITE_DOMAIN.APP_ROOT.'/index.php?ctl=payment&act=response&class_name=Allinpay';
		$data_notify_url = SITE_DOMAIN.APP_ROOT.'/index.php?ctl=payment&act=notify&class_name=Allinpay';
		$serverUrl		 = 'https://service.allinpay.com/gateway/index.do';
		$merchant_acctid = trim($payment_info['config']['merchant_id']);  //人民币账号 不可空
		$key             = trim($payment_info['config']['md5_key']);

		$inputCharset=1;//1. 字符集:
		$pickupUrl=$data_return_url;//2. 取货地址:
		$receiveUrl=$data_notify_url;//3. 商户系统通知地址:
		$version='v1.0';//4. 版本号:
		$language=1;//5. 语言:
		$signType=1;//6. 签名类型:
		$merchantId= $merchant_acctid;//7. 商户号:
		$payerName=$_REQUEST['user_info']['real_name'];//8. 付款人姓名:
		$payerEmail='';//9. 付款人联系email:
		$payerTelephone=$_REQUEST['user_info']['mobile'];//10. 付款人电话:
		$payerIDCard='';//11. 付款人证件号:
		$pid='';//12. 合作伙伴商户号:
		$orderNo= $payment_notice['notice_sn'];//13. 商户系统订单号:
		$orderAmount= $money * 100;//14. 订单金额(单位分):
		$orderCurrency='';//15. 订单金额币种类型:
		$orderDatetime= to_date(TIME_UTC, 'YmdHis');//16. 商户的订单提交时间:

		$orderExpireDatetime='';//17. 订单过期时间:
		$productName='';//18. 商品名称:
		$productPrice='';//20. 商品价格:
		$productNum='';//21. 商品数量:
		$productId='';//19. 商品代码:
		$productDesc='';//22. 商品描述:
		$ext1='';//23. 扩展字段1:
		$ext2='';//24. 扩展字段2:
		$extTL='';//25. 业务扩展字段:
		$payType=1; //26. 支付方式: payType 不能为空，必须放在表单中提交。
		$issuerId=$bank_id; //27. 发卡方代码: issueId 直联时不为空，必须放在表单中提交。
		$pan='';//28. 付款人支付卡号:
		$tradeNature='GOODS';//29. 贸易类型:


		// 生成签名字符串。
		$bufSignSrc="";
		if($inputCharset != "")
			$bufSignSrc=$bufSignSrc."inputCharset=".$inputCharset."&";
		if($pickupUrl != "")
			$bufSignSrc=$bufSignSrc."pickupUrl=".$pickupUrl."&";
		if($receiveUrl != "")
			$bufSignSrc=$bufSignSrc."receiveUrl=".$receiveUrl."&";
		if($version != "")
			$bufSignSrc=$bufSignSrc."version=".$version."&";
		if($language != "")
			$bufSignSrc=$bufSignSrc."language=".$language."&";
		if($signType != "")
			$bufSignSrc=$bufSignSrc."signType=".$signType."&";
		if($merchantId != "")
			$bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";
		if($payerName != "")
			$bufSignSrc=$bufSignSrc."payerName=".$payerName."&";
		if($payerEmail != "")
			$bufSignSrc=$bufSignSrc."payerEmail=".$payerEmail."&";
		if($payerTelephone != "")
			$bufSignSrc=$bufSignSrc."payerTelephone=".$payerTelephone."&";
		if($payerIDCard != "")
			$bufSignSrc=$bufSignSrc."payerIDCard=".$payerIDCard."&";
		if($pid != "")
			$bufSignSrc=$bufSignSrc."pid=".$pid."&";
		if($orderNo != "")
			$bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
		if($orderAmount != "")
			$bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
		if($orderCurrency != "")
			$bufSignSrc=$bufSignSrc."orderCurrency=".$orderCurrency."&";
		if($orderDatetime != "")
			$bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
		if($orderExpireDatetime != "")
			$bufSignSrc=$bufSignSrc."orderExpireDatetime=".$orderExpireDatetime."&";
		if($productName != "")
			$bufSignSrc=$bufSignSrc."productName=".$productName."&";
		if($productPrice != "")
			$bufSignSrc=$bufSignSrc."productPrice=".$productPrice."&";
		if($productNum != "")
			$bufSignSrc=$bufSignSrc."productNum=".$productNum."&";
		if($productId != "")
			$bufSignSrc=$bufSignSrc."productId=".$productId."&";
		if($productDesc != "")
			$bufSignSrc=$bufSignSrc."productDesc=".$productDesc."&";
		if($ext1 != "")
			$bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
		if($ext2 != "")
			$bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
		if($extTL != "")
			$bufSignSrc=$bufSignSrc."extTL".$extTL."&";
		if($payType !== "")
			$bufSignSrc=$bufSignSrc."payType=".$payType."&";
		if($issuerId != "")
			$bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
		if($pan != "")
			$bufSignSrc=$bufSignSrc."pan=".$pan."&";
		if($tradeNature != "")
			$bufSignSrc=$bufSignSrc."tradeNature=".$tradeNature."&";
		$bufSignSrc=$bufSignSrc."key=".$key;
		
		//签名，设为signMsg字段值。
		$signMsg = strtoupper(md5($bufSignSrc));

        $def_url  = '<div style="text-align:center"><form name="form2" style="text-align:center;" method="post" action='.$serverUrl.' target="_blank">';
        
        $def_url .= "<input type='hidden' name='inputCharset' id='inputCharset'  value='" . $inputCharset . "' />";  
        $def_url .= "<input type='hidden' name='pickupUrl' id='pickupUrl'  value='" . $pickupUrl . "' />";
        $def_url .= "<input type='hidden' name='receiveUrl' id='receiveUrl'  value='" . $receiveUrl . "' />";
        
        $def_url .= "<input type='hidden' name='version' id='version'  value='" . $version . "' />";
        $def_url .= "<input type='hidden' name='language' id='language'  value='" . $language . "' />";               
        $def_url .= "<input type='hidden' name='signType' id='signType'  value='" . $signType . "' />";
        
        $def_url .= "<input type='hidden' name='merchantId' id='merchantId'  value='" . $merchantId . "' />";
        $def_url .= "<input type='hidden' name='payerName' id='payerName'  value='" . $payerName . "' />";        
        $def_url .= "<input type='hidden' name='payerEmail' id='payerEmail'  value='" . $payerEmail . "' />";   
             
        $def_url .= "<input type='hidden' name='payerTelephone' id='payerTelephone'  value='" . $payerTelephone . "' />";
        $def_url .= "<input type='hidden' name='payerIDCard' id='payerIDCard'  value='" . $payerIDCard . "' />";
        $def_url .= "<input type='hidden' name='pid' id='pid'  value='" . $pid . "' />";      
                  
        $def_url .= "<input type='hidden' name='orderNo' id='orderNo'  value='" . $orderNo . "' />";
        $def_url .= "<input type='hidden' name='orderAmount' id='orderAmount'  value='" . $orderAmount . "' />";
        $def_url .= "<input type='hidden' name='orderCurrency' id='orderCurrency'  value='" . $orderCurrency . "' />"; 
               
        $def_url .= "<input type='hidden' name='orderDatetime' id='orderDatetime'  value='" . $orderDatetime . "' />";
        $def_url .= "<input type='hidden' name='orderExpireDatetime' id='orderExpireDatetime'  value='" . $orderExpireDatetime . "' />";        
        $def_url .= "<input type='hidden' name='productName' id='productName'  value='" . $productName . "' />";
        
        $def_url .= "<input type='hidden' name='productPrice' id='productPrice'  value='" . $productPrice . "' />";  
        $def_url .= "<input type='hidden' name='productNum' id='productNum'  value='" . $productNum . "' />";
        $def_url .= "<input type='hidden' name='productId' id='productId'  value='" . $productId . "' />";
        
        $def_url .= "<input type='hidden' name='productDesc' id='productDesc'  value='" . $productDesc . "' />";
        $def_url .= "<input type='hidden' name='ext1' id='ext1'  value='" . $ext1 . "' />";
        $def_url .= "<input type='hidden' name='ext2' id='ext2'  value='" . $ext2 . "' />";
        
        $def_url .= "<input type='hidden' name='extTL' id='extTL'  value='" . $extTL . "' />";
        $def_url .= "<input type='hidden' name='payType' id='payType'  value='" . $payType . "' />";
        $def_url .= "<input type='hidden' name='issuerId' id='issuerId'  value='" . $issuerId . "' />";  
              
        $def_url .= "<input type='hidden' name='pan' id='pan'  value='" . $pan . "' />";
        $def_url .= "<input type='hidden' name='tradeNature' id='tradeNature'  value='" . $tradeNature . "' />";
        $def_url .= "<input type='hidden' name='signMsg' id='signMsg'  value='" . $signMsg . "' />";     
           
        $def_url .= "<input type='submit' name='submit' class='paybutton' value='确认付款，到通联支付去啦' />";
        $def_url .= "</form></div></br>";
		$def_url .="<br /><span class='red'>".$GLOBALS['lang']['PAY_TOTAL_PRICE'].":".format_price($money)."</span>";
        return $def_url;
	}
	
	public function get_display_code(){
       $payment_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment where class_name='Allinpay'");
		if($payment_item)
		{
			$payment_cfg = unserialize($payment_item['config']);
			$html = "<style type='text/css'>.allinpay_types{background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/banklogo.gif) no-repeat 0 0; float:left; display:block;width:150px; height:14px;font-size:0px;  text-align:left; padding:15px 0px;}";
	        $html .=".allinpay_types input{margin:0 }";
	        $html .=".bk_type_cmb {background-position:10px -447px}"; //招商银行
	        $html .=".bk_type_icbc {background-position:10px -406px}"; //工商银行
	        $html .=".bk_type_ccb {background-position:10px -85px}"; //建设银行
	        $html .=".bk_type_abc {background-position:10px -47px}"; //农业
	        $html .=".bk_type_cmbc {background-position:10px -167px}"; //民生银行
	        $html .=".bk_type_spdb {background-position:10px -366px}"; //浦发银行
	        $html .=".bk_type_hxb {background-position:10px -1349px}"; //华夏银行
	        $html .=".bk_type_cgb {background-position:10px -246px}"; //广发银行
	        $html .=".bk_type_cib {background-position:10px -486px}"; //兴业银行
	        $html .=".bk_type_ceb {background-position:10px -126px}"; //光大银行
	        $html .=".bk_type_comm {background-position:10px -205px}"; //交通银行
	        $html .=".bk_type_boc {background-position:10px -829px}"; //中国银行
	        $html .=".bk_type_citic {background-position:10px -287px}"; //中信银行
	        $html .=".bk_type_bos {background-position:10px -1599px}"; //上海银行
	        $html .=".bk_type_pingan {background-position:10px -901px}"; //平安银行
	        $html .=".bk_type_psbc {background-position:5px -526px}"; //邮政储蓄
	        $html .=".bk_type_b1669 {background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/b1669.gif) no-repeat 0 0;}"; //枣庄银行
	        $html .=".bk_type_b1552 {background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/b1552.gif) no-repeat 0 0;}"; //汉口银行
	        $html .=".bk_type_b1608 {background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/b1608.gif) no-repeat 0 0;}"; //齐商银行
	        $html .=".bk_type_b1629 {background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/b1629.gif) no-repeat 0 0;}"; //泰安银行
	        $html .=".bk_type_vbank {background:url(".SITE_DOMAIN.APP_ROOT."/system/payment/Allinpay/vbank.jpg) no-repeat 0 0;}"; //虚拟银行
	        $html .="</style>";
	        $html .="<script type='text/javascript'>function set_bank(bank_id)";
			$html .="{";
			$html .="$(\"input[name='bank_id']\").val(bank_id).trigger('update');";
			$html .="}</script>";
			$is_show_jieji = false;
			$is_show_xyk = false;
	        foreach ($payment_cfg['allinpay_gateway'] as $key=>$val) {
	            $html  .= "<label class='allinpay_types bk_type_".$key." ui-radiobox' rel='common_payment' title='".$this->payment_lang["allinpay_gateway_".$key]."' ><input type='radio' name='payment' value='".$payment_item['id']."' rel='".$key."' onclick='set_bank(\"".$key."\")' /></label>";
	        }
	        $html .= "<input type='hidden' name='bank_id' /><div class='blank'></div>";
			return $html;
		}
		else{
			return '';
		}
    }
	
	public function response($request)
	{
		$return_res = array(
			'info'=>'',
			'status'=>false,
		);

		require_once(APP_ROOT_PATH.'system/payment/Allinpay/php_rsa.php');
		$publickeyfile = APP_ROOT_PATH.'system/payment/Allinpay/publickey.txt';

		$payment = $GLOBALS['db']->getRow("select id,config from ".DB_PREFIX."payment where class_name='Allinpay'");  
    	$payment['config'] = unserialize($payment['config']);
		$key = trim($payment['config']['md5_key']);
	
		$merchantId=$request["merchantId"];
		$version=$request['version'];
		$language=$request['language'];
		$signType=$request['signType'];
		$payType=$request['payType'];
		$issuerId=$request['issuerId'];
		$paymentOrderId=$request['paymentOrderId'];
		$orderNo=$request['orderNo'];
		$orderDatetime=$request['orderDatetime'];
		$orderAmount=$request['orderAmount'];
		$payDatetime=$request['payDatetime'];
		$payAmount=$request['payAmount'];
		$ext1=$request['ext1'];
		$ext2=$request['ext2'];
		$payResult=$request['payResult'];
		$errorCode=$request['errorCode'];
		$returnDatetime=$request['returnDatetime'];
		$signMsg=$request["signMsg"];

		$bufSignSrc="";
		if($merchantId != "")
			$bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";
		if($version != "")
			$bufSignSrc=$bufSignSrc."version=".$version."&";
		if($language != "")
			$bufSignSrc=$bufSignSrc."language=".$language."&";
		if($signType != "")
			$bufSignSrc=$bufSignSrc."signType=".$signType."&";
		if($payType !== "")
			$bufSignSrc=$bufSignSrc."payType=".$payType."&";
		if($issuerId != "")
			$bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
		if($paymentOrderId != "")
			$bufSignSrc=$bufSignSrc."paymentOrderId=".$paymentOrderId."&";
		if($orderNo != "")
			$bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
		if($orderDatetime != "")
			$bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
		if($orderAmount != "")
			$bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
		if($payDatetime != "")
			$bufSignSrc=$bufSignSrc."payDatetime=".$payDatetime."&";
		if($payAmount != "")
			$bufSignSrc=$bufSignSrc."payAmount=".$payAmount."&";
		if($ext1 != "")
			$bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
		if($ext2 != "")
			$bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
		if($payResult != "")
			$bufSignSrc=$bufSignSrc."payResult=".$payResult."&";
		if($errorCode != "")
			$bufSignSrc=$bufSignSrc."errorCode=".$errorCode."&";
		if($returnDatetime != "")
			$bufSignSrc=$bufSignSrc."returnDatetime=".$returnDatetime;

		$publickeycontent = file_get_contents($publickeyfile);
		$publickeyarray = explode(PHP_EOL, $publickeycontent);
		$publickey_arr = explode('=',$publickeyarray[0]);
		$modulus_arr = explode('=',$publickeyarray[1]);
		$publickey = trim($publickey_arr[1]);
		$modulus = trim($modulus_arr[1]);			
		$keylength = 1024;

		$verifyResult = rsa_verify($bufSignSrc,$signMsg, $publickey, $modulus, $keylength,"sha1");

		if($verifyResult){
			$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where notice_sn = '".$orderNo."'");
				
			require_once APP_ROOT_PATH."system/libs/cart.php";
			
            if ($payment_notice['is_paid'] == 0) {
			    $rs = payment_paid($payment_notice['id'],$paymentOrderId);
            }
            	
			$is_paid = intval($GLOBALS['db']->getOne("select is_paid from ".DB_PREFIX."payment_notice where id = '".intval($payment_notice['id'])."'"));
			if ($is_paid == 1){
				app_redirect(url("index","payment#incharge_done",array("id"=>$payment_notice['id']))); //支付成功
			}else{
				app_redirect(url("index","payment#pay",array("id"=>$payment_notice['id'])));
			}
		}else{
			exit;
		}
	}
	
	public function notify($request)
	{
		$return_res = array(
			'info'=>'',
			'status'=>false,
		);

		require_once(APP_ROOT_PATH.'system/payment/Allinpay/php_rsa.php');
		$publickeyfile = APP_ROOT_PATH.'system/payment/Allinpay/publickey.txt';

		$payment = $GLOBALS['db']->getRow("select id,config from ".DB_PREFIX."payment where class_name='Allinpay'");  
    	$payment['config'] = unserialize($payment['config']);
		$key = trim($payment['config']['md5_key']);
	
		$merchantId=$request["merchantId"];
		$version=$request['version'];
		$language=$request['language'];
		$signType=$request['signType'];
		$payType=$request['payType'];
		$issuerId=$request['issuerId'];
		$paymentOrderId=$request['paymentOrderId'];
		$orderNo=$request['orderNo'];
		$orderDatetime=$request['orderDatetime'];
		$orderAmount=$request['orderAmount'];
		$payDatetime=$request['payDatetime'];
		$payAmount=$request['payAmount'];
		$ext1=$request['ext1'];
		$ext2=$request['ext2'];
		$payResult=$request['payResult'];
		$errorCode=$request['errorCode'];
		$returnDatetime=$request['returnDatetime'];
		$signMsg=$request["signMsg"];

		$bufSignSrc="";
		if($merchantId != "")
			$bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";
		if($version != "")
			$bufSignSrc=$bufSignSrc."version=".$version."&";
		if($language != "")
			$bufSignSrc=$bufSignSrc."language=".$language."&";
		if($signType != "")
			$bufSignSrc=$bufSignSrc."signType=".$signType."&";
		if($payType !== "")
			$bufSignSrc=$bufSignSrc."payType=".$payType."&";
		if($issuerId != "")
			$bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
		if($paymentOrderId != "")
			$bufSignSrc=$bufSignSrc."paymentOrderId=".$paymentOrderId."&";
		if($orderNo != "")
			$bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
		if($orderDatetime != "")
			$bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
		if($orderAmount != "")
			$bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
		if($payDatetime != "")
			$bufSignSrc=$bufSignSrc."payDatetime=".$payDatetime."&";
		if($payAmount != "")
			$bufSignSrc=$bufSignSrc."payAmount=".$payAmount."&";
		if($ext1 != "")
			$bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
		if($ext2 != "")
			$bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
		if($payResult != "")
			$bufSignSrc=$bufSignSrc."payResult=".$payResult."&";
		if($errorCode != "")
			$bufSignSrc=$bufSignSrc."errorCode=".$errorCode."&";
		if($returnDatetime != "")
			$bufSignSrc=$bufSignSrc."returnDatetime=".$returnDatetime;

		$publickeycontent = file_get_contents($publickeyfile);
		$publickeyarray = explode(PHP_EOL, $publickeycontent);
		$publickey_arr = explode('=',$publickeyarray[0]);
		$modulus_arr = explode('=',$publickeyarray[1]);
		$publickey = trim($publickey_arr[1]);
		$modulus = trim($modulus_arr[1]);			
		$keylength = 1024;

		$verifyResult = rsa_verify($bufSignSrc,$signMsg, $publickey, $modulus, $keylength,"sha1");

		if($verifyResult){
			$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where notice_sn = '".$orderNo."'");
				
			require_once APP_ROOT_PATH."system/libs/cart.php";
			
            if ($payment_notice['is_paid'] == 0) {
			    $rs = payment_paid($payment_notice['id'],$paymentOrderId);
            }
            	
			$is_paid = intval($GLOBALS['db']->getOne("select is_paid from ".DB_PREFIX."payment_notice where id = '".intval($payment_notice['id'])."'"));
			if ($is_paid == 1){
				app_redirect(url("index","payment#incharge_done",array("id"=>$payment_notice['id']))); //支付成功
			}else{
				app_redirect(url("index","payment#pay",array("id"=>$payment_notice['id'])));
			}
		}else{
			exit;
		}
	}

	//订单查询接口
	public function order_query($payment_notice_id)
	{
		$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where id = ".$payment_notice_id);
		$notice_sn = $payment_notice['notice_sn'];
		$create_time = $payment_notice['create_time'];
		$payment_info = $GLOBALS['db']->getRow("select id,config,logo from ".DB_PREFIX."payment where id=".intval($payment_notice['payment_id']));
		$payment_info['config'] = unserialize($payment_info['config']);

		$merchantId = trim($payment_info['config']['merchant_id']);  //人民币账号 不可空
		$key        = trim($payment_info['config']['md5_key']);
		
		$serverUrl = 'https://service.allinpay.com/gateway/index.do';
		$serverIP = 'service.allinpay.com';

		$version = 'v1.5';
		$signType = 0;
		$orderNo = $notice_sn;
		$orderDatetime = date('YmdHis', $create_time);
		$queryDatetime = date('YmdHis', time());

		//组签名原串
		$bufSignSrc = "";
		if($merchantId != "")
		$bufSignSrc = $bufSignSrc."merchantId=".$merchantId."&";
		if($version != "")
		$bufSignSrc = $bufSignSrc."version=".$version."&";
		if($signType !== "")
		$bufSignSrc = $bufSignSrc."signType=".$signType."&";
		if($orderNo != "")
		$bufSignSrc = $bufSignSrc."orderNo=".$orderNo."&";
		if($orderDatetime != "")
		$bufSignSrc = $bufSignSrc."orderDatetime=".$orderDatetime."&";
		if($queryDatetime != "")
		$bufSignSrc = $bufSignSrc."queryDatetime=".$queryDatetime."&";
		if($key != "")
		$bufSignSrc = $bufSignSrc."key=".$key;

		//生成签名串
		$signMsg = strtoupper(md5($bufSignSrc));

		require_once APP_ROOT_PATH."system/payment/Allinpay/php_rsa.php";
		require_once APP_ROOT_PATH."system/payment/Allinpay/HashMap.class.php";
		
		//Put all the arguments in a hash
		$argv = array(
			'merchantId' => $merchantId,
			'version' => $version,
			'signType' => $signType,
			'orderNo' => $orderNo,
			'orderDatetime' => $orderDatetime,
			'queryDatetime' => $queryDatetime,
			'signMsg' => $signMsg
		);

        $index = 0;
        $params = "";
        foreach ($argv as $key=>$value) {
            if ($index != 0) {
                $params .= '&';
            }
            $params .= $key.'=';
            $params .= urlencode($value);
            $index += 1;
        }
        $length = strlen($params);

        $urlhost = $serverIP;
        $urlpath = '/gateway/index.do';

		$header = array();
		$header[] = 'POST '.$urlpath.' HTTP/1.0';
        $header[] = 'Host: '.$urlhost;
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';
		$header[] = 'Accept-encoding: gzip';
		$header[] = 'Accept-language: en-us';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Content-Length: '.$length;
    
        $request = implode("\r\n", $header)."\r\n\r\n".$params;

		if(!$fp= pfsockopen('ssl://'.$urlhost, 443, $errno, $errstr, 10)){
            return "服务器连接错误";
		}else{
			fwrite($fp, $request); 
			$inHeaders = true;//是否在返回头
			$atStart = true;//是否返回头第一行
			$ERROR = false;
			$responseStatus;//返回头状态 
		    while(!feof($fp)){ 
                $line = fgets($fp, 2048); 
                
                if($atStart){
                    $atStart = false;
                    preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m); 
                    $responseStatus = $m[2];
                    continue;
                }
                
                if($inHeaders ){
                    if(strLen(trim($line)) == 0 ){
                        $inHeaders = false;		
                    }
                    continue;
                }
                
                if(!$inHeaders and $responseStatus == 200){
                    //获得参数串
                    $pageContents = $line;  	
                }
		    } 
		    fclose($fp);
		}

		$map = new HashMap();
		$result = explode('&',$pageContents);
		if (is_array($result)) {
            foreach ($result as $element) {
                $temp = explode('=',$element);
                if(count($temp)==2){
                    $map->put($temp[0], $temp[1]);
                }					
		  	}
		}

		//开始组验签源串
		$bufVerifySrc = "";
		if($map->get("merchantId") != "")
		$bufVerifySrc = $bufVerifySrc."merchantId=".($map->get("merchantId"))."&"; 		//merchantId
		
		if($map->get("version") != "")
		$bufVerifySrc = $bufVerifySrc."version=".($map->get("version"))."&";		//version
		
		if($map->get("language") != "")
		$bufVerifySrc = $bufVerifySrc."language=".($map->get("language"))."&";		//language

		if($map->get("signType") != "")
		$bufVerifySrc = $bufVerifySrc."signType=".($map->get("signType"))."&";		//signType

		if($map->get("payType") != "")
		$bufVerifySrc = $bufVerifySrc."payType=".($map->get("payType"))."&";		//payType
		
		if($map->get("paymentOrderId") != "")
		$bufVerifySrc = $bufVerifySrc."paymentOrderId=".($map->get("paymentOrderId"))."&";		//paymenrOrderId

		if($map->get("orderNo") != "")
		$bufVerifySrc = $bufVerifySrc."orderNo=".($map->get("orderNo"))."&";		///orderNo

		if($map->get("orderDatetime") != "")
		$bufVerifySrc = $bufVerifySrc."orderDatetime=".($map->get("orderDatetime"))."&";		//orderDatetime

		if($map->get("orderAmount") != "")
		$bufVerifySrc = $bufVerifySrc."orderAmount=".($map->get("orderAmount"))."&";		//orderAmount

		if($map->get("payDatetime") != "")
		$bufVerifySrc = $bufVerifySrc."payDatetime=".($map->get("payDatetime"))."&";		//payDatetime
		
		if($map->get("payAmount") != "")
		$bufVerifySrc = $bufVerifySrc."payAmount=".($map->get("payAmount"))."&";		//payAmount
		
		if($map->get("ext1") != "")
		$bufVerifySrc = $bufVerifySrc.urldecode("ext1=".($map->get("ext1")))."&";		//ext1
		
		if($map->get("ext2") != "")
		$bufVerifySrc = $bufVerifySrc.urldecode("ext2=".($map->get("ext2")))."&";		//ext2				
		
		if($map->get("payResult") != "")
		$bufVerifySrc = $bufVerifySrc."payResult=".($map->get("payResult"))."&";		//payResult
		
		if($map->get("errorCode") != "")
		$bufVerifySrc = $bufVerifySrc."errorCode=".($map->get("errorCode"))."&";		//errorCode
		
		if($map->get("returnDatetime") != "")
		$bufVerifySrc = $bufVerifySrc."returnDatetime=".($map->get("returnDatetime"));		//returnDatetime
		//验签源串组装完成

        //交易结果处理
        $expResult = array();
        foreach ($result as $v) {
            $v = explode('=',$v);
            $k = $v[0];
            if ($k == 'payDatetime' || $k == 'payAmount' || $k == 'returnDatetime' || $k == 'orderDatetime' || $k == 'orderNo' || $k == 'orderAmount' || $k == 'paymentOrderId' || $k == 'payResult' || $k == 'ERRORCODE' || $k == 'ERRORMSG') {
                $expResult[$k] = $v[1];
            }
        }

        return $expResult;
	}

    //自动订单查询完成支付状态确认
    function auto_order_query() {
        //未完成支付的订单
		$payment_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."payment where class_name='Allinpay'");
        $payment_notice_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."payment_notice where is_paid=0 and payment_id=".$payment_id." and create_time>".(time()-5*60));
        if (!$payment_notice_list) { return; }

        foreach ($payment_notice_list as $payment) {
            $result = $this->order_query($payment['id']);
            if (!isset($result['payResult']) || $result['payResult'] != 1) { continue; }
            require_once APP_ROOT_PATH."system/libs/cart.php";
            $rs = payment_paid($payment['id']);
        }

        return;
    }
}
?>