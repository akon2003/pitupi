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

<script type="text/javascript" src="/app/Tpl/new/js/script.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<?php function get_group_name($group_id)
	{
		switch ($group_id) {
			case 1:
				return '基础配置';break;
			case 2:
				return '图片配置';break;
			case 3:
				return '站点配置';break;
			case 4:
				return '会员相关配置';break;
			case 5:
				return '邮件与短信';break;
			case 6:
				return '借款配置';break;
			case 7:
				return '会员奖励';break;
			case 8:
				return '扩展配置';break;
			default:
				return '';
		}
	}

	function get_input_type($type_id)
	{
		switch ($group_id) {
			case 0:
				return '文本输入';break;
			case 1:
				return '下拉框输入';break;
			case 2:
				return '图片上传';break;
			case 3:
				return '编辑器';break;
			case 4:
				return '密码';break;
			case 5:
				return '文本域';break;
			default:
				return '';
		}
	}
	function get_conf_name($name)
	{
		$conf_name = 'CONF_'.$name;
		$lang_conf_name = l($conf_name);

		if ($lang_conf_name == $conf_name) {
			return l($name);
		} else {
			return $lang_conf_name;
		}
	}
	function get_is_conf($is_conf)
	{
		if ($is_conf == 1) {
			return '是';
		} else {
			return '否';
		}
	}
	function get_container($value) {
		return "<input style='float:left;width:98%;height:100%;margin-top:5px;border:none;background:transparent;' readonly value='".$value."'/>";
	} ?>
<div class="main main-size16">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="新增配置" onclick="add();" />
	<input type="button" class="button" value="编辑配置" onclick="_edit()" />
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable dataTableSelect dataTableSelectDblclick" cellpadding=0 cellspacing=0 ><tr><td colspan="10" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Conf','params')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="240px"><a href="javascript:sortBy('name','<?php echo ($sort); ?>','Conf','params')" title="按照配置名称<?php echo ($sortType); ?> ">配置名称<?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="240px   "><a href="javascript:sortBy('name','<?php echo ($sort); ?>','Conf','params')" title="按照配置名称<?php echo ($sortType); ?> ">配置名称<?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="120px   "><a href="javascript:sortBy('group_id','<?php echo ($sort); ?>','Conf','params')" title="按照配置分组<?php echo ($sortType); ?> ">配置分组<?php if(($order)  ==  "group_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="120px   "><a href="javascript:sortBy('input_type','<?php echo ($sort); ?>','Conf','params')" title="按照配置类型<?php echo ($sortType); ?> ">配置类型<?php if(($order)  ==  "input_type"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="80px   "><a href="javascript:sortBy('is_effect','<?php echo ($sort); ?>','Conf','params')" title="按照是否有效<?php echo ($sortType); ?> ">是否有效<?php if(($order)  ==  "is_effect"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="80px   "><a href="javascript:sortBy('is_conf','<?php echo ($sort); ?>','Conf','params')" title="按照是否配置<?php echo ($sortType); ?> ">是否配置<?php if(($order)  ==  "is_conf"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('value','<?php echo ($sort); ?>','Conf','params')" title="按照配置设定值   <?php echo ($sortType); ?> ">配置设定值   <?php if(($order)  ==  "value"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="280px   "><a href="javascript:sortBy('tip','<?php echo ($sort); ?>','Conf','params')" title="按照提示文本<?php echo ($sortType); ?> ">提示文本<?php if(($order)  ==  "tip"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('value_scope','<?php echo ($sort); ?>','Conf','params')" title="按照设定值选项<?php echo ($sortType); ?> ">设定值选项<?php if(($order)  ==  "value_scope"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$conf): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($conf["id"])); ?></td><td>&nbsp;<a href="javascript:edit   ('<?php echo (addslashes($conf["id"])); ?>')"><?php echo ($conf["name"]); ?></a></td><td>&nbsp;<?php echo (get_conf_name($conf["name"])); ?></td><td>&nbsp;<?php echo (get_group_name($conf["group_id"])); ?></td><td>&nbsp;<?php echo (get_input_type($conf["input_type"])); ?></td><td>&nbsp;<?php echo (get_is_effect($conf["is_effect"])); ?></td><td>&nbsp;<?php echo (get_is_conf($conf["is_conf"])); ?></td><td>&nbsp;<?php echo (get_container($conf["value"])); ?></td><td>&nbsp;<?php echo ($conf["tip"]); ?></td><td>&nbsp;<?php echo ($conf["value_scope"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="10" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>