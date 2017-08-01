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

<?php function get_is_reset($status)
	{
		if($status==1)
		return l("YES");
		else
		return l("NO");
	} ?>
<script type="text/javascript">
	function send_demo()
	{		
		$.ajax({ 
			url: ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=send_demo&test_mail="+$.trim($("input[name='test_email']").val())+"&operatepwd="+$.trim($("input[name='operatepwd']").val()), 
			data: "ajax=1",
			dataType: "json",
			success: function(obj){
				if(obj.status==0)
				{
					alert(obj.info);
				}
				else
				$("#info").html(obj.info);
			}
		});
	}
	$(document).ready(function(){
		$("input[name='test_mail_btn']").bind("click",function(){
			var mail = $.trim($("input[name='test_email']").val());	
			if(mail!='')
			send_demo();
		});
	});
</script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?>
	<input type="text" class="textbox" name="test_email" placeholder="邮件地址" size="10"/>
	<input type="password" class="textbox" name="operatepwd" placeholder="操作密码" size="10"/>
	<input type="button" class="button" name="test_mail_btn" value="<?php echo L("TEST");?>" />
</div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="新增邮件服务器" onclick="add();" />
	<input type="button" class="button" value="编辑邮件服务器" onclick="_edit()" />
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="7" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','MailServer','index')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('smtp_server','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("SMTP_SERVER");?>   <?php echo ($sortType); ?> "><?php echo L("SMTP_SERVER");?>   <?php if(($order)  ==  "smtp_server"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('smtp_name','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("SMTP_NAME");?>   <?php echo ($sortType); ?> "><?php echo L("SMTP_NAME");?>   <?php if(($order)  ==  "smtp_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('use_limit','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("USE_LIMIT");?>   <?php echo ($sortType); ?> "><?php echo L("USE_LIMIT");?>   <?php if(($order)  ==  "use_limit"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('total_use','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("TOTAL_USE");?>   <?php echo ($sortType); ?> "><?php echo L("TOTAL_USE");?>   <?php if(($order)  ==  "total_use"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_reset','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("IS_RESET");?>   <?php echo ($sortType); ?> "><?php echo L("IS_RESET");?>   <?php if(($order)  ==  "is_reset"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_effect','<?php echo ($sort); ?>','MailServer','index')" title="按照<?php echo L("IS_EFFECT");?><?php echo ($sortType); ?> "><?php echo L("IS_EFFECT");?><?php if(($order)  ==  "is_effect"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$serveritem): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($serveritem["id"])); ?></td><td>&nbsp;<?php echo ($serveritem["smtp_server"]); ?></td><td>&nbsp;<?php echo ($serveritem["smtp_name"]); ?></td><td>&nbsp;<?php echo ($serveritem["use_limit"]); ?></td><td>&nbsp;<?php echo ($serveritem["total_use"]); ?></td><td>&nbsp;<?php echo (get_is_reset($serveritem["is_reset"])); ?></td><td>&nbsp;<?php echo (get_is_effect($serveritem["is_effect"],$serveritem['id'])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="7" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>