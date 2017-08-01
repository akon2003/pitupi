<?php

function demo_payment_code(&$serverUrl, &$merchantId, &$key) {
	// 重新设置测试参数
	$serverUrl= 'http://ceshi.allinpay.com/gateway/index.do';
	$merchantId = '100020091218001';
	$key = '1234567890';
}

function demo_response_code(&$merchantId, &$key, &$publickeyfile) {
	//header("Content-type: text/html; charset=utf-8");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	// 重新设置测试参数
	$merchantId = '100020091218001';
	$key = '1234567890';
}

?>