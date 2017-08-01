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
<script type="text/javascript" src="__TMPL__Common/js/carry.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form method='post' id="form" name="form" action="__APP__">
		订单号：<input type="text" class="textbox" name="notice_sn" id="notice_sn" value="<?php echo trim($_REQUEST['notice_sn']);?>" style="width:160px;" />
		<input type="hidden" value="UserCarry" name="m" />
		<input type="hidden" value="<?php echo ($act); ?>" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
	</form>
</div>
<div class="blank5"></div>
<?php if($notice_sn != ''): ?><table cellpadding="4" cellspacing="0" border="0" class="form">
    <tr>
        <td class="topTd"></td>
    </tr>
    <tr>
        <td id="confirm_result"><?php echo ($result); ?></td>
    </tr>
	<?php if($valid == 1): ?><tr id="confirm_update_show">
        <td>
			<input type="button" class="button" id="confirm_update_button" value="余额不足--返回到待审核状态" />
		</td>
    </tr><?php endif; ?>
    <tr>
        <td class="bottomTd"></td>
    </tr>
</table><?php endif; ?>
</div>

<script type="text/javascript">
	$("#confirm_update_button").click(function() {
		if (confirm("是否确定返回到待审核状态")) {
			var pass = prompt("请输入约定的密码","");
			if (pass == "") { return false; }

			var ajaxurl = APP_ROOT+"/m.php?m=UserCarry&a=<?php echo ($act); ?>";

			var query = new Object();
			query.ajax = 1;
			query.confirm = 1;
			query.notice_sn = $("#notice_sn").val();
			query.pass = pass;		
			$.ajax({ 
				url: ajaxurl,
				data: query,
				type: "POST",
				dataType: "json",
				success: function(result){
					if (result.status == 1) {
						alert(result.msg);
						$("confirm_result").html(result.msg);
						$("#confirm_update_show").hide();
					} else {
						alert(result.msg);
					}
				},error:function(e){
					alert("系统异常,请稍后处理");
				}
			});	
		}
	});
</script>