<?php echo $this->fetch('./inc/header_nonav.html'); ?>
<?php echo $this->fetch('./inc/header_xiejun.html'); ?>
<?php
	$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/login.css";		
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
<div class="container-fluid">
	<div class="row">
		<img class="img-responsive center-block" src="./images/register.jpg" alt="">
	</div>
</div>
<div class="login">
    <div id="mb_register">
		<input class="logininput mainborder" id="phone" name="phone" type="text" placeholder="输入手机">
		<input class="logininput_getcode mainborder" id="mobile_code" name="mobile_code" type="text" placeholder="输入验证码">
		<input class="ui-button_getcode specialbackground" id="getcode" type="button" value="获取验证码">
		<input class="logininput mainborder" id="user_pwd" name="user_pwd" type="password" placeholder="输入密码">
		<?php if ($this->_var['data']['wap_referer']): ?>
		  <input class="logininput mainborder" id="referer" name="referer" value="<?php echo $this->_var['data']['wap_referer']; ?>" type="hidden" >
		<?php else: ?>
		  <input class="logininput mainborder" id="referer" name="referer" type="text" placeholder="输入推荐人手机号/用户名">
		<?php endif; ?>
		
		<div class="blank"></div> 
		<input class="ui-button_login Headerbackground_dark" type="submit" name="commit" id="signup-submit" value="立即注册有优惠哟！" style="background-color: #ff9600">
    </div>
</div>
<div class="container" style="font-size: 16px;">
	<a class="f_r rgst" href="<?php
echo parse_wap_url_tag("u:index|index|"."".""); 
?>">首页</a>
	<a class="f_l rgst" href="<?php
echo parse_wap_url_tag("u:index|login|"."".""); 
?>">已有帐号，返回登陆</a>
</div>
<script type="text/javascript">

$("#signup-submit").click(function(){
	var name=$.trim($("#user_pwd").val())
	var reg=/(\s+)|(\t+)|(\r+)|(\n+)/;  
	var regs=/.{6,16}/;
	if(!reg.test(name)){	
		if(regs.test(name)){	
		}
		else{
			alert("长度在6~16之间");
			return false;
		}
	}
	else{
		alert("密码输入字符不能包含空格。");
		return false;
	}
	
	var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|register|"."".""); 
?>';
	var query = new Object();
	query.user_pwd = $.trim($("#user_pwd").val());
	query.mobile = $.trim($("#phone").val());
	query.mobile_code = $.trim($("#mobile_code").val());
	query.referer = $.trim($("#referer").val());
	query.post_type = "json";
	query.rel_uid = "<?php echo $this->_var['rel_uid']; ?>";

	$.ajax({
		url:ajaxurl,
		data:query,
		type:"Post",
		dataType:"json",
		success:function(data){
			if(data.user_login_status)
			{	
				alert(data.show_err);
				window.location.href = '<?php
echo parse_wap_url_tag("u:index|register_idno|"."".""); 
?>';
			}else{
				alert(data.show_err);
			}
		}
	});
});


$("#getcode").click(function(){
	var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|send_register_code|"."".""); 
?>';
	var query = new Object();
	query.mobile = $.trim($("#phone").val());
	query.post_type = "json";
	$.ajax({
		url:ajaxurl,
		data:query,
		type:"Post",
		dataType:"json",
		success:function(data){
			alert(data.show_err);
		}
	});
});

$("#user_name").bind("blur",function(){
	// 页面修改代码
	return true; 
	// 结束修改

	var obj = $(this);
	var ajaxurl = APP_ROOT+"/index.php?ctl=ajax&act=check_field";
	var query = new Object();
	query.field_name = "user_name";
	query.field_data = $.trim(obj.val());
	$.ajax({ 
		url: ajaxurl,
		data:query,
		type: "POST",
		dataType: "json",
		success: function(data){
			if(data.status==1)
			{
			
			}
			else
			{
				alert(data.info);
			}
		}
	});	
}); //用户名验证

</script>
<?php echo $this->fetch('./inc/footer.html'); ?>







