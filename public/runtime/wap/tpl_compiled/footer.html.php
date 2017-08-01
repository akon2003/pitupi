<a href="#top" target="_self" id="go_top"></a> 
<script>
$(document).ready(function(){
	//截断进步比的小数点后两位
	$(".content_pic h1").each(function(){
		var thisvalue=$(this).html();
		$(this).html(Math.round(thisvalue*100)/100+"%")
		
	});	
});
</script>
<?php if ($this->_var['pages'] && $this->_var['data']['act'] != "uc_voucher_exchange"): ?>
	<div class="fy">
		<?php echo $this->_var['pages']; ?>
	</div>
<?php endif; ?>

<footer>
	<div class="footer">
	</div>
</footer>

</body>
<?php if ($this->_var['signPackage']): ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
      debug: false,
      appId: '<?php echo $this->_var['signPackage']['appId']; ?>',
      timestamp: <?php echo $this->_var['signPackage']['timestamp']; ?>,
      nonceStr: '<?php echo $this->_var['signPackage']['nonceStr']; ?>',
      signature: '<?php echo $this->_var['signPackage']['signature']; ?>',
      jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });
  var shareData = {
		//title: '<?php echo $this->_var['page_title']; ?>', // 分享标题
		link: '<?php echo $this->_var['wx_url']; ?>', // 分享链接
	   	// imgUrl: '', // 分享图标
	   	
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	}
   wx.ready(function () {
    // 在这里调用 API
		wx.onMenuShareTimeline(shareData);
		wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareQQ({
		  title: '<?php echo $this->_var['page_title']; ?>',
		  desc: '',
		  link: '<?php echo $this->_var['wx_url']; ?>',
		  imgUrl: '',
		  trigger: function (res) {
			//alert('用户点击分享到QQ');
		  },
		  complete: function (res) {
			//alert(JSON.stringify(res));
		  },
		  success: function (res) {
			//alert('已分享');
		  },
		  cancel: function (res) {
			//alert('已取消');
		  },
		  fail: function (res) {
			//alert(JSON.stringify(res));
		  }
		});
		wx.onMenuShareWeibo(shareData);
  });
</script>
<?php endif; ?>
<style> .la51 a {display: none;} </style>
<div class="la51">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/18868188.js"></script>
</div>
</html>