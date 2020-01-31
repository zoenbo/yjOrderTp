<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Psort extends Base{
	public function index(){
		$Psort = new model\Psort();
		View::assign(['All'=>$Psort->all($this->page($Psort->total()))]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Psort = new model\Psort();
			$object = $Psort->add();
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
			$Psort = new model\Psort();
			$object = $Psort->one();
			if (!$object) return $this->failed('不存在此产品分类！');
			if (Request::isPost()){
				$object = $Psort->modify();
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
			$Psort = new model\Psort();
			foreach (Request::post('sort') as $key=>$value){
				if (!is_numeric($value)) continue;
				$Psort->sort($key,$value);
			}
			return $this->success(Config::get('app.prev_url'),'产品分类排序成功！');
		}
		return '';
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法删除！');
			$Psort = new model\Psort();
			if (!$Psort->one()) return $this->failed('不存在此产品分类！');
			if (Request::isPost()) return $Psort->remove() ? $this->success(Request::post('prev'),'产品分类删除成功！') : $this->failed('产品分类删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}