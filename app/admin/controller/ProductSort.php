<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class ProductSort extends Base{
	public function index(){
		$ProductSort = new model\ProductSort();
		View::assign(['All'=>$ProductSort->all($this->page($ProductSort->total()))]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$ProductSort = new model\ProductSort();
			$object = $ProductSort->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'产品分类添加成功！') : $this->failed('产品分类添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$ProductSort = new model\ProductSort();
			$object = $ProductSort->one();
			if (!$object) return $this->failed('不存在此产品分类！');
			if (Request::isPost()){
				$object = $ProductSort->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'产品分类修改成功！') : $this->failed($object);
			}
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function sort(){
		if (Request::isPost()){
			$ProductSort = new model\ProductSort();
			foreach (Request::post('sort') as $key=>$value){
				if (!is_numeric($value)) continue;
				$ProductSort->sort($key,$value);
			}
			return $this->success(Config::get('app.prev_url'),'产品分类排序成功！');
		}
		return '';
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法删除！');
			$ProductSort = new model\ProductSort();
			if (!$ProductSort->one()) return $this->failed('不存在此产品分类！');
			if (Request::isPost()) return $ProductSort->remove() ? $this->success(Request::post('prev'),'产品分类删除成功！') : $this->failed('产品分类删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}