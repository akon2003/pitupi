<?php
/**
 * 创建一个类，这个类里包含两个接口方法，在方法中处理数据，然后按格式返回数据
 */

require_once ROOT_PATH.'system/common.php';
require_once ROOT_PATH.'system/payment/AllinpayPos_payment.php';

class Order{

    private $nombre = '';
	private $payment = null;

    public function __construct($name = 'World') 
	{
		$this->name = $name;
		$this->payment = new AllinpayPos_payment();
	}

    public function greet($name = '') 
	{
		$name = $name?$name:$this->name;
        return 'Hello '.$name.'.';
	}

    public function serverTimestamp() 
	{
		return time();
	}


    /**
     * @param $data
     * @return SimpleXMLElement
     */
	public function queryOrder($data) {
        $data = simplexml_load_string($data);
		$nombre = $this->payment->get_agree_password(); //约定的密码
        /**
         * 在这里查询根据接收到的参数查询数据 然后按规定格式返回
         */
        $trxId =  $data->trxId; //交易流水号
        $trxcod =  $data->trxcod;//交易类型F0000001
        $payinst =  $data->payinst;//支付机构编号,通联编号(999999999)
        $entinst =  $data->entinst;//entinst企业编号,商户编号(终端商户号)
        $bizseq =  $data->bizseq; //业务流水号,协议号
        $qryType =  $data->qryType; //1：金融增值、2：理财产品购买、3：理财查询
        $timestamp =  $data->timestamp;//交易时间
        $biztype =  $data->biztype;//业务类型,保留域
        $termid =  $data->termid;//终端编码,终端代码，校验用
        $userid =  $data->userid;//用户代码

        $mac =  $data->mac;//mac校验码
		//MD5（交易流水号|交易类型码|交易时间|业务流水号|响应码|约定的密码）.如果某一交易没有对应的字段，则留空，但是|不能少；
        $md5_str = md5($trxId."|".$trxcod."|".$timestamp."|".$bizseq."|"."|".$nombre);
        $md5_1 = substr($mac,3);
        $md5_2 = substr(mb_strtoupper($md5_str),3);
		$bizcode = 'TLallinpay';
        $bizname = '通联';
        $amount = 0;
        $relatname = '';
        $relatacct = '';
        $idtype = '';
		$idno = '';
        $mobileno = $bizseq;
        $quot = '';
        $preprofit = '';
        $dayprofit = '';
        $deadline = '';


		if($md5_1 != $md5_2){
            //返回错误信息
            $rspcode = '9999';
            $rspmsg = '校验码出错,请您正确提交';
            $md5_3 =  md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);
            return
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><JRTQry><trxId>'.$trxId.'</trxId><trxcod>'.$trxcod.'</trxcod><payinst>'.$payinst.'</payinst><entinst>'.$entinst.'</entinst><bizseq>'.$bizseq.'</bizseq><qryType>'.$qryType.'</qryType><rspcode>'.$rspcode.'</rspcode><rspmsg>'.$rspmsg.'</rspmsg><bizcode>'.$bizcode.'</bizcode><bizname>'.$bizname.'</bizname><relatname>'.$relatname.'</relatname><relatacct>'.$relatacct.'</relatacct><amount>'.$amount.'</amount><idtype>'.$idtype.'</idtype><idno>'.$idno.'</idno><mobileno>'.$mobileno.'</mobileno><quot>'.$quot.'</quot><preprofit>'.$preprofit.'</preprofit><dayprofit>'.$dayprofit.'</dayprofit><deadline>'.$deadline.'</deadline><content></content><mac>'.$md5_3.'</mac></JRTQry>';
        }

		$res = $this->payment->query_order($bizseq);

		if (!$res){
			//返回错误信息
			$rspcode = '9999';
			$rspmsg = '系统无此信息,请您正确提交';
			$md5_3 =  md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);
			$content = '没有此编号信息';
			return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<JRTQry>
					<trxId>'.$trxId.'</trxId>
					<trxcod>'.$trxcod.'</trxcod>
					<payinst>'.$payinst.'</payinst>
					<entinst>'.$entinst.'</entinst>
					<bizseq>'.$bizseq.'</bizseq>
					<qryType>'.$qryType.'</qryType>
					<rspcode>'.$rspcode.'</rspcode>
					<rspmsg>'.$rspmsg.'</rspmsg>
					<bizcode>'.$bizcode.'</bizcode>
					<bizname>'.$bizname.'</bizname>
					<relatname>'.$relatname.'</relatname>
					<relatacct>'.$relatacct.'</relatacct>
					<amount>'.$amount.'</amount>
					<idtype>'.$idtype.'</idtype>
					<idno>'.$idno.'</idno>
					<mobileno>'.$mobileno.'</mobileno>
					<quot>'.$quot.'</quot>
					<preprofit>'.$preprofit.'</preprofit>
					<dayprofit>'.$dayprofit.'</dayprofit>
					<deadline>'.$deadline.'</deadline>
					<content>'.$content.'</content>
					<mac>'.$md5_3.'</mac>
				</JRTQry>';
		} else {
			$rspcode = '0000';
			$md5_3 =  md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);

			$amount = $res['money'] * 100;
			$bizcode = '';
			$bizname = '';
			$relatname = '';
			$relatacct = '';
			$idtype = '';
			$idno = '';
			$mobileno = '';
			$quot = '';
			$preprofit = '';
			$dayprofit = '';
			$deadline = '';
			
            return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<JRTQry>
					<trxId>'.$trxId.'</trxId>
					<trxcod>'.$trxcod.'</trxcod>
					<payinst>'.$payinst.'</payinst>
					<entinst>'.$entinst.'</entinst>
					<bizseq>'.$bizseq.'</bizseq>
					<qryType>'.$qryType.'</qryType>
					<rspcode>'.$rspcode.'</rspcode>
					<rspmsg>'.$rspmsg.'</rspmsg>
					<bizcode>'.$bizcode.'</bizcode>
					<bizname>'.$bizname.'</bizname>
					<relatname>'.$relatname.'</relatname>
					<relatacct>'.$relatacct.'</relatacct>
					<amount>'.$amount.'</amount>
					<idtype>'.$idtype.'</idtype>
					<idno>'.$idno.'</idno>
					<mobileno>'.$mobileno.'</mobileno>
					<quot>'.$quot.'</quot>
					<preprofit>'.$preprofit.'</preprofit>
					<dayprofit>'.$dayprofit.'</dayprofit>
					<deadline>'.$deadline.'</deadline>
					<content></content>
					<mac>'.$md5_3.'</mac>
				</JRTQry>';
		}
    }

    public function payConfirm($xml_data){
		$data = simplexml_load_string($xml_data);
		$trxId =  $data->trxId; //交易流水号
        $trxcod =  $data->trxcod;//交易类型F0000001
        $payinst =  $data->payinst;//支付机构编号,通联编号(999999999)
        $entinst =  $data->entinst;//entinst企业编号,商户编号(终端商户号)
        $timestamp =  $data->timestamp;//交易时间,Yyyymmddhhmmss
        $qryType =  $data->qryType; //1：金融增值、2：理财产品购买、3：理财查询
        $bizseq =  $data->bizseq; //业务流水号,协议号
        $biztype =  $data->biztype;//业务类型,保留域
        $termid =  $data->termid;//终端编码,终端代码，校验用
        $userid =  $data->userid;//用户代码
		$payresult = $data->payresult; //支付结果，0000表示支付成功
        $amount = $data->amount;//金额	20	单位分
        $payseq = $data->payseq;//检索参考号
        $batchid = $data->batchid;//批次号
        $traceno = $data->traceno;//终端流水
        $payname = $data->payname;//实际的支付账户户名
        $payacct = $data->payacct;//实际的支付账户账号
        $acctinst =$data->acctinst;//支付账户所属银行号
        $relatname = $data->relatname;//查询结果中的关联户姓名
        $relatacct = $data->relatacct;//查询结果中的关联户账号
        $relatinst = $data->relatinst;//关联户所属机构
        $idtype = $data->idtype;//证件类型
        $idno = $data->idno;//证件号码
        $mobileno = $data->mobileno;//手机号码
        $content = $data->content;//业务关联内容
        $userid = $data->userid;//用户代码
        $mac =  $data->mac;//mac校验码
		$nombre = $this->payment->get_agree_password(); //约定的密码
		$md5_str =  md5($trxId."|".$trxcod."|".$timestamp."|".$bizseq."|"."|".$nombre);		
        $dispaddi = '通联支付测试';

        $md5_1 = substr($mac,3);
		$md5_2 = substr(mb_strtoupper($md5_str),3);

        if($md5_1 != $md5_2){
            //返回错误信息
            $rspcode = '9996';
            $rspmsg = '校验码出错,请您正确提交';
            $md5_3 = md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);
            return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<JRTPay>
					<trxId>'.$trxId.'</trxId>
					<trxcod>'.$trxcod.'</trxcod>
					<payinst>'.$payinst.'</payinst>
					<entinst>'.$entinst.'</entinst>
					<bizseq>'.$bizseq.'</bizseq>
					<rspcode>'.$rspcode.'</rspcode>
					<rspmsg>'.$rspmsg.'</rspmsg>
					<dispaddi>'.$dispaddi.'</dispaddi>
					<mac>'.$md5_3.'</mac>
				</JRTPay>';
        }

		$res = $this->payment->query_order($bizseq);

        if($payresult == '0000' && $res){
			/**
			在这里进行对数据库的更改，因已刷卡支付成功，就在这里对数据库进行更改和处理，
			并将 payseq 存入到数据库中以便日后开发检索时使用，并要根据payseq检查，是否已经通知过。
			**/
			$this->payment->pay_confirm($xml_data);

            $rspcode = '0000';
            $rspmsg = '通联测试成功';
            $md5_3 =  md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);
            return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<JRTPay>
					<trxId>'.$trxId.'</trxId>
					<trxcod>'.$trxcod.'</trxcod>
					<payinst>'.$payinst.'</payinst>
					<entinst>'.$entinst.'</entinst>
					<bizseq>'.$bizseq.'</bizseq>
					<rspcode>'.$rspcode.'</rspcode>
					<rspmsg>'.$rspmsg.'</rspmsg>
					<dispaddi>'.$dispaddi.'</dispaddi>
					<mac>'.$md5_3.'</mac>
				</JRTPay>';
			}else{
            //返回错误信息
            $rspcode = '9996';
            $rspmsg = '通联支付端错误';
            $md5_3 =  md5($trxId."|".$trxcod."|"."|".$bizseq."|".$rspcode."|".$nombre);

            return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<JRTPay>
					<trxId>'.$trxId.'</trxId>
					<trxcod>'.$trxcod.'</trxcod>
					<payinst>'.$payinst.'</payinst>
					<entinst>'.$entinst.'</entinst>
					<bizseq>'.$bizseq.'</bizseq>
					<rspcode>'.$rspcode.'</rspcode>
					<rspmsg>'.$rspmsg.'</rspmsg>
					<dispaddi>'.$dispaddi.'</dispaddi>
					<mac>'.$md5_3.'</mac>
				</JRTPay>';
        }
    }

}