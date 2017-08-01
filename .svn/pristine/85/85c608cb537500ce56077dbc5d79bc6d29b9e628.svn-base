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
<div class="main_title"><?php echo L("EDIT");?> <a href="<?php echo u("ApiLogin/index");?>" class="back_list"><?php echo L("BACK_LIST");?></a></div>
<div class="blank5"></div>
<form name="edit" action="__APP__" method="post" enctype="multipart/form-data">
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("SMS_NAME");?>:</td>
		<td class="item_input">
			<?php echo ($data["name"]); ?>
			<input type="hidden" value="<?php echo ($data["name"]); ?>" name="name" />
			<input type="hidden" value="<?php echo (intval($data["is_weibo"])); ?>" name="is_weibo" />
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("CLASS_NAME");?>:</td>
		<td class="item_input">
			<?php echo ($data["class_name"]); ?>
			<input type="hidden" value="<?php echo ($data["class_name"]); ?>" name="class_name" />
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("ICON");?>:</td>
		<td class="item_input">
			<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='<?php echo ($data["icon"]); ?>' name='icon' id='keimg_h_icon_i' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='icon'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='<?php if($data["icon"] == ''): ?>./admin/Tpl/default/Common/images/no_pic.gif<?php else: ?><?php echo ($data["icon"]); ?><?php endif; ?>' target='_blank' id='keimg_a_icon' ><img src='<?php if($data["icon"] == ''): ?>./admin/Tpl/default/Common/images/no_pic.gif<?php else: ?><?php echo ($data["icon"]); ?><?php endif; ?>' id='keimg_m_icon' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='/admin/Tpl/default/Common/images/del.gif' style='<?php if($data["icon"] == ''): ?>display:none<?php endif; ?>; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='icon' title='删除'>
				</div>
			</div>
		</div>
		</span>
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("BICON");?>:</td>
		<td class="item_input">
			<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='<?php echo ($data["bicon"]); ?>' name='bicon' id='keimg_h_bicon_i' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='bicon'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='<?php if($data["bicon"] == ''): ?>./admin/Tpl/default/Common/images/no_pic.gif<?php else: ?><?php echo ($data["bicon"]); ?><?php endif; ?>' target='_blank' id='keimg_a_bicon' ><img src='<?php if($data["bicon"] == ''): ?>./admin/Tpl/default/Common/images/no_pic.gif<?php else: ?><?php echo ($data["bicon"]); ?><?php endif; ?>' id='keimg_m_bicon' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='/admin/Tpl/default/Common/images/del.gif' style='<?php if($data["bicon"] == ''): ?>display:none<?php endif; ?>; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='bicon' title='删除'>
				</div>
			</div>
		</div>
		</span>
		</td>
	</tr>
	<?php if($data['config']): ?><tr>
		<td class="item_title"><?php echo L("CONFIG_INFO");?>:</td>
		<td class="item_input">
			<?php if(is_array($data["config"])): foreach($data["config"] as $key=>$config): ?><?php $config_name = $key; ?>
				<span class="cfg_title"><?php echo trim($data['lang'][$key]);?>:</span>
				<span class="cfg_content">
				<?php if($config['INPUT_TYPE'] == 0): ?><input type="text" class="textbox" name="config[<?php echo ($key); ?>]" value="<?php echo ($vo['config'][$key]); ?>" />
				<?php elseif($config['INPUT_TYPE'] == 2): ?>
				<input type="password" class="textbox" name="config[<?php echo ($key); ?>]" value="<?php echo ($vo['config'][$key]); ?>" />
				<?php else: ?>
				<select name="config[<?php echo ($key); ?>]" >
					<?php if(is_array($config["VALUES"])): foreach($config["VALUES"] as $key=>$val): ?><option value="<?php echo ($val); ?>" <?php if($vo['config'][$config_name] == $val): ?>selected="selected"<?php endif; ?>><?php echo trim($data['lang'][$config_name."_".$val]);?></option><?php endforeach; endif; ?>
				</select><?php endif; ?>
				</span>
				<div class="blank5"></div><?php endforeach; endif; ?>
		</td>
	</tr><?php endif; ?>
</table>
<div class="blank5"></div>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">操作密码:</td>
		<td class="item_input">
			<input type="password" class="textbox" name="operatepwd" value=""/>
		</td>
	</tr>
	<tr>
		<td class="item_title"></td>
		<td class="item_input">
			<!--隐藏元素-->
			<input type="hidden" value="<?php echo ($vo["id"]); ?>" name="id" />
			<input type="hidden" name="<?php echo conf("VAR_MODULE");?>" value="ApiLogin" />
			<input type="hidden" name="<?php echo conf("VAR_ACTION");?>" value="update" />
			<!--隐藏元素-->
			<input type="submit" class="button" value="<?php echo L("EDIT");?>" />
			<input type="reset" class="button" value="<?php echo L("RESET");?>" />
		</td>
	</tr>
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>	 
</form>
</div>
</body>
</html>