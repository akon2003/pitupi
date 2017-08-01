<?php

/**
 * Admin 2016-7-22 新手标投资凭据与合同处理
 */

require_once APP_ROOT_PATH.'system/utils/tcpdf/tcpdf.php';
class toolModule extends SiteBaseModule
{
    function index() {
    	toolModule::calculate();
    }
    function load(){
    	toolModule::calculate();
    }
    function calculate(){
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['CALCULATE'].' - '.$GLOBALS['lang']['TOOLS']);
    	
    	$loantype_list = load_auto_cache("loantype_list");
    	
    	$GLOBALS['tmpl']->assign("loantype_list",$loantype_list);
    	
    	$level_list = load_auto_cache("level");
		$GLOBALS['tmpl']->assign("level_list",$level_list['list']);
    	
    	$GLOBALS['tmpl']->assign("inc_file","inc/tool/calculate.html");
		$GLOBALS['tmpl']->display("page/tool.html");
    }
    
    function ajax_calculate(){
    	
    	$act_type = intval($_REQUEST['act_type']);
    	$deal['loantype'] = intval($_REQUEST['borrowpay']);
    	$deal['borrow_amount'] = intval($_REQUEST['borrowamount']);
    	$deal['repay_time'] = intval($_REQUEST['repaytime']);
    	$deal['repay_time_type'] = intval($_REQUEST['repaytimetype']);
    	$deal['rate'] = trim($_REQUEST['apr']);
    	$deal['repay_start_time'] = to_timespan(to_date(TIME_UTC,"Y-m-d"));
    	
    	$deal_repay_rs =  deal_repay_money($deal);
    	
    	$deal['month_repay_money'] = $deal_repay_rs['month_repay_money'];
    	//总的必须还多少本息
		$deal['remain_repay_money'] = $deal_repay_rs['remain_repay_money'];
		
    	//最后一期还款
		$deal['last_month_repay_money'] = $deal_repay_rs['last_month_repay_money'];
    	
    	if($act_type==0){
    		$deal['month_manage_money'] = $deal['borrow_amount']*(float)app_conf('MANAGE_FEE')/100;
    	}
    	else{
    		$deal['month_manage_money'] = $deal['borrow_amount']*(float)app_conf('USER_LOAN_MANAGE_FEE')/100;
    	}
    	//总的多少管理费
		if($deal['repay_time_type']==1)
			$deal['all_manage_money'] = $deal['month_manage_money'] * $deal["repay_time"];
		else
			$deal['all_manage_money'] = $deal['month_manage_money'] ;
    	
    	$GLOBALS['tmpl']->assign("borrowpay",$deal['loantype']);
    	$GLOBALS['tmpl']->assign("borrowamount",$deal['borrow_amount']);
    	$GLOBALS['tmpl']->assign("apr",$deal['rate']);
    	if($deal['repay_time_type']==1)
    		$GLOBALS['tmpl']->assign("rate",$deal['rate']/12);
    	else
    		$GLOBALS['tmpl']->assign("rate",$deal['rate']/12/30);
    	
    	$GLOBALS['tmpl']->assign("repaytime",$deal['repay_time'] );
    	$GLOBALS['tmpl']->assign("repaytimetype",$deal['repay_time_type'] );
    	$GLOBALS['tmpl']->assign("repayamount",$deal['month_repay_money']);
    	$GLOBALS['tmpl']->assign("repayallamount",$deal['remain_repay_money']);
    	
    	$GLOBALS['tmpl']->assign("act_type",$act_type);
    	
    	
    	if($act_type==0){
	    	$level = intval($_REQUEST['level']);
	    	$level_list = load_auto_cache("level");
	    	$GLOBALS['tmpl']->assign("services_fee",$level_list['services_fee'][$level]/100*$deal['borrow_amount']);
    	}
    	
    	if($deal['repay_time_type']==0){
    		$inrepayshow = 0;
    	}
    	else{
    		$inrepayshow = intval($_REQUEST['inrepayshow']);
    	}
    	
    	$impose_day = intval($_REQUEST['impose_day']);
    	
    	if(isset($_REQUEST['isshow']) && intval($_REQUEST['isshow'])==1)
    	{
    		
    		$loantype = $deal['loantype'];
	    	$LoanModule = LoadLoanModule($loantype);
			$list = $LoanModule->make_repay_plan($deal);
			
			if($impose_day >= app_conf('YZ_IMPSE_DAY')){
				$impose_fee = app_conf('IMPOSE_FEE_DAY2');
				$manage_impose_fee = app_conf('MANAGE_IMPOSE_FEE_DAY2');
			}
			else{
				$impose_fee = app_conf('IMPOSE_FEE_DAY1');
				$manage_impose_fee = app_conf('MANAGE_IMPOSE_FEE_DAY1');
			}
			$left_repay_money = $deal['remain_repay_money'];
	
    		foreach($list as $k=>$v){
    			$list[$k]['impose_money'] = $v['repay_money'] * $impose_fee*$impose_day*0.01;
    			if($act_type==0){
    				$list[$k]['manage_impose_money'] = $v['repay_money'] * $manage_impose_fee*$impose_day*0.01;
    			}
    			
    			$list[$k]['left_repay_money'] = $left_repay_money = $left_repay_money - round($v['repay_money'],2);
    			
    		}
    		
    		$GLOBALS['tmpl']->assign("list",$list);
		}
		
		//提前还款
		if($inrepayshow == 1){
			
			$tq_list = array();
			$deal['compensate_fee'] = app_conf('COMPENSATE_FEE');
			if($deal['repay_time_type']==0){
				$deal['repay_time']= 1;
			}
			for($i=0;$i<$deal['repay_time'];$i++){
				$loaninfo['deal']=$deal;
				if(is_last_repay($deal['loantype'])){
					$loaninfo['deal']['month_manage_money']=$deal['all_manage_money'];
				}
				
				if($deal['repay_time_type']==1)
    				$tq_list[$i] = inrepay_repay($loaninfo,$i,next_replay_month(TIME_UTC,$i+1));
    			else
    				$tq_list[$i] = inrepay_repay($loaninfo,$i,TIME_UTC+$impose_day*24*3600);
    			
    			if(is_last_repay($deal['loantype'])){
					$tq_list[$i]['month_repay_money'] = 0;
					$tq_list[$i]['month_repay_money'] = 0;
					if($i+1 == $deal['repay_time']){
						$tq_list[$i]['manage_money'] = $deal['all_manage_money'];
						$tq_list[$i]['month_repay_money'] = $deal['last_month_repay_money'];
					}
    			}
    			else{
    				$tq_list[$i]['manage_money'] = $deal['month_manage_money'];
    				$tq_list[$i]['month_repay_money'] = $deal['month_repay_money'];
    				if($i+1 == $deal['repay_time']){
						$tq_list[$i]['month_repay_money'] = $deal['last_month_repay_money'];
					}
    			}
    		}
    		
    		$GLOBALS['tmpl']->assign("tq_list",$tq_list);
		}
		
    	$GLOBALS['tmpl']->display("inc/tool/calculate_result.html");
    }
    
	// 借款协议
    function agreement(){
    	$win = intval($_REQUEST['win']);
    	$id = intval($_REQUEST['id']);
		$credence = array();
    	
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);

		// 用户信息
		$params['user']['real_name'] = $GLOBALS['user_info']['real_name'];
		$params['user']['user_name'] = $GLOBALS['user_info']['user_name'];
		$params['user']['mobile'] = $GLOBALS['user_info']['mobile'];
		$params['user']['address'] = $GLOBALS['user_info']['address'];
		$params['user']['idno'] = $GLOBALS['user_info']['idno'];

    	if($id > 0){
   			require APP_ROOT_PATH."app/Lib/deal.php";
    		$deal = get_deal($id);
    		if($deal){
				$GLOBALS['tmpl']->assign("deal",$deal);

				// 融资名称
				$params['deal']['deal_name'] = $deal['name'];
				// 融资编号
				$params['deal']['deal_sn'] = $deal['deal_sn'];
				// 合同生效时间
				$params['deal']['valid_date'] = date('Y年m月d日',$deal['repay_start_time']);
				// 借款期限
				$params['deal']['repay_time'] = $deal['repay_time'];
				// 借款期限类型
				$params['deal']['repay_time_type'] = $deal['repay_time_type']==1? '个月':'天';
				// 起止时间
				$params['deal']['begin_time'] = date('Y年m月d日',$deal['repay_start_time']);
				if ($deal['repay_time_type'] == 1) {
                    $end_time = to_next_month($deal['repay_start_time'],$deal['repay_time']);
					$params['deal']['end_time'] = date('Y年m月d日',$end_time);
				} else {
					// 按天
					$end_time = $deal['repay_start_time'] + $deal['repay_time'] * 24 * 3600;
					$params['deal']['end_time'] = date('Y年m月d日',$end_time);
				}
				// 年利率
				$params['deal']['rate'] = sprintf("%.2f", $deal['rate']);
				// 还款类型
				$params['deal']['loan_type'] = $deal['loantype'] == 1? 2 : 1;
				// 借款用途??
				//$loantype = $GLOBALS['db']->getRow("select name FROM ".DB_PREFIX."deal_loan_type WHERE id=".$deal['loantype']);
				$params['deal']['purpose'] = $deal['sub_name'];
				// 还款日
				$params['deal']['repay_day'] = date('d',$deal['repay_start_time'] - 24*3600);

				// 融资人信息
				$deal_user_info = $GLOBALS['db']->getRow("select user_name,idno,mobile,address,real_name,orgNo FROM ".DB_PREFIX."user WHERE id=".$deal['user_id']);
				$params['deal']['deal_user']['user_name'] = $deal_user_info['user_name'];
				$params['deal']['deal_user']['real_name'] = $deal_user_info['real_name'];
				$params['deal']['deal_user']['mobile'] = $deal_user_info['mobile'];
				$params['deal']['deal_user']['idno'] = $deal_user_info['idno'];
				$params['deal']['deal_user']['orgNo'] = $deal_user_info['orgNo'];
				$params['deal']['deal_user']['address'] = $deal_user_info['address'];
				

				// 投资记录
				$deal_load_list = $GLOBALS['db']->getAll("select * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id." and user_id=".$GLOBALS['user_info']['id']." ORDER BY create_time DESC");

				$money = 0; 
				for ($i=0; $i<count($deal_load_list); $i++) {
					$money += $deal_load_list[$i]['money'];
				}
				// 利息总额
				if ($deal['repay_time_type'] == 1) {
					$rate_amount = ($deal['repay_time'] / 12) * $deal['rate'] * $money / 100;
				} else {
					$rate_amount = ($deal['repay_time'] / 360) * $deal['rate'] * $money / 100;
				}
                // 投资时间
				$params['deal']['load_time'] = date('Y年m月d日',$deal_load_list[0]['create_time']);

				// 风险管理费
				$fengxian_guanli = $money * floatval(app_conf("FENGXIAN_GUANLI_FEE"))/100;
				// 融资服务费
				$rongzi_fuwu = $money * floatval(app_conf("RONGZI_FUWU_FEE"))/100;
				// 尽职调查费
				$jinzhi_diaocha = $money * floatval(app_conf("JINZHI_DIAOCHA_FEE"))/100;
				// 合计费用
				$amount_fee = $fengxian_guanli + $rongzi_fuwu + $jinzhi_diaocha;
				// 每月利息
				if ($deal['repay_time_type'] == 1) {
					$rate_per_month = $rate_amount / $deal['repay_time'];
				} else {
					$rate_per_month = 0;
				}

				require_once APP_ROOT_PATH."system/utils/Num2Cny.php";
				// 投资金额大写格式化
				$params['load']['money_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($money));
				$params['load']['money_upper'] = Ext_Num2Cny::ParseNumber($money);
				$params['load']['money_upper_short'] = rtrim($params['load']['money_upper'],'圆整');
				// 利息总额格式化
				$params['load']['rate_amount_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($rate_amount));
				$params['load']['rate_amount_upper'] = Ext_Num2Cny::ParseNumber($rate_amount);
				// 风险管理费格式化
				$params['load']['fengxian_guanli_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($fengxian_guanli));
				$params['load']['fengxian_guanli_upper'] = Ext_Num2Cny::ParseNumber($fengxian_guanli);
				// 融资服务费格式化
				$params['load']['rongzi_fuwu_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($rongzi_fuwu));
				$params['load']['rongzi_fuwu_upper'] = Ext_Num2Cny::ParseNumber($rongzi_fuwu);
				// 尽职调查费格式化
				$params['load']['jinzhi_diaocha_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($jinzhi_diaocha));
				$params['load']['jinzhi_diaocha_upper'] = Ext_Num2Cny::ParseNumber($jinzhi_diaocha);
				// 合计费用格式化
				$params['load']['amount_fee_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($amount_fee));
				$params['load']['amount_fee_upper'] = Ext_Num2Cny::ParseNumber($amount_fee);
				// 每月利息格式化
				$params['load']['rate_per_month_lower'] = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($rate_per_month));
				$params['load']['rate_per_month_upper'] = Ext_Num2Cny::ParseNumber($rate_per_month);

    			$GLOBALS['tmpl']->assign('params',$params);

				// 借款协议模板
                if ($deal['ext'] == '') {
				    $contract_id = $GLOBALS['db']->getOne("select id FROM ".DB_PREFIX."contract WHERE title='借款协议'");
                } else if ($deal['ext'] == 'uplan') {
				    $contract_id = $GLOBALS['db']->getOne("select id FROM ".DB_PREFIX."contract WHERE title='委托投资协议'");
                } else if ($deal['ext'] == 'newe') {
                    echo "新手标无投资协议";
                    exit;
                    //新手标不打印投资协议
                }
				$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($contract_id));
				$GLOBALS['tmpl']->assign('contract',$contract);
    		}
		}

    	if($win && $GLOBALS['user_info'])
    	{
    		$GLOBALS['tmpl']->assign("win",$win);

            if ($deal['ext'] == '') {
                $params['title'] = '借款合同';
                $params['subject'] = '';
                $params['keywords'] = '';
                $params['file_name'] = '借款合同'.$deal['deal_sn'].'.pdf';
                $params['html_data'] = $contract;
                $params['font_size'] = 11;
                $params['img1'] = array('/app/Tpl/new/images/nice/jrlc.png',30, 220, 43, 43, '', 'localhost', '', true, 151);
            } else if ($deal['ext'] == 'uplan' || $deal['ext'] == 'newe') {
                $params['title'] = '委托投资协议';
                $params['subject'] = '';
                $params['keywords'] = '';
                $params['file_name'] = '委托投资协议'.$deal['deal_sn'].'.pdf';
                $params['html_data'] = $contract;
                $params['font_size'] = 11;
                $params['img1'] = array('/app/Tpl/new/images/nice/jrlc.png',30, 172, 43, 43, '', 'localhost', '', true, 151);
            }

			$this->create_pdf($params);
    		echo $GLOBALS['tmpl']->fetch("inc/tool/agreement.html");
    	}
    	else
    	{
    		$GLOBALS['tmpl']->assign("inc_file","inc/tool/agreement.html");
			$GLOBALS['tmpl']->display("page/tool.html");
    	}
    }

	// 投资凭据
	function credence(){	
    	$win = intval($_REQUEST['win']);
    	$id = intval($_REQUEST['id']);
		$credence = array();
    	
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);

		// 用户真实姓名
		$params['user']['real_name'] = $GLOBALS['user_info']['real_name'];

    	if($id > 0){
    		require APP_ROOT_PATH."app/Lib/deal.php";
    		$deal = get_deal($id);
    		if($deal){
				$GLOBALS['tmpl']->assign("deal",$deal);

				// 融资名称
				$params['deal']['deal_name'] = $deal['name'];
				// 融资编号
				$params['deal']['deal_sn'] = $deal['deal_sn'];
				// 融资人名称
				$params['deal']['deal_user'] = $GLOBALS['db']->getOne("select real_name FROM ".DB_PREFIX."user WHERE id=".$deal['user_id']);
				// 担保机构名称
				$params['deal']['agency_name'] = $GLOBALS['db']->getOne("select user_name FROM ".DB_PREFIX."user WHERE id=".$deal['agency_id']);

				// 投资记录
				$deal_load_list = $GLOBALS['db']->getAll("select * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id." and user_id=".$GLOBALS['user_info']['id']." ORDER BY create_time DESC");

				$money = 0; $create_time = $deal_load_list[0]['create_time'];
				for ($i=0; $i<count($deal_load_list); $i++) {
					$money += $deal_load_list[$i]['money'];
				}

				require_once APP_ROOT_PATH."system/utils/Num2Cny.php";
				// 投资金额大写格式化
				$money_upper = Ext_Num2Cny::ParseNumber($money);
				// 投资金额小写格式化
				$money_lower = str_replace(app_conf("CURRENCY_UNIT"),'',format_price($money));

				// 投资金额大写格式化
				$params['load']['money'] = $money_upper."（".app_conf("CURRENCY_UNIT").":".$money_lower."）";
				// 投资时间
				$params['load']['year'] = date('Y',$create_time);
				$params['load']['month'] = date('m',$create_time);
				$params['load']['day'] = date('d',$create_time);

    			$GLOBALS['tmpl']->assign('params',$params);
				
				// 投资凭据模板
                if ($deal['ext'] == '') {
	    			$contract_id = $GLOBALS['db']->getOne("select id FROM ".DB_PREFIX."contract WHERE title='投资凭证'");
                } else if ($deal['ext'] == 'uplan') {
    				$contract_id = $GLOBALS['db']->getOne("select id FROM ".DB_PREFIX."contract WHERE title='委托投资凭证'");
                } else if ($deal['ext'] == 'newe') {
    				$contract_id = $GLOBALS['db']->getOne("select id FROM ".DB_PREFIX."contract WHERE title='新手标投资凭证'");
                }
				$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($contract_id));
				$GLOBALS['tmpl']->assign('contract',$contract);
    		}
    	}

    	if($win && $GLOBALS['user_info'])
    	{
    		$GLOBALS['tmpl']->assign("win",$win);

            if ($deal['ext'] == '') {
                $params['title'] = '投资凭据';
                $params['subject'] = '';
                $params['keywords'] = '';
                $params['file_name'] = '投资凭据'.$deal['deal_sn'].'.pdf';
                $params['html_data'] = $contract;
                $params['font_size'] = 15;
				$params['cell'] = array(0, 40, "         金融理财（公章）           担保公司（公章）");
            } else if ($deal['ext'] == 'uplan' || $deal['ext'] == 'newe') {
                $params['title'] = '投资凭据';
                $params['subject'] = '';
                $params['keywords'] = '';
                $params['file_name'] = '投资凭据'.$deal['deal_sn'].'.pdf';
                $params['html_data'] = $contract;
                $params['font_size'] = 15;
				$params['cell'] = array(0, 40, "         金融理财（公章）           担保公司（公章）");
            }

			$this->create_pdf($params);
    		echo $GLOBALS['tmpl']->fetch("inc/tool/agreement.html");
    	}
    	else
    	{
    		$GLOBALS['tmpl']->assign("inc_file","inc/tool/agreement.html");
			$GLOBALS['tmpl']->display("page/tool.html");
    	}
    }

	function create_pdf($params){
		require_once APP_ROOT_PATH.'system/utils/tcpdf/tcpdf.php';

		//实例化 
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
		// 设置文档信息 
		$pdf->SetCreator('jrlc'); 
		$pdf->SetAuthor('jrlc'); 
		$pdf->SetTitle($params['title']); 
		$pdf->SetSubject($params['subject']); 
		$pdf->SetKeywords($params['keywords']); 
		 
		// 设置页眉和页脚信息 
		$pdf->SetHeaderData('logo.png', 32, '', '', array(0,64,255), array(0,64,128)); 
		$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
		 
		// 设置页眉和页脚字体 
		$pdf->setHeaderFont(Array('simsun', '', '10')); 
		$pdf->setFooterFont(Array('simsun', '', '8')); 

		// 设置默认等宽字体 
		$pdf->SetDefaultMonospacedFont('courier'); 
		 
		// 设置间距 
		$pdf->SetMargins(16.71, 18, 16.71); 
		$pdf->SetHeaderMargin(5); 
		$pdf->SetFooterMargin(10); 
		 
		// 设置分页 
		$pdf->SetAutoPageBreak(true, 10); 
		 
		// set image scale factor 
		$pdf->setImageScale(1.25); 
		 
		// set default font subsetting mode 
		$pdf->setFontSubsetting(true); 
		 
		//设置字体 
		$pdf->SetFont('simsun', '', $params['font_size']); 
		$pdf->SetHtmlLinksStyle($color=array(0,0,0), $fontstyle='U');
		$pdf->AddPage(); 

		$pdf->writeHTML($params['html_data'], true, 0, true, 0,'L');

		if (isset($params['cell'])) {
			$i = $params['cell'];
			$pdf->Cell ($i[0], $i[1], $i[2]);
		}
		if (isset($params['img1'])) {
			$i = $params['img1'];
			$pdf->Image ($i[0],$i[1],$i[2],$i[3],$i[4],$i[5],$i[6],$i[7],$i[8],$i[9]);
		}
		if (isset($params['img2'])) {
			$i = $params['img2'];
			$pdf->Image ($i[0],$i[1],$i[2],$i[3],$i[4],$i[5],$i[6],$i[7],$i[8],$i[9]);
		}

		//输出PDF 
		$pdf->Output($params['file_name'], 'I');
	}
	
    function contact(){
    	$win = intval($_REQUEST['win']);
    	$id = intval($_REQUEST['id']);
    	
    	
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);
    	
    	if($id > 0){
    		require APP_ROOT_PATH."app/Lib/deal.php";
    		$deal = get_deal($id);
    		if($deal){
    			$GLOBALS['tmpl']->assign('deal',$deal);
			
				$loan_list = $GLOBALS['db']->getAll("select * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id." ORDER BY create_time ASC");
				foreach($loan_list as $k=>$v){
					$vv_deal['borrow_amount'] = $v['money'];
					$vv_deal['rate'] = $deal['rate'];
					$vv_deal['repay_time'] = $deal['repay_time'];
					$vv_deal['loantype'] = $deal['loantype'];
					$vv_deal['repay_time_type'] = $deal['repay_time_type'];
					
					$deal_rs =  deal_repay_money($vv_deal);
					$loan_list[$k]['get_repay_money'] = $deal_rs['month_repay_money'];
					if(is_last_repay($deal['loantype']))
						$loan_list[$k]['get_repay_money'] = $deal_rs['remain_repay_money'];
					
					$loan_list[$k]['user_name'] = utf_substr($v['user_name']);
				}
				
				$GLOBALS['tmpl']->assign('loan_list',$loan_list);
				
				if($deal['user']['sealpassed'] == 1){
					$credit_file = get_user_credit_file($deal['user_id']);
					$GLOBALS['tmpl']->assign('user_seal_url',$credit_file['credit_seal']['file_list'][0]);
				}
				
				
				$GLOBALS['tmpl']->assign('SITE_URL',str_replace(array("https://","http://"),"",SITE_DOMAIN));
				$GLOBALS['tmpl']->assign('SITE_TITLE',app_conf("SITE_TITLE"));
				$GLOBALS['tmpl']->assign('CURRENCY_UNIT',app_conf("CURRENCY_UNIT"));
				
				
				$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($deal['contract_id']));
				
				
				$GLOBALS['tmpl']->assign('contract',$contract);
    		}
	   		
	    	
    	}
    	
    	if($win)
    	{
    		$GLOBALS['tmpl']->assign("win",$win);
    		echo $GLOBALS['tmpl']->fetch("inc/tool/contact.html");
    	}
    	else
    	{
    		$GLOBALS['tmpl']->assign("inc_file","inc/tool/contact.html");
			$GLOBALS['tmpl']->display("page/tool.html");
    	}
    }
	
	function dcontact(){
    	 
    	$win = 1;
    	$id = intval($_REQUEST['id']);
    	if(!$GLOBALS['user_info']){
    		echo "请先登录";exit();
    	}
    	
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);
    	
    	if($id > 0){
    		require APP_ROOT_PATH."app/Lib/deal.php";
    		$deal = get_deal($id);
    		if($deal){
    			$GLOBALS['tmpl']->assign('deal',$deal);
			
				$loan_list = $GLOBALS['db']->getAll("select * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id." ORDER BY create_time ASC");
				
				$loan_ids = array();
				foreach($loan_list as $k=>$v){
					$vv_deal['borrow_amount'] = $v['money'];
					$vv_deal['rate'] = $deal['rate'];
					$vv_deal['repay_time'] = $deal['repay_time'];
					$vv_deal['loantype'] = $deal['loantype'];
					$vv_deal['repay_time_type'] = $deal['repay_time_type'];
					
					$deal_rs =  deal_repay_money($vv_deal);
					$loan_list[$k]['get_repay_money'] = $deal_rs['month_repay_money'];
					if(is_last_repay($deal['loantype']))
						$loan_list[$k]['get_repay_money'] = $deal_rs['remain_repay_money'];
					
					$loan_list[$k]['user_name'] = utf_substr($v['user_name']);
					$loan_ids[] = $v['id'];
				}
				
				if($GLOBALS['user_info']['id'] != $deal['user_id'] || !in_array($GLOBALS['user_info']['id'],$loan_ids)){
					echo "无权限下载";exit();
				}
				
				$GLOBALS['tmpl']->assign('loan_list',$loan_list);
				
				if($deal['user']['sealpassed'] == 1){
					$credit_file = get_user_credit_file($deal['user_id']);
					$GLOBALS['tmpl']->assign('user_seal_url',$credit_file['credit_seal']['file_list'][0]);
				}
				
				
				$GLOBALS['tmpl']->assign('SITE_URL',str_replace(array("https://","http://"),"",SITE_DOMAIN));
				$GLOBALS['tmpl']->assign('SITE_TITLE',app_conf("SITE_TITLE"));
				$GLOBALS['tmpl']->assign('CURRENCY_UNIT',app_conf("CURRENCY_UNIT"));
				
				
				$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($deal['contract_id']));
				
				
				$GLOBALS['tmpl']->assign('contract',$contract);
    		}
    	}
    	
    	require APP_ROOT_PATH."/system/utils/word.php";
    	$word = new word(); 
   		$word->start(); 
   		$wordname = "借款协议.doc"; 
   		echo  $GLOBALS['tmpl']->fetch("inc/tool/contact.html");
   		$word->save($wordname); 
    }
    
	function tcontact(){
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['TT_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);
    	$win = intval($_REQUEST['win']);
    	$id = intval($_REQUEST['id']);
    	
    	if($id > 0){
    		//先执行更新借贷信息
			$deal_id = $GLOBALS['db']->getOne("SELECT deal_id FROM ".DB_PREFIX."deal_load_transfer WHERE id=".$id);
			if($deal_id==0){
				echo "不存在的债权"; die();
			}
			else{
				syn_deal_status($deal_id);
			}
			
			$condition = ' AND dlt.id='.$id.' AND d.deal_status >= 4 and d.is_effect=1 and d.is_delete=0  and d.repay_time_type =1 and  d.publish_wait=0  ';
			$union_sql = " LEFT JOIN ".DB_PREFIX."deal_load_transfer dlt ON dlt.deal_id = dl.deal_id ";
			
			
			require APP_ROOT_PATH."/app/Lib/deal_func.php";
			$transfer = get_transfer($union_sql,$condition);
			
			if($transfer){
				$GLOBALS['tmpl']->assign('transfer',$transfer);
			}
			else{
				echo "不存在的债权"; die();	
			}
			
			$GLOBALS['tmpl']->assign('SITE_URL',str_replace(array("https://","http://"),"",SITE_DOMAIN));
			$GLOBALS['tmpl']->assign('SITE_TITLE',app_conf("SITE_TITLE"));
			$GLOBALS['tmpl']->assign('CURRENCY_UNIT',app_conf("CURRENCY_UNIT"));
			
			$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($transfer['tcontract_id']));
			
			$GLOBALS['tmpl']->assign('contract',$contract);
    	}
    	
    	if($win)
    	{
    		$GLOBALS['tmpl']->assign("win",$win);
    		echo $GLOBALS['tmpl']->fetch("inc/tool/tcontact.html");
    	}
    	else
    	{
	    	$GLOBALS['tmpl']->assign("inc_file","inc/tool/tcontact.html");
			$GLOBALS['tmpl']->display("page/tool.html");
    	}
    }
    
    function dtcontact(){
    	$win = 1;
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['TT_CONTACT'].' - '.$GLOBALS['lang']['TOOLS']);
    	$id = intval($_REQUEST['id']);
    	
    	if(!$GLOBALS['user_info']){
    		echo "请先登录";exit();
    	}
    	
    	
    	if($id > 0){
    		//先执行更新借贷信息
			$deal_id = $GLOBALS['db']->getOne("SELECT deal_id FROM ".DB_PREFIX."deal_load_transfer WHERE id=".$id);
			if($deal_id==0){
				echo "不存在的债权"; die();
			}
			else{
				syn_deal_status($deal_id);
			}
			
			$condition = ' AND dlt.id='.$id.' AND d.deal_status >= 4 and d.is_effect=1 and d.is_delete=0  and d.repay_time_type =1 and  d.publish_wait=0  ';
			$union_sql = " LEFT JOIN ".DB_PREFIX."deal_load_transfer dlt ON dlt.deal_id = dl.deal_id ";
			
			
			require APP_ROOT_PATH."/app/Lib/deal_func.php";
			$transfer = get_transfer($union_sql,$condition);
			
			if($transfer){
				if($GLOBALS['user_info']['id']!=$transfer['user_id'] || $GLOBALS['user_info']['id']!=$transfer['t_user_id']){
					echo "无权限下载"; die();
				}
				$GLOBALS['tmpl']->assign('transfer',$transfer);
			}
			else{
				echo "不存在的债权"; die();	
			}
			
			$GLOBALS['tmpl']->assign('SITE_URL',str_replace(array("https://","http://"),"",SITE_DOMAIN));
			$GLOBALS['tmpl']->assign('SITE_TITLE',app_conf("SITE_TITLE"));
			$GLOBALS['tmpl']->assign('CURRENCY_UNIT',app_conf("CURRENCY_UNIT"));
			
			$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($transfer['tcontract_id']));
			
			$GLOBALS['tmpl']->assign('contract',$contract);
    	}
    	
    	require APP_ROOT_PATH."/system/utils/word.php";
    	$word = new word(); 
   		$word->start(); 
   		$wordname = "债权转让及受让协议.doc"; 
   		echo  $GLOBALS['tmpl']->fetch("inc/tool/tcontact.html");
   		$word->save($wordname); 
    }
    
    function mobile(){
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CHECK_MOBILE'].' - '.$GLOBALS['lang']['TOOLS']);
    	
    	$GLOBALS['tmpl']->assign("inc_file","inc/tool/mobile.html");
		$GLOBALS['tmpl']->display("page/tool.html");
    }
    
    function ajax_mobile(){
    	$url = "http://api.showji.com/Locating/www.showji.com.aspx?m=".trim($_REQUEST['mobile'])."&output=json&callback=querycallback";
		$content = @file_get_contents($url);
		preg_match("/querycallback\((.*?)\)/",$content,$rs);
		echo $rs[1];
    } 
    
    function ip(){
    	$GLOBALS['tmpl']->assign("page_title",$GLOBALS['lang']['T_CHECK_IP'].' - '.$GLOBALS['lang']['TOOLS']);
    	
    	$GLOBALS['tmpl']->assign("inc_file","inc/tool/ip.html");
		$GLOBALS['tmpl']->display("page/tool.html");
    }
}
?>