<?php

/**
 * 实名认证接口
 * @param string real_name 姓名
 * @param string card 身份证
 * @param string ext 接口调用方识别,避免无法识别的调用
 */
 
require_once('Allinpay_idcard.php');

$data = array('status'=>0, 'isok'=>false, 'info'=>'请求失败');

$realname = trim($_REQUEST['realname']);
$card = trim($_REQUEST['card']);
$ext = trim($_REQUEST['ext']);

if ($realname == "" || $card == "" || $ext == "") {
	echo json_encode($data); exit;
}

$info = array(
	'realname'=>$realname,
	'card'=>$card,
	'ext'=>$ext
);
$idcard = new Allinpay_idcard();
$data = $idcard->getinfo($info);
echo json_encode($data);

?>