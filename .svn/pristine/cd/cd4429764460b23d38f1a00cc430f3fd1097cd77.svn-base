<?php

class PaymentNoticeAction extends CommonAction{
	public function com_search(){
		$map = array ();
	
		if (!isset($_REQUEST['end_time']) || $_REQUEST['end_time'] == '') {
			$_REQUEST['end_time'] = to_date(get_gmtime(), 'Y-m-d');
		}
	
	
		if (!isset($_REQUEST['start_time']) || $_REQUEST['start_time'] == '') {
			$_REQUEST['start_time'] = dec_date($_REQUEST['end_time'], 7);
		}
	
		$map['start_time'] = trim($_REQUEST['start_time']);
		$map['end_time'] = trim($_REQUEST['end_time']);
	
		$this->assign("start_time",$map['start_time']);
		$this->assign("end_time",$map['end_time']);
	
	
		if ($map['start_time'] == ''){
			$this->error('开始时间 不能为空');
			exit;
		}
	
		if ($map['end_time'] == ''){
			$this->error('结束时间 不能为空');
			exit;
		}
	
		$d = explode('-',$map['start_time']);
		if (checkdate($d[1], $d[2], $d[0]) == false){
			$this->error("开始时间不是有效的时间格式:{$map['start_time']}(yyyy-mm-dd)");
			exit;
		}
	
		$d = explode('-',$map['end_time']);
		if (checkdate($d[1], $d[2], $d[0]) == false){
			$this->error("结束时间不是有效的时间格式:{$map['end_time']}(yyyy-mm-dd)");
			exit;
		}
	
		if (to_timespan($map['start_time']) > to_timespan($map['end_time'])){
			$this->error('开始时间不能大于结束时间:'.$map['start_time'].'至'.$map['end_time']);
			exit;
		}
	
		$q_date_diff = 31;
		$this->assign("q_date_diff",$q_date_diff);
		//echo abs(to_timespan($map['end_time']) - to_timespan($map['start_time'])) / 86400 + 1;
		if ($q_date_diff > 0 && (abs(to_timespan($map['end_time']) - to_timespan($map['start_time'])) / 86400  + 1 > $q_date_diff)){
			$this->error("查询时间间隔不能大于  {$q_date_diff} 天");
			exit;
		}
		
		return $map;
	}

	public function index()
	{
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		$payment_list = M("Payment")->where("is_effect = 1")->field("id,name")->findAll();
		$this->assign("payment_list",$payment_list);

		if(isset($_REQUEST['payment_id']) && intval($_REQUEST['payment_id']) > 0){
			$condition['payment_id'] = array("eq",intval($_REQUEST['payment_id']));
		} else {
			foreach ($payment_list as $key=>$value) {
				$payment_id[$key] = $value['id'];
			}
			$condition['payment_id'] = array("in", $payment_id);
		}
	
		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt",$start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}
		
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$this->assign("main_title", "所有充值单");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("index");
	}

	public function online()
	{
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		$payment_list = M("Payment")->where("is_effect = 1 and online_pay = 1")->field("id, name")->findAll();
		$this->assign("payment_list",$payment_list);

		if(isset($_REQUEST['payment_id']) && intval($_REQUEST['payment_id']) > 0){
			$condition['payment_id'] = array("eq",intval($_REQUEST['payment_id']));
		} else {
			foreach ($payment_list as $key=>$value) {
				$payment_id[$key] = $value['id'];
			}
			$condition['payment_id'] = array("in", $payment_id);
		}
	
		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("gt",$start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("lt",$end_time);
			}
		}
		
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$this->assign("main_title", "线上充值单");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("online");
	}

	public function posline()
	{
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		$condition['payment_id'] = M("Payment")->where("class_name='AllinpayPos'")->getField("id");
	
		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt", $start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}
		
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$this->assign("main_title", "POS充值单");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("posline");
	}

	//查询个人充值记录
	public function myposline()
	{
		// 添加操作人员ID
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$condition['input_user_id'] = $adm_session['adm_id'];
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		$condition['payment_id'] = M("Payment")->where("class_name='AllinpayPos'")->getField("id");
	
		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt", $start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}
		
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$this->assign("main_title", "POS充值单");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("posline");
	}

	public function offline()
	{
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		$condition['payment_id'] = M("Payment")->where("class_name='Otherpay'")->getField("id");
	
		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt",$start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}
		
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		$this->assign("main_title", "线下充值单");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("PaymentNotice");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("offline");
	}

	public function export_csv($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or phone like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
		}

		if(isset($_REQUEST['payment_id']) && intval($_REQUEST['payment_id']) > 0){
			$condition['payment_id'] = array("eq",intval($_REQUEST['payment_id']));
		} else {
			if (isset($_REQUEST['act']) && trim($_REQUEST['act']) == "offline") {
				$condition['payment_id'] = array("eq", M("Payment")->where("class_name='Otherpay'")->getField("id"));
			} else if (isset($_REQUEST['act']) && trim($_REQUEST['act']) == "posline") {
				$condition['payment_id'] = array("eq", M("Payment")->where("class_name='AllinpayPos'")->getField("id"));
			} else if (isset($_REQUEST['act']) && trim($_REQUEST['act']) == "online") {
				$payment_list = M("Payment")->where("is_effect = 1 and online_pay = 1")->field("id, name")->findAll();
				foreach ($payment_list as $key=>$value) {
					$payment_id[$key] = $value['id'];
				}
				$condition['payment_id'] = array("in", $payment_id);
			} else {
				$payment_list = M("Payment")->where("is_effect = 1")->field("id, name")->findAll();
				foreach ($payment_list as $key=>$value) {
					$payment_id[$key] = $value['id'];
				}
				$condition['payment_id'] = array("in", $payment_id);
			}
		}

		if (isset($_REQUEST['end_time']) || isset($_REQUEST['start_time'])) {
			$end_time = trim($_REQUEST['end_time']);
			$start_time = trim($_REQUEST['start_time']);

			if ($end_time != "") {
				$d = explode('-',$end_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("结束时间不是有效的时间格式:{$end_time}(yyyy-mm-dd)");
					exit;
				}
			}
			if ($start_time != "") {
				$d = explode('-',$start_time);
				if (checkdate($d[1], $d[2], $d[0]) == false){
					$this->error("开始时间不是有效的时间格式:{$start_time}(yyyy-mm-dd)");
					exit;
				}
			}

			if ($end_time != "" && $start_time != "") {
				if (to_timespan($start_time) > to_timespan($end_time)){
					$this->error('开始时间不能大于结束时间:'.$start_time.'至'.$end_time);
					exit;
				}
			}

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt",$start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt",$end_time);
			}
		}
	
		if (isset($_REQUEST['is_paid']) && intval($_REQUEST['is_paid']) >= 0) {
			$condition['is_paid'] = intval($_REQUEST['is_paid']);
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");
	
		$list = M("PaymentNotice")->where($map)
			->field("id,notice_sn,create_time,pay_time,is_paid,user_id,payment_id,memo,input_user_id,money")
			->limit($limit)->findAll();
		
		if ($list && count($list)) {
			for ($i=0; $i<count($list); $i++) {
				$list[$i]['payment_name'] = M("payment")->where("id=".$list[$i]['payment_id'])->getField("name");
				$user = M("User")->where("id=".$list[$i]['user_id'])
					->Field("AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,user_name")
					->find();
				$list[$i]['user_name'] = $user['user_name'];
				$list[$i]['real_name'] = $user['real_name'];
				$list[$i]['mobile'] = $user['mobile'];
				$list[$i]['remain_money'] = $user['money'];

				$input_user = M("User")->where("id=".$list[$i]['input_user_id'])
					->Field("AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name")
					->find();
				$list[$i]['input_user_real_name'] = $input_user['real_name'];
			}
		}

		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$carry_value = array('id'=>'""','notice_sn'=>'""','user_name'=>'""','real_name'=>'""','mobile'=>'""','money'=>'""','create_time'=>'""','pay_time'=>'""','is_paid','payment_name','remain_money'=>'""','input_user_real_name','memo'=>'""');
			if($page == 1){
				$content = iconv("utf-8","gbk","编号,订单号,会员ID,会员名称,电话号码,金额,交易时间,支付时间,是否支付,支付方式,账户余额,操作者,操作备注");
				$content = $content . "\n";
			}
			for ($i=count($list)-1; $i>=0; $i--) 
			{
				$k = $i; $v = $list[$i];
				$carry_value = array();
				$carry_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$carry_value['notice_sn'] = iconv('utf-8','gbk','"' . $v['notice_sn'] . '"');
				$carry_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$carry_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$carry_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$carry_value['money'] = iconv('utf-8','gbk','"' .  number_format($v['money'],2) . '"');
				$carry_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				$carry_value['pay_time'] = iconv('utf-8','gbk','"' . to_date($v['pay_time']) . '"');
				$carry_value['is_paid'] = iconv('utf-8','gbk','"' . ($v['is_paid']==0?'否':'是') . '"');
				$carry_value['payment_name'] = iconv('utf-8','gbk','"' . $v['payment_name'] . '"');
				$carry_value['remain_money'] = iconv('utf-8','gbk','"' .  number_format($v['remain_money'],2) . '"');
				$carry_value['input_user_real_name'] = iconv('utf-8','gbk','"' . $v['input_user_real_name'] . '"');
				$carry_value['memo'] = iconv('utf-8','gbk','"' . $v['memo'] . '"');
			
				$content .= implode(",", $carry_value) . "\n";
			}	

			header("Content-Disposition: attachment; filename=payment_notice.csv");
	    	echo $content;  
		}
		else
		{
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}

	//管理员收款
	public function update(){   
		
		$notice_id = intval($_REQUEST['id']);
		$outer_notice_sn = strim($_REQUEST['outer_notice_sn']);
		$bank_id = strim($_REQUEST['bank_id']);
		
		//开始由管理员手动收款
		require_once APP_ROOT_PATH."system/libs/cart.php";
		$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where id = ".$notice_id);
		
		if($payment_notice['is_paid'] == 0 )
		{
			if($bank_id)
			{
				$GLOBALS['db']->query("update ".DB_PREFIX."payment_notice set  bank_id = ".$bank_id." where id = ".$notice_id." and is_paid = 0");
			}else{
				$this->error ("请输入直联银行编号");
			}
			payment_paid($notice_id,"银行流水号 ".':'.$outer_notice_sn);	//对其中一条款支付的付款单付款
			$msg = sprintf(l("ADMIN_PAYMENT_PAID"),$payment_notice['notice_sn']);
			save_log($msg,1);
			$this->success(l("ORDER_PAID_SUCCESS"));
		}
		else {
			$this->error (l("INVALID_OPERATION"));
		}
	}
	
	public function gathering(){
		
		$id = intval($_REQUEST['id']);
		$this->assign("id",$id);
		$this->display();
	}
}
?>