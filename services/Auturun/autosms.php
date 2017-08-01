<?php

/**
 * 自动发送短信提醒
 * Admin 2016-7-25
 */

define('APP_ROOT_PATH', dirname(dirname(dirname(__FILE__))).'/');
require_once (APP_ROOT_PATH.'system/common.php');
require_once (APP_ROOT_PATH.'system/libs/user.php');
require_once (APP_ROOT_PATH.'app/Lib/app_init.php');
require_once (APP_ROOT_PATH.'app/Lib/deal.php');
require_once (APP_ROOT_PATH.'app/Lib/deal_func_ext.php');
require_once (APP_ROOT_PATH.'app/Lib/common.php');

$str = date('Y-m-d H:i:s',time()).'\r\n';
$str .= "运行自动短信提醒\r\n";

$result = autoRepaySms();
$str .= $result['info']."\r\n";

$file_name = dirname(__FILE__).'/'.date('Ymd',time()).'-sms.txt';
save_log_ext($file_name, $str);

?>