<?php

/**
 * 借款管理短信模板
 * 修改update()
 * 正常修改跳转index,借款信息模板跳转deal
 * Admin 2016-7-26
 */

class MsgTemplateAction extends CommonAction{
	public function index()
	{
		$type = intval($_REQUEST['type']);
		$tpl_list = M("MsgTemplate")->where("type=".$type)->findAll();
		$this->assign("tpl_list",$tpl_list);
		$this->display();
	}	
    /**
     * 借款管理短信模板
     * Admin 2016-7-26
     */
	public function deal()
	{
		$this->assign("main_title","借款消息模板管理");
        $name = "'TPL_INS_DEAL_REPAY_SMS','TPL_DEAL_THREE_EMAIL','TPL_INS_DEAL_REPAY_SMS_AGENCY'";
		$tpl_list = M("MsgTemplate")->where("name in (".$name.")")->findAll();
		$this->assign("tpl_list",$tpl_list);
		$this->display();
	}	
    public function load_tpl()
	{
		$name = trim($_REQUEST['name']);
		$tpl = M("MsgTemplate")->where("name='".$name."'")->find();
		if($tpl)
		{
			$tpl['tip'] = l("MSG_TIP_".strtoupper($name));
			$this->ajaxReturn($tpl,'',1);
		}
		else
		{
			$this->ajaxReturn('','',0);
		}		
	}
	
	/**
	 * 修改更新信息模板之后的跳转页面
	 * 正常修改跳转到 index
	 * 借款短信模板跳转到 deal
	 * Admin 2016-7-26 
	 */
	public function update()
	{
		$data = M(MODULE_NAME)->create ();
		if($data['name']==''||$data['id']==0)
		{
			$this->error(l("SELECT_MSG_TPL"));
		}
		$log_info = $data['name'];
		if (isset($_REQUEST['c']) && trim($_REQUEST['c']) == deal) {
			$this->assign("jumpUrl",u(MODULE_NAME."/deal"));
		} else {
			$this->assign("jumpUrl",u(MODULE_NAME."/index"));
		}
		
		// 更新数据
		$list=M(MODULE_NAME)->save ($data);
		if (false !== $list) {
			//成功提示
			save_log($log_info.L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$log_info.L("UPDATE_FAILED"));
		}
	}
}
?>