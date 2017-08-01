<?php
/*
 * Created on 2015-6-19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
  /**
  * 体验金收益领取
  * @param 
  */
 function do_receive_benefits(){ 	
 	
 	require_once APP_ROOT_PATH.'system/libs/user.php';
 	$today = to_date(TIME_UTC,"Y-m-d");
 	$user_id = intval($GLOBALS['user_info']['id']);
 	$learn_load_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."learn_load  where is_send = 0 and user_id = ".$user_id);
 	
 	foreach($learn_load_list as $k => $v)
	{
		$learn_end_time[$k] = strtotime($learn_load_list[$k]['create_date']) + $learn_load_list[$k]['time_limit'] * 24 * 3600 ;
		$learn_expire_end_time[$k] = strtotime($learn_load_list[$k]['create_date']) + ($learn_load_list[$k]['time_expire_limit'] +$learn_load_list[$k]['time_limit']) * 24 * 3600 ;
		$end_date[$k] = to_date($learn_end_time[$k],'Y-m-d');
		$expire_end_date[$k] = to_date($learn_expire_end_time[$k],'Y-m-d');
		
		if($today>= $end_date[$k] && $today<= $expire_end_date[$k]){
			$msg = "体验金收益领取";
			$learn_data['is_send'] = 1;
			$learn_data['send_date'] = to_date(TIME_UTC,"Y-m-d");
			$learn_data['send_time'] = to_date(TIME_UTC,"Y-m-d H:i:s");
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."learn_load",$learn_data,"UPDATE","id=".$learn_load_list[$k]['id']);
			modify_account(array('money'=>$learn_load_list[$k]['interest']), $user_id,$msg,47);
			
		}
		
	}
 	
 }
 
  /**
  * 体验金投资
  * @param 
  */
  function learn_invest($learn_id,$money){ 	
  		
  		
		$today = to_date(TIME_UTC,"Y-m-d");
		$now_time = to_date(TIME_UTC,"Y-m-d H:i:s"); 
		
		$sql = "select * from ".DB_PREFIX."learn where id =".$learn_id." ";	
		$learn_info = $GLOBALS['db']->getRow($sql);	
		
		$learn_load_data['learn_id'] = $learn_info['id'];
		$learn_load_data['money'] = $money;
		$learn_load_data['rate'] = $learn_info['rate'];
		$learn_load_data['time_limit'] = $learn_info['time_limit'];
		$learn_load_data['time_expire_limit'] = $learn_info['time_expire_limit'];
		$learn_load_data['create_date'] = $today;
		$learn_load_data['create_time'] = $now_time;
		//$learn_load_data['interest'] =  intval((intval($money)*$learn_info['rate']*0.01*$learn_info['time_limit'])/365);
		$learn_load_data['interest'] =  (intval($money)*$learn_info['rate']*0.01*$learn_info['time_limit'])/365;
		
		$learn_load_data['user_id'] = intval($GLOBALS['user_info']['id']);
		
		$sql_send = "update ".DB_PREFIX."learn_send_list set is_use = '1',use_time ='".$now_time."',use_date='".$today."' where is_use = '0' and  user_id = ".intval($GLOBALS['user_info']['id']);
		$GLOBALS['db']->query($sql_send);
	
		$GLOBALS['db']->autoExecute(DB_PREFIX."learn_load",$learn_load_data);
 		if($GLOBALS['db']->affected_rows()){
			
			$is_invest = 1;
		}
		else{
			$is_invest = 0;
		}
		
		return $is_invest;
 }
 
 
?>
