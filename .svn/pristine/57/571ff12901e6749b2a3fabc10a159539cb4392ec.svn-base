<?php 

defined('ALLINPAY_PATH')||define('ALLINPAY_PATH', APP_ROOT_PATH.'system/payment/Allinpay/');
header("Content-type:text/html;charset=UTF-8");
require_once('ArrayXml.class.php');
 
class PhpTools {
	public $apiUrl			= 'https://tlt.allinpay.com/aipg/ProcessServlet';
	public $password		= '111111';
	public $certFile		= '';
	public $privateKeyFile	= '';
	public $arrayXml;

	/**
	 * 初始化证书/apiurl参数
	 * @param bollen $flag 真值为生产环境,否则为测试环境
	 */
	public function __construct()      
    {      
        $this->arrayXml = new ArrayAndXml();
		$this->certFile = dirname(dirname(__FILE__)).'/data/allinpay-pds.pem';
		$this->privateKeyFile = dirname(dirname(__FILE__)).'/data/20073100000554304.pem';
    }     
	
	/**
	 * PHP版本低于 5.4.1 的在通联返回的是 GBK编码环境使用
	 * 但是本地文件编码是 UTF-8
	 *
	 * @param string $hexstr
	 * @return binary string
	 */
	public function hextobin($hexstr) {
	    $n = strlen($hexstr);
	    $sbin = "";
	    $i = 0;
	
	    while($i < $n) {
	        $a = substr($hexstr, $i, 2);
	        $c = pack("H*",$a);
	        if ($i==0) {
	            $sbin = $c;
	        } else {
	            $sbin .= $c;
	        }
	
	        $i+=2;
	    }
	
	    return $sbin;
	}

	/**
	 * 验签
	 */
	public function verifyXml($xmlResponse){
		// 本地反馈结果验证签名开始
		$signature = '';
		if (preg_match('/<SIGNED_MSG>(.*)<\/SIGNED_MSG>/i', $xmlResponse, $matches)) {
		    $signature = $matches[1];
		}
		
		$xmlResponseSrc = preg_replace('/<SIGNED_MSG>.*<\/SIGNED_MSG>/i', '', $xmlResponse);
		//$xmlResponseSrc = mb_convert_encoding(str_replace('<','&lt;',$xmlResponseSrc), "UTF-8", "GBK");
		$pubKeyId = openssl_get_publickey(file_get_contents($this->certFile));
		$flag = (bool) openssl_verify($xmlResponseSrc, $this->hextobin($signature), $pubKeyId);
		openssl_free_key($pubKeyId);

		if ($flag) {
		    // 变成数组，做自己相关业务逻辑
			$xmlResponse = str_replace('<?xml version="1.0" encoding="GBK"?>', '<?xml version="1.0" encoding="UTF-8"?>', $xmlResponseSrc);
		    $xmlResponse = mb_convert_encoding($xmlResponse, 'UTF-8', 'GBK');
		    $results = $this->arrayXml->parseString($xmlResponse, true);
		    return $results;
		}

		return false;
	}
	
	/**
	 * 验签
	 */
	public function verifyStr($orgStr,$signature){
		$pubKeyId = openssl_get_publickey(file_get_contents($this->certFile));
		$flag = (bool) openssl_verify($orgStr, $this->hextobin($signature), $pubKeyId);
		openssl_free_key($pubKeyId);
		
		if ($flag) {
		    return true;
		} else {
		    return false;
		}
	}
	
	/**
	 * 签名
	 */
	public function signXml($params){
		$xmlSignSrc = $this->arrayXml->toXmlGBK($params, 'AIPG');
		$xmlSignSrc = str_replace("TRANS_DETAIL2", "TRANS_DETAIL",$xmlSignSrc);
		$privateKey = file_get_contents($this->privateKeyFile);
		$pKeyId = openssl_pkey_get_private($privateKey, $this->password);
		openssl_sign($xmlSignSrc, $signature, $pKeyId);
		openssl_free_key($pKeyId);
		$params['INFO']['SIGNED_MSG'] = bin2hex($signature);
		$xmlSignPost = $this->arrayXml->toXmlGBK($params, 'AIPG');

		return  $xmlSignPost;
	}

	/**
	 * 发送请求
	 * @param array $params
	 * @return xml string
	 */
	public function send($params){
		$xmlSignPost=$this->signXml($params);
		$xmlSignPost=str_replace("TRANS_DETAIL2", "TRANS_DETAIL",$xmlSignPost);
		$response = cURL::factory()->post($this->apiUrl, $xmlSignPost);
	
		if (!isset($response['body'])) {
			return false;
		}

		//获取返回报文
		$xmlResponse = $response['body'];
		$xmlResponse = mb_convert_encoding($xmlResponse, 'UTF-8', 'GBK');

		return $xmlResponse;
	}
}
?>