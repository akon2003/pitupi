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

require_once(APP_ROOT_PATH.'system/libs/carry.php');
require_once(APP_ROOT_PATH.'system/carry/Allinpay/libs/ArrayXml.class.php');
require_once(APP_ROOT_PATH.'system/carry/Allinpay/libs/cURL.class.php');
require_once(APP_ROOT_PATH.'system/carry/Allinpay/libs/PhpTools.class.php');
class Allinpay_carry implements carry {
	
    /**
     * 
     * 单笔实时接口
     * TRX_CODE:100014--单笔实时代付
     * TRX_CODE:100011--单笔实时代收
     * @var unknown_type
     */
	public function single_cash($params)
	{
		$user_carry = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_carry where id = ".$params);

        $account_user_real_name = $user_carry['real_name'];
		$bankcard = preg_replace('/\s+/','',$user_carry['bankcard']);
		$amount = round($user_carry['money'],2) * 100;

        $account_user_info = $GLOBALS['db']->getRow("select id,user_name,user_type,phone,AES_DECRYPT(real_name_encrypt, '".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile from ".DB_PREFIX."user where id = ".$user_carry['user_id']);
        $account_user_name = $account_user_info['user_name'];
        $account_user_mobile = $account_user_info['mobile'];
        $account_prop = $account_user_info['user_type']==0? 0 : 1;

        $bank_info = $GLOBALS['db']->getRow("select id,name,allinpay_code from ".DB_PREFIX."bank where id = ".$user_carry['bank_id']);
		$bank_code = $bank_info['allinpay_code'];

        $carry_info = $GLOBALS['db']->getRow("select id,config,logo,AES_DECRYPT(ext1,'".AES_DECRYPT_KEY."') as ext1,AES_DECRYPT(ext2,'".AES_DECRYPT_KEY."') as ext2 from ".DB_PREFIX."carry where class_name = 'Allinpay' and is_effect=1");

		$carry_info['config'] = unserialize($carry_info['config']);
		$merchant_id = trim($carry_info['config']['merchant_id']);  //人民币账号 不可空
		$user_name = trim($carry_info['config']['user_name']);  //人民币账号 不可空
		$key = trim($carry_info['config']['user_pass']);

        $submit_time = date('YmdHis', time());
		$req_sn = $submit_time.rand('100','999');

		$GLOBALS['db']->query("update ".DB_PREFIX."user_carry set req_sn='".$req_sn."',update_time=".time()." where id = ".$params);

        // 源数组
        $params = array(
            'INFO' => array(
                'TRX_CODE' => '100014',
                'VERSION' => '03',
                'DATA_TYPE' => '2',
                'LEVEL' => '6',
                'USER_NAME' => $user_name,
                'USER_PASS' => $key,
                'USER_PASS' => $key,
                'REQ_SN' => $req_sn,
            ),
            'TRANS' => array(
                'BUSINESS_CODE' => '09900',//业务代码,对接前提供09400
                'MERCHANT_ID' => $merchant_id,
                'SUBMIT_TIME' => $submit_time,
                'E_USER_CODE' => $account_user_mobile,//用户代码,可作备注
                'BANK_CODE' => $bank_code,//建议填写,银行代码
                'ACCOUNT_TYPE' => '00',//00储蓄卡
                'ACCOUNT_NO' => $bankcard,
                'ACCOUNT_NAME' => $account_user_real_name,
                'ACCOUNT_PROP' => $account_prop,//账号属性 0个人1公司
                'AMOUNT' => $amount,
                'CURRENCY' => 'CNY',
                'ID_TYPE' => '0',
                'CUST_USERID' => '',
                'SUMMARY' => '',
                'REMARK' => '',
            ),
        );
		
        //发起请求
        $tools=new PhpTools();
		$tools->certFile = $carry_info['ext1'];
		$tools->privateKeyFile = $carry_info['ext2'];
        $result = $tools->send($params);
		$return = array('status'=>0, 'isok'=>0, 'msg'=>'', 'info'=>$req_sn);

		if($result!=FALSE) {
			$return['status'] = 1;
			//交易结果以此为准
			if (isset($result['AIPG']['TRANSRET'])) {
				$ret_code = $result['AIPG']['TRANSRET']['RET_CODE'];
				$err_msg = $result['AIPG']['TRANSRET']['ERR_MSG'];
				//处理成功
				if ($ret_code == '0000' or $ret_code == '4000') {
					$return['isok'] = 1;
					//更新用户提现记录表
				}
				//交易中间状态,需继续做交易结果查询来确认交易的最终状态
				else if ($ret_code == '2000' || $ret_code == '2001' || $ret_code == '2003' || $ret_code == '2005' || $ret_code == '2007' || $ret_code == '2008' || $ret_code == '0003' || $ret_code == '0014') {
					$return['isok'] = 2;
					$return['msg'] = $err_msg.' 请查询交易详情';
				}
				//交易失败
				else {
					$return['isok'] = 3;
					$return['msg'] = $ret_code.' '.$err_msg;
				}
			} else {
				$return['msg'] = $result['AIPG']['INFO']['ERR_MSG'];
			}
		} else {
			$return['msg'] = '验签失败，请检查通联公钥证书是否正确';
		}

		return $return;
	}

    /**
     * 批量代收付接口
     * TRX_CODE:100002--批量代付
     * TRX_CODE:100001--批量代收
     * @var unknown_type
     */
	public function batch_tranx($params)
	{
		$user_carry = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_carry where id = ".$params);

        $account_user_real_name = $user_carry['real_name'];
		$bankcard = preg_replace('/\s+/','',$user_carry['bankcard']);
		$amount = round($user_carry['money'],2) * 100;

        $account_user_info = $GLOBALS['db']->getRow("select id,user_name,user_type,phone,AES_DECRYPT(real_name_encrypt, '".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile from ".DB_PREFIX."user where id = ".$user_carry['user_id']);
        $account_user_name = $account_user_info['user_name'];
        $account_user_mobile = $account_user_info['mobile'];
        $account_prop = $account_user_info['user_type']==0? 0 : 1;

        $bank_info = $GLOBALS['db']->getRow("select id,name,allinpay_code from ".DB_PREFIX."bank where id = ".$user_carry['bank_id']);
		$bank_code = $bank_info['allinpay_code'];

        $carry_info = $GLOBALS['db']->getRow("select id,config,logo,AES_DECRYPT(ext1,'".AES_DECRYPT_KEY."') as ext1,AES_DECRYPT(ext2,'".AES_DECRYPT_KEY."') as ext2 from ".DB_PREFIX."carry where class_name = 'Allinpay' and is_effect=1");

		$carry_info['config'] = unserialize($carry_info['config']);
		$merchant_id = trim($carry_info['config']['merchant_id']);  //人民币账号 不可空
		$user_name = trim($carry_info['config']['user_name']);  //人民币账号 不可空
		$key = trim($carry_info['config']['user_pass']);

        $submit_time = date('YmdHis', time());
		$req_sn = $submit_time.rand('100','999');

		$GLOBALS['db']->query("update ".DB_PREFIX."user_carry set req_sn='".$req_sn."',update_time=".time()." where id = ".$params);

        // 源数组
        $params = array(
            'INFO' => array(
                'TRX_CODE' => '100001',
                'VERSION' => '03',
                'DATA_TYPE' => '2',
                'LEVEL' => '6',
                'USER_NAME' => $user_name,
                'USER_PASS' => $key,
                'REQ_SN' => $req_sn,
            ),
			'BODY' => array(
				'TRANS_SUM' => array(
					'BUSINESS_CODE' => '09900',//业务代码,对接前提供10600
					'MERCHANT_ID' => $merchant_id,
					'SUBMIT_TIME' => $submit_time,
					'TOTAL_ITEM' => '1',
					'TOTAL_SUM' => $amount,
					'SETTDAY' => '',
				 ),
				'TRANS_DETAILS'=> array(
					  'TRANS_DETAIL'=> array(
							'SN' => '00001',
							'E_USER_CODE'=> '00001',
							'BANK_CODE'=> $bank_code,//建议填写,银行代码
							'ACCOUNT_TYPE'=> '00',//00储蓄卡
							'ACCOUNT_NO'=> $bankcard,
							'ACCOUNT_NAME'=> $account_user_real_name,
							'PROVINCE'=> '',
							'CITY'=> '',
							'BANK_NAME'=> '',
							'ACCOUNT_PROP'=> $account_prop,//账号属性 0个人1公司
							'AMOUNT'=> $amount,
							'CURRENCY'=> 'CNY',
							'PROTOCOL'=> '',
							'PROTOCOL_USERID'=> '',
							'ID_TYPE'=> '',
							'ID'=> '',
							'TEL'=> '',
							'CUST_USERID'=> '',
							'REMARK'=> '',
							'SETTACCT'=> '',
							'SETTGROUPFLAG'=> '',
							'SUMMARY'=> '',
							'UNION_BANK'=> '010538987654',
						 )
				 )
			),
        );
		
        //发起请求
        $tools=new PhpTools();
		$tools->certFile = $carry_info['ext1'];
		$tools->privateKeyFile = $carry_info['ext2'];
        $result = $tools->send($params);
		$return = array('status'=>0, 'isok'=>0, 'msg'=>'', 'info'=>$req_sn);

		if($result!=FALSE) {
			$return['status'] = 1;
			//交易结果以此为准
			if (isset($result['AIPG']) && isset($result['AIPG']['BODY']) && isset($result['AIPG']['BODY']['RET_DETAILS']) && isset($result['AIPG']['BODY']['RET_DETAILS'])) {
				$ret_detail = $result['AIPG']['BODY']['RET_DETAILS'][0];
				$ret_code = $ret_detail['RET_CODE'];
				$err_msg = $ret_detail['ERR_MSG'];
				//处理成功
				if ($ret_code == '0000' or $ret_code == '4000') {
					$return['isok'] = 1;
					//更新用户提现记录表
				}
				//交易中间状态,需继续做交易结果查询来确认交易的最终状态
				else if ($ret_code == '2000' || $ret_code == '2001' || $ret_code == '2003' || $ret_code == '2005' || $ret_code == '2007' || $ret_code == '2008' || $ret_code == '0003' || $ret_code == '0014') {
					$return['isok'] = 2;
					$return['msg'] = $err_msg.' 请查询交易详情';
				}
				//交易失败
				else {
					$return['isok'] = 3;
					$return['msg'] = $ret_code.' '.$err_msg;
				}
			} else {
				$return['msg'] = $result['AIPG']['INFO']['ERR_MSG'];
			}
		} else {
			$return['msg'] = '验签失败，请检查通联公钥证书是否正确';
		}

		return $return;
	}

    /**
     * 交易结果查询 200004
     */
	public function query_ret($params)
	{
		$user_carry = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_carry where id = ".$params);
		$query_sn = $user_carry['req_sn'];

        $carry_info = $GLOBALS['db']->getRow("select id,config,logo,AES_DECRYPT(ext1,'".AES_DECRYPT_KEY."') as ext1,AES_DECRYPT(ext2,'".AES_DECRYPT_KEY."') as ext2 from ".DB_PREFIX."carry where class_name = 'Allinpay' and is_effect=1");
		$carry_info['config'] = unserialize($carry_info['config']);
		$merchant_id = trim($carry_info['config']['merchant_id']);  //人民币账号 不可空
		$user_name = trim($carry_info['config']['user_name']);  //人民币账号 不可空
		$key = trim($carry_info['config']['user_pass']);

        $submit_time = date('YmdHis', time());
		$req_sn = $submit_time.rand('100','999');
		
        // 源数组
        $params = array(
            'INFO' => array(
                'TRX_CODE' => '200004',
                'VERSION' => '03',
                'DATA_TYPE' => '2',
                'LEVEL' => '6',
                'USER_NAME' => $user_name,
                'USER_PASS' => $key,
                'REQ_SN' => $req_sn,
            ),
            'QTRANSREQ' => array(
                'QUERY_SN' => $query_sn,
                'MERCHANT_ID' => $merchant_id,
                'STATUS' => '2',
                'TYPE' => '1',
                'START_DAY' => '',
                'END_DAY' => ''
            ),
        );
        
        //发起请求
        $tools=new PhpTools();
		$tools->certFile = $carry_info['ext1'];
		$tools->privateKeyFile = $carry_info['ext2'];
        $result = $tools->send($params);

		$return = array('status'=>0, 'isok'=>0, 'msg'=>'', 'info'=>'');

		if($result!=FALSE) {
			$return['status'] = 1;
            $return['info'] = $result;
		} else {
			$return['msg'] = '验签失败，请检查通联公钥证书是否正确';
		}
		
		return $return;
    }

    /**
     * 交易结果查询 200004
     */
	public function succ_notify_server($params)
	{
		return array('status'=>0, 'isok'=>0, 'msg'=>'', 'info'=>'');
    }
}
?>