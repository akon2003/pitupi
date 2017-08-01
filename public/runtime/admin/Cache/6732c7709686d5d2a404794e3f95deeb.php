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
<script type="text/javascript" src="/app/Tpl/new/js/script.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/user.js"></script>
<div class="main main-size16">
<div class="main_title">会员投标记录</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">
		<?php echo L("USER_NAME");?>：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" style="width:100px;" />
		<label><input type="radio" name="is_user" value="1" <?php if(intval($_REQUEST['is_user']) == 1): ?>checked="checked"<?php endif; ?> />用户</label>
		<label><input type="radio" name="is_user" value="2" <?php if(intval($_REQUEST['is_user']) == 2): ?>checked="checked"<?php endif; ?> />推荐人</label>
		<label><input type="radio" name="is_user" value="3" <?php if(intval($_REQUEST['is_user']) == 3): ?>checked="checked"<?php endif; ?> />客服</label>&nbsp;
		借款名称：<select name="deal_id">
			<option value="0" <?php if(intval($_REQUEST['deal_id']) == 0): ?>selected="selected"<?php endif; ?>><?php echo L("NO_SELECT_CATE");?></option>
			<?php if(is_array($deal_list)): foreach($deal_list as $key=>$deal_item): ?><option value="<?php echo ($deal_item["id"]); ?>" <?php if(intval($_REQUEST['deal_id']) == $deal_item['id']): ?>selected="selected"<?php endif; ?>><?php echo ($deal_item["name"]); ?></option><?php endforeach; endif; ?>
		</select>
		投标时间：<input type="text" class="textbox" name="begin_time" id="begin_time" value="<?php echo trim($_REQUEST['begin_time']);?>" onfocus="return showCalendar('begin_time', '%Y-%m-%d', false, false, 'begin_time');" style="width:130px" />
		-
		<input type="text" class="textbox" name="end_time" id="end_time" value="<?php echo trim($_REQUEST['end_time']);?>" onfocus="return showCalendar('end_time', '%Y-%m-%d', false, false, 'end_time');" style="width:130px" />
        <input type="hidden" value="Loads" name="m" />
		<input type="hidden" value="<?php echo ACTION_NAME ?>" name="a" />
		<input type="hidden" value="<?php echo ACTION_NAME ?>" name="c" />
		<input type="hidden" value="-1" name="cate_id" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
    	<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv();" />
	</form>
</div>
<?php function get_deal_url($name,$id){
		return '<a href="'.__ROOT__.'/index.php?ctl=newe&id='.$id.'" target="_blank">'.$name.'</a>';
	}
	function get_repay_time($time,$type){
		return $time.($type==0 ? '天' : '月');
	}
	function get_loantype($type){
		$str=loantypename($type);
		
		return $str;
	}
	function is_auto_type($type){
		return ($type==0 ? '手动投标' : '自动投标');
	}
	function is_repay_type($type){
		return ($type==0 ? '成功' : '<span style="color:red">流标</span>');
	} ?>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="13" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Loads','newe')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','Loads','newe')" title="按照会员ID   <?php echo ($sortType); ?> ">会员ID   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','Loads','newe')" title="按照会员名   <?php echo ($sortType); ?> ">会员名   <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pid','<?php echo ($sort); ?>','Loads','newe')" title="按照推荐人   <?php echo ($sortType); ?> ">推荐人   <?php if(($order)  ==  "pid"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('admin_id','<?php echo ($sort); ?>','Loads','newe')" title="按照专属客服   <?php echo ($sortType); ?> ">专属客服   <?php if(($order)  ==  "admin_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','Loads','newe')" title="按照投资金额   <?php echo ($sortType); ?> ">投资金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('name','<?php echo ($sort); ?>','Loads','newe')" title="按照标题   <?php echo ($sortType); ?> ">标题   <?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('cate_id','<?php echo ($sort); ?>','Loads','newe')" title="按照<?php echo L("DEAL_CATE");?>   <?php echo ($sortType); ?> "><?php echo L("DEAL_CATE");?>   <?php if(($order)  ==  "cate_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('rate','<?php echo ($sort); ?>','Loads','newe')" title="按照利率(%)   <?php echo ($sortType); ?> ">利率(%)   <?php if(($order)  ==  "rate"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('repay_time','<?php echo ($sort); ?>','Loads','newe')" title="按照借款时间   <?php echo ($sortType); ?> ">借款时间   <?php if(($order)  ==  "repay_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('loantype','<?php echo ($sort); ?>','Loads','newe')" title="按照还款方式   <?php echo ($sortType); ?> ">还款方式   <?php if(($order)  ==  "loantype"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_repay','<?php echo ($sort); ?>','Loads','newe')" title="按照状态   <?php echo ($sortType); ?> ">状态   <?php if(($order)  ==  "is_repay"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','Loads','newe')" title="按照投标时间<?php echo ($sortType); ?> ">投标时间<?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($item["id"]); ?></td><td>&nbsp;<?php echo (get_user_name_iframe($item["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($item["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($item["pid"])); ?></td><td>&nbsp;<?php echo (get_admin_real_name($item["admin_id"])); ?></td><td>&nbsp;<?php echo (number_format($item["money"],2)); ?></td><td>&nbsp;<?php echo ($item["name"]); ?></td><td>&nbsp;<?php echo (get_deal_cate_name($item["cate_id"])); ?></td><td>&nbsp;<?php echo ($item["rate"]); ?></td><td>&nbsp;<?php echo (get_repay_time($item["repay_time"],$item['repay_time_type'])); ?></td><td>&nbsp;<?php echo (get_loantype($item["loantype"])); ?></td><td>&nbsp;<?php echo (is_repay_type($item["is_repay"])); ?></td><td>&nbsp;<?php echo (to_date($item["create_time"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="13" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>