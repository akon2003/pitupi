<?php

/**
 * 个人梦想计划模块
 */

class ExtDealDreamAction extends CommonAction{
	/**
	 * 参与用户
	 */
    public function index() {
        $this->assign("main_title", "参与用户");
		//开始加载搜索条件

		$condition = " 1=1 ";	
		
		if (isset ($_REQUEST ['_order'])) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}

		switch($sorder){
			case "dream_amount":
			case "dream_count":
			case "load_money":
			case "load_count":
			case "dream_amount_end":
			case "dream_count_end":
			case "interest_money_end":
				$order = "u.id";
				break;
			case "start_time":
				$order = "d.".$sorder;
				break;
			default :
				$order = "u.".$sorder;
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

		if(trim($_REQUEST['user_name'])!='') {
			if(!isset($_REQUEST['is_user'])) {
				$is_user = 1;
			} else {
				$is_user = intval($_REQUEST['is_user']);
			}

			$user_ids = array(); $q = trim($_REQUEST['user_name']);
			if ($is_user == 1) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $user) {
						$user_ids[] = $user['id'];
					}
				}
				$condition .= " and u.id in (".implode(",",$user_ids).")";
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
				$condition .= " and u.pid in (".implode(",",$users).")";
			} else {
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
				$condition .= " and u.admin_id in (".implode(",",$adm_users).")";
			}
		}

		$dream_users = $GLOBALS['db']->getAll("SELECT distinct(d.user_id) from ".DB_PREFIX."deal_dream d left join ".DB_PREFIX."user u on d.user_id=u.id where $condition");
		foreach ($dream_users as $k=>$v) {
			$dream_users[$k] = $v['user_id'];
		}

		$count = count($dream_users);

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}

		$p = new Page ($count, $listRows);
		if($count>0){
			$condition .= " and id in (".implode(',',$dream_users).")";
			$list = $GLOBALS['db']->getAll("select u.id,u.user_name,u.real_name,u.mobile,u.pid,u.admin_id from ".DB_PREFIX."user u where $condition order by ".$order." ".$sort." limit ". $p->firstRow . ',' . $p->listRows);
			foreach ($list as $k=>&$v) {
				$v['dream_amount'] = $GLOBALS['db']->getOne("select sum(dream_amount) from ".DB_PREFIX."deal_dream where user_id=".$v['id']);
				$v['dream_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where user_id=".$v['id']);
				$v['load_money'] = $GLOBALS['db']->getOne("select sum(load_money) from ".DB_PREFIX."deal_dream where user_id=".$v['id']);
				$v['load_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream_load where user_id=".$v['id']);
				$v['start_time'] = $GLOBALS['db']->getOne("select min(create_time) from ".DB_PREFIX."deal_dream where user_id=".$v['id']);
				$v['dream_amount_end'] = $GLOBALS['db']->getOne("select sum(dream_amount) from ".DB_PREFIX."deal_dream where status in (0,3) and user_id=".$v['id']);
				$v['dream_count_end'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream where status in (0,3) and user_id=".$v['id']);
				$v['interest_money_end'] = $GLOBALS['db']->getOne("select sum(interest_money) from ".DB_PREFIX."deal_dream_load dl left join ".DB_PREFIX."deal_dream d on d.id=dl.deal_id where d.status in (0,3) and d.user_id=".$v['id']);
			}
			$this->assign("list",$list);
		}

		$page = $p->show();
		$this->assign ( "page", $page );
        $this->display();
    }


	/**
	 * 计划列表
	 */
	public function items()
	{
        $this->assign("main_title", "计划列表");
		//开始加载搜索条件
		$condition = " 1=1 and d.is_delete=0 and d.is_effect=1";
		
		if(isset($_REQUEST['name']) && trim($_REQUEST['name'])!='') {
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}

		$status = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : '-1';
		if ($status > -1) {
			$condition .= " and d.status=".$status;
		}

		if(isset($_REQUEST['user_name']) && trim($_REQUEST['user_name'])!='') {
			$q = trim($_REQUEST['user_name']);
			$condition .= " and u.user_name like '%".$q." or AES_DECRYPT(u.real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ";
		}

		/*
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 3*24*3600: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));

		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and d.create_time >= $begin_time ";	
			} else {
				$condition .= " and d.create_time between $begin_time and $end_time ";	
			}
		}*/


		if (isset ($_REQUEST ['_order'])) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		if ($sorder == "interest_money") {
			$sorder = "dream_amount";
		}
	
		switch($sorder){
			case "user_name":
			case "real_name":
				$order = "u.".$sorder;
				break;
			default :
				$order = "d.".$sorder;
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
	

		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_dream d left join ".DB_PREFIX."user u on u.id=d.user_id WHERE $condition ";
		$rs_count = $GLOBALS['db']->getOne($sql_count);

		$list = array();
		if($rs_count > 0){				
			if (isset($_REQUEST ['listRows']) && !empty($_REQUEST ['listRows'])) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ($rs_count, $listRows);
				
			$sql_list =  " select d.*,u.user_name,u.real_name from ".DB_PREFIX."deal_dream d left join ".DB_PREFIX."user u on u.id=d.user_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;

			$list = $GLOBALS['db']->getAll($sql_list);
			foreach($list as $k=>&$v){
				//计算收益
				$dream_load_list = $GLOBALS['db']->getAll("select money,create_time,interest_money from ".DB_PREFIX."deal_dream_load where deal_id=".$v['id']);
				$interest_money = 0;
				for ($i=0; $i<count($dream_load_list); $i++) {
					if ($v['status'] == 1 || $v['status'] == 2) {
						$days = interval_days($dream_load_list[$i]['create_time'], TIME_UTC);
						$money = $dream_load_list[$i]['money'];
						$interest_money += $days * $money * $v['rate'] / (100*12*30); 
					} else {
						$interest_money += $dream_load_list[$i]['interest_money']; 
					}
				}
				$v['interest_money'] = $interest_money;
			}
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


	/**
	 * 计划详情
	 */
	public function detail()
	{
		$id = intval($_REQUEST['id']);
		$dream = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_dream where id=".$id);

		$user_real_name = get_user_real_name($dream['user_id']);
		if ($user_real_name == "") {
			$user_real_name = get_user_name_only($dream['user_id']);
		}

		$main_title = "[".$user_real_name."]-梦想计划 ".$dream['name']." ".format_price($dream['dream_amount'])."元";
		$this->assign("main_title", $main_title);

		//开始加载搜索条件
		$condition = " 1=1 and deal_id=".$id;
		
		if (isset ($_REQUEST ['_order'])) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		$order = $sorder;
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}

		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_dream_load WHERE $condition ";
		$rs_count = $GLOBALS['db']->getOne($sql_count);

		$list = array();
		if($rs_count > 0){				
			if (!empty($_REQUEST ['listRows'])) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ($rs_count, $listRows);
				
			$sql_list =  " select * from ".DB_PREFIX."deal_dream_load WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;

			$list = $GLOBALS['db']->getAll($sql_list);
			foreach($list as $k=>&$v)			
			{
				$v['index'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_dream_load where id<=".$v['id']." and deal_id=".$id);
				$v['total_money'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_dream_load where deal_id=".$id." and id <= ".$v['id']);
				if ($v['status'] == 1 || $v['status'] == 2) {
					$v['space_total_days'] = interval_days($v['create_time'], TIME_UTC);
					$interest_money = $v['space_total_days'] * $v['money'] * $deal['rate'] / (100*12*30);
				} else {
					$interest_money = $v['interest_money']; 
				}
				$v['interest_money_format'] = number_format($interest_money, 3).'元';
			}

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
}

?>