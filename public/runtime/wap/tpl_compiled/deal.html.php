<?php echo $this->fetch('./inc/header.html'); ?>
<?php echo $this->fetch('./inc/header_xiejun.html'); ?>
<?php
	$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/deal.css";		
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
<!--投资借款简单详情-->
<div class="detail">
<div class="mainblok mainborder">
			<div class="container-fluid">
				<div class="h10"></div>
				<div class="row">
					<div class="container">
						<div class=""><span style="color: #e76e15"><?php echo $this->_var['data']['deal']['name']; ?></span>-借款编号:<?php echo $this->_var['data']['deal']['deal_sn']; ?></div>
						<!--<div class=""></div>-->
					</div>
				</div>
				<div class="h30"></div>
				<div class="row">
					<div class="container text-center">
						<div class="row">
							<div class="col-xs-6">
								<div><span style="font-size: 30px;color: #e76e15"><?php echo $this->_var['data']['deal']['rate_foramt']; ?></span>%</div>
								<div>预期年收益</div>
							</div>
							<div class="col-xs-6">
								<div><span style="font-size: 30px;"><?php echo $this->_var['data']['deal']['repay_time']; ?></span><?php if ($this->_var['data']['deal']['repay_time_type'] == 0): ?>天<?php else: ?>月<?php endif; ?></div>
								<div>期限</div>
							</div>
						</div>

					</div>
				</div>
				<div class="h30"></div>
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-xs-9">
								<div class="h10"></div>
								<div class="progress" style="height: 6px;margin-bottom: 10px;">
									<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
										 aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $this->_var['data']['deal']['progress_point']; ?>%;">
										<span class="sr-only"><?php echo $this->_var['data']['deal']['progress_point']; ?>% 完成</span>
									</div>
								</div>
							</div>
							<div class="col-xs-3" style="margin-top: 2px;">
								<?php if ($this->_var['data']['deal']['progress_point'] == 100): ?>
									已满标
								<?php else: ?>
									<?php echo $this->_var['data']['deal']['progress_point']; ?>% 完成
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								借款金额<?php echo $this->_var['data']['deal']['borrow_amount_format']; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="h10"></div>
					<div class="" style="border-bottom: 3px solid #ddd;"></div>
				</div>
				<div class="row">
					<div class="container">
						<div class="h10"></div>
						<div class="row">
							<div class="col-xs-12">
								<?php if ($this->_var['data']['deal']['uloadtype'] == 1): ?>
								<div class="row">
									<span class="col-xs-3">可投份数</span>
									<span class="list_con detail_Orange"><?php echo $this->_var['data']['deal']['need_portion']; ?></span>
								</div>
								<?php else: ?>
								<div class="row">
									<span class="col-xs-3">可投金额</span>
									<span class="list_con detail_Orange"><?php echo $this->_var['data']['deal']['need_money']; ?></span>
								</div>
								<?php endif; ?>
								<div class="row"><span class="col-xs-3">最低金额</span><span><?php echo $this->_var['data']['deal']['min_loan_money_format']; ?></span></div>
								<?php if ($this->_var['data']['deal']['uloadtype'] == 1): ?>
								<div class="row">
									<span class="col-xs-3">已认购</span>
									<span class="list_con"><?php echo $this->_var['data']['deal']['buy_portion']; ?>笔</span>
								</div>
								<?php else: ?>
								<div class="row">
									<span class="col-xs-3">已认购</span>
									<span class="list_con"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['deal']['load_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
								</div>
								<?php endif; ?>
								<div class="row">
									<span class="col-xs-3">风险等级</span>
									<span><?php if ($this->_var['data']['deal']['rish_rank'] == 0): ?>低<?php elseif ($this->_var['data']['deal']['rish_rank'] == 1): ?>中<?php elseif ($this->_var['data']['deal']['rish_rank'] == 2): ?>高<?php endif; ?></span></div>
								<div class="row">
									<span class="col-xs-3">还款方式</span>
									<span><?php 
$k = array (
  'name' => 'loantypename',
  'v' => $this->_var['data']['deal']['loantype'],
  'type' => '1',
);
echo $k['name']($k['v'],$k['type']);
?></span></div>
								<div class="row">
									<span class="col-xs-3">剩余时间</span>
									<span>
									<?php if ($this->_var['data']['deal']['remain_time_format'] == '0天0时0分'): ?>
									投标结束
									<?php else: ?>
									<?php echo $this->_var['data']['deal']['remain_time_format']; ?>
									<?php endif; ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="h10"></div>
					<div class="" style="border-bottom: 3px solid #ddd;"></div>
				</div>
			</div>

        </div><!--mainblok——end--> 


		<div class="blank15"></div>
       
        <div class="mainblok mainborder">
         <?php if ($this->_var['data']['deal']['deal_status'] == 1): ?>
            <div class="detail_list">
                <ul>
                    <li>
                        <label>可用余额</label>
                        <div class="list_con">
                        	<em class="detail_Orange"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></em>元
							<?php if ($this->_var['is_login'] == 0): ?>
							<a href="<?php
echo parse_wap_url_tag("u:index|login|"."".""); 
?>" class="recharge">我要充值</a>
							<?php else: ?>
							<a href="<?php
echo parse_wap_url_tag("u:index|uc_incharge|"."".""); 
?>" class="recharge">我要充值</a>
							<?php endif; ?>
						</div>
                    </li>
					<?php if ($this->_var['data']['deal']['uloadtype'] == 1): ?>
					 <li>
                        <label>投标金额</label>
                        <div class="list_con">
                        	<table width="100%">
                        		<tr>
                        			<td width="50%" >
                        			<!--
								 	<div class="nun_choose clearfix">
										<span class="Minus f_l">−</span>
										<input id="deal_id" type="hidden" value="<?php echo $this->_var['data']['deal']['id']; ?>"  />
										<input id="buy_number" name="buy_number" type="hidden" value="<?php echo $this->_var['data']['deal']['min_loan_money']; ?>" >
									    <input type="text"  value="1" class="nun f_l"  autocomplete="off" name="pay_inmoney" id="pay_inmoney"/>
									    <span class="Plus f_l">+</span>
									</div>
									-->
									<div id="deal-intro">
									 <div class="deal-rf">
									 	<div class="nun_choose clearfix">
									<div id="deal-intro" class="touzbox pr <?php if ($this->_var['data']['deal']['uloadtype'] == 1): ?>c_number-box<?php endif; ?>">
										<a href="javascript:void(0);" class="c_number " rel="-">-</a>
										<input id="deal_id" type="hidden" value="<?php echo $this->_var['data']['deal']['id']; ?>"  />
										<input id="buy_number" name="buy_number" type="hidden" value="<?php echo $this->_var['data']['deal']['min_loan_money']; ?>" >
									    <input type="text" style=""  value="1" class="nuns f_l"  autocomplete="off" name="pay_inmoney" id="pay_inmoney"/>
									    <a href="javascript:void(0);" class="c_number "  rel="+">+</a>
									</div>
									</div>
									</div>
									</div>
									</td>
									<td width="50%">
										收益：<span class="J_u_money_sy f_red">0.00</span>
									</td>
                        		</tr>
								
                        	</table>
                        </div>
                     </li>	
					<?php else: ?>
					 <li>
                        <label>投标金额</label>
                        <div class="list_con">
                        	<table width="100%">
                        		<tr>
                        			<td width="50%"><input id="deal_id" type="hidden" value="<?php echo $this->_var['data']['deal']['id']; ?>"  />
                        				<input id="pay_inmoney" name="pay_inmoney"  class="ui-button_login ui_width" type="text" placeholder="输入金额<?php if ($this->_var['data']['deal']['min_loan_money'] > 0): ?>，最低投标金额<?php echo $this->_var['data']['deal']['min_loan_money_format']; ?>元<?php endif; ?>">
									</td>
									<td width="50%">
										收益：<span class="J_u_money_sy f_red">0.00</span>
									</td>
                        		</tr>
								
                        	</table>
                        
                        </div>
                     </li>
					<?php endif; ?>
					<?php if ($this->_var['data']['ecv_list']): ?>
					<li>
                        <label>使用红包</label>
                        <div class="list_con" style="height:75px">
                        	<select name="ecv_id" id="ecv_id">
                        		<option value="0">选择红包</option>
								<?php $_from = $this->_var['data']['ecv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ecv');if (count($_from)):
    foreach ($_from AS $this->_var['ecv']):
?>
								<option value="<?php echo $this->_var['ecv']['id']; ?>"><?php echo $this->_var['ecv']['name']; ?>[抵<?php echo $this->_var['ecv']['money']; ?>元]</option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        	</select>
							<br>
							<span class="f_red">超出部分不返还</span>
                        </div>
						
                     </li>
					<?php endif; ?>
                   
					<li class="reset_pay_pwd">
                        <label>支付密码</label>
                        <div class="list_con">
                        <input id="pay_inmoney_password" class="ui-button_login ui_width" type="password" placeholder="输入密码">
                        <?php if ($this->_var['is_login'] == 0): ?>
							<a href="<?php
echo parse_wap_url_tag("u:index|login|"."".""); 
?>" class="recharge">设置支付密码</a>
							<?php else: ?>
							<a href="<?php
echo parse_wap_url_tag("u:index|reset_pay_pwd|"."".""); 
?>" class="recharge">设置支付密码</a>
							<?php endif; ?>
						</div>
					 </li>
                </ul>
            </div>
			<?php endif; ?>
        </div><!--mainblok——end--> 
   </div>
<div class="detail_foot">
    <div class="lookdetail"><a href="<?php
echo parse_wap_url_tag("u:index|deal_mobile|"."id=".$this->_var['data']['deal']['id']."".""); 
?>">查看详情</a></div>
    <?php if ($this->_var['is_login'] == 1): ?>
	            <?php if ($this->_var['data']['deal']['deal_status'] == 1 && $this->_var['data']['deal']['remain_time'] > 0): ?><div id="pay_deal" class="I_Investment">我要投资</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 1 && $this->_var['data']['deal']['remain_time'] <= 0): ?><div class="I_Investment disabled">已过期</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 2): ?><div class="I_Investment disabled">满标</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 3): ?><div class="I_Investment disabled">流标</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 4): ?><div class="I_Investment disabled">还款中</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 5): ?><div class="I_Investment disabled">已还款</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 0): ?><div class="I_Investment disabled">等待材料</div><?php endif; ?>
   	<?php else: ?>
	            <?php if ($this->_var['data']['deal']['deal_status'] == 1 && $this->_var['data']['deal']['remain_time'] > 0): ?><div id="pay_deal" class="I_Investment"><a href="<?php
echo parse_wap_url_tag("u:index|login|"."".""); 
?>">我要投资</a></div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 2): ?><div class="I_Investment disabled">满标</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 3): ?><div class="I_Investment disabled">流标</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 4): ?><div class="I_Investment disabled">还款中</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 5): ?><div class="I_Investment disabled">已还款</div><?php endif; ?>
				<?php if ($this->_var['data']['deal']['deal_status'] == 0): ?><div class="I_Investment disabled">等待材料</div><?php endif; ?>
	<?php endif; ?>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>
<script>
	$(document).ready(function(){
		$(".Model").click(function(){
			if(	!$(this).hasClass("y"))
		{
			$(this).siblings().removeClass("y");
			$(this).addClass("y");
		}
		});
		
		$(".Minus").click(function(){
			var x=$(".nun_choose .nun").val();
			if(x>1)
			{
				x-=1;
				$(".nun_choose .nun").val(x);
			}
			else
			{
				alert("数量不能小于1");
				$(".nun_choose .nun").val(1);
			}
		});
		$(".Plus").click(function(){
			var x=$(".nun_choose .nun").val();
			var y=<?php echo $this->_var['data']['deal']['need_portion']; ?>;//20暂代库存
			//var y=20;//20暂代库存
			if(x>(y-1))
			{
				
				alert("数量不能大于可投份数");
				$(".nun_choose .nun").val(y);
			}
			else
			{
				x=parseInt(x) + 1;
				$(".nun_choose .nun").val(x);
			}
		});
		
	});
</script>
<script type="text/javascript">
	var is_submit_lock = false;
$("#pay_deal").click(function(){
		if(is_submit_lock==true) return ;
		
		is_submit_lock = true;
		var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|deal_dobid|"."".""); 
?>';
		var query = new Object();
		
		query.id = $.trim($("#deal_id").val());
		query.bid_money = $.trim($("#pay_inmoney").val());
		query.buy_number = $.trim($("#buy_number").val());
		query.bid_paypassword = $.trim($("#pay_inmoney_password").val());
		query.ecv_id = $.trim($("#ecv_id").val());
	
		
		query.post_type = "json";
		$.ajax({
			url:ajaxurl,
			data:query,
			type:"Post",
			dataType:"json",
			success:function(data){
				is_submit_lock = false;
				if(data.status == 2){
					window.location.href = data.app_url;
				}else{
					alert(data.show_err);
					if(data.response_code == 1){
						window.location.href = '<?php
echo parse_wap_url_tag("u:index|uc_invest|"."".""); 
?>';
					}
				}
				
			}
		});
	});
</script>	
<script type='text/javascript'>
	function fav_result(o)
	{
		$(o).parent().html("已关注");
	}
	var is_submit_lock =false;
	var bid_paypassword = "";
	var bid_calculate = null;
	jQuery(function(){
		<?php if ($this->_var['data']['deal']['uloadtype'] == 1): ?>
		$("a.c_number").click(function(){
			var rel=$(this).attr("rel");
			var obj = $(this);
			var number = parseInt($("#pay_inmoney").val());
			switch(rel){
				case "-":
					if(number-1 > 1){
						$("#pay_inmoney").val(number-1);
					}
					else{
						$("#pay_inmoney").val(1);
					}
					break;
				case "+":
					 var max_portion = <?php if ($this->_var['data']['deal']['max_portion'] > 0): ?><?php echo $this->_var['deal']['max_portion'] - $this->_var['has_bid_portion'];  ?><?php else: ?><?php echo $this->_var['data']['deal']['need_portion']; ?><?php endif; ?>;
					if(number+1 <= max_portion){
						$("#pay_inmoney").val(number+1);
					}
					else{
						$("#pay_inmoney").val(max_portion);
					}
					break
			}
			loadSy();
		});
		<?php endif; ?>
		
		
		$("#J_bindpassword_rbtn").live("click",function(){
			$.weeboxs.close("paypass-box");
		});
		
		$("#pay_inmoney").keyup(function(){
			loadSy();
		});
//		$("#pay_inmoney").onchange(function(){
//			loadSy();
//		});
		
		loadSy();
		
	});
	
	function loadSy(){
		var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|calc_bid|"."".""); 
?>';
		var id =  $.trim($("#deal_id").val());
		var money = $.trim($("#pay_inmoney").val());
		var number = $.trim($("#buy_number").val());
		var query = new Object();
		//query.id = '<?php echo $this->_var['data']['deal']['id']; ?>';
		query.id =  $.trim($("#deal_id").val());
		query.money = $.trim($("#pay_inmoney").val());
		query.number = $.trim($("#buy_number").val());
		
		if(bid_calculate) bid_calculate.abort(); /*终止之前所有的未结束的ajax请求，然后重新开始新的请求  */
		query.post_type = "json";
		$.ajax({
			url:ajaxurl,
			data:query,
			type:"post",
			dataType:"json",
			success:function(result){
				//alert(result.profit);
				$(".J_u_money_sy").html(result.profit);
				
			}
		});
	}
	
	function to_load(){
		if(is_submit_lock)
		{
			return false;
		}
		is_submit_lock = true;
		var query = new Object();
		query.bid_money=$.trim($("#pay_inmoney").val())
		query.id="<?php echo $this->_var['data']['deal']['id']; ?>";
		query.bid_paypassword = FW_Password(bid_paypassword);
		query.ajax=1;
		
		$.ajax({
			url:'<?php
echo parse_wap_url_tag("u:index|calc_bid|"."".""); 
?>',
			data:query,
			type:"POST",
			dataType:"json",
			success:function(result){
				if(result.status==1){
					is_submit_lock = false;
					$.showSuccess(result.info,function(){
						window.location.reload();
					});
				}
				else if(result.status==2){
					window.location.href=result.jump;
				}
				else{
					is_submit_lock = false;
					$.showErr(result.info);
				}
			},
			error:function(ajaxobj)
			{
			}
		});
	}
</script>







