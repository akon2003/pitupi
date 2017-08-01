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

<?php function get_is_paid($status)
	{
		if($status == 0)
		return l("NO");
		else
		return l("YES");
	} ?>
<div class="main main-size16">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("USER_NAME");?>：<input size="6" type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" style="width:100px;" />
		支付状态：<select name="is_paid">
			<option value="-1" <?php if(intval($_REQUEST['is_paid']) == -1 || !isset($_REQUEST['is_paid'])): ?>selected="selected"<?php endif; ?>><?php echo L("ALL");?></option>
			<option value="0" <?php if(intval($_REQUEST['is_paid']) == 0 && isset($_REQUEST['is_paid'])): ?>selected="selected"<?php endif; ?>>未支付</option>
			<option value="1" <?php if(intval($_REQUEST['is_paid']) == 1): ?>selected="selected"<?php endif; ?>>已支付</option>
		</select>			
		交易时间：<input size="8" type="text" class="textbox" name="start_time" id="start_time" value="<?php echo trim($_REQUEST['start_time']);?>" onfocus="return showCalendar('start_time', '%Y-%m-%d', false, false, 'start_time');" />
		-
		<input size="8" type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d', false, false, 'end_time');" />
		<input type="hidden" value="PaymentNotice" name="m" />
		<input type="hidden" value="offline" name="a" />
		<input type="hidden" value="offline" name="act" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="reset" class="button" value="重置" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv();" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="13" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('notice_sn','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照流水号   <?php echo ($sortType); ?> ">流水号   <?php if(($order)  ==  "notice_sn"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("USER_ID");?>   <?php echo ($sortType); ?> "><?php echo L("USER_ID");?>   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("USER_NAME");?>   <?php echo ($sortType); ?> "><?php echo L("USER_NAME");?>   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照交易金额   <?php echo ($sortType); ?> ">交易金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照交易时间   <?php echo ($sortType); ?> ">交易时间   <?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pay_time','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("PAY_TIME");?>   <?php echo ($sortType); ?> "><?php echo L("PAY_TIME");?>   <?php if(($order)  ==  "pay_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_paid','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("IS_PAID");?>   <?php echo ($sortType); ?> "><?php echo L("IS_PAID");?>   <?php if(($order)  ==  "is_paid"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('payment_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("PAYMENT_METHOD");?>   <?php echo ($sortType); ?> "><?php echo L("PAYMENT_METHOD");?>   <?php if(($order)  ==  "payment_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照账户余额   <?php echo ($sortType); ?> ">账户余额   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('input_user_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照操作用户ID   <?php echo ($sortType); ?> ">操作用户ID   <?php if(($order)  ==  "input_user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('input_user_id','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照操作用户   <?php echo ($sortType); ?> ">操作用户   <?php if(($order)  ==  "input_user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','PaymentNotice','offline')" title="按照<?php echo L("PAYMENT_MEMO");?><?php echo ($sortType); ?> "><?php echo L("PAYMENT_MEMO");?><?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payment_notice): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($payment_notice["id"]); ?></td><td>&nbsp;<?php echo ($payment_notice["notice_sn"]); ?></td><td>&nbsp;<?php echo (get_user_name_only($payment_notice["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($payment_notice["user_id"])); ?></td><td>&nbsp;<?php echo (format_price($payment_notice["money"])); ?></td><td>&nbsp;<?php echo (to_date($payment_notice["create_time"])); ?></td><td>&nbsp;<?php echo (to_date($payment_notice["pay_time"])); ?></td><td>&nbsp;<?php echo (get_is_paid($payment_notice["is_paid"])); ?></td><td>&nbsp;<?php echo (get_payment_name($payment_notice["payment_id"])); ?></td><td>&nbsp;<?php echo (get_user_money($payment_notice["user_id"])); ?></td><td>&nbsp;<?php echo (get_admin_name($payment_notice["input_user_id"])); ?></td><td>&nbsp;<?php echo (get_admin_real_name($payment_notice["input_user_id"])); ?></td><td>&nbsp;<?php echo ($payment_notice["memo"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="13" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>

<script type="text/javascript">
	$("form[name='search']").bind("reset", function() {
		$(this).find("input:text").val("");
		$(this).find("select[name='payment_id']").val(0);
		$(this).find("select[name='is_paid']").val(-1);
		return false;
	});
</script>