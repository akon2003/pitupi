<?php

class PromoteMsgAction extends CommonAction{
	public function msglog() {		
		$this->assign("main_title", "邮件短信列表");
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("msglog");
	}

	public function mail_index() {
		$condition['type'] = 1;
		$this->assign("default_map",$condition);
		parent::index();
	}

	public function sms_index() {
		$condition['type'] = 0;
		$this->assign("default_map",$condition);
		parent::index();
	}

	public function add_mail() {
		//输出会员组
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		parent::index();
	}

	public function add_sms() {
		//输出会员组
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		parent::index();
	}

	/**
	 * XHF 2016/8/7 
	 * 新增发布模板群发短信
	 */
	public function add_product() {
		//输出会员组
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		parent::index();
	}

	/**
	 * 新增已发短信列表,已发送成功的短信
	 */
	public function sms() {
		$this->assign("main_title","已发送的短信");

		$condition = " 1=1 and template_id<>9 ";
		//短信
		$condition .= " and send_type=0 and is_success=1";

		if(trim($_REQUEST['user_name'])!='') {
			//支持模糊搜索
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition .= " and user_id in (".implode(',',$user_list).")";
		}

		$begin_time = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and create_time >= ".$begin_time;
			} else if ($begin_time==0) {
				$condition .= " and create_time <= ".$end_time;
			} else {
				$condition .= " and create_time between ".$begin_time." and ".$end_time;
			}
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}

		$model = D('DealMsgList');
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}

		$this->display();	
	}

	/**
	 * 新增已发短信列表,待发短信及未成功短信
	 */
	public function sms_wait() {
	}

	public function gen_deal_mail() {
		$id = trim(addslashes($_REQUEST['id']));
		require_once APP_ROOT_PATH.'app/Lib/deal.php';
		require_once APP_ROOT_PATH.'app/Lib/common.php';
		$rs = get_deal_list(count(explode(",",$id)),0," id in (".$id.") ");
		if($rs) {
			$content = get_deal_mail_content($rs['list']);
			$this->ajaxReturn($content,'',1);
		} else {
			$this->ajaxReturn('','',0);
		}		
	}
	
	public function gen_deal_sms() {
		$id = intval($_REQUEST['id']);
		$rs = M("Deal")->where("is_delete = 0 and id = ".$id." ")->find();
		if($rs) {
			$content = get_deal_sms_content($id);
			$this->ajaxReturn($content,'',1);
		} else {
			$this->ajaxReturn('','',0);
		}		
	}
	
	public function import_mail() {
		//开始验证
		if(intval($_REQUEST['mail_type'])==0){//普通邮件
		
			if($_REQUEST['title']=='') {
				$this->success(L("MAIL_TITLE_EMPTY_TIP"),1);
			}
			if($_REQUEST['content']=='') {
				$this->success(l("MAIL_CONTENT_EMPTY_TIP"),1);
			}
		} else {
			if(intval($_REQUEST['deal_id'])==0||M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->count()==0) {
				$this->success(l("DEAL_ID_ERROR"),1);
			}
		}
		
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->success(l("SEND_DEFINE_DATE_EMPTY_TIP"),1);
			}
		}
		
		$msg_data['type'] = 1;
		$msg_data['title'] = $_REQUEST['title'];
		$msg_data['content'] = $_REQUEST['content'];
		$msg_data['is_html'] = intval($_REQUEST['is_html']);
		if($_REQUEST['mail_type']==1) {
			$msg_data['title'] = M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->getField("sub_name")."团购通知邮件";
			if($msg_data['content']=='')
			$msg_data['content'] = get_deal_mail_content(intval($_REQUEST['deal_id']));
			$msg_data['is_html'] = 1;
		}
		
		$msg_data['send_time'] = trim($_REQUEST['send_time'])==''?TIME_UTC:to_timespan($_REQUEST['send_time']);
		$msg_data['send_status'] = 0;
		$msg_data['deal_id'] = intval($_REQUEST['deal_id']);
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
			case 1:
				//订阅城市
				$msg_data['send_type_id'] = intval($_REQUEST['city_id']);
				break;
			case 2:
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}
		$msg_data['send_define_data'] = $_REQUEST['send_define_data'];
		
		$page = intval($_REQUEST['page']);
		$page = $page==0?1:$page;
		$limit = (($page-1)*1000).",1000";
		$end = false;
		//开始设置
		if(intval(app_conf("EDM_ON"))==1) {
			set_time_limit(0);
			//edm 发送
			switch($msg_data['send_type']) {
				case 0:
					//会员组
					$condition = "is_effect = 1 and is_delete = 0";
					if($msg_data['send_type_id']>0)					
					$condition .= " and group_id = ".$msg_data['send_type_id'];
					$mail_list = M("User")->where($condition)->field("email")->limit($limit)->findAll();					
					$email = '';
					foreach($mail_list as $k=>$v)
					{
						$email.=$v['email'].",";
					}
					if($email!='')
					$email = substr($email,0,-1);
					if($email=='')$end = true;
					break;
				case 1:
					//订阅城市		
					$city_id = intval($msg_data['send_type_id']);	
					$condition = "is_effect = 1";
					if($city_id>0)	
					{
						require_once APP_ROOT_PATH."system/utils/child.php";
						$ids_util = new child("deal_city");											
						$ids = $ids_util->getChildIds($city_id);
						$ids[] = $city_id;					
						$ids_str = implode(",",$ids);
						$condition.=" and city_id in (".$ids_str.")";
					}					
					$mail_list = M("MailList")->where($conditon)->field("mail_address")->limit($limit)->findAll();
					$email = '';
					foreach($mail_list as $k=>$v)
					{
						$email.=$v['mail_address'].",";
					}
					if($email!='')
					$email = substr($email,0,-1);
					if($email=='')$end = true;
					break;
				case 2:
					//自定义号码
					$email = $msg_data['send_define_data'];
					$end = true;
					break;
			}
			if($email=='') {
				$this->success(L("EDM_INSERT_SUCCESS"),1);
			}
			
			require 'edm.php';
			$rs = send_mail($email,$msg_data['title'],app_conf("REPLY_ADDRESS"),app_conf("SHOP_TITLE"),$msg_data['content'],trim($_REQUEST['send_time']),$client,$token);
			if($rs == 'success') {				
				//status == 0  error() 时, 继续下页
				if($end)
				$this->success(L("EDM_INSERT_SUCCESS"),1);
				else
				$this->error(L("EDM_INSERT_SUCCESS"),1);
			} else {
				$this->success($rs,1);
			}
		}
	}
	
	public function insert_mail() {		
		//系统安全选项检测
		$this->check_safe_item();

		//开始验证
		if(intval($_REQUEST['mail_type'])==0){//普通邮件
			if($_REQUEST['title']=='') {
				$this->error(L("MAIL_TITLE_EMPTY_TIP"));
			}
			if($_REQUEST['content']=='') {
				$this->error(l("MAIL_CONTENT_EMPTY_TIP"));
			}
		} else {
			if(intval($_REQUEST['deal_id'])==0||M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->count()==0) {
				$this->error(l("DEAL_ID_ERROR"));
			}
		}
		
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->error(l("SEND_DEFINE_DATE_EMPTY_TIP"));
			}
		}
		
		$msg_data['type'] = 1;
		$msg_data['title'] = $_REQUEST['title'];
		$msg_data['content'] = $_REQUEST['content'];
		$msg_data['is_html'] = intval($_REQUEST['is_html']);
		if($_REQUEST['mail_type']==1) {
			$msg_data['title'] = M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->getField("sub_name")."团购通知邮件";
			if($msg_data['content']=='') {
				$deal_infos = M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->findAll();
				$msg_data['content'] = get_deal_mail_content($deal_infos);
			}
			$msg_data['is_html'] = 1;
		}
		
		$msg_data['send_time'] = TIME_UTC;
		$msg_data['send_status'] = 0;
		$msg_data['deal_id'] = intval($_REQUEST['deal_id']);
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
			case 2:
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}

		$msg_data['send_define_data'] = preg_replace("/[,;:]/", ",", $_REQUEST['send_define_data']);
		
		$rs = M("PromoteMsg")->add($msg_data);
		if($rs) {
			require_once APP_ROOT_PATH."system/utils/es_mail.php";
			$mail = new mail_sender();

			$mail_address = explode(",", $msg_data['send_define_data']);
			foreach ($mail_address as $mailto) {
				$mail->AddAddress(trim($mailto));
			}

			$mail->IsHTML($msg_data['is_html']);  // 设置邮件格式为 HTML
			$mail->Subject = $msg_data['title'];  // 标题
			$mail->Body = $msg_data['content'];	  // 内容	

			$result = $mail->Send();

			if ($result) {
				save_log($msg_data['content'].L("INSERT_SUCCESS"),1);
				$this->success(L("INSERT_SUCCESS"));
			}
		} else {			
			$this->error(L("INSERT_FAILED"));
		}
	}

	public function insert_sms() {	
		//系统安全选项检测
		$this->check_safe_item();

		//开始验证
		if(intval($_REQUEST['sms_type'])==0){//普通短信
			if($_REQUEST['content']=='') {
				$this->error(l("SMS_CONTENT_EMPTY_TIP"));
			}
		} else {
			if(intval($_REQUEST['deal_id'])==0||M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->count()==0) {
				$this->error(l("DEAL_ID_ERROR"));
			}
		}
		
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->error(l("SEND_DEFINE_DATE_EMPTY_TIP"));
			}
		}
		
		$msg_data['type'] = 0;
		$msg_data['content'] = $_REQUEST['content'];
		if($_REQUEST['sms_type']==1) {
			if($msg_data['content']=='')
			$msg_data['content'] = get_deal_sms_content(intval($_REQUEST['deal_id']));
		}
		
		$msg_data['send_time'] = TIME_UTC;
		$msg_data['send_status'] = 0;
		$msg_data['deal_id'] = intval($_REQUEST['deal_id']);
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}
		$msg_data['send_define_data'] = $_REQUEST['send_define_data'];

		$rs = M("PromoteMsg")->add($msg_data);

		if ($rs) {
			require_once APP_ROOT_PATH."system/utils/es_sms.php";
			$sms = new sms_sender();
			$mobile = $msg_data['send_define_data'];
			$content = $msg_data['content'];

			//XHF 2016/8/6 暂时关闭群发功能
			//$result = $sms->sendSms($mobile, $content);
			$result = array('status'=>0,'msg'=>'');
			//end

			if ($result['status']) 				
			{
				save_log($msg_data['content'].L("INSERT_SUCCESS"),1);
				$this->success(L("INSERT_SUCCESS"));
			}
			else
			{
				$this->error($result['msg']);
			}
		} else {
			$this->error(L("INSERT_FAILED"));
		}
		// 结束
	}

	/**
	 * XHF 2016/8/7 
	 * 新增发布模板群发短信
	 */
	public function insert_product_sms() {	
		//系统安全选项检测
		$this->check_safe_item();

		$sms_type = 0; //普通短信

		//发送自定义状态是否填写发送对象
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->error(l("SEND_DEFINE_DATE_EMPTY_TIP"));
			} else {
				$define_data = trim($_REQUEST['send_define_data']);
				$define_data_arr = explode(",", $define_data);

				if (preg_match("/^(1\d{10})(,(1\d{10})*)$/", $define_data)) {
					$this->error("自定义号码格式错误");
				}
				if (count($define_data_arr) > 100) {
					$this->error("号码个数超过限制");
				}
			}
		}
		if (trim($_REQUEST['create_time']) == "") {
			$this->error("时间不能为空");
		}
		if (trim($_REQUEST['money']) == "") {
			$this->error("金额不能为空");
		}
		if (trim($_REQUEST['rate']) == "") {
			$this->error("年化收益不能为空");
		}
		if (trim($_REQUEST['repay_time']) == "") {
			$this->error("期限不能为空");
		}
		
		//新标发布模板
		$tmpl_mail = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_BORDCAST_PUBLISH'");
		$tmpl_content = $tmpl_mail['content'];
		
		$notice['create_time'] = trim($_REQUEST['create_time']);
		$notice['money'] = trim($_REQUEST['money']).'万元';
		$notice['rate'] = trim($_REQUEST['rate']).'%';
		$notice['repay_time'] = trim($_REQUEST['repay_time']).'个月';
		$GLOBALS['tmpl']->assign("notice",$notice);			
		$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);

		$msg_data['type'] = 0;
		$msg_data['content'] = $msg;
		$msg_data['send_time'] = TIME_UTC;
		$msg_data['send_status'] = 0;
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}
		$msg_data['send_define_data'] = $_REQUEST['send_define_data'];

		$msg_data['template_id'] = $tmpl['id'];
		$msg_data['datas'] = serialize(array(
			'create_time' => $notice['create_time'],
			'money' => $notice['money'],
			'rate' => $notice['rate'],
			'repay_time' => $notice['repay_time']
		));

		$this->error("群发消息功能暂未开通");
		exit;

		$rs = M("PromoteMsg")->add($msg_data);

		if ($rs) {
			require_once APP_ROOT_PATH."system/utils/es_sms.php";
			$sms = new sms_sender();
			$mobile = $msg_data['send_define_data'];
			$content = $msg_data['content'];

			//XHF 2016/8/6 暂时关闭群发功能
			//$result = $sms->sendSms($mobile, $content);
			$result = array('status'=>0,'msg'=>'群发消息暂未开通');
			//end

			if ($result['status']) {
				save_log($msg_data['content'].L("INSERT_SUCCESS"),1);
				$this->success(L("INSERT_SUCCESS"));
			} else {
				$this->error($result['msg']);
			}
		} else {
			$this->error(L("INSERT_FAILED"));
		}
		// 结束
	}

	public function edit_mail() {		
		$id = intval($_REQUEST ['id']);
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$this->assign ( 'vo', $vo );
		
		//输出会员组
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		$this->display ();
	}

	public function edit_sms() {		
		$id = intval($_REQUEST ['id']);
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$this->assign ( 'vo', $vo );
		
		//输出会员组
		$group_list = M("UserGroup")->findAll();
		$this->assign("group_list",$group_list);
		
		$this->display ();
	}
	
	public function update_mail() {		
		//系统安全选项检测
		$this->check_safe_item();

		//开始验证
		if(intval($_REQUEST['mail_type'])==0){//普通邮件
			if($_REQUEST['title']=='') {
				$this->error(L("MAIL_TITLE_EMPTY_TIP"));
			}
			if($_REQUEST['content']=='') {
				$this->error(L("MAIL_CONTENT_EMPTY_TIP"));
			}
		} else {
			if(intval($_REQUEST['deal_id'])==0||M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->count()==0) {
				$this->error(l("DEAL_ID_ERROR"));
			}
		}
		
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->error(l("SEND_DEFINE_DATE_EMPTY_TIP"));
			}
		}
		
		$msg_data['type'] = 1;
		$msg_data['title'] = $_REQUEST['title'];
		$msg_data['content'] = $_REQUEST['content'];
		$msg_data['is_html'] = intval($_REQUEST['is_html']);
		if($_REQUEST['mail_type']==1) {
			$msg_data['title'] = M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->getField("sub_name")."团购通知邮件";
			if($msg_data['content']=='')
			$msg_data['content'] = get_deal_mail_content(intval($_REQUEST['deal_id']));
			$msg_data['is_html'] = 1;
		}
		
		$msg_data['send_time'] = trim($_REQUEST['send_time'])==''?TIME_UTC:to_timespan($_REQUEST['send_time']);
		$msg_data['deal_id'] = intval($_REQUEST['deal_id']);
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
			case 1:
				//订阅城市
				$msg_data['send_type_id'] = intval($_REQUEST['city_id']);
				break;
			case 2:
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}
		$msg_data['send_define_data'] = $_REQUEST['send_define_data'];
		$msg_data['id'] = intval($_REQUEST['id']);
		if(intval($_REQUEST['resend'])==1) {
			$msg_data['send_status'] = 0;
			M("PromoteMsgList")->where("msg_id=".intval($msg_data['id']))->delete();
		}
		$rs = M("PromoteMsg")->save($msg_data); 
		if($rs) {
			save_log($msg_data['title'].L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {			
			$this->error(L("UPDATE_FAILED"));
		}
		
	}
	
	public function update_sms() {		
		//系统安全选项检测
		$this->check_safe_item();

		//开始验证
		if(intval($_REQUEST['sms_type'])==0){//普通短信
		
			if($_REQUEST['content']=='') {
				$this->error(L("SMS_CONTENT_EMPTY_TIP"));
			}
		} else {
			if(intval($_REQUEST['deal_id'])==0||M("Deal")->where("is_delete=0 and id =".intval($_REQUEST['deal_id']))->count()==0) {
				$this->error(l("DEAL_ID_ERROR"));
			}
		}
		
		if(intval($_REQUEST['send_type'])==2) {
			if($_REQUEST['send_define_data']=='') {
				$this->error(l("SEND_DEFINE_DATE_EMPTY_TIP"));
			}
		}
		
		$msg_data['type'] = 0;
		$msg_data['content'] = $_REQUEST['content'];
		if($_REQUEST['sms_type']==1) {
			if($msg_data['content']=='')
			$msg_data['content'] = get_deal_sms_content(intval($_REQUEST['deal_id']));
		}
		
		$msg_data['send_time'] = trim($_REQUEST['send_time'])==''?TIME_UTC:to_timespan($_REQUEST['send_time']);
		$msg_data['deal_id'] = intval($_REQUEST['deal_id']);
		$msg_data['send_type'] = intval($_REQUEST['send_type']);
		switch($msg_data['send_type']) {
			case 0:
				//会员组
				$msg_data['send_type_id'] = intval($_REQUEST['group_id']);
				break;
			case 1:
				//订阅城市
				$msg_data['send_type_id'] = intval($_REQUEST['city_id']);
				break;
			case 2:
				//自定义号码
				$msg_data['send_type_id'] = 0;
				break;
		}
		$msg_data['send_define_data'] = $_REQUEST['send_define_data'];
		$msg_data['id'] = intval($_REQUEST['id']);
		if(intval($_REQUEST['resend'])==1) {
			$msg_data['send_status'] = 0;
			M("PromoteMsgList")->where("msg_id=".intval($msg_data['id']))->delete();
		}
		$rs = M("PromoteMsg")->save($msg_data); 

		if ($rs) {
			require_once APP_ROOT_PATH."system/utils/es_sms.php";
			$sms = new sms_sender();
			$mobile = $msg_data['send_define_data'];
			$content = $msg_data['content'];

			//XHF 2016/8/6 暂时关闭群发功能
			//$result = $sms->sendSms($mobile, $content);
			$result = array('status'=>0,'msg'=>'');
			//end

			if ($result['status']) {
				save_log($msg_data['content'].L("UPDATE_SUCCESS"),1);
				$this->success(L("UPDATE_SUCCESS"));
			} else {
				$this->error(L("UPDATE_FAILED"));
			}
		} else {
			$this->error(L("UPDATE_FAILED"));
		}
		// 结束		
	}
	
	public function foreverdelete() {
		//系统安全选项检测
		$this->check_safe_item();
	}

	// 手机验证码查询
	// XHF 2016/8/4 验证码查询时间较长
	public function verify_sms() {
		$condition = " 1=1";
		if(trim($_REQUEST['keywords'])!='') {
            $q = trim($_REQUEST['keywords']);
   			$condition .= " and mobile like '%".$q."%'";
		}

		$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."mobile_verify_code where ".$condition." order by create_time desc limit 0,60");

		$this->assign("list",$list);
		$this->assign("main_title","短信验证码");
		$this->display();
	}

	// 短信群发管理 2016/11/23
	public function sms_send_multi() {
		$this->assign("main_title","短信群发管理");
		$conditions = array (
			'valid_mobile' => 1,
			'valid_user' => 1,
			'valid_idcardpassed' => -1,
			'valid_load' => -1,
			'valid_authority' => -1,
		);

		$this->assign("conditions",$conditions);
		$this->display();
	}

	public function sms_send_multi_result() {
		$this->assign("main_title","短信群发管理");
		$user_list = array();
		$conditions = array (
			'valid_mobile' => intval($_POST['valid_mobile']),
			'valid_user' => intval($_POST['valid_user']),
			'valid_idcardpassed' => intval($_POST['valid_idcardpassed']),
			'valid_load' => intval($_POST['valid_load']),
			'valid_authority' => intval($_POST['valid_authority']),
		);

		$condition = " 1=1 and is_delete=0";
		//电话号码非空
		if ($conditions['valid_mobile'] == 1) {
			$condition .= " and mobile<>'' ";
		} else if ($conditions['valid_mobile'] == 0) {
			$condition .= " and mobile='' ";
		}

		//有效注册推荐人...
		if ($conditions['valid_user'] == 1) {
			$condition .= " and pid<>672 ";
		} else if ($conditions['valid_user'] == 0) {
			$condition .= " and pid=672 ";
		}

		//有效注册推荐人...
		if ($conditions['valid_user'] == 1) {
			$condition .= " and pid<>672 ";
		} else if ($conditions['valid_user'] == 0) {
			$condition .= " and pid=672 ";
		}

		//实名认证
		if ($conditions['valid_idcardpassed'] == 1) {
			$condition .= " and idcardpassed=1 ";
		} else if ($conditions['valid_idcardpassed'] == 0) {
			$condition .= " and idcardpassed=0 ";
		}

		//短信退订
		if (1) {
			//
		}

		//是否投资
		if ($conditions['valid_load'] == 1) {
			$condition .= " and id in (select distinct(user_id) from ".DB_PREFIX."deal_load) ";
		} else if ($conditions['valid_load'] == 0) {
			$condition .= " and id in (select distinct(user_id) from ".DB_PREFIX."deal_load) ";
		}

		//授权中心
		if ($conditions['valid_authority'] == 0) {
			//
		}

		//注册时间
		if (isset($_POST['begin_time']) && trim($_POST['begin_time']) != "") {
			$condition .= " and create_time > ".strtotime(trim($_POST['begin_time']));
		}
		if (isset($_POST['end_time']) && trim($_POST['end_time']) != "") {
			$condition .= " and create_time < ".strtotime(trim($_POST['end_time']));
		}

		$list = $GLOBALS['db']->getAll("select id,user_name,real_name,mobile from ".DB_PREFIX."user where".$condition);
		$count = count($list);
		//分组长度
		$item = 5;

		//按5组分组对齐
		for ($i=0; $i<(count($list) % $item); $i++) {
			$list[] = array('id'=>'','user_name'=>'','real_name'=>'','mobile'=>'');
		}
		//数组拆分
		$user = array(); $length = intval(count($list) / $item);
		for ($i=0; $i<$length; $i++) {
			$user[$i] = array_slice($list, $i*$item,$item);
		}

		$this->assign("list", $user);
		$this->assign("count", $count);
		$this->assign("conditions", $conditions);
		$this->display("sms_send_multi");
	}
}
?>