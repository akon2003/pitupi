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

<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<div class="main main-size16">
<div class="main_title">成员提成统计</div>
<script type="text/javascript">
	function view(id){
		window.location.href = ROOT+'?m=MyManager&a=referrals_details&admin_id='+id;
	}
	function export_referrals_csv()
	{
		var param = '';
		if ($("#begin_time").val() != "") {
			param += '&begin_time='+$("#begin_time").val();
		}
		if ($("#end_time").val() != "") {
			param += '&end_time='+$("#end_time").val();
		}
		if ($("select[name='deal_id']").val() > 0) {
			param += '&deal_id='+$("select[name='deal_id']").val();
		}
		if ($("select[name='admin_id']").val() > 0) {
			param += '&admin_id='+$("select[name='admin_id']").val();
		}
		var url= ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=export_referrals_csv";
		location.href = url+param;
	}
</script>
<?php function view($id){
		return '<a href="javascript:view('.$id.')">查看</a>';
	} ?>
<div class="blank5"></div>
<form name="search" action="__APP__" method="get">	
	<div class="search_row">
		投标时间：<input type="text" class="textbox" name="begin_time" id="begin_time" value="<?php echo trim($_REQUEST['begin_time']);?>" onfocus="return showCalendar('begin_time', '%Y-%m-%d', false, false, 'begin_time');" />
		-
		<input type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d', false, false, 'end_time');" />
		专属客服：<select name="admin_id">
		<option value="-1" <?php if(intval($_REQUEST['admin_id']) == 0): ?>selected="selected"<?php endif; ?>>全部</option>
			<?php if(is_array($admin_list)): foreach($admin_list as $key=>$admin_item): ?><option value="<?php echo ($admin_item["id"]); ?>" <?php if(intval($_REQUEST['admin_id']) == $admin_item['id']): ?>selected="selected"<?php endif; ?>><?php echo ($admin_item["real_name"]); ?></option><?php endforeach; endif; ?>
		</select>
		<input type="hidden" value="MyManager" name="m" />
		<input type="hidden" value="referrals" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="reset" class="button" value="重置" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_referrals_csv();" />
	</div>
	<div class="blank5"></div>
</form>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="11" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','MyManager','referrals')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('adm_name','<?php echo ($sort); ?>','MyManager','referrals')" title="按照成员ID   <?php echo ($sortType); ?> ">成员ID   <?php if(($order)  ==  "adm_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('real_name','<?php echo ($sort); ?>','MyManager','referrals')" title="按照成员名   <?php echo ($sortType); ?> ">成员名   <?php if(($order)  ==  "real_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pid','<?php echo ($sort); ?>','MyManager','referrals')" title="按照所属部门   <?php echo ($sortType); ?> ">所属部门   <?php if(($order)  ==  "pid"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('role_id','<?php echo ($sort); ?>','MyManager','referrals')" title="按照所属角色   <?php echo ($sortType); ?> ">所属角色   <?php if(($order)  ==  "role_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('begin_time','<?php echo ($sort); ?>','MyManager','referrals')" title="按照起始时间   <?php echo ($sortType); ?> ">起始时间   <?php if(($order)  ==  "begin_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('end_time','<?php echo ($sort); ?>','MyManager','referrals')" title="按照截止时间   <?php echo ($sortType); ?> ">截止时间   <?php if(($order)  ==  "end_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('deal_name','<?php echo ($sort); ?>','MyManager','referrals')" title="按照标题   <?php echo ($sortType); ?> ">标题   <?php if(($order)  ==  "deal_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('count_users','<?php echo ($sort); ?>','MyManager','referrals')" title="按照投资人数   <?php echo ($sortType); ?> ">投资人数   <?php if(($order)  ==  "count_users"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('count_money','<?php echo ($sort); ?>','MyManager','referrals')" title="按照投资金额   <?php echo ($sortType); ?> ">投资金额   <?php if(($order)  ==  "count_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','MyManager','referrals')" title="按照查看<?php echo ($sortType); ?> ">查看<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$customer): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($customer["id"])); ?></td><td>&nbsp;<?php echo ($customer["adm_name"]); ?></td><td>&nbsp;<?php echo ($customer["real_name"]); ?></td><td>&nbsp;<?php echo (get_admin_name($customer["pid"])); ?></td><td>&nbsp;<?php echo (get_role_name($customer["role_id"])); ?></td><td>&nbsp;<?php echo ($customer["begin_time"]); ?></td><td>&nbsp;<?php echo ($customer["end_time"]); ?></td><td>&nbsp;<?php echo ($customer["deal_name"]); ?></td><td>&nbsp;<?php echo ($customer["count_users"]); ?></td><td>&nbsp;<?php echo (format_price($customer["count_money"])); ?></td><td>&nbsp;<?php echo (view($customer["id"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="11" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->


<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>

<script type="text/javascript">
	$("form[name='search']").bind("reset", function() {
		$(this).find("input:text").val("");
		$(this).find("select[name='deal_id']").val(-1);
		$(this).find("select[name='admin_id']").val(-1);
		return false;
	});
</script>