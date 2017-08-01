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
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<?php function show_deal($name,$deal_id){
		return '<a href="__ROOT__/index.php?ctl=deal&id='.$deal_id.'" target="_blank">'.$name.'</a>';
	}
	function get_transfer_status($status,$t_user_id){
		if($t_user_id > 0){
			return '已转让';
		}
		elseif($status == 0){
			return '已撤销';
		}
		else
			return '转让中';
	}
	function transfer_reback($id,$transfer){
		if($transfer['status'] > 0 && $transfer['t_user_id']==0){
			return '<a href="javascript:reback('.$id.');">撤销</a>';
		}
	} ?>
<script>
function export_csv()
{
	var inputs = $(".search_row").find("input");
	var selects = $(".search_row").find("select");
	var param = '';
	//var csv_set =  $("#csv_set").val();
	for(i=0;i<inputs.length;i++)
	{
		if(inputs[i].name!='m'&&inputs[i].name!='a')
		param += "&"+inputs[i].name+"="+$(inputs[i]).val();
	}
	for(i=0;i<selects.length;i++)
	{
		param += "&"+selects[i].name+"="+$(selects[i]).val();
	}
	var url= ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=export_csv";
	location.href = url+param;
}
</script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="10" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px    "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','Transfer','index')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('name','<?php echo ($sort); ?>','Transfer','index')" title="按照原始标    <?php echo ($sortType); ?> ">原始标    <?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_id','<?php echo ($sort); ?>','Transfer','index')" title="按照转让者    <?php echo ($sortType); ?> ">转让者    <?php if(($order)  ==  "user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('t_user_id','<?php echo ($sort); ?>','Transfer','index')" title="按照承接者    <?php echo ($sortType); ?> ">承接者    <?php if(($order)  ==  "t_user_id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('transfer_time','<?php echo ($sort); ?>','Transfer','index')" title="按照承接时间    <?php echo ($sortType); ?> ">承接时间    <?php if(($order)  ==  "transfer_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('transfer_amount','<?php echo ($sort); ?>','Transfer','index')" title="按照转让价格    <?php echo ($sortType); ?> ">转让价格    <?php if(($order)  ==  "transfer_amount"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('transfer_number','<?php echo ($sort); ?>','Transfer','index')" title="按照转让期数    <?php echo ($sortType); ?> ">转让期数    <?php if(($order)  ==  "transfer_number"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','Transfer','index')" title="按照发布时间    <?php echo ($sortType); ?> ">发布时间    <?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('status','<?php echo ($sort); ?>','Transfer','index')" title="按照状态<?php echo ($sortType); ?> ">状态<?php if(($order)  ==  "status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th class="op_action"><a href="javascript:void(0)" class="A_opration">操作</a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$transfer): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($transfer["id"]); ?></td><td>&nbsp;<?php echo ($transfer["name"]); ?></td><td>&nbsp;<?php echo (get_user_real_name($transfer["user_id"])); ?></td><td>&nbsp;<?php echo (get_user_real_name($transfer["t_user_id"])); ?></td><td>&nbsp;<?php echo (to_date($transfer["transfer_time"])); ?></td><td>&nbsp;<?php echo (format_price($transfer["transfer_amount"])); ?></td><td>&nbsp;<?php echo ($transfer["transfer_number"]); ?></td><td>&nbsp;<?php echo (to_date($transfer["create_time"])); ?></td><td>&nbsp;<?php echo (get_transfer_status($transfer["status"],$transfer['t_user_id'])); ?></td><td class="op_action"><div class="viewOpBox"><a href="javascript:vdetail('<?php echo ($transfer["id"]); ?>')">详情</a>&nbsp;<?php echo (transfer_reback($transfer["id"],$transfer)); ?></div><a href="javascript:void(0);" class="opration">操作+</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="10" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
<script type="">
	function vdetail(id){
		window.open("__ROOT__/index.php?ctl=transfer&act=detail&id="+id);
	}
	function reback(id){
		$.ajax({
			url:ROOT+'?m=Transfer&a=reback&id='+id,
			dataType:"json",
			success:function(ajaxobj){
				if(ajaxobj.status == 1){
					$.weeboxs.open(ajaxobj.info, {contentType:'html',showButton:false,title:"撤销转让",width:600,height:400});
				}
				else{
					alert(ajaxobj.info);		
				}
			},
			error:function(){
				alert("操作失败");
			}
		});
		
	}
</script>
</body>
</html>