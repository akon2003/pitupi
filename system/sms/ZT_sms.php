<?php

/* 模块的基本信息 */
$sms_lang = array(
	'name'		=>	'上海助通信息',
	'username'	=>	'用户名',
	'password'	=>	'密码',
	'productid'	=>	'产品ID',
	'limit'		=>	'最大支持'
);

$config = array( 
	'productid'	=>	array('INPUT_TYPE'	=>	'0'), //产品ID:
	'limit'		=>	array('INPUT_TYPE'	=>	'0'), //最多支持号码数:
);


/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == TRUE)
{
    $module['server_url']	= 'http://www.ztsms.cn/';
	$module['class_name']   = 'ZT';
    $module['name']   		= $sms_lang['name']; /* 名称 */
    $module['config'] 		= $config; /* 配置 */
    $module['lang'] 		= $sms_lang;
       
    return $module;
}

require_once(APP_ROOT_PATH.'system/libs/sms.php');
class ZT_sms implements sms
{
	public $class_name		= 'ZT';
	public $sms;
	
    public function __construct($smsInfo = '')
    { 	    	
		if(!empty($smsInfo))
		{			
			$this->sms = $smsInfo;
		}
    }

	public function sendSMS($mobile_number,$content,$is_adv)
	{
		$loop = 0; $message = ""; $result = array('status'=>0, 'msg'=>'');
		$limit = intval($this->sms['config']['limit']);
		$url = 'http://www.ztsms.cn:8800/sendSms.do'; //短信接口的URL
		$loop = ceil(count($mobile_number)/$limit);

		$params['username'] = $this->sms['user_name'];
		$params['password'] = md5($this->sms['password']);
		$params['mobile'] = $mobile_number;
		$params['productid'] = $this->sms['config']['productid'];
		$params['xh'] = '';
		if (is_array($content)) {
			if (isset($content['content'])) {
				$params['content'] = urlencode($this->get_signature().$content['content']);
			}
			if (isset($content['xh'])) {
				$params['xh'] = $content['xh'];
			}
		} else {
			$params['content'] = urlencode($this->get_signature().$content);
		}	
		
		if ($loop > 1) {
			for ($i=0; $i<$loop; $i++) {
				$mobile = array_slice($mobile_number,$i*$limit,$limit);
				$params['mobile'] = implode(",",$mobile);
				$return = $this->request($url, $params);
				if (!preg_match("/^(1,).*/i", $return)) { 
					$message = '从第['.($i+1).']个号码'.$mobile_number[$i*$limit]."开始发送失败"; break; 
				}
			}
		} else if ($loop == 1) {
			$params['mobile'] = implode(",",$mobile_number);
			$return = $this->request($url, $params);
		}

		if ($return == -1) {
			$result['msg'] = '用户名或密码不正确';
		} else if (preg_match("/^(1,).*/i", $return)) {
			$result['status'] = 1;
			$result['msg'] = '短信发送成功，消息编号'.preg_replace("/1,/i", "", $return);
		} else if (preg_match("/^(0,).*/i", $return)) {
			$result['msg'] = '短信发送失败，消息编号'.preg_replace("/0,/i", "", $return);
		} else if ($return == 2) {
			$result['msg'] = '余额不够或扣费错误';
		} else if ($return == 3) {
			$result['msg'] = '扣费失败异常（请联系客服）';
		} else if (preg_match("/^(5,).*/i", $return)) {
			$result['status'] = 1;
			$result['msg'] = '短信定时成功，消息编号'.preg_replace("/5,/i", "", $return);
		} else if ($return == 6) {
			$result['msg'] = '有效号码为空';
		} else if ($return == 7) {
			$result['msg'] = '短信内容为空';
		} else if ($return == 8) {
			$result['msg'] = '无签名，格式：【签名】';
		} else if ($return == 9) {
			$result['msg'] = '没有url提交权限';
		} else if ($return == 10) {
			$result['msg'] = '发送号码过多，最多支持200个号码';
		} else if ($return == 11) {
			$result['msg'] = '产品ID异常或产品禁用';
		} else if ($return == 12) {
			$result['msg'] = '参数异常';
		} else if ($return == 14) {
			$result['msg'] = '用户名或密码不正确，产品余额为0，禁止提交，联系客服';
		} else if ($return == 15) {
			$result['msg'] = 'IP验证失败';
		} else if ($return == 19) {
			$result['msg'] = '短信内容过长，最多支持500个，或提交编码异常导致';
		} else {
			$result['msg'] = '未知错误';
		}

		$result['msg'] .= $message;
		return $result;	
	}
	
	/**
	 * 发送模板短信
	 * @param $mobile 手机号码集合,用英文逗号分开,接受字符串类型的电话号码
	 * @param $args 内容数据 格式为数组 
	 *   例如：array('name'=>'Marry','value'=>'Alon')，如不需替换请填 null
	 * @param $template_id 模板ID 测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
	 * @return  数组格式 status:状态 msg:错误信息
	 */
	public function sendTemplateSMS($mobile,$args,$template_id,$content)
	{
		$loop = 0; $message = ""; $result = array('status'=>0, 'msg'=>'');
		$limit = intval($this->sms['config']['limit']);
		$url = 'http://www.ztsms.cn:8800/sendSms.do'; //短信接口的URL
		$loop = ceil(count($mobile)/$limit);

		$params['username'] = $this->sms['user_name'];
		$params['password'] = md5($this->sms['password']);
		$params['mobile'] = $mobile;
		$params['productid'] = $this->sms['config']['productid'];
		$params['xh'] = '';
		if (is_array($content)) {
			if (isset($content['content'])) {
				$params['content'] = urlencode($this->get_signature().$content['content']);
			}
			if (isset($content['xh'])) {
				$params['xh'] = $content['xh'];
			}
		} else {
			$params['content'] = urlencode($this->get_signature().$content);
		}	
		
		if ($loop > 1) {
			for ($i=0; $i<$loop; $i++) {
				$sub_mobile = array_slice($mobile,$i*$limit,$limit);
				$params['mobile'] = implode(",",$sub_mobile);
				$return = $this->request($url, $params);
				if (!preg_match("/^(1,).*/i", $return)) { 
					$message = '从第['.($i+1).']个号码'.$mobile_number[$i*$limit]."开始发送失败"; break; 
				}
			}
		} else if ($loop == 1) {
			$params['mobile'] = implode(",",$mobile);
			$return = $this->request($url, $params);
		}

		if ($return == -1) {
			$result['msg'] = '用户名或密码不正确';
		} else if (preg_match("/^(1,).*/i", $return)) {
			$result['status'] = 1;
			$result['msg'] = '短信发送成功，消息编号'.preg_replace("/1,/i", "", $return);
		} else if (preg_match("/^(0,).*/i", $return)) {
			$result['msg'] = '短信发送失败，消息编号'.preg_replace("/0,/i", "", $return);
		} else if ($return == 2) {
			$result['msg'] = '余额不够或扣费错误';
		} else if ($return == 3) {
			$result['msg'] = '扣费失败异常（请联系客服）';
		} else if (preg_match("/^(5,).*/i", $return)) {
			$result['status'] = 1;
			$result['msg'] = '短信定时成功，消息编号'.preg_replace("/5,/i", "", $return);
		} else if ($return == 6) {
			$result['msg'] = '有效号码为空';
		} else if ($return == 7) {
			$result['msg'] = '短信内容为空';
		} else if ($return == 8) {
			$result['msg'] = '无签名，格式：【签名】';
		} else if ($return == 9) {
			$result['msg'] = '没有url提交权限';
		} else if ($return == 10) {
			$result['msg'] = '发送号码过多，最多支持200个号码';
		} else if ($return == 11) {
			$result['msg'] = '产品ID异常或产品禁用';
		} else if ($return == 12) {
			$result['msg'] = '参数异常';
		} else if ($return == 14) {
			$result['msg'] = '用户名或密码不正确，产品余额为0，禁止提交，联系客服';
		} else if ($return == 15) {
			$result['msg'] = 'IP验证失败';
		} else if ($return == 19) {
			$result['msg'] = '短信内容过长，最多支持500个，或提交编码异常导致';
		} else {
			$result['msg'] = '未知错误';
		}

		$result['msg'] .= $message;
		return $result;	
	}

	public function getSmsInfo()
	{	
		return "上海助通信息";	
	}

	public function queryAccountInfo()
	{
		return "本接口未实现";
	}
	
	public function check_fee()
	{
		$url = "http://www.ztsms.cn:8800/balance.do";
		$params['username'] = $this->sms['user_name'];
		$params['password'] = $this->sms['password'];
		$params['productid'] = $this->sms['config']['productid'];		
		$return = $this->request($url, $params);

		$result = array();
		if ($return >=0) {
			$result['status'] = 1;
			$result['msg'] = "当前剩余信息条数：{$return}";
		} else {
			$result['status'] = 0;
			if ($return == -1)		{ $result['msg'] = "用户名或密码不正确"; }
			else if ($return == -2) { $result['msg'] = "没有url提交权限"; }
			else if ($return == -3) { $result['msg'] = "信息查询失败"; }
		}

		return $return;
	}

	private function request($url, $params) {
        /* 格式化将要发要送的参数 */
        if ($params && is_array($params))
        {
			$str = "";
            foreach ($params AS $key => $value)
            {
                $str .= '&' . $key . '=' . $value;
            }
            $params = preg_replace('/^&/', '', $str);
        }
		$return = file_get_contents($url.'?'.$params);

		return $return;
	}

	private function get_signature() {
		$sign = app_conf('SHOP_TITLE');
		$sign = '【'.$sign.'】';
		return $sign;
	}
}