<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use app\admin\validate\Logistics as valid;

class Logistics extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,code,name')
						->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])
						->order(['code'=>'ASC'])
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
			return $this->field('id,name,code')->order(['code'=>'ASC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('name,code')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'name'=>Request::post('name'),
			'code'=>Request::post('code')
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat()) return '此物流已存在！';
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}
	
	//批量添加
	public function multi(){
		$validate = new valid();
		foreach (explode("\r\n",Request::post('multi')) as $key=>$value){
			$value = explode('|',$value);
			if (count($value) != 2) return '批量添加格式有误！';
			$data = [
				'id'=>'',
				'name'=>$value[0],
				'code'=>$value[1]
			];
			if ($validate->check($data)){
				if ($this->repeat(false,$value[0],$value[1])) return '“'.$value[0].'”物流已存在！';
				$this->insertGetId($data);
			}else{
				return $validate->getError();
			}
		}
		return 1;
	}
	
	//修改
	public function modify(){
		$data = [
			'name'=>Request::post('name'),
			'code'=>Request::post('code')
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat(true)) return '此物流已存在！';
			return $this->where(['id'=>Request::get('id')])->update($data);
		}else{
			return $validate->getError();
		}
	}
	
	//删除
	public function remove(){
		try {
			$affected_rows = $this->where(['id'=>Request::get('id')])->delete();
			if ($affected_rows) $this->execute('OPTIMIZE TABLE `'.$this->getTable().'`');
			return $affected_rows;
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//验证重复
	private function repeat($update=false,$name='',$code=''){
		try {
			$map['where'] = '(`name`=:name OR `code`=:code)';
			$map['value'] = ['name'=>$name ? $name : Request::post('name'),'code'=>$code ? $code : Request::post('code')];
			$object = $this->field('id')->where($map['where'],$map['value']);
			return $update ? $object->where('id','<>',Request::get('id'))->find() : $object->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map(){
		return [
			'field'=>'name|code',
			'condition'=>'LIKE',
			'value'=>'%'.Request::get('keyword').'%'
		];
	}
}