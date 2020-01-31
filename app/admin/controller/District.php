<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\View;
use app\admin\model;

class District extends Base{
	public function index(){
		$District = new model\District();
		$object = $District->all($this->page($District->total()));
		foreach ($object as $key=>$value){
			$object[$key]['child'] = $District->one2($value['id']);
		}
		View::assign([
			'All'=>$object,
			'Map'=>$this->whole(Request::get('pid')),
			'ParentId'=>$District->one(Request::get('pid'))['pid']
		]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$District = new model\District();
			$object = $District->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index',['pid'=>Request::get('pid')]),'行政区划添加成功！') : $this->failed('行政区划添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		View::assign(['Map'=>$this->whole(Request::get('pid'))]);
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$District = new model\District();
			$object = $District->one();
			if (!$object) return $this->failed('不存在此行政区划！');
			if (Request::isPost()){
				$object2 = $District->modify($object['pid']);
				return is_numeric($object2) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index',['pid'=>$object['pid']]),'行政区划修改成功！') : $this->failed($object2);
			}
			View::assign(['One'=>$object]);
			View::assign(['Map'=>$this->whole($object['pid'])]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function delete(){
		if (Request::get('id')){
			$District = new model\District();
			if (!$District->one()) return $this->failed('不存在此行政区划！');
			if ($District->one2(Request::get('id'))) return $this->failed('此行政区划下有子行政区划，无法删除！');
			if (Request::isPost()) return $District->remove() ? $this->success(Request::post('prev'),'行政区划删除成功！') : $this->failed('行政区划删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	private function whole($pid=0){
		$name = '';
		$District = new model\District();
		$object = $District->one($pid);
		if ($object){
			$name .= $object['name'];
			if ($object['pid']) $name = $this->whole($object['pid']).' - '.$name;
		}
		return $name;
	}
}