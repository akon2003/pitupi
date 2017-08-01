<?php

class MyManagerAction extends CommonAction{
	private function auth(){
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		return $adm_session;
	}
	
	public function index()
	{	
		//查询部门列表
		$department_list = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 1");
		$this->assign ('department_list', $department_list );

		if (isset($_REQUEST['department_id']) && trim($_REQUEST['department_id']) != "-1") {
			$condition['pid'] = array("eq", $_REQUEST['department_id']);
		} else {
			$condition['pid'] = array("gt",0);
		}

		if (isset($_REQUEST['effect']) && trim($_REQUEST['effect']) != "-1") {
			$condition['is_effect'] = intval($_REQUEST['effect'])-1;
		} else {
			$_REQUEST['effect'] = -1;
			$condition['is_effect'] = array("gt",-1);
		}

		$condition['is_delete'] = 0;
		$condition['is_department'] = 0;
	
		if(strim($_REQUEST['adm_name'])!=""){
			$q = trim($_REQUEST['adm_name']);
			$admin_list = M("Admin")->where("adm_name like '%".$q."%' or mobile like '%".$q."%' or real_name like '%".$q."%' or email like '%".$q."%' and is_department=0")->field("id")->findAll();
			foreach ($admin_list as $key=>$value) {
				$admin_list[$key] = $value['id'];
			}
			$condition['id'] = array("in", $admin_list);
		}	

		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $condition );
		}
		
		$model = D ("Admin");
		if (! empty ( $model )) {
			$this->_list ( $model, $condition );
		}
		$list = $this->get("list");

		$this->assign("list",$list);
		$this->display ();
		return;
	}
	
	
	public function delete() {exit;
		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
			$condition = array ();
			$condition['id'] = array ('in', explode ( ',', $id ) );
			
			$adm_session = $this->auth();
			if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
				if($adm_session['is_department'] == 1){
					$condition['pid'] = $adm_session['adm_id'];
				}
			}
			
			if($adm_session['pid'] > 0 ){
				$this->error (l("NO_AUTH"));
			}
			
			$rel_data = M("Admin")->where($condition)->findAll();
			foreach($rel_data as $k=>$v){
				$info[] =$v['name'];
			}
			if($info) $info = implode(",",$info);
			$list = M("Admin")->where ( $condition )->setField ( 'is_delete', 0 );
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
	
	
	public function add() {
		$adm_session = $this->auth();
		if($adm_session['pid'] > 0){
			$this->error (l("NO_AUTH"));
		}
		
		if($adm_session['pid'] > 0){
			$condition['id'] = array("eq",$adm_session['adm_id']);
		}
		
		
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$ext = " AND id=".$adm_session['adm_id'];
				$this->assign("is_department",1);
			}
		}
		
		//查询部门列表
		$adm_sql =  " SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 1 $ext ";
		$adm_list = $GLOBALS['db']->getAll($adm_sql);
		$this->assign ( 'departs', $adm_list );
		
		
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);
		
		$this->assign ( 'adm_id', $adm_id );
		
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$extW["id"] = array("in",$adm_list[0]['role_ids']);
			}
		}
		
		$list = M("Role")->where($extW)-> findAll();
		$this->assign ( 'list', $list );
		$this->display ();
	}
	
	
	public function insert() {
		$adm_session = $this->auth();
		if($adm_session['pid'] > 0){
			$this->error (l("NO_AUTH"));
		}
		
		B('FilterString');
		$data = M("Admin")->create ();
		//开始验证有效性
		$this->assign("jumpUrl",u(MODULE_NAME."/add"));
		if(!check_empty($data['adm_name']))
		{
			$this->error(L("ADM_NAME_EMPTY_TIP"));
		}
		if(!check_empty($data['adm_password']))
		{
			$this->error(L("ADM_PASSWORD_EMPTY_TIP"));
		}
		if($data['role_id']==0)
		{
			$this->error(L("ROLE_EMPTY_TIP"));
		}
		if(M("Admin")->where("adm_name='".$data['adm_name']."'")->count()>0)
		{
			$this->error(L("ADMIN_EXIST_TIP"));
		}
		
		$adm_session = $this->auth();
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$pid = $adm_session['adm_id'];
			}
		}
		else{
			$pid = intval($_REQUEST['pid']);
		}
		
		if(intval($data['referrals_rate']) > 10){
			$this->error("提成系数不得超过10%");
		}
		
		$log_info = $data['adm_name'];
		$data['adm_password'] = md5(trim($data['adm_password']));
		$data['is_department'] = 0;
		$data['pid'] = $pid;
		$data['referrals_rate'] = floatval($data['referrals_rate']);

		if (isset($_REQUEST['sex']) && trim($_REQUEST['sex']) != "2") {
			$data['sex'] = intval($_REQUEST['sex']);
		}
		
		$list=M("Admin")->add($data);
		if (false !== $list) {
			$total = M("Admin")->where("pid=".$pid)->count();
			M("Admin")->where("id=".$pid)->setField("referrals_count",$total);
			
			//成功提示
			save_log($log_info.L("INSERT_SUCCESS"),1);
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			save_log($log_info.L("INSERT_FAILED"),0);
			$this->error(L("INSERT_FAILED"));
		}
	}
	
	public function set_effect()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M("Admin")->where("id=".$id)->getField("name");
		$c_is_effect = M("Admin")->where("id=".$id)->getField("is_effect");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M("Admin")->where("id=".$id)->setField("is_effect",$n_is_effect);
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
	
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;
	}
	
	public function edit()
	{
		$adm_session = $this->auth();
		if($adm_session['pid'] > 0){
			$id = $adm_session['adm_id'];
			$this->assign ("is_mymanager",1);
		}
		else{
			$id = intval($_REQUEST ['id']);
		}
		$condition['id'] = $id;
		$vo = M("Admin")->where($condition)->find();
		$this->assign ( 'vo', $vo );
		
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$ext = " AND id=".$adm_session['adm_id'];
				$this->assign("is_department",1);
			}
		}
		
		//查询部门列表
		$adm_sql =  " SELECT * FROM ".DB_PREFIX."admin WHERE is_delete= 0 and is_effect=1 and is_department = 1 $ext ";
		$adm_list = $GLOBALS['db']->getAll($adm_sql);
		$this->assign ( 'departs', $adm_list );
		
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$extW["id"] = array("in",$adm_list[0]['role_ids']);
			}
		}
		
		$role = M("Role")->where($extW)-> findAll();
		
		$this->assign ( 'role', $role );
	
		$this->display ();
	}
	
		
	public function update()
	{
		$data = M("Admin")->create ();
	
		if(!check_empty($data['adm_password']))
		{
			unset($data['adm_password']);  //不更新密码
		}
		else
		{
			$data['adm_password'] = md5(trim($data['adm_password']));
		}
	
		if(isset($data['role_id']) && $data['role_id']==0){
			$this->error("请选择角色");
		}
		
		if(intval($data['referrals_rate']) > 10){
			$this->error("提成系数不得超过10%");
		}
		
		$adm_session = $this->auth();
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$data['pid'] = $adm_session['adm_id'];
			}
		}
		
		if($adm_session['pid'] > 0 ){
			$data['pid'] = $adm_session['pid'];
		}

		if (isset($_REQUEST['sex']) && trim($_REQUEST['sex']) != "2") {
			$data['sex'] = intval($_REQUEST['sex']);
		}

		// 更新数据
		$list=M("Admin")->save ($data);
	
		if (false !== $list) {
			//成功提示
			$total = M("Admin")->where("pid=".$data['pid'])->count();
			M("Admin")->where("id=".$data['pid'])->setField("referrals_count",$total);
			save_log($data['name'].L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($data['name'].L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$data['name'].L("UPDATE_FAILED"));
		}
	}
	
	function export_csv($page=1){
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		$condition['is_delete'] = 0;
		
		$adm_session = $this->auth();
		if($adm_session['adm_name']!=app_conf("DEFAULT_ADMIN")){
			if($adm_session['is_department'] == 1){
				$condition['pid'] = $adm_session['adm_id'];
			}
			elseif($adm_session['pid'] > 0){
				$condition['id'] = array("eq",$adm_session['adm_id']);
			}
		}
		else{
			$condition['pid'] = array("gt",0);
		}
		
		if(strim($_REQUEST['adm_name'])!=""){
			$q = trim($_REQUEST['adm_name']);
			$admin_list = M("Admin")->where("adm_name like '%".$q."%' or mobile like '%".$q."%' or real_name like '%".$q."%' or email like '%".$q."%' and is_department=0")->field("id")->findAll();
			foreach ($admin_list as $key=>$value) {
				$admin_list[$key] = $value['id'];
			}
			$condition['id'] = array("in", $admin_list);
		}
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $condition );
		}

		$model = D ("Admin");
		
		$list = $model->where($condition)->limit($limit)->findAll();

		if($list){
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
	
			$export_value = array('id'=>'""','name'=>'""','real_name'=>'""','mobile'=>'""','email'=>'""','bumen'=>'""','role'=>'""','status'=>'""','time'=>'""','ip'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,成员ID,姓名,手机,邮箱,所属部门,所属角色,状态,最后登录时间,最后登录IP");
	
			if($page==1)
				$content = $content . "\n";
			
			foreach($list as $k=>$v)
			{
				$export_value['id'] =  iconv('utf-8','gbk','"' . $v['id'] . '"');
				$export_value['name'] = iconv('utf-8','gbk','"' . $v['adm_name'] . '"');
				$export_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$export_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$export_value['email'] = iconv('utf-8','gbk','"' . $v['email'] . '"');
				$export_value['bumen'] = iconv('utf-8','gbk','"' . get_admin_name($v['pid']) . '"');
				$export_value['role'] = iconv('utf-8','gbk','"' . M("Role")->where("id=".$v['role_id'])->getField("name") . '"');
				$export_value['status'] = iconv('utf-8','gbk','"' . ($v['is_effect']== 1 ? "有效": "无效") . '"'); 
				$export_value['time'] = iconv('utf-8','gbk','"' . to_date($v['login_time']) . '"'); 
				$export_value['ip'] = iconv('utf-8','gbk','"' . $v['login_ip'] . '"'); 				
				$content .= implode(",", $export_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=部门成员.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}		
	}

	public function referrals()
	{
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		foreach ($cate_tree as $k=>$v) {
			$cate_tree[$k]['title_show'] = str_replace("|--","",$v['title_show']);
		}
		$this->assign("cate_tree",$cate_tree);

		//借款名称
		$deal_list = M("Deal")->where(' 1=1 and '.DB_PREFIX.'deal.deal_status=4 or '.DB_PREFIX.'deal.deal_status=5 order by id desc')->field('id,name')->findAll();
		$this->assign("deal_list",$deal_list);
		
		//专属客服
		$admin_list = $GLOBALS['db']->getAll("SELECT distinct a.id,a.adm_name,a.real_name FROM ".DB_PREFIX."admin a inner join ".DB_PREFIX."user u on u.admin_id=a.id inner join ".DB_PREFIX."deal_load dl on dl.user_id=u.id");
		$this->assign("admin_list",$admin_list);

		$condition = " 1=1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0)
		{
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .= " and d.cate_id in (".implode(",",$cate_ids).")";
		}

		if(intval($_REQUEST['admin_id'])>0) {
			$admin_condition = " id=".intval($_REQUEST['admin_id']);
		} else {
			for ($i=0; $i<count($admin_list); $i++) {
				$admin_list[$i] = $admin_list[$i]['id'];
			}
			$admin_condition = " id in (".implode(",",$admin_list).")";
		}
		
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.create_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dl.create_time <= $end_time ";	
			} else {
				$condition .= " and dl.create_time between $begin_time and $end_time ";	
			}
		}
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."admin where $admin_condition ORDER BY id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."admin where $admin_condition ORDER BY id DESC limit  ".$p->firstRow . ',' . $p->listRows);
			$begin_time = $begin_time > 0? $_REQUEST['begin_time']:"-";
			$end_time = $end_time > 0? $_REQUEST['end_time']:"-";
			$deal_name = intval($_REQUEST['deal_id'])>0? M("Deal")->where("id=".intval($_REQUEST['deal_id']))->getField("name"):"全部";

			for ($i=0; $i<count($list); $i++) {
				$admin_id = $list[$i]['id'];

				$details = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.rate,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_money FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition and u.admin_id=".$admin_id);

				$users = array();
				$list[$i]['count_money'] = 0;
				$list[$i]['count_bonus_money'] = 0;
				for ($j=0; $j<count($details); $j++) {
					$users[] = $details[$j]['user_id'];
					$list[$i]['count_money'] += $details[$j]['money'];
					$list[$i]['count_bonus_money'] = $details[$j]['bonus_money'];
				}
				$list[$i]['count_users'] = count(array_flip(array_flip($users)));
				$list[$i]['begin_time'] = $begin_time;
				$list[$i]['end_time'] = $end_time;
				$list[$i]['deal_name'] = $deal_name;
			}
			$this->assign("list",$list);
		}
		$page = $p->show();
		$this->assign ( "page", $page );
		$this->display();
	}

	public function referrals_details()
	{
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		foreach ($cate_tree as $k=>$v) {
			$cate_tree[$k]['title_show'] = str_replace("|--","",$v['title_show']);
		}
		$this->assign("cate_tree",$cate_tree);

		//借款名称
		$deal_list = M("Deal")->where(' 1=1 and '.DB_PREFIX.'deal.deal_status=4 or '.DB_PREFIX.'deal.deal_status=5 order by id desc')->field('id,name')->findAll();
		$this->assign("deal_list",$deal_list);
		
		//专属客服
		$admin_list = $GLOBALS['db']->getAll("SELECT distinct a.id,a.adm_name,a.real_name FROM ".DB_PREFIX."admin a inner join ".DB_PREFIX."user u on u.admin_id=a.id inner join ".DB_PREFIX."deal_load dl on dl.user_id=u.id");
		$this->assign("admin_list",$admin_list);

		$condition = " 1=1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0)
		{
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .= " and d.cate_id in (".implode(",",$cate_ids).")";
		}

		if(intval($_REQUEST['admin_id'])>0)
		{
			$condition .= " and u.admin_id=".intval($_REQUEST['admin_id']);
		}
		
		if(trim($_REQUEST['key_words'])!='')
		{
			$q = trim($_REQUEST['key_words']);
			$t = intval($_REQUEST['key_words_type']);

			if ($t == 3) {
				//借款名称
				$condition .= " and d.name like '%".$q."%'";
			} else if ($t == 2) {
				//推荐人
				$ids = $GLOBALS['db']->getAll("select id,user_name from ".DB_PREFIX."user u where u.user_name like '%".$q."%' or u.mobile like '%".$q."%' or u.real_name like '%".$q."%'");
				if ($ids && count($ids)) {
					foreach ($ids as $k=>$v) { $ids[$k] = "'".$v['id']."'"; }
					$condition .= " and u.pid in (".implode(',', $ids).")";
				}
			} else {
				//用户名
				$ids = $GLOBALS['db']->getAll("select id from ".DB_PREFIX."user u where u.user_name like '%".$q."%' or u.mobile like '%".$q."%' or u.real_name like '%".$q."%'");
				if ($ids && count($ids)) {
					foreach ($ids as $k=>$v) { $ids[$k] = $v['id']; }
					$condition .= " and u.id in (".implode(',', $ids).")";
				}
			}			
		}
		if (!isset($_REQUEST['key_words_type'])) {
			$_REQUEST['key_words_type'] = 1;
		}
		
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.create_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dl.create_time <= $end_time ";	
			} else {
				$condition .= " and dl.create_time between $begin_time and $end_time ";	
			}
		}
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u on dl.user_id=u.id where $condition $extwhere ORDER BY dl.id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition $extwhere ORDER BY dl.id DESC limit  ".$p->firstRow . ',' . $p->listRows);
			$this->assign("list",$list);
		}
		$page = $p->show();
		$this->assign ( "page", $page );
		$this->display();
	}
	
	function export_referrals_csv($page=1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		//专属客服
		$admin_list = $GLOBALS['db']->getAll("SELECT distinct a.id,a.adm_name,a.real_name FROM ".DB_PREFIX."admin a inner join ".DB_PREFIX."user u on u.admin_id=a.id inner join ".DB_PREFIX."deal_load dl on dl.user_id=u.id");
		$this->assign("admin_list",$admin_list);

		$condition = " 1=1";

		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0)
		{
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if(intval($_REQUEST['admin_id'])>0) {
			$admin_condition = " id=".intval($_REQUEST['admin_id']);
		} else {
			for ($i=0; $i<count($admin_list); $i++) {
				$admin_list[$i] = $admin_list[$i]['id'];
			}
			$admin_condition = " id in (".implode(",",$admin_list).")";
		}

		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.create_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dl.create_time <= $end_time ";	
			} else {
				$condition .= " and dl.create_time between $begin_time and $end_time ";	
			}
		}

		$list = $GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."admin where $admin_condition ORDER BY id");
		$begin_time = $begin_time > 0? $_REQUEST['begin_time']:"-";
		$end_time = $end_time > 0? $_REQUEST['end_time']:"-";
		$deal_name = intval($_REQUEST['deal_id'])>0? M("Deal")->where("id=".intval($_REQUEST['deal_id']))->getField("name"):"全部";
		$sql = "SELECT * FROM ".DB_PREFIX."admin where $admin_condition ORDER BY id";

		for ($i=0; $i<count($list); $i++) {
			$admin_id = $list[$i]['id'];

			$details = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.rate,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_money FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition and u.admin_id=".$admin_id);

			$users = array();
			$list[$i]['count_money'] = 0;
			$list[$i]['count_bonus_money'] = 0;
			for ($j=0; $j<count($details); $j++) {
				$users[] = $details[$j]['user_id'];
				$list[$i]['count_money'] += $details[$j]['money'];
				$list[$i]['count_bonus_money'] = $details[$j]['bonus_money'];
			}
			$list[$i]['count_users'] = count(array_flip(array_flip($users)));
			$list[$i]['begin_time'] = $begin_time;
			$list[$i]['end_time'] = $end_time;
			$list[$i]['deal_name'] = $deal_name;
		}

		if($list){
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
	
			$export_value = array('id'=>'""','name'=>'""','real_name'=>'""','mobile'=>'""','email'=>'""','bumen'=>'""','role'=>'""','begin_time'=>'""','end_time'=>'""','title'=>'""','users'=>'""','money'=>'""','bonus'=>'""','status'=>'""','time'=>'""','ip'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,成员ID,姓名,手机,邮箱,所属部门,所属角色,起始时间,截止时间,标题,投资人数,投资金额,提成金额,状态,最后登录时间,最后登录IP");
	
			if($page==1)
				$content = $content . "\n";
			
			foreach($list as $k=>$v)
			{
				$export_value['id'] =  iconv('utf-8','gbk','"' . $v['id'] . '"');
				$export_value['name'] = iconv('utf-8','gbk','"' . $v['adm_name'] . '"');
				$export_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$export_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$export_value['email'] = iconv('utf-8','gbk','"' . $v['email'] . '"');
				$export_value['bumen'] = iconv('utf-8','gbk','"' . get_admin_name($v['pid']) . '"');
				$export_value['role'] = iconv('utf-8','gbk','"' . M("Role")->where("id=".$v['role_id'])->getField("name") . '"');
				$export_value['begin_time'] = iconv('utf-8','gbk','"' . $v['begin_time'] . '"');
				$export_value['end_time'] = iconv('utf-8','gbk','"' . $v['end_time'] . '"');
				$export_value['title'] = iconv('utf-8','gbk','"' . $v['deal_name'] . '"');
				$export_value['users'] = iconv('utf-8','gbk','"' . $v['count_users'] . '"');
				$export_value['money'] = iconv('utf-8','gbk','"' . $v['count_money'] . '"');
				$export_value['bonus'] = iconv('utf-8','gbk','"' . $v['count_bonus_money'] . '"');
				$export_value['status'] = iconv('utf-8','gbk','"' . ($v['is_effect']== 1 ? "有效": "无效") . '"'); 
				$export_value['time'] = iconv('utf-8','gbk','"' . to_date($v['login_time']) . '"'); 
				$export_value['ip'] = iconv('utf-8','gbk','"' . $v['login_ip'] . '"'); 				
				$content .= implode(",", $export_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=提成统计.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}		
	}

	function export_details_csv($page=1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));

		//专属客服
		$admin_list = $GLOBALS['db']->getAll("SELECT distinct a.id,a.adm_name,a.real_name FROM ".DB_PREFIX."admin a inner join ".DB_PREFIX."user u on u.admin_id=a.id inner join ".DB_PREFIX."deal_load dl on dl.user_id=u.id");
		$this->assign("admin_list",$admin_list);

		$condition = " 1=1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0)
		{
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .= " and d.cate_id in (".implode(",",$cate_ids).")";
		}

		if(intval($_REQUEST['admin_id'])>0)
		{
			$condition .= " and u.admin_id=".intval($_REQUEST['admin_id']);
		}
		
		if(trim($_REQUEST['key_words'])!='')
		{
			$q = trim($_REQUEST['key_words']);
			$t = intval($_REQUEST['key_words_type']);

			if ($t == 3) {
				//借款名称
				$condition .= " and d.name like '%".$q."%'";
			} else if ($t == 2) {
				//推荐人
				$ids = $GLOBALS['db']->getAll("select id,user_name from ".DB_PREFIX."user u where u.user_name like '%".$q."%' or u.mobile like '%".$q."%' or u.real_name like '%".$q."%'");
				if ($ids && count($ids)) {
					foreach ($ids as $k=>$v) { $ids[$k] = "'".$v['id']."'"; }
					$condition .= " and u.pid in (".implode(',', $ids).")";
				}
			} else {
				//用户名
				$ids = $GLOBALS['db']->getAll("select id from ".DB_PREFIX."user u where u.user_name like '%".$q."%' or u.mobile like '%".$q."%' or u.real_name like '%".$q."%'");
				if ($ids && count($ids)) {
					foreach ($ids as $k=>$v) { $ids[$k] = $v['id']; }
					$condition .= " and u.id in (".implode(',', $ids).")";
				}
			}
		}
	
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time'])+1*24*3600;
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.create_time >= $begin_time ";	
			} else if ($begin_time==0) {
				$condition .= " and dl.create_time <= $end_time ";	
			} else {
				$condition .= " and dl.create_time between $begin_time and $end_time ";	
			}
		}
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u on dl.user_id=u.id where $condition $extwhere ORDER BY dl.id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}

		$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.mobile,u.email,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition $extwhere ORDER BY dl.id DESC");

		for ($i=0; $i<count($list); $i++) {
			$admin_id = $list[$i]['id'];

			$details = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.rate,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_money FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition and u.admin_id=".$admin_id);

			$users = array();
			$list[$i]['count_money'] = 0;
			$list[$i]['count_bonus_money'] = 0;
			for ($j=0; $j<count($details); $j++) {
				$users[] = $details[$j]['user_id'];
				$list[$i]['count_money'] += $details[$j]['money'];
				$list[$i]['count_bonus_money'] = $details[$j]['bonus_money'];
			}
			$list[$i]['count_users'] = count(array_flip(array_flip($users)));
			$list[$i]['begin_time'] = $begin_time;
			$list[$i]['end_time'] = $end_time;
			$list[$i]['deal_name'] = $deal_name;
		}

		if($list){
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
	
			$export_value = array('id'=>'""','name'=>'""','real_name'=>'""','mobile'=>'""','email'=>'""','money'=>'""','title'=>'""','cate'=>'""','rate'=>'""','time'=>'""','status'=>'""','create_time'=>'""','recommend'=>'""','admin_id'=>'""','admin'=>'""','bonus_rate'=>'""','bonus_money'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,会员ID,会员名,手机,邮箱,投资金额,标题,投标类型,利率,借款时间,状态,投标时间,推荐人,客服ID,专属客服,提成比例,提成金额");
	
			if($page==1)
				$content = $content . "\n";
			
			foreach($list as $k=>$v)
			{
				$export_value['id'] =  iconv('utf-8','gbk','"' . $v['id'] . '"');
				$export_value['name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$export_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$export_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$export_value['email'] = iconv('utf-8','gbk','"' . $v['email'] . '"');
				$export_value['money'] = iconv('utf-8','gbk','"' . $v['money'] . '"');
				$export_value['title'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$export_value['cate'] = iconv('utf-8','gbk','"' . get_deal_cate_name($v['cate_id']) . '"');
				$export_value['rate'] = iconv('utf-8','gbk','"' . $v['rate'].'%' . '"');
				$export_value['time'] = iconv('utf-8','gbk','"' . $v['repay_time'].($v['repay_time_type'] == 1?'月':'天') . '"');
				$export_value['status'] = iconv('utf-8','gbk','"' . ($v['is_repay'] == 0?'成功':'失败') . '"');
				$export_value['create_time'] = iconv('utf-8','gbk','"' . date('Y-m-d H:i:s',$v['create_time']) . '"');
				$export_value['recommend'] = iconv('utf-8','gbk','"' . get_user_real_name($v['pid']) . '"');
				$export_value['admin_id'] = iconv('utf-8','gbk','"' . get_admin_name($v['admin_id']) . '"');
				$export_value['admin'] = iconv('utf-8','gbk','"' . get_admin_real_name($v['admin_id']) . '"');
				$export_value['bonus_rate'] = iconv('utf-8','gbk','"' . $v['bonus_rate'].'%' . '"');
				$export_value['bonus_money'] = iconv('utf-8','gbk','"' . $v['bonus_rate_count'] . '"'); 
				$content .= implode(",", $export_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=details.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	}

	function export_log_csv($page=1){		
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		$adm_session = $this->auth();
		if($adm_session['pid'] > 0 || $adm_session['is_department'] == 1){
			$this->error (l("NO_AUTH"));
		}
		
		$adm_id = intval($_REQUEST['id']);
		$start_time = strim($_REQUEST['start_time']);
		$end_time = strim($_REQUEST['end_time']);
		
		
		//列表过滤器，生成查询Map对象
		if($start_time!="" && $end_time !=""){
			$map['create_date'] = array("in",date_in($start_time,$end_time));
		}
		elseif($start_time!="" && $end_time ==""){
			$map['create_time'] = array("gt",to_timespan($start_time));
		}
		elseif($start_time=="" && $end_time !=""){
			$map['create_time'] = array("lt",to_timespan($end_time));
		}
		
	
		if($adm_id > 0)
			$map['admin_id'] = array("eq",$adm_id);
	
		
		$list = D ("AdminReferrals")->where($map)->limit($limit)->findAll();
		
		if($list){
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$header = "";
			if($page == 1)
				$header = iconv('utf-8','gbk','"奖励合计：' .  M("AdminReferrals")->where($map)->sum("money"). '"'). "\n\n";
	
			$export_value = array('id'=>'""','name'=>'""','chenyuan'=>'""','bumen'=>'""','loan_money'=>'""','money'=>'""','memo'=>'""');
			if($page == 1)
				$content = iconv("utf-8","utf-8","编号,投资会员名,部门成员,所属部门,投资金额,提成金额,备注");
	
			if($page==1)
				$content = $content . "\n";
			
			foreach($list as $k=>$v)
			{
				$export_value['id'] =  iconv('utf-8','gbk','"' . $v['id'] . '"');
				$export_value['name'] = iconv('utf-8','gbk','"' . get_user_name_reals($v['user_id']) . '"');
				$export_value['chenyuan'] = iconv('utf-8','gbk','"' . get_admin_name($v['admin_id']) . '"');
				$export_value['bumen'] = iconv('utf-8','gbk','"' . get_admin_name($v['rel_admin_id']) . '"');
				$export_value['loan_money'] = iconv('utf-8','gbk','"' . $v['loan_money'] . '"');
				$export_value['money'] = iconv('utf-8','gbk','"' . $v['money'] . '"');
				$export_value['memo'] = iconv('utf-8','gbk','"' . strip_tags($v['memo']) . '"'); 
				
				$content .= implode(",", $export_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=部门成员.csv");
			echo $header.$content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}	
	}
}
?>