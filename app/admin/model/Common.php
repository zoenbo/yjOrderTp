<?php
namespace app\admin\model;

use Exception;
use think\facade\Config;
use think\facade\Db;
use think\Model;

class Common extends Model{
	//数据表信息
	public function info(){
		try {
			return Db::query('SHOW TABLE STATUS FROM `'.Config::get('database.connections.mysql.database').'` LIKE \''.Config::get('database.connections.mysql.prefix').'%\'');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//优化数据表
	public function optimizeTable($table){
		try {
			return Db::execute('OPTIMIZE TABLE `'.$table.'`');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	 
	//修复Autoindex
	public function repairAutoindex($table){
		try {
			return Db::execute('ALTER TABLE `'.$table.'` AUTO_INCREMENT=1');
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}