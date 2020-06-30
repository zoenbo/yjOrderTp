<?php
namespace app\admin\model;

use app\admin\validate\Smtp as valid;
use Exception;
use think\facade\Db;
use think\facade\Config;
use think\facade\Request;
use think\Model;

class Smtp extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,smtp,port,email,user')
						->where($this->map()['field'],$this->map()['condition'],$this->map()['value'])
						->order(['id'=>'DESC'])
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
			return $this->field('smtp,port,email,user')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询运行中的服务器
	public function one2(){
		try {
			$firstRow = date('H') % $this->total();
			return $this->field('smtp,port,email,user,pass')->order(['id'=>'DESC'])->limit($firstRow,1)->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询运行中的服务器
	public function one3($hour){
		try {
			$firstRow = $hour % $this->total();
			return $this->field('id,smtp,port,email,user')->order(['id'=>'DESC'])->limit($firstRow,1)->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'smtp'=>Request::post('smtp'),
			'port'=>Request::post('port'),
			'email'=>Request::post('email'),
			'user'=>Request::post('user'),
			'pass'=>Request::post('pass')
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
			'smtp'=>Request::post('smtp'),
			'port'=>Request::post('port'),
			'email'=>Request::post('email'),
			'user'=>Request::post('user')
		];
		if (Request::post('pass')) $data['pass'] = Request::post('pass');
		$validate = new valid();
		if ($validate->remove('pass',['require'])->check($data)){
			return $this->where(['id'=>Request::get('id')])->update($data);
		}else{
			return $validate->getError();
		}
	}
	
	//删除
	public function remove(){
		try {
			$affected_rows = $this->where(['id'=>Request::get('id')])->delete();
			if ($affected_rows) Db::execute('OPTIMIZE TABLE `'.$this->getTable().'`');
			return $affected_rows;
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map(){
		return [
			'field'=>'smtp|port|email|user',
			'condition'=>'LIKE',
			'value'=>'%'.Request::get('keyword').'%'
		];
	}
}