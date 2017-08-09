<?php echo $this->fetch('./inc/header.html'); ?>
<?php echo $this->fetch('./inc/header_xiejun.html'); ?>
<!--xiejun 2016.7.7 U计划列表显示模板-->
<?php
	$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/deals.css";
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
<!--投资借款列表-->
<?php $_from = $this->_var['data']['uplan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal');if (count($_from)):
    foreach ($_from AS $this->_var['deal']):
?>
    <div class="container" style="border-bottom: 1px solid #ccc;">
    	<div class="h10"></div>
        <div class="row">
            <a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
                <div class="col-xs-3 text-center" style="border-right: 1px solid #cccccc; color: #e76e15;">
                	<div class="row">
                		<div><span style="font-size: 20px;"><?php echo $this->_var['deal']['rate']; ?></span>%</div>
                    	<div style="font-size: 12px">预期年收益</div>
                	</div>
                </div>
            </a>
            <div class="col-xs-9">
                <div class="row">
                    <a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
                        <div class="col-xs-8">
                            <div class="h-5"></div>
                            <div><?php echo $this->_var['deal']['sub_name']; ?></div>
                            <div>期限<?php echo $this->_var['deal']['repay_time']; ?>个月</div>
                        </div>
                    </a>
                    <div class="col-xs-4">
                        <a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
                        	<div class="row">
                        		<div class="content_pic">
                                <?php if ($this->_var['deal']['deal_status'] >= 4): ?>
                                <div class="title">100%</div>
                                <div class="content_pic_1" style="height:100%;">
                                    <?php else: ?>
                                    <div class="title"><?php echo $this->_var['deal']['progress_point']; ?>%</div>
                                    <div class="content_pic_1" style="height:<?php echo $this->_var['deal']['progress_point']; ?>%;">
                                        <?php endif; ?>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="blank"></div>
                        	</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="h10"></div>
            </div>
        </div>
        <div class="h10"></div>
    </div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php echo $this->fetch('./inc/footer.html'); ?>