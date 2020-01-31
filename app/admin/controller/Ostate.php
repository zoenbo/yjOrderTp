<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Ostate extends Base{
	public function index(){
		$Ostate = new model\Ostate();
		View::assign(['All'=>$Ostate->all($this->page($Ostate->total()))]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Ostate = new model\Ostate();
			$object = $Ostate->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单状态添加成功！') : $this->failed('订单状态添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Ostate = new model\Ostate();
			$object = $Ostate->one();
			if (!$object) return $this->failed('不存在此订单状态！');
			if (Request::isPost()){
				if (Config::get('app.demo')) if (in_array(Request::get('id'),[1,2,3,4])) return $this->failed('演示站，id为1、2、3、4的订单状态无法修改！');
				$object = $Ostate->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单状态修改成功！') : $this->failed($object);
			}
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function selected(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，无法设置默认订单状态！');
			$Ostate = new model\Ostate();
			if (!$Ostate->one()) return $this->failed('不存在此订单状态！');
			if (!$Ostate->selected()) return $this->failed('设置默认订单状态失败！');
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function sort(){
		if (Request::isPost()){
			$Ostate = new model\Ostate();
			foreach (Request::post('sort') as $key=>$value){
				if (!is_numeric($value)) continue;
				$Ostate->sort($key,$value);
			}
			return $this->success(Config::get('app.prev_url'),'订单状态排序成功！');
		}
		return '';
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo')) if (in_array(Request::get('id'),[1,2,3,4])) return $this->failed('演示站，id为1、2、3、4的订单状态无法删除！');
			$Ostate = new model\Ostate();
			if (!$Ostate->one()) return $this->failed('不存在此订单状态！');
			if (Request::isPost()) return $Ostate->remove() ? $this->success(Request::post('prev'),'订单状态删除成功！') : $this->failed('订单状态删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}