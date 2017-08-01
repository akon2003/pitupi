<?php

defined('APP_ROOT_PATH')|define('APP_ROOT_PATH', dirname(dirname(dirname(__FILE__))).'/');
require_once(APP_ROOT_PATH.'system/common.php');
require_once(APP_ROOT_PATH.'system/libs/idcard.php');
require_once(APP_ROOT_PATH.'system/idcard/Allinpay/libs/ArrayXml.class.php');
require_once(APP_ROOT_PATH.'system/idcard/Allinpay/libs/cURL.class.php');
require_once(APP_ROOT_PATH.'system/idcard/Allinpay/libs/PhpTools.class.php');

class Allinpay_idcard implements idcard {
	
	public function getinfo($info)
	{
		$sql = "select id,config,logo,AES_DECRYPT(ext1,'".AES_DECRYPT_KEY."') as ext1,AES_DECRYPT(ext2,'".AES_DECRYPT_KEY."') as ext2,AES_DECRYPT(ext3,'".AES_DECRYPT_KEY."') as ext3 from ".DB_PREFIX."idcard where class_name='Allinpay'";
		$idcard_info = $GLOBALS['db']->getRow($sql);
		$config = unserialize($idcard_info['config']);

		if ($idcard_info['ext3'] != $info['ext']) {
			return array('status'=>0, 'isok'=>false, 'info'=>'请求失败');
		}

		$params = array(
			'INFO'=>array(
				'TRX_CODE'		=> '220001', //1. 字符集:
				'VERSION'		=> '03', //2. 版本号:
				'DATA_TYPE'		=> '2', //3. 数据格式: 2|xml
				'LEVEL'			=> '5', //4. 处理级别: 0-9 0优先级最低，默认为5
				'MERCHANT_ID'	=> $config['merchant_id'],//5. 商户号:
				'USER_NAME'		=> $config['user_name'],//6. 用户名:
				'USER_PASS'		=> $config['user_pass'],//7. 用户密码:
				'REQ_SN'		=> $config['merchant_id'].date('ymdhis',time()),//8. 交易批次号: 商户号+时间+自定义流水|不重复流水
			),
			'IDVER' => array(
				'NAME'			=> $info['realname'],//10. 姓名:
				'IDNO'			=> strval($info['card']),//11. 身份证号:
				'VALIDATE'		=> '', //12. 有效期: YYYYMMDD|可空
				'REMARK'		=> '' //13. 备注: 预留|可空	
			)
		);

		//发起请求
		$tools=new PhpTools();
		$tools->certFile = $idcard_info['ext1'];
		$tools->privateKeyFile = $idcard_info['ext2'];
		$result = $tools->send($params);

		$data = array('status'=>0, 'isok'=>false, 'info'=>'请求失败');
		if (!$result) {
			return $data;
		}

		preg_match_all("/\<RET_CODE\>(\d+)\<\/RET_CODE\>/i", $result, $arrcode);
		preg_match_all("/\<ERR_MSG\>(.*)\<\/ERR_MSG\>/i", $result, $arrmsg);

		if (isset($arrcode) && isset($arrcode[1]) && isset($arrcode[1][0])) {
			$data['response']['code'] = $arrcode[1][0];
		}
		if (isset($arrcode) && isset($arrcode[1]) && isset($arrcode[1][1])) {
			$data['result']['code'] = $arrcode[1][1];
		}
		if (isset($arrmsg) && isset($arrmsg[1]) && isset($arrmsg[1][0])) {
			$data['response']['msg'] = $arrmsg[1][0];
		}
		if (isset($arrmsg) && isset($arrmsg[1]) && isset($arrmsg[1][1])) {
			$data['result']['msg'] = $arrmsg[1][1];
		}

		$data['info'] = $data['response']['msg'];

		if ($data['response']['code'] == 0)		{ $data['status'] = 1; }
		if ($data['result']['code'] == 0)		{ $data['isok'] = true; }
		if ($data['result']['msg'])				{ $data['info'] .= $data['result']['msg']; }

		return $data;
	}
}
?>