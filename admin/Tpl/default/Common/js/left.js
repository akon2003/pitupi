$(document).ready(function(){
	$(".menu").find("a").bind("click",function(){
		$(".menu").find("a").removeClass("current");
		parent.main.location.href = $(this).attr("href");
		$(this).addClass("current");
		return false;
	});
	
	var href = location.href;
	if (href.match(/(m=Index).*(key=index)/)) {
		$(".menu").find("a").first().click();
	} else {
		href = href.replace('a=left', 'a=imap');
		parent.main.location.href = href;
	}
});