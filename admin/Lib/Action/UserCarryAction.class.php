<?php

/**
 * auto_check()
 * 通联返回状态"余额不足",稍后提交可正常通过
 * "稍后"提交状态不做提现失败状态更新
 * 在异常处理页面添加返回到待审核状态功能
 * Admin 2016-7-25
 */

class UserCarryAction extends CommonAction{

    //提现申请列表
	public function index(){
		$this->getlist(trim($_REQUEST['status']));
	}
	public function wait(){
		$this->assign("ori_action","wait");
		$this->getlist("0");
	}
	public function success(){
		$this->assign("ori_action","success");
		$this->getlist("1");
	}
	public function failed(){
		$this->assign("ori_action","failed");
		$this->getlist("2");
	}
	public function reback(){
		$this->assign("ori_action","reback");
		$this->getlist("4");
	}
	public function waitpay(){
		$this->assign("ori_action","waitpay");
		$this->getlist("3");
	}
	public function waitquery(){
		$this->assign("ori_action","waitquery");
		$this->getlist("5");
	}
	//0待审核，1已付款，2未通过，3待付款
	public function user_search($user_name) {
		$str = "user_name like '%{$user_name}%'";
		$str .= " or real_name like '%{$user_name}%'";
		$str .= " or mobile like '%{$user_name}%'";
		$str .= " or phone like '%{$user_name}%'";
		$str .= " or alipay_id like '%{$user_name}%'";
		$str .= " or taobao_id like '%{$user_name}%'";
		$str .= " or qq_id like '%{$user_name}%'";
		return "(".$str.")";
	}

	private function getlist($status=''){
		//自动处理待支付订单
		$this->auto_check();

		if(trim($_REQUEST['user_name'])!='')
		{
			//支持模糊搜索
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['user_id'] = array("in", $user_list);
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

			// 获取时区
			$timezone = intval(app_conf('TIME_ZONE'));

			if ($start_time != "" && $end_time != ""){
				$condition['create_date'] = array("between", array($start_time,$end_time));
			} else if ($start_time != "" && $end_time == "") {
				$condition['create_date'] = array("egt", $start_time);
			} else if ($start_time == "" && $end_time != "") {
				$condition['create_date'] = array("elt", $end_time);
			}
		}

		if($status!='') {
			if ($status == 3 || $status == 5) {
				$condition['status'] = array("in",array(3,5));
			} else {
				$condition['status'] = array("eq",$status);
			}
		}
		
		$this->assign("default_map",$condition);
		$map = $this->get("default_map");

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ("UserCarry");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("index");
	}

	//提现申请列表
	public function edit(){
		$id = intval($_REQUEST ['id']);
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$vo['region_lv1_name'] = M("DeliveryRegion")->where("id=".$vo['region_lv1'])->getField("name");
		$vo['region_lv2_name'] = M("DeliveryRegion")->where("id=".$vo['region_lv2'])->getField("name");
		$vo['region_lv3_name'] = M("DeliveryRegion")->where("id=".$vo['region_lv3'])->getField("name");
		$vo['region_lv4_name'] = M("DeliveryRegion")->where("id=".$vo['region_lv4'])->getField("name");
		$vo['bank_name'] =  M("bank")->where("id=".$vo['bank_id'])->getField("name");
		
		$this->assign("vo",$vo);
		$this->display ();
	}

    // Admin 2016-7-13 自动处理待查询状态的订单
    // 5小时以内未成功处理的订单
    // 5小时以内的时间设定需为有效
    // 更新提现记录表的条件

	//自动处理待支付订单
	public function auto_check() {
		//自动处理待支付订单申请(5小时以内)
		$carry_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_carry where status in (3,5) and update_time>'".(TIME_UTC-5*3600)."'");
		if (!$carry_list || !count($carry_list)) { return; }

		$carry_info = $GLOBALS['db']->getRow("select id,class_name from ".DB_PREFIX."carry where is_effect=1");
		$carry_class = $carry_info['class_name']."_carry";
		require_once APP_ROOT_PATH.'system/carry/'.$carry_class.'.php';
        $carry = new $carry_class();

		for ($i=0; $i<count($carry_list); $i++) {
			$valid = true;
			$vo = $carry_list[$i];

            $res = $carry->query_ret($vo['id']);
            if (!isset($res['info']) || !isset($res['info']['AIPG'])) { continue; }
			if (!isset($res['info']['AIPG']['QTRANSRSP']['QTDETAIL'])) { continue; }

			$qtdetail = $res['info']['AIPG']['QTRANSRSP']['QTDETAIL'];
			$fintime = strtotime($qtdetail['FINTIME']);
			$ret_code = $qtdetail['RET_CODE'];
			$err_msg = $qtdetail['ERR_MSG'];

			$data['update_time'] = $fintime;
			$data['msg'] = $err_msg;

			if ($ret_code == '0000' || $ret_code == '4000') {
				//交易成功
				$data['status'] = 1;
				$data['msg'] = '提现成功(查询处理)';
			} else if ($ret_code == '2000' || $ret_code == '2001' || $ret_code == '2003' || $ret_code == '2005' || $ret_code == '2007' || $ret_code == '2008' || $ret_code == '0003' || $ret_code == '0014') {
				//交易中间状态,需继续做交易结果查询来确认交易的最终状态
				$valid = false;
			} else {
				// Admin 2016-7-25
				// 通联返回状态"余额不足",稍后提交可正常通过
				// "稍后"提交状态不做提现失败状态更新
				if (!preg_match('/余额不足/',$data['msg'])) {
					//交易失败
					$data['status'] = 2;
				}
			}

			if ($valid == false) { continue; }

            $condition = " 1=1 and id=".$vo['id'];

			// 更新数据
			$list=M(MODULE_NAME)->where($condition)->save ($data);

			if ($list > 0) {
				//成功提示
				$user_id = $vo['user_id'];
				$user_info = M("User")->where("id=".$user_id)->find();
				require_once APP_ROOT_PATH."/system/libs/user.php";
				if($data['status']==1){
					//提现
					modify_account(array("lock_money"=>-$vo['money']),$vo['user_id'],"提现成功",8);
					modify_account(array("lock_money"=>-$vo['fee']),$vo['user_id'],"提现成功",9);
					//$content = "您于".to_date($vo['create_time'],"Y年m月d日 H:i:s")."提交的".format_price($vo['money'])."提现申请汇款成功，请查看您的资金记录。";
					$group_arr = array(0,$user_id);
					sort($group_arr);
					$group_arr[] =  6;
					
					$sh_notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i:s");		//提现时间
					$sh_notice['money'] = format_price($vo['money']);  						//提现金额
					$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
					$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_WITHDRAWS_SUCCESS'",false);
					$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
						
					$msg_data['content'] = $sh_content;
					$msg_data['to_user_id'] = $user_id;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['type'] = 0;
					$msg_data['group_key'] = implode("_",$group_arr);
					$msg_data['is_notice'] = 6;
					
					$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
					$id = $GLOBALS['db']->insert_id();
					$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
					
					//短信通知
					if(app_conf("SMS_ON")==1)
					{
						//尊敬的用户{$notice.user_name},您的{$notice.carry_money}元提现已成功转入您的银行账户,请注意查收,感谢您的关注和支持.
						$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_CARYY_SUCCESS_SMS'");				
						$tmpl_content = $tmpl['content'];
										
						$notice['user_name'] = $user_info["user_name"];
						$notice['carry_money'] = $vo['money'];
						$notice['site_name'] = app_conf("SHOP_TITLE");
						
						$GLOBALS['tmpl']->assign("notice",$notice);
						
						$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
						
						$msg_data['dest'] = $user_info['mobile'];
						$msg_data['send_type'] = 0;
						$msg_data['title'] = "提现成功短信提醒";
						$msg_data['content'] = addslashes($msg);
						$msg_data['send_time'] = 0;
						$msg_data['is_send'] = 0;
						$msg_data['create_time'] = TIME_UTC;
						$msg_data['user_id'] = $user_info['id'];
						$msg_data['is_html'] = $tmpl['is_html'];

						//Admin 2016/8/6 
						//模板ID
						$msg_data['template_id'] = $tmpl['id'];
						//json数据
						$msg_data['datas'] = serialize(array(
							'user_name' => $notice['user_name'],
							'carry_money' => $notice['carry_money']
						));
						//end

						$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入				
					}
				} elseif($data['status']==2){
					//驳回
					modify_account(array("money"=>$vo['money'],"lock_money"=>-$vo['money']),$vo['user_id'],"提现失败",8);
					modify_account(array("money"=>$vo['fee'],"lock_money"=>-$vo['fee']),$vo['user_id'],"提现失败",9);
					//$content = "您于".to_date($vo['create_time'],"Y年m月d日 H:i:s")."提交的".format_price($vo['money'])."提现申请被我们驳回，驳回原因\"".$data['msg']."\"";
					
					$group_arr = array(0,$user_id);
					sort($group_arr);
					$group_arr[] =  7;
					
					$sh_notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i");		// 提现时间		
					$sh_notice['money'] = format_price($vo['money']);  						// 提现金额
					$sh_notice['msg'] = $data['msg'];  							// 驳回原因
					$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
					$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_WITHDRAWS_FAILED'",false);
					$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
					
					$msg_data['content'] = $sh_content;
					$msg_data['to_user_id'] = $user_id;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['type'] = 0;
					$msg_data['group_key'] = implode("_",$group_arr);
					$msg_data['is_notice'] = 7;
					
					$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
					$id = $GLOBALS['db']->insert_id();
					$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
					
					
					//短信通知
					if(app_conf("SMS_ON")==1)
					{
						//尊敬的用户{$notice.user_name},您于{$notice.time}提交的{$notice.carry_money}提现申请提现申请被我们驳回,驳回原因{$notice.msg}.
						$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_CARYY_FAILED_SMS'");				
						$tmpl_content = $tmpl['content'];
										
						$notice['user_name'] = $user_info["user_name"];
						$notice['carry_money'] = $vo['money'];
						$notice['site_name'] = app_conf("SHOP_TITLE");
						$notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i");
						$notice['msg'] = $data['msg'];  	
						
						$GLOBALS['tmpl']->assign("notice",$notice);
						
						$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
						
						$msg_data['dest'] = $user_info['mobile'];
						$msg_data['send_type'] = 0;
						$msg_data['title'] = "提现失败短信提醒";
						$msg_data['content'] = addslashes($msg);;
						$msg_data['send_time'] = 0;
						$msg_data['is_send'] = 0;
						$msg_data['create_time'] = TIME_UTC;
						$msg_data['user_id'] = $user_info['id'];
						$msg_data['is_html'] = $tmpl['is_html'];

						//Admin 2016/8/6 
						//模板ID
						$msg_data['template_id'] = $tmpl['id'];
						//json数据
						$msg_data['datas'] = serialize(array(
							'user_name' => $notice['user_name'],
							'time' => $notice['time'],
							'carry_money' => $notice['carry_money'],
							'msg' => $notice['msg']
						));
						//end

						$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入				
					}
				}
				save_log("编号为".$data['id']."的提现申请".L("UPDATE_SUCCESS")."[自动更新]",1);
			}
		}
	}

	// 异常查询
	// Admin 2016/7/25
	// "余额不足"异常状态添加状态还原功能用以重新提交
	public function unusual() {
		$notice_sn = ""; $result = ""; $valid = 0;

		if (isset($_REQUEST['notice_sn'])) {
			$notice_sn = trim($_REQUEST['notice_sn']);
		}

		// "余额不足"异常重新提交处理代码
		// Admin 2016/7/25
		if (isset($_REQUEST['ajax']) && isset($_REQUEST['confirm']) && $notice_sn != "") {
			$data = array('status'=>0, 'msg'=>'');

			$pass = trim($_REQUEST['pass']);
			if (md5(md5($pass)) != "18d2a098cff1fa9119fec964953146c7") {
				$data['msg'] = "约定密码输入错误";
				ajax_return($data);
			}

			$result = $GLOBALS['db']->query("update ".DB_PREFIX."user_carry set status=0,pingzheng=0,msg='异常,重新提交' where req_sn = '".$notice_sn."' and status=2");
			if ($result) {
				$data['status'] = 1;
				$data['msg'] = "状态修改成功";
			} else {
				$data['msg'] = "状态修改失败";
			}
			ajax_return($data);
		}

		if ($notice_sn != "") {
            $query_info = $GLOBALS['db']->getRow("select id,user_id,req_sn,msg from ".DB_PREFIX."user_carry where req_sn='".$notice_sn."'");
            $user_info = $GLOBALS['db']->getRow("select id,user_name,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile from ".DB_PREFIX."user where id=".$query_info['user_id']);

            $carry_info = $GLOBALS['db']->getRow("select id,class_name from ".DB_PREFIX."carry where is_effect=1");
            $carry_class = $carry_info['class_name']."_carry";
			require_once APP_ROOT_PATH.'system/carry/'.$carry_class.'.php';

            $carry = new $carry_class();
            $res = $carry->query_ret($query_info['id']);
            $req_sn = $query_info['req_sn'];

            $str = "查询流水号: ".$query_info['req_sn']."<br/>";
            $str .= "申请用户: ".$user_info['user_name']." [".$user_info['real_name'].", ".$user_info['mobile']."]<br/>";

			if (isset($res['info']) && isset($res['info']['AIPG'])) {
				$info = $res['info']['AIPG']['INFO'];
				$str .= "交易代码: ".$info['TRX_CODE']."<br/>";
				$str .= "返回代码: ".$info['RET_CODE']."<br/>";
				$str .= "返回结果: ".$info['ERR_MSG']."<br/>";

				if (isset($res['info']['AIPG']['QTRANSRSP']['QTDETAIL'])) {
					$qtdetail = $res['info']['AIPG']['QTRANSRSP']['QTDETAIL'];
					$str .= "交易批次号: ".$qtdetail['BATCHID']."<br/>";
					$str .= "记录序号: ".$qtdetail['BATCHID']."<br/>";
					$str .= "交易方向: ".($qtdetail['TRXDIR']==0? "代付":"代收")."<br/>";
					$str .= "清算日期: ".date('Y年m月d日',strtotime($qtdetail['SETTDAY']))."<br/>";
					$str .= "提交时间: ".date('Y年m月d日 H:i:s',strtotime($qtdetail['SUBMITTIME']))."<br/>";
					$str .= "完成时间: ".date('Y年m月d日 H:i:s',strtotime($qtdetail['FINTIME']))."<br/>";
					$str .= "账号: ".$qtdetail['ACCOUNT_NO']."<br/>";
					$str .= "账号名: ".$qtdetail['ACCOUNT_NAME']."<br/>";
					if ($qtdetail['RET_CODE'] == '0000') {
						$str .= "<em style='color:blue'>金额: ".format_price($qtdetail['AMOUNT']/100)."</em><br/>";
						$str .= "<em style='color:blue'>返回码: ".$qtdetail['RET_CODE']."</em><br/>";
						$str .= "<em style='color:blue'>返回结果: ".$qtdetail['ERR_MSG']."</em><br/>";
					} else {
						$str .= "<em style='color:red'>金额: ".format_price($qtdetail['AMOUNT']/100)."</em><br/>";
						$str .= "<em style='color:red'>返回码: ".$qtdetail['RET_CODE']."</em><br/>";
						$str .= "<em style='color:red'>返回结果: ".$qtdetail['ERR_MSG']."</em><br/>";
					}
				}
			} else if ($res['info'] != "") {
				$str .= $res['info']."<br/>";
			}
			if ($res['msg'] != "") {
				$str .= $res['msg']."<br/>";
			}

			$str .= "<br/>";
			$str .= "A:成功状态，如：0000、4000<br/>";
			$str .= "B:中间状态：如：2000、2001、2003、2005、2007、2008、0003、0014<br/>";
			$str .= "C:失败状态: 除以上状态以外的返回码都是失败状态<br/>";

			$result['status'] = 1;
			$result['msg'] = $str;
			if (preg_match('/余额不足/',$query_info['msg'])) {
				$valid = 1;
			}
		}

		$this->assign("main_title", "提现处理异常查询");
		$this->assign("act", "unusual");
		$this->assign("valid", $valid);
		$this->assign("notice_sn", $notice_sn);
		$this->assign("result", $result['msg']);
		$this->display();
	}

	public function update(){
		$data = M(MODULE_NAME)->create ();

		$password = $_REQUEST['password'];
		if (isset($data['password'])) { unset($data['password']); }
		$carry = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."carry where is_effect=1");

		if (!$carry) {
			$this->error("未找到有效的接口"); exit;
		}

		if (md5(md5($password)) != $carry['reserve']) {
			$log_info = "提现审核密码输入错误";
			save_log($log_info.L("UPDATE_FAILED"),0);
			$this->error("密码输入错误"); exit;
		}

		$ori_action = $_REQUEST['ori_action'];
		if (isset($data['ori_action'])) { unset($data['ori_action']); }

		switch($data['status']){
			case 0:
				$action = 'wait';
				break;
			case 1:
				$action = 'success';
				break;
			case 2:
				$action = 'failed';
				break;
			case 3:
				$action = 'waitpay';
				break;
			case 4:
				$action = 'reback';
				break;
			case 5:
				$action = 'waitquery';
				break;
			default :
				$action = 'index';
				break;
		}

		// 5已付款待查询 3待付款 2未通过 1已付款
	    if($data['status']==3){
	    	$condition['status'] = array("eq","0");//只有待审核状态才可以更改
	    }
	    elseif($data['status']==2){
	    	$condition['status'] = array("in","0,3");//只有  待审核和待付款  状态才可以更改
	    }
	    elseif($data['status']==1){
	    	$condition['status'] = array("in","3,5");//只有  待付款和待查询  状态才可以更改
	    }
	    $condition['id'] = $data['id'];

		// 待付款状态加载通联支付
		if ($data['status'] == 3) { 
			$user_carry = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_carry where id = ".$_REQUEST['id']);

			if (!$user_carry) {
				$this->error("无效的订单请求");exit;
			} else if ($user_carry['pingzheng'] == '1') {
				$this->error("订单已锁定,不能重复提交");exit;
			}	
			
			// 判断是否余额不足
			$user_money = $GLOBALS['db']->getOne("select AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money from ".DB_PREFIX."user where id = ".$user_carry['user_id']);
			if ($user_money < 0) {
				$this->error(format_price($user_money)." 余额不足");exit;
			}

			// 加载通联支付处理过程			
            $carry_info = $GLOBALS['db']->getRow("select id,class_name from ".DB_PREFIX."carry where is_effect=1");
            $carry_class = $carry_info['class_name']."_carry";
			require_once APP_ROOT_PATH.'system/carry/'.$carry_class.'.php';

			// 提现处理加锁
			$GLOBALS['db']->query("update ".DB_PREFIX."user_carry set pingzheng='1' where id = ".$_REQUEST['id']);

            $carry = new $carry_class();
			// 交通银行与民生银行仅支持对私批量代付
			if ($user_carry['bank_id'] == 9) {
				$res = $carry->batch_tranx($_REQUEST['id']);
			} else {
				$res = $carry->single_cash($_REQUEST['id']);
			}

			if ($res['status'] == 1 && $res['isok'] == 1) {
				//提现成功
				$data['status'] = 1;
				$data['msg'] = '提现成功';
				$data['req_sn'] = $res['info'];
			} else if ($res['status'] == 1 && $res['isok'] == 2) {
				//付款待查询
				$data['status'] = 5;
				$data['msg'] = $res['msg'];
				$data['req_sn'] = $res['info'];
			} else if ($res['status'] == 1 && $res['isok'] == 3) {
				//结果待查询以及支付失败
				$data['msg'] = '其他状态:'.$res['msg'];
				$data['req_sn'] = $res['info'];
			}
		}
		else if ($data['status'] == 1) {
			$data['msg'] = '提现成功';
		}

		// 添加操作人员ID
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$data['input_user_id'] = $adm_session['adm_id'];

		// 更新数据
		$list=M(MODULE_NAME)->where($condition)->save ($data);

		if ($list > 0) {
			$sdata['update_time'] = TIME_UTC;
			$sdata['id'] = $data['id'];
			if(trim($_REQUEST['pingzheng'])!=''){
				$sdata['pingzheng'] = trim($_REQUEST['pingzheng']);
			}
			M(MODULE_NAME)->save ($sdata);
			//成功提示
			$vo = M(MODULE_NAME)->where("id=".$data['id'])->find();
			$user_id = $vo['user_id'];
			$user_info = M("User")->where("id=".$user_id)->find();
			require_once APP_ROOT_PATH."/system/libs/user.php";
			if($data['status']==1){
				//提现
				modify_account(array("lock_money"=>-$vo['money']),$vo['user_id'],"提现成功",8);
				modify_account(array("lock_money"=>-$vo['fee']),$vo['user_id'],"提现成功",9);
				//$content = "您于".to_date($vo['create_time'],"Y年m月d日 H:i:s")."提交的".format_price($vo['money'])."提现申请汇款成功，请查看您的资金记录。";
				$group_arr = array(0,$user_id);
				sort($group_arr);
				$group_arr[] =  6;
				
				$sh_notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i:s");		//提现时间
				$sh_notice['money'] = format_price($vo['money']);  						//提现金额
				$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
				$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_WITHDRAWS_SUCCESS'",false);
				$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
					
				$msg_data['content'] = $sh_content;
				$msg_data['to_user_id'] = $user_id;
				$msg_data['create_time'] = TIME_UTC;
				$msg_data['type'] = 0;
				$msg_data['group_key'] = implode("_",$group_arr);
				$msg_data['is_notice'] = 6;
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
				$id = $GLOBALS['db']->insert_id();
				$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
				
				//短信通知
				if(app_conf("SMS_ON")==1)
				{
					//尊敬的用户{$notice.user_name},您的{$notice.carry_money}元提现已成功转入您的银行账户,请注意查收,感谢您的关注和支持.
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_CARYY_SUCCESS_SMS'");				
					$tmpl_content = $tmpl['content'];
									
					$notice['user_name'] = $user_info["user_name"];
					$notice['carry_money'] = $vo['money'];
					$notice['site_name'] = app_conf("SHOP_TITLE");
					
					$GLOBALS['tmpl']->assign("notice",$notice);
					
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					
					$msg_data['dest'] = $user_info['mobile'];
					$msg_data['send_type'] = 0;
					$msg_data['title'] = "提现成功短信提醒";
					$msg_data['content'] = addslashes($msg);;
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];

					//Admin 2016/8/6 
					//模板ID
					$msg_data['template_id'] = $tmpl['id'];
					//json数据
					$msg_data['datas'] = serialize(array(
						'user_name' => $notice['user_name'],
						'carry_money' => $notice['carry_money']
					));
					//end

					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入				
				}
			}
			elseif($data['status']==2){
				//驳回
				modify_account(array("money"=>$vo['money'],"lock_money"=>-$vo['money']),$vo['user_id'],"提现失败",8);
				modify_account(array("money"=>$vo['fee'],"lock_money"=>-$vo['fee']),$vo['user_id'],"提现失败",9);
				//$content = "您于".to_date($vo['create_time'],"Y年m月d日 H:i:s")."提交的".format_price($vo['money'])."提现申请被我们驳回，驳回原因\"".$data['msg']."\"";
				
				$group_arr = array(0,$user_id);
				sort($group_arr);
				$group_arr[] =  7;
				
				$sh_notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i");		// 提现时间		
				$sh_notice['money'] = format_price($vo['money']);  						// 提现金额
				$sh_notice['msg'] = $data['msg'];  							// 驳回原因
				$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
				$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_WITHDRAWS_FAILED'",false);
				$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
				
				$msg_data['content'] = $sh_content;
				$msg_data['to_user_id'] = $user_id;
				$msg_data['create_time'] = TIME_UTC;
				$msg_data['type'] = 0;
				$msg_data['group_key'] = implode("_",$group_arr);
				$msg_data['is_notice'] = 7;
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
				$id = $GLOBALS['db']->insert_id();
				$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
				
				
				//短信通知
				if(app_conf("SMS_ON")==1)
				{
					//尊敬的用户{$notice.user_name},您于{$notice.time}提交的{$notice.carry_money}提现申请提现申请被我们驳回,驳回原因{$notice.msg}.
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_CARYY_FAILED_SMS'");				
					$tmpl_content = $tmpl['content'];
									
					$notice['user_name'] = $user_info["user_name"];
					$notice['carry_money'] = $vo['money'];
					$notice['site_name'] = app_conf("SHOP_TITLE");
					$notice['time'] = to_date($vo['create_time'],"Y年m月d日 H:i");
					$notice['msg'] = $data['msg'];  	
					
					
					$GLOBALS['tmpl']->assign("notice",$notice);
					
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					
					$msg_data['dest'] = $user_info['mobile'];
					$msg_data['send_type'] = 0;
					$msg_data['title'] = "提现失败短信提醒";
					$msg_data['content'] = addslashes($msg);;
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];

					//Admin 2016/8/6 
					//模板ID
					$msg_data['template_id'] = $tmpl['id'];
					//json数据
					$msg_data['datas'] = serialize(array(
						'user_name' => $notice['user_name'],
						'time' => $notice['time'],
						'carry_money' => $notice['carry_money'],
						'msg' => $notice['msg']
					));
					//end

					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入				
				}
			}
			save_log("编号为".$data['id']."的提现申请".L("UPDATE_SUCCESS"),1);
			//开始验证有效性
			$this->assign("jumpUrl",u(MODULE_NAME."/wait"));
			parent::success(L("UPDATE_SUCCESS"));
		}else {
			//错误提示
			$DBerr = M()->getDbError();
			save_log("编号为".$data['id']."的提现申请".L("UPDATE_FAILED").$DBerr,0);
			$this->error(L("UPDATE_FAILED").$DBerr,0);
		}
	}
	
	public function config(){
		$list = M()->query("SELECT * FROM ".DB_PREFIX."user_carry_config WHERE vip_id='0' ORDER BY id ASC");
		foreach($list as $k=>$v) {
			$list[$k]['user_type'] = intval($v['user_type']);
			$list[$k]['user_group'] = intval($v['user_group']);
			$list[$k]['user_level'] = intval($v['user_level']);
		}

		//用户类型
		$user_type_list = array(array('id'=>0, 'name'=>'个人用户'), array('id'=>1, 'name'=>'企业用户'), array('id'=>2, 'name'=>'担保机构'), array('id'=>3, 'name'=>'授权服务中心'));
		//用户组别
		$user_group_list = $GLOBALS['db']->getAll("select id,name from ".DB_PREFIX."user_group");
		//用户等级
		$user_level_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_level");

		$this->assign("list",$list);
		$this->assign("user_type_list",$user_type_list);
		$this->assign("user_group_list",$user_group_list);
		$this->assign("user_level_list",$user_level_list);
		$this->display();
	}
	
	public function saveconfig(){
		$config = $_POST['config'];
		$has_ids = null;
		foreach($config['id'] as $k=>$v){
			if(intval($v) > 0){
				$has_ids[] = $v;
			}
		}
		M()->query("DELETE FROM ".DB_PREFIX."user_carry_config WHERE id not in (".implode(",",$has_ids).")");

		foreach($config['id'] as $k=>$v){
			if(intval($v) > 0){
				$config_data =array();
				$config_data['id'] = $v;
				$config_data['name'] = trim($config['name'][$k]);
				$config_data['min_price'] = floatval($config['min_price'][$k]);
				$config_data['max_price'] = floatval($config['max_price'][$k]);
				$config_data['fee'] = floatval($config['fee'][$k]);
				$config_data['vip_id'] = 0;
				$config_data['fee_type'] = intval($config['fee_type'][$k]);
				$config_data['user_type'] = intval($config['user_type'][$k]);
				$config_data['user_group'] = intval($config['user_group'][$k]);
				$config_data['user_level'] = intval($config['user_level'][$k]);
				M("UserCarryConfig")->save($config_data);
			}
		}

		$aconfig = $_POST['aconfig'];
		foreach($aconfig['name'] as $k=>$v){
			if(trim($v)!=""){
				$config_data =array();
				$config_data['name'] = trim($v);
				$config_data['min_price'] = floatval($aconfig['min_price'][$k]);
				$config_data['max_price'] = floatval($aconfig['max_price'][$k]);
				$config_data['fee'] = floatval($aconfig['fee'][$k]);
				$config_data['fee_type'] = intval($aconfig['fee_type'][$k]);
				$config_data['user_type'] = intval($config['user_type'][$k]);
				$config_data['user_group'] = intval($config['user_group'][$k]);
				$config_data['user_level'] = intval($config['user_level'][$k]);
				M("UserCarryConfig")->add($config_data);
			}
		}
		rm_auto_cache("user_carry_config");
		parent::success(L("UPDATE_SUCCESS"));
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
	
		if(trim($_REQUEST['status_type'])=="index"){
			if(trim($_REQUEST['status'])!='')
			{
				$condition['status'] = intval($_REQUEST['status']);
			}
		}
		else{
			$status_type = trim($_REQUEST['status_type']);
			switch($status_type){
				case "wait":
					$condition['status'] = 0;
					break;
				case "waitpay":
					$condition['status'] = 3;
					break;
				case "success":
					$condition['status'] = 1;
					break;
				case "failed":
					$condition['status'] = 2;
					break;
				case "reback":
					$condition['status'] = 4;
					break;
			}
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");
	
		$list = M("UserCarry")->where($map)
			->field("id,user_id,real_name,bank_id,bankzone,bankcard,money,fee,create_time,update_time,status,`desc`,region_lv1,region_lv2,region_lv3,region_lv4")
			->limit($limit)->findAll();
		
		if ($list && count($list)) {
			for ($i=0; $i<count($list); $i++) {
				$list[$i]['lv1_name'] = M("Region_conf")->where("id=".$list[$i]['region_lv1'])->getField("name");
				$list[$i]['lv2_name'] = M("Region_conf")->where("id=".$list[$i]['region_lv2'])->getField("name");
				$list[$i]['lv3_name'] = M("Region_conf")->where("id=".$list[$i]['region_lv3'])->getField("name");
				$list[$i]['lv4_name'] = M("Region_conf")->where("id=".$list[$i]['region_lv4'])->getField("name");
				$list[$i]['bank_name'] = M("bank")->where("id=".$list[$i]['bank_id'])->getField("name");

				$user = M("User")->where("id=".$list[$i]['user_id'])
					->Field("AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,user_name")
					->find();
				$list[$i]['user_name'] = $user['user_name'];
				$list[$i]['mobile'] = $user['mobile'];
				$list[$i]['remain_money'] = $user['money'];
			}
		}

		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$carry_value = array('id'=>'""','bank_name'=>'""','region'=>'""','regions'=>'""','bankzone'=>'""','user_name'=>'""','real_name'=>'""','bankcard'=>'""','money'=>'""','fee'=>'""','mobile'=>'""','create_time'=>'""','update_time'=>'""','remain_money'=>'""','desc'=>'""');
			if($page == 1){
				$content = iconv("utf-8","gbk","编号,银行,地区（省）,地区（市/区）,支行名称,会员ID,开户名,卡号,金额,手续费,电话号码,申请时间,处理时间,账户余额,操作备注");
				$content = $content . "\n";
			}
			for ($i=count($list)-1; $i>=0; $i--) 
			{
				$k = $i; $v = $list[$i];
				$carry_value = array();
				$carry_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$carry_value['bank_name'] = iconv('utf-8','gbk','"' . $v['bank_name'] . '"');
				$carry_value['region'] = iconv('utf-8','gbk','" '.$v['lv1_name'] .' '.$v['lv2_name'] .' "');
				$carry_value['regions'] = iconv('utf-8','gbk','"  '.$v['lv3_name'] .' '.$v['lv4_name'] . '"');
				$carry_value['bankzone'] = iconv('utf-8','gbk','"' . $v['bankzone'] . '"');
				$carry_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$carry_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$carry_value['bankcard'] = iconv('utf-8','gbk','"' . $v['bankcard'] . '"');
				$carry_value['money'] = iconv('utf-8','gbk','"' .  number_format($v['money'],2) . '"');
				$carry_value['fee'] = iconv('utf-8','gbk','"' .  number_format($v['fee'],2) . '"');
				$carry_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$carry_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				$carry_value['update_time'] = iconv('utf-8','gbk','"' . to_date($v['update_time']) . '"');
				$carry_value['remain_money'] = iconv('utf-8','gbk','"' .  number_format($v['remain_money'],2) . '"');
				$carry_value['desc'] = iconv('utf-8','gbk','"' . $v['desc'] . '"');
			
				$content .= implode(",", $carry_value) . "\n";
			}	
					
			header("Content-Disposition: attachment; filename=carry_list.csv");
	    	echo $content;  
		}
		else
		{
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}
	
	public function delete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				
				
				$list = M(MODULE_NAME)->where ( $condition )->delete();	
		
				if ($list!==false) {					
					save_log(l("FOREVER_DELETE_SUCCESS"),1);
					parent::success (l("FOREVER_DELETE_SUCCESS"),$ajax);
				} else {
					save_log(l("FOREVER_DELETE_FAILED"),0);
					$this->error (l("FOREVER_DELETE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}	
}
?>