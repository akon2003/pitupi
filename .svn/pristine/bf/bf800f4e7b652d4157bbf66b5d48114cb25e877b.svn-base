<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo conf("APP_NAME");?><?php echo l("ADMIN_PLATFORM");?></title>
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/footer.css" />
<script type="text/javascript">
	var VAR_MODULE = "<?php echo conf("VAR_MODULE");?>";
	var VAR_ACTION = "<?php echo conf("VAR_ACTION");?>";
	var ROOT = '__APP__';
</script>
</head>

<body style="background:url('__TMPL__Common/images/bkground-10.jpg')">
	<div class="footer"><?php echo conf("APP_NAME");?><?php echo l("ADMIN_PLATFORM");?> <?php echo L("APP_VERSION");?>:<?php echo conf("DB_VERSION");?><?php if(app_conf("APP_SUB_VER")){ ?>.<?php echo app_conf("APP_SUB_VER");?><?php } ?>
		<?php if($msg_tip == 1): ?><style type="text/css">
			#admin_tip {position:absolute;z-index:999;background:#FF0;padding:0 5px;height:24px;line-height:24px;right:5px;top:2px;font-size:12px;font-family:'Arial';}
			#admin_tip .tip_header {color:blue;margin-right:5px;}
			#admin_tip .tip_message {color:blue;}
			#admin_tip .tip_close {color:gray;cursor:pointer;margin-left:10px;}
		</style>
		<div id="admin_tip">
			<span class="tip_header">提示信息: </span>
			<span class="tip_message">----</span>
			<span class="tip_close" title="关闭提示"><b>X(关闭)</b></span>
		</div>
		<script type="text/javascript">
			//关闭提示窗口
			$("#admin_tip .tip_close").bind("click", function() {
				$("#admin_tip").hide();
			});

			//定时加载提示窗口
			var t1 = window.setInterval(function() {
				var ajaxurl = 'm.php?m=Index&a=tip';
				var query = new Object();
				query.ajax = 1;
				$.ajax({
					url:ajaxurl,
					data:query,
					type:"Post",
					dataType:"json",
					success:function(data){
						if (data.status) {
							$("#admin_tip").show();
							$("#admin_tip .tip_message").html(data.info);
						}
					},error(e) {
						//
					}
				});
			},5*1000);
		</script><?php endif; ?>	
	</div>
</body>
</html>