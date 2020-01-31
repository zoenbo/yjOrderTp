<?php
namespace app\home\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;

class Visit extends Model{
	private $tableName = 'Visit';

	//查询所有（不分页）
	public function all(){
		try {
			return $this->field('ip,url,count,date1,date2')
						->order(['date2'=>'DESC'])
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询昨天是否有记录
	public function yesterday(){
		try {
			return $this->field('id')
						->where('date1','<',strtotime(date('Y-m-d').' 00:00:00'))
						->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one(){
		try {
			return $this->field('id')
						->where(['ip'=>get_userip(),'url'=>Request::post('url',NULL,'stripslashes')])
						->where('date1','>=',strtotime(date('Y-m-d').' 00:00:00'))
						->where('date2','<=',strtotime(date('Y-m-d').' 23:59:59'))
						->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'ip'=>get_userip(),
			'url'=>Request::post('url',NULL,'stripslashes'),
			'count'=>1,
			'date1'=>time(),
			'date2'=>time()
		];
		return $this->insertGetId($data);
	}
	
	//修改
	public function modify($id){
		$this->where(['id'=>$id])->inc('count')->update();
		return $this->where(['id'=>$id])->update(['date2'=>time()]);
	}
	
	//清空表
	public function truncate(){
		try {
			return $this->execute('TRUNCATE `'.Config::get('database.connections.mysql.prefix').strtolower($this->tableName).'`');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}