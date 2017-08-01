<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<link rel="stylesheet" href="__TMPL__Aryee/css/font-awesome.css" />
	<link rel="stylesheet" href="__TMPL__Aryee/css/ace-fonts.css" />
<title><?php echo conf("APP_NAME");?><?php echo l("ADMIN_PLATFORM");?></title>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/left.css" />
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.timer.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/left.js"></script>
</head>
<body style="background:url('__TMPL__Common/images/bkground-10.jpg')">
	<?php if(is_array($menus)): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_group): ++$k;$mod = ($k % 2 )?><dl class="menu menu-hide">
		<dt style="background:url('__TMPL__Common/images/bkground-11.jpg')"><i class="ace-icon fa fa-th-large"></i>&nbsp;<?php echo ($menu_group["name"]); ?></dt>
		<?php if(is_array($menu_group["nodes"])): foreach($menu_group["nodes"] as $key=>$node): ?><?php if(!isset($node['show']) or ($node['show'] == true)): ?><dd><a href="<?php echo u($node["module"]."/".$node["action"]);?>"><i class="ace-icon fa fa-angle-right"></i>&nbsp;<?php echo ($node["name"]); ?></a></dd><?php endif; ?><?php endforeach; endif; ?>		
	</dl><?php endforeach; endif; else: echo "" ;endif; ?>
	<script type="text/javascript">
		var dl =document.getElementsByTagName('dl');/*xiejun 2016.7.22修改左边菜单打开方式*/
		jQuery(function(){
			$(".menu dt").click(function(){
				$(dl).addClass("menu-hide");/*xiejun 2016.7.22修改左边菜单打开方式*/
				$(this).parent().removeClass("menu-hide");/*xiejun 2016.7.22修改左边菜单打开方式*/
			});
		})
	</script>
</body>
</html>