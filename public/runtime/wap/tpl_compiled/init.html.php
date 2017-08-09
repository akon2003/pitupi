<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0,minimum-scale=0.5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $this->_var['data']['program_title']; ?></title>
	<link rel="stylesheet" type="text/css" href="./css/font-awesome-4.2.0/css/font-awesome.min.css"><!--特殊字体处理包-->
    <script type="text/javascript" src="./js/jquery.js"></script><!--jquery文档-->
	<script type="text/javascript" src="./js/public.js"></script><!--共有jquery文档-->
	<script type="text/javascript" src="./js/touchScroll.js"></script><!--滑屏轮播插件包-->
	<script type="text/javascript" src="./js/touchslider.dev.js"></script><!--滑屏轮播插件包-->	
	<script type="text/javascript" src="./js/script.js"></script>
	<script type="text/javascript" src="./js/peizi.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="./css/xiejun.css"/>
    <?php
			$this->_var['parent_pagecss'][] = $this->_var['TMPL_REAL']."/css/public.css";
	?>
	<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['parent_pagecss'],
);
echo $k['name']($k['v']);
?>" />
    <script type="text/javascript">
		var APP_ROOT = '<?php echo $this->_var['APP_ROOT']; ?>';
		var WAP_PATH = '<?php echo $this->_var['WAP_ROOT']; ?>';
		var APP_ROOT_ORA = '<?php echo $this->_var['PC_URL']; ?>';
	</script> 	
</head>
<body id="top">

<script>
$(document).ready(function(){
	$("#J-deal-collect-but").click(function(){
		var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|uc_do_collect|"."".""); 
?>';
		var query = new Object();
		query.id =  $.trim($(this).attr("dataid"));
		var obj = $(this);
		$.ajax({ 
			url: ajaxurl,
			data:query,
			type: "POST",
			dataType: "json",
			success: function(result){
				if(result.status==1)
				{
					$(obj).html("已关注");
				}
				else
				{	
				}
			}
		});	
	});
		
				
	$("#J-del-deal-collect-but").click(function(){
		var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|uc_del_collect|"."".""); 
?>';
		var query = new Object();
		query.id =  $.trim($(this).attr("dataid"));
		var obj = $(this);
		$.ajax({ 
			url: ajaxurl,
			data:query,
			type: "POST",
			dataType: "json",
			success: function(result){
				if(result.status==1)
				{
					$(obj).html("关注");
				}
				else
				{	
				}
			}
		});	
	});
});
</script>
 <?php if ($this->_var['data']['act'] == 'register' || $this->_var['data']['act'] == 'register_idno'): ?>
<div class="register_top clearfix">
	<ul class="info">
		<li class="<?php if ($this->_var['data']['act'] == 'register'): ?>current<?php endif; ?>">
			<span>1&nbsp;输入信息&nbsp;</span>
			<i class="fa fa-angle-right"></i>
		</li>
		<li class="<?php if ($this->_var['data']['act'] == 'register_idno'): ?>current<?php endif; ?>">
			<span>2&nbsp;身份验证&nbsp;</span>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>3&nbsp;注册成功&nbsp;</span>
			<i class="fa fa-angle-right"></i>
		</li>		
	</ul>
</div>
<?php endif; ?>
 <div class="page_total"><?php echo $this->_var['data']['page']['page_total']; ?></div>
<!--分页总数-->
	
<?php
			$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/init.css";		
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />	

<!--网站主页-->
<div class="wrap init">
	<div class="swipe"><!--这里是头部广告图位置，是否轮播-->
        <ul id="slider">
        	<?php $_from = $this->_var['data']['index_list']['adv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'adv');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['adv']):
?>
				<li><a href="<?php echo $this->_var['adv']['data']; ?>"><img class="img-responsive center-block" src="<?php echo $this->_var['adv']['img']; ?>"  alt=""/></a></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
        </ul>
		
        <div id="pagenavi">
        	<?php $_from = $this->_var['data']['index_list']['adv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'adv');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['adv']):
?>
           	 <a href="javascript:void(0);" <?php if ($this->_var['key'] == 0): ?>class="active"<?php endif; ?> ></a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>      
        </div>
		<!--这是轮播对应的按钮-->
		
        <div class="blank"></div>
    </div><!--swipe end-->
	<div class="container-fluid">
		<div class="row" style="background: #fff;">
			<div class="container" style="height: 32px;border-bottom: 1px solid #ccc;padding: 5px 10px;">
				<i class="glyphicon glyphicon-menu-hamburger" style="color: #062e58;"></i>&nbsp;理财计划
			</div>
			<div class="container" style="border-bottom: 1px solid #ccc;text-align: center;">
				<div class="row">
					<div class="col-xs-4" style="border-right: 1px solid #ccc;">
						<div class="row">
							<div class="h20"></div>
							<a href="<?php
echo parse_wap_url_tag("u:index|deals|"."".""); 
?>" class="menu1" onclick="clickResponse(this)" res="1">
								<div style="color: #062e58"><img class="img-responsive center-block" src="./images/touzi.png" alt="" /></div>
								<div class="h10"></div>
								<div style="font-size: 15px">我要投资</div>
								<div style="font-size: 12px;">期限灵活 优质资产</div>
							</a>
							<div class="h20"></div>
						</div>
					</div>
					<div class="col-xs-4" style="border-right: 1px solid #ccc;">
						<div class="row">
							<div class="h20"></div>
							<a href="<?php
echo parse_wap_url_tag("u:index|uplan_list|"."".""); 
?>" class="menu1" onclick="clickResponse(this)" res="1">
							<div><img class="img-responsive center-block" src="./images/uplan.png" alt="" /></div>
							<div class="h10"></div>
							<div style="font-size: 15px;">U计划</div>
							<div style="font-size: 12px;">定期理财&nbsp;分散投资</div>
							</a>
							<div class="h20"></div>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="row">
							<div class="h20"></div>
							<a href="<?php
echo parse_wap_url_tag("u:index|newe_list|"."".""); 
?>" class="menu1" onclick="clickResponse(this)" res="1">
								<div style="color: #062e58"><img class="img-responsive center-block" src="./images/newe.png" alt="" /></div>
								<div class="h10"></div>
								<div style="font-size: 15px">新手标</div>
								<div style="font-size: 12px;">新手投资&nbsp;专享通道</div>
							</a>
							<div class="h20"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="container" style="border-bottom: 1px solid #ccc;text-align: center;">
				<div class="h10"></div>
				<div class="row">
					<div class="col-xs-4">
						<div>累计成交额</div>
						<div><span style="font-size: 18px;color: #f47809"><?php echo $this->_var['data']['total_load']; ?></span></div>
						<div>万元</div>
					</div>
					<div class="col-xs-4">
						<div class="">累计创造收益</div>
						<div class=""><span style="font-size: 18px;color: #f47809"><?php echo $this->_var['data']['total_rate']; ?></span></div>
						<div>万元</div>
					</div>
					<div class="col-xs-4">
						<div class="">累计注册用户</div>
						<div class=""><span style="font-size: 18px;color: #f47809"><?php echo $this->_var['data']['user_count']; ?></span></div>
						<div>人</div>
					</div>
				</div>
				<div class="h10"></div>
			</div>
			<!--<div class="container" style="border-bottom: 1px solid #ccc;text-align: center;">-->
				<!--<div class="row">-->
					<!--<div class="col-xs-4" style="border-right: 1px solid #ccc;">-->
						<!--<div class="row">-->
							<!--<div class="h20"></div>-->
							<!--<div><span class="glyphicon glyphicon-home" aria-hidden="true"></span></div>-->
							<!--<div>定期理财</div>-->
							<!--<div>期限灵活 优质资产</div>-->
							<!--<div class="h20"></div>-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="col-xs-4" style="border-right: 1px solid #ccc;">-->
						<!--<div class="row">-->
							<!--<div class="h20"></div>-->
							<!--<div><span class="glyphicon glyphicon-home" aria-hidden="true"></span></div>-->
							<!--<div>U计划</div>-->
							<!--<div>灵活的定期理财</div>-->
							<!--<div class="h20"></div>-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="col-xs-4">-->
						<!--<div class="row">-->
							<!--<div class="h20"></div>-->
							<!--<div><span class="glyphicon glyphicon-home" aria-hidden="true"></span></div>-->
							<!--<div>U计划</div>-->
							<!--<div>灵活的定期理财</div>-->
							<!--<div class="h20"></div>-->
						<!--</div>-->
					<!--</div>-->
				<!--</div>-->
			<!--</div>-->
		</div>
		<div class="row">
			<a href="<?php
echo parse_wap_url_tag("u:index|newe_list|"."".""); 
?>">
				<div class="container" style="background: #ddd;padding: 5px;">
					<img class="img-responsive center-block" src="./images/newe_link.png" alt="">
				</div>
			</a>
		</div>
		<div class="row">
			<a href="<?php
echo parse_wap_url_tag("u:index|uplan_list|"."".""); 
?>">
				<div class="container" style="background: #ddd;padding: 5px;">
					<img class="img-responsive center-block" src="./images/uplan_link.png" alt="">
				</div>
			</a>
		</div>
		<div class="row" style="background: #ddd;">
			<div class="container" style="padding: 5px 10px;">
				<div class=""><i class="glyphicon glyphicon-menu-hamburger" style="color: #062e58"></i>&nbsp;为你推荐</div>
			</div>
			<div class="container" style="padding: 5px;">
				<div class="" style="-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background: #fff;">
					<?php $_from = $this->_var['data']['index_list']['deal_all_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal');if (count($_from)):
    foreach ($_from AS $this->_var['deal']):
?>
					<div class="" style="border-bottom: 1px solid #cccccc;">
						<a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
						<div class="container" style="font-size: 14px;">
							<div class="h20"></div>
							<span class="yellow"><?php echo $this->_var['deal']['name']; ?></span>
							<span class="verticalline">-</span>
							<span class="State <?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?>green<?php else: ?>gray<?php endif; ?>">
								<?php if ($this->_var['deal']['deal_status'] == 0): ?>等待材料<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?>进行中<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] <= 0): ?>已过期<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 2): ?>满标<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 3): ?>流标<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 4): ?>还款中<?php endif; ?>
								<?php if ($this->_var['deal']['deal_status'] == 5): ?>已还清<?php endif; ?>
							</span>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-xs-9">
									<div class="h10"></div>
									<div class="row" style="text-align: center;">
										<div class="col-xs-4">
											<div class="row" style="font-size: 16px;"><?php echo $this->_var['deal']['borrow_amount_format']; ?></div>
											<div class="row">金额</div>
										</div>
										<div class="col-xs-4">
											<div class="row" style="font-size: 16px;color: #ff9713"><?php echo $this->_var['deal']['rate']; ?>%</div>
											<div class="row">年利率</div>
										</div>
										<div class="col-xs-4">
											<div class="row" style="font-size: 16px;"><?php echo $this->_var['deal']['repay_time']; ?>月</div>
											<div class="row">期限</div>
										</div>
									</div>
								</div>
								<div class="col-xs-3">
									<div class="row">

										<?php if ($this->_var['deal']['deal_status'] >= 4): ?>
										<div class="h10"></div>
										<div class="h-5"></div>
										<button type="button" class="btn" style="background: #a9a9a9;color: #fff;">还款中</button>
										<?php else: ?>
											<div class="content_pic">
												<h1><?php echo $this->_var['deal']['progress_point']; ?></h1>
												<div class="content_pic_1" style="height:<?php echo $this->_var['deal']['progress_point']; ?>%;">
													<span></span>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<div class="blank"></div>
									</div>
								</div>
								<div class="h10"></div>
							</div>
							</a>
						</div>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>
			</div>
		</div>
	</div>

	

    <!--<div class="mainblok mainborder">-->
        <!--<div class="Statistics mainborder" style="border:none;">-->
            <!--<span>累计成交额</span>-->
            <!--<span class="num_size blue"><?php echo $this->_var['data']['total_load']; ?></span>-->
            <!--<span>（万元）</span>-->
        <!--</div>-->
        <!--<div class="Statistics mainborder">-->
            <!--<span>累计创造收益</span>-->
            <!--<span class="num_size yellow"><?php echo $this->_var['data']['total_rate']; ?></span>-->
            <!--<span>（万元）</span>            -->
        <!--</div>-->
        <!--<div class="Statistics mainborder">-->
            <!--<span>累计注册用户</span>-->
            <!--<span class="num_size green"><?php echo $this->_var['data']['user_count']; ?></span>-->
            <!--<span>（人）</span>-->
        <!--</div>-->
        <!--<div class="blank"></div>  -->
    <!--</div>-->
</div>
<script type="text/javascript" src="<?php echo $this->_var['TMPL']; ?>/js/init.js"></script>

<?php echo $this->fetch('./inc/footer_index.html'); ?>







