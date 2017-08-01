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
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">
	function address(user_id)
	{
		location.href = ROOT + '?m=User&a=address&id='+user_id;
	}
</script>

<script type="text/javascript">	
</script>

<div class="main main-size12">
<div class="main_title">账户余额统计表</div>
<div class="blank5"></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("USER_NAME");?>：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" />
		专属客服：<input type="text" class="textbox" name="adm_name" value="<?php echo trim($_REQUEST['adm_name']);?>" />
		<input type="hidden" name="user_type" value="<?php if(ACTION_NAME == 'index' or ACTION_NAME == 'register'): ?>0<?php else: ?>1<?php endif; ?>" />
		<input type="hidden" value="User" name="m" />
		<input type="hidden" value="<?php echo ACTION_NAME; ?>" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
    	<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv_ext('export_csv_customer_acct_list');" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="13" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('dataTable')"></th><th width="50px"><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_name','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照会员ID<?php echo ($sortType); ?> ">会员ID<?php if(($order)  ==  "user_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('real_name','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照用户名<?php echo ($sortType); ?> ">用户名<?php if(($order)  ==  "real_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照可用余额<?php echo ($sortType); ?> ">可用余额<?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('lock_money','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照冻结金额<?php echo ($sortType); ?> ">冻结金额<?php if(($order)  ==  "lock_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('sex','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照性别<?php echo ($sortType); ?> ">性别<?php if(($order)  ==  "sex"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('mobile','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照手机<?php echo ($sortType); ?> ">手机<?php if(($order)  ==  "mobile"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pid','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照推荐人<?php echo ($sortType); ?> ">推荐人<?php if(($order)  ==  "pid"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('admin_id','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照专属客服<?php echo ($sortType); ?> ">专属客服<?php if(($order)  ==  "admin_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('qq_id','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照QQ号码<?php echo ($sortType); ?> ">QQ号码<?php if(($order)  ==  "qq_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('score','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照积分余额<?php echo ($sortType); ?> ">积分余额<?php if(($order)  ==  "score"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','User','customer_acct_list')" title="按照注册时间<?php echo ($sortType); ?> ">注册时间<?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td><input type="checkbox" name="key" class="key" value="<?php echo ($user["id"]); ?>"></td><td>&nbsp;<?php echo ($user["id"]); ?></td><td>&nbsp;<?php echo ($user["user_name"]); ?></td><td>&nbsp;<?php echo ($user["real_name"]); ?></td><td>&nbsp;<?php echo (format_price($user["money"])); ?></td><td>&nbsp;<?php echo (format_price($user["lock_money"])); ?></td><td>&nbsp;<?php echo (get_sex($user["sex"])); ?></td><td>&nbsp;<?php echo ($user["mobile"]); ?></td><td>&nbsp;<?php echo (get_user_real_name($user["pid"])); ?></td><td>&nbsp;<?php echo (get_admin_real_name($user["admin_id"])); ?></td><td>&nbsp;<?php echo ($user["qq_id"]); ?></td><td>&nbsp;<?php echo ($user["score"]); ?></td><td>&nbsp;<?php echo (to_date($user["create_time"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="13" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 
<div class="blank5"></div>
<div class="search_row">
	账户总余额: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["total"])); ?></span>元&nbsp;
	可用余额: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["total_money"])); ?></span>元&nbsp;
	冻结资金: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["total_lock_money"])); ?></span>元&nbsp;
	今日充值: <span style="color:red;font-weight:bold;"><?php echo (format_price($sum["incharge"])); ?></span>元
</div>
<div class="page"><?php echo ($page); ?></div>
<div class="blank5"></div>
</div>
</body>
</html>