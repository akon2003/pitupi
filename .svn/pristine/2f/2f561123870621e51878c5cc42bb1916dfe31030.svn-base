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

<script type="text/javascript" src="__TMPL__Common/js/conf.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/deal.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/jquery.autocomplete.css" />
<script type="text/javascript" src="__TMPL__Common/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		init_dealform();
	}
</script>
<div class="main">
<div class="main_title"> <?php echo L("ADD");?>U计划 <a href="<?php if($reback_url): ?><?php echo ($reback_url); ?><?php else: ?><?php echo u("ExtDealUplan/index");?><?php endif; ?>" class="back_list"><?php echo L("BACK_LIST");?></a></div>
<div class="blank5"></div>
<form name="edit" action="__APP__" method="post" enctype="multipart/form-data">
<div class="blank5"></div>
<table class="form conf_tab" cellpadding=0 cellspacing=0 rel="1">
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">U计划编号:</td>
		<td class="item_input">
			<input type="text" name="deal_sn" class="textbox" value="<?php echo ($deal_sn); ?>" />
			<span class="tip_span">此处编号用于合同处，不得重复</span>
		</td>
	</tr>
	<tr>
		<td class="item_title">定向标密码:</td>
		<td class="item_input">
			<input type="text" name="mer_bill_no" class="textbox" <?php if($vo['deal_status'] >= 1): ?>readonly<?php endif; ?> value="<?php echo ($vo["mer_bill_no"]); ?>" />
			<span class="tip_span">非空表示定向标，输入内容即为定向标密码</span>
		</td>
	</tr>
	<tr>
		<td class="item_title">U计划名称:</td>
		<td class="item_input">
			<input type="text" class="textbox require" name="name" style="width:500px;" />
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("DEAL_SUB_NAME");?>:</td>
		<td class="item_input"><input type="text" class="textbox require" name="sub_name" /> <span class='tip_span'>[<?php echo L("DEAL_SUB_NAME_TIP");?>]</span></td>
	</tr>
	<tr>
		<td class="item_title">会员名称:</td>
		<td class="item_input">
			<input type="text" class="textbox require J_autoUserName" name="user_name" />
			<input type="hidden" class="textbox require J_autoUserId" name="user_id" />
		</td>
	</tr>
	<tr>
		<td class="item_title">分类:</td>
		<td class="item_input">	
		<select name="cate_id" class="w_textbox">
			<?php if(is_array($deal_cate_tree)): foreach($deal_cate_tree as $key=>$cate_item): ?><?php if (preg_match("/U计划$/",$cate_item['title_show'])) { echo '<option value="'.$cate_item['id'].'">U计划</option>'; } ?><?php endforeach; endif; ?>
		</select>
		</td>
	</tr>	
	<tr>
		<td class="item_title">用途:</td>
		<td class="item_input">
		<select name="type_id" class="w_textbox">
			<?php if(is_array($deal_type_tree)): foreach($deal_type_tree as $key=>$type_item): ?><?php if (preg_match("/U计划$/",$type_item['title_show'])) { echo '<option value="'.$type_item['id'].'">U计划</option>'; } ?><?php endforeach; endif; ?>
		</select>
		</td>
	</tr>	
	<tr>
		<td class="item_title">还款方式:</td>
		<td class="item_input">
		<select name="loantype" class="w_textbox">
			<?php if(is_array($loantype_list)): foreach($loantype_list as $key=>$loantype): ?><?php if (preg_match("/付息还本/",$loantype['sub_name'])) { echo '<option value="'.$loantype['key'].' rel="'.$loantype['repay_time_type_str'].'">'.$loantype['sub_name'].'</option>'; } ?><?php endforeach; endif; ?>
		</select>
		</td>
	</tr>	
	<tr>
		<td class="item_title">合同范本:</td>
		<td class="item_input">
		<select name="contract_id" class="w_textbox require">
			<?php if(is_array($contract_list)): foreach($contract_list as $key=>$contract): ?><?php if (preg_match("/委托投资协议/",$contract['title'])) { echo '<option value="'.$contract['id'].'">'.$contract['title'].'</option>'; } ?><?php endforeach; endif; ?>
		</select>
		</td>
	</tr>
	<tr style="display:none">
		<td class="item_title">转让合同范本:</td>
		<td class="item_input">
		<select name="tcontract_id" class="w_textbox">
			<?php if(is_array($contract_list)): foreach($contract_list as $key=>$contract): ?><?php if (preg_match("/委托投资协议/",$contract['title'])) { echo '<option value="'.$contract['id'].'">'.$contract['title'].'</option>'; } ?><?php endforeach; endif; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="item_title">发布金额:</td>
		<td class="item_input">
			<input type="text" class="textbox require" name="borrow_amount" value="<?php if($vo['borrow_amount']): ?><?php echo ($vo["borrow_amount"]); ?><?php else: ?>0.00<?php endif; ?>" />
		</td>
	</tr>
	<tr>
		<td class="item_title">投标类型:</td>
		<td class="item_input">
			<select name="uloadtype" class="w_textbox">
				<option value=0>按金额</option>
			</select>
		</td>
	</tr>	
	<tr class="uloadtype_0">
		<td class="item_title"><?php echo L("MIN_LOAN_MONEY");?>:</td>
		<td class="item_input">
			<input type="text" class="textbox require" name="min_loan_money" value="0" readonly/>
		</td>
	</tr>
	
	<tr class="uloadtype_0">
		<td class="item_title"><?php echo L("MAX_LOAN_MONEY");?>:</td>
		<td class="item_input">
			<input type="text" class="textbox" name="max_loan_money"  value="0" />
			<span class="tip_span">0为不限制</span>
		</td>
	</tr>
	<tr>
		<td class="item_title">期限:</td>
		<td class="item_input">
			<input type="text" id="repay_time" class="textbox require" SIZE="5"  name="repay_time" value="6" /> 月
			<input type="hidden" name="repay_time_type" value="1" />
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("RATE");?>:</td>
		<td class="item_input">
			<input type="text" class="textbox require" SIZE="5" name="rate"  value="<?php echo ($vo["rate"]); ?>"  />%
		</td>
	</tr>
	<tr>
		<td class="item_title">筹标期限:</td>
		<td class="item_input">
			<input type="text" class="textbox require" SIZE="5" name="enddate" value="<?php echo ($vo["enddate"]); ?>"  /> 天
		</td>
	</tr>	
	<?php if(ACTION_NAME != 'makedeals'): ?><tr>
		<td class="item_title">U计划状态:</td>
		<td class="item_input">
			<label><?php echo L("DEAL_STATUS_1");?><input type="radio" name="deal_status" value="1" /></label>
			<label><?php echo L("DEAL_STATUS_3");?><input type="radio" name="deal_status" value="3" /></label>
		</td>
	</tr><?php endif; ?>
	<tr id="start_time_box" style="display:none">
		<td class="item_title">开始时间:</td>
		<td class="item_input">
			<input type="text" class="textbox" name="start_time" value="" id="start_time"  onfocus="this.blur(); return showCalendar('start_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_start_time');" />
			<input type="button" class="button" id="btn_start_time" value="<?php echo L("SELECT_TIME");?>" onclick="return showCalendar('start_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_start_time');" />
			<input type="button" class="button" value="<?php echo L("CLEAR_TIME");?>" onclick="$('#start_time').val('');" />		
			如有同步：时间只能是当天或者前一天 
		</td>
	</tr>
	<tr id="bad_time_box" style="display:none">
		<td class="item_title"><?php echo L("DEAL_STATUS_3");?>时间:</td>
		<td class="item_input">
			<input type="text" class="textbox" name="bad_time" id="bad_time" value="" onfocus="this.blur(); return showCalendar('bad_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_bad_time');" />
			<input type="button" class="button" id="btn_bad_time" value="<?php echo L("SELECT_TIME");?>" onclick="return showCalendar('bad_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_bad_time');" />
			<input type="button" class="button" value="<?php echo L("CLEAR_TIME");?>" onclick="$('#bad_time').val('');" />	
		</td>
	</tr>
	<tr id="bad_info_box" style="display:none">
		<td class="item_title"><?php echo L("DEAL_STATUS_3");?>原因:</td>
		<td class="item_input">
			<textarea type="text" class="textbox" name="bad_msg" id="bad_msg" value="" rows="3" cols="50"></textarea>
		</td>
	</tr>
	<tr>
		<td class="item_title"><?php echo L("SORT");?>:</td>
		<td class="item_input"><input type="text" class="textbox" name="sort" value="<?php echo ($new_sort); ?>" /></td>
	</tr>
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
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
			<input type="hidden" name="peizi_ids" value="<?php echo ($peizi_ids); ?>" />
			<?php if(ACTION_NAME == 'makedeals'): ?><input type="hidden" name="<?php echo conf("VAR_MODULE");?>" value="PeiziOrder" />
				<input type="hidden" name="<?php echo conf("VAR_ACTION");?>" value="domakedeals" />
			<?php else: ?>
				<input type="hidden" name="<?php echo conf("VAR_MODULE");?>" value="ExtDealUplan" />
				<input type="hidden" name="<?php echo conf("VAR_ACTION");?>" value="insert" />
				<input type="hidden" name="ext" value="uplan" /><?php endif; ?>
			<!--隐藏元素-->
			<input type="submit" class="button" value="<?php echo L("ADD");?>" />
			<input type="reset" class="button" value="<?php echo L("RESET");?>" />
			</td>
		</tr>
		<tr>
			<td colspan=2 class="bottomTd"></td>
		</tr>
	</table> 	 
</form>
</div>
<div style="display:none" id="J_tmp_ke_box">
	<div class="f_l">名称：<input type="text" class="textbox" size="10" name="mortgage_%k_name_%s" id="mortgage_%k_name_%s" value="" />&nbsp;</div>
	<div class="f_l">图片：</div>
	<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='' name='mortgage_%k_img_%s' id='keimg_h_mortgage_%k_img_%s_i' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='mortgage_%k_img_%s'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='./admin/Tpl/default/Common/images/no_pic.gif' target='_blank' id='keimg_a_mortgage_%k_img_%s' ><img src='./admin/Tpl/default/Common/images/no_pic.gif' id='keimg_m_mortgage_%k_img_%s' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='/admin/Tpl/default/Common/images/del.gif' style='display:none; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='mortgage_%k_img_%s' title='删除'>
				</div>
			</div>
		</div>
		</span>
	<div class="blank5"></div>
</div>
</body>
</html>