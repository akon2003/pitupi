<?php

$payment_lang = array(
	'name'	=>	'通联支付',
	'merchant_id'	=>	'商户号',
	'user_name'	=>	'用户名',
	'user_pass'	=>	'用户密码',
);

$config = array( 
	'merchant_id'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //商户号
	'user_name'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //用户名
	'user_pass'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //用户密码
);

/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == TRUE)
{
    $module['class_name']    = 'Allinpay';

    /* 名称 */
    $module['name']    = $payment_lang['name'];

    /* 配送 */
    $module['config'] = $config;
    
    $module['lang'] = $payment_lang;
       
    return $module;
}

// 通联验证模型

require_once(APP_ROOT_PATH.'system/libs/idcard.php');
class Allinpay_idcard implements idcard {
	
	public function getinfo($info)
	{
		$sql = "select id,config,logo,AES_DECRYPT(ext3,'".AES_DECRYPT_KEY."') as ext3 from ".DB_PREFIX."idcard where class_name='Allinpay'";
		$idcard_info = $GLOBALS['db']->getRow($sql);
		$ext3 = $idcard_info['ext3'];

		$params = "realname=".$info['realname']."&card=".$info['card']."&ext=".$ext3;
		$server = "http://localhost/services/idcard/index.php?";
		$response = file_get_contents($server.$params);
		$data = json_decode($response, true);
		return $data;
	}
}
?>