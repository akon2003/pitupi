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

<script type="text/javascript">
	function uninstall(id)
	{
		if(confirm("<?php echo L("CONFIRM_DELETE");?>"))
		{
			location.href = ROOT + "?m=Sms&a=uninstall&id="+id;
		}
	}
	function send_demo()
	{		
		$.ajax({ 
			url: ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=send_demo&test_mobile="+$.trim($("input[name='test_mobile']").val())+"&operatepwd="+$.trim($("input[name='operatepwd']").val()), 
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
	function check_fee(id)
	{
		 $.ajax({ 
			url: ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=check_fee&&id="+id, 
			data: "ajax=1",
			success: function(text){
				alert(text);
			}
		});
	}
	function account_info(id)
	{
		 $.ajax({ 
			url: ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=account_info&&id="+id, 
			data: "ajax=1",
			success: function(text){
				alert(text);
			}
		});
	}
	$(document).ready(function(){
		$("input[name='test_mobile_btn']").bind("click",function(){
			var mail = $.trim($("input[name='test_mobile']").val());	
			if(mail!='')
			send_demo();
		});
	});
</script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?>
	<input type="text" class="textbox" name="test_mobile" placeholder="手机号码" size="10"/>
	<input type="password" class="textbox" name="operatepwd" placeholder="操作密码" size="10"/>
	<input type="button" class="button" name="test_mobile_btn" value="<?php echo L("TEST");?>" />
</div>
<div class="blank5"></div>

<table cellspacing="0" cellpadding="0" class="dataTable" id="dataTable">
	<tbody>
		<tr>
			<td class="topTd" colspan="7">&nbsp; </td>
			</tr>
			<tr class="row">
				<th><?php echo L("SMS_NAME");?></th>
				<th>类名</th>		
				<th><?php echo L("DESCRIPTION");?></th>	
				<th><?php echo L("TAG_LANG_OPERATE");?></th>
				<th>查询余额</th>
				<th>账户信息</th>
			</tr>
			<?php if(is_array($sms_list)): foreach($sms_list as $key=>$sms_item): ?><tr class="row">
				<td><?php echo ($sms_item["name"]); ?></td>
				<td><?php echo ($sms_item["class_name"]); ?></td>
				<td><?php echo ($sms_item["description"]); ?></td>	
				<td>
					<?php if($sms_item['installed'] == 0): ?><a href="<?php echo u("Sms/install",array("class_name"=>$sms_item['class_name']));?>"><?php echo L("INSTALL");?></a>
					<?php else: ?>
						<a href="javascript:uninstall(<?php echo ($sms_item["id"]); ?>);" ><?php echo L("UNINSTALL");?></a>
						<a href="javascript:edit(<?php echo ($sms_item["id"]); ?>);" ><?php echo L("EDIT");?></a>
						<?php if($sms_item['is_effect'] == 0): ?><a href="<?php echo u("Sms/set_effect",array("id"=>$sms_item['id']));?>"><?php echo L("USE_THIS_SMS");?></a>
						<?php else: ?>
							<?php echo L("SMS_USING");?><?php endif; ?><?php endif; ?>
				</td>
				<td style="text-align:center"><a href="javascript:void(0)" onclick="check_fee(<?php echo ($sms_item["id"]); ?>)">查询余额</a></td>
				<td style="text-align:center"><a href="javascript:void(0)" onclick="account_info(<?php echo ($sms_item["id"]); ?>)">账户信息</a></td>
			</tr><?php endforeach; endif; ?>
			<tr><td class="bottomTd" colspan="7"> &nbsp;</td></tr>
		</tbody>
	</table>
</div>
</body>
</html>