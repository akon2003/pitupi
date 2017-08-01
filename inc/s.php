<?php
/**
 +------------------------------------------------------------------------------
 * wsdl服务端  
 +------------------------------------------------------------------------------
 * @wsdl服务端接收
 * @Author 犇<admin@huqiao.net>
 * @Copyright (c) www.huqiao.net
 +------------------------------------------------------------------------------
 */

defined('ROOT_PATH')|define('ROOT_PATH', dirname(dirname(__FILE__)).'/');
require_once(ROOT_PATH.'system/payment/AllinpayPos/order.class.php');
define('WSDL_URL',ROOT_PATH.'system/payment/AllinpayPos/order.wsdl');	//定义WSDL文件路径
ini_set('soap.wsdl_cache_enabled','0');			//关闭WSDL缓存
 
 //WSDL文件不存在时自动创建
if(!file_exists(WSDL_URL))
{
    require_once ROOT_PATH.'system/payment/AllinpayPos/SoapDiscovery.class.php';
    $disco = new SoapDiscovery('Order','AllinpayControllerwsdl');
    $str = $disco->getWSDL();
    file_put_contents(WSDL_URL,$str);
}
 
//SOAP开启并接收Client传入的参数响应 
$server = new SoapServer(WSDL_URL);
$server->setClass('Order');
$server->handle();

?>