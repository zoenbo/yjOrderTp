<?php
namespace app\admin\controller;

use app\admin\model;
use think\facade\Config;
use think\facade\Request;
use think\facade\Route;
use think\facade\View;

class Manager extends Base{
	private $level = [1=>['red','超级管理员'],2=>['green','普通管理员']];
	private $is_activation = [['green','否'],['red','是']];
	private $order_permit = [0=>['',''],1=>['green','自己订单'],2=>['blue','自己订单 + 前台订单'],3=>['red','所有订单']];
	private $qq = [['green','否'],['red','是']];

	public function index(){
		$Manager = new model\Manager();
		$object = $Manager->all($this->page($Manager->total()));
		if ($object){
			$PermitGroup = new model\PermitGroup();
			foreach ($object as $key=>$value){
				$object[$key]['level_name'] = '<span class="'.$this->level[$value['level']][0].'">'.$this->level[$value['level']][1].'</span>';
				$object[$key]['order_permit'] = $value['level']==1 ? '-' : '<span class="'.$this->order_permit[$value['order_permit']][0].'">'.$this->order_permit[$value['order_permit']][1].'</span>';
				$object2 = $PermitGroup->one($value['permit_group_id']);
				$object[$key]['group'] = $object2 ? $object2['name'] : '此权限组已被删除';
			}
		}
		View::assign(['All'=>$object]);
		$this->permitGroup(Request::get('permit_group_id'));
		$this->level1(Request::get('level'));
		$this->isActivation1(Request::get('is_activation',-1));
		$this->orderPermit1(Request::get('order_permit'));
		$this->qq1(Request::get('qq',-1));
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Manager = new model\Manager();
			$object = $Manager->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'管理员添加成功！') : $this->failed('管理员添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		$this->permitGroup(0,1);
		$this->level2(2);
		$this->isActivation2(1);
		$this->orderPermit2(1);
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Manager = new model\Manager();
			$object = $Manager->one();
			if (!$object) return $this->failed('不存在此管理员！');
			if (Request::isPost()){
				if (Config::get('app.demo') && Request::get('id')==1) return $this->failed('演示站，id为1的管理员无法修改！');
				$object = $Manager->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'管理员修改成功！') : $this->failed($object);
			}
			$this->permitGroup($object['permit_group_id'],1);
			$this->level2($object['level']);
			$this->isActivation2($object['is_activation']);
			$this->orderPermit2($object['order_permit']);
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function isActivation(){
		if (Request::get('id')){
			$Manager = new model\Manager();
			$object = $Manager->one();
			if (!$object) return $this->failed('不存在此管理员！');
			if (Request::get('id') == 1) return $this->failed('无法激活创始人！');
			if ($object['is_activation'] == 0){
				if (!$Manager->isActivation(1)) return $this->failed('管理员激活失败！');
			}else{
				if (!$Manager->isActivation(0)) return $this->failed('管理员取消激活失败！');
			}
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function qq(){
		if (Request::get('id')){
			$Manager = new model\Manager();
			$object = $Manager->one();
			if (!$object) return $this->failed('不存在此管理员！');
			if (!$Manager->qq('')) return $this->failed('管理员QQ解除绑定失败！');
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}

	public function delete(){
		if (Request::get('id')){
			if (Request::get('id') == 1) return $this->failed('无法删除创始人！');
			$Manager = new model\Manager();
			$object = $Manager->one();
			if (!$object) return $this->failed('不存在此管理员！');
			if (Request::isPost()) return $Manager->remove() ? $this->success(Request::post('prev'),'管理员删除成功！') : $this->failed('管理员删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}

	private function permitGroup($id=0,$flag=0){
		$html = '';
		$PermitGroup = new model\PermitGroup();
		foreach ($PermitGroup->all2() as $value){
			if ($id == 0){
				$html .= '<option value="'.$value['id'].'" '.($value['is_default']&&$flag ? 'selected' : '').'>'.$value['name'].'</option>';
			}else{
				$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
			}
		}
		View::assign(['PermitGroup'=>$html]);
	}

	private function level1($id=0){
		$html = '';
		foreach ($this->level as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').' class="'.$value[0].'">'.$value[1].'</option>';
		}
		View::assign(['Level'=>$html]);
	}

	private function level2($id=0){
		$html = '';
		foreach ($this->level as $key=>$value){
			$html .= '<div class="radio-box"><label class="'.$value[0].'"><input type="radio" name="level" value="'.$key.'" '.($key==$id ? 'checked' : '').'>'.$value[1].'</label></div>';
		}
		View::assign(['Level'=>$html]);
	}

	private function isActivation1($id=0){
		$html = '';
		foreach ($this->is_activation as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').' class="'.$value[0].'">'.$value[1].'</option>';
		}
		View::assign(['Activation'=>$html]);
	}

	private function isActivation2($id=0){
		$html = '<div class="radio-box"><label class="red"><input type="radio" name="is_activation" value="1" '.($id==1 ? 'checked' : '').'>是</label></div><div class="radio-box"><label class="green"><input type="radio" name="is_activation" value="0" '.($id==0 ? 'checked' : '').'>否</label></div>';
		View::assign(['Activation'=>$html]);
	}

	private function orderPermit1($id=0){
		$html = '';
		foreach ($this->order_permit as $key=>$value){
			if ($key) $html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').' class="'.$value[0].'">'.$value[1].'</option>';
		}
		View::assign(['OrderPermit'=>$html]);
	}

	private function orderPermit2($id=0){
		$html = '';
		foreach ($this->order_permit as $key=>$value){
			if ($key) $html .= '<div class="radio-box"><label class="'.$value[0].'"><input type="radio" name="order_permit" value="'.$key.'" '.($key==$id ? 'checked' : '').'>'.$value[1].'</label></div>';
		}
		View::assign(['OrderPermit'=>$html]);
	}

	private function qq1($id=0){
		$html = '';
		foreach ($this->qq as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').' class="'.$value[0].'">'.$value[1].'</option>';
		}
		View::assign(['Qq'=>$html]);
	}
}