<?php echo $this->fetch('./inc/header.html'); ?>	
<?php
			$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/search.css";		
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />	
<div class="search">
	<form action="<?php
echo parse_wap_url_tag("u:index|deals|"."".""); 
?>" method="get" id="search_form" >
	 <input type="hidden" name="ctl" value="deals" >
	     <ul>
	     	<li class="condition_team">
	     		      <h3>
	     		      	<i class="fa fa-trophy"></i>
						等级
						</h3>
			    <dl class="clearfix">
			  	      <dd class="current">不限<p>0</p></dd>
					  <dd>B级以上<p>5</p></dd>
					  <dd>C级以上 <p>4</p></dd>
					  <dd>D级以上 <p>3</p></dd>
				      <dd>E级以上 <p>2</p></dd>
					  <input id="level" type="hidden" name="level" value="不限" ><!--这里取值-->
						 
				</dl>
	     	</li>
			<li class="condition_team">
	     		      <h3>
	     		      	<i class="fa fa-fax"></i>
						利率
						</h3>
					  <dl class="clearfix">
					  	      <dd class="current">不限 <p>0</p></dd>
							  <dd>10%以上 <p>10</p></dd>
							   <dd>12%以上 <p>12</p></dd>
							    <dd>15%以上 <p>15</p></dd>
								 <dd>18%以上 <p>18</p></dd>
								   <input id="interest" type="hidden" name="interest" value="不限" ><!--这里取值-->
						</dl>
	     	</li>
	     	
			<li class="condition_team">
	     		      <h3>
	     		      	<i class="fa fa-rebel"></i>
						借款状态
						</h3>
					  <dl class="clearfix">
					  	      <dd class="current">不限<p></p></dd>
					  	      <dd>待等材料<p>0</p></dd>
							  <dd>进行中<p>1</p></dd>
							   <dd>满标<p>2</p></dd>
							    <dd>流标<p>3</p></dd>
								 <dd>还款中<p>4</p></dd>
								 <dd>已还清<p>5</p></dd>
								   <input id="deal_status" type="hidden" name="deal_status" value="不限" ><!--这里取值-->
						</dl>
	     	</li>
	     	
			<li class="condition_team">
	     		        <h3>
		     		      	  <i class="fa fa-flask"></i>
							       剩余时间
						</h3>
					    <dl class="clearfix">
					  	      <dd class="current">不限<p>0</p></dd>
							  <dd>1天以内<p>1</p></dd>
							  <dd>3天以内<p>3</p></dd>
							  <input id="lefttime" type="hidden" name="lefttime" value="不限" ><!--这里取值-->
						</dl>
	     	</li>
	     	
	     	<li class="condition_team">
	     		        <h3>
		     		          <i class="fa fa-history"></i>
						                  期限
						</h3>
					    <dl class="clearfix">
					  	      <dd class="current">不限<p>0</p></dd>
							  <dd>12个月以内<p>12</p></dd>
							  <dd>18个月以内<p>18</p></dd>
							  <input id="months" type="hidden" name="months" value="不限" ><!--这里取值-->
						</dl>
	     	</li>
			
	     </ul>
	   <!--   <a href="<?php
echo parse_wap_url_tag("u:index|deals|"."level=2&interest=10&deal_status=3&lefttime=3&months=12&".""); 
?>">搜索</a>
		 -->
		 <div class="but_search">
		 	<input type="submit" name="commit" value="搜索" >	
		 </div>
			
	</form>
	
</div>
<script>
	$(document).ready(function(){
		  $(".condition_team dd").click(function(){
		  	$(this).addClass("current").siblings().removeClass("current");
			var value=$(this).find("p").html();
			$(this).siblings("input").val(value)
		  });
	});
</script>
<?php echo $this->fetch('./inc/footer.html'); ?>