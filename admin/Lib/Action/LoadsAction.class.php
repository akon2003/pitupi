<?php

/**
 * Admin 2016-7-22 U计划与新手标用户显示按deal_id,id倒序排列
 */

class LoadsAction extends CommonAction {

    function index() {
    	$extwhere ="" ;
    	$this->getlist($extwhere);
		$this->display();
    }

    function uplan() {
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		foreach ($cate_tree as $k=>$v) {
			$cate_tree[$k]['title_show'] = str_replace("|--","",$v['title_show']);
		}
		$this->assign("cate_tree",$cate_tree);

		//借款名称
		$deal_list = M("Deal")->where(" 1=1 and ".DB_PREFIX."deal.ext='uplan' and ".DB_PREFIX."deal.deal_status in (4,5) order by id desc")->field("id,name")->findAll();
		$this->assign("deal_list",$deal_list);
		
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
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u on dl.user_id=u.id where $condition and d.ext='uplan' ORDER BY dl.id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition and d.ext='uplan' ORDER BY dl.deal_id DESC,dl.id desc limit  ".$p->firstRow . ',' . $p->listRows);
			$this->assign("list",$list);
		}
		$page = $p->show();
		$this->assign ( "page", $page );
        $this->display();
    }

    function newe() {
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		foreach ($cate_tree as $k=>$v) {
			$cate_tree[$k]['title_show'] = str_replace("|--","",$v['title_show']);
		}
		$this->assign("cate_tree",$cate_tree);

		//借款名称
		$deal_list = M("Deal")->where(" 1=1 and ".DB_PREFIX."deal.ext='newe' and ".DB_PREFIX."deal.deal_status in (4,5) order by id desc")->field("id,name")->findAll();
		$this->assign("deal_list",$deal_list);
		
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
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u on dl.user_id=u.id where $condition and d.ext='newe' ORDER BY dl.id DESC ");

		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition and d.ext='newe' ORDER BY dl.deal_id DESC,dl.id desc limit  ".$p->firstRow . ',' . $p->listRows);
			$this->assign("list",$list);
		}
		$page = $p->show();
		$this->assign ( "page", $page );
        $this->display();
    }

    function details() {
    	$extwhere ="" ;
    	$this->getlist($extwhere);
		$this->display();
    }
    
    function hand() {
    	$extwhere =" and dl.is_auto=0 " ;
    	$this->getlist($extwhere);
		$this->display("index");
    }
    
    function auto() {
    	$extwhere =" and dl.is_auto=1 " ;
    	$this->getlist($extwhere);
		$this->display("index");
    }
    
    function success() {
    	$extwhere =" and dl.is_repay=0 " ;
    	$this->getlist($extwhere);
		$this->display("index");
    }
    
    function failed() {
    	$extwhere =" and dl.is_repay=1 " ;
    	$this->getlist($extwhere);
		$this->display("index");
    }
    
	// Admin 2016/7/27
	// 增加排序功能
    private function getlist($extwhere){
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
		
		$condition = " 1=1 ";
		//开始加载搜索条件
		if(intval($_REQUEST['deal_id'])>0)
		{
			$condition .= " and dl.deal_id = ".intval($_REQUEST['deal_id']);
		}

		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
			case "rate":
			case "repay_time":
			case "loantype":
					$order ="d.".$sorder;
				break;
			case "user_name":
			case "real_name":
			case "pid":
			case "admin_id":
					$order ="u.".$sorder;
				break;
			default : 
				$order = "dl.".$sorder;
				break;
		}
		
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .= " and d.cate_id in (".implode(",",$cate_ids).")";
		}
		
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
			$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.real_name,u.pid,u.orgNo,u.admin_id,ab.bonus_rate,dl.money*ab.bonus_rate/100 as bonus_rate_count FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."admin_bonus ab on d.repay_time=ab.repay_time and d.repay_time_type=ab.repay_time_type where $condition $extwhere ORDER BY ".$order." ".$sort." limit  ".$p->firstRow . ',' . $p->listRows);
			$this->assign("list",$list);
		}
		$page = $p->show();
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		$this->assign ( "page", $page );
	}

	public function export_csv($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));

        $condition = " 1=1";
		
		if(trim($_REQUEST['name'])!='') 
        {
            $condition .= " and d.name like '%".trim($_REQUEST['name'])."%'"; 
        }
		
		if(trim($_REQUEST['c'])=='news') 
        {
            $condition .= " and d.is_new = 1"; 
        } else if(trim($_REQUEST['c'])=='newe') {
            $condition .= " and d.ext = 'newe'"; 
        }

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

		if(trim($_REQUEST['cate_id'])!=-1)
		{
            $condition .= " and d.cate_id=".intval($_REQUEST['cate_id']);
		}
		
		$begin_time  = trim($_REQUEST['begin_time'])==''?0:to_timespan($_REQUEST['begin_time']);
		$end_time  = trim($_REQUEST['end_time'])==''?0:to_timespan($_REQUEST['end_time']);
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0) {
                $condition .= " and dl.create_time >= ".$begin_time;
			} else {
                $condition .= " and dl.create_time between ".$begin_time." and ".$end_time;
            }
		}

        $list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.repay_time,d.repay_time_type,d.loantype,d.rate,d.cate_id,u.user_name,u.mobile,u.real_name,u.pid,u.orgNo,u.admin_id,dlt.name as type_name FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id =dl.deal_id LEFT JOIN ".DB_PREFIX."user u ON dl.user_id=u.id LEFT JOIN ".DB_PREFIX."deal_loan_type dlt on dlt.id=d.type_id where $condition ORDER BY dl.deal_id DESC limit ".$limit);

		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$user_value = array('id'=>'""','user_name'=>'""','real_name','refer_user_name'=>'""','admin_user_name'=>'""','mobile'=>'""','loan_money'=>'""','name'=>'""','type_name'=>'""','rate'=>'""','repay_time'=>'""','create_time'=>'""');
			if($page == 1) {
	        	$content = iconv("utf-8","gbk","编号,用户ID,姓名,推荐人,专属客服,手机号,投资金额,标题,投标类型,利率(%),借款时间,投标时间");
				$content = $content . "\n";
            }

            foreach($list as $k=>$v)
			{	
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['real_name'] = iconv('utf-8','gbk','"' . $v['real_name'] . '"');
				$user_value['refer_user_name'] = iconv('utf-8','gbk','"' . get_user_real_name($v['pid']) . '"');
				$user_value['admin_user_name'] = iconv('utf-8','gbk','"' . get_admin_real_name($v['admin_id']) . '"');
				$user_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$user_value['loan_money'] = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
				$user_value['name'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$user_value['type_name'] = iconv('utf-8','gbk','"' . $v['type_name'] . '"');
				$user_value['rate'] = iconv('utf-8','gbk','"' . $v['rate'] . '"');
				$user_value['repay_time'] = iconv('utf-8','gbk','"' . $v['repay_time'].($v['repay_time_type']==0?'天':'个月'). '"');
				$user_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
			
				$content .= implode(",", $user_value) . "\n";
			}	
			
			header("Content-Disposition: attachment; filename=投标记录.csv");
	    	echo $content;  
		}
		else
		{
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}
}
?>