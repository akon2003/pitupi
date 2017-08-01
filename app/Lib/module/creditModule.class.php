<?php
defined('USER_ONLINE_CERTIFICAT')||define('USER_ONLINE_CERTIFICAT', '用户在线实名认证');

class creditModule extends SiteBaseModule {
	private $is_ajax ; 
	public function __construct(){
		$this->is_ajax = intval($_REQUEST['is_ajax']);
		$this->from = strim($_REQUEST['from']);
		if(!$GLOBALS['user_info']){
			set_gopreview();
			showErr($GLOBALS['lang']['PLEASE_LOGIN_FIRST'],$this->is_ajax,url("index","user#login"));
		}
	}
    function index() {
    	$type=strim($_REQUEST['type']);
    	$credit_type= load_auto_cache("credit_type");
    	if(!isset($credit_type['list'][$type])){
    		showErr('认证类型不存在',$this->is_ajax);
    	}
    	$credit_type['list'][$type]['description_format'] = $GLOBALS['tmpl']->fetch("str:".$credit_type['list'][$type]['description']);
    	$GLOBALS['tmpl']->assign("credit",$credit_type['list'][$type]);
    	
    	if($type=="credit_contact" || $type=="credit_residence"){
    		//地区列表
				$work =  $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."user_work where user_id =".$GLOBALS['user_info']['id']);
				$GLOBALS['tmpl']->assign("work",$work);
				
				$region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2");  //二级地址
				foreach($region_lv2 as $k=>$v)
				{
					if($v['id'] == intval($work['province_id']))
					{
						$region_lv2[$k]['selected'] = 1;
						break;
					}
				}
				$GLOBALS['tmpl']->assign("region_lv2",$region_lv2);
				
				$region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".intval($work['province_id']));  //三级地址
				foreach($region_lv3 as $k=>$v)
				{
					if($v['id'] == intval($work['city_id']))
					{
						$region_lv3[$k]['selected'] = 1;
						break;
					}
				}
				$GLOBALS['tmpl']->assign("region_lv3",$region_lv3);
    	}
    	
    	$GLOBALS['tmpl']->assign("is_ajax",$this->is_ajax);
    	$user_type = $GLOBALS['db']->getOne("SELECT user_type FROM ".DB_PREFIX."user WHERE id=".$GLOBALS['user_info']['id']);
    	$GLOBALS['tmpl']->assign('user_type',$user_type);

		if($this->is_ajax==1 && $this->from =="debit")
    		showSuccess($GLOBALS['tmpl']->fetch("debit/debit_credit_box.html"),$this->is_ajax);
    	elseif($this->is_ajax==1)
    		showSuccess($GLOBALS['tmpl']->fetch("inc/credit/credit_box.html"),$this->is_ajax);
    	else
    		$GLOBALS['tmpl']->display("inc/credit/credit_box.html");
    }
    
    function credit_save(){
    	$type=strim($_REQUEST['type']);
    	$credit_type= load_auto_cache("credit_type");
    	if(!isset($credit_type['list'][$type])){
    		showErr('认证类型不存在',$this->is_ajax);
    	}
    	
    	$field_array = array(
			"credit_identificationscanning"=>"idcardpassed",
			"credit_contact"=>"workpassed",
			"credit_credit"=>"creditpassed",
			"credit_incomeduty"=>"incomepassed",
			"credit_house"=>"housepassed",
			"credit_car"=>"carpassed",
			"credit_marriage"=>"marrypassed",
			"credit_titles"=>"skillpassed",
			"credit_videoauth"=>"videopassed",
			"credit_mobilereceipt"=>"mobiletruepassed",
			"credit_residence"=>"residencepassed",
			"credit_seal"=>"sealpassed",
		);
		$u_c_data[$field_array[$type]] = 0;
    	//身份认证
    	if($type == "credit_identificationscanning"){
    		$u_c_data['real_name_encrypt'] = "AES_ENCRYPT('".strim($_REQUEST['real_name'])."','".AES_DECRYPT_KEY."')";
    		$u_c_data['idno_encrypt'] = "AES_ENCRYPT('".strim($_REQUEST['idno'])."','".AES_DECRYPT_KEY."')";
    		if(getIDCardInfo(strim($_REQUEST['idno']))==0){
    			showErr("提交失败,身份证号码错误！",$this->is_ajax);
    		}
    		if(get_user_info("count(*)","idno_encrypt = ".$u_c_data['idno_encrypt']." and id <> ".intval($GLOBALS['user_info']['id']),"ONE")>0){
    			showErr("提交失败,身份证号码已使用！",$this->is_ajax);
    		}

			$verify = idCardVerify($_REQUEST['real_name'], $_REQUEST['idno']);
    		if($verify['status'] == 0){
    			showErr(/*$verify['info']*/"认证请求失败,请稍后再试!",$this->is_ajax);
    		}
			if($verify['isok'] == false){
    			showErr(/*$verify['info']*/"身份证跟姓名不匹配",$this->is_ajax);
    		}

			$id_card_info = idCardSubInfo($_REQUEST['idno']);
    		$u_c_data['real_name'] = $_REQUEST['real_name'];
    		$u_c_data['idno'] = $_REQUEST['idno'];
    		$u_c_data['sex'] = $id_card_info['sex'];
    		$u_c_data['byear'] = $id_card_info['byear'];
    		$u_c_data['bmonth'] = $id_card_info['bmonth'];
    		$u_c_data['bday'] = $id_card_info['bday'];
			// 结束 
    	}

    	//汽车认证
    	if($type == "credit_car"){
    		$u_c_data['car_brand'] = strim($_REQUEST['carbrand']);
    		$u_c_data['car_year'] = intval($_REQUEST['caryear']);
    		$u_c_data['car_number'] = strim($_REQUEST['carnumber']);
    		$u_c_data['carloan'] = intval($_REQUEST['carloan']);
    		
    	}
    	//房产认证
    	if($type == "credit_house"){
    		$u_c_data['houseloan'] = intval($_REQUEST['houseloan']);
    		
    	}
    	//结婚认证
    	if($type == "credit_marriage"){
    		$u_c_data['haschild'] = intval($_REQUEST['haschild']);
    		
    	}
    	//学历认证
    	if($type == "credit_graducation"){
    		$u_c_data['edu_validcode'] = strim($_REQUEST['validcode']);
    		$u_c_data['graduation'] = strim($_REQUEST['graduation']);
    		$u_c_data['university'] = strim($_REQUEST['university']);
    		$u_c_data['graduatedyear'] = intval($_REQUEST['graduatedyear']);
    	}
    	
    	//视频认证
    	if($type == "credit_videoauth"){
    		$u_c_data['has_send_video'] = intval($_REQUEST['usemail']);
    	}
    	
    	//居住地证明
    	if($type == "credit_residence"){
    		$u_w_data['province_id'] = intval($_REQUEST['province_id']);
    		$u_w_data['city_id'] = intval($_REQUEST['city_id']);
    		
    		if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user_work where user_id=".$GLOBALS['user_info']['id']) > 0){
    			$u_w_data['user_id'] = $GLOBALS['user_info']['id'];
    			$GLOBALS['db']->autoExecute(DB_PREFIX."user_work",$u_w_data,"INSERT");
    		}
    		else
    			$GLOBALS['db']->autoExecute(DB_PREFIX."user_work",$u_w_data,"UPDATE","user_id=".$GLOBALS['user_info']['id']);
    		
    		$u_c_data['address'] = htmlspecialchars($_REQUEST['address']);
    		$u_c_data['phone'] = htmlspecialchars($_REQUEST['phone']);
    		$u_c_data['postcode'] = htmlspecialchars($_REQUEST['postcode']);    		
    	}
    	
    	$GLOBALS['db']->autoExecute(DB_PREFIX."user",$u_c_data,"UPDATE","id=".$GLOBALS['user_info']['id']);
  	
    	$file=array();

    	$mode = "INSERT";
    	$condition = "";
    	
    	$temp_info = $GLOBALS['db']->getRow("SELECT user_id,`type`,`file` FROM ".DB_PREFIX."user_credit_file WHERE user_id=".$GLOBALS['user_info']['id']." AND type='".$type."'");
    	if($temp_info){
    		$file_list = unserialize($temp_info['file']);
    		
    		//认证是否过期
			$time = TIME_UTC;
			$expire_time = $credit_type['list'][$type]['expire']*30*24*3600;
			
    		switch($type){
    			case "credit_contact" :
    				if($GLOBALS['user_info']['workpassed']==1){
			    		if(($time - $GLOBALS['user_info']['workpassed_time']) > $expire_time){
			    			
			    			$GLOBALS['user_info']['workpassed'] = 0;
			    			$GLOBALS['db']->query("update ".DB_PREFIX."user set workpassed=0 WHERE id=".$GLOBALS['user_info']['id']);
			    			es_session::set('user_info',$GLOBALS['user_info']);
			    		}
			    	}
    			break;
    			case "credit_credit" :
    				if($GLOBALS['user_info']['creditpassed']==1){
			    		if(($time - $GLOBALS['user_info']['creditpassed_time']) > $expire_time){
			    			
			    			$GLOBALS['user_info']['creditpassed'] = 0;
			    			$GLOBALS['db']->query("update ".DB_PREFIX."user set creditpassed=0 WHERE id=".$GLOBALS['user_info']['id']);
			    			es_session::set('user_info',$GLOBALS['user_info']);
			    		}
			    	}
    			break;
    			case "credit_incomeduty" :
    				if($GLOBALS['user_info']['incomepassed']==1){
			    		if(($time - $GLOBALS['user_info']['incomepassed_time']) > $expire_time){
			    			
			    			$GLOBALS['user_info']['incomepassed'] = 0;
			    			$GLOBALS['db']->query("update ".DB_PREFIX."user set incomepassed=0 WHERE id=".$GLOBALS['user_info']['id']);
			    			es_session::set('user_info',$GLOBALS['user_info']);
			    		}
			    	}
    			break;
    			case "credit_residence" :
    				if($GLOBALS['user_info']['residencepassed']==1){
			    		if(($time - $GLOBALS['user_info']['residencepassed_time']) > $expire_time){
			    			
			    			$GLOBALS['user_info']['residencepassed'] = 0;
			    			$GLOBALS['db']->query("update ".DB_PREFIX."user set residencepassed=0 WHERE id=".$GLOBALS['user_info']['id']);
			    			es_session::set('user_info',$GLOBALS['user_info']);
			    		}
			    	}
	    		break;
	    		
	    		case "credit_seal" :
			    	foreach($file_list as $k=>$v){
						@unlink(APP_ROOT_PATH.$v);
					}
					$file_list = array();
	    			$GLOBALS['user_info']['sealpassed'] = 0;
	    			$GLOBALS['db']->query("update ".DB_PREFIX."user set sealpassed=0 WHERE id=".$GLOBALS['user_info']['id']);
	    			es_session::set('user_info',$GLOBALS['user_info']);
			    	
    			break;
    		}
    		
    		$mode = "UPDATE";
    		$condition = "user_id=".$GLOBALS['user_info']['id']." AND type='".$type."'";
    	}
    	
		if($file){
			foreach($file as $v){
				$file_list[] = $v;
			}
		}

		// 修改 XHF
		// 修改日期 <2016-03-24> 开始
		// 代码修改,在线实名认证自动更新数据状态,修改待审核为已审核
		/*
    	$data['user_id'] = $GLOBALS['user_info']['id'];
    	$data['type'] = $type;
    	$data['status'] = 0;
    	$data['file'] = serialize($file);
    	$data['create_time'] = TIME_UTC;
    	$data['passed'] = 0;
    	
    	$GLOBALS['db']->autoExecute(DB_PREFIX."user_credit_file",$data,$mode,$condition);

		if($this->is_ajax==1)
    		showSuccess("提交成功,请等待管理员审核！",$this->is_ajax);
		*/

		if($this->modify_certification_passed() && $this->is_ajax==1)
    		showSuccess("实名认证提交成功！",$this->is_ajax);
		// 结束
		
    	else
    		$GLOBALS['tmpl']->display("inc/credit/upload_result_tip.html");
    }

	// 修改 XHF
	// 修改日期 <2016-03-24> 开始
	// 代码修改,添加在线实名认证自动更新数据状态
	public function modify_certification_passed(){
		$user_id = $GLOBALS['user_info']['id'];
		$ispassed = 1;
		$type = 'credit_identificationscanning';
		$key = 'idcardpassed';

    	$credit_type = load_auto_cache("credit_type");
    	if(!isset($credit_type['list'][$type])) { return false; }
		$typeinfo = $credit_type['list'][$type];
  	
		// 保存用户信息
		$GLOBALS['db']->query("update ".DB_PREFIX."user set {$key}=".$ispassed.", {$key}_time='".TIME_UTC."' where id = ".$user_id);

		$u_info = $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."user WHERE id='{$user_id}'");
	
 		// 修改用户帐户数据
		require_once APP_ROOT_PATH."system/libs/user.php";
		if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user_point_log WHERE user_id='".intval($user_id)."' and memo='%".$typeinfo['type_name']."%' and `type`= 8 ")==0){
			modify_account(array('point'=>$typeinfo['point']),$user_id,$typeinfo['type_name'],8);
		}
		
		// 设置用户级别
		$user_current_level = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_level where id = ".intval($u_info['level_id']));
		$user_level = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_level where point <=".intval($u_info['point'])." order by point desc");
		if($user_current_level['point']<=$user_level['point'] && $u_info['level_id']!=$user_level['id'] && $user_level['id'] > 0)
		{
			$u_info['level_id'] = intval($user_level['id']);
			$GLOBALS['db']->query("update ".DB_PREFIX."user set level_id = ".$u_info['level_id']." where id = ".$u_info['id']);
			require_once APP_ROOT_PATH ."app/Lib/common.php";
			$notice['level_name']=$user_level['name'];
			$tmpl_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_LEVEL_ADD'",false);
			$GLOBALS['tmpl']->assign("notice",$notice);
			$pm_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_content['content']);
			
			send_user_msg("",$pm_content,0,$u_info['id'],TIME_UTC,0,true,true);			
			$user_current_level['name'] = $user_level['name'];
		}

		$group_arr = array(0,$user_id);
		sort($group_arr);
		$group_arr[] =  intval($ispassed + 1);
		
		// 发送系统消息
		$msg_data['content'] = "尊敬的用户 ".$u_info['real_name']."，您已通过实名认证。";
		$msg_data['to_user_id'] = $user_id;
		$msg_data['create_time'] = TIME_UTC;
		$msg_data['type'] = 0;
		$msg_data['group_key'] = implode("_",$group_arr);
		$msg_data['is_notice'] = intval($ispassed + 1);
		
		$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
		$id = $GLOBALS['db']->insert_id();
		$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);

		// 写入记录到审核记录表中
		$is_exist = $GLOBALS['db']->getAll("select id from ".DB_PREFIX."user_credit_file where user_id='{$user_id}'");
		$mode = 'INSERT'; $condition = '';

		$credit_data['status'] = 1;
		$credit_data['passed'] = $ispassed;
		$credit_data['type'] = $type;
		$credit_data['passed_time'] = TIME_UTC;
		$credit_data['msg'] = USER_ONLINE_CERTIFICAT;

		if ($is_exist) {
			$mode = 'UPDATE';
			$condition = "where user_id={$user_id} AND type='credit_identificationscanning'";
		} else {
			$credit_data['user_id'] = $user_id;
			$credit_data['create_time'] = $credit_data['passed_time'];
		}

    	$GLOBALS['db']->autoExecute(DB_PREFIX."user_credit_file",$credit_data,$mode,$condition);

		return true;
	}
	// 结束
}
?>