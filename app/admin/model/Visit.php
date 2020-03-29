<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use think\facade\Session;

class Visit extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['where'],$this->map()['value'])->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('ip,url,count,date1,date2')
						->where($this->map()['where'],$this->map()['value'])
						->order(['date2'=>'DESC'])
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
			return $this->field('ip,url,count,date1,date2')->order(['date2'=>'DESC'])->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//清空表
	public function truncate(){
		try {
			return $this->execute('TRUNCATE `'.$this->getTable().'`');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map(){
		$map['where'] = '(`ip` LIKE :ip OR `url` LIKE :url)';
		$map['value'] = ['ip'=>'%'.Request::get('keyword').'%','url'=>'%'.Request::get('keyword').'%'];
		return $map;
	}
}