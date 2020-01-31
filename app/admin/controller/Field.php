<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Field extends Base{
	public function index(){
		$Field = new model\Field();
		$object = $Field->all($this->page($Field->total()));
		View::assign(['All'=>$object]);
		return $this->view();
	}

	public function selected(){
		if (Request::get('id')){
			$Field = new model\Field();
			$object = $Field->one();
			if (!$object) return $this->failed('不存在此字段！');
			if ($object['selected'] == 0){
				if (!$Field->selected(1)) return $this->failed('设置默认字段失败！');
			}else{
				if (!$Field->selected(0)) return $this->failed('取消默认字段失败！');
			}
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
}