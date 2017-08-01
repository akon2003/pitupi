<?php echo $this->fetch('./inc/header.html'); ?>
<?php echo $this->fetch('./inc/header_xiejun.html'); ?>
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
<div class="h10"></div>
<div class="invest">
    <?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal');if (count($_from)):
    foreach ($_from AS $this->_var['deal']):
?>
    <div class="row">
        <div class="container" style="border-bottom: 1px solid #ccc;">
            <div class="row">
                <a href="<?php
echo parse_wap_url_tag("u:index|deal|"."id=".$this->_var['deal']['id']."".""); 
?>">
                <div class="col-xs-3 text-center" style="border-right: 1px solid #cccccc; color: #e76e15;">
                	<div class="row">
                		<div><span style="font-size: 20px;"><?php echo $this->_var['deal']['rate']; ?></span>%</div>
                    	<div style="font-size: 12px;">预期年收益</div>
                	</div>
                </div>
                </a>
                <div class="col-xs-9">
                    <div class="row">
                        <a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
                        <div class="col-xs-8">
                        	<div class="row" style="padding-left: 5px;">
                        		<div class="h-5"></div>
	                            <div><?php echo $this->_var['deal']['sub_name']; ?></div>
	                            <div>期限<?php echo $this->_var['deal']['repay_time']; ?>个月</div>
                        	</div>
                        </div>
                        </a>
                        <div class="col-xs-4">
                        	<div class="row">
                        		<div class="h10"></div>
	                            <a href="<?php
echo parse_wap_url_tag("u:index|uplan|"."id=".$this->_var['deal']['id']."".""); 
?>">
	                            	<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?><button type="button" class="btn" style="background: #e76e15;color: #fff;">立即加入</button><?php endif; ?>
									<?php if ($this->_var['deal']['deal_status'] == 2): ?><button type="button" class="btn" style="background: #a9a9a9;color: #fff;">满标</button><?php endif; ?>
									<?php if ($this->_var['deal']['deal_status'] == 3): ?><button type="button" class="btn" style="background: #a9a9a9;color: #fff;">流标</button><?php endif; ?>
									<?php if ($this->_var['deal']['deal_status'] == 4): ?><button type="button" class="btn" style="background: #a9a9a9;color: #fff;">还款中</button><?php endif; ?>
									<?php if ($this->_var['deal']['deal_status'] == 5): ?><button type="button" class="btn" style="background: #a9a9a9;color: #fff;">已还款</button><?php endif; ?>
									<?php if ($this->_var['deal']['deal_status'] == 0): ?><button type="button" class="btn" style="background: #a9a9a9;color: #fff;">等待材料</button><?php endif; ?>
	                            </a>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="h10"></div>
                </div>
            </div>
        </div>
        <div class="h10"></div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>