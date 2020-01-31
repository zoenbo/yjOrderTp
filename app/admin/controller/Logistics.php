<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\View;
use app\admin\model;

class Logistics extends Base{
	public function index(){
		$Logistics = new model\Logistics();
		$object = $Logistics->all($this->page($Logistics->total()));
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Logistics = new model\Logistics();
			$object = $Logistics->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'物流添加成功！') : $this->failed('物流添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		return $this->view();
	}
	
	public function multi(){
		if (Request::isPost()){
			$Logistics = new model\Logistics();
			$object = $Logistics->multi();
			return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'物流批量添加成功！') : $this->failed($object);
		}
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Logistics = new model\Logistics();
			$object = $Logistics->one();
			if (!$object) return $this->failed('不存在此物流！');
			if (Request::isPost()){
				$object = $Logistics->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'物流修改成功！') : $this->failed($object);
			}
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function delete(){
		if (Request::get('id')){
			$Logistics = new model\Logistics();
			if (!$Logistics->one()) return $this->failed('不存在此物流！');
			if (Request::isPost()) return $Logistics->remove() ? $this->success(Request::post('prev'),'物流删除成功！') : $this->failed('物流删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}