<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Smtp extends Base{
	public function index(){
		$Smtp = new model\Smtp();
		$object = $Smtp->all($this->page($Smtp->total()));
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法添加！');
			$Smtp = new model\Smtp();
			$object = $Smtp->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'SMTP服务器添加成功！') : $this->failed('SMTP服务器添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		return $this->view();
	}
	
	public function state(){
		$Smtp = new model\Smtp();
		$object = [];
		if ($Smtp->total() > 0){
			foreach (range(0,23) as $value){
				$temp = $Smtp->one3($value);
				if ($value < 10) $value = '0'.$value;
				$temp['hour'] = $value;
				$object[] = $temp;
			}
		}
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Smtp = new model\Smtp();
			$object = $Smtp->one();
			if (!$object) return $this->failed('不存在此SMTP服务器！');
			if (Request::isPost()){
				if (Config::get('app.demo')) return $this->failed('演示站，数据无法修改！');
				$object = $Smtp->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'SMTP服务器修改成功！') : $this->failed($object);
			}
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法删除！');
			$Smtp = new model\Smtp();
			if (!$Smtp->one()) return $this->failed('不存在此SMTP服务器！');
			if (Request::isPost()) return $Smtp->remove() ? $this->success(Request::post('prev'),'SMTP服务器删除成功！') : $this->failed('SMTP服务器删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
}