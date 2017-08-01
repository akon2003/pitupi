<?php

class WeekwinAction extends CommonAction{
	public function index()
	{
		$everwin = M("PeiziWeekwin")->find();
		$this->assign("everwin",$everwin);
		$this->display();
	}
	
	public function update_index()
	{
		
	}
	
}
?>