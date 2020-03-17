<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use app\admin\validate\Template as valid;

class Template extends Model{
	private $tableName = 'Template';

	//查询总记录
	public function total(){
		return $this->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,name,manager_id,template,template_style_id,order_state_id,is_show_search,is_show_send,is_captcha,is_qq,is_default,date')
						->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])
						->order(['date'=>'DESC'])
						->limit($firstRow,Config::get('app.page_size'))
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询所有（不分页）
	public function all2(){
		try {
			return $this->field('id,name,is_default')->order(['date'=>'DESC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('name,manager_id,template,template_style_id,product,field,pay,order_state_id,is_show_search,is_show_send,is_captcha,is_qq,success,success2,often,is_default')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'name'=>Request::post('name'),
			'manager_id'=>Request::post('manager_id'),
			'template'=>Request::post('template'),
			'template_style_id'=>Request::post('template')==1 ? 0 : Request::post('template_style_id'),
			'field'=>Request::post('field') ? implode(',',Request::post('field')) : '',
			'pay'=>Request::post('pay') ? Request::post('selectedPay').'|'.implode(',',Request::post('pay')) : Request::post('selectedPay'),
			'order_state_id'=>Request::post('order_state_id'),
			'is_show_search'=>Request::post('is_show_search'),
			'is_show_send'=>Request::post('template')==1 ? 0 : Request::post('is_show_send'),
			'is_captcha'=>Request::post('is_captcha'),
			'is_qq'=>Request::post('is_qq'),
			'success'=>Request::post('success',NULL,'stripslashes'),
			'success2'=>Request::post('success2',NULL,'stripslashes'),
			'often'=>Request::post('often',NULL,'stripslashes'),
			'date'=>time()
		];
		if (Request::post('protype') == 0){
			if (!is_array(Request::post('pid1'))) return '请至少选择一个产品！';
			$data['product'] = '0|'.Request::post('sort1').'|'.implode(',',Request::post('pid1')).'|'.Request::post('selected1').'|'.Request::post('viewtype');
		}elseif (Request::post('protype') == 1){
			if (!is_array(Request::post('pid2'))) return '请至少选择一个产品！';
			$data['product'] = '1|'.Request::post('sort2').'|'.implode(',',Request::post('pid2')).'|'.Request::post('selected2').'|'.Request::post('viewtype');
		}
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat()) return '此模板名已存在！';
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}
	
	//修改
	public function modify(){
		$data = [
			'name'=>Request::post('name'),
			'manager_id'=>Request::post('manager_id'),
			'template'=>Request::post('template'),
			'template_style_id'=>Request::post('template')==1 ? 0 : Request::post('template_style_id'),
			'field'=>Request::post('field') ? implode(',',Request::post('field')) : '',
			'pay'=>Request::post('pay') ? Request::post('selectedPay').'|'.implode(',',Request::post('pay')) : Request::post('selectedPay'),
			'order_state_id'=>Request::post('order_state_id'),
			'is_show_search'=>Request::post('is_show_search'),
			'is_show_send'=>Request::post('template')==1 ? 0 : Request::post('is_show_send'),
			'is_captcha'=>Request::post('is_captcha'),
			'is_qq'=>Request::post('is_qq'),
			'success'=>Request::post('success',NULL,'stripslashes'),
			'success2'=>Request::post('success2',NULL,'stripslashes'),
			'often'=>Request::post('often',NULL,'stripslashes')
		];
		if (Request::post('protype') == 0){
			if (!is_array(Request::post('pid1'))) return '请至少选择一个产品！';
			$data['product'] = '0|'.Request::post('sort1').'|'.implode(',',Request::post('pid1')).'|'.Request::post('selected1').'|'.Request::post('viewtype');
		}elseif (Request::post('protype') == 1){
			if (!is_array(Request::post('pid2'))) return '请至少选择一个产品！';
			$data['product'] = '1|'.Request::post('sort2').'|'.implode(',',Request::post('pid2')).'|'.Request::post('selected2').'|'.Request::post('viewtype');
		}
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat(true)) return '此模板名已存在！';
			return $this->where(['id'=>Request::get('id')])->update($data);
		}else{
			return $validate->getError();
		}
	}

	//设置默认
	public function isDefault(){
		$this->where(['is_default'=>1])->update(['is_default'=>0]);
		return $this->where(['id'=>Request::get('id')])->update(['is_default'=>1]);
	}

	//删除
	public function remove(){
		try {
			$affected_rows = $this->where(['id'=>Request::get('id')])->delete();
			if ($affected_rows) $this->execute('OPTIMIZE TABLE `'.Config::get('database.connections.mysql.prefix').strtolower($this->tableName).'`');
			return $affected_rows;
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//验证重复
	private function repeat($update=false){
		try {
			$object = $this->field('id')->where(['name'=>Request::post('name')]);
			return $update ? $object->where('id','<>',Request::get('id'))->find() : $object->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//搜索
	private function map(){
		return [
			'field'=>'name',
			'condition'=>'LIKE',
			'value'=>'%'.Request::get('keyword').'%'
		];
	}
}