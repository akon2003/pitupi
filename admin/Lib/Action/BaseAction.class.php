<?php

class BaseAction extends Action{
	//后台基础类构造
	protected $lang_pack;
	public function __construct() {
		parent::__construct();
		check_install();
		//重新处理后台的语言加载机制，后台语言环境配置于后台config.php文件
		$langSet = conf('DEFAULT_LANG');			       	
		// 定义当前语言
		define('LANG_SET',strtolower($langSet));
		 // 读取项目公共语言包
		if (is_file(LANG_PATH.$langSet.'/common.php')) {
			L(include LANG_PATH.$langSet.'/common.php');
			$this->lang_pack = require LANG_PATH.$langSet.'/common.php';
			
			if(!file_exists(APP_ROOT_PATH."public/runtime/admin/lang.js")) {
				$str = "var LANG = {";
				foreach($this->lang_pack as $k=>$lang) {
					$str .= "\"".$k."\":\"".$lang."\",";
				}
				$str = substr($str,0,-1);
				$str .="};";
				file_put_contents(APP_ROOT_PATH."public/runtime/admin/lang.js",$str);
			}
		}
		es_session::close();

		$this->write_log();
	}	

	protected function error($message,$ajax = 0) {
		if(!$this->get("jumpUrl")) {
			if($_SERVER["HTTP_REFERER"]) $default_jump = $_SERVER["HTTP_REFERER"]; else $default_jump = u("Index/main");
			$this->assign("jumpUrl",$default_jump);
		}
		parent::error($message,$ajax);
	}

	protected function success($message,$ajax = 0) {

		if(!$this->get("jumpUrl")) {
			if($_SERVER["HTTP_REFERER"]) $default_jump = $_SERVER["HTTP_REFERER"]; else $default_jump = u("Index/main");
			$this->assign("jumpUrl",$default_jump);
		}
		parent::success($message,$ajax);
	}

	protected function write_log($msg='') {
		// 添加操作人员ID
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		if ($adm_session) {
			$data['adm_id'] = $adm_session['adm_id'];
			$data['adm_name'] = $adm_session['adm_name'];
		}
		$data['login_ip'] = CLIENT_IP;
		$data['create_time'] = TIME_UTC;
		$data['module'] = MODULE_NAME;
		$data['action'] = ACTION_NAME;

		$param = $_REQUEST;
		$str = '';

		foreach ($param as $k=>$v) {
			if ($k == 'm') { continue; }
			if ($k == 'a') { continue; }
			if (preg_match("/password/i",$k)) { continue; }
			if (preg_match("/operatepwd/i",$k)) { continue; }

			if (preg_match("/^fanwe_user_/i",$k)) {
				$k = str_replace('fanwe_user_','',$k); 
			}
			if (strlen($v) > 50) { 
				$v = substr($v,0,50).' ...'; 
			}
			$str .= $k.'|'.$v.'&';
		}
		$str = rtrim($str,'&');
		$data['memo'] = $msg? $msg.'::'.$str : $str;

		$list = M('AdminVisitLog')->add($data);

		if (false == $list) {
			$this->error('系统异常');
		}
	}
}
?>