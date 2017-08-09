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
</script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/main.css" />
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
</head>

<body>
	<div class="main">
	<div class="main_title">网站后台地图</div>
	<div class="blank5"></div>
	<table class="form" cellpadding=0 cellspacing=0>
		<tr>
			<td colspan=2 class="topTd"></td>
		</tr>
		<?php if(is_array($navs)): foreach($navs as $key=>$nav): ?><tr>
				<td colspan=2 class="item_title" style="text-align:left; font-weight:bolder;"><?php echo ($nav["name"]); ?></td>
			</tr>
			<?php if(is_array($nav["groups"])): foreach($nav["groups"] as $key=>$group): ?><tr>
				<td class="item_title" style="width:130px;">
					<?php echo ($group["name"]); ?>
				</td>
				<td class="item_input">				
					<?php if(is_array($group["nodes"])): foreach($group["nodes"] as $key=>$node): ?><a href="<?php echo u($node["module"]."/".$node["action"]); ?>"><?php echo ($node["name"]); ?></a>&nbsp;<?php endforeach; endif; ?>
				</td>
			</tr><?php endforeach; endif; ?><?php endforeach; endif; ?>
		<tr>
			<td colspan=2 class="bottomTd"></td>
		</tr>
	</table>	
	</div>
</body>
</html>