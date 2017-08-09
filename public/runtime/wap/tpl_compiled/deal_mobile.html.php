<?php echo $this->fetch('./inc/header.html'); ?>
<?php echo $this->fetch('./inc/header_xiejun.html'); ?>
<?php
	$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/deal_mobile.css";		
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
<!--投资借款具体详情-->
<?php echo $this->fetch('./inc/mobile.html'); ?>	
<?php echo $this->fetch('./inc/footer.html'); ?>







