<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Config;

class Common extends Model{
	//数据表信息
	public function info(){
		try {
			return $this->query('SHOW TABLE STATUS FROM `'.Config::get('database.connections.mysql.database')."` LIKE '".Config::get('database.connections.mysql.prefix')."%'");
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//优化数据表
	public function optimizeTable($table){
		try {
			return $this->execute('OPTIMIZE TABLE `'.$table.'`');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	 
	//修复Autoindex
	public function repairAutoindex($table){
		try {
			return $this->execute('ALTER TABLE `'.$table.'` AUTO_INCREMENT=1');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}