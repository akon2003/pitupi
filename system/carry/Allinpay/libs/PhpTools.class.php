<?php 

require_once 'ArrayXml.class.php';
require_once 'cURL.class.php';

class PhpTools{
	public $arrayXml ;
	public $certFile = '';//通联公钥证书
	public $privateKeyFile = '';//商户私钥证书
	public $password = '';//商户私钥密码以及用户密码
	public $apiUrl = '';//通联系统对接请求地址（外网,商户测试时使用）

	public function __construct()      
    {   
        $this->arrayXml = new ArrayAndXml();
		//通联公钥证书
		$this->certFile = dirname(__FILE__).'/allinpay-pds.pem';
		//商户私钥证书
		$this->privateKeyFile = dirname(__FILE__).'/20060400000044502.pem';
		//商户私钥密码以及用户密码
		$this->password = '111111';
		//通联系统对接请求地址（外网,商户测试时使用）
		$this->apiUrl = 'https://tlt.allinpay.com/aipg/ProcessServlet';
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
		$xmlResponseSrc1 = mb_convert_encoding(str_replace('<','&lt;',$xmlResponseSrc), "UTF-8", "GBK");

		$pubKeyId = openssl_get_publickey(file_get_contents($this->certFile));
		$flag = (bool) openssl_verify($xmlResponseSrc, $this->hextobin($signature), $pubKeyId);
		openssl_free_key($pubKeyId);

		if ($flag) {
		    $xmlResponse = mb_convert_encoding(str_replace('<?xml version="1.0" encoding="GBK"?>', '<?xml version="1.0" encoding="UTF-8"?>', $xmlResponseSrc), 'UTF-8', 'GBK');
		    $results = $this->arrayXml->parseString( $xmlResponse , TRUE);
		    return $results;
		} else {
		    return FALSE;
		}
	}
	
	/**
	 * 验签
	 */
	public function verifyStr($orgStr,$signature){
		$pubKeyId = openssl_get_publickey(file_get_contents($this->certFile));
		$flag = (bool) openssl_verify($orgStr, $this->hextobin($signature), $pubKeyId);
		openssl_free_key($pubKeyId);
		
		if ($flag) {
		    return TRUE;
		} else {
		    return FALSE;
		}
	}
	
	/**
	 * 签名
	 */
	public function signXml($params){
		 
		$xmlSignSrc = $this->arrayXml->toXmlGBK($params, 'AIPG');
		$xmlSignSrc=str_replace("TRANS_DETAIL2", "TRANS_DETAIL",$xmlSignSrc);
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
	 */
	public function send($params){
		$xmlSignPost=$this->signXml($params);
		$xmlSignPost=str_replace("TRANS_DETAIL2", "TRANS_DETAIL",$xmlSignPost);
		$response = cURL::factory()->post($this->apiUrl, $xmlSignPost);

        //保存返回结果用以确认错误原因
		$file = dirname(__FILE__).'/'.date('mdHis',time()).rand(100,999).'.txt';
		file_put_contents($file, $xmlSignPost);
	
		if (! isset($response['body'])) {
		    die('Error: HTTPS REQUEST Bad.');
		}
		//获取返回报文
		$xmlResponse = $response['body'];
		//验证返回报文
		$result=$this->verifyXml($xmlResponse);

		return $result;
	}
}

?>