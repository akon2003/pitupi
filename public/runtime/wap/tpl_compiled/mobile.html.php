<div class="pro_detail">
	<div class="container" style="border-bottom: 3px solid #ccc;">
		<div class="h10"></div>
		<div class="row">
			<div class="col-xs-12">
				<div class="" style="font-size: 16px;font-weight: 600;">基本信息</div>
				<div class="h10"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-5 xiejun_border_top xiejun_border_left_bottom">融资方</div>
				<div class="col-xs-7 xiejun_border_top xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'hideUserName',
  'v' => $this->_var['data']['u_info']['user_name'],
);
echo $k['name']($k['v']);
?></div>
			</div>
		</div>
		<div class="h10"></div>
	</div>
	<div class="container" style="border-bottom: 3px solid #ccc;background-color: #ccc;">
		<div class="row" style="padding: 0 3px;">
			<div class="col-xs-12 radiu5" style="background-color: #fff;">
				<div class="row xiejun_radius_title">
					<div class="col-xs-12">
						<div class="h10"></div>
						<div class="" style="font-size: 16px;font-weight: 600;">担保方信息</div>
						<div class="h10"></div>
					</div>
				</div>
				<div class="h10"></div>
				<div class="row">
					<div class="col-xs-12">
						<div class="" style="padding-right: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['data']['deal']['agency_info']['content']; ?></div>
					</div>
				</div>
				<div class="h10"></div>
			</div>
		</div>
	</div>
	<div class="container" style="border-bottom: 3px solid #ccc;background-color: #ccc;">
		<div class="row" style="padding: 0 3px;">
			<div class="col-xs-12 radiu3" style="background-color: #fff;">				
				<div class="row xiejun_radius_title">
					<div class="col-xs-12">
						<div class="h10"></div>
						<div class="" style="font-size: 16px;font-weight: 600;">信贷借款记录</div>
						<div class="h10"></div>
					</div>
				</div>
				<div class="h10"></div>
				<div class="row">
					<div class="col-xs-12">
						<div class="col-xs-5 xiejun_border_top xiejun_border_left_bottom">发布借款笔数</div>
						<div class="col-xs-7 xiejun_border_top xiejun_border_left_bottom xiejun_border_right"><?php echo $this->_var['data']['user_statics']['deal_count']; ?></div>
					</div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">成功借款笔数</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php echo $this->_var['data']['user_statics']['success_deal_count']; ?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">还清笔数</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php echo $this->_var['data']['user_statics']['repay_deal_count']; ?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">逾期次数</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php echo $this->_var['data']['user_statics']['yuqi_count']; ?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">共计借入</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['borrow_amount'],
);
echo $k['name']($k['v']);
?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">待还本息</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data'][''],
);
echo $k['name']($k['v']);
?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">逾期金额</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['yuqi_amount'],
);
echo $k['name']($k['v']);
?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">共计借出</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_money'],
);
echo $k['name']($k['v']);
?></div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="col-xs-5 xiejun_border_left_bottom">待收本息</div>
                    	<div class="col-xs-7 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_wait_repay_money'],
);
echo $k['name']($k['v']);
?></div>
                    </div>
				</div>
				<div class="h10"></div>
			</div>
		</div>
	</div>
	<div class="container hidden" style="border-bottom: 3px solid #ccc; background-color: #ccc;">
		<div class="row" style="padding: 0 3px;">
			<div class="col-xs-12 radiu3" style="background-color: #fff;">
				<div class="h10"></div>
				<div class="row" style="font-size: 15px;font-weight: 600;">
					<div class="col-xs-4">审核项目</div>
					<div class="col-xs-4">状态</div>
					<div class="col-xs-4">通过时间</div>
				</div>
				<div class="h10"></div>
				<?php if ($this->_var['data']['u_info']['idcardpassed'] == 1 || ( $this->_var['data']['u_info']['idcardpassed'] == 0 && $this->_var['data']['credit_file']['credit_identificationscanning']['file_list'] )): ?>
				<div class="row">
					<div class="col-xs-4">身份证认证</div>
					<div class="col-xs-4"><?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>资料已上传，待审核<?php endif; ?></div>
					<div class="col-xs-4"><?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['idcardpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?><?php endif; ?>&nbsp;</div>
				</div>
				<?php endif; ?>
				<?php if ($this->_var['data']['u_info']['workpassed'] == 1 || ( $this->_var['data']['u_info']['workpassed'] == 0 && $this->_var['data']['credit_file']['credit_contact']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">工作认证</div>
                    <div class="col-xs-4">
                    <?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
			   		<?php if ($this->_var['data']['expire']['workpassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4">
                    <?php if (! $this->_var['data']['expire']['workpassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['workpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?><?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['creditpassed'] == 1 || ( $this->_var['data']['u_info']['creditpassed'] == 0 && $this->_var['data']['credit_file']['credit_credit']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">信用报告</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['creditpassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if (! $this->_var['data']['expire']['creditpassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['creditpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
         <!-- xsz -->       
                <?php if ($this->_var['data']['u_info']['incomepassed'] == 1 || ( $this->_var['data']['u_info']['incomepassed'] == 0 && $this->_var['data']['credit_file']['credit_incomeduty']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">收入认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['incomepassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if (! $this->_var['data']['expire']['incomepassed_expire']): ?>
	             	<?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['incomepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				    <?php endif; ?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['housepassed'] == 1 || ( $this->_var['data']['u_info']['housepassed'] == 0 && $this->_var['data']['credit_file']['credit_house']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">房产认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"> <?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?>
	               <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['housepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				   <?php endif; ?>&nbsp;</div>
                </div>
                 <?php endif; ?>
                 
                <?php if ($this->_var['data']['u_info']['carpassed'] == 1 || ( $this->_var['data']['u_info']['carpassed'] == 0 && $this->_var['data']['credit_file']['credit_car']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">购车证明</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4">	<?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['carpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['marrypassed'] == 1 || ( $this->_var['data']['u_info']['marrypassed'] == 0 && $this->_var['data']['credit_file']['credit_marriage']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">结婚认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['marrypassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['edupassed'] == 1 || ( $this->_var['data']['u_info']['edupassed'] == 0 && $this->_var['data']['credit_file']['credit_graducation']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">学历认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['edupassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['skillpassed'] == 1 || ( $this->_var['data']['u_info']['skillpassed'] == 0 && $this->_var['data']['credit_file']['credit_titles']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">技术职称认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['skillpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</div>
                </div>
                 <?php endif; ?>
                 
                 <?php if ($this->_var['data']['u_info']['videopassed'] == 1 || ( $this->_var['data']['u_info']['videopassed'] == 0 && $this->_var['data']['u_info']['has_send_video'] == 1 )): ?>
                <div class="row">
                    <div class="col-xs-4">视频认证通过</div>
                    <div class="col-xs-4"><?php if ($this->_var['u_info']['videopassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if ($this->_var['u_info']['videopassed'] == 1): ?>
            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['videopassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				<?php endif; ?>&nbsp;</div>
                </div>
                 <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1 || ( $this->_var['data']['u_info']['mobiletruepassed'] == 0 && $this->_var['data']['credit_file']['credit_mobilereceipt']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">手机实名认证</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['mobiletruepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>   
                
                <?php if ($this->_var['data']['u_info']['residencepassed'] == 1 || ( $this->_var['data']['u_info']['residencepassed'] == 0 && $this->_var['data']['credit_file']['credit_residence']['file_list'] )): ?>
                <div class="row">
                    <div class="col-xs-4">居住地证明</div>
                    <div class="col-xs-4"><?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['residencepassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></div>
                    <div class="col-xs-4"><?php if (! $this->_var['data']['expire']['residencepassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['residencepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>
					<?php endif; ?>&nbsp;</div>
                </div>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['info_down']): ?>
                <div class="row">
                    <div class="col-xs-4">会员资料下载</div>
                    <div class="col-xs-4"><span class="Tick"><i class="fa fa-check"></i></span></div>
                    <div class="col-xs-4"><a href="<?php echo $this->_var['u_info']['info_down']; ?>">下载查看</a>&nbsp;</div>
                </div>
                <?php endif; ?>
				<div class="h10"></div>
			</div>
		</div>
	</div>
	
	<div class="container" style="border-bottom: 3px solid #ccc;background-color: #ccc;">
		<div class="row" style="padding: 0 3px;">
			<div class="col-xs-12 radiu3" style="background-color: #fff;">
				<div class="row xiejun_radius_title">
					<div class="col-xs-12">
						<div class="h10"></div>
						<div class="" style="font-size: 16px;font-weight: 600;">投资记录</div>
						<div class="h10"></div>
					</div>
				</div>
				<div class="h10"></div>
				<div class="row">
					<?php if ($this->_var['data']['load_list']): ?>
					<div class="col-xs-12">
						<div class="col-xs-12 xiejun_border_top"></div>
					</div>
					<?php $_from = $this->_var['data']['load_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'load');if (count($_from)):
    foreach ($_from AS $this->_var['load']):
?>
					<div class="col-xs-12">
						<div class="col-xs-3 xiejun_border_left_bottom"><?php 
$k = array (
  'name' => 'utf_substr',
  'v' => $this->_var['load']['user_name'],
);
echo $k['name']($k['v']);
?></div>
						<div class="col-xs-4 xiejun_border_left_bottom"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['load']['money'],
);
echo $k['name']($k['v']);
?></div>
						<div class="col-xs-5 xiejun_border_left_bottom xiejun_border_right"><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?></div>
					</div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					<?php else: ?>
					<div class="col-xs-12">
						<div class="col-xs-12" style="border: 1px solid #ccc;">
							没有投资记录！
						</div>
					</div>
					<?php endif; ?>
				</div>
				<div class="h10"></div>
			</div>
		</div>
	</div>

	
	
	
	
        <div class="mainblok mainborder hidden">
            <div class="pro_detail_tit">
                <span><i class="fa fa-newspaper-o"></i></span>
                借入者信用信息
            </div>
            <!--
            <div class="detail_article">
                <p><?php echo $this->_var['data']['deal']['agency_info']['company_brief']; ?></p>
            </div>
            -->
            <div class="detail_list">
                <div class="detail_list_tit"><span></span> 基本信息</div>
                <div class="basic_ifm">
                    <ul>
                        <li><label>融资方</label><span><?php 
$k = array (
  'name' => 'hideUserName',
  'v' => $this->_var['data']['u_info']['user_name'],
);
echo $k['name']($k['v']);
?></span></li>
                        <!--
                        <li><label>性别</label><span><?php if ($this->_var['data']['u_info']['sex'] > 0): ?><?php if ($this->_var['data']['u_info']['sex'] == 1): ?>男<?php else: ?>女<?php endif; ?><?php else: ?>未知<?php endif; ?></span></li>
                        <li><label>年龄</label><span><?php echo to_date(get_gmtime(),"Y")- $this->_var['data']['u_info']['byear'];?> </span></li> 
                        <li><label>是否结婚</label><span><?php echo $this->_var['data']['u_info']['marriage']; ?></span></li>
                        <li><label>工作城市</label><span><?php echo $this->_var['data']['u_info']['region_province']; ?>&nbsp;&nbsp;<?php echo $this->_var['data']['u_info']['region_city']; ?></span></li>
                        <li><label>公司行业</label><span><?php echo $this->_var['data']['u_info']['workinfo']['officedomain']; ?></span></li>
                        <li><label>公司规模</label><span><?php echo $this->_var['data']['u_info']['workinfo']['officecale']; ?></span></li>
                        <li><label>工作收入</label><span><?php echo $this->_var['data']['u_info']['workinfo']['salary']; ?></span></li>
                        <li><label>学历</label><span><?php echo $this->_var['data']['u_info']['graduation']; ?></span></li>
                        <li><label>有无购房</label><span><?php if ($this->_var['data']['u_info']['hashouse'] == 1): ?><?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?><font>有</font><?php else: ?>有<?php endif; ?><?php else: ?>无<?php endif; ?></span></li>
                        -->
		 			</ul>
                </div>
            </div>
            <div class="detail_list">
                <div class="detail_list_tit"><span></span> 担保方信息</div>
                <div class="basic_ifm">
                    <ul>
                        <li><label>担保方</label><span><?php echo $this->_var['data']['deal']['agency_info']['content']; ?></span></li>
		 			</ul>
                </div>
            </div>
            <div class="detail_list">
                <div class="detail_list_tit"><span></span>信贷借款记录</div>
                <div class="basic_ifm">
                    <ul class="Borrow_record">
                        <li><label>发布借款笔数</label><span><?php echo $this->_var['data']['user_statics']['deal_count']; ?></span></li>
                        <li><label>成功借款笔数</label><span><?php echo $this->_var['data']['user_statics']['success_deal_count']; ?></span></li>
                        <li><label>还清笔数</label><span><?php echo $this->_var['data']['user_statics']['repay_deal_count']; ?></span></li>
                        <li><label>逾期次数</label><span><?php echo $this->_var['data']['user_statics']['yuqi_count']; ?></span></li>
                        <li><label>共计借入</label><span><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['borrow_amount'],
);
echo $k['name']($k['v']);
?></span></li>
                        <li><label>待还本息</label><span><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data'][''],
);
echo $k['name']($k['v']);
?></span></li>
                        <li><label>逾期金额</label><span><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['yuqi_amount'],
);
echo $k['name']($k['v']);
?></span></li>
                        <li><label>共计借出</label><span><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_money'],
);
echo $k['name']($k['v']);
?></span></li>
                        <li><label>待收本息</label><span><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_wait_repay_money'],
);
echo $k['name']($k['v']);
?></span></li>
                    </ul>
                </div>
            </div>
        </div><!--mainblok——end--> 

        <div class="mainblok mainborder hidden">
            <div class="pro_detail_tit">
                <span><i class="fa fa-newspaper-o"></i></span>
                审核记录
            </div>
            <div class="detail_list">
            <div class="audit_records_tit">
                <ul>
                    <li>审核项目</li>
                    <li>状态</li>
                    <li>通过时间</li>
                </ul> 
                <div class="blank"></div>
            </div>
            <div class="audit_records">
          		
          		<?php if ($this->_var['data']['u_info']['idcardpassed'] == 1 || ( $this->_var['data']['u_info']['idcardpassed'] == 0 && $this->_var['data']['credit_file']['credit_identificationscanning']['file_list'] )): ?>
                <ul>
                    <li>身份证认证</li>
                    <li><?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>资料已上传，待审核<?php endif; ?></li>
                    <li><?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['idcardpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?><?php endif; ?>&nbsp;</li>
                </ul> 
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['workpassed'] == 1 || ( $this->_var['data']['u_info']['workpassed'] == 0 && $this->_var['data']['credit_file']['credit_contact']['file_list'] )): ?>
                <ul>
                    <li>工作认证</li>
                    <li>
                    <?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
			   		<?php if ($this->_var['data']['expire']['workpassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li>
                    <?php if (! $this->_var['data']['expire']['workpassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['workpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?><?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['creditpassed'] == 1 || ( $this->_var['data']['u_info']['creditpassed'] == 0 && $this->_var['data']['credit_file']['credit_credit']['file_list'] )): ?>
                <ul>
                    <li>信用报告</li>
                    <li><?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['creditpassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if (! $this->_var['data']['expire']['creditpassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['creditpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
         <!-- xsz -->       
                <?php if ($this->_var['data']['u_info']['incomepassed'] == 1 || ( $this->_var['data']['u_info']['incomepassed'] == 0 && $this->_var['data']['credit_file']['credit_incomeduty']['file_list'] )): ?>
                <ul>
                    <li>收入认证</li>
                    <li><?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['incomepassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if (! $this->_var['data']['expire']['incomepassed_expire']): ?>
	             	<?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
	                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['incomepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				    <?php endif; ?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['housepassed'] == 1 || ( $this->_var['data']['u_info']['housepassed'] == 0 && $this->_var['data']['credit_file']['credit_house']['file_list'] )): ?>
                <ul>
                    <li>房产认证</li>
                    <li><?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li> <?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?>
	               <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['housepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				   <?php endif; ?>&nbsp;</li>
                </ul>
                 <?php endif; ?>
                 
                <?php if ($this->_var['data']['u_info']['carpassed'] == 1 || ( $this->_var['data']['u_info']['carpassed'] == 0 && $this->_var['data']['credit_file']['credit_car']['file_list'] )): ?>
                <ul>
                    <li>购车证明</li>
                    <li><?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li>	<?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['carpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['marrypassed'] == 1 || ( $this->_var['data']['u_info']['marrypassed'] == 0 && $this->_var['data']['credit_file']['credit_marriage']['file_list'] )): ?>
                <ul>
                    <li>结婚认证</li>
                    <li><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['marrypassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['edupassed'] == 1 || ( $this->_var['data']['u_info']['edupassed'] == 0 && $this->_var['data']['credit_file']['credit_graducation']['file_list'] )): ?>
                <ul>
                    <li>学历认证</li>
                    <li><?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['edupassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['skillpassed'] == 1 || ( $this->_var['data']['u_info']['skillpassed'] == 0 && $this->_var['data']['credit_file']['credit_titles']['file_list'] )): ?>
                <ul>
                    <li>技术职称认证</li>
                    <li><?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['skillpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                 <?php endif; ?>
                 
                 <?php if ($this->_var['data']['u_info']['videopassed'] == 1 || ( $this->_var['data']['u_info']['videopassed'] == 0 && $this->_var['data']['u_info']['has_send_video'] == 1 )): ?>
                <ul>
                    <li>视频认证通过</li>
                    <li><?php if ($this->_var['u_info']['videopassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if ($this->_var['u_info']['videopassed'] == 1): ?>
            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['videopassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
				<?php endif; ?>&nbsp;</li>
                </ul>
                 <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1 || ( $this->_var['data']['u_info']['mobiletruepassed'] == 0 && $this->_var['data']['credit_file']['credit_mobilereceipt']['file_list'] )): ?>
                <ul>
                    <li>手机实名认证</li>
                    <li><?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?><span class="Tick"><i class="fa fa-check"></i></span><?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['mobiletruepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>   
                
                <?php if ($this->_var['data']['u_info']['residencepassed'] == 1 || ( $this->_var['data']['u_info']['residencepassed'] == 0 && $this->_var['data']['credit_file']['credit_residence']['file_list'] )): ?>
                <ul>
                    <li>居住地证明</li>
                    <li><?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
					<?php if ($this->_var['data']['expire']['residencepassed_expire']): ?>
					已过期
					<?php else: ?><span class="Tick"><i class="fa fa-check"></i></span><?php endif; ?>
					<?php else: ?>
					资料已上传，待审核
					<?php endif; ?></li>
                    <li><?php if (! $this->_var['data']['expire']['residencepassed_expire']): ?>
	            	<?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
	            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['residencepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php endif; ?>
					<?php endif; ?>&nbsp;</li>
                </ul>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['info_down']): ?>
                <ul>
                    <li>会员资料下载</li>
                    <li><span class="Tick"><i class="fa fa-check"></i></span></li>
                    <li><a href="<?php echo $this->_var['u_info']['info_down']; ?>">下载查看</a>&nbsp;</li>
                </ul>
                <?php endif; ?>
                <div class="blank"></div>              
            </div>
            </div>
        </div><!--mainblok——end--> 

        <div class="mainblok mainborder hidden">
            <div class="pro_detail_tit">
                <span><i class="fa fa-newspaper-o"></i></span>
                投资记录
            </div>
            <div class="detail_list">
                <div class="investment_records">
                  <?php $_from = $this->_var['data']['load_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'load');if (count($_from)):
    foreach ($_from AS $this->_var['load']):
?>
                    <ul>
                        <li><?php 
$k = array (
  'name' => 'utf_substr',
  'v' => $this->_var['load']['user_name'],
);
echo $k['name']($k['v']);
?></li>
                        <li>
                            <h1><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['load']['money'],
);
echo $k['name']($k['v']);
?></h1>
                            <span><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
						<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'H:i',
);
echo $k['name']($k['v'],$k['f']);
?></span>
                        </li>
                        <li class="blank"></li>
                    </ul>
                    
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </div>
        </div><!--mainblok——end--> 

        <!--
        <div class="mainblok mainborder">
            <div class="pro_detail_tit">
                <span><i class="fa fa-newspaper-o"></i></span>
                留言列表
            </div>
            <div class="detail_list sxpd5">
        
           <?php $_from = $this->_var['data']['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'load');if (count($_from)):
    foreach ($_from AS $this->_var['load']):
?>
            <div class="message_list">
                <h2><?php echo $this->_var['load']['user_name']; ?> &nbsp;&nbsp; <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?></h2>
                <span>【<?php echo $this->_var['load']['title']; ?>】:<?php echo $this->_var['load']['content']; ?></span>
            </div>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            

            </div>
        </div>
        --><!--mainblok——end--> 

    </div>
<!--<div class="pro_detail_foot leave_word btn_leave_word">
留言
</div>-->
<div class="Leave_Word">
<div class="Leave_Word_block">	
		 <input type="hidden" id="title" value="留言板">
		 <textarea id="content" name="content"></textarea> 
</div>
<div class="lish_but clearfix">
		 	<div class="abolish  lish">取消</div>
		 	<?php if ($this->_var['data']['act'] == 'transfer_mobile'): ?>
		 	<input type="hidden" id="rel_table" value="transfer">
		 	<input type="hidden" id="rel_id" value="<?php echo $this->_var['data']['transfer_id']; ?>">
		 	<?php else: ?>
		 	<input type="hidden" id="rel_table" value="deal">
		 	<input type="hidden" id="rel_id" value="<?php echo $this->_var['data']['deal_id']; ?>">
		 	<?php endif; ?>
		 	<input type="hidden" id="deal_id" value="<?php echo $this->_var['data']['deal']['id']; ?>">
			<div id="add_msg" class="publish  lish ">发表</div>
</div>
</div>
<script>
	$(document).ready(function(){
		$(".leave_word").click(function(){
			$(".Leave_Word").toggle();
			$(".btn_leave_word").hide();
			
		});
		$(".abolish").click(function(){
			$(".Leave_Word").hide();
			$(".btn_leave_word").show();
		});
	});
	
	$("#add_msg").click(function(){
		var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|msg|"."".""); 
?>';
		var query = new Object();
		query.rel_table = $.trim($("#rel_table").val());
		query.rel_id = $.trim($("#rel_id").val());
		query.title = $.trim($("#title").val());
		query.content = $.trim($("#content").val());
		
		query.post_type = "json";
		$.ajax({
			url:ajaxurl,
			data:query,
			type:"Post",
			dataType:"json",
			success:function(data){
				alert(data.show_err);
				window.location.reload();
			}
		});
	});
</script>

