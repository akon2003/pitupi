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

<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">
function export_csv_site_money()
{
	var inputs = $(".search_row").find("input");
	var selects = $(".search_row").find("select");
	var param = '';
	for(i=0;i<inputs.length;i++)
	{
		if(inputs[i].name!='m'&&inputs[i].name!='a')
		param += "&"+inputs[i].name+"="+$(inputs[i]).val();
	}
	for(i=0;i<selects.length;i++)
	{
		param += "&"+selects[i].name+"="+$(selects[i]).val();
	}
	var url= ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=export_csv_site_money_report";
	location.href = url+param;
}

</script>
<?php function local_format_price($money) {
	if ($money == 0 || $money == "") {
		return "";
	} else {
		return format_price($money);
	}
} ?>
<style type="text/css">
	#J_view_repay_plan th{ color:#fff; padding:5px 0}
</style>
<div class="main main-size09">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get" id="ThreeGetForm">	
		查询时间：<input type="text" class="textbox" name="begin_time" id="begin_time" value="<?php echo trim($_REQUEST['begin_time']);?>" onfocus="return showCalendar('begin_time', '%Y-%m-%d', false, false, 'begin_time');" />
		-
		<input type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d', false, false, 'end_time');" />
		<input type="hidden" value="Deal" name="m" />
		<input type="hidden" value="site_money_report" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="reset" class="button" value="重置" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv_site_money();" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="6" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('report_date','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照日期   <?php echo ($sortType); ?> ">日期   <?php if(($order)  ==  "report_date"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照总金额   <?php echo ($sortType); ?> ">总金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('loan_fee','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照风险管理费   <?php echo ($sortType); ?> ">风险管理费   <?php if(($order)  ==  "loan_fee"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('service_fee','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照融资服务费   <?php echo ($sortType); ?> ">融资服务费   <?php if(($order)  ==  "service_fee"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('xiwei_fee','<?php echo ($sort); ?>','Deal','site_money_report')" title="按照尽职调查费<?php echo ($sortType); ?> ">尽职调查费<?php if(($order)  ==  "xiwei_fee"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($deal["id"]); ?></td><td>&nbsp;<?php echo ($deal["report_date"]); ?></td><td>&nbsp;<?php echo (format_price($deal["money"])); ?></td><td>&nbsp;<?php echo (local_format_price($deal["loan_fee"])); ?></td><td>&nbsp;<?php echo (local_format_price($deal["service_fee"])); ?></td><td>&nbsp;<?php echo (local_format_price($deal["xiwei_fee"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="6" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="search_row">
	收入总额: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["money"])); ?></span>元&nbsp;
	融资风险管理费: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["loan_fee"])); ?></span>元&nbsp;
	融资服务费: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["service_fee"])); ?></span>元&nbsp;
	尽职调查费: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["xiwei_fee"])); ?></span>元&nbsp;
</div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>

<script type="text/javascript">
	$("form[name='search']").bind("reset", function() {
		$(this).find("input:text").val("");
		$(this).find("select[name='status']").val("-1");
		return false;
	});
</script>