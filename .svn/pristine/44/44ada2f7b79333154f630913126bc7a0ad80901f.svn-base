<?php

/**
 * Admin 2016-08-06
 * 添加接口适用于按模板发送信息
 * sendTemplateSMS 发送模板短信
 * queryAccountInfo() 查询账户信息
 */
interface sms{
	
	/**
	 * 发送短信
	 * @param array $mobile_number	手机号
	 * @param string $content		短信内容
	 * return array(status='',msg='')
	 */
	function sendSMS($mobile_number,$content,$is_adv);
	
	/*获取该短信接口的相关数据*/
	function getSmsInfo();
	
	/*查询余额*/
	function check_fee();

	/**
	 * 发送模板短信
	 * @param array $mobile		手机号
	 * @param string $args		短信参数
	 * @param string $template_id		模板ID
	 * @param string $content	兼容直接发送内容
	 * return array(status='',msg='')
	 */
	function sendTemplateSMS($mobile,$args,$template_id,$content);	

	/**
	 * 查询账户信息
	 * @return string 账户信息说明
	 */
	function queryAccountInfo();
}
?>