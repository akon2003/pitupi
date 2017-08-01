<?php

/**
 * 操作权限设置
 * 为后台用户添加可操作模块
 * 操作时需要输入设置的操作密码
 */

class OperateAction extends CommonAction{
	public function index() {	
		$this->assign("main_title", "操作权限分配");

		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		$model = D (MODULE_NAME);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$list = $this->get("list");
		foreach ($list as $k=>&$v) {
			if ($v['password'] == '') {
				$v['empty_password'] = '是';
			}
		}
		
		$this->assign("list",$list);
		$this->display ();
	}
	
	//新增分配用户
	public function add() {
		$this->assign("main_title", "新增分配用户");

		//后台用户列表
		$admin_list = $GLOBALS['db']->getAll("select id,adm_name,real_name from ".DB_PREFIX."admin where is_department=0 and is_effect=1 and is_delete=0 order by authority_id, role_id asc");
		//操作模块列表
		$module_list = $this->_get_modules();

		$this->assign("admin_list", $admin_list);
		$this->assign("module_list", $module_list);

		$this->display();
	}
	
	public function insert() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');

		$data = M(MODULE_NAME)->create ();

		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/add"));
		if (intval($data['adm_id']) == 0) {
			$this->error("请选择用户！");
		}
		//是否重复添加
		$operate_id = $GLOBALS['db']->getOne("select id from ".DB_PREFIX."operate where adm_id=".$data['adm_id']);
		if ($operate_id) {
			$this->error("该用户已添加！");
		}

		$data['adm_name'] = get_admin_name($data['adm_id']);
		if ($data['password'] != "") {
			$data['password'] = md5(md5($data['password']));
		}
		$data['create_time'] = TIME_UTC;
		$data['update_time'] = 0;
		$data['modules'] = implode(',', $_REQUEST['role_access']);

		// 更新数据
		$log_info = $data['adm_name'].'分配操作权限';
		$list=M(MODULE_NAME)->add($data);
		if (false !== $list) {			
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}

	public function edit() {
		$this->assign("main_title", "编辑分配用户");

		$id = intval($_REQUEST['id']);
		$condition['id'] = $id;
		$vo = M(MODULE_NAME)->where($condition)->find();

		//操作模块列表
		$module_list = $this->_get_modules();
		//分配模块列表
		$assign_module_list = explode(',', $vo['modules']);
		foreach ($module_list as $k_menu=>&$menu) {
			foreach ($menu['groups'] as $k=>&$v) {
				$checked = false;
				foreach ($assign_module_list as $k_node=>$node) {
					if ($node === $v['module']) { 
						$checked = true;
						break;						
					}
				}
				if (isset($v['module'])) {
					$v['checked'] = $checked;
				}
			}
		}

		$this->assign("module_list", $module_list);
		$this->assign('vo', $vo);

		$this->display();
	}
	
	public function update() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');

		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/index"));

		$data['id'] = intval($_REQUEST['id']);
		//密码非空表示修改密码
		if (trim($_REQUEST['password']) != "") {
			$data['password'] = md5(md5(trim($_REQUEST['password'])));
		}
		$data['update_time'] = TIME_UTC;
		$data['modules'] = implode(',', $_REQUEST['role_access']);

		// 更新数据
		$log_info = $data['adm_name'].'编辑操作权限';		
		$list=M(MODULE_NAME)->save($data);
		if (false !== $list) {			
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}

	//操作模块
	private function _get_modules() {
		$modules = array(
			'deal'	=>	array(
				'name'		=>	'借款管理',
				'groups'	=>	array(
					array('module'=>'ExtDealNewe',	'name'=>'新手标管理'),
					array('module'=>'ExtDealUplan',	'name'=>'U计划管理'),
					array('module'=>'Deal',			'name'=>'借款管理'),
				),
			),
			'user'	=>	array(
				'name'		=>	'会员管理',
				'groups'	=>	array(					
					array('module'=>'MyCustomer',	'name'=>'会员维护'),
				),
			),
			'order'	=>	array(
				'name'		=>	'财务管理',
				'groups'	=>	array(
					array('module'=>'UserCarry',	'name'=>'用户提现'),
					array('module'=>'CarryPwdSet',	'name'=>'提现密码设置'),
					array('module'=>'User',			'name'=>'账户管理'),
				),
			),
			'front'	=>	array(
				'name'		=>	'平台推广',
				'groups'	=>	array(
					array('module'=>'Article',		'name'=>'文章管理'),
					array('module'=>'Adv',			'name'=>'前端广告管理'),
					array('module'=>'MAdv',			'name'=>'手机端广告管理'),
					array('module'=>'MsgTemplate',	'name'=>'消息模板管理'),
				),
			),
			'department'	=>	array(
				'name'		=>	'系统管理',
				'groups'	=>	array(
					array('module'=>'MyManager',	'name'=>'后台用户管理'),
					array('module'=>'Departments',	'name'=>'部门管理'),
					array('module'=>'Role',			'name'=>'角色管理'),
				),
			),
			'system1'	=>	array(
				'name'		=>	'系统配置(设置)',
				'groups'	=>	array(
					array('module'=>'Conf',			'name'=>'系统配置'),
					array('module'=>'DealCate',		'name'=>'借款产品管理'),
					array('module'=>'DealLoanType',	'name'=>'借款类型管理'),
					array('module'=>'Contract',		'name'=>'借款合同设置'),
					array('module'=>'Admin',		'name'=>'管理员设置'),
					array('module'=>'Operate',		'name'=>'操作权限设置'),
				),
			),
			'system2'	=>	array(
				'name'		=>	'系统配置(接口)',
				'groups'	=>	array(
					array('module'=>'IdCard',		'name'=>'实名认证接口'),
					array('module'=>'Payment',		'name'=>'支付接口'),
					array('module'=>'Carry',		'name'=>'提现接口'),
					array('module'=>'ApiLogin',		'name'=>'第三方登录接口'),
					array('module'=>'Mail',			'name'=>'邮件服务接口'),
					array('module'=>'Sms',			'name'=>'短信接口'),

				),
			),
			'manager'	=>	array(
				'name'		=>	'市场部管理',
				'groups'	=>	array(
					array('module'=>'ExtAdminManager',	'name'=>'市场部管理'), //市场部总监:重置密码,密码解锁,分配客服
				),
			),
		);
		return $modules;
	}
}
?>