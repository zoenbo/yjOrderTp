<?php
namespace app\admin\controller;

use app\admin\model;
use think\facade\Config;
use think\facade\Request;
use think\facade\Route;
use think\facade\View;

class Template extends Base{
	private $template = ['电脑版（新版）','电脑版（经典版）','手机版1','手机版2','手机版3','手机版4'];
	
	public function index(){
		$Template = new model\Template();
		$object = $Template->all($this->page($Template->total()));
		if ($object){
			$Manager = new model\Manager();
			$Ostate = new model\Ostate();
			foreach ($object as $key=>$value){
				if ($value['uid']){
					$object2 = $Manager->one($value['uid']);
					$object[$key]['admin'] = $object2 ? $object2['name'] : '此管理员已被删除';
				}else{
					$object[$key]['admin'] = '不指定';
				}
				$object[$key]['template'] = $this->template[$value['template']];
				$object3 = $Ostate->one($value['state']);
				$object[$key]['state'] = $object3 ? '<span style="color:'.$object3['color'].';">'.$object3['name'].'</span>' : '此状态已被删除';
				$object[$key]['captcha'] = $value['cid'] ? '添加' : '不添加';
			}
		}
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	public function add(){
		if (Request::isPost()){
			$Template = new model\Template();
			$object = $Template->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'模板添加成功！') : $this->failed('模板添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		$this->template();
		$this->manager();
		$this->style();
		$this->sort();
		$this->product();
		$this->field();
		$this->pay();
		$this->ostate();
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Template = new model\Template();
			$object = $Template->one();
			if (!$object) return $this->failed('不存在此模板！');
			if (Request::isPost()){
				if (Config::get('app.demo') && Request::get('id')<=6) return $this->failed('演示站，id<=6的模板无法修改！');
				$object = $Template->modify();
				return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'模板修改成功！') : $this->failed($object);
			}
			$this->template($object['template']);
			$this->manager($object['uid']);
			$this->style($object['sid']);

			$product = explode('|',$object['product']);
			$this->sort($product[1] ?? 0);
			$this->product($product[0]==0 ? 0 : $product[2]);
			$object['protype'] = $product[0];
			$object['pro'] = $product[2] ?? '';
			$object['proselected'] = $product[3] ?? '';
			$object['viewtype'] = $product[4] ?? 1;

			$this->field($object['field']);
			$this->pay($object['pay']);
			$this->ostate($object['state']);
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function code(){
		if (Request::get('id')){
			$Template = new model\Template();
			$object = $Template->one();
			if (!$object) return $this->failed('不存在此模板！');
			View::assign(['One'=>$object]);
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}

	public function order(){
		echo (new \app\common\controller\Template())->html(Request::get('id'),1);
	}
	
	public function delete(){
		if (Request::get('id')){
			if (Config::get('app.demo') && Request::get('id')<=6) return $this->failed('演示站，id<=6的模板无法删除！');
			$Template = new model\Template();
			if (!$Template->one()) return $this->failed('不存在此模板！');
			if (Request::isPost()) return $Template->remove() ? $this->success(Request::post('prev'),'模板删除成功！') : $this->failed('模板删除失败！');
			return $this->confirm('您真的要删除这条数据么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function ajaxProduct(){
		if (Request::isAjax()){
			$Product = new model\Product();
			echo json_encode($Product->all2(Request::post('sid')));
		}
	}

	public function selected(){
		if (Request::get('id')){
			$Template = new model\Template();
			if (!$Template->one()) return $this->failed('不存在此模板！');
			if (!$Template->selected()) return $this->failed('设置默认模板失败！');
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}

	private function template($id=0){
		$html = '';
		foreach ($this->template as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').' view="'.Route::buildUrl('/'.parse_name(Request::controller()).'/order',['id'=>$key]).'">'.$value.'</option>';
		}
		View::assign(['Template'=>$html]);
	}
	
	private function manager($id=0){
		$html = '';
		$Manager = new model\Manager();
		foreach ($Manager->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
		}
		View::assign(['Manager'=>$html]);
	}
	
	private function style($id=0){
		$html = '';
		$Style = new model\Style();
		foreach ($Style->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['id'].'号样式</option>';
		}
		View::assign(['Style'=>$html]);
	}
	
	private function sort($id=0){
		$html = '';
		$Psort = new model\Psort();
		foreach ($Psort->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').' style="color:'.$value['color'].';">'.$value['name'].'</option>';
		}
		View::assign(['Sort'=>$html]);
	}
	
	private function product($ids=''){
		$html = '';
		$Psort = new model\Psort();
		$object = $Psort->all2();
		if ($object){
			$Product = new model\Product();
			foreach ($object as $value){
				$html .= '<optgroup label="'.$value['name'].'" style="color:'.$value['color'].';" value="'.$value['id'].'">';
				$object2 = $Product->all2($value['id']);
				if ($object2){
					foreach ($object2 as $v){
						$html .= '<option value="'.$v['id'].'" '.(in_array($v['id'],explode(',',$ids)) ? 'selected' : '').' style="color:'.($v['color'] ? $v['color'] : '#000').';">└—'.$v['name'].'（'.$v['price'].'元）</option>';
					}
				}
				$html .= '</optgroup>';
			}
		}
		View::assign(['Product'=>$html]);
	}
	
	private function field($ids=[]){
		$html = '';
		$Field = new model\Field();
		$selected = arrToStr($Field->all3(),'id');
		$ids = is_array($ids) ? $selected : $ids;
		foreach ($Field->all2() as $value){
			$html .= '<div class="check-box"><label'.(in_array($value['id'],explode(',',$selected)) ? ' class="red"' : '').'><input type="checkbox" name="field[]" '.(in_array($value['id'],explode(',',$ids)) ? 'checked' : '').' value="'.$value['id'].'">'.$value['name'].'</label></div>';
		}
		View::assign(['Field'=>$html]);
	}
	
	private function pay($ids=''){
		$html = $html2 = '';
		$ids = explode('|',$ids);
		$pay = Config::get('app.pay2');
		foreach ($pay as $key=>$value){
			$html .= '<div class="check-box"><label><input type="checkbox" name="pay[]" value="'.$key.'" '.(isset($ids[1]) && in_array($key,explode(',',$ids[1])) ? 'checked' : '').'>'.$value.'</label></div>';

		}
		foreach ($pay as $key=>$value){
			$html2 .= '<option value="'.$key.'" '.(in_array($key,explode(',',$ids[0])) ? 'selected' : '').'>'.$value.'</option>';
		}
		View::assign([
			'Pay'=>$html,
			'Pay2'=>$html2
		]);
	}

	private function ostate($id=0){
		$html = '';
		$Ostate = new model\Ostate();
		foreach ($Ostate->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').' style="color:'.$value['color'].';">'.$value['name'].'</option>';
		}
		View::assign(['Ostate'=>$html]);
	}
}