<?php

class licai_deal
{
	public function index(){
		
		$root = array();
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		$root['user_id'] = $user_id;
		
		require_once APP_ROOT_PATH.'system/libs/licai.php';
		require_once APP_ROOT_PATH.'app/Lib/page.php';

		$id = intval($GLOBALS['request']['id']);
		$licai = get_licai($id);
		
		$licai["fund_brand_name"] = $GLOBALS["db"]->getOne("select name from ".DB_PREFIX."licai_fund_brand where id =".$licai["fund_brand_id"]);
		
		if(!$licai || $licai['status'] == 0){
			$root['show_err'] = "理财产品不存在";
			output($root);
		}
		
		if($user_id){
			$root['user_info'] = $user;
		}	
		$root['licai'] = $licai;
		
		$min_interest_rate=0;
		$min_interest_rate=0;
		if($licai['type'] > 0){
			$licai_interest_json = json_encode($licai['licai_interest']);
			$min_interest_rate = $licai['licai_interest'][0]['interest_rate'];
			$max_interest_rate = $licai['licai_interest'][count($licai['licai_interest'])-1]['interest_rate'];
		}
		else{
			$licai_interest_json =json_encode($licai['licai_interest']);// $licai['average_income_rate'];
		}
		
		//为客户创造收益
		//$user_income = doubleval($GLOBALS['db']->getOne("select sum(money) from ".DB_PREFIX."user_log WHERE `type`=9 "));
		$user_income = doubleval($GLOBALS['db']->getOne("select sum(earn_money) from ".DB_PREFIX."licai_redempte"));
		$root['user_income'] = $user_income;
		
		$condition = " where lc.id = ".$id;
		//图表
		//七天
		//$condition .= " and lh.history_date >= '".to_date(TIME_UTC-7*3600*24,"Y-m-d")."' and lh.history_date <= '".to_date(TIME_UTC,"Y-m-d")."'";
		if($licai["type"] == 0)
		{
			$data_table_count = $GLOBALS["db"]->getOne("select count(*) from ".DB_PREFIX."licai_history lh left join ".DB_PREFIX."licai lc on lc.id=lh.licai_id ".$condition);
			
			if($data_table_count >= 5)
			{
				$limit = " limit ".($data_table_count-5).",5 ";
			}
			else
			{
				$limit = "";
			}
			
			$data_table = $GLOBALS['db']->getAll("select lh.history_date,lh.rate from ".DB_PREFIX."licai_history lh left join ".DB_PREFIX."licai lc on lc.id = lh.licai_id ".$condition." order by lh.history_date asc ".$limit);
			
			if($data_table_count == 1)
			{
				array_unshift($data_table,array("history_date"=>$data_table[0]["history_date"],"rate"=>$data_table[0]["rate"]));
			}

			$root['data_table'] = $data_table;
		}
		
		$root['licai_interest_json'] = $licai_interest_json;
		$root['min_interest_rate'] = $min_interest_rate;
		$root['max_interest_rate'] = $max_interest_rate;
		
		$root['program_title'] = "投标详情";
		
		output($root);		
	}
}
?>
