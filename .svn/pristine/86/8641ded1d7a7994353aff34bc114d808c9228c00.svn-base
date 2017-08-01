<?php

class BankAction extends CommonAction{
public function index()
	{	
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		$map['is_rec'] = 1;
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		$model = D ("Bank");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$list = $this->get("list");
		foreach($list as $k=>$v)
		{
			if($list[$k]['is_rec'] ==1){
				 $list[$k]['is_rec']="是";
			}else{
				$list[$k]['is_rec']="否";
			}
			$bank_info = unserialize($v['allinpay_info']);
			$list[$k]['ainchk1'] = isset($bank_info['ainchk1']) && $bank_info['ainchk1'] == 1? '支持' : '';
			$list[$k]['ainval1'] = isset($bank_info['ainchk1']) && $bank_info['ainchk1'] == 1? $bank_info['ainval1'].'万元' : '';
			$list[$k]['ainchk2'] = isset($bank_info['ainchk2']) && $bank_info['ainchk2'] == 1? '支持' : '';
			$list[$k]['ainval2'] = isset($bank_info['ainchk2']) && $bank_info['ainchk2'] == 1? $bank_info['ainval2'].'万元' : '';
			$list[$k]['ainchk3'] = isset($bank_info['ainchk3']) && $bank_info['ainchk3'] == 1? '支持' : '';
			$list[$k]['ainval3'] = isset($bank_info['ainchk3']) && $bank_info['ainchk3'] == 1? $bank_info['ainval3'].'万元' : '';
			$list[$k]['ainchk4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? '支持' : '';
			$list[$k]['ainval4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? $bank_info['ainval4'].'万元' : '';
			$list[$k]['ainvax4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? $bank_info['ainvax4'].'次/天' : '';
		}
		
		$this->assign("list",$list);
		$this->display ();
		return;
	}
	
	public function edit() {
		$id = intval($_REQUEST ['id']);
		$condition['id'] = $id;
		$vo = M(MODULE_NAME)->where($condition)->find();
		$bank_info = unserialize($vo['allinpay_info']);

		$vo['ainchk1'] = isset($bank_info['ainchk1']) && $bank_info['ainchk1'] == 1? 1 : 0;
		$vo['ainval1'] = isset($bank_info['ainchk1']) && $bank_info['ainchk1'] == 1? $bank_info['ainval1'] : '';
		$vo['ainchk2'] = isset($bank_info['ainchk2']) && $bank_info['ainchk2'] == 1? 1 : 0;
		$vo['ainval2'] = isset($bank_info['ainchk2']) && $bank_info['ainchk2'] == 1? $bank_info['ainval2'] : '';
		$vo['ainchk3'] = isset($bank_info['ainchk3']) && $bank_info['ainchk3'] == 1? 1 : 0;
		$vo['ainval3'] = isset($bank_info['ainchk3']) && $bank_info['ainchk3'] == 1? $bank_info['ainval3'] : '';
		$vo['ainchk4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? 1 : 0;
		$vo['ainval4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? $bank_info['ainval4'] : '';
		$vo['ainvax4'] = isset($bank_info['ainchk4']) && $bank_info['ainchk4'] == 1? $bank_info['ainvax4'] : '';

		$this->assign ( 'vo', $vo );
		$this->display ();
	}
	
	public function set_sort()
	{
		$id = intval($_REQUEST['id']);
		$sort = intval($_REQUEST['sort']);
		$log_info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		if(!check_sort($sort))
		{
			$this->error(l("SORT_FAILED"),1);
		}
		M(MODULE_NAME)->where("id=".$id)->setField("sort",$sort);
		save_log($log_info.l("SORT_SUCCESS"),1);
		rm_auto_cache("cache_bank");
		$this->success(l("SORT_SUCCESS"),1);
	}
	
	public function set_isrec()
	{
		$id = intval($_REQUEST['id']);
		$is_rec = intval($_REQUEST['is_rec']);
		$log_info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		/*
		if(!check_sort($is_rec))
		{
			$this->error(l("SORT_FAILED"),1);
		}*/
		M(MODULE_NAME)->where("id=".$id)->setField("is_rec",$is_rec);
		save_log($log_info.l("SORT_SUCCESS"),1);
		rm_auto_cache("cache_bank");
		$this->success(l("SORT_SUCCESS"),1);
	}
	
	public function update() {
		B('FilterString');
		$data = M(MODULE_NAME)->create ();

		$bank_info = array();
		if (isset($_REQUEST['ainchk1']) && $_REQUEST['ainchk1'] == 1) {
			$bank_info['ainchk1'] = 1;
			$bank_info['ainval1'] = intval($_REQUEST['ainval1']);
		}
		if (isset($_REQUEST['ainchk2']) && $_REQUEST['ainchk2'] == 1) {
			$bank_info['ainchk2'] = 1;
			$bank_info['ainval2'] = intval($_REQUEST['ainval2']);
		}
		if (isset($_REQUEST['ainchk3']) && $_REQUEST['ainchk3'] == 1) {
			$bank_info['ainchk3'] = 1;
			$bank_info['ainval3'] = intval($_REQUEST['ainval3']);
		}
		if (isset($_REQUEST['ainchk4']) && $_REQUEST['ainchk4'] == 1) {
			$bank_info['ainchk4'] = 1;
			$bank_info['ainval4'] = intval($_REQUEST['ainval4']);
			$bank_info['ainvax4'] = intval($_REQUEST['ainvax4']);
		}
		$data['allinpay_info'] = serialize($bank_info);

		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("title");
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/edit",array("id"=>$data['id'])));
		// 更新数据
		$list=M(MODULE_NAME)->save ($data);
		if (false !== $list) {
			//成功提示
			save_log($log_info.L("UPDATE_SUCCESS"),1);
			rm_auto_cache("cache_bank");
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$log_info.L("UPDATE_FAILED"));
		}
	}
	
	public function add()
	{
		$sort = M("Bank") -> max("sort");
		$this->assign ( 'sort', $sort  + 1);
		$this->display ();
	}
	
	public function insert() {
		B('FilterString');
		$data = M(MODULE_NAME)->create ();

		$bank_info = array();
		if (isset($_REQUEST['ainchk1']) && $_REQUEST['ainchk1'] == 1) {
			$bank_info['ainchk1'] = 1;
			$bank_info['ainval1'] = intval($_REQUEST['ainval1']);
		}
		if (isset($_REQUEST['ainchk2']) && $_REQUEST['ainchk2'] == 1) {
			$bank_info['ainchk2'] = 1;
			$bank_info['ainval2'] = intval($_REQUEST['ainval2']);
		}
		if (isset($_REQUEST['ainchk3']) && $_REQUEST['ainchk3'] == 1) {
			$bank_info['ainchk3'] = 1;
			$bank_info['ainval3'] = intval($_REQUEST['ainval3']);
		}
		if (isset($_REQUEST['ainchk4']) && $_REQUEST['ainchk4'] == 1) {
			$bank_info['ainchk4'] = 1;
			$bank_info['ainval4'] = intval($_REQUEST['ainval4']);
			$bank_info['ainvax4'] = intval($_REQUEST['ainvax4']);
		}
		$data['allinpay_info'] = serialize($bank_info);

		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/add"));
		if(!check_empty($data['name']))
		{
			$this->error(L("DEALCATE_NAME_EMPTY_TIP"));
		}	

		// 更新数据
		$log_info = $data['name'];
		
		$list=M(MODULE_NAME)->add($data);
		if (false !== $list) {
			
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			rm_auto_cache("cache_bank");
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}

	public function delete() {
		
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['name'];	
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->delete();

				if ($list!==false) {
					save_log($info.l("FOREVER_DELETE_SUCCESS"),1);
					rm_auto_cache("cache_bank");
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