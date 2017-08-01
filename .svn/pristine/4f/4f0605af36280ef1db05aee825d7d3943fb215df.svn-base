<?php

require APP_ROOT_PATH.'app/Lib/page.php';
require APP_ROOT_PATH.'app/Lib/uc.php';
class deal_msgboardModule extends SiteBaseModule
{
	public function index()
	{	
		$loan_type_list = load_auto_cache("deal_loan_type_list");
    	foreach($loan_type_list as $k=>$v){
    		if($v['credits']!=""){
    			$loan_type_list[$k]['credits'] = unserialize($v['credits']);
    			if(!is_array($loan_type_list[$k]['credits'])){
					$loan_type_list[$k]['credits'] = array();
				}
    		}
    		else
    			$loan_type_list[$k]['credits'] = array();
    	}
    	
    	$GLOBALS['tmpl']->assign('usefulness_type_list',$loan_type_list);
		
		$GLOBALS['tmpl']->display("page/deal_msgboard_index.html",$cache_id);
	}
	
	public function savedeal()
	{
		$is_ajax = intval($_REQUEST['is_ajax']);

    	$verify_code = strim($_REQUEST['verify_code']);
		
		$data = array();
		$data["user_name"] = strim($_REQUEST["user_name"]);
		$data["ID_NO"] = strim($_REQUEST["ID_NO"]);
		$data["mobile"] = strim($_REQUEST["mobile"]);
		$data["money"] = floatval($_REQUEST["money"]);
		$data["time_limit"] = strim($_REQUEST["time_limit"]);
		$data["usefulness"] = $GLOBALS["db"]->getOne("select name from ".DB_PREFIX."deal_loan_type where id = ".intval($_REQUEST["usefulness"]));
		
		$data["create_time"] = to_date(TIME_UTC);
		$data["status"] = 0;
		$data["unit"] = intval($_REQUEST["unit"]);
		
		if($verify_code==""){
			showErr("请输入手机验证码");
		}
		//判断验证码是否正确
		if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."mobile_verify_code WHERE mobile='".strim($data['mobile'])."' AND verify_code='".strim($verify_code)."' AND create_time + ".SMS_EXPIRESPAN." > ".TIME_UTC." ")==0){
			showErr("手机验证码出错,或已过期");
		}		
		
		if($data["user_name"]=="")
		{
			showErr("请填写您的真实姓名",$ajax,"");
		}
		if($data["ID_NO"]=="")
		{
			showErr("请填写您的身份证号码",$ajax,"");
		}
		if($data["mobile"]=="")
		{
			showErr("请填写您的手机号",$ajax,"");
		}
		if($data["money"] <= 0)
		{
			showErr("请填写借款金额",$ajax,"");
		}
		if($data["time_limit"]=="")
		{
			showErr("请填写借款期限",$ajax,"");
		}
		
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msgboard",$data,'INSERT','','SILENT');
		
		showSuccess("提交成功,等待管理员审核",0,url("index","deal_msgboard#index"));
	}
}
?>