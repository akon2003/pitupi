<?php

/**
 * 容联云通讯接口
 */

/* 模块的基本信息 */
$sms_lang = array(
	'name'			=> '容联云通讯',
	'accountSid'	=> '主帐号',
	'accountToken'  => '主帐号令牌',
	'appId'			=> '应用Id',
	'serverIP'		=> '请求地址',
	'serverPort'	=> '请求端口',
	'softVersion'	=> '请求版本',
	'limit'			=> '最大支持'
);

$config = array( 
	'accountSid'	=> array('INPUT_TYPE' => '0'), //主帐号:
	'accountToken'	=> array('INPUT_TYPE' => '0'), //主帐号令牌:
	'appId'			=> array('INPUT_TYPE' => '0'), //应用Id:
	'serverIP'		=> array('INPUT_TYPE' => '0'), //请求地址:
	'serverPort'	=> array('INPUT_TYPE' => '0'), //请求端口:
	'softVersion'	=> array('INPUT_TYPE' => '0'), //请求版本:
	'limit'			=> array('INPUT_TYPE' => '0'), //最多支持号码数:
);


/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == TRUE) 
{
    $module['server_url']	= 'sandboxapp.cloopen.com:8883';
	$module['class_name']   = 'YTX';
    $module['name']			= $sms_lang['name']; //名称
    $module['config']		= $config; //配置    
    $module['lang']			= $sms_lang;       
    return $module;
}

require_once(APP_ROOT_PATH.'system/libs/sms.php');
class YTX_sms implements sms
{
	public $class_name		= 'YTX';
	public $sms;
	
    public function __construct($smsInfo = '')
    { 	    	
		if(!empty($smsInfo)){
			$this->sms = $smsInfo;
		}
    }

    public function sendSMS($mobile_number,$content,$is_adv) {
    	//本接口发送模板短信
    }

	/**
	 * 发送模板短信
	 * @param $mobile 手机号码集合,用英文逗号分开,接受字符串类型的电话号码
	 * @param $args 内容数据 格式为序列化数组 
	 *   例如：array('name'=>'Marry','value'=>'Alon')，如不需替换请填 null
	 * @param $template_id 模板ID 测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
	 * @return  数组格式 status:状态 msg:错误信息
	 * 
	 * 假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为
	 * result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");	
	 * 则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入
	 */
	public function sendTemplateSMS($mobile,$args,$template_id,$content="")
	{
		$return = array('status'=>0, 'msg'=>'');
		//多条信息发送限制号码限制
		$limit = intval($this->sms['config']['limit']);
		if (!$limit) { $limit = 100; }

		if (is_string($mobile) && trim($mobile) == "") {
			$return['msg'] = "电话号码不能为空";
			return $return;
		} else if (is_array($mobile) && count($mobile) > $limit) {
			$return['msg'] = "发送号码个数超过限制".$limit."条";
			return $return;
		}

		if (!$template_id) {
			$return['msg'] = "没有指定短信模板";
			return $return;
		}

		$template_id = $this->template_sys_to_ytx($template_id);

		if (!$template_id) {
			$return['msg'] = "无效的短信模板";
			return $return;
		}

		$to = is_array($mobile)? implode(",", $mobile) : $mobile;


		require_once(APP_ROOT_PATH.'system/sms/YTX/CCPRestSmsSDK.php');

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid = $this->sms['config']['accountSid'];
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken = $this->sms['config']['accountToken'];
		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId = $this->sms['config']['appId'];
		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP = $this->sms['config']['serverIP'];
		//请求端口，生产环境和沙盒环境一致
		$serverPort = intval($this->sms['config']['serverPort']);
		//REST版本号，在官网文档REST介绍中获得。
		$softVersion = $this->sms['config']['softVersion'];

	    $rest = new CCPRestSms($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken); 
	    $rest->setAppId($appId); 

		$datas = null;

		//组织短信内容
		if ($args) {
			$args = unserialize($args);
			$datas = array();
			foreach ($args as $k=>$v) {
				$datas[] = $v;
			}
		}

 
	    // 发送模板短信
	    $result = $rest->sendTemplateSMS($to, $datas, $template_id); 
	    if($result == NULL ) {
	    	$return['msg'] = "发送失败,请重试!";
	    	return $return;
	    }

	    if($result->statusCode!=0) {
	    	$return['msg'] = "发送失败,错误代码:" . $result->statusCode . ",错误信息:" . $result->statusMsg;
	    }else{
	    	$return['status'] = 1;
	    	$return['msg'] = "发送成功";
	    }

	    return $return;	    
	}

    public function getSmsInfo()
    {
    	return "容联云通讯";
    }

    /**
     * 账户信息查询
     */
    public function queryAccountInfo()
    {
    	require_once(APP_ROOT_PATH.'system/sms/YTX/CCPRestSDK.php');

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid = $this->sms['config']['accountSid'];
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken = $this->sms['config']['accountToken'];
		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId = $this->sms['config']['appId'];
		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP = $this->sms['config']['serverIP'];
		//请求端口，生产环境和沙盒环境一致
		$serverPort = $this->sms['config']['serverPort'];
		//REST版本号，在官网文档REST介绍中获得。
		$softVersion = $this->sms['config']['softVersion'];

        $rest = new CCPRest($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        // 调用主帐号信息查询接口
        $result = $rest->queryAccountInfo();

        $msg = "";
        if($result == NULL ) {
            $msg .= "查询请求出错,请重试!";
            return $msg;
        }
        if($result->statusCode!=0) {
            $msg .= "错误代码: " . $result->statusCode . "\r\n";
            $msg .= "错误信息: " . $result->statusMsg . "\r\n";
            //TODO 添加错误处理逻辑
        }else{
            $msg .= "账户信息查询成功!\r\n";
            // 获取返回信息
            $account = $result->Account;
            $msg .= "主账户名称: ".$account->friendlyName."\r\n";
            $msg .= "类型: ".($account->type==0? "试用中":"已注册")."\r\n";
            $msg .= "状态: ".($account->status==0? "未激活":($account->status==1?"已激活":($account->status==2?"已暂停":"已关闭")))."\r\n";
            $msg .= "创建时间: ".$account->dateCreated."\r\n";
            $msg .= "更新时间: ".$account->dateUpdated."\r\n";
            $msg .= "主账户余额: ".number_format(doubleval($account->balance),2)."元\r\n";
            $msg .= "子账户余额: ".number_format(doubleval($account->subBalance),2)."元\r\n";
            //TODO 添加成功处理逻辑
        }
        return $msg;
    }

	/**
	 * 查询账户余额
	 */
	public function check_fee() {
        require_once(APP_ROOT_PATH.'system/sms/YTX/CCPRestSDK.php');

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid = $this->sms['config']['accountSid'];
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken = $this->sms['config']['accountToken'];
		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId = $this->sms['config']['appId'];
		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP = $this->sms['config']['serverIP'];
		//请求端口，生产环境和沙盒环境一致
		$serverPort = $this->sms['config']['serverPort'];
		//REST版本号，在官网文档REST介绍中获得。
		$softVersion = $this->sms['config']['softVersion'];

        $rest = new CCPRest($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        // 调用主帐号信息查询接口
        $result = $rest->queryAccountInfo();

        $msg = "";
        if($result == NULL ) {
            $msg .= "查询失败,请重试!";
            return $msg;
        }
        if($result->statusCode!=0) {
            $msg .= "查询失败,请重试!";
        }else{
            // 获取返回信息
            $account = $result->Account;
            $msg .= "主账户:".number_format(doubleval($account->balance),2)."元;";
            $msg .= "子账户:".number_format(doubleval($account->subBalance),2)."元";
        }

        return $msg;
	}

	/**
	 * 系统模板ID转换云通讯模板ID
	 * @param  [int] $template_id 系统模板ID
	 * @return [string] 云通讯模板ID
	 */
	public function template_sys_to_ytx($template_id) {
		//云通讯测试模板ID=1
		if ($template_id == '-1') { return '1'; }
		//测试期间,所有都返回为	1	
		return 1;
	}
}