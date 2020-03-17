<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use app\admin\validate\District as valid;

class District extends Model{
	private $tableName = 'District';
	
	//查询总记录
	public function total(){
		return $this->where($this->map()['where'],$this->map()['value'])->count();

	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,name')
						->where($this->map()['where'],$this->map()['value'])
						->order(['id'=>'ASC'])
						->limit($firstRow,Config::get('app.page_size'))
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('name,parent_id')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	public function one2($parent_id){
		try {
			$map['parent_id'] = $parent_id;
			return $this->field('id')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'name'=>Request::post('name'),
			'parent_id'=>Request::get('parent_id')
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat(Request::get('parent_id'))) return '此行政区划已存在！';
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}
	
	//修改
	public function modify($parent_id=0){
		$data = [
			'name'=>Request::post('name')
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat($parent_id,true)) return '此行政区划已存在！';
			return $this->where(['id'=>Request::get('id')])->update($data);
		}else{
			return $validate->getError();
		}
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
	private function repeat($parent_id=0,$update=false){
		try {
			$object = $this->field('id')->where(['name'=>Request::post('name'),'parent_id'=>$parent_id]);
			return $update ? $object->where('id','<>',Request::get('id'))->find() : $object->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map(){
		$map['where'] = '`name` LIKE :name AND `parent_id`=:parent_id';
		$map['value'] = ['name'=>'%'.Request::get('keyword').'%','parent_id'=>Request::get('parent_id',0)];
		return $map;
	}
}