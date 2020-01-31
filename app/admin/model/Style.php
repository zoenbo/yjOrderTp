<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use app\admin\validate\Style as valid;

class Style extends Model{
	private $tableName = 'Style';

	//查询总记录
	public function total(){
		return $this->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,bgcolor,bordercolor,buttoncolor,date')
						->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])
						->order(['date'=>'DESC','id'=>'DESC'])
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
			return $this->field('id')->order(['id'=>'ASC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('bgcolor,bordercolor,buttoncolor')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'bgcolor'=>Request::post('bgcolor'),
			'bordercolor'=>Request::post('bordercolor'),
			'buttoncolor'=>Request::post('buttoncolor'),
			'date'=>time()
		];
		$validate = new valid();
		if ($validate->check($data)){
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}
	
	//修改
	public function modify(){
		$data = [
			'bgcolor'=>Request::post('bgcolor'),
			'bordercolor'=>Request::post('bordercolor'),
			'buttoncolor'=>Request::post('buttoncolor')
		];
		$validate = new valid();
		if ($validate->check($data)){
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
	
	//搜索
	private function map(){
		return [
			'field'=>'bgcolor|bordercolor|buttoncolor',
			'condition'=>'LIKE',
			'value'=>'%'.Request::get('keyword').'%'
		];
	}
}