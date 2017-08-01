<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo conf("APP_NAME");?><?php echo l("ADMIN_PLATFORM");?></title>
<script type="text/javascript" src="__ROOT__/public/runtime/admin/lang.js"></script>
<script type="text/javascript">
	var version = '<?php echo app_conf("DB_VERSION");?>';
	var VAR_MODULE = "<?php echo conf("VAR_MODULE");?>";
	var VAR_ACTION = "<?php echo conf("VAR_ACTION");?>";
	var ROOT = '__APP__';
	var ROOT_PATH = '<?php echo APP_ROOT; ?>';
	var app_type = '<?php echo ($apptype); ?>';
	var ofc_swf = '__TMPL__Common/js/open-flash-chart.swf';
	var sale_line_data_url = '<?php echo urlencode(u("Ofc/sale_line"));?>';
	var sale_refund_data_url = '<?php echo urlencode(u("Ofc/sale_refund"));?>';
</script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/main.css" />
<script type="text/javascript" src="__TMPL__Common/js/swfobject.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/main.js"></script>
</head>


<body>
<style type="text/css">
	table { border-collapse:collapse; vertical-align:middle;}
	/*table tr{ height:25px;}*/
	table td{width:200px;padding: 0 10px;}
	/*.bg1{ background:#ccc;}*/
	table tr:hover{ background: #f0f0f0;color: #f1a417;}
	table td a{text-decoration: none;}
	table td span{color: #f1a417;}
	/*.bg2{ background:#999;}*/
	.title{font-size: 20px; height: 40px;line-height: 40px;background: #f2f2f2;font-weight: 500;letter-spacing: 1px;}
	.cont{font-size: 15px;height: 32px;line-height: 32px;}
	.bt{border-top: 1px solid #ccc;}
	.text-right{text-align: right;}
	.bl{border-left: 1px solid #ccc;}
	.tab{border: 1px solid #ccc;}
	.tab_width{ width:1200px; margin:30px 30px 0; cursor:pointer;}
</style>
<div class="tab_width">
	<div class="tab">
		<table>
			<thead>
			</thead>
			<tbody>
				<tr><td colspan="6" class="title">会员统计</td></tr>
				<tr class="bt cont">
					<td>总用户数</td>
					<td class="text-right"><span><?php echo ($total_user); ?></span>人</td>
					<td class="bl">实际投资人数</td>
					<td class="text-right"><span><?php echo ($total_load_user); ?></span>人</td>
					<td class="bl">今日新增会员</td>
					<td class="text-right"><span><?php echo ($new_user_today); ?></span>人</td>
				</tr>
				<tr class="bt cont">
					<td>本周新增会员</td>
					<td class="text-right"><span><?php echo ($new_user_this_week); ?></span>人</td>
					<td class="bl">本周活跃会员</td>
					<td class="text-right"><span><?php echo ($active_user_this_week); ?></span>人</td>
					<td class="bl">完成实名认证数</td>
					<td class="text-right"><sapn><?php echo ($total_idcardpassed_user); ?></sapn>人</td>
				</tr>
				<tr class="bt cont">
					<td>密码错误超过2次</td>
					<td class="text-right"><a href="<?php echo u("MyCustomer/error_pwd");?>" <?php if($error_password_input > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($error_password_input); ?></span>人</a></td>
					<td class="bl">密码锁定</td>
					<td class="text-right"><a href="<?php echo u("MyCustomer/lock");?>" <?php if($password_lock > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($password_lock); ?></span>人</a></td>
					<td class="bl">用户投标记录</td>
					<td class="text-right"><a href="<?php echo u("Loads/index");?>"><span style="color:#f60;">查看</span></a></td>
				</tr>
				<tr class="bt"><td colspan="6" class="title">资金统计</td></tr>
				<tr class="bt cont">
					<td>今日用户总充值</td>
					<td class="text-right"><sapn><?php echo (format_price($total_inchareg)); ?></sapn>元</td>
					<td class="bl">今日用户总提现</td>
					<td class="text-right"><span><?php echo (format_price($total_carry)); ?></span>元</td>
					<td class="bl">累计投资额</td>
					<td class="text-right"><span><?php echo (format_price($total_deal_load)); ?></span>元</td>
				</tr>
				<tr class="bt cont">
					<td>用户总利息收益</td>
					<td class="text-right"><span><?php echo (format_price($total_interest_money)); ?></span>元</td>
					<td class="bl">已还本息总额</td>
					<td class="text-right"><span><?php echo (format_price($true_repay_money)); ?></span>元</td>
					<td class="bl">待还利息</td>
					<td class="text-right"><span><?php echo (format_price($wait_interest_money)); ?></span>元</td>
				</tr>
				<tr class="bt cont">
					<td>待还本金</td>
					<td class="text-right"><span><?php echo (format_price($wait_self_money)); ?></span>元</td>
					<td class="bl">用户帐户总余额</td>
					<td class="text-right"><span><?php echo (format_price($user_total_money)); ?></span>元</td>
					<td class="bl"></td>
					<td class="text-right"></td>
				</tr>
				<tr class="bt"><td colspan="6" class="title">待办事项</td></tr>
				<tr class="bt cont">
					<td>借款待初审</td>
					<td class="text-right"><a href="<?php echo u("Deal/publish");?>" <?php if($publis_wait_first > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($publis_wait_first); ?></span>笔</a></td>
					<td class="bl">借款待复审</td>
					<td class="text-right"><a href="<?php echo u("Deal/true_publish");?>" <?php if($publis_wait_second > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($publis_wait_second); ?></span>笔</a></td>
					<td class="bl">借款待三审</td>
					<td class="text-right"><a href="<?php echo u("Deal/third_publish");?>" <?php if($publis_wait_third > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($publis_wait_third); ?></span>笔</a></td>
				</tr>
				<tr class="bt cont">
					<td>借款待发布</td>
					<td class="text-right"><a href="<?php echo u("Deal/submit_publish");?>" <?php if($publis_wait_four > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($publis_wait_four); ?></span>笔</a></td>
					<td class="bl">满标待审</td>
					<td class="text-right"><a href="<?php echo u("Deal/full");?>" <?php if($suc_deal_count > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($suc_deal_count); ?></span>笔</a></td>
					<td class="bl">企业借款申请</td>
					<td class="text-right"><span>0</span>笔</td>
				</tr>
				<tr class="bt cont">
					<td>VIP会员待审</td>
					<td class="text-right"><span>0</span>笔</td>
					<td class="bl">待处理个人实名认证</td>
					<td class="text-right"><span>0</span>笔</td>
					<td class="bl">待处理企业实名认证</td>
					<td class="text-right"><span>0</span>笔</td>
				</tr>
				<tr class="bt cont">
					<td>资料认证申请</td>
					<td class="text-right"><span>0</span>笔</td>
					<td class="bl">提现待审核</td>
					<td class="text-right"><a href="<?php echo u("UserCarry/index",array("status"=>0));?>" <?php if($carry_count > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($carry_count); ?></span>笔</a></td>
					<td class="bl">待查询</td>
					<td class="text-right"><a href="<?php echo u("UserCarry/waitquery",array("status"=>0));?>" <?php if($carry_waitquery > 0): ?>style="color:#f60;"<?php endif; ?>><span><?php echo ($carry_waitquery); ?></span>笔</a></td>
				</tr>
				<tr class="bt"><td colspan="6" class="title">其他事项</td></tr>
				<tr class="bt cont">
					<td>三日内待还款</td>
					<td class="text-right"><a href="<?php echo u("Deal/three");?>" <?php if($threeday_repay_count > 0): ?>style="color:#f60;"<?php endif; ?><span><?php echo ($threeday_repay_count); ?></span>笔</a></td>
					<td class="bl">逾期待还款</td>
					<td class="text-right"><a href="<?php echo u("Deal/yuqi");?>" <?php if($yq_repay_count > 0): ?>style="color:#f60;"<?php endif; ?><span><?php echo ($yq_repay_count); ?></span>笔</a></td>
					<td class="bl"></td>
					<td class="text-right"></td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>
</div>
	<div class="main" style="display: none;">
		<div class="notify_box">
			<div class="block">
				<div class="header">会员统计</div>
				<div class="content">
					<div class="row row_line">
						<div class="item_t">总用户数</div><div class="item_c"><b><?php echo ($total_user); ?></b>人</div><div class="split">|</div>
						<div class="item_t">实际投资人数</div><div class="item_c"><b><?php echo ($total_load_user); ?></b>人</div><div class="split">|</div>
						<div class="item_t">今日新增会员</div><div class="item_c"><b><?php echo ($new_user_today); ?></b>人</div>
					</div>
					<div class="blank5"></div>
					<div class="row">
						<div class="item_t">本周新增会员</div><div class="item_c"><b><?php echo ($new_user_this_week); ?></b>人</div><div class="split">|</div>
						<div class="item_t">本周活跃会员</div><div class="item_c"><b><?php echo ($active_user_this_week); ?></b>人</div><div class="split">|</div>
						<div class="item_t">完成实名认证数</div><div class="item_c"><b><?php echo ($total_idcardpassed_user); ?></b>人</div>
					</div>
					<div class="blank5"></div>
					<div class="row">
						<div class="item_t">密码错误超过2次</div><div class="item_c"><a href="<?php echo u("MyCustomer/error_pwd");?>" <?php if($error_password_input > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($error_password_input); ?></b>人</a></div><div class="split">|</div>
						<div class="item_t">密码锁定</div><div class="item_c"><a href="<?php echo u("MyCustomer/lock");?>" <?php if($password_lock > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($password_lock); ?></b>人</a></div><div class="split">|</div>
						<div class="item_t" style="color:red;">用户投标记录</div><div class="item_c" style="color:red;"><a href="<?php echo u("Loads/index");?>"><b style="color:#f60;">查看</b></a></div>
					</div>
				</div>
			</div>
			<div class="blank5"></div>

			<div class="block">
				<div class="header">资金统计</div>
				<div class="content">
					<div class="row row_line">
						<div class="item_t">今日用户总充值</div><div class="item_c"><b><?php echo (format_price($total_inchareg)); ?></b>元</div><div class="split">|</div>
						<div class="item_t">今日用户总提现</div><div class="item_c"><b><?php echo (format_price($total_carry)); ?></b>元</div><div class="split">|</div>
						<div class="item_t">累计投资额</div><div class="item_c"><b><?php echo (format_price($total_deal_load)); ?></b>元</div>
					</div>
					<div class="blank5"></div>
					<div class="row row_line">
						<div class="item_t">用户总利息收益</div><div class="item_c"><b><?php echo (format_price($total_interest_money)); ?></b>元</div><div class="split">|</div>
						<div class="item_t">已还本息总额</div><div class="item_c"><b><?php echo (format_price($true_repay_money)); ?></b>元</div><div class="split">|</div>
						<div class="item_t">待还利息</div><div class="item_c"><b><?php echo (format_price($wait_interest_money)); ?></b>元</div>
					</div>
					<div class="blank5"></div>
					<div class="row">
						<div class="item_t">待还本金</div><div class="item_c"><b><?php echo (format_price($wait_self_money)); ?></b>元</div><div class="split">|</div>
						<div class="item_t">用户帐户总余额</div><div class="item_c"><b><?php echo (format_price($user_total_money)); ?></b>元</div>
					</div>
				</div>
			</div>
			<div class="blank5"></div>

			<div class="block">
				<div class="header">待办事项</div>
				<div class="content">
					<div class="row row_line">
						<div class="item_t">借款待初审</div><div class="item_c"><a href="<?php echo u("Deal/publish");?>" <?php if($publis_wait_first > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($publis_wait_first); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">借款待复审</div><div class="item_c"><a href="<?php echo u("Deal/true_publish");?>" <?php if($publis_wait_second > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($publis_wait_second); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">借款待三审</div><div class="item_c"><a href="<?php echo u("Deal/third_publish");?>" <?php if($publis_wait_third > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($publis_wait_third); ?></b>笔</a></div>
					</div>
					<div class="blank5"></div>
					<div class="row row_line">
						<div class="item_t">借款待发布</div><div class="item_c"><a href="<?php echo u("Deal/submit_publish");?>" <?php if($publis_wait_four > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($publis_wait_four); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">满标待审</div><div class="item_c"><a href="<?php echo u("Deal/full");?>" <?php if($suc_deal_count > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($suc_deal_count); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">企业借款申请</div><div class="item_c"><b>0</b>笔</div>
					</div>
					<div class="blank5"></div>
					<div class="row row_line">
						<div class="item_t">VIP会员待审</div><div class="item_c"><b>0</b>笔</div><div class="split">|</div>
						<div class="item_t">待处理个人实名认证</div><div class="item_c"><b>0</b>笔</div><div class="split">|</div>
						<div class="item_t">待处理企业实名认证</div><div class="item_c"><b>0</b>笔</div>
					</div>
					<div class="blank5"></div>
					<div class="row">
						<div class="item_t">资料认证申请</div><div class="item_c"><b>0</b>笔</div><div class="split">|</div>
						<div class="item_t">提现待审核</div><div class="item_c"><a href="<?php echo u("UserCarry/index",array("status"=>0));?>" <?php if($carry_count > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($carry_count); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">待查询</div><div class="item_c"><a href="<?php echo u("UserCarry/waitquery",array("status"=>0));?>" <?php if($carry_waitquery > 0): ?>style="color:#f60;"<?php endif; ?>><b><?php echo ($carry_waitquery); ?></b>笔</a></div>
					</div>
				</div>
			</div>
			<div class="blank5"></div>

			<div class="block">
				<div class="header">其他事项</div>
				<div class="content">
					<div class="row">
						<div class="item_t">三日内待还款</div><div class="item_c"><a href="<?php echo u("Deal/three");?>" <?php if($threeday_repay_count > 0): ?>style="color:#f60;"<?php endif; ?><b><?php echo ($threeday_repay_count); ?></b>笔</a></div><div class="split">|</div>
						<div class="item_t">逾期待还款</div><div class="item_c"><a href="<?php echo u("Deal/yuqi");?>" <?php if($yq_repay_count > 0): ?>style="color:#f60;"<?php endif; ?><b><?php echo ($yq_repay_count); ?></b>笔</a></div>
					</div>
					<div class="blank5"></div>
				</div>
			</div>
			<div class="blank5"></div>
		</div>
		<div class="blank5"></div>

		<script type="text/javascript">
		var nav_json_data = <?php echo json_encode($navs); ?>;
		loadModule();
		$("#J_nav").change(function(){
			loadModule();
		});
		$("#J_m").change(function(){
			loadAction();
		});
		function loadModule(){
			var nav =$("#J_nav").val();
			var html = "";
			$.each(nav_json_data,function(i,v){
				if(i==nav){
					$.each(v.groups,function(ii,vv){
						html += '<option value="'+ii+'">'+vv.name+'</option>';
					});
				}
			});

			$("#J_m").html(html);
			loadAction();
		}

		function loadAction(){
			var nav =$("#J_nav").val();
			var m =  $("#J_m").val();
			var a_html = '<option value="">请选择</option>';
			$.each(nav_json_data,function(i,v){
				if(i==nav){
					$.each(v.groups,function(ii,vv){
						if(ii==m){
							$.each(vv.nodes,function(iii,vvv){
								a_html += '<option value="'+vvv.action+'" module="'+vvv.module+'">'+vvv.name+'</option>';
							});
						}
					});
				}
			});

			$("#J_a").html(a_html);
		}

		$("#J_a").change(function(){
			if($.trim($(this).val())!=""){
				location.href = ROOT + '?m='+$(this).find("option:selected").attr("module")+'&a='+$(this).val();
			}
		})
	</script>
	</div>
</body>
</html>