<?php

/** 
 * deal_func.php 扩展
 * 
 * 此文件添加基于 deal_func.php 函数的扩展
 *
 * @author Admin 
 * Date: 2016-7-19
 *
 * 添加自动发送还款信息提醒
 * Date: 2016-7-25
 *
 * 以下为上海助通信息
 * 相同的手机号码信息发送时间间隔最好在2-3分钟以上
 * 群发不受发送时间间隔的影响
 * Admin 2016-7-25
 */ 

require_once 'deal_func.php';

/**
 * 服务端自动处理地址格式化
 * @param string $url 被格式化地址
 * @param string $from 被替换内容
 * @param string $to 替换内容
 * @param string $domain_from 被替换地址
 * @param string $domain_to 替换地址
 * @return string 格式化之后的地址
 */
function auturunUrlFormat($url,$from=null,$to='',$domain_from='',$domain_to='') {
    $str = '';
    if ($from == null) {
        $from = array('/services\\Auturun\//i','/services\/Auturun\//i');
    }
    if (is_array($from)) {
        foreach ($from as $v) {
            $str = preg_replace($v,$to,$url);
        }
    } else {
        $str = preg_replace($v,$to,$url);
    }

    if ($domain_from != '') {
        $str = str_replace($domain_from, $domain_to, $str);
    }
    return $str;
}

/**
 * 自动还款处理函数
 * 遍历还款计划表 deal_repay
 * 调用自动还款处理函数 getUcRepayBorrowMoneyAuto
 * Admin 2016-07-22
 */
function autoRepayBorrowMoney() {
	$status = array('status'=>0, 'info'=>'');

	//获取当日需要还款的标
    $deal_repay_info = $GLOBALS['db']->getAll("select id,deal_id,user_id,l_key from ".DB_PREFIX."deal_repay where has_repay=0 and repay_date = '".date('Y-m-d',TIME_UTC)."' order by id");

	if (!$deal_repay_info) {
		$status['info'] = '当前没有要还款的标';
		return $status;
	}

    $status['status'] = 1;

    foreach ($deal_repay_info as $info) {
        $id = $info['deal_id'];
        $ids = $info['l_key'];
        $user_id = $info['user_id'];

        $state = getUcRepayBorrowMoneyAuto($id,$ids,$user_id);

        if ($state['status'] == 1) {
            $status['info'] .= "标的{$id}[{$user_id}--{$to_user_id} {$repay_date}] ".date('H:i:s', TIME_UTC)." 还款成功<br/>";
        } else if ($status['status'] == 0) {
            $status['info'] .= "标的{$id}[{$user_id}--{$to_user_id} {$repay_date}] ".date('H:i:s', TIME_UTC)." 还款失败<br/>";
        }
    }
    return $status;
}

/**
 * 新手标自动还款处理函数
 * 遍历新手标还款计划表 deal_repay_ext
 * 调用新手标自动还款处理函数 getUcRepayBorrowMoneyAutoExt
 * Admin 2016-07-19
 */
function autoRepayBorrowMoneyExt() {
	$status = array('status'=>0, 'info'=>'');

	//获取当日需要还款的标
	$deal_repay_info = $GLOBALS['db']->getAll("select id,deal_id,user_id,to_user_id,l_key from ".DB_PREFIX."deal_repay_ext where has_repay=0 and repay_date = '".date('Y-m-d',TIME_UTC)."' order by id");
	if (!$deal_repay_info) {
		$status['info'] = '当前没有要还款的标';
		return $status;
	}

    $status['status'] = 1;

    foreach ($deal_repay_info as $info) {
        $id = $info['deal_id'];
        $ids = $info['l_key'];
        $user_id = $info['user_id'];
        $to_user_id = $info['to_user_id'];
        $repay_date = date('Y-m-d',TIME_UTC);
        if (!$to_user_id) { continue; }

        $state = getUcRepayBorrowMoneyAutoExt($id,$ids,$user_id,$to_user_id,$repay_date);

        if ($state['status'] == 1) {
            $status['info'] .= "标的{$id}[{$user_id}--{$to_user_id} {$repay_date}] ".date('H:i:s', TIME_UTC)." 还款成功<br/>";
        } else if ($status['status'] == 0) {
            $status['info'] .= "标的{$id}[{$user_id}--{$to_user_id} {$repay_date}] ".date('H:i:s', TIME_UTC)." 还款失败<br/>";
        }
    }
    return $status;
}

/**
 * 自动发送还款信息函数
 * 调用信息发送处理函数 sendRepayMoneySmsAuto,sendRepayMoneySmsAutoExt
 * Admin 2016-7-24
 */
function autoRepaySms() {
	$status = array('status'=>1, 'info'=>'');

    $days_conf = $GLOBALS['db']->getOne(" SELECT value FROM ".DB_PREFIX."conf WHERE name='SMS_SEND_REPAY_NOTICE'");	
    $days = explode(',',$days_conf);

    foreach ($days as $day) {
    	
        $deal_ids = sendRepayMoneySmsAuto($day);
        if (count($deal_ids)) {
            $status['info'] .= '['.$day.'天借款短信提醒] 借款用户编号:['.implode(',',$deal_ids).']\r\n';
        } else {
            $status['info'] .= '['.$day.'天借款短信提醒] 没有满足条件的借款\r\n';
        }

        //U计划与新手标还款提醒
        $deal_ids = sendRepayMoneySmsAutoExt($day);
        if (count($deal_ids)) {
            $status['info'] .= '['.$day.'天借款短信提醒] 借款用户编号:['.implode(',',$deal_ids).']\r\n';
        } else {
            $status['info'] .= '['.$day.'天借款短信提醒] 没有满足条件的借款\r\n';
        }
    }

    return $status;
}

/** 
* 基于函数getUcRepayBorrowMoney修改
* 对标的url格式化修改,用于生成可以正常访问的链接地址
* Admin 2016-07-18
* 修改url格式化调用函数处理
* Admin 2016-7-25
*/  
function getUcRepayBorrowMoneyAuto($id,$ids,$user_id=0){
	$id = intval($id);
	$root = array();
	$root["status"] = 0;//0:出错;1:正确;
		
	if($id == 0){
		$root["show_err"] = "操作失败！";
		return $root;
	}

    $deal = get_deal($id);

	if(!$deal)
	{
		$root["show_err"] = "借款不存在！";
		return $root;
	}
	if($deal['ips_bill_no']!=""){
		$root["status"] = 2;
		$root["jump"] = APP_ROOT.'/index.php?ctl=collocation&act=RepaymentNewTrade&deal_id='.$deal['id'].'&l_key='.$ids."&from=".$GLOBALS['request']['from'];
		$root['jump'] = str_replace("/mapi", "", $site_domain.$root['jump']);
		return $root;
	}

    //移除自动化还款处理url格式化
    $deal['url'] = auturunUrlFormat($deal['url']);
    $deal['share_url'] = auturunUrlFormat($deal['share_url']);
    $deal['app_url'] = auturunUrlFormat($deal['app_url']);
    $deal['user']['url'] = auturunUrlFormat($deal['user']['url']);

	if($user_id > 0){
		$GLOBALS['user_info'] = get_user("*",$user_id);
	}
	
	if($deal['user_id']!=$GLOBALS['user_info']['id']){
		$root["show_err"] = "不属于你的借款！";
		return $root;
	}
	if($deal['deal_status']!=4){
		$root["show_err"] = "借款不是还款状态！";
		return $root;
	}
	
	$ids = explode(",",$ids);
	
	//当前用户余额
	$user_total_money = (float)$GLOBALS['user_info']['money'];
	
	if($user_total_money<= 0){
		$root["show_err"] = "余额不足";
		return $root;
	}
	
	$last_repay_key = -1;
	require_once APP_ROOT_PATH.'system/libs/user.php';

	foreach($ids as $lkey){
		//还了多少人
		$repay_user_count = 0;
		//多少人未还
		$no_repay_user_count =0;
		//还了多少本息
		$repay_money = 0;
		//还了多少逾期罚息
		$repay_impose_money = 0;
		//还了多少管理费
		$repay_manage_money = 0;
        //还了多少抵押管理费
        $mortgage_fee = 0;
		//还了多少逾期管理费
		$repay_manage_impose_money = 0;
		
		//用户回款 get_deal_user_load_list($deal_info, $user_id = 0 ,$lkey = -1 , $ukey = -1,$true_time=0,$get_type = 0, $r_type = 0, $limit = "")
		$user_loan_list = get_deal_user_load_list($deal, 0 , $lkey , -1 , 0 , 1);
		//如果已收取管理费
		$get_manage = $GLOBALS['db']->getOne("SELECT get_manage FROM ".DB_PREFIX."deal_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey."  ");

		//===============还款================
		foreach($user_loan_list as $lllk=>$lllv){
			foreach($lllv as $kk=>$vv){
				if($vv['has_repay']==0 ){//借款人已还款，但是没打款到借出用户中心
					$user_load_data = array();

					$user_load_data['true_repay_time'] = TIME_UTC;
					$user_load_data['true_repay_date'] = to_date(TIME_UTC);
					$user_load_data['is_site_repay'] = 0;
					$user_load_data['status'] = 0;
						
					$user_load_data['true_repay_money'] = (float)$vv['month_repay_money'];
					$user_load_data['true_self_money'] = (float)$vv['self_money'];
					$user_load_data['true_interest_money'] = (float)$vv['interest_money'];
					$user_load_data['true_manage_money'] = (float)$vv['manage_money'];
					$user_load_data['true_manage_interest_money'] = (float)$vv['manage_interest_money'];
					$user_load_data['true_repay_manage_money'] = (float)$vv['repay_manage_money'];
					$user_load_data['true_manage_interest_money_rebate'] = (float)$vv['manage_interest_money_rebate'];
					$user_load_data['impose_money'] = (float)$vv['impose_money'];
					$user_load_data['repay_manage_impose_money'] = (float)$vv['repay_manage_impose_money'];
					$user_load_data['true_reward_money'] = (float)$vv['reward_money'];
                    $user_load_data['true_mortgage_fee'] = (float)$vv['mortgage_fee'];
					
					$need_repay_money = 0;
					if($get_manage==0)
						$need_repay_money += $user_load_data['true_repay_money']  + $user_load_data['impose_money'] + $user_load_data['true_repay_manage_money'] + $user_load_data['repay_manage_impose_money'] + $user_load_data['mortgage_fee'];
					else
						$need_repay_money += $user_load_data['true_repay_money']  + $user_load_data['impose_money'] + $user_load_data['repay_manage_impose_money'] + $user_load_data['mortgage_fee'];
					//=============余额足够才进行还款=================
					if((float)$need_repay_money <= $user_total_money){
						$last_repay_key = $lkey;
						$repay_user_count +=1;
						$repay_money +=$user_load_data['true_repay_money'];
						$repay_impose_money += $user_load_data['impose_money'];
						$repay_manage_money += $user_load_data['true_repay_manage_money'];
						$repay_manage_impose_money += $user_load_data['repay_manage_impose_money'];
						$user_total_money = $user_total_money - $need_repay_money;
                        $mortgage_fee+= $user_load_data['true_mortgage_fee'];
						
						if($vv['status']>0)
							$user_load_data['status'] = $vv['status'] - 1;
							
						$user_load_data['has_repay'] = 1;
						if($get_manage == 1){
							unset($user_load_data['true_repay_manage_money']);
						}

						$GLOBALS['db']->autoExecute(DB_PREFIX."deal_load_repay",$user_load_data,"UPDATE","id=".$vv['id']."  AND has_repay = 0  ","SILENT");
					
						if($GLOBALS['db']->affected_rows() > 0){
			
							$unext_loan = $user_loan_list[$vv['u_key']][$kk+1];
							
							
							$load_repay_rs = $GLOBALS['db']->getOne("SELECT (sum(true_interest_money) + sum(impose_money)) as shouyi,sum(impose_money) as total_impose_money FROM ".DB_PREFIX."deal_load_repay WHERE deal_id=".$deal['id']." AND user_id=".$vv['user_id']);
							$all_shouyi_money= number_format($load_repay_rs['shouyi'],2);
							$all_impose_money = number_format($load_repay_rs['total_impose_money'],2);
								
							
							if($user_load_data['impose_money'] !=0 || $user_load_data['true_manage_money'] !=0 || $user_load_data['true_repay_money']!=0){
								$in_user_id  = $vv['user_id'];
								//如果是转让债权那么将回款打入转让者的账户
								if((int)$vv['t_user_id']== 0){
									$loan_user_info['user_name'] = $vv['user_name'];
									$loan_user_info['email'] = $vv['email'];
									$loan_user_info['mobile'] = $vv['mobile'];
								}
								else{
									$in_user_id = $vv['t_user_id'];
									$loan_user_info['user_name'] = $vv['t_user_name'];
									$loan_user_info['email'] = $vv['t_email'];
									$loan_user_info['mobile'] = $vv['t_mobile'];
								}
			
								//更新用户账户资金记录
								modify_account(array("money"=>$user_load_data['true_repay_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,回报本息",5);
								
								if($user_load_data['true_manage_money'] > 0)
									modify_account(array("money"=>-$user_load_data['true_manage_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,投标管理费",20);
                                
								//利息管理费
								if($user_load_data['true_manage_interest_money'] > 0)
								    modify_account(array("money"=>-$user_load_data['true_manage_interest_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,投标利息管理费",20);
								
								if($user_load_data['impose_money'] != 0)
									modify_account(array("money"=>$user_load_data['impose_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,逾期罚息",21);
								
								//投资者奖励
								if($user_load_data['true_reward_money']!=0){
									modify_account(array("money"=>$user_load_data['true_reward_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,奖励收益",28);
								}
								
								//普通会员邀请返利
								get_referrals($vv['id']);
								
								//投资者返佣金
								if($user_load_data['true_manage_interest_money_rebate'] !=0){
									/*ok*/
									$reback_memo = sprintf($GLOBALS['lang']["INVEST_REBATE_LOG"],$deal["url"],$deal["name"],$loan_user_info["user_name"],intval($vv["l_key"])+1);
									reback_rebate_money($in_user_id,$user_load_data['true_manage_interest_money_rebate'],"invest",$reback_memo);
								}

                                //短信通知回款
								$loan_user_info['id'] = $in_user_id;
								send_repay_reback_sms_mail($deal,$loan_user_info,$unext_loan,$user_load_data,$all_shouyi_money,$all_impose_money);
							}
						}
					}
					
					//=============余额足够才进行还款=================
				}
			}
		}
		//===============还款================
		
		if($repay_user_count > 0){
			//判断当前期是否还款完毕
			$true_repay_count = $GLOBALS['db']->getOne("SELECT count(*)  FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay=1 ");
		
			$ext_str= "";
			if($true_repay_count<>$repay_user_count){
				$ext_str="[部分]";
			}
			//更新用户账户资金记录
			modify_account(array("money"=>-$repay_money),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,偿还本息$ext_str",4);
			if($repay_impose_money!=0)
				modify_account(array("money"=>-$repay_impose_money),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,逾期罚息$ext_str",11);
			
			if($repay_manage_money > 0 && $get_manage == 0)
				modify_account(array("money"=>-$repay_manage_money),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,借款管理费$ext_str",10);
			
			if($mortgage_fee > 0)
                modify_account(array("money"=>-$mortgage_fee),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,抵押物管理费$ext_str",27);
            
			if($repay_manage_impose_money!=0 )
				modify_account(array("money"=>-$repay_manage_impose_money),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,逾期管理费$ext_str",12);
			
			$rebate_rs = get_rebate_fee($GLOBALS['user_info']['id'],"borrow");
			$true_manage_money_rebate = $repay_manage_money* floatval($rebate_rs['rebate'])/100;
			//借款者返佣
			if($true_manage_money_rebate!=0){
				/*ok*/
				$reback_memo = sprintf($GLOBALS['lang']["BORROW_REBATE_LOG"],$deal["url"],$deal["name"],$deal["user"]["user_name"],intval($kk)+1);
				reback_rebate_money($GLOBALS['user_info']['id'],$true_manage_money_rebate,"borrow",$reback_memo);
			}
		}
		
		$r_msg = "会员还款$ext_str";
		if($repay_money > 0){
			$r_msg .=",本息：".format_price($repay_money);
		}
		if($repay_impose_money> 0){
			$r_msg .=",逾期费用：".format_price($repay_impose_money);
		}
		if($repay_manage_money > 0 && $get_manage == 0){
			$r_msg .=",管理费：".format_price($repay_manage_money);
		}
        if($mortgage_fee > 0){
            $r_msg .=",抵押物管理费：".format_price($mortgage_fee);
        }
		if($repay_manage_impose_money > 0){
			$r_msg .=",逾期管理费：".format_price($repay_manage_impose_money);
		}
		$repay_id = $GLOBALS['db']->getOne("SELECT id  FROM ".DB_PREFIX."deal_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey);
		repay_log($repay_id,$r_msg,$GLOBALS['user_info']['id'],0);
		
		
		//$content = "您好，您在".app_conf("SHOP_TITLE")."的借款 “<a href=\"".$deal['url']."\">".$deal['name']."</a>”的借款第".($lkey+1)."期还款".number_format(($repay_money+$repay_impose_money+$repay_manage_money+$repay_manage_impose_money),2)."元，";
		//如果还款完毕
		$sms_ext_str = "成功";
		if($left_user_count = $GLOBALS['db']->getOne("SELECT count(*)  FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay = 0 ") == 0){
			//$content .="本期还款完毕。";
			$notices['repay_status'] = "本期还款完毕";
			$impose_rs = $GLOBALS['db']->getRow("SELECT sum(true_self_money) as total_self_money,sum(true_interest_money) as total_interest_money,sum(true_repay_money) as total_repay_money,sum(impose_money) as total_impose_money,sum(true_repay_manage_money) as total_repay_manage_money,sum(repay_manage_impose_money) as total_repay_manage_impose_money,sum(true_mortgage_fee) as total_mortgage_fee  FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay = 1");
			//判断是否逾期
			$repay_update_data['has_repay'] = 1;
			$repay_update_data['true_repay_time'] = TIME_UTC;
			$repay_update_data['true_repay_date'] = to_date(TIME_UTC);
			$repay_update_data['true_repay_money'] = floatval($impose_rs['total_repay_money']);
			$repay_update_data['true_self_money'] =  floatval($impose_rs['total_self_money']);
			$repay_update_data['true_interest_money'] =  floatval($impose_rs['total_interest_money']);
			$repay_update_data['impose_money'] =floatval($impose_rs['total_impose_money']);
			if($get_manage == 0){
				$repay_update_data['true_manage_money'] =floatval($impose_rs['total_repay_manage_money']);
			}
			
			$repay_update_data['true_mortgage_fee'] =floatval($impose_rs['total_mortgage_fee']);
			
			$repay_update_data['manage_impose_money']=floatval($impose_rs['total_repay_manage_impose_money']);
			
			//返佣金额
			$rebate_rs = get_rebate_fee($GLOBALS['user_info']['id'],"borrow");
			$repay_update_data['true_manage_money_rebate'] =floatval($impose_rs['total_repay_manage_money']) * floatval($rebate_rs['rebate'])/100;
			
			if($vv['impose_day'] > 0){
				
				//VIP降级-逾期还款
				$type = 2;
				$type_info = 5;
				$resultdate = syn_user_vip($GLOBALS['user_info']['id'],$type,$type_info);
				
				if($vv['impose_day'] < app_conf('YZ_IMPSE_DAY')){
					modify_account(array("point"=>trim(app_conf('IMPOSE_POINT'))),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,逾期还款",11);
					$repay_update_data['status'] = 2;
				}
				else{
					modify_account(array("point"=>trim(app_conf('YZ_IMPOSE_POINT'))),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($kk+1)."期,严重逾期",11);
					$repay_update_data['status'] = 3;
				}
			}
			elseif(TIME_UTC<=((int)$vv['repay_day'] + 24*3600-1)){
				$repay_update_data['status'] = 1;
				
				//VIP升级 -正常还款
				$type = 1;
				$type_info = 3;
				$resultdate = syn_user_vip($GLOBALS['user_info']['id'],$type,$type_info);
			}
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_repay",$repay_update_data,"UPDATE","deal_id = ".$deal['id']." and l_key=".$lkey);
			
			$notices['has_next_loan'] = 0;
			if($next_loan =$GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."deal_repay WHERE deal_id=".$deal['id']." and l_key > ".$last_repay_key." ORDER BY  l_key ASC")){
				//$content .= "本笔借款的下个还款日为".to_date($next_loan['repay_day'],"Y年m月d日")."，需要本息".number_format($next_loan['repay_money'],2)."元。";
				$notices['has_next_loan'] = 1;
				$notices['next_repay_time'] = to_date($next_loan['repay_time'],"Y年m月d日");
				$notices['next_repay_money'] = number_format($next_loan['repay_money'],2);
			}
		}
		else{
			//$content .="本期部分还款，还有".$left_user_count."个投资人待还。";
			$notices['repay_status'] = "本期部分还款";
			$notices['left_user_count'] = $left_user_count;
			$sms_ext_str = "部分";
			$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_repay SET has_repay = 2 WHERE deal_id = ".$deal['id']." and l_key=".$lkey);
		}
		
		//您好，您在{$notice.shop_title}的借款{$notice.url}的借款第{$notice.key}期还款{$notice.money}元
		
		$notices['site_title'] = app_conf("SHOP_TITLE");
		$notices['url'] =  "“<a href=\"".$deal['url']."\">".$deal['name']."</a>”";
		$notices['index'] =  ($lkey+1);
		$notices['repay_money'] = ($repay_money+$repay_impose_money+$repay_manage_impose_money);
		if($get_manage == 0){
			$notices['repay_money'] = number_format($notices['repay_money'] + $repay_manage_money,2);
		}
		else{
			$notices['repay_money'] = number_format($notices['repay_money'],2);
		}
        
        $notices['repay_money'] += $mortgage_fee;
		
		$tmpl_contents = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_REPAY_MONEY_MSG'",false);
		$GLOBALS['tmpl']->assign("notice",$notices);
		$content = $GLOBALS['tmpl']->fetch("str:".$tmpl_contents['content']);
		
		send_user_msg("",$content,0,$GLOBALS['user_info']['id'],TIME_UTC,0,true,8);
		unset($notices);
		
		//短信通知
		if(app_conf("SMS_ON")==1&&app_conf('SMS_SEND_REPAY')==1){
			//尊敬的用户{$notice.user_name},您的借款"{$notice.deal_name}"在第{$notice.index}期{$notice.status}还款{$notice.all_money}元,感谢您的关注和支持.
			$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_REPAY_SUCCESS_MSG'",false);
			$tmpl_content = $tmpl['content'];

			$notice['user_name'] = $GLOBALS['user_info']['user_name'];
			//Admin 2016/8/5 解决没有副标题的标的
			$notice['deal_name'] = $deal['sub_name']==''? $deal['name'] : $deal['sub_name'];
			$notice['site_name'] = app_conf("SHOP_TITLE");
			$notice['index'] = $lkey+1;
			$notice['status'] = $sms_ext_str;
			if($get_manage ==0){
				$notice['all_money'] = number_format(($repay_money+$repay_impose_money+$repay_manage_money+$repay_manage_impose_money),2);
			}
			else{
				$notice['all_money'] = number_format(($repay_money+$repay_impose_money+$repay_manage_impose_money),2);
			}
			$notice['repay_money'] = number_format($repay_money,2);
			$notice['impose_money'] = number_format($repay_impose_money,2);
			if($get_manage == 0){
				$notice['manage_money'] = number_format($repay_manage_money,2);
			}
			else{
				$notice['manage_money'] = number_format(0,2);
			}
			$notice['mortgage_fee'] = number_format($mortgage_fee,2);
			$notice['manage_impose_money'] = number_format($repay_manage_impose_money,2);
			
			$GLOBALS['tmpl']->assign("notice",$notice);
			$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest'] = $GLOBALS['user_info']['mobile'];
			$msg_data['send_type'] = 0;
			$msg_data['title'] = "还款短信通知";
			$msg_data['content'] = $msg;
			$msg_data['send_time'] = 0;
			$msg_data['is_send'] = 0;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['user_id'] = $GLOBALS['user_info']['id'];
			$msg_data['is_html'] = 0;

			//Admin 2016/8/6 
			//模板ID
			$msg_data['template_id'] = $tmpl['id'];
			//json数据
			$msg_data['datas'] = serialize(array(
				'user_name' => $notice['user_name'],
				'deal_name' => $notice['deal_name'],
				'index' => $notice['index'],
				'status' => $notice['status'],
				'all_money' => $notice['all_money']
			));
			//end

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
		}
		
	}
	
	//判断本借款是否还款完毕
	if($GLOBALS['db']->getOne("SELECT count(*)  FROM ".DB_PREFIX."deal_repay WHERE deal_id=".$deal['id']." and l_key=".$last_repay_key." AND has_repay <> 1 ") == 0){
		//全部还完
		if($GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."deal_repay WHERE deal_id=".$deal['id']." and has_repay = 0 ") == 0){
			//判断获取的信用是否超过限制
			if($GLOBALS['db']->getOne("SELECT sum(point) FROM ".DB_PREFIX."user_point_log WHERE  `type`=6 AND user_id=".$GLOBALS['user_info']['id']) < (int)trim(app_conf('REPAY_SUCCESS_LIMIT'))){
				//获取上一次还款时间
				$befor_repay_time = $GLOBALS['db']->getOne("SELECT MAX(create_time) FROM ".DB_PREFIX."user_point_log WHERE  `type`=6 AND user_id=".$GLOBALS['user_info']['id']);
				$day = ceil((TIME_UTC-$befor_repay_time)/24/3600);
				//当天数大于等于间隔时间 获得信用
				if($day >= (int)trim(app_conf('REPAY_SUCCESS_DAY'))){
					modify_account(array("point"=>trim(app_conf('REPAY_SUCCESS_POINT'))),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],还清借款",4);
				}
			}
				
			//用户获得额度
			modify_account(array("quota"=>trim(app_conf('USER_REPAY_QUOTA'))),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],还清借款获得额度",4);
			
		}
	}
	
	
	$GLOBALS['db']->query("UPDATE ".DB_PREFIX."generation_repay_submit SET `memo`='因还款失效',`status`=2 WHERE deal_id=".$deal['id']);
		
	sys_user_status($GLOBALS['user_info']['id'],false,true);
	syn_deal_status($id);
	syn_transfer_status(0,$id);
	$root["status"] = 1;//0:出错;1:正确;
	$root["show_err"] = "还款完毕，本次还款人数:$repay_user_count";
	
	return $root;
}

/** 
* 基于函数getUcRepayBorrowMoney修改
* @param int $to_user_id 投标用户id 用于查找指定用户的投标记录
* @param string $repay_date 还款日期 用于查找指定日期投标记录
* 对标的url格式化修改,用于生成可以正常访问的链接地址
* 有别于正常的还款自动清分
* 移除 $deal['ips_bill_no']的处理过程
* 不以 $deal['deal_status']=4判断还款状态
* 设置管理费为0
* 发送信息内容调整
* Admin 2016-07-18
*/  
function getUcRepayBorrowMoneyAutoExt($id,$ids,$user_id,$to_user_id,$repay_date){
	$id = intval($id);
	$root = array();
	$root["status"] = 0; //0:出错;1:正确;
		
	if($id == 0){
		$root["show_err"] = "操作失败！";
		return $root;
	}

    $deal = get_deal($id);

	if(!$deal)
	{
		$root["show_err"] = "借款不存在！";
		return $root;
	}

    //移除自动化还款处理url格式化
    $deal['url'] = auturunUrlFormat($deal['url']);
    $deal['share_url'] = auturunUrlFormat($deal['share_url']);
    $deal['app_url'] = auturunUrlFormat($deal['app_url']);
    $deal['user']['url'] = auturunUrlFormat($deal['user']['url']);

	if($user_id > 0){
		$GLOBALS['user_info'] = get_user("*",$user_id);
	}
	
	if($deal['user_id']!=$GLOBALS['user_info']['id']){
		$root["show_err"] = "不属于你的借款！";
		return $root;
	}
	
	$ids = explode(",",$ids);
	
	//当前用户余额
	$user_total_money = (float)$GLOBALS['user_info']['money'];
	
	if($user_total_money<= 0){
		$root["show_err"] = "余额不足";
		return $root;
	}
	
	$last_repay_key = -1;
	require_once APP_ROOT_PATH.'system/libs/user.php';

	foreach($ids as $lkey){
		//还了多少人
		$repay_user_count = 0;
		//多少人未还
		$no_repay_user_count =0;
		//还了多少本息
		$repay_money = 0;
		//还了多少逾期罚息
		$repay_impose_money = 0;
		//还了多少管理费
		$repay_manage_money = 0;
        //还了多少抵押管理费
        $mortgage_fee = 0;
		//还了多少逾期管理费
		$repay_manage_impose_money = 0;

		$user_loan_list = get_deal_user_load_list_ext($deal, $to_user_id, $lkey , -1 , 0 , 1, 0, '', $repay_date);

		//如果已收取管理费
		$get_manage = 0;

		//===============还款================
		foreach($user_loan_list as $lllk=>$lllv){
			foreach($lllv as $kk=>$vv){
				if($vv['has_repay']==0 ){//借款人已还款，但是没打款到借出用户中心
					$user_load_data = array();

					$user_load_data['true_repay_time'] = TIME_UTC;
					$user_load_data['true_repay_date'] = to_date(TIME_UTC);
					$user_load_data['is_site_repay'] = 0;
					$user_load_data['status'] = 0;
						
					$user_load_data['true_repay_money'] = (float)$vv['month_repay_money'];
					$user_load_data['true_self_money'] = (float)$vv['self_money'];
					$user_load_data['true_interest_money'] = (float)$vv['interest_money'];
					$user_load_data['true_manage_money'] = (float)$vv['manage_money'];
					$user_load_data['true_manage_interest_money'] = (float)$vv['manage_interest_money'];
					$user_load_data['true_repay_manage_money'] = (float)$vv['repay_manage_money'];
					$user_load_data['true_manage_interest_money_rebate'] = (float)$vv['manage_interest_money_rebate'];
					$user_load_data['impose_money'] = (float)$vv['impose_money'];
					$user_load_data['repay_manage_impose_money'] = (float)$vv['repay_manage_impose_money'];
					$user_load_data['true_reward_money'] = (float)$vv['reward_money'];
                    $user_load_data['true_mortgage_fee'] = (float)$vv['mortgage_fee'];
					
					$need_repay_money = 0;
					if($get_manage==0)
						$need_repay_money += $user_load_data['true_repay_money']  + $user_load_data['impose_money'] + $user_load_data['true_repay_manage_money'] + $user_load_data['repay_manage_impose_money'] + $user_load_data['mortgage_fee'];
					else
						$need_repay_money += $user_load_data['true_repay_money']  + $user_load_data['impose_money'] + $user_load_data['repay_manage_impose_money'] + $user_load_data['mortgage_fee'];
					//=============余额足够才进行还款=================
					if((float)$need_repay_money <= $user_total_money){
						$last_repay_key = $lkey;
						$repay_user_count +=1;
						$repay_money +=$user_load_data['true_repay_money'];
						$repay_impose_money += $user_load_data['impose_money'];
						$repay_manage_money += $user_load_data['true_repay_manage_money'];
						$repay_manage_impose_money += $user_load_data['repay_manage_impose_money'];
						$user_total_money = $user_total_money - $need_repay_money;
                        $mortgage_fee+= $user_load_data['true_mortgage_fee'];
						
						if($vv['status']>0)
							$user_load_data['status'] = $vv['status'] - 1;
							
						$user_load_data['has_repay'] = 1;
						if($get_manage == 1){
							unset($user_load_data['true_repay_manage_money']);
						}

						$GLOBALS['db']->autoExecute(DB_PREFIX."deal_load_repay",$user_load_data,"UPDATE","id=".$vv['id']." AND has_repay = 0  ","SILENT");
					
						if($GLOBALS['db']->affected_rows() > 0){
			
							$unext_loan = $user_loan_list[$vv['u_key']][$kk+1];
							
							
							$load_repay_rs = $GLOBALS['db']->getOne("SELECT (sum(true_interest_money) + sum(impose_money)) as shouyi,sum(impose_money) as total_impose_money FROM ".DB_PREFIX."deal_load_repay WHERE deal_id=".$deal['id']." AND user_id=".$vv['user_id']);
							$all_shouyi_money= number_format($load_repay_rs['shouyi'],2);
							$all_impose_money = number_format($load_repay_rs['total_impose_money'],2);
								
							
							if($user_load_data['impose_money'] !=0 || $user_load_data['true_manage_money'] !=0 || $user_load_data['true_repay_money']!=0){
								$in_user_id  = $vv['user_id'];
								//如果是转让债权那么将回款打入转让者的账户
								if((int)$vv['t_user_id']== 0){
									$loan_user_info['user_name'] = $vv['user_name'];
									$loan_user_info['email'] = $vv['email'];
									$loan_user_info['mobile'] = $vv['mobile'];
								}
								else{
									$in_user_id = $vv['t_user_id'];
									$loan_user_info['user_name'] = $vv['t_user_name'];
									$loan_user_info['email'] = $vv['t_email'];
									$loan_user_info['mobile'] = $vv['t_mobile'];
								}
			
								//更新用户账户资金记录
								modify_account(array("money"=>$user_load_data['true_repay_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],回报本息",5);
								
								if($user_load_data['true_manage_money'] > 0)
									modify_account(array("money"=>-$user_load_data['true_manage_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],投标管理费",20);
                                
								//利息管理费
								if($user_load_data['true_manage_interest_money'] > 0)
								    modify_account(array("money"=>-$user_load_data['true_manage_interest_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],投标利息管理费",20);
								
								if($user_load_data['impose_money'] != 0)
									modify_account(array("money"=>$user_load_data['impose_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],逾期罚息",21);
								
								//投资者奖励
								if($user_load_data['true_reward_money']!=0){
									modify_account(array("money"=>$user_load_data['true_reward_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],奖励收益",28);
								}
								
								//普通会员邀请返利
								get_referrals($vv['id']);
								
								//投资者返佣金
								if($user_load_data['true_manage_interest_money_rebate'] !=0){
									/*ok*/
									$reback_memo = sprintf($GLOBALS['lang']["INVEST_REBATE_LOG"],$deal["url"],$deal["name"],$loan_user_info["user_name"],intval($vv["l_key"])+1);
									reback_rebate_money($in_user_id,$user_load_data['true_manage_interest_money_rebate'],"invest",$reback_memo);
								}

                                //短信通知回款
								$loan_user_info['id'] = $in_user_id;
								send_repay_reback_sms_mail($deal,$loan_user_info,$unext_loan,$user_load_data,$all_shouyi_money,$all_impose_money);
							}
						}
					}
					
					//=============余额足够才进行还款=================
				}
			}
		}
		//===============还款================
		
		if($repay_user_count > 0){
			//判断当前期是否还款完毕
			$true_repay_count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay=1 and user_id=".$to_user_id);
		
			$ext_str= "";
			if($true_repay_count<>$repay_user_count){
				$ext_str="[部分]";
			}
			//更新用户账户资金记录
			modify_account(array("money"=>-$repay_money),$GLOBALS['user_info']['id'],"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],偿还本息$ext_str",4);
		}
		
		$r_msg = "会员还款$ext_str";
		if($repay_money > 0){
			$r_msg .=",本息：".format_price($repay_money);
		}

		$repay_id = $GLOBALS['db']->getOne("SELECT id FROM ".DB_PREFIX."deal_repay_ext WHERE deal_id = ".$deal['id']." and l_key=".$lkey." and to_user_id=".$to_user_id);
		repay_log($repay_id,$r_msg,$GLOBALS['user_info']['id'],0);
		
		//如果还款完毕
		$sms_ext_str = "成功";
		if($left_user_count = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay = 0 AND user_id=".$to_user_id." AND repay_date='".$repay_date."' ") == 0){
			$notices['repay_status'] = "用户编号[".$to_user_id."]本期还款完毕";
			$impose_rs = $GLOBALS['db']->getRow("SELECT sum(true_self_money) as total_self_money,sum(true_interest_money) as total_interest_money,sum(true_repay_money) as total_repay_money,sum(impose_money) as total_impose_money,sum(true_repay_manage_money) as total_repay_manage_money,sum(repay_manage_impose_money) as total_repay_manage_impose_money,sum(true_mortgage_fee) as total_mortgage_fee  FROM ".DB_PREFIX."deal_load_repay WHERE deal_id = ".$deal['id']." and l_key=".$lkey." AND has_repay = 1");
			//判断是否逾期
			$repay_update_data['has_repay'] = 1;
			$repay_update_data['true_repay_time'] = TIME_UTC;
			$repay_update_data['true_repay_date'] = to_date(TIME_UTC);
			$repay_update_data['true_repay_money'] = floatval($impose_rs['total_repay_money']);
			$repay_update_data['true_self_money'] =  floatval($impose_rs['total_self_money']);
			$repay_update_data['true_interest_money'] =  floatval($impose_rs['total_interest_money']);
			$repay_update_data['impose_money'] =floatval($impose_rs['total_impose_money']);
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_repay_ext",$repay_update_data,"UPDATE","deal_id = ".$deal['id']." and l_key=".$lkey." and to_user_id=".$to_user_id." and repay_date='".$repay_date."'");
		}
		
		$notices['site_title'] = app_conf("SHOP_TITLE");
		$notices['url'] =  "“<a href=\"".$deal['url']."\">".$deal['name']."</a>”";
		$notices['index'] =  ($lkey+1);
		$notices['repay_money'] = ($repay_money+$repay_impose_money+$repay_manage_impose_money);
		if($get_manage == 0){
			$notices['repay_money'] = number_format($notices['repay_money'] + $repay_manage_money,2);
		}
		else{
			$notices['repay_money'] = number_format($notices['repay_money'],2);
		}
        
        $notices['repay_money'] += $mortgage_fee;
		
		$tmpl_contents = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_REPAY_MONEY_MSG'",false);
		$GLOBALS['tmpl']->assign("notice",$notices);
		$content = $GLOBALS['tmpl']->fetch("str:".$tmpl_contents['content']);
		
		send_user_msg("",$content,0,$GLOBALS['user_info']['id'],TIME_UTC,0,true,8);
		unset($notices);
		
		//短信通知
		if(app_conf("SMS_ON")==1&&app_conf('SMS_SEND_REPAY')==1){
			//尊敬的用户{$notice.user_name},您的借款"{$notice.deal_name}"在第{$notice.index}期{$notice.status}还款{$notice.all_money}元,感谢您的关注和支持.
			$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_REPAY_SUCCESS_MSG'",false);
			$tmpl_content = $tmpl['content'];

			$notice['user_name'] = $GLOBALS['user_info']['user_name'];
			//Admin 2016/8/5 解决没有副标题的标的
			$notice['deal_name'] = $deal['sub_name']==''? $deal['name'] : $deal['sub_name'];
			$notice['site_name'] = app_conf("SHOP_TITLE");
			$notice['index'] = $lkey+1;
			$notice['status'] = $sms_ext_str;
			if($get_manage ==0){
				$notice['all_money'] = number_format(($repay_money+$repay_impose_money+$repay_manage_money+$repay_manage_impose_money),2);
			}
			else{
				$notice['all_money'] = number_format(($repay_money+$repay_impose_money+$repay_manage_impose_money),2);
			}
			$notice['repay_money'] = number_format($repay_money,2);
			$notice['impose_money'] = number_format($repay_impose_money,2);
			if($get_manage == 0){
				$notice['manage_money'] = number_format($repay_manage_money,2);
			}
			else{
				$notice['manage_money'] = number_format(0,2);
			}
			$notice['mortgage_fee'] = number_format($mortgage_fee,2);
			$notice['manage_impose_money'] = number_format($repay_manage_impose_money,2);
			
			$GLOBALS['tmpl']->assign("notice",$notice);
			$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest'] = $GLOBALS['user_info']['mobile'];
			$msg_data['send_type'] = 0;
			$msg_data['title'] = "还款短信通知";
			$msg_data['content'] = $msg;
			$msg_data['send_time'] = 0;
			$msg_data['is_send'] = 0;
			$msg_data['create_time'] = TIME_UTC;
			$msg_data['user_id'] = $GLOBALS['user_info']['id'];
			$msg_data['is_html'] = 0;

			//Admin 2016/8/6 
			//模板ID
			$msg_data['template_id'] = $tmpl['id'];
			//json数据
			$msg_data['datas'] = serialize(array(
				'user_name' => $notice['user_name'],
				'deal_name' => $notice['deal_name'],
				'index' => $notice['index'],
				'status' => $notice['status'],
				'all_money' => $notice['all_money']
			));
			//end

			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
		}
		
	}

	syn_deal_status($id);
	syn_transfer_status(0,$id);
	$root["status"] = 1;//0:出错;1:正确;
	$root["show_err"] = "还款完毕，本次还款人数:$repay_user_count";
	
	return $root;
}

/** 
* 基于函数get_deal_user_load_list修改
* 获取指定日期的用户回款列表
* 新版新手标模式投资即刻生成还款计划与回款计划,按还款日期查询
* string $repay_date 查询日期 '2016-07-19' 
* Admin 2016-07-19
*/  
function get_deal_user_load_list_ext($deal_info, $user_id = 0 ,$lkey = -1 , $ukey = -1,$true_time=0,$get_type = 0, $r_type = 0, $limit = '', $repay_date=''){
	if(!$deal_info){
		return false;
	}

	$result = array();
	
    if($get_type > 0){
        if($get_type==1)
            $extW = " AND dlr.has_repay = 0 ";
        else
            $extW = " AND dlr.has_repay = 1 ";
    }
    
    if($user_id > 0){
        $extW .= " AND ((dlr.user_id =  ".$user_id." and dlr.t_user_id = 0 ) or dlr.t_user_id = ".$user_id.")";
    }
    
    if($lkey >= 0){
        $extW .= " AND dlr.l_key =  ".$lkey;
    }
            
    if (!empty($limit)){ 
        $limit = " limit ".$limit;
    
        $sql = "SELECT count(*) FROM ".DB_PREFIX."deal_load_repay dlr ".					
                " WHERE dlr.deal_id=".$deal_info['id']." $extW";
        
        $count = $GLOBALS['db']->getOne($sql);
        $result['count'] = $count;
    }

    if ($repay_date != '') {
        $extW .= " AND dlr.repay_date = '".$repay_date."'";
    }

    $sql = "SELECT dlr.*,dl.pMerBillNo,dl.money,dl.is_winning,dl.income_type,income_value,u.ips_acct_no,AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') AS mobile,AES_DECRYPT(u.email_encrypt,'".AES_DECRYPT_KEY."') AS email,u.user_name,tu.ips_acct_no as t_ips_acct_no,tu.id as t_user_id,tu.user_name as t_user_name,AES_DECRYPT(tu.mobile_encrypt ,'".AES_DECRYPT_KEY."') AS t_mobile,AES_DECRYPT(tu.email_encrypt ,'".AES_DECRYPT_KEY."') AS t_email  FROM ".DB_PREFIX."deal_load_repay dlr ".
        " LEFT JOIN ".DB_PREFIX."deal_load dl ON dl.id =dlr.load_id  ".
        " LEFT OUTER JOIN ".DB_PREFIX."user u ON u.id = dlr.user_id ".
        " LEFT OUTER JOIN ".DB_PREFIX."deal_load_transfer dlt ON dlt.load_id = dl.id and dlt.near_repay_time <=dlr.repay_time ".
        " LEFT OUTER JOIN ".DB_PREFIX."user tu ON tu.id = dlt.t_user_id ".
        " WHERE dlr.deal_id=".$deal_info['id']." $extW ORDER BY dlr.l_key ASC,dlr.u_key ASC ".$limit;

    $load_users = $GLOBALS['db']->getAll($sql);

	if($true_time == 0)
		$true_time = TIME_UTC;
	
	$loan_list = array();
	foreach($load_users as $k=>$v){
		
        $item = array();
        
        //deal_load_repay 编号
        $item['id'] = $v['id'];
        
        //status 1提前,2准时还款，3逾期还款 4严重逾期 数据库里的参数 + 1
        if($v['has_repay'] == 1){
            $item['status'] = $v['status'] +1;
        }
        
        //实际投标金额
        $item['money'] = $v['money']; 
        
        //还款日
        $item['repay_day'] = $v['repay_time'];
        
        //实际还款日
        $item['true_repay_time'] = $v['true_repay_time'];
        
        //月还本息
        $item['month_repay_money']= $v['true_repay_money'];
        
        //当前期本金
        $item['self_money'] = $v['true_self_money'];
        
        //罚息
        $item['impose_money'] =$v['impose_money'];
			
			
        $item['interest_money'] = $v['true_interest_money'];
        //投标者信息
        $item['user_id'] =$v['user_id'];
        $item['user_name'] =$v['user_name'];
        $item['email'] =$v['email'];
        $item['mobile'] =$v['mobile'];
        $item['ips_acct_no'] =$v['ips_acct_no'];
        
        //承接者信息
        $item['t_user_id'] =$v['t_user_id'];
        $item['t_user_name'] =$v['t_user_name'];
        $item['t_ips_acct_no'] =$v['t_ips_acct_no'];
        $item['t_email'] =$v['t_email'];
        $item['t_mobile'] =$v['t_mobile'];
        
        //管理费
        $item['manage_money'] =$v['true_manage_money'];
        
        //利息管理费
        $item['manage_interest_money'] =$v['true_manage_interest_money'];

        //借款者均摊下来的管理费
        $item['repay_manage_money'] =$v['repay_manage_money'];
        //借款者均摊下来的抵押物管理费
        $item['mortgage_fee'] =$v['mortgage_fee'];
        
        //是否还款 0未还 1已还
        $item['has_repay'] =$v['has_repay'];
        
        //对应deal_repay的编号
        $item['repay_id'] =$v['repay_id'];
        //投标编号 对应 deal_load 的编号
        $item['load_id'] =$v['load_id'];
        //第几期
        $item['l_key'] =$v['l_key'];
        $item['l_key_index'] =$v['l_key']+1;
            
			
        //对应借款的第几个投标人
        $item['u_key'] =$v['u_key'];
        //登记债权人时提 交的订单号
        $item['pMerBillNo'] =$v['pMerBillNo'];
        //逾期借款人管理费罚息
        $item['repay_manage_impose_money'] = $v['repay_manage_impose_money'];
        //返佣
        $item['manage_interest_money_rebate'] = $v['true_manage_interest_money_rebate'];
        
        $item['true_manage_interest_money_rebate'] = $v['true_manage_interest_money_rebate'];
        
        $item['t_pMerBillNo'] = $v['t_pMerBillNo'];
        $item['reward_money'] = $v['reward_money'];

        if($v['has_repay'] == 0){
            //月还本息
            $item['month_repay_money']= $v['repay_money'];
            //管理费
            $item['manage_money'] =$v['manage_money'];
            //利息管理费
            $item['manage_interest_money'] =$v['manage_interest_money'];
            $item['repay_manage_money'] = $v['repay_manage_money'];
            $item['self_money'] = $v['self_money'];
            $item['interest_money'] = $v['interest_money'];
            $item['repay_manage_impose_money'] = $v['repay_manage_impose_money'];
            //返佣
            $item['manage_interest_money_rebate'] = $v['manage_interest_money_rebate'];
            
            $item['month_has_repay_money'] = 0;
            if($true_time > ($v['repay_time'] + 24*3600 -1 ) && $item['month_repay_money'] > 0){
                $time_span = to_timespan(to_date($true_time,"Y-m-d"),"Y-m-d");
                $next_time_span = $v['repay_time'];
                $item['impose_day'] = $day  = ceil(($time_span-$next_time_span)/24/3600);
                
    
                if($day >0){
                    //普通逾期
                    $item['status'] = 3;
                    $impose_fee = trim($deal_info['impose_fee_day1']);
                    $manage_impose_fee = trim($deal_info['manage_impose_fee_day1']);
                    if($day >= app_conf('YZ_IMPSE_DAY')){//严重逾期
                        $impose_fee = trim($deal_info['impose_fee_day2']);
                        $manage_impose_fee = trim($deal_info['manage_impose_fee_day2']);
                        $item['status'] = 4;
                    }
                    
                    $impose_fee = floatval($impose_fee);
                        
                    //罚息
                    $item['impose_money'] = $item['month_repay_money'] *$impose_fee*$day/100;
                    
                    $item['repay_manage_impose_money'] = $item['month_repay_money']*$manage_impose_fee*$day/100;
                }
                
            }
            else{
                $item['status'] = 2;
            }
            $item['month_has_repay_money'] = 0;
            $item['month_has_repay_money_all'] = 0;
        }
        elseif($v['has_repay'] == 2){
            //月还本息
            $item['month_repay_money']= $v['repay_money'];
            //管理费
            $item['manage_money'] =$v['manage_money'];
            //利息管理费
            $item['manage_interest_money'] =$v['manage_interest_money'];
            $item['repay_manage_money'] =$v['repay_manage_money'];
            $item['self_money'] = $v['self_money'];
            $item['interest_money'] = $v['interest_money'];
            $item['repay_manage_impose_money'] = $v['repay_manage_impose_money'];
            //返佣
            $item['manage_interest_money_rebate'] = $v['manage_interest_money_rebate'];
            $item['month_has_repay_money'] = 0;
            $item['month_has_repay_money_all'] = 0;
        }
        else{
            $item['month_has_repay_money'] = $item['month_repay_money'];
            $item['month_has_repay_money_all'] = $item['month_repay_money'] + $item['month_manage_money']+$item['impose_money'];
        }
        
        $item['expect_earnings'] = $v['interest_money'] - $v['manage_money'] - $v['manage_interest_money'] + $v['reward_money'];
        if($item['has_repay']==1){
            $item['true_earnings'] = $v['true_interest_money'] + $item['impose_money'] - $v['true_manage_money'] - $v['true_manage_interest_money'] + $v['true_reward_money'];
        }
        else{
            $item['expect_earnings'] += $item['impose_money'];
            $item['true_earnings'] = 0;
        }
        
        $item['repay_day_format'] = to_date($item['repay_day'],"Y-m-d");
        $item['true_repay_time_format'] = to_date($item['true_repay_time']);
        $item['true_repay_day_format'] = to_date($item['true_repay_time'],"Y-m-d");
        $item['manage_money_format'] = format_price($item['manage_money']);
        $item['manage_interest_money_format'] = format_price($item['manage_interest_money']);
        $item['impose_money_format'] = format_price($item['impose_money']);
        $item['repay_manage_impose_money_format'] = format_price($item['repay_manage_impose_money']);
        $item['manage_interest_money_rebate_format'] = format_price($item['manage_interest_money_rebate']);
        $item['month_repay_money_format'] = format_price($item['month_repay_money']);
        $item['month_has_repay_money_format'] = format_price($item['month_has_repay_money']);
        $item['month_has_repay_money_all_format'] = format_price($item['month_has_repay_money_all']);
        //状态
        if($item['has_repay'] == 0){
            $item['status_format'] = '待还';
        }elseif($item['status'] == 1){
            $item['status_format'] = '提前还款';
        }elseif($item['status'] == 2){
            $item['status_format'] = '正常还款';
        }elseif($item['status'] == 3){
            $item['status_format'] = '逾期还款';
        }elseif($item['status'] == 4){
            $item['status_format'] = '严重逾期';
        }
        
        $item['site_repay_format'] = "";
        if($v['has_repay']==1){
            if($v['is_site_repay'] == 0){
                $item['site_repay_format'] = "会员";
            }
            elseif($v['is_site_repay'] == 1){
                $item['site_repay_format'] = "网站";
            }
            elseif($v['is_site_repay'] == 2){
                $item['site_repay_format'] = "机构";
            }
        }
        
        
        if ($r_type == 0){
            if($lkey >= 0){
                if($lkey == $item['l_key']){
                    $loan_list[$item['u_key']][$item['l_key']] = $item;
                }
            }
            else
                $loan_list[$item['u_key']][$item['l_key']] = $item;
        }else{
            $loan_list[] = $item;
        }
	}
	
	if ($r_type == 0){	
		if($ukey >= 0)
			return $loan_list[$ukey];
		else{
			return $loan_list;
		}
	}else{
		$result['item'] = $loan_list;
		return $result;
	}
}

/**
 * 常规标的发送还款提醒信息
 * @param int $day 距离还款日期的天数
 * @param Array $deal_ids 已发送还款标的编号
 */
function sendRepayMoneySmsAuto($day) {
    //借款编号数组
    $deal_user_ids = array();

    $condition = " 1=1";
	//还款日期
	$condition .= " and dl.repay_date ='".date('Y-m-d',(TIME_UTC+$day*24*3600))."'";

    //借款用户
    $deal_users = $GLOBALS['db']->getAll(" SELECT distinct(dl.user_id) FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d on d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND d.ext=''");

    //发送信息
    foreach($deal_users as $k=>$user){
    	//if (isRemovedUser($user['user_id'])) { continue; }
        $deal_user_ids[] = $user['user_id'];

        //有多少条记录
        $repay_count = $GLOBALS['db']->getOne(" SELECT count(*) FROM ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        if (!$repay_count) { continue; }

        $deal_ids = $GLOBALS['db']->getOne(" SELECT distinct(dl.deal_id) FROM ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);

        $v = $GLOBALS['db']->getRow(" SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.borrow_amount,d.cate_id,d.send_three_msg_time,d.agency_id FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']." ORDER BY dl.repay_time ASC limit 0,1");
        if ($repay_count > 1) {
            $v['repay_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.repay_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
            $v['manage_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.manage_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
            $v['manage_impose_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.manage_impose_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
            $v['impose_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.impose_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        }
        //总的借款金额
        if ($repay_count > 1) {
            $v['borrow_amount'] = $GLOBALS['db']->getOne(" SELECT sum(d.borrow_amount) from ".DB_PREFIX."deal d left join ".DB_PREFIX."deal_repay dl on dl.deal_id=d.id WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        }

        $repay_money = $v['repay_money'] + $v['manage_money'] + $v['manage_impose_money'] + $v['impose_money'];
        $v['agency_id'] = 301;

        $user_info = $GLOBALS['db']->getRow("select id,user_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name from ".DB_PREFIX."user where id = ".$v['user_id']);
        $deal_user_info = '['.$user_info['real_name'].'-'.$user_info['mobile'].']';

        //如果账户可用余额足够则返回并且时间间隔小于3天
        if ($repay_money < $user_info['money'] && $day < 3) { continue; }
        
        $group_arr = array(0,$v['user_id'],4);
        
        $sh_notice['shop_title'] = app_conf("SHOP_TITLE"); //站点名称
        $sh_notice['deal_name'] = '“'.$v['name'].'”';	//借款名称
        $sh_notice['repay_time'] = date('Y年m月d日',$v['repay_time']); //还款时间
        $sh_notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
        $sh_notice['money'] = round($repay_money,2); //需还金额
        $sh_notice['repay_count'] = $repay_count; //还款笔数
        $sh_notice['deal_user_info'] = $deal_user_info; 
        $GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
        $tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS'",false);

        $sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
        $msg_data['content'] = $sh_content;
        $msg_data['to_user_id'] = $v['user_id'];
        $msg_data['create_time'] = TIME_UTC;
        $msg_data['type'] = 0;
        $msg_data['group_key'] = implode("_",$group_arr);
        $msg_data['is_notice'] = 12;
        $msg_data['fav_id'] = $v['id'];

        $GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
        $id = $GLOBALS['db']->insert_id();
        $GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);

        // 发送给担保方
        if ($v['agency_id'] > 0) {
            $tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS_AGENCY'",false);

            $sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
            $msg_data['to_user_id'] = $v['agency_id'];
            $msg_data['content'] = $sh_content;
            $msg_data['group_key'] = implode("_",array(0,$v['agency_id'],4));
            
            $GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
            $id = $GLOBALS['db']->insert_id();
            $GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
        }
        
        //邮件
        //暂时关闭邮件发送
        if(0)//app_conf("MAIL_ON")==1 && $user_info['email'] != "")
        {
            $site_domain = "http://www.***.com";
            $tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_DEAL_THREE_EMAIL'");

            $tmpl_content = $tmpl['content'];
            $notice['user_name'] = $user_info['user_name'];
            $notice['deal_name'] = $v['name'];
            $notice['repay_count'] = $repay_count;
            $notice['deal_url'] = auturunUrlFormat($site_domain.url("index",$v['ext']=='uplan'?'uplan':($v['ext']=='newe'?'newe':'deal'), array("id"=>$v['id'])));
            $notice['repay_url'] = auturunUrlFormat($site_domain.url("index","uc_deal#refund"));

            $notice['repay_time'] = date('Y年m月d日',$v['repay_time']);
            $notice['repay_time_y'] = to_date($v['repay_time'],"Y");
            $notice['repay_time_m'] = to_date($v['repay_time'],"m");
            $notice['repay_time_d'] = to_date($v['repay_time'],"d");
            $notice['site_name'] = app_conf("SHOP_TITLE");
            $notice['repay_money'] = round($repay_money,2);
            $notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
            $notice['help_url'] = auturunUrlFormat($site_domain.url("index","helpcenter"));
            $notice['msg_cof_setting_url'] = auturunUrlFormat($site_domain.url("index","uc_msg#setting"));
            
            $GLOBALS['tmpl']->assign("notice",$notice);
                
            $msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
            $msg_data['dest'] = $user_info['email'];
            $msg_data['send_type'] = 1;
            $msg_data['title'] = "还款邮件提醒";
            $msg_data['content'] = addslashes($msg);
            $msg_data['send_time'] = 0;
            $msg_data['is_send'] = 0;
            $msg_data['create_time'] = TIME_UTC;
            $msg_data['user_id'] = $user_info['id'];
            $msg_data['is_html'] = $tmpl['is_html'];
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
        }
        
        //短信
        if(app_conf("SMS_ON")==1 && $user_info['mobile'])
        {
*            $tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS'");

            $tmpl_content = $tmpl['content'];
            $notice['user_name'] = $user_info["user_name"];
            $notice['deal_name'] = $v['name'];
            $notice['repay_count'] = $repay_count;
            $notice['repay_time'] = date('Y年m月d日',$v['repay_time']);
            $notice['repay_time_y'] = to_date($v['repay_time'],"Y");
            $notice['repay_time_m'] = to_date($v['repay_time'],"m");
            $notice['repay_time_d'] = to_date($v['repay_time'],"d");
            $notice['site_name'] = app_conf("SHOP_TITLE");
            $notice['repay_money'] = round($repay_money,2);
            $notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
            
            $GLOBALS['tmpl']->assign("notice",$notice);
                
            $msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
            
            $msg_data['dest'] = $user_info['mobile'];
            $msg_data['send_type'] = 0;
            $msg_data['title'] = "还款短信提醒";
            $msg_data['content'] = addslashes($msg);;
            $msg_data['send_time'] = 0;
            $msg_data['is_send'] = 0;
            $msg_data['create_time'] = TIME_UTC;
            $msg_data['user_id'] = $user_info['id'];
            $msg_data['is_html'] = $tmpl['is_html'];

			//Admin 2016/8/6 
			//模板ID
			$msg_data['template_id'] = $tmpl['id'];
			//json数据
			$msg_data['datas'] = serialize(array(
				'borrow_amount' => $notice['borrow_amount'],
				'repay_time' => $notice['repay_time'],
				'money' => $notice['repay_money']
			));
			//end

            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
            
            // 发送给担保方
            if ($v['agency_id'] > 0) {
                $user_info = $GLOBALS['db']->getRow("select id,user_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile from ".DB_PREFIX."user where id = ".$v['agency_id']);

                if ($user_info['mobile']) {
*                    $tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS_AGENCY'");

                    $tmpl_content = $tmpl['content'];
                    $msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
                    $msg_data['dest'] = $user_info['mobile'];
                    $msg_data['send_type'] = 0;
                    $msg_data['title'] = "还款短信提醒";
                    $msg_data['content'] = addslashes($msg);;
                    $msg_data['send_time'] = 0;
                    $msg_data['is_send'] = 0;
                    $msg_data['create_time'] = TIME_UTC;
                    $msg_data['user_id'] = $user_info['id'];
                    $msg_data['is_html'] = $tmpl['is_html'];

					//Admin 2016/8/6 
					//模板ID
					$msg_data['template_id'] = $tmpl['id'];
					//json数据
					$msg_data['datas'] = serialize(array(
						'deal_user_info' => $deal_user_info,
						'borrow_amount' => $notice['borrow_amount'],
						'repay_time' => $notice['repay_time'],
						'money' => $notice['repay_money']
					));
					//end

                    $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
                }
            }
        }

        if ($repay_count == 1) {
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",array("send_three_msg_time"=>$v['repay_time']),"UPDATE","id=".$v['deal_id']); 
        } else {
            foreach ($deal_ids as $idk=>$idv) {
                $deal_ids[$idk] = $idv['deal_id'];
            }
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",array("send_three_msg_time"=>$v['repay_time']),"UPDATE","id in (".explode(',', $deal_ids).")"); 
        }

        //消息发送
		//Admin 可关闭即时发送
		/*
        $msg_items = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_msg_list where is_send = 0 and (send_type = 0 or send_type = 1) order by id asc");
        foreach ($msg_items as $msg_item) {
            //优先改变发送状态,不论有没有发送成功
            $GLOBALS['db']->query("update ".DB_PREFIX."deal_msg_list set is_send = 1 where id =".intval($msg_item['id']));
            
            if ($GLOBALS['db']->affected_rows()){
                $result = send_sms_email($msg_item);
                //发送结束，更新当前消息状态
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_msg_list set is_success = ".intval($result['status']).",result='".$result['msg']."',send_time='".TIME_UTC."' where id =".intval($msg_item['id']));
            }
        }
		*/
    }

    return $deal_user_ids;
}

/**
 * uplan,newe标的发送还款提醒信息
 * @param int $day 距离还款日期的天数
 * @param Array $deal_ids 已发送还款标的编号
 */
function sendRepayMoneySmsAutoExt($day) {
    //借款编号数组
    $deal_user_ids = array();

    $condition = " 1=1";
	//还款日期
	$condition .= " and dl.repay_date ='".date('Y-m-d',(TIME_UTC+$day*24*3600))."'";

    //借款用户
    $deal_users = $GLOBALS['db']->getAll(" SELECT dl.user_id FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d on d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND d.ext in ('uplan','newe') limit 0,1");
    if (!$deal_users) {
        $deal_users = $GLOBALS['db']->getAll(" SELECT dl.user_id FROM ".DB_PREFIX."deal_repay_ext dl LEFT JOIN ".DB_PREFIX."deal d on d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND d.ext in ('uplan','newe') limit 0,1");
    }

    //发送信息
    foreach($deal_users as $k=>$user){
        $deal_user_ids[] = $user['user_id'];

        //有多少条记录
        $repay_count = $GLOBALS['db']->getOne(" SELECT count(*) FROM ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']) + $GLOBALS['db']->getOne(" SELECT count(*) FROM ".DB_PREFIX."deal_repay_ext dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        if (!$repay_count) { continue; }

        $deal_ids = $GLOBALS['db']->getAll(" SELECT distinct(dl.deal_id) FROM ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        $deal_ids_ext = $GLOBALS['db']->getAll(" SELECT distinct(dl.deal_id) FROM ".DB_PREFIX."deal_repay_ext dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);

        if (count($deal_ids)) {
            $v = $GLOBALS['db']->getRow(" SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.borrow_amount,d.cate_id,d.send_three_msg_time,d.agency_id FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']." ORDER BY dl.repay_time ASC limit 0,1");
        } else {
            $v = $GLOBALS['db']->getRow(" SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.borrow_amount,d.cate_id,d.send_three_msg_time,d.agency_id FROM ".DB_PREFIX."deal_repay_ext dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']." ORDER BY dl.repay_time ASC limit 0,1");
        }

        if ($repay_count > 1) {
            $v['repay_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.repay_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']) + $GLOBALS['db']->getOne(" SELECT sum(dl.repay_money) from ".DB_PREFIX."deal_repay_ext dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
            $v['impose_money'] = $GLOBALS['db']->getOne(" SELECT sum(dl.impose_money) from ".DB_PREFIX."deal_repay dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']) + $GLOBALS['db']->getOne(" SELECT sum(dl.impose_money) from ".DB_PREFIX."deal_repay_ext dl WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        }
        //总的借款金额
        if ($repay_count > 1) {
            $v['borrow_amount'] = $GLOBALS['db']->getOne(" SELECT sum(d.borrow_amount) from ".DB_PREFIX."deal d left join ".DB_PREFIX."deal_repay dl on dl.deal_id=d.id WHERE $condition AND dl.has_repay=0 AND dl.user_id=".$user['user_id']);
        }

        $repay_money = $v['repay_money'] + $v['impose_money'];

        $user_info = $GLOBALS['db']->getRow("select id,user_name,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name from ".DB_PREFIX."user where id = ".$v['user_id']);

        //如果账户可用余额足够并且时间小于3天则返回
        if ($repay_money < $user_info['money'] && $day < 3) { continue; }
        
        $group_arr = array(0,$v['user_id'],4);
        
        $sh_notice['shop_title'] = app_conf("SHOP_TITLE"); //站点名称
        $sh_notice['deal_name'] = '“'.$v['name'].'”';	//借款名称
        $sh_notice['repay_time'] = date('Y-m-d',$v['repay_time']); //还款时间
        $sh_notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
        $sh_notice['money'] = round($repay_money,2); //需还金额
        $sh_notice['repay_count'] = $repay_count; //还款笔数
        $sh_notice['deal_user_info'] = $deal_user_info; 
        $GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
        $tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS'",false);

		$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
        $msg_data['content'] = $sh_content;
        $msg_data['to_user_id'] = $v['user_id'];
        $msg_data['create_time'] = TIME_UTC;
        $msg_data['type'] = 0;
        $msg_data['group_key'] = implode("_",$group_arr);
        $msg_data['is_notice'] = 12;
        $msg_data['fav_id'] = $v['id'];

        $GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
        $id = $GLOBALS['db']->insert_id();
        $GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
        
        //邮件
        //关闭邮件发送
		//Admin 2016/8/9 加入邮件账户判断
        if(0)//app_conf("MAIL_ON")==1 && $user_info['email'] != "")
        {
            $site_domain = "http://localhost";
            $tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_DEAL_THREE_EMAIL'");

            $tmpl_content = $tmpl['content'];
            $notice['user_name'] = $user_info['user_name'];
            $notice['deal_name'] = $v['name'];
            $notice['repay_count'] = $repay_count;
            $notice['deal_url'] = auturunUrlFormat($site_domain.url("index",$v['ext']=='uplan'?'uplan':($v['ext']=='newe'?'newe':'deal'), array("id"=>$v['id'])));
            $notice['repay_url'] = auturunUrlFormat($site_domain.url("index","uc_deal#refund"));

            $notice['repay_time'] = date('Y年m月d日',$v['repay_time']);
            $notice['repay_time_y'] = to_date($v['repay_time'],"Y");
            $notice['repay_time_m'] = to_date($v['repay_time'],"m");
            $notice['repay_time_d'] = to_date($v['repay_time'],"d");
            $notice['site_name'] = app_conf("SHOP_TITLE");
            $notice['repay_money'] = round($repay_money,2);
            $notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
            $notice['help_url'] = auturunUrlFormat($site_domain.url("index","helpcenter"));
            $notice['msg_cof_setting_url'] = auturunUrlFormat($site_domain.url("index","uc_msg#setting"));
            
            $GLOBALS['tmpl']->assign("notice",$notice);
                
            $msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
            $msg_data['dest'] = $user_info['email'];
            $msg_data['send_type'] = 1;
            $msg_data['title'] = "还款邮件提醒";
            $msg_data['content'] = addslashes($msg);
            $msg_data['send_time'] = 0;
            $msg_data['is_send'] = 0;
            $msg_data['create_time'] = TIME_UTC;
            $msg_data['user_id'] = $user_info['id'];
            $msg_data['is_html'] = $tmpl['is_html'];
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
        }
        
        //短信
        if(app_conf("SMS_ON")==1 && $user_info['mobile'])
        {
            $tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS'");

            $tmpl_content = $tmpl['content'];
            $notice['user_name'] = $user_info["user_name"];
            $notice['deal_name'] = $v['name'];
            $notice['repay_count'] = $repay_count;
            $notice['repay_time'] = date('Y年m月d日',$v['repay_time']);
            $notice['repay_time_y'] = to_date($v['repay_time'],"Y");
            $notice['repay_time_m'] = to_date($v['repay_time'],"m");
            $notice['repay_time_d'] = to_date($v['repay_time'],"d");
            $notice['site_name'] = app_conf("SHOP_TITLE");
            $notice['repay_money'] = round($repay_money,2);
            $notice['borrow_amount'] = (intval($v['borrow_amount'])/10000).'万元'; //融资金额
            
            $GLOBALS['tmpl']->assign("notice",$notice);
                
            $msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
            
            $msg_data['dest'] = $user_info['mobile'];
            $msg_data['send_type'] = 0;
            $msg_data['title'] = "还款短信提醒";
            $msg_data['content'] = addslashes($msg);;
            $msg_data['send_time'] = 0;
            $msg_data['is_send'] = 0;
            $msg_data['create_time'] = TIME_UTC;
            $msg_data['user_id'] = $user_info['id'];
            $msg_data['is_html'] = $tmpl['is_html'];


			//Admin 2016/8/6 
			//模板ID
			$msg_data['template_id'] = $tmpl['id'];
			//json数据
			$msg_data['datas'] = serialize(array(
				'borrow_amount' => $notice['borrow_amount'],
				'repay_time' => $notice['repay_time'],
				'money' => $notice['repay_money']
			));
			//end

            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
        }

        if ($repay_count == 1) {
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",array("send_three_msg_time"=>$v['repay_time']),"UPDATE","id=".$v['deal_id']); 
        } else {
            $deal_ids = array_merge($deal_ids, $deal_ids_ext);
            foreach ($deal_ids as $idk=>$idv) {
                $deal_ids[$idk] = $idv['deal_id'];
            }
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",array("send_three_msg_time"=>$v['repay_time']),"UPDATE","id in (".explode(',', $deal_ids).")"); 
        }

        //消息发送
        $msg_items = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_msg_list where is_send = 0 and (send_type = 0 or send_type = 1) order by id asc");
        foreach ($msg_items as $msg_item) {
            //优先改变发送状态,不论有没有发送成功
            $GLOBALS['db']->query("update ".DB_PREFIX."deal_msg_list set is_send = 1 where id =".intval($msg_item['id']));
            
            if ($GLOBALS['db']->affected_rows()){
                $result = send_sms_email($msg_item);
                //发送结束，更新当前消息状态
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_msg_list set is_success = ".intval($result['status']).",result='".$result['msg']."',send_time='".TIME_UTC."' where id =".intval($msg_item['id']));
            }
        }
    }

    return $deal_user_ids;
}

/**
 * 获取或判断需要排除的用户
 * @param  integer $id 需要判断的用户id
 * @return 排除的用户数组,或者判断结果
 */
function isRemovedUser($id) {
	//排除百姓缘 real_name='昆明百姓缘药业有限公司', id=2759, user_name='13888642358';
	if ($id == 2759) {
		return true;
	} else {
		return false;
	}
}
?>