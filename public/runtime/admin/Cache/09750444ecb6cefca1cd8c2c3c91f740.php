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

<div class="main">
<div class="main_title"><?php echo ($main_title); ?> </div>
<div class="blank5"></div>
<form name="edit" action="__APP__" method="post" enctype="multipart/form-data">
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">个人账号:</td>
		<td class="item_input"><?php echo ($adm_data["adm_name"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">用户名:</td>
		<td class="item_input"><?php echo ($adm_data["real_name"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">用户角色:</td>
		<td class="item_input"><?php echo ($adm_data["role_name"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">所属部门:</td>
		<td class="item_input"><?php echo ($adm_data["department_name"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">授权中心:</td>
		<td class="item_input"><?php echo ($adm_data["authority_name"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">手机号:</td>
		<td class="item_input"><?php echo ($adm_data["mobile"]); ?></td>
	</tr>
	<tr>
		<td class="item_title">操作权限:</td>
		<td class="item_input"><?php if($adm_data['operate_authority'] != ''): ?><?php echo ($adm_data["operate_authority"]); ?><?php else: ?>无操作权限<?php endif; ?></td>
	</tr>
	<tr>
		<td class="item_title">登录密码:</td>
		<td class="item_input">
			<a href="<?php echo u("Index/change_password");?>">修改</a>
		</td>
	</tr>
	<?php if($adm_data['operate_authority'] != ''): ?><tr>
		<td class="item_title">操作密码:</td>
		<td class="item_input">
			<a href="<?php echo u("Index/change_password_operate");?>">修改</a>&nbsp;
			<a href="<?php echo u("Index/change_password_reset");?>">重置</a>&nbsp;
		</td>
	</tr><?php endif; ?>
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>
</form>
</div>
</body>
</html>