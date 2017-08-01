<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
	<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/left.css" />
	<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
	<link rel="stylesheet" href="__TMPL__Aryee/css/font-awesome.css" />
	<link rel="stylesheet" href="__TMPL__Aryee/css/ace-fonts.css" />
	<title><?php echo conf("APP_NAME");?><?php echo l("ADMIN_PLATFORM");?></title>
</head>
<body style="background:white;margin:0 12px;">
<style type="text/css">
	.menu_item dt {margin-bottom:3px;height:16px;font-size:14px;padding:10px 20px;font-weight:bold;}
	.menu_item dt {background: #f2f2f2;cursor:pointer;border: 1px solid #ccc;}
	.menu_item dd {float:left;margin-left: 20px;margin-top: 5px;padding: 3px 10px;font-size: 14px;}
	.menu_item dd a{text-decoration:none;color: #2076a3;}
	.menu_item dd a:hover{color: #ffb221;}
</style>

	<?php if(is_array($menus)): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_group): ++$k;$mod = ($k % 2 )?><dl class="menu_item">
		<dt><i class="ace-icon fa fa-sitemap"></i>&nbsp;<?php echo ($menu_group["name"]); ?></dt>
		<div class="blank5"></div>
		<?php if(is_array($menu_group["nodes"])): foreach($menu_group["nodes"] as $key=>$node): ?><?php if(!isset($node['show']) or ($node['show'] == true)): ?><dd>
			<a href="<?php echo u($node["module"]."/".$node["action"]);?>" {if $node.module eq 'Loads' and $node.action eq 'index'}style="color:red"{/if}>
				<div class="menu-link"><i class="ace-icon fa fa-check-square-o"></i>&nbsp;<?php echo ($node["name"]); ?></div>
			</a>
		</dd><?php endif; ?><?php endforeach; endif; ?>
	</dl>
		<div class="blank5"></div><?php endforeach; endif; else: echo "" ;endif; ?>
</body>

<script type="text/javascript">
	$(".menu_item").find("a").bind("click",function(){
		var href = $(this).attr("href");
		var menu = $(parent.menu.document).find("a");
		for (var i=0; i<menu.length; i++) {
			if (href == $(menu[i]).attr("href")) {
				var obj = $(menu[i]);
				if(obj.parents("dl").hasClass("menu-hide")){
					obj.parents("dl").removeClass("menu-hide").siblings().addClass("menu-hide");
				}
			}
		}
	});

	$(".menu_item").find("dt").bind("click",function(){
		var cont = $(this).html();
		var menu = $(parent.menu.document).find("dt");
		for (var i=0; i<menu.length; i++) {
			if (cont == $(menu[i]).html()) {
				var obj = $(menu[i]);
				if(obj.parents("dl").hasClass("menu-hide")){
					obj.parents("dl").removeClass("menu-hide").siblings().addClass("menu-hide");
				}
			}
		}
		return false;
	});
</script>
</html>