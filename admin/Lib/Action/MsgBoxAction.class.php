<?php

class MsgBoxAction extends CommonAction{
	//已发送的信息
	public function index() {
		$this->assign("main_title","已发送的信息");
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));

		$is_notice = array(
			'0' => "用户信息",
			'0' => "用户信息",
			'1' => "系统通知",
			'2' => "材料通过",
			'3' => "审核失败",
			'4' => "额度更新",
			'5' => "提现申请",
			'6' => "提现成功",
			'7' => "提现失败",
			'8' => "还款成功",
			'9' => "回款成功",
			'10'=> "借款流标",
			'11'=> "投标流标",
			'12'=> "三日内还款",
			'13'=> "标被留言",
			'14'=> "标留言被回复",
			'15'=> "借款投标过半",
			'16'=> "投标满标",
			'17'=> "债权转让失败",
			'18'=> "债权转让成功",
			'19'=> "续约成功",
			'20'=> "续约失败"
		);
		$this->assign("is_notice",$is_notice);

		$condition['from_user_id'] = array("in", array(0,$adm_session['adm_id']));

		if (isset($_REQUEST['is_notice']) && $_REQUEST['is_notice'] != "-1") {
			$condition['is_notice'] = array("eq", intval($_REQUEST['is_notice']));
		} else {
			$condition['is_notice'] = array("gt", -1);
			$_REQUEST['is_notice'] = "-1";
		}

		if(trim($_REQUEST['user_name'])!='')
		{
			//支持模糊搜索
			$q = trim($_REQUEST['user_name']);
			$user_list = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			foreach ($user_list as $key=>$value) {
				$user_list[$key] = $value['id'];
			}
			$condition['to_user_id'] = array("in", $user_list);
		}

		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition['create_time'] = array("egt", $begin_time);	
			} else if ($begin_time==0) {
				$condition['create_time'] = array("elt", $end_time);	
			} else {
				$condition['create_time'] = array("between", array($begin_time,$end_time));	
			}
		}

		$this->assign("default_map",$condition);
		$map = $this->get("default_map");
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}

		$model = D($this->getActionName());
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}

		$this->display();
	}

	public function view()
	{
		$id = intval($_REQUEST ['id']);
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$this->assign ( 'vo', $vo );
		$this->display ();
	}
	
	public function foreverdelete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['id'];	
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->delete();			
				if ($list!==false) {
					save_log($info.l("FOREVER_DELETE_SUCCESS"),1);
					$this->success (l("FOREVER_DELETE_SUCCESS"),$ajax);
				} else {
					save_log($info.l("FOREVER_DELETE_FAILED"),0);
					$this->error (l("FOREVER_DELETE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}	
}
?>