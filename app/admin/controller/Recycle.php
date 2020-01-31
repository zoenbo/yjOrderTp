<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Config;
use app\admin\model;

class Recycle extends Order{
	public function add(){
		
	}
	
	public function multi(){
	}
	
	public function recycle(){
		
	}

	public function ui(){
	}

	public function outputdiy(){
	}

	public function recover(){
		if (Request::get('id')){
			$Order = new model\Order();
			if (!$Order->one()) return $this->failed('不存在此订单，或没有此订单的管理权限！');
			return $Order->recover() ? $this->success(Config::get('app.prev_url'),'订单还原成功！') : $this->failed('订单还原失败！');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function delete(){
		if (Request::get('id')){
			$Order = new model\Order();
			if (!$Order->one()) return $this->failed('不存在此订单，或没有此订单的管理权限！');
			if (Request::isPost()) return $Order->remove() ? $this->success(Request::post('prev'),'订单删除成功！') : $this->failed('订单删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}