<?php
header("Content-type:text/html;charset=utf-8");
class third_userModule extends SiteBaseModule{
	//qq登录系统
   public  function qq_login(){
    	//echo $_GET['a'];die();
        $access_token = $_SESSION['access_token'];
        $appid = $_SESSION['appid'];
        $openid = $_SESSION['openid'];
        //① 通过相关session信息(appid/appkey/openid)就可以获得qq账号的信息了
        //调用qq/user/get_user_info.php接口
        $url = "http://...";
        //对$url进行跨域请求
        //file_get_contents()对其他地址进行请求的时候，“不能传递session信息”
        //需要通过get方式设置
        $info = file_get_contents($url);
        
        //获得昵称信息
        $arr_info = json_decode($info,true);
        print_r($arr_info);
   }
}
