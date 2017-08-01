<?php

/**
 * XHF 2016/8/25
 * 新增控制器,投资有礼,购买即完成计划表创建
 * deal表 ext 字段名为 presents
 * deal表增加字段 reserve1 保存相关设置
 */

require APP_ROOT_PATH.'app/Lib/deal.php';
require 'dealsModule.class.php';
class presentsModule extends dealsModule
{
	public function index(){
		$GLOBALS['tmpl']->caching = true;
		$GLOBALS['tmpl']->cache_lifetime = 60;  //首页缓存10分钟
		$field = es_cookie::get("shop_sort_field"); 
		$field_sort = es_cookie::get("shop_sort_type"); 
		
		$cache_id  = md5(MODULE_NAME.ACTION_NAME.$_SERVER['REQUEST_URI'].$field.$field_sort);	
		if (!$GLOBALS['tmpl']->is_cached("page/presents.html", $cache_id))
		{	
			//查询当前最新的投资送礼标的产品
            $deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where is_delete=0 and is_effect=1 and ext='present' and deal_status in (1,2,4,5) order by id desc limit 1");
			
			$deal['present'] = unserialize($deal['reserve1']);
			$presents = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."goods where is_effect=1 and ext='present' order by id desc");

			$present_list = array();
			foreach ($deal['present'] as $v) {
				if (!$v['checked']) { continue; }
				foreach ($presents as $vv) {
					if ($v['id'] != $vv['id']) { continue; }
					$present = $vv;
					$present['min_loan_money'] = $v['min_loan_money'];
				}
				$present_list[] = $present;
			}

			$GLOBALS['tmpl']->assign("deal",$deal);
			$GLOBALS['tmpl']->assign("present_list",$present_list);
		}
		
		$GLOBALS['tmpl']->display("page/presents.html",$cache_id);
	}
}
?>
