<?php
class init{
	public function index()
	{		
		$root = array();
		$root['response_code'] = 1;

		$root['kf_phone'] = $GLOBALS['m_config']['kf_phone'];//客服电话
		$root['kf_email'] = $GLOBALS['m_config']['kf_email'];//客服邮箱
		
		$root['about_info'] = intval($GLOBALS['m_config']['about_info']);
		
		$root['is_peizi'] = (int)app_conf("PEIZI_OPEN") == 0 ? 1 : 0;
		$root['licai_open'] = (int)app_conf("LICAI_OPEN");		
		
		$root['version'] = VERSION; //接口版本号int
		$root['page_size'] = PAGE_SIZE;//默认分页大小
		$root['program_title'] = $GLOBALS['m_config']['program_title'];
		$root['site_domain'] = str_replace("/mapi", "", SITE_DOMAIN.APP_ROOT);//站点域名;
		$root['site_domain'] = str_replace("http://", "", $root['site_domain']);//站点域名;
		$root['site_domain'] = str_replace("https://", "", $root['site_domain']);//站点域名;
		
		$stats = site_statics();
		$GLOBALS['tmpl']->assign("stats",$stats);
				
		$root['total_load'] = strip_tags(number_format(floatval($stats['total_load'])/10000,2));//累计成交额;
		$root['total_rate'] = strip_tags(number_format(floatval($stats['total_rate'])/10000,2));//累计创造收益;
		$root['user_count'] = $stats['user_count'];
		
		$index_list = $GLOBALS['cache']->get("MOBILE_INDEX_ADVS");
		if(true || $index_list===false)
		{
			$advs = $GLOBALS['db']->getAll(" select * from ".DB_PREFIX."m_adv where status = 1 order by sort desc ");
			$adv_list = array();
			$deal_list = array();
			$condition = "-1";
			foreach($advs as $k=>$v)
			{
				if ($v['page'] == 'top'){
					/*
					$adv_list[]['id'] = $v['id'];
					$adv_list[]['name'] = $v['name'];
					if ($v['page'] == 'top' && $v['img'] != ''){
						$adv_list[]['img'] = get_abs_img_root(get_spec_image($v['img'],640,240,1));
					}else{
						$adv_list[]['img'] = '';
					}
					$adv_list[]['type'] = $v['type'];
					$adv_list[]['open_url_type'] = $v['open_url_type'];
					$adv_list[]['data'] = $v['data'];
					*/
					if ($v['img'] != '')
						$v['img'] = get_abs_img_root(get_spec_image($v['img'],640,240,1));
					$adv_list[] = $v;
				}else{
					/*
					$deal_list[]['id'] = $v['id'];
					$deal_list[]['name'] = $v['name'];					
					$deal_list[]['img'] = '';					
					$deal_list[]['type'] = $v['type'];
					$deal_list[]['open_url_type'] = $v['open_url_type'];
					$deal_list[]['data'] = $v['data'];
					*/
					//$v['img'] = '';
					//$deal_list[] = $v;
					$condition .= ",".intval($v['data']);
				}			
			}
			
			//$condition = " id in (".$condition.")";
			//publish_wait 0:已审核 1:等待审核;deal_status 0待等材料，1进行中，2满标，3流标，4还款中，5已还清
			$condition = " publish_wait = 0 AND deal_status in (1,2,4,5)";
			require APP_ROOT_PATH.'app/Lib/deal.php';
			$limit = "0,5";
			$orderby = "deal_status ASC,sort DESC,id DESC";
			
			//print_r($limit);
			//print_r($condition);
			if((int)app_conf("SHOW_EXPRIE_DEAL") == 0){
				$condition .= " AND (if(deal_status = 1, start_time + enddate*24*3600 > ".TIME_UTC .",1=1)) ";
			}
			$result = get_deal_list($limit,0,$condition,$orderby,'','',false,'');
			$deal_all = get_deal_list(10,0,'publish_wait=0 and deal_status in (1,2,4)',$orderby,'','',false,''); //首页调用投标条数 xiejun 2016.07.18
			$uplan = get_deal_list("0,1",0,' publish_wait=0 and deal_status in (1,2) ','id desc','','',false,'uplan');
			$newe = get_deal_list("0,1",0,' publish_wait=0 and deal_status in (1,2) ','id desc','','',false,'newe');

			$index_list['adv_list'] = $adv_list;
			$index_list['deal_list'] = $result['list'];
			$index_list['deal_all_list'] = $deal_all['list'];//首页调用投标条数 xiejun 2016.07.18
			$index_list['uplan_list'] = $uplan['list'];
			$index_list['newe_list'] = $newe['list'];
			
			$GLOBALS['cache']->set("MOBILE_INDEX_ADVS",$index_list);		
		}
		
		$root['index_list'] = $index_list;
		$root['deal_cate_list'] = getDealCateArray();//分类
		
		if(strim($GLOBALS['m_config']['sina_app_key'])!=""&&strim($GLOBALS['m_config']['sina_app_secret'])!="")
		{
			$root['api_sina'] = 1;
			$root['sina_app_key'] = $GLOBALS['m_config']['sina_app_key'];
			$root['sina_app_secret'] = $GLOBALS['m_config']['sina_app_secret'];
			$root['sina_bind_url'] = $GLOBALS['m_config']['sina_bind_url'];
		}
		if(strim($GLOBALS['m_config']['tencent_app_key'])!=""&&strim($GLOBALS['m_config']['tencent_app_secret'])!="")
		{
			$root['api_tencent'] = 1;
			$root['tencent_app_key'] = $GLOBALS['m_config']['tencent_app_key'];
			$root['tencent_app_secret'] = $GLOBALS['m_config']['tencent_app_secret'];
			$root['tencent_bind_url'] = $GLOBALS['m_config']['tencent_bind_url'];
		}

		output($root);
	}
}

function getDealCateArray(){
	//$land_list = FanweService::instance()->cache->loadCache("land_list");
		
		$sql = "select id, pid, name, icon from ".DB_PREFIX."deal_cate where pid = 0 and is_effect = 1 and is_delete = 0 order by sort desc ";
		//echo $sql; exit;
		$list = $GLOBALS['db']->getAll($sql);

	return $list;
}
?>