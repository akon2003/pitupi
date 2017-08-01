<?php

define('APP_ROOT_PATH', dirname(dirname(dirname(__FILE__))).'/');
require_once (APP_ROOT_PATH.'system/common.php');
require_once (APP_ROOT_PATH.'system/libs/user.php');
require_once (APP_ROOT_PATH.'app/Lib/app_init.php');
require_once (APP_ROOT_PATH.'app/Lib/deal.php');
require_once (APP_ROOT_PATH.'app/Lib/deal_func_ext.php');
require_once (APP_ROOT_PATH.'app/Lib/common.php');

$str = date('Y-m-d H:i:s',time()).'\r\n';
$str .= "运行自动批量还款\r\n";

$str .= "正常标的自动还款\r\n";
$result = autoRepayBorrowMoney();
$str .= $result['info']."\r\n";

$str .= "新手标自动还款\r\n";
$result = autoRepayBorrowMoneyExt();
$str .= $result['info']."\r\n";

save_deal_log($str);

function save_deal_log($log) {
    $log_file = dirname(__FILE__).'/'.date('Ymd',time()).'-log.txt';
    if (file_exists($log_file)) {
        $log = file_get_contents($log_file).$log;
    }
    file_put_contents($log_file, $log);
}

?>