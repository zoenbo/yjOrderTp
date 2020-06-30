<?php
namespace app\admin\model;

use Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\Model;

class LoginRecord extends Model{
	//查询总记录
	public function total($type=0){
		return $this->where($this->map($type)['where'],$this->map($type)['value'])->count();
	}
	
	//查询所有
	public function all($firstRow,$type=0){
		try {
			return $this->field('manager_id,ip,date')
						->where($this->map($type)['where'],$this->map($type)['value'])
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
			return $this->field('manager_id,ip,date')->order(['date'=>'DESC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add($manager_id){
		$data = [
			'manager_id'=>$manager_id,
			'ip'=>getUserIp(),
			'date'=>time()
		];
		return $this->insertGetId($data);
	}
	
	//清空表
	public function truncate(){
		try {
			return Db::execute('TRUNCATE `'.$this->getTable().'`');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map($type){
		$map['where'] = '`ip` LIKE :keyword';
		$map['value']['keyword'] = '%'.Request::get('keyword').'%';
		if ($type){
			$session = Session::get(Config::get('system.session_key'));
			$map['where'] .= ' AND `manager_id`=:manager_id';
			$map['value']['manager_id'] = $session['id'];
		}else{
			if (Request::get('manager_id')){
				$map['where'] .= ' AND `manager_id`=:manager_id';
				$map['value']['manager_id'] = Request::get('manager_id');
			}
		}
		return $map;
	}
}