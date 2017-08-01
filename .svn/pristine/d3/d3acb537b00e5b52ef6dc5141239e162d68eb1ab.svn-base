<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/__style__.css" />
<script type="text/javascript" src="__TMPL__Common/js/check_dog.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/IA300ClientJavascript.js"></script>
<script type="text/javascript">
 	var VAR_MODULE = "<?php echo conf("VAR_MODULE");?>";
	var VAR_ACTION = "<?php echo conf("VAR_ACTION");?>";
	var MODULE_NAME	=	'<?php echo MODULE_NAME; ?>';
	var ACTION_NAME	=	'<?php echo ACTION_NAME; ?>';
	var ROOT = '__APP__';
	var ROOT_PATH = '<?php echo APP_ROOT; ?>';
	var CURRENT_URL = '<?php echo trim($_SERVER['REQUEST_URI']);?>';
	var INPUT_KEY_PLEASE = "<?php echo L("INPUT_KEY_PLEASE");?>";
	var TMPL = '__TMPL__';
	var APP_ROOT = '<?php echo APP_ROOT; ?>';
	var FILE_UPLOAD_URL = ROOT   + "?m=file&a=do_upload";
	var EMOT_URL = '<?php echo APP_ROOT; ?>/public/emoticons/';
	var MAX_FILE_SIZE = "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
	var LOGINOUT_URL = '<?php echo u("Public/do_loginout");?>';
	var WEB_SESSION_ID = '<?php echo es_session::id(); ?>';
	CHECK_DOG_HASH = '<?php $adm_session = es_session::get(md5(conf("AUTH_KEY"))); echo $adm_session["adm_dog_key"]; ?>';
	function check_dog_sender_fun()
	{
		window.clearInterval(check_dog_sender);
		check_dog2();
	}
	var check_dog_sender = window.setInterval("check_dog_sender_fun()",5000);
</script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.timer.js"></script>
<script type="text/javascript" src="__ROOT__/public/runtime/admin/lang.js"></script>
<script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/kindeditor.js'></script>
<script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/lang/zh_CN.js'></script>
<script type="text/javascript" src="__TMPL__Common/js/script.js"></script>
</head>
<body onLoad="javascript:DogPageLoad();">
<div id="info"></div>

<script type="text/javascript" src="/app/Tpl/new/js/script.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">
	function show_detail(id)
	{
		window.location.href=ROOT+'?m=Deal&a=show_detail&id='+id;
	}
	function repay_plan(id)
	{
		window.location.href=ROOT+'?m=Deal&a=repay_plan&id='+id;
	}
</script>
<?php function a_get_buy_status($buy_status,$deal)
	{
		if($deal['is_effect'] == 0){
			return l("IS_EFFECT_0");
		}
		if($buy_status==2){
			return "<span style='color:red'>".l("DEAL_STATUS_".$buy_status)."</span>";
		}
		else{
			if($deal['deal_status'] == 1 && ($deal['start_time'] + $deal['enddate'] *24*3600 - 1) < TIME_UTC){
				return "已过期";
			}
			elseif($deal['deal_status'] == 1 && $deal['start_time'] > TIME_UTC)
				return "<span style='color:red'>未开始</span>";
			else
				return l("DEAL_STATUS_".$buy_status);
		}
	}
	function get_repay_plan($id,$deal){
		if($deal['deal_status']>=4) {
			return '<a href="javascript:repay_plan('.$id.');">还款计划</a>';
		}
	}
	function show_detail($id,$deal){
		if(((($deal['start_time'] + $deal['end_date'] *24*3600 - 1) > TIME_UTC) && $deal['deal_status'] == 1) || $deal['deal_status']==2 || ($deal['deal_status']==1 && $deal['buy_count'] > 0) || $deal['deal_status']>=4){
			return '<a href="javascript:show_detail('.$id.');">投标详情和操作</a>';
		}
	} ?>
<div class="main main-size16">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("DEAL_NAME");?>：<input type="text" class="textbox" name="name" value="<?php echo trim($_REQUEST['name']);?>" />
		借款客户：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" size="10" />
		借款期数：<select name="repay_time">
			<option value="0" <?php if(intval($_REQUEST['repay_time']) == 0): ?>selected="selected"<?php endif; ?>>全部</option>
			<option value="1" <?php if(intval($_REQUEST['repay_time']) == 1): ?>selected="selected"<?php endif; ?>>一个月</option>
			<option value="3" <?php if(intval($_REQUEST['repay_time']) == 3): ?>selected="selected"<?php endif; ?>>三个月</option>
			<option value="6" <?php if(intval($_REQUEST['repay_time']) == 6): ?>selected="selected"<?php endif; ?>>六个月</option>
			<option value="12" <?php if(intval($_REQUEST['repay_time']) == 12): ?>selected="selected"<?php endif; ?>>十二个月</option>
		</select>
		用途：<select name="type_id">
			<option value="0" <?php if(intval($_REQUEST['type_id']) == 0): ?>selected="selected"<?php endif; ?>><?php echo L("NO_SELECT_CATE");?></option>
			<?php if(is_array($type_tree)): foreach($type_tree as $key=>$type_item): ?><option value="<?php echo ($type_item["id"]); ?>" <?php if(intval($_REQUEST['type_id']) == $type_item['id']): ?>selected="selected"<?php endif; ?>><?php echo ($type_item["title_show"]); ?></option><?php endforeach; endif; ?>
		</select>		
		<?php if(ACTION_NAME == 'index'): ?>借款状态：<select name="deal_status">
			<option value="all" <?php if($_REQUEST['deal_status'] == 'all' || trim($_REQUEST['deal_status']) == ''): ?>selected="selected"<?php endif; ?>>所有状态</option>
			<option value="0" <?php if($_REQUEST['deal_status'] != 'all' && trim($_REQUEST['deal_status']) != '' && intval($_REQUEST['deal_status']) == 0): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_0");?></option>
			<option value="1" <?php if(intval($_REQUEST['deal_status']) == 1): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_1");?></option>
			<option value="2" <?php if(intval($_REQUEST['deal_status']) == 2): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_2");?></option>
			<option value="6" <?php if(intval($_REQUEST['deal_status']) == 6): ?>selected="selected"<?php endif; ?>>已过期</option>
			<option value="3" <?php if(intval($_REQUEST['deal_status']) == 3): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_3");?></option>
			<option value="4" <?php if(intval($_REQUEST['deal_status']) == 4): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_4");?></option>
			<option value="5" <?php if(intval($_REQUEST['deal_status']) == 5): ?>selected="selected"<?php endif; ?>><?php echo L("DEAL_STATUS_5");?></option>
		</select><?php endif; ?>        
		<input type="hidden" value="Deal" name="m" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="a" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="c" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
    	<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv();" />
	</form>
</div>
<div class="blank5"></div>

<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable dataTableSelect dataTableSelectDblclick" cellpadding=0 cellspacing=0 ><tr><td colspan="16" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Deal','index')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','Deal','index')" title="按照借款客户   <?php echo ($sortType); ?> ">借款客户   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','Deal','index')" title="按照客户名称   <?php echo ($sortType); ?> ">客户名称   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('name','<?php echo ($sort); ?>','Deal','index')" title="按照<?php echo L("DEAL_NAME");?><?php echo ($sortType); ?> "><?php echo L("DEAL_NAME");?><?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('deal_sn','<?php echo ($sort); ?>','Deal','index')" title="按照债权合同号   <?php echo ($sortType); ?> ">债权合同号   <?php if(($order)  ==  "deal_sn"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('borrow_amount','<?php echo ($sort); ?>','Deal','index')" title="按照金额   <?php echo ($sortType); ?> ">金额   <?php if(($order)  ==  "borrow_amount"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('repay_time','<?php echo ($sort); ?>','Deal','index')" title="按照期数   <?php echo ($sortType); ?> ">期数   <?php if(($order)  ==  "repay_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('rate','<?php echo ($sort); ?>','Deal','index')" title="按照利率(%)   <?php echo ($sortType); ?> ">利率(%)   <?php if(($order)  ==  "rate"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('loantype','<?php echo ($sort); ?>','Deal','index')" title="按照还款方式   <?php echo ($sortType); ?> ">还款方式   <?php if(($order)  ==  "loantype"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('deal_status','<?php echo ($sort); ?>','Deal','index')" title="按照<?php echo L("DEAL_STATUS");?>   <?php echo ($sortType); ?> "><?php echo L("DEAL_STATUS");?>   <?php if(($order)  ==  "deal_status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('repay_start_time','<?php echo ($sort); ?>','Deal','index')" title="按照放款日   <?php echo ($sortType); ?> ">放款日   <?php if(($order)  ==  "repay_start_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Deal','index')" title="按照到期日   <?php echo ($sortType); ?> ">到期日   <?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="60px   "><a href="javascript:sortBy('buy_count','<?php echo ($sort); ?>','Deal','index')" title="按照投标数<?php echo ($sortType); ?> ">投标数<?php if(($order)  ==  "buy_count"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_effect','<?php echo ($sort); ?>','Deal','index')" title="按照<?php echo L("IS_EFFECT");?>    <?php echo ($sortType); ?> "><?php echo L("IS_EFFECT");?>    <?php if(($order)  ==  "is_effect"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Deal','index')" title="按照还款计划   <?php echo ($sortType); ?> ">还款计划   <?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Deal','index')" title="按照投标详情和操作<?php echo ($sortType); ?> ">投标详情和操作<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($deal["id"])); ?></td><td>&nbsp;<?php echo (get_user_name_iframe($deal["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($deal["user_id"])); ?></td><td>&nbsp;<a href="javascript:edit   ('<?php echo (addslashes($deal["id"])); ?>')"><?php echo ($deal["name"]); ?></a></td><td>&nbsp;<?php echo ($deal["deal_sn"]); ?></td><td>&nbsp;<?php echo (format_price($deal["borrow_amount"])); ?></td><td>&nbsp;<?php echo (get_time_type($deal["repay_time"],$deal)); ?></td><td>&nbsp;<?php echo ($deal["rate"]); ?></td><td>&nbsp;<?php echo (loantypename($deal["loantype"],1)); ?></td><td>&nbsp;<?php echo (a_get_buy_status($deal["deal_status"],$deal)); ?></td><td>&nbsp;<?php echo (to_date($deal["repay_start_time"],'Y-m-d')); ?></td><td>&nbsp;<?php echo (get_deal_end_repay_time($deal["id"])); ?></td><td>&nbsp;<?php echo ($deal["buy_count"]); ?></td><td>&nbsp;<?php echo (get_is_effect($deal["is_effect"])); ?></td><td>&nbsp;<?php echo (get_repay_plan($deal["id"],$deal)); ?></td><td>&nbsp;<?php echo (show_detail($deal["id"],$deal)); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="16" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>