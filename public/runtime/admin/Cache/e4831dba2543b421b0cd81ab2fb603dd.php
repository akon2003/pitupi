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

<div class="main main-size09">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("KEYWORD");?>：<input type="text" class="textbox" name="log_info" value="<?php echo trim($_REQUEST['log_info']);?>" />		
		<?php echo L("LOG_TIME");?>：
		<input type="text" class="textbox" name="log_begin_time" id="log_begin_time" value="<?php echo trim($_REQUEST['log_begin_time']);?>" onfocus="return showCalendar('log_begin_time', '%Y-%m-%d %H:%M:%S', false, false, 'log_begin_time');" />
		-
		<input type="text" class="textbox" name="log_end_time" id="log_end_time" value="<?php echo trim($_REQUEST['log_end_time']);?>" onfocus="return showCalendar('log_end_time', '%Y-%m-%d %H:%M:%S', false, false, 'log_end_time');" />
		<input type="hidden" value="Log" name="m" />
		<input type="hidden" value="index" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="9" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_info','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("LOG_INFO");?>   <?php echo ($sortType); ?> "><?php echo L("LOG_INFO");?>   <?php if(($order)  ==  "log_info"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_time','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("LOG_TIME");?>   <?php echo ($sortType); ?> "><?php echo L("LOG_TIME");?>   <?php if(($order)  ==  "log_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_ip','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("LOG_IP");?>   <?php echo ($sortType); ?> "><?php echo L("LOG_IP");?>   <?php if(($order)  ==  "log_ip"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_admin','<?php echo ($sort); ?>','Log','index')" title="按照管理员ID   <?php echo ($sortType); ?> ">管理员ID   <?php if(($order)  ==  "log_admin"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_admin','<?php echo ($sort); ?>','Log','index')" title="按照管理员   <?php echo ($sortType); ?> ">管理员   <?php if(($order)  ==  "log_admin"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_status','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("LOG_STATUS");?>   <?php echo ($sortType); ?> "><?php echo L("LOG_STATUS");?>   <?php if(($order)  ==  "log_status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('module','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("MODULE");?>   <?php echo ($sortType); ?> "><?php echo L("MODULE");?>   <?php if(($order)  ==  "module"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('action','<?php echo ($sort); ?>','Log','index')" title="按照<?php echo L("ACTION");?><?php echo ($sortType); ?> "><?php echo L("ACTION");?><?php if(($order)  ==  "action"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo ($log["log_info"]); ?></td><td>&nbsp;<?php echo (to_date($log["log_time"])); ?></td><td>&nbsp;<?php echo ($log["log_ip"]); ?></td><td>&nbsp;<?php echo (get_admin_name($log["log_admin"])); ?></td><td>&nbsp;<?php echo (get_admin_real_name($log["log_admin"])); ?></td><td>&nbsp;<?php echo (get_log_status($log["log_status"])); ?></td><td>&nbsp;<?php echo ($log["module"]); ?></td><td>&nbsp;<?php echo ($log["action"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="9" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>