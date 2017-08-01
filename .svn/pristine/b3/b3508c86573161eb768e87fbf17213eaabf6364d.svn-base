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
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/user.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<?php function get_user_group($group_id)
	{
		$group_name = M("UserGroup")->where("id=".$group_id)->getField("name");
		if($group_name)
		{
			return $group_name;
		}
		else
		{
			return l("NO_GROUP");
		}
	}
	function get_user_level($id)
	{
		$level_name = M("UserLevel")->where("id=".$id)->getField("name");
		if($level_name)
		{
			return $level_name;
		}
		else
		{
			return "<span style='color:red'>无</span>";
		}
	}
	function get_user_vip_grade($vip_id)
	{
		if ($vip_id == 0) {
			return '';
		} else {
			return M("VipType")->where("id=".$vip_id)->getField("vip_grade");;
		}
	}
	function user_type_status($type){
		if($type==1){
			return "企业客户";
		}
		else{
			return "个人客户";
		}
	}
	function get_idcardpassed($idcardpassed){
		if($idcardpassed==1){
			return "是";
		}
		else{
			return "";
		}
	}
	function user_company($id,$user){
		if($user['user_type']==1){
			return "<a href='javascript:user_company(".$id.");'>公司</a>&nbsp;";
		}
	}
	function get_is_black($tag,$id){
		if($tag)
		{
			return "<span class='is_black' data='".$tag."' onclick='set_black(".$id.",this);'>是</span>";
		}
		else
		{
			return "<span class='is_black' data='".$tag."' onclick='set_black(".$id.",this);'>否</span>";
		}
	} ?>
<div class="main main-size20">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("USER_NAME");?>：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" />
		<label><input type="radio" name="is_user" value="1" <?php if(intval($_REQUEST['is_user']) == 1): ?>checked="checked"<?php endif; ?> />用户</label>
		<label><input type="radio" name="is_user" value="2" <?php if(intval($_REQUEST['is_user']) == 2): ?>checked="checked"<?php endif; ?> />推荐人</label>
		<label><input type="radio" name="is_user" value="3" <?php if(intval($_REQUEST['is_user']) == 3): ?>checked="checked"<?php endif; ?> />客服</label>&nbsp;
		注册时间：<input type="text" class="textbox" name="begin_time" id="begin_time" value="<?php echo trim($_REQUEST['begin_time']);?>" onfocus="return showCalendar('begin_time', '%Y-%m-%d %H:%M:%S', false, false, 'begin_time');" />
		-
		<input type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d %H:%M:%S', false, false, 'end_time');" />
		<input type="hidden" value="<?php echo MODULE_NAME; ?>" name="m" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="19" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照选择<?php echo ($sortType); ?> ">选择<?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照用户ID   <?php echo ($sortType); ?> ">用户ID   <?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_type','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照用户类型   <?php echo ($sortType); ?> ">用户类型   <?php if(($order)  ==  "user_type"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('vip_id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照VIP等级   <?php echo ($sortType); ?> ">VIP等级   <?php if(($order)  ==  "vip_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('real_name','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照姓名   <?php echo ($sortType); ?> ">姓名   <?php if(($order)  ==  "real_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('sex','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照性别   <?php echo ($sortType); ?> ">性别   <?php if(($order)  ==  "sex"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('idno','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照身份证号码<?php echo ($sortType); ?> ">身份证号码<?php if(($order)  ==  "idno"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('mobile','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照手机   <?php echo ($sortType); ?> ">手机   <?php if(($order)  ==  "mobile"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('idcardpassed','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照实名认证   <?php echo ($sortType); ?> ">实名认证   <?php if(($order)  ==  "idcardpassed"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pid','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照推荐人   <?php echo ($sortType); ?> ">推荐人   <?php if(($order)  ==  "pid"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('admin_id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照专属客服   <?php echo ($sortType); ?> ">专属客服   <?php if(($order)  ==  "admin_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('total_money','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照账户总余额   <?php echo ($sortType); ?> ">账户总余额   <?php if(($order)  ==  "total_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照账户余额   <?php echo ($sortType); ?> ">账户余额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('lock_money','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照冻结金额   <?php echo ($sortType); ?> ">冻结金额   <?php if(($order)  ==  "lock_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('loan_money','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照累计投资金额   <?php echo ($sortType); ?> ">累计投资金额   <?php if(($order)  ==  "loan_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('qq_id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照QQ号码   <?php echo ($sortType); ?> ">QQ号码   <?php if(($order)  ==  "qq_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('score','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照积分余额   <?php echo ($sortType); ?> ">积分余额   <?php if(($order)  ==  "score"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照注册时间   <?php echo ($sortType); ?> ">注册时间   <?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('authority_id','<?php echo ($sort); ?>','ExtAdminManager','index')" title="按照授权中心<?php echo ($sortType); ?> ">授权中心<?php if(($order)  ==  "authority_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (checkbox($user["id"])); ?></td><td>&nbsp;<?php echo (get_user_name_iframe($user["id"])); ?></td><td>&nbsp;<?php echo (user_type_status($user["user_type"])); ?></td><td>&nbsp;<?php echo (get_user_vip_grade($user["vip_id"])); ?></td><td>&nbsp;<?php echo ($user["real_name"]); ?></td><td>&nbsp;<?php echo (get_sex($user["sex"])); ?></td><td>&nbsp;<?php echo ($user["idno"]); ?></td><td>&nbsp;<?php echo ($user["mobile"]); ?></td><td>&nbsp;<?php echo (get_idcardpassed($user["idcardpassed"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($user["pid"])); ?></td><td>&nbsp;<?php echo (get_admin_real_name($user["admin_id"])); ?></td><td>&nbsp;<?php echo (format_price($user["total_money"])); ?></td><td>&nbsp;<?php echo (format_price($user["money"])); ?></td><td>&nbsp;<?php echo (format_price($user["lock_money"])); ?></td><td>&nbsp;<?php echo (format_price($user["loan_money"])); ?></td><td>&nbsp;<?php echo ($user["qq_id"]); ?></td><td>&nbsp;<?php echo ($user["score"]); ?></td><td>&nbsp;<?php echo (to_date($user["create_time"])); ?></td><td>&nbsp;<?php echo (get_authority($user["authority_id"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="19" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>