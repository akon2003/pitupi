<?php

/**
 * 新手标处理模块
 * deal扩展字段标记 ext='newe'
 * 用户投资即刻生成还款计划与回款计划
 */

class ExtDealNeweAction extends DealAction{
	function getActionName() {
		return "Deal";
	}

	function index() {
        $this->assign("main_title", "新手专享");
		//开始加载搜索条件
		$map['is_delete'] = 0;
		$map['ext'] = 'newe';
		
		if(trim($_REQUEST['name'])!='') {
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}
		
		$deal_status = isset($_REQUEST['deal_status']) ? trim($_REQUEST['deal_status']) : 'all';

		if(isset($_REQUEST['is_has_received']) && trim($_REQUEST['is_has_received']) != 'all'){
			$map['is_has_received'] = array("eq",intval($_REQUEST['is_has_received']));
			$map['buy_count'] = array("gt",0);
		}
		
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],$deal_status);
		$this->display ();
	}
	
	function add() {
		$this->assign("new_sort", M("Deal")->where("is_delete=0")->max("sort")+1);
		
		$deal_cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$deal_cate_tree = D("DealCate")->toFormatTree($deal_cate_tree,'name');
		$this->assign("deal_cate_tree",$deal_cate_tree);

        $deal_sn = 'U'.date('Ymd',TIME_UTC).'04';
		
		$this->assign("deal_sn",$deal_sn);
		
		$citys = M("DealCity")->where('is_delete= 0 and is_effect=1 ')->findAll();
		$this->assign ( 'citys', $citys );
		
		$deal_agency = M("User")->where('is_effect = 1 and user_type = 2')->order('sort DESC')->findAll();
		$this->assign("deal_agency",$deal_agency);
		
		$deal_type_tree = M("DealLoanType")->findAll();
		$deal_type_tree = D("DealLoanType")->toFormatTree($deal_type_tree,'name');
		$this->assign("deal_type_tree",$deal_type_tree);
		
		$loantype_list = load_auto_cache("loantype_list");
    	$this->assign("loantype_list",$loantype_list);
    	
    	$contract_list = load_auto_cache("contract_cache");
    	$this->assign("contract_list",$contract_list);
		$this->display();
	}

    function insert() {
		//系统安全选项检测
		$this->check_safe_item();

		B('FilterString');
		$ajax = intval($_REQUEST['ajax']);
		$data = M($this->getActionName())->create ();

		//开始验证有效性
		$this->assign("jumpUrl","javascript:history.back(-1);");
		
		if(!check_empty($data['name'])) {
			$this->error(L("DEAL_NAME_EMPTY_TIP"));
		}	
		if(!check_empty($data['sub_name'])) {
			$this->error(L("DEAL_SUB_NAME_EMPTY_TIP"));
		}	
		if($data['cate_id']==0) {
			$this->error(L("DEAL_CATE_EMPTY_TIP"));
		}
		if($data['type_id']==0) {
			$this->error(L("DEAL_TYPE_EMPTY_TIP"));
		}

        if(D("Deal")->where("deal_sn='".$data['deal_sn']."'")->count() > 0){
			$this->error("编号已存在");
		}
		
		// 更新数据
		$log_info = $data['name'];
		$data['create_time'] = TIME_UTC;
		$data['update_time'] = TIME_UTC;
		$data['start_time'] = trim($data['start_time'])==''?0:to_timespan($data['start_time']);
		if($data['start_time'] > 0) {
			$data['start_date'] = to_date($data['start_time'],"Y-m-d");
		}

		$data['mortgage_infos'] = $this->mortgage_info();
        $data['mortgage_contract'] = $this->mortgage_info("contract");
		$data['min_loan_money'] = 100;
		$data['max_loan_money'] = 10000;
        $data['ext'] = 'newe';
        $data['is_new'] = 1;
        $data['is_effect'] = 1;
        $data['publish_wait'] = 0;

		$list=M($this->getActionName())->add($data);
		if (false !== $list) {
			require_once(APP_ROOT_PATH."app/Lib/common.php");
			//成功提示
			syn_deal_status($list);
			syn_deal_match($list);
			save_log("编号：$list，".$log_info.L("INSERT_SUCCESS"),1);
			$this->assign("jumpUrl",u($this->getActionName()."/index"));
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log($log_info.L("INSERT_FAILED").$dbErr,0);
			$this->error(L("INSERT_FAILED").$dbErr);
		}
	}

	public function three() {
		$this->assign("main_title","还款列表");
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
					$order ="d.".$sorder;
				break;
			case "has_repay_status":
					$order ="dl.status";
				break;
			case "site_bad_status":
					$order ="dl.is_site_bad";
				break;
			case "is_has_send":
					$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
					$order ="dl.l_key";
				break;
			default : 
				$order ="dl.".$sorder;
				break;
		}
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "ASC";
		}
		
		//开始加载搜索条件
		$condition =" 1=1 and d.ext='newe' ";
		
		if(isset($_REQUEST['status'])){
			$status = intval($_REQUEST['status']);
			if($status >0){
				if(($status-1)==0) {
					$condition .= " AND dl.has_repay=0 ";
				} else {
					$condition .= " AND dl.has_repay=1 and dl.status=".($status-2);
				}
			}
		} else{
			$condition .= " AND dl.has_repay=0 ";
			$_REQUEST['status'] = 1;
		}
		
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
		
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 3*24*3600: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.repay_time >= $begin_time ";	
			} else {
				$condition .= " and dl.repay_time between  $begin_time and $end_time ";	
			}
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
		
		if(trim($_REQUEST['name'])!='') {
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}

		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_repay_ext dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition ";
	
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay_ext dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on u.id=dl.to_user_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			
			foreach($list as $k=>$v){
				$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
				if($v['send_three_msg_time'] == $v['repay_time']){
					$list[$k]['is_has_send'] = 1;
				}
				else{
					$list[$k]['is_has_send'] = 0;
				}
				if($v['has_repay']==1){
					switch($v['status']){
						case 0;
							$list[$k]['has_repay_status'] = "提前还款";
							break;
						case 1;
							$list[$k]['has_repay_status'] = "准时还款";
							break;
						case 2;
							$list[$k]['has_repay_status'] = "逾期还款";
							break;
						case 3;
							$list[$k]['has_repay_status'] = "严重逾期";
							break;
					}
				} else{
					$list[$k]['has_repay_status'] = "<span style='color:red'>未还</span>";
				}
				
				if($v['is_site_bad'] == 1){
					$list[$k]['site_bad_status'] = "<span style='color:red'>坏账</span>";
				} else{
					$list[$k]['site_bad_status'] = "正常";
				}
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

	public function export_csv($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));

        $condition = " 1=1 and d.is_delete=0";
		
		if(trim($_REQUEST['name'])!='') 
        {
            $condition .= " and d.name like '%".trim($_REQUEST['name'])."%'"; 
        }

		$condition .= " and (d.ext='newe' or d.is_new=1) ";

        if(trim($_REQUEST['user_name'])!='')
		{
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
                $condition .= " and u.id in (".implode(',',$user_ids).")";
			} else if ($is_user == 2) {
				$users = M("User")->where("user_name like '%".$q."%' or AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' or AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') like '%".$q."%' ")->field("id")->findAll();
				if ($users && count($users)) {
					foreach ($users as $k=>$user) {
						$users[$k] = $user['id'];
					}
				}
                $condition .= " and u.pid in (".implode(',',$users).")";
			} else if ($is_user == 3){
				$adm_users = M("Admin")->where("adm_name like '%".$q."%' or real_name like '%".$q."%' or mobile like '%".$q."%' ")->field("id")->findAll();
				if ($adm_users && count($adm_users)) {
					foreach ($adm_users as $k=>$user) {
						$adm_users[$k] = $user['id'];
					}
				}
                $condition .= " and u.admin_id in (".implode(',',$adm_users).")";
			}
		}

		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time']);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
                $condition .= " and d.create_time >= ".$begin_time;
			} else {
                $condition .= " and d.create_time between ".$begin_time." and ".$end_time;
            }
		}

        $list = $GLOBALS['db']->getAll("SELECT d.*,u.user_name,u.mobile,u.real_name,u.lock_money,AES_DECRYPT(u.money_encrypt,'".AES_DECRYPT_KEY."') as money,dlt.name as type_name FROM ".DB_PREFIX."deal d  LEFT JOIN ".DB_PREFIX."user u ON d.user_id=u.id LEFT JOIN ".DB_PREFIX."deal_loan_type dlt on dlt.id=d.type_id where $condition ORDER BY d.id DESC limit ".$limit);

        if ($list) {
            foreach ($list as &$v) {
				$v['loantype'] = $v['loantype']==1?'付息还本':($v['loantype']==2?'到期还本息':'');
				$v['repay_time'] = $v['repay_time'].($v['repay_time_type']==0?'天':'月');
				$v['repay_start_time'] = $v['repay_start_time']>0? date('Y-m-d',$v['repay_start_time']) : '';

				if ($v['repay_time_type'] == 0) { // 按天
					$v['end_time'] = $v['repay_start_time']==0? 0 : $v['repay_start_time'] + $v['repay_time']*24*3600;
				} else {
					$v['end_time'] = $v['repay_start_time']==0? 0 : next_replay_month($v['repay_start_time'],$v['repay_time'],$v['repay_start_time']);;
				}
				$v['end_time'] = $v['end_time']>0? get_deal_end_repay_time($v['id']) : '';
				$v['loan_count'] = $GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."deal_load where deal_id=".$v['id']);
            }
        }

		if($list) {
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$user_value = array('id'=>'""','user_name'=>'""','real_name','mobile'=>'""','money'=>'""','lock_money'=>'""','name'=>'""','deal_sn'=>'""','borrow_amount'=>'""','is_effect'=>'""','repay_time'=>'""','rate'=>'""','loantype'=>'""','create_time'=>'""','repay_start_time'=>'""','end_time'=>'""','loan_count'=>'""');
			if($page == 1) {
	        	$content = iconv("utf-8","gbk","编号,借款客户,客户名称,手机号,可用余额,冻结金额,借款名称,合同号,借款金额,是否有效,期数,利率(%),还款方式,创建日期,放款日期,到期日期,投标数");
				$content = $content . "\n";
            }

            foreach($list as $k=>$v) {	
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$user_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$user_value['money'] = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
				$user_value['lock_money'] = iconv('utf-8','gbk','"' . number_format($v['lock_money'],2) . '"');
				$user_value['name'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$user_value['deal_sn'] = iconv('utf-8','gbk','"' . $v['deal_sn'] . '"');
				$user_value['borrow_amount'] = iconv('utf-8','gbk','"' . $v['borrow_amount'] . '"');
				$user_value['is_effect'] = iconv('utf-8','gbk','"' . ($v['is_effect']==1? '有效':'无效') . '"');
				$user_value['repay_time'] = iconv('utf-8','gbk','"' . $v['repay_time'] . '"');
				$user_value['rate'] = iconv('utf-8','gbk','"' . $v['rate'] . '"');
				$user_value['loantype'] = iconv('utf-8','gbk','"' . $v['loantype'] . '"'); // 1 付息还本 2 到期还本息
				$user_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				$user_value['repay_start_time'] = iconv('utf-8','gbk','"' . $v['repay_start_time'] . '"');
				$user_value['end_time'] = iconv('utf-8','gbk','"' . $v['end_time'] . '"');
				$user_value['loan_count'] = iconv('utf-8','gbk','"' . $v['loan_count'] . '"');
			
				$content .= implode(",", $user_value) . "\n";
			}	
			
			header("Content-Disposition: attachment; filename=新手标.csv");
	    	echo $content;  
		} else {
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}

    public function export_csv_three($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		} else{
			$sorder = "id";
		}
	
		switch($sorder){
			case "name":
			case "cate_id":
				$order ="d.".$sorder;
				break;
			case "has_repay_status":
				$order ="dl.status";
				break;
			case "site_bad_status":
				$order ="dl.is_site_bad";
				break;
			case "is_has_send":
				$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
				$order ="dl.l_key";
				break;
			default :
				$order ="dl.".$sorder;
				break;
		}
	
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else{
			$sort = "ASC";
		}
	
		//开始加载搜索条件
		$condition =" 1=1 and d.ext='newe' ";
	
		$status = intval($_REQUEST['status']);

		if($status >0){
			if(($status-1)==0)
				$condition .= " AND dl.has_repay=0 ";
			else
				$condition .= " AND dl.has_repay=1 and dl.status=".($status-2);
		}
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
	
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 3*24*3600: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
				$condition .= " and dl.repay_time >= $begin_time ";
			} else {
				$condition .= " and dl.repay_time between  $begin_time and $end_time ";
			}
		}
	
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
	
		if(trim($_REQUEST['name'])!='') {
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
	
		if(trim($_REQUEST['user_name'])!='') {
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";
		}
	
		if(intval($_REQUEST['cate_id'])>0) {
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
	
		$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay_ext dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on u.id=dl.user_id WHERE $condition  ORDER BY $order $sort LIMIT ".$limit;
		$list = $GLOBALS['db']->getAll($sql_list);

		foreach($list as $k=>$v){
			$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
			if($v['send_three_msg_time'] == $v['repay_time']){
				$list[$k]['is_has_send'] = "已发送";
			}
			else{
				$list[$k]['is_has_send'] = "未发送";
			}
			if($v['has_repay']==1){
				switch($v['status']){
					case 0: 
						$list[$k]['has_repay_status'] = "提前还款"; break;
					case 1: 
						$list[$k]['has_repay_status'] = "准时还款";
						break;
					case 2:
						$list[$k]['has_repay_status'] = "逾期还款";
						break;
					case 3:
						$list[$k]['has_repay_status'] = "严重逾期";
						break;
				}
			} else{
				$list[$k]['has_repay_status'] = "未还";
			}
	
			if($v['is_site_bad'] == 1){
				$list[$k]['site_bad_status'] = "坏账";
			} else{
				$list[$k]['site_bad_status'] = "正常";
			}
			$list[$k]['cate_id'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$list[$k]['cate_id']);
			
		}

		if($list) {
			register_shutdown_function(array(&$this, 'export_csv_three'), $page+1);
	
			$three_value = array('id'=>'""','name'=>'""','l_key_index'=>'""','user_name'=>'""','mobile'=>'""','repay_money'=>'""','manage_money'=>'""','impose_money'=>'""','manage_impose_money'=>'""','repay_time'=>'""','cate_id'=>'""','has_repay_status'=>'""','site_bad_status'=>'""','is_has_send'=>'""');
			if($page == 1){
				$content = iconv("utf-8","gbk","编号,借款名称,第几期,借款人,手机号码,还款金额,管理费,逾期费用,逾期管理费用,还款日,投标类型,还款状态 ,账单状态,发送提示");
				$content = $content . "\n";
			}
	
			foreach($list as $k=>$v) {
				$three_value = array();
				$three_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$three_value['name'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$three_value['l_key_index'] = iconv('utf-8','gbk','"' . $v['l_key_index'] . '"');
				$three_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$three_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$three_value['repay_money'] = iconv('utf-8','gbk','"'.format_price($v['repay_money']).'"');
				$three_value['manage_money'] = iconv('utf-8','gbk','"' . format_price($v['manage_money']) . '"');
				$three_value['impose_money'] = iconv('utf-8','gbk','"' . format_price($v['impose_money']) . '"');
				$three_value['manage_impose_money'] = iconv('utf-8','gbk','"'.format_price($v['manage_impose_money']).'"');
				$three_value['repay_time'] = iconv('utf-8','gbk','"' .  to_date($v['repay_time'],"Y-m-d"). '"');
				$three_value['cate_id'] = iconv('utf-8','gbk','"' . $list[$k]['cate_id'] . '"');
				$three_value['has_repay_status'] = iconv('utf-8','gbk','"' . $v['has_repay_status'] . '"');
				$three_value['site_bad_status'] = iconv('utf-8','gbk','"' . $v['site_bad_status'] . '"');
				$three_value['is_has_send'] = iconv('utf-8','gbk','"' . $v['is_has_send'] . '"');
				$content .= implode(",", $three_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=新手标_还款计划.csv");
			echo $content;
		} else {
			if($page==1) {
				$this->error(L("NO_RESULT"));
			}
		}	
	}
}
?>