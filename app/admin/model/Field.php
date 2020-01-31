<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;

class Field extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow=0){
		try {
			return $this->field('id,name,selected')
						->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])
						->order(['id'=>'ASC'])
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
			return $this->field('id,name,selected')->order(['id'=>'ASC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询所有（默认字段）
	public function all3(){
		try {
			return $this->field('id')->where(['selected'=>1])->order(['id'=>'ASC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('selected')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//设置和取消默认
	public function selected($selected){
		return $this->where(['id'=>Request::get('id')])->update(['selected'=>$selected]);
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