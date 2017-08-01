<?php

class RoleAction extends CommonAction{
	public function index()
	{
		$condition['is_delete'] = 0;
		$this->assign("default_map",$condition);
		parent::index();
	}
	public function trash()
	{
		$condition['is_delete'] = 1;
		$this->assign("default_map",$condition);
		parent::index();
	}
	public function add()
	{
		//输出module与action
		$access_list = $GLOBALS['access_list'];	
        foreach($access_list as $k=>$v){
            if((int)C("PEIZI_OPEN")==0){
               $pznot_in = array(
                "PeiziRate",
                "PeiziOrderOp",
                "PeiziOrder,Option",
                "Conf,PeiziConf,PeiziHoliday,PeiziIndexshow",
                "PeiziOrderOther,PeiziOrderStockMoney"
               );
               if(in_array($k, $pznot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
            
            if((int)C("LICAI_OPEN")==0){
                 $lcnot_in = array(
                    "Licai,LicaiHistory,LicaiInterest,LicaiRecommend,LicaiDealshow,LicaiOrder",
                    "LicaiFundType,LicaiFundBrand,LicaiRecommend,LicaiDealshow",
                    "LicaiRedempte",
                    "LicaiNear,LicaiSend",
                    "LicaiAdvance"
                   );
               if(in_array($k, $lcnot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
			
			if((int)C("PROJECT_OPEN")==0){
                $lcnot_in = array(
                    
                   );
               if(in_array($k, $lcnot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
        }
		$this->assign("access_list",$access_list);
		$this->display();
	}
	public function edit() {	
		$id = intval($_REQUEST ['id']);
		$condition['is_delete'] = 0;
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$this->assign ( 'vo', $vo );
		//输出module与action
		$access_list = $GLOBALS['access_list'];
       
		foreach($access_list as $k=>$v)
		{
            if((int)C("PEIZI_OPEN")==0){
               $pznot_in = array(
                "PeiziRate",
                "PeiziOrderOp",
                "PeiziOrder,Option",
                "Conf,PeiziConf,PeiziHoliday,PeiziIndexshow",
                "PeiziOrderOther,PeiziOrderStockMoney"
               );
               if(in_array($k, $pznot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
            
            if((int)C("LICAI_OPEN")==0){
                $lcnot_in = array(
                    "Licai,LicaiHistory,LicaiInterest,LicaiRecommend,LicaiDealshow,LicaiOrder",
                    "LicaiFundType,LicaiFundBrand,LicaiRecommend,LicaiDealshow",
                    "LicaiRedempte",
                    "LicaiNear,LicaiSend",
                    "LicaiAdvance"
                   );
               if(in_array($k, $lcnot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
			
			if((int)C("PROJECT_OPEN")==0){
                $lcnot_in = array(
                    
               );
               if(in_array($k, $lcnot_in)){
                   unset($access_list[$k]); 
                   continue;
               }
            }
           
                     
			if($GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."role_access where role_id = ".$vo['id']." and module = '".$k."' and node = ''")>0)
			{
				$access_list[$k]['module_auth'] = 1;  //当前模块被授权
			}
			else
			{
				$access_list[$k]['module_auth'] = 0; 
			}
			
			$node_list = $v['node'];

			foreach($node_list as $kk=>$vv)
			{	
				if($vv['module']!=""){
					$module = $vv['module'];
				}
				else{
					$module = $k;
				}
				if($GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."role_access where role_id = ".$vo['id']." and module = '".$module."' and node = '".$vv['action']."'")>0)
				{
					$node_list[$kk]['node_auth'] = 1;
				}
				else
				{
					$node_list[$kk]['node_auth'] = 0;
				}
			}
			$access_list[$k]['node'] = $node_list;
			//非模块授权时的是否全选
			$r1 = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."role_access where role_id = ".$vo['id']." and module = '".$k."' and node <> ''");
			$r2 = count($v['node']);
			if($r1==$r2&&$r2!=0)
			{
				//全选
				$access_list[$k]['check_all'] = 1;
			}
			else
			{
				$access_list[$k]['check_all'] = 0;
			}
		}		
		$this->assign("access_list",$access_list);
		
		
		$this->display ();
	}
	//设置访问菜单
	public function configs() {
		$id = intval($_REQUEST ['id']);
		$condition['is_delete'] = 0;
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();
		$config = unserialize($vo['config']);
		$vo['all_auth'] = !$config? 1 : 0;

		$this->assign ( 'vo', $vo );
		$this->assign("menu",$this->menu($config));

		$this->display();
	}
	public function configs_update() {
		if (isset($_REQUEST['all_auth']) && intval($_REQUEST['all_auth']) > 0) {
			M(MODULE_NAME)->where("id=".intval($_REQUEST['id']))->setField("config","");
			save_log($_REQUEST['name']."菜单设置生效",1);
			$this->success($_REQUEST['name']."菜单设置生效");
			return;
		}

		$config_key = array(); $config_menu = array();
		//获取系统菜单项
		foreach ($_REQUEST as $k=>$v) {
			if (preg_match("/^__k1_/", $k) && $_REQUEST[$k] == 1) { $config_key[] = $k; }
		}
		//一级头部导航
		foreach ($config_key as $k=>$v) {
			$v = str_replace('__k1_', '', $v);
			if (!preg_match("/__k2_/", $v)) { 
				$config_menu[$v]['flag'] = 1; 
				unset($config_key[$k]);
			} else {
				$config_key[$k] = $v;
			}
		}
		//二级左侧导航菜单
		foreach ($config_key as $k=>$v) {			
			foreach ($config_menu as $tk=>$tv) {
				$valid_node = false;
				if (preg_match("/".$tk."__k2_/", $v)) {
					$v = str_replace($tk.'__k2_', '', $v);
					if (!preg_match("/__k3_/", $v)) { 
						$config_menu[$tk]['groups'][$v]['flag'] = 1;
						unset($config_key[$k]);						
					}
					$valid_node = true;
				}
			}
		}
		//三级下拉菜单
		foreach ($config_menu as $tk=>$tv) {
			foreach ($config_menu[$tk]['groups'] as $lk=>$lv) {
				$valid_node = false;
				foreach ($config_key as $k=>$v) {
					if (preg_match("/".$tk."__k2_".$lk."__k3_/", $v)) {
						$v = str_replace($tk.'__k2_'.$lk.'__k3_', '', $v);
						$config_menu[$tk]['groups'][$lk]['nodes'][$v]['flag'] = 1;
						$valid_node = true;
					}
				}
			}
		}
		
		if ($config_menu) {
			M(MODULE_NAME)->where("id=".intval($_REQUEST['id']))->setField("config",serialize($config_menu));
			save_log($_REQUEST['name']."菜单设置生效",1);
			$this->success($_REQUEST['name']."菜单设置生效");
		} else {
			$this->error("无效的用户菜单设置");
		}
	}

	private function menu($config=null) {
		$menu = require_once APP_ROOT_PATH."system/admnav_cfg.php";	

        foreach($menu as $k=>$v){
            if((int)C("PEIZI_OPEN")==0 && strpos(strtolower($v['key']),"peizi")!==false){
                unset($menu[$k]);
            }
            
            if((int)C("LICAI_OPEN")==0 && strpos(strtolower($v['key']),"licai")!==false){
                unset($menu[$k]);
            }
			
			if((int)C("PROJECT_OPEN")==0 && strpos(strtolower($v['key']),"project")!==false){
                unset($menu[$k]);
            }
        }

		foreach ($menu as $k1=>$v1) {
			$menu[$k1]['flag'] = 0;
			if ($config && isset($config[$k1])) {
				$menu[$k1]['flag'] = 1;
			}
			foreach ($menu[$k1]['groups'] as $k2=>$v2) {
				$menu[$k1]['groups'][$k2]['flag'] = 0;
				if ($config && isset($config[$k1]) && isset($config[$k1]['groups'][$k2])) {
					$menu[$k1]['groups'][$k2]['flag'] = 1;
				}
				foreach ($menu[$k1]['groups'][$k2]['nodes'] as $k3=>$v3) {
					$key = $v3['module'].'#'.$v3['action'];
					$menu[$k1]['groups'][$k2]['nodes'][$k3]['flag'] = 0;
					$menu[$k1]['groups'][$k2]['nodes'][$k3]['key'] = $key;
					if ($config && isset($config[$k1]) && isset($config[$k1]['groups'][$k2]) && isset($config[$k1]['groups'][$k2]['nodes'][$key])) {
						$menu[$k1]['groups'][$k2]['nodes'][$k3]['flag'] = 1;
					}
				}
			}
		}

		return $menu;
	}
	//相关操作
	public function set_effect()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		$c_is_effect = M(MODULE_NAME)->where("id=".$id)->getField("is_effect");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_effect",$n_is_effect);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	public function insert() {		
		B('FilterString');
		$data = M(MODULE_NAME)->create ();
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/add"));
		if(!check_empty($data['name']))
		{
			$this->error(L("ROLE_NAME_EMPTY_TIP"));
		}	
		// 更新数据
		$log_info = $data['name'];
		$role_id=M(MODULE_NAME)->add($data);
		if (false !== $role_id) {
			//开始关联节点
			if(isset($_REQUEST['role_access']))
			{
				$role_access =  $_REQUEST['role_access'];
				$role = array();
				foreach($role_access as $k=>$v)
				{
					//开始提交关联
					$v = strim($v);
					if(strpos($v,",")===false){
						$item = explode("|",$v);
						
						$access_item['role_id'] = $role_id;
						$access_item['node'] = empty($item[1])?"":$item[1];
						$access_item['module'] = $item[0];
						$GLOBALS['db']->autoExecute(DB_PREFIX."role_access",$access_item,"INSERT","","SILENT");
					}
					else{
						$access_item['role_id'] = $role_id;
						$access_item['node'] = "";
						$access_item['module'] = $v;
						$GLOBALS['db']->autoExecute(DB_PREFIX."role_access",$access_item,"INSERT","","SILENT");
					}
					
				}
			}
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}
	
	public function update() {
		B('FilterString');
		$data = M(MODULE_NAME)->create ();
		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("name");
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/edit",array("id"=>$data['id'])));
		if(!check_empty($data['name']))
		{
			$this->error(L("ROLE_NAME_EMPTY_TIP"));
		}	
		// 更新数据
		$list=M(MODULE_NAME)->save ($data);
		if (false !== $list) {
			//成功提示
			$role_id = $data['id'];
			M("RoleAccess")->where("role_id=".$role_id)->delete();
			//开始关联节点
			
			
			$role_access = $_REQUEST['role_access'];
			foreach($role_access as $k=>$v)
			{
				//开始提交关联
				$v = strim($v);
				if(strpos($v,",")===false){
					$item = explode("|",$v);
					if(empty($item[1]))
					{					
						//模块授权
						$GLOBALS['db']->query("delete from ".DB_PREFIX."role_access where role_id = ".$role_id." and module = '".$item[0]."'");
					}
					else
					{
						//节点授权
						$GLOBALS['db']->query("delete from ".DB_PREFIX."role_access where role_id = ".$role_id." and module = '".$item[0]."' and node = '".$item[1]."'");
					}
					$access_item['role_id'] = $role_id;
					$access_item['node'] = empty($item[1])?"":$item[1];
					$access_item['module'] = $item[0];
					$GLOBALS['db']->autoExecute(DB_PREFIX."role_access",$access_item,"INSERT","","SILENT");
				}
				else{
					//模块授权
					$GLOBALS['db']->query("delete from ".DB_PREFIX."role_access where role_id = ".$role_id." and module = ''");
					$access_item['role_id'] = $role_id;
					$access_item['node'] = "";
					$access_item['module'] = $v;
					$GLOBALS['db']->autoExecute(DB_PREFIX."role_access",$access_item,"INSERT","","SILENT");
				}
				
			}
			
			save_log($log_info.L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"));
		}
	}

	public function delete() {
		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['name'];	
					//开始验证分组下是否存在管理员
					if(M("Admin")->where("is_effect = 1 and is_delete = 0 and role_id=".$data['id'])->count()>0)
					{
						$this->error ($data['name'].l("EXIST_ADMIN"),$ajax);
					}
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 1 );
				if ($list!==false) {
					save_log($info.l("DELETE_SUCCESS"),1);
					$this->success (l("DELETE_SUCCESS"),$ajax);
				} else {
					save_log($info.l("DELETE_FAILED"),0);
					$this->error (l("DELETE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	public function restore() {
		//删除指定记录
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
				$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 0 );
				if ($list!==false) {
					save_log($info.l("RESTORE_SUCCESS"),1);
					$this->success (l("RESTORE_SUCCESS"),$ajax);
				} else {
					save_log($info.l("RESTORE_FAILED"),0);
					$this->error (l("RESTORE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	public function foreverdelete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				$role_access_condition = array ('role_id' => array ('in', explode ( ',', $id ) ) );
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['name'];
					//开始验证分组下是否存在管理员
					if(M("Admin")->where("is_effect = 1 and is_delete = 0 and role_id=".$data['id'])->count()>0)
					{
						$this->error ($data['name'].l("EXIST_ADMIN"),$ajax);
					}	
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->delete();
				M("RoleAccess")->where($role_access_condition)->delete();
				M("Admin")->where($role_access_condition)->delete();
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