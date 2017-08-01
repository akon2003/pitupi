<?php

/**
 * XHF 2016-7-14
 * 首页展示添加U计划和新手标
 * 2016/11/1
 * 首页改版,页面输出内容变更
 */

define(MODULE_NAME,"index");
require APP_ROOT_PATH.'app/Lib/deal.php';
class indexModule extends SiteBaseModule {
	public function index() {
		$GLOBALS['tmpl']->caching = true;
		$GLOBALS['tmpl']->cache_lifetime = 180;  //首页缓存3分钟
		$cache_id  = md5(MODULE_NAME.ACTION_NAME);
	
		if (!$GLOBALS['tmpl']->is_cached("page/index.html", $cache_id)) {	
			change_deal_status();
			
			if((int)app_conf("SHOW_EXPRIE_DEAL") == 0){
				$extW = " AND (if(deal_status = 1, start_time + enddate*24*3600 > ".TIME_UTC .",1=1)) ";
			}
			$uplan = array();
			$extW = " and publish_wait =0 AND deal_status in(1,2) AND start_time <=".TIME_UTC." and is_hidden = 0 and is_effect=1 and is_delete=0";
			
            // 新手专享
			$uplan_01 =  get_deal_list(1,0," (ext='newe' or is_new=1) ".$extW," id DESC",'newe');
            // 最新U计划
			$uplan_03 =  get_deal_list(1,0," ext='uplan' and is_new=0 and repay_time=3 ".$extW," id DESC",'uplan');
			$uplan_06 =  get_deal_list(1,0," ext='uplan' and is_new=0 and repay_time=6 ".$extW," id DESC",'uplan');
			$uplan_12 =  get_deal_list(1,0," ext='uplan' and is_new=0 and repay_time=12 ".$extW," id DESC",'uplan');
			$uplan['uplan_01'] = $uplan_01['list'][0];
			$uplan['uplan_03'] = $uplan_03['list'][0];
			$uplan['uplan_06'] = $uplan_06['list'][0];
			$uplan['uplan_12'] = $uplan_12['list'][0];
			$uplan['uplan_xx'] = '';

			foreach ($uplan as $k=>&$v) {
				if ($k == 'uplan_01') {
					$v['name'] = '新手专享';
					$v['repay_time'] = 1;
				} else if ($k == 'uplan_03') {
					$v['name'] = 'U计划A';
					$v['repay_time'] = 3;
				} else if ($k == 'uplan_06') {
					$v['name'] = 'U计划B';
					$v['repay_time'] = 6;
				} else if ($k == 'uplan_12') {
					$v['name'] = 'U计划C';
					$v['repay_time'] = 12;
				}

				if ($v && $v['id']) {
					//rate
					$v['rate'] = number_format($v['rate'],1);
					if ($v['rate'] > 10) { 
						$v['rate'] = rtrim($v['rate'], '.0'); 
					} else if ($v['rate'] == 10) { 
						$v['rate'] = '10';
					}

					//progress_point
					$v['progress_point'] = intval($v['load_money']/$v['borrow_amount']*100);
					//borrow_amount
					$v['borrow_amount'] = format_price($v['borrow_amount']);
				} else {
					if ($k == 'uplan_01') {
						$v['id'] = '0';
						$v['rate'] = '8.0';
					} else if ($k == 'uplan_03') {
						$v['id'] = '0';
						$v['rate'] = '7.2';
					} else if ($k == 'uplan_06') {
						$v['id'] = '0';
						$v['rate'] = '9.0';
					} else if ($k == 'uplan_12') {
						$v['id'] = '0';
						$v['rate'] = '12';
					}
					//progress_point
					$v['progress_point'] = 0;
					//borrow_amount
					$v['borrow_amount'] = '--';
				}
			}
			$GLOBALS['tmpl']->assign("uplan_list",$uplan);
			$GLOBALS['tmpl']->assign("uplan_str",serialize($uplan));

			//最新借款列表
			//$deal_list =  get_deal_list(4,0," publish_wait =0 AND deal_status in(1,2,4,5) AND start_time <=".TIME_UTC." and is_hidden = 0 and is_new=0 and ext='' and repay_time>1"," deal_status ASC,id DESC");
			$deal_list =  get_deal_list(4,0," publish_wait =0 AND deal_status in(1,2,4,5) and is_hidden = 0 and is_new=0 and ext=''"," deal_status ASC,id DESC");
			$GLOBALS['tmpl']->assign("deal_list",$deal_list['list']);

			//图标友情链接			
			$ico_yqlj_id = $GLOBALS['db']->getOne("SELECT id FROM ".DB_PREFIX."link_group where name='图标链接'");
			if($ico_yqlj_id > 0){
				$ico_yqlj_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."link where group_id=$ico_yqlj_id and is_effect=1 order by sort asc");
				$GLOBALS['tmpl']->assign("ico_yqlj_id",$ico_yqlj_id);
				$GLOBALS['tmpl']->assign("ico_yqlj_list",$ico_yqlj_list);
			}
			
			$now = TIME_UTC;
			$vote = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."vote where is_effect = 1 and begin_time < ".$now." and (end_time = 0 or end_time > ".$now.") order by sort desc limit 1");
			$GLOBALS['tmpl']->assign("vote",$vote);
			
			$stats = site_statics();
			$stats['user_count'] = $stats['user_count'];
			$stats['total_load'] = $stats['total_load'];
			$GLOBALS['cache']->set("site_statics",$stats);

			$GLOBALS['tmpl']->assign("stats",$stats);
			
			$near_deal_loads = get_near_deal_loads("0,8");
			$GLOBALS['tmpl']->assign("near_deal_loads",$near_deal_loads);
			
			//格式化统计代码
			$VIRTUAL_MONEY_1_FORMAT =  format_conf_count(floatval(trim(app_conf("VIRTUAL_MONEY_1"))) + $stats['total_load']);
			$VIRTUAL_MONEY_2_FORMAT =  format_conf_count(floatval(trim(app_conf("VIRTUAL_MONEY_2"))) + $stats['total_rate']);
			$VIRTUAL_MONEY_3_FORMAT =  format_conf_count(floatval(trim(app_conf("VIRTUAL_MONEY_3"))) + $stats['total_bzh']);
			$GLOBALS['tmpl']->assign("VIRTUAL_MONEY_1_FORMAT",$VIRTUAL_MONEY_1_FORMAT);
			$GLOBALS['tmpl']->assign("VIRTUAL_MONEY_2_FORMAT",$VIRTUAL_MONEY_2_FORMAT);
			$GLOBALS['tmpl']->assign("VIRTUAL_MONEY_3_FORMAT",$VIRTUAL_MONEY_3_FORMAT);
			
			$GLOBALS['tmpl']->assign("show_site_titile",1);

			//公司新闻与行业新闻
			$advs = $GLOBALS['db']->getAll(" select a.* from ".DB_PREFIX."article a left join ".DB_PREFIX."article_cate ac on ac.id=a.cate_id where ac.title in ('公司新闻','行业新闻') order by a.id desc limit 0,10");
			$index = 1;
			$slide = array();

			foreach ($advs as $k=>$v) {
				$advs[$k]['update_date'] = date('Y-m-d',$v['update_time']);

				if($v['uname']!='') {
					$advs[$k]['url'] = url("index","Article",array("id"=>$v['uname']));
				} else {
					$advs[$k]['url'] = url("index","Article",array("id"=>$v['id']));
				}

				if ($v['icon'] && $index <= 5) {
					$advs[$k]['index'] = $index;
					$slide[] = $advs[$k];
					$index ++;
				}
			}
			$GLOBALS['tmpl']->assign("advs",$advs);
			$GLOBALS['tmpl']->assign("slide",$slide);
		}
		$GLOBALS['tmpl']->display("page/index.html",$cache_id);
	}
}	
?>
