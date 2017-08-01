<?php

/**
 * U计划处理模块
 * deal扩展字段标记 ext='uplan'
 */

class ExtDealUplanAction extends DealAction{
	function getActionName() {
		return "Deal";
	}

    function index() {
        $this->assign("main_title", "U计划列表");
		//开始加载搜索条件
		$map['is_delete'] = 0;
		$map['ext'] = 'uplan';
		
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
		return;
    }

	function add() {
		$this->assign("new_sort", M("Deal")->where("is_delete=0")->max("sort")+1);
		
		$deal_cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$deal_cate_tree = D("DealCate")->toFormatTree($deal_cate_tree,'name');
		$this->assign("deal_cate_tree",$deal_cate_tree);

        $last_deal_sn = $GLOBALS['db']->getOne("select deal_sn from ".DB_PREFIX."deal where ext='uplan' order by id desc limit 1");
		
        if ($last_deal_sn) {
            $last_sn = 0;
            if (preg_match("/U".date('Ymd',TIME_UTC)."/", $last_deal_sn)) {
                $last_sn = intval(substr($last_deal_sn,10));
            }
    		$deal_sn = 'U'.date('Ymd',TIME_UTC).str_pad($last_sn + 1,2,0,STR_PAD_LEFT);
        } else {
            $deal_sn = 'U'.date('Ymd',TIME_UTC).'01';
        }
		
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

	public function export_csv($page = 1) {
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));

        $condition = " 1=1 and d.is_delete=0";
		
		if(trim($_REQUEST['name'])!='') {
            $condition .= " and d.name like '%".trim($_REQUEST['name'])."%'"; 
        }

		$condition .= " and d.ext='uplan' ";

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
			
			header("Content-Disposition: attachment; filename=U计划.csv");
	    	echo $content;  
		} else {
			if($page==1)
			$this->error(L("NO_RESULT"));
		}		
	}

    public function insert() {
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
			$this->error("借款编号已存在");
		}
		
		// 更新数据
		$log_info = $data['name'];
		$data['create_time'] = TIME_UTC;
		$data['update_time'] = TIME_UTC;
		$data['start_time'] = trim($data['start_time'])==''?TIME_UTC:to_timespan($data['start_time']);
		if($data['start_time'] > 0) {
			$data['start_date'] = to_date($data['start_time'],"Y-m-d");
		}
		
		if($data['uloadtype']==1){
		    if((int)$data['portion'] > 0) {
		      $data['min_loan_money'] = $data['borrow_amount'] / $data['portion'];
		    } else {
		      $data['min_loan_money'] = 0;
			}		       
		}
		
		$data['mortgage_infos'] = $this->mortgage_info();
        $data['mortgage_contract'] = $this->mortgage_info("contract");
        $data['is_effect'] = 1;
		$data['deal_status'] = 1;
        $data['publish_wait'] = 6;
		$list=M($this->getActionName())->add($data);
		if (false !== $list) {
			foreach($_REQUEST['city_id'] as $k=>$v){
				if(intval($v) > 0){
					$deal_city_link['deal_id'] =$list;
					$deal_city_link['city_id'] = intval($v);
					M("DealCityLink")->add ($deal_city_link);
				}			
			}
			
			require_once(APP_ROOT_PATH."app/Lib/common.php");
			//成功提示
			syn_deal_status($list);
			syn_deal_match($list);
			save_log("编号：$list，".$log_info.L("INSERT_SUCCESS"),1);
			$this->assign("jumpUrl",u(MODULE_NAME."/index"));
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log($log_info.L("INSERT_FAILED").$dbErr,0);
			$this->error(L("INSERT_FAILED").$dbErr);
		}
	}
}
?>