<?php

//后台验证的基础类
class AuthAction extends BaseAction{
	public function __construct() {
		parent::__construct();
		$this->check_has_auth('','default');		
	}
		
	//index列表的前置通知,输出页面标题
	public function _before_index() {
		$this->assign("main_title",L(MODULE_NAME."_INDEX"));
	}

	public function _before_trash() {
		$this->assign("main_title",L(MODULE_NAME."_INDEX"));
	}

	/**
	 * 添加系统安全选项
	 * @param $args 安全选项数组
	 *   $args[] 检测内容项
	 *   array('operate_password'=>array('module'=>'')) 操作密码检测,module为空读取模块名称
	 *   array('system_repair_mode'=>array('module'=>'')) 系统维护模式检测,module为空读取模块名称
	 *   args为空表示全部检测
	 */
	public function check_safe_item($args=null) {
		if ($args && !is_array($args)) {
			$this->error("参数格式不正确"); return;
		}

		if (!$args) {
			$args = array(
				'system_repair_mode'	=> array(),
				'operate_password'		=> array(),
			);
		}

		//系统维护模式检测
		if (isset($args['system_repair_mode'])) {
			$module = isset($args['system_repair_mode']['module']) && $args['system_repair_mode']['module'] != ''? $args['system_repair_mode']['module'] : MODULE_NAME;
			$status = $this->check_system_repair_mode($module);
			if ($status['status'] == 0) {
				$this->error($status['info']); break;
			}
		}

		//操作密码检测
		if (isset($args['operate_password'])) {
			$module = isset($args['operate_password']['module']) && $args['operate_password']['module'] != ''? $args['operate_password']['module'] : MODULE_NAME;
			$status = $this->check_operate_password($module);
			if ($status['status'] == 0) {
				$this->error($status['info']); break;
			}
		}

		return true;
	}

	//检测后台用户操作密码有效性
	public function check_operate_password($module_name=MODULE_NAME) {
		$status = array('status'=>0, 'info'=>'');

		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);

		//获取系统设置密码
		$operate_info = $GLOBALS['db']->getRow("select password,modules,is_effect from ".DB_PREFIX."operate where adm_id=".$adm_id." and adm_name='".$adm_name."'");
		if (!$operate_info) {
			$status['info'] = '操作密码未分配，请联系管理员！';
		} else if ($operate_info['password'] == '') {
			$status['info'] = '操作密码未设置！';
		} else if ($operate_info['is_effect'] != 1) {
			$status['info'] = '权限分配已失效，请联系管理员！';
		} else {
			if (!isset($_REQUEST['operatepwd']) || trim($_REQUEST['operatepwd']) == '') {
				$status['info'] = '请输入操作密码！';
			} else {
				$operatepwd = trim($_REQUEST['operatepwd']);
				if (md5(md5($operatepwd)) != $operate_info['password']) {
					$status['info'] = '操作密码错误，请重新输入！';
				} else {
					$status['status'] = 1;
				}
			}			
		}

		//检测是否有对应模块操作权限
		if ($status['status'] == 1) {
			$status['status'] = 0;
			$status['info'] = '操作权限未分配，请联系管理员！';

			if ($operate_info['modules'] != "") {
				$modules = explode(',', $operate_info['modules']);
				foreach ($modules as $k=>$v) {
					if (strtolower($module_name) == strtolower($v)) {
						$status['status'] = 1; break;
					}
				}
			}
		}

		return $status;
	}

	//系统维护模式
	public function check_system_repair_mode($module_name=MODULE_NAME) {
		$status = array('status'=>0, 'info'=>'');
		$system_repair_mode_open = $GLOBALS['db']->getOne("select value from ".DB_PREFIX."conf where name='SYSTEM_REPAIR_MODE_OPEN'");

		if ($system_repair_mode_open == 1 && $module_name != 'ExtendConf') {
			$status['info'] = '系统处于维护模式，请稍后再试！';
		} else {
			$status['status'] = 1;
		}

		return $status;
	}

	public function get_config_access_list() {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];

		if (!$adm_id) {
			$this->error(L('NO_AUTH'));
		}

		$adm_info = $GLOBALS['db']->getRow("select role_id,pid from ".DB_PREFIX."admin where id=".$adm_id);
		$role_id = $adm_info['role_id'];
		if ($role_id == 0) {
			$role_id = $GLOBALS['db']->getOne("select role_id from ".DB_PREFIX."admin where id=".$adm_info['pid']);
		}

		if (!$role_id) {
			$this->error('没有分配角色');
		} else {
			$role = $GLOBALS['db']->getRow("select is_config,pid from ".DB_PREFIX."role where is_config=1 and pid>0 and is_effect=1 and is_delete=0 and id=".$role_id);
			if ($role) {
				$role_id = $role['pid'];
			}
		}

		$config_access_list = $GLOBALS['db']->getOne("select config from ".DB_PREFIX."role where is_effect=1 and is_delete=0 and id=".$role_id);

		if ($config_access_list) {
			return unserialize($config_access_list);
		} else {
			$this->error('没有分配角色');
		}
	}

	/**
	 * 判断用户是否有某个方法的权限
	 */
	public function check_has_auth($module='',$action='') {
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = $adm_session['adm_id'];

		//管理员的SESSION
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);
		$ajax = intval($_REQUEST['ajax']);
		$is_auth = 0;

		if(intval($user_info['id'])>0) { //会员允许使用后台上传功能
			if((MODULE_NAME=='File'&&ACTION_NAME=='do_upload')||(MODULE_NAME=='File'&&ACTION_NAME=='do_upload_img')) {
				$is_auth = 1;
			}
		}

		$user_info =  es_session::get("user_info");
		
		if(intval($user_info['id'])>0) { //会员允许使用后台上传功能
			if((MODULE_NAME=='File'&&ACTION_NAME=='do_upload')||(MODULE_NAME=='File'&&ACTION_NAME=='do_upload_img')) {
				$is_auth = 1;
			}
		}
		
		if($adm_id == 0&&$is_auth==0) {			
			if($ajax == 0) {
				$this->redirect("Public/login");
			} else {
				$this->error(L("NO_LOGIN"),$ajax);
			}
		}		

		//Index模块不做权限控制
		if(MODULE_NAME=='Index') {
			$is_auth = 1;
			return;
		}

		if($adm_name != 'admin' && $is_auth==0) {
			$adm_info = $GLOBALS['db']->getRow("select role_id,pid from ".DB_PREFIX."admin where id=".$adm_id);
			$role_id = $adm_info['role_id'];
			if ($role_id == 0) {
				$role_id = $GLOBALS['db']->getOne("select role_id from ".DB_PREFIX."admin where id=".$adm_info['pid']);
			}

			if (!$role_id) {
				$this->error('没有分配角色'); exit;
			} else {
				$role = $GLOBALS['db']->getRow("select is_config,pid from ".DB_PREFIX."role where is_config=1 and pid>0 and is_effect=1 and is_delete=0 and id=".$role_id);
				if ($role) {
					$role_id = $role['pid'];
				}
			}

			$config_access_list = $GLOBALS['db']->getOne("select config from ".DB_PREFIX."role where  id=".$role_id);
			if ($config_access_list) {
				$config_access_list = unserialize($config_access_list);
			} else {
				$this->error('没有分配角色');
			}

			if ($module == '') {
				$module = MODULE_NAME;
			}
			if ($action == '') {
				$action = ACTION_NAME;
			} else if ($action == 'default') {
				$action = "[a-zA-Z0-9_]*";
			}

			foreach ($config_access_list as $k=>$v) {
				if (preg_match("/.[a-zA-Z0-9_]*\|[a-zA-Z0-9_]*\|".MODULE_NAME.'\|'.ACTION_NAME."$/", $v)) {
					$is_auth = 1; break; 
				}
			}	
		} else {
			$is_auth = 1;
		}

		if (!$is_auth) {
			$this->error(L('NO_AUTH'));
		}
	}
}
?>