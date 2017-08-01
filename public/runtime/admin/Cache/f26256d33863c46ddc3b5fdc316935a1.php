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
	function get_referrals_name($user_id)
	{
		$user_name = M("User")->where("id=".$user_id)->getField("user_name");
		if($user_name)
		return $user_name;
		else
			return '无';
	}	
	function ips_status($ips_acct_no){
		if($ips_acct_no==""){
			return "未同步";
		}
		else{
			return "已同步";
		}
	}
	function user_type_status($type){
		if($type==1){
			return "企业";
		}
		else{
			return "普通";
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
	}
    function gest_deal_status($status) {
        switch($status) {
            case 0: return "等待材料"; break;
            case 1: return "进行中"; break;
            case 2: return "满标"; break;
            case 3: return "流标"; break;
            case 4: return "还款中"; break;
            case 5: return "已还清"; break;
            default: return "";
        }
    } ?>
<div class="main">
<div class="blank5"></div>
<div>
	<ul class="show_item"><?php for($i=0; $i<count($show_item); $i++) {
		echo "<li id='".$show_item[$i]['key']."'>".$show_item[$i]['title']."</li>";
	} ?></ul>
</div>
<div class="blank0"></div>
<div class="show_info">
	<!-- XHF 2016/7/28 加入维护记录 -->
	<div class="visit_info" style="display:none;">
		<div style="width:100%;margin-top:15px;">
			<form style="padding:3px 8px;" action="" method="post">
				回访时间:<input type="text" name="visit_date" id="visit_date" value="" onclick="return showCalendar('visit_date', '%Y-%m-%d %H:%M', false, false, 'visit_date');" style="width:100px" readonly />
				回访内容:<input type="text" name="content" style="width:300px;" />
				评估:<input type="text" name="remark" style="width:100px;" />
				下次回访时间:<input type="text" name="next_visit_date" id="next_visit_date" value="" onclick="return showCalendar('next_visit_date', '%Y-%m-%d', false, false, 'next_visit_date');" style="width:80px" readonly />
				<input type="hidden" value="User" name="m" />
				<input type="hidden" value="<?php echo ($user_id); ?>" name="user_id" />
				<input type="hidden" value="add_visit" name="a" />
				<input type="submit" value="提交记录" />
			</form>
		</div>
		<table class="grid" style="margin-top:10px;">
			<tr class='header'>
				<td style="width:38px;">编号</td>
				<td style="width:120px;">回访时间</td>
				<td>内容</td>
				<td style="width:80px;">下次预约时间</td>
				<td style="width:120px;">评估</td>
				<td style="width:80px;">客户经理</td>
				<td style="width:120px;">创建时间</td>
			</tr>
			<?php if(is_array($visit_list)): foreach($visit_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["visit_date"]); ?></td>
				<td><?php echo ($item["content"]); ?></td>		
				<td><?php echo ($item["next_visit_date"]); ?></td>
				<td><?php echo ($item["remark"]); ?></td>
				<td><?php echo ($item["customer"]); ?></td>
				<td><?php echo ($item["create_time_format"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="user_info" style="display:none">
		<table><?php for ($i=0; $i<count($user_info); $i+=3) {
				$str = "<tr>";
				for ($k=$i; $k<$i+3; $k++) {
					if ($user_info[$k]['key'] == 'none') {
						$str .= "<td></td><td></td>";
					} else {
						$str .= "<td class='u_title'>".$user_info[$k]['title'].":</td><td class='u_value'><input type='text' readonly value='".$user_info[$k]['value']."' /></td>";
					}
				}
				$str .= "</tr>";
				echo $str;
			} ?></table>
	</div>

	<div class="load_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>投资金额</td>
				<td>投资时间</td>
				<td>合同文本号</td>
				<td>投资标的名称</td>
				<td>借款客户名称</td>
				<td>借款品种</td>
				<td>借款用途</td>
				<td>借款期限</td>
				<td>借款利率</td>
				<td>借款金额</td>
				<td>还款方式</td>
			</tr>
			<?php if(is_array($load_list)): foreach($load_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td><?php echo ($item["create_time_format"]); ?></td>
				<td><?php echo ($item["deal_sn"]); ?></td>
				<td><?php echo ($item["deal_name"]); ?></td>
				<td><?php echo ($item["deal_user_name"]); ?></td>
				<td><?php echo ($item["cate_name"]); ?></td>
				<td><?php echo ($item["deal_type"]); ?></td>
				<td><?php echo ($item["repay_time_format"]); ?></td>
				<td><?php echo ($item["rate"]); ?>%</td>
				<td><?php echo ($item["borrow_amount"]); ?></td>
				<td><?php echo ($item["loantype_format"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="deal_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>借款时间</td>
				<td>客户名称</td>
				<td>业务品种</td>
				<td>借款标题</td>
				<td>合同文本号</td>
				<td>用途</td>
				<td>金额</td>
				<td>借款期限</td>
				<td>借款利率</td>
				<td>还款方式</td>
				<td>状态</td>
			</tr>
			<?php if(is_array($deal_list)): foreach($deal_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["repay_start_date"]); ?></td>
				<td><?php echo ($item["deal_user_name"]); ?></td>
				<td><?php echo ($item["cate_name"]); ?></td>
				<td><?php echo ($item["name"]); ?></td>
				<td><?php echo ($item["deal_sn"]); ?></td>
				<td><?php echo ($item["deal_type"]); ?></td>
				<td><?php echo ($item["borrow_amount"]); ?></td>
				<td><?php echo ($item["repay_time_format"]); ?></td>
				<td><?php echo ($item["rate"]); ?>%</td>
				<td><?php echo ($item["loantype_format"]); ?></td>
				<td><?php echo (gest_deal_status($item["deal_status"])); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="payment_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>订单号</td>
				<td>客户名称</td>
				<td>交易金额</td>
				<td>交易类型</td>
				<td>交易时间</td>
				<td>账户余额</td>
				<td>备注</td>
			</tr>
			<?php if(is_array($payment_notice_list)): foreach($payment_notice_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["notice_sn"]); ?></td>
				<td><?php echo ($item["user_name"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td><?php echo ($item["payment_type"]); ?></td>
				<td><?php echo ($item["pay_time_format"]); ?></td>
				<td><?php echo ($item["account_money"]); ?></td>
				<td><?php echo ($item["memo"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="carry_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>客户名称</td>
				<td>交易金额</td>
				<td>交易类型</td>
				<td>交易时间</td>
				<td>账户余额</td>
				<td>备注</td>
			</tr>
			<?php if(is_array($user_carry_list)): foreach($user_carry_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["user_name"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td>提现</td>
				<td><?php echo ($item["create_time_format"]); ?></td>
				<td><?php echo ($item["account_money"]); ?></td>
				<td><?php echo ($item["memo"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="money_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td style='width:38px'>编号</td>
				<td>客户名称</td>
				<td>操作金额</td>
				<td>账户余额</td>
				<td>操作类型</td>				
				<td>时间</td>
				<td>备注</td>
			</tr>
			<?php if(is_array($user_money_log_list)): foreach($user_money_log_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["user_name"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td><?php echo ($item["account_money"]); ?></td>
				<td><?php echo ($item["type_format"]); ?></td>
				<td><?php echo ($item["create_time_format"]); ?></td>
				<td><?php echo ($item["memo"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="score_info" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>类型</td>
				<td>积分</td>
				<td>备注</td>
				<td>获得日期</td>
				<td>操作人</td>
			</tr>
		</table>
	</div>

	<div class="bribery_money" style="display:none">
		<table class="grid">
			<tr class='header'>
				<td>编号</td>
				<td>红包金额</td>
				<td>红包状态</td>
				<td>红包获得方式</td>
				<td>操作人</td>
				<td>获得日期</td>
				<td>使用日期</td>
				<td>到期日期</td>
				<td>备注</td>
			</tr>
		</table>
	</div>

	<div class="recom_level_1" style="display:none;width:1200px;">
		<table class="grid">
			<tr class='header'>
				<td style='width:38px'>编号</td>
				<td>用户ID</td>
				<td>姓名</td>
				<td>性别</td>
				<td>身份证号码</td>				
				<td>电话</td>
				<td>推荐人</td>
				<td>专属客服</td>
				<td>账户总额</td>
				<td>账户余额</td>
				<td>冻结金额</td>
				<td>累计投资金额</td>
				<td>QQ号码</td>
				<td>积分余额</td>
				<td>注册时间</td>
				<td>渠道名称</td>
			</tr>
			<?php if(is_array($recom_level_1_list)): foreach($recom_level_1_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["user_name"]); ?></td>
				<td><?php echo ($item["real_name"]); ?></td>
				<td><?php echo ($item["sex"]); ?></td>
				<td><?php echo ($item["idno"]); ?></td>
				<td><?php echo ($item["mobile"]); ?></td>
				<td><?php echo ($item["refer_user_real_name"]); ?></td>
				<td><?php echo ($item["admin_real_name"]); ?></td>
				<td><?php echo ($item["account_money"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td><?php echo ($item["lock_money"]); ?></td>
				<td><?php echo ($item["loan_money"]); ?></td>
				<td><?php echo ($item["qq_id"]); ?></td>
				<td><?php echo ($item["score"]); ?></td>
				<td><?php echo ($item["create_time_format"]); ?></td>
				<td></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div class="recom_level_2" style="display:none;width:1200px;">
		<table class="grid">
			<tr class='header'>
				<td style='width:38px'>编号</td>
				<td>用户ID</td>
				<td>姓名</td>
				<td>性别</td>
				<td>身份证号码</td>				
				<td>电话</td>
				<td>推荐人</td>
				<td>专属客服</td>
				<td>账户总额</td>
				<td>账户余额</td>
				<td>冻结金额</td>
				<td>累计投资金额</td>
				<td>QQ号码</td>
				<td>积分余额</td>
				<td>注册时间</td>
				<td>渠道名称</td>
			</tr>
			<?php if(is_array($recom_level_2_list)): foreach($recom_level_2_list as $key=>$item): ?><tr>
				<td><?php echo ($item["id"]); ?></td>
				<td><?php echo ($item["user_name"]); ?></td>
				<td><?php echo ($item["real_name"]); ?></td>
				<td><?php echo ($item["sex"]); ?></td>
				<td><?php echo ($item["idno"]); ?></td>
				<td><?php echo ($item["mobile"]); ?></td>
				<td><?php echo ($item["refer_user_real_name"]); ?></td>
				<td><?php echo ($item["admin_real_name"]); ?></td>
				<td><?php echo ($item["account_money"]); ?></td>
				<td><?php echo ($item["money"]); ?></td>
				<td><?php echo ($item["lock_money"]); ?></td>
				<td><?php echo ($item["loan_money"]); ?></td>
				<td><?php echo ($item["qq_id"]); ?></td>
				<td><?php echo ($item["score"]); ?></td>
				<td><?php echo ($item["create_time_format"]); ?></td>
				<td></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>

</div>
<div class="blank5"></div>
</div>
<style type="text/css">
	.show_item {height:23px;border-bottom:1px solid #ccc;}
	.show_item li {float:left;padding:3px 8px;margin-right:3px;cursor:pointer;letter-spacing: 1px;}
	.show_item li.selected {background:white;font-weight:bold;border: 1px solid #ccc;border-bottom: none;border-radius: 3px 3px 0 0;line-height: 17px;}
	.show_info table {width:90%;margin:20px auto;}
	.show_info table td {padding:5px;}
	.show_info table.grid {border:1px solid #E0ECFF;border-collapse:collapse;border-spacing:0;width:100%;}
	.show_info table.grid td {border:1px solid #E0ECFF;}
	.show_info table tr.header {font-weight:bold;text-align:center;}
	.show_info .user_info table tr {margin-bottom:16px;}
	.show_info .user_info table tr td {padding:5px 3px;vertical-align:middle;}
	.show_info .user_info table td.u_title {text-align:right;padding-right:6px;}
	.show_info .user_info table td.u_value {text-align:left;}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(".show_item li").bind("click", function() {
			$(this).addClass("selected").siblings().removeClass("selected");
			$(".show_info > div").hide();
			$(".show_info ."+$(this).attr("id")).show();
		});
		
		$(".show_item li:first-child").trigger("click");
	});
</script>
</body>
</html>