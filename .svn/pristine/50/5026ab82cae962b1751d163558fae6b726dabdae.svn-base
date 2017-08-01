<?php

/**
 * 增加用户登录日志
 * Admin 2016/7/30
 */
class LogAction extends CommonAction{
	public function index()
	{
		if(trim($_REQUEST['log_info'])!='')
		{
			$map['log_info'] = array('like','%'.trim($_REQUEST['log_info']).'%');			
		}
		
		$log_begin_time  = trim($_REQUEST['log_begin_time'])==''?0:to_timespan($_REQUEST['log_begin_time']);
		$log_end_time  = trim($_REQUEST['log_end_time'])==''?0:to_timespan($_REQUEST['log_end_time']);
		if($log_end_time==0)
		{
			$map['log_time'] = array('gt',$log_begin_time);	
		}
		else
		$map['log_time'] = array('between',array($log_begin_time,$log_end_time));	
		
		
		$this->assign("default_map",$map);
		parent::index();
	}

	/**
	 * 增加用户登录日志
	 * Admin 2016/7/30
	 * 记录用户正常登录/错误登录和正常退出状态
	 */
	public function user_login_log() {
		$this->assign("main_title", "用户登录日志");
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_name":
			case "real_name":
			case "mobile":
				$order ="u.".$sorder;
				break;
			default : 
				$order ="ull.".$sorder;
				break;
		}
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
	
		//开始加载搜索条件
		$condition =" 1=1 ";

		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and ull.create_time >= $begin_time ";	
			}
			else
			{
				$condition .= " and ull.create_time between $begin_time and $end_time ";	
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");

		if(trim($_REQUEST['user_name'])!='')
		{
			$q = trim($_REQUEST['user_name']);
			$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
			if ($users && count($users)) {
				foreach ($users as $user) {
					$user_ids[] = $user['id'];
				}
			}
			$condition .= " and u.id in (".implode(',', $user_ids).")";	
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."user_login_log ull LEFT JOIN ".DB_PREFIX."user u ON ull.user_id=u.id WHERE $condition ";

		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT ull.*,u.user_name,u.real_name,u.mobile FROM ".DB_PREFIX."user_login_log ull LEFT JOIN ".DB_PREFIX."user u ON ull.user_id=u.id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);

			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display ();
	}

	public function foreverdelete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		
		$condition = array ("log_time" => array("lt",next_replay_month(TIME_UTC,-6)) );			
		
		$list = M(MODULE_NAME)->where ( $condition )->delete();
		if ($list!==false) {
			save_log("清除半年前的记录",1);
			$this->success (l("FOREVER_DELETE_SUCCESS"),$ajax);
		} else {
			save_log("清除半年前的记录",0);
			$this->error (l("FOREVER_DELETE_FAILED"),$ajax);
		}
			
	}
	
	
}
?>