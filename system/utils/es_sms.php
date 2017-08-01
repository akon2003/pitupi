<?php

class sms_sender
{
	var $sms;
	
	public function __construct()
    { 	
		$sms_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."sms where is_effect = 1");
		if($sms_info)
		{
			$sms_info['config'] = unserialize($sms_info['config']);
			
			require_once APP_ROOT_PATH."system/sms/".$sms_info['class_name']."_sms.php";
			
			$sms_class = $sms_info['class_name']."_sms";
			$this->sms = new $sms_class($sms_info);
		}
    }    
	
	public function sendSms($mobiles,$content,$is_adv=0)
	{
		if(!is_array($mobiles))
			$mobiles = preg_split("/[ ,]/i",$mobiles);
		
		if(count($mobiles) > 0 )
		{
			if(!$this->sms)
			{
				$result['status'] = 0;
			}
			else
			{
				$result = $this->sms->sendSms($mobiles,$content,$is_adv);
			}
		}
		else
		{
			$result['status'] = 0;
			$result['msg'] = "没有发送的手机号";
		}
		
		return $result;
	}

	/**
	 * 发送模板短信
	 * @param $mobiles 手机号码,支持单个字符串类型,多个为数组类型
	 * @param $args 模板参数 YTX模板参数必须保证顺序与模板中的顺序一致,数组类型,可以为null
	 * @param $template_id 模板ID
	 * @param $content 兼容直接发送内容
	 * @return 数组格式 status:状态 msg:错误信息
	 */ 
	public function sendTemplateSMS($mobiles,$args,$template_id,$content="")
	{
		if(!is_array($mobiles)) 
		{
			$mobiles = preg_split("/[ ,]/i",$mobiles);
		}
		
		if(count($mobiles) > 0 )
		{
			if(!$this->sms)
			{
				$result['status'] = 0;
			}
			else
			{
				$result = $this->sms->sendTemplateSMS($mobiles,$args,$template_id,$content);
			}
		}
		else
		{
			$result['status'] = 0;
			$result['msg'] = "没有发送的手机号";
		}
		
		return $result;
	}
}
?>