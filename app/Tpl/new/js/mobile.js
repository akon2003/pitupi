$(document).ready(function() {
// 获取终端的相关信息
var TerminalCCC = {
	// 辨别移动终端类型
	platform : function(){
		var u = navigator.userAgent, app = navigator.appVersion;
		return {
			// android终端或者uc浏览器
			android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
			// 是否为iPhone或者QQHD浏览器
			iPhone: u.indexOf('iPhone') > -1 ,
			// 是否iPad
			iPad: u.indexOf('iPad') > -1
		};
	}(),
	// 辨别移动终端的语言：zh-cn、en-us、ko-kr、ja-jp...
	language : (navigator.browserLanguage || navigator.language).toLowerCase()
}

// 根据不同的终端，跳转到不同的地址
if(TerminalCCC.platform.android || TerminalCCC.platform.iPhone || TerminalCCC.platform.iPad){
	location.href = '/wap/index.php';
	return;
} 
});