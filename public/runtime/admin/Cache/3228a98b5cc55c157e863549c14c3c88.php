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
<script type="text/javascript" src="__TMPL__Common/js/user.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/carry.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">
	var r_status = '<?php echo $_REQUEST['status']; ?>';
</script>
<!-- 提现处理 -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#dataTable tr").bind("dblclick", function() {
			var item = $("#dataTable input:checkbox:checked");
			if (item.length == 0) {
				alert("请选择需要处理的申请"); 
			} else {
				modify_carry(item.eq(0).val());
			}
			return false;
		});
	});
</script>
<div class="main main-size16">
<div class="main_title"><?php echo L(MODULE_NAME."_".ACTION_NAME);?></div>
<div class="blank5"></div>
<?php function get_carry_status($status){
		return l("CARRY_STATUS_".$status);
	}
	function modify_carry($id,$user){
		if($user['status']!=4) {
			return '<a href="javascript:modify_carry('.$id.');">查看/处理</a>';
		}
	} ?>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("USER_NAME");?>：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" style="width:100px;" />
		<?php if(ACTION_NAME == 'index'): ?>状态：<select name="status">
			<option value=""><?php echo L("ALL");?></option>
			<option value="0" <?php if($_REQUEST['status']!='' && intval($_REQUEST['status']) == 0): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_0");?></option>
			<option value="3" <?php if(intval($_REQUEST['status']) == 3): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_3");?></option>
			<option value="1" <?php if(intval($_REQUEST['status']) == 1): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_1");?></option>
			<option value="2" <?php if(intval($_REQUEST['status']) == 2): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_2");?></option>
			<option value="4" <?php if(intval($_REQUEST['status']) == 4): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_4");?></option>
			<option value="5" <?php if(intval($_REQUEST['status']) == 5): ?>selected="selected"<?php endif; ?>><?php echo L("CARRY_STATUS_5");?></option>
		</select><?php endif; ?>
		申请时间：<input type="text" class="textbox" name="start_time" id="start_time" value="<?php echo trim($_REQUEST['start_time']);?>" onfocus="return showCalendar('start_time', '%Y-%m-%d', false, false, 'start_time');" />
		-
		<input type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d', false, false, 'end_time');" />
		<input type="hidden" value="UserCarry" name="m" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="a" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="status_type" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="reset" class="button" value="重置" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv();" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable dataTableSelect" cellpadding=0 cellspacing=0 ><tr><td colspan="13" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照<?php echo L("USER_ID");?>   <?php echo ($sortType); ?> "><?php echo L("USER_ID");?>   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照<?php echo L("USER_NAME");?>   <?php echo ($sortType); ?> "><?php echo L("USER_NAME");?>   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','UserCarry','wait')" title="按照提现金额   <?php echo ($sortType); ?> ">提现金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('fee','<?php echo ($sort); ?>','UserCarry','wait')" title="按照手续费   <?php echo ($sortType); ?> ">手续费   <?php if(($order)  ==  "fee"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','UserCarry','wait')" title="按照申请时间   <?php echo ($sortType); ?> ">申请时间   <?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="80px   "><a href="javascript:sortBy('status','<?php echo ($sort); ?>','UserCarry','wait')" title="按照提现状态<?php echo ($sortType); ?> ">提现状态<?php if(($order)  ==  "status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('update_time','<?php echo ($sort); ?>','UserCarry','wait')" title="按照处理时间   <?php echo ($sortType); ?> ">处理时间   <?php if(($order)  ==  "update_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照账户余额   <?php echo ($sortType); ?> ">账户余额   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('msg','<?php echo ($sort); ?>','UserCarry','wait')" title="按照原因说明   <?php echo ($sortType); ?> ">原因说明   <?php if(($order)  ==  "msg"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('req_sn','<?php echo ($sort); ?>','UserCarry','wait')" title="按照订单号   <?php echo ($sortType); ?> ">订单号   <?php if(($order)  ==  "req_sn"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('input_user_id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照操作人   <?php echo ($sortType); ?> ">操作人   <?php if(($order)  ==  "input_user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','UserCarry','wait')" title="按照查看/处理<?php echo ($sortType); ?> ">查看/处理<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($user["id"])); ?></td><td>&nbsp;<?php echo (get_user_name_only($user["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($user["user_id"])); ?></td><td>&nbsp;<?php echo (format_price($user["money"])); ?></td><td>&nbsp;<?php echo (format_price($user["fee"])); ?></td><td>&nbsp;<?php echo (to_date($user["create_time"])); ?></td><td>&nbsp;<?php echo (get_carry_status($user["status"])); ?></td><td>&nbsp;<?php echo (to_date($user["update_time"])); ?></td><td>&nbsp;<?php echo (get_user_money($user["user_id"])); ?></td><td>&nbsp;<?php echo ($user["msg"]); ?></td><td>&nbsp;<?php echo ($user["req_sn"]); ?></td><td>&nbsp;<?php echo (get_admin_real_name($user["input_user_id"])); ?></td><td>&nbsp;<?php echo (modify_carry($user["id"],$user)); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="13" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>

<script type="text/javascript">
	$("form[name='search']").bind("reset", function() {
		$(this).find("input:text").val("");
		return false;
	});
</script>