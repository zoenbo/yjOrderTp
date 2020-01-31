<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Product extends Base{
	public function index(){
		$Product = new model\Product();
		$object = $Product->all($this->page($Product->total()));
		if ($object){
			$Psort = new model\Psort();
			foreach ($object as $key=>$value){
				$object2 = $Psort->one($value['sid']);
				$object[$key]['psort'] = $object2 ? '<span style="color:'.$object2['color'].';">'.$object2['name'].'</span>' : '此分类已被删除';
			}
		}
		View::assign(['All'=>$object]);
		$this->psort(Request::get('sid'));
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Product = new model\Product();
			$object = $Product->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'产品添加成功！') : $this->failed('产品添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		$this->psort();
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Product = new model\Product();
			$object = $Product->one();
			if (!$object) return $this->failed('不存在此产品！');
			if (Request::isPost()){
				if (Config::get('app.demo')) if (in_array(Request::get('id'),[1,2,3,4,5])) return $this->failed('演示站，id为1、2、3、4、5的产品无法修改！');
				$object = $Product->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'产品修改成功！') : $this->failed($object);
			}
			$this->psort($object['sid']);
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function selected(){
		if (Request::get('id')){
			$Product = new model\Product();
			if (!$Product->one()) return $this->failed('不存在此产品！');
			if (!$Product->selected()) return $this->failed('设置默认产品失败！');
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function sort(){
		if (Request::isPost()){
			$Product = new model\Product();
			foreach (Request::post('sort') as $key=>$value){
				if (!is_numeric($value)) continue;
				$Product->sort($key,$value);
			}
			return $this->success(Config::get('app.prev_url'),'产品排序成功！');
		}
		return '';
	}
	 
	public function viewed(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，无法设置显示状态！');
			$Product = new model\Product();
			$object = $Product->one();
			if (!$object) return $this->failed('不存在此产品！');
			if ($object['view'] == 0){
				if (!$Product->view(1)) return $this->failed('设置产品前台显示失败！');
			}else{
				if (!$Product->view(0)) return $this->failed('取消产品前台显示失败！');
			}
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法删除！');
			$Product = new model\Product();
			if (!$Product->one()) return $this->failed('不存在此产品！');
			if (Request::isPost()) return $Product->remove() ? $this->success(Request::post('prev'),'产品删除成功！') : $this->failed('产品删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	private function psort($id=0){
		$html = '';
		$Psort = new model\Psort();
		foreach ($Psort->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').' style="color:'.$value['color'].';">'.$value['name'].'</option>';
		}
		View::assign(['Sort'=>$html]);
	}
}