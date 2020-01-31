<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Dbbak extends Base{
	private $linkid;
	private $sqlid;
	private $record;
	
	public function index(){
		if (Request::isPost()){
			if (Config::get('app.demo')) return $this->failed('演示站，无法备份！');
			return $this->bak('data',date('YmdHis'),Request::post('filesize'),Request::post('tablename') ? Request::post('tablename') : []);
		}
		$Common = new model\Common();
		$object = $Common->info();
		$remainder = count($object) % 4;
		if ($remainder != 0){
			for ($i=0;$i<4-$remainder;$i++){
				$object[]['Name'] = '';
			}
		}
		View::assign(['All'=>$object]);
		return $this->view();
	}

	private function query($sql){
		if (!!$this->sqlid = mysqli_query($this->linkid,$sql)){
			return mysqli_query($this->linkid,$sql);
		}else{
			return $this->failed('SQL语句：'.$sql.'<br>错误信息：'.mysqli_error($this->linkid),0,2);
		}
	}

	private function numFields($sql_id=''){
		if (!$sql_id) $sql_id = $this->sqlid;
		return $sql_id ? mysqli_num_fields($sql_id) : false;
	}

	private function nextRecord($sql_id=''){
		if (!$sql_id) $sql_id = $this->sqlid;
		return (!!$this->record = mysqli_fetch_array($sql_id)) ? $this->record : false;
	}

	private function f($name){
		return $this->record[$name] ? $this->record[$name] : false;
	}

	private function getInfo($table){
		$this->query('SHOW CREATE TABLE '.$table);
		$this->nextRecord();
		return "\r\n".str_replace("\n","\r\n",$this->f('Create Table')).";\r\n";
	}

	private function getRecord($table,$num_fields){
		$comma = '';
		$sql = "INSERT INTO `$table`(`".implode('`,`',array_map('addslashes',array_keys(mysqli_fetch_assoc(mysqli_query($this->linkid,"SELECT * FROM `$table` LIMIT 1")))))."`) VALUES(";
		for ($i=0;$i<$num_fields;$i++){
			$sql .= ($comma."'".addslashes($this->record[$i])."'");
			$comma = ',';
		}
		$sql .= ");\r\n";
		return $sql;
	}
	
	private function write($sql,$filename){
		if (!$fp = fopen($filename,'w+')) return $this->failed('文件打开失败！');
		if (!fwrite($fp,$sql)) return $this->failed('文件写入失败！');
		if (!fclose($fp)) return $this->failed('文件关闭失败！');
		return true;
	}
	
	//备份全部表（不分卷）
	private function all($path='',$filename='',$tip=1,$tablestatus=1){
		if (!$tablesInfo = $this->query('SHOW TABLE STATUS FROM `'.Config::get('database.connections.mysql.database')."` LIKE '".Config::get('database.connections.mysql.prefix')."%'")) return $this->failed('读数据库结构错误！');
		$sql = "SET NAMES UTF8;\r\n";
		while ($this->nextRecord($tablesInfo)){
			$table = $this->f('Name');
			if ($tablestatus) $sql .= $this->getInfo($table);
			$this->query("SELECT * FROM $table");
			$num_fields = $this->numFields();
			while ($this->nextRecord()){
				$sql .= $this->getRecord($table,$num_fields);
			}
		}
		$sql = substr($sql,0,-2);
		$filename .= '_all.sql';
		if ($this->write($sql,ROOT_PATH.'/'.$path.'/'.$filename) && $tip==1) return $this->success(NULL,'全部数据表备份成功，生成备份文件：./'.$path.'/'.$filename.'。',0,2);
		return '';
	}
	
	//备份全部表（分卷）
	private function allPart($path='',$filename='',$filesize=2000,$tip=1,$tablestatus=1){
		if (!$tablesInfo = $this->query('SHOW TABLE STATUS FROM `'.Config::get('database.connections.mysql.database')."` LIKE '".Config::get('database.connections.mysql.prefix')."%'")) return $this->failed('读数据库结构错误！');
		$p = 1;
		$sql = "SET NAMES UTF8;\r\n";
		while ($this->nextRecord($tablesInfo)){
			$table = $this->f('Name');
			if ($tablestatus) $sql .= $this->getInfo($table);
			//exit($sql);
			$this->query("SELECT * FROM $table");
			$num_fields = $this->numFields();
			while ($this->nextRecord()){
				$sql .= $this->getRecord($table,$num_fields);
				if (strlen($sql) >= $filesize*1024){
					$sql = substr($sql,0,-2);
					$filename2 = $filename.'_all_part'.$p.'.sql';
					if ($this->write($sql,$path.'/'.$filename2)){
						$info[] = $filename2;
					}else{
						$info[] = '备份'.$filename2.'失败';
					}
					$p++;
					$sql = '';
				}
			}
		}
		$info = [];
		if ($sql != ''){
			$sql = substr($sql,0,-2);
			$filename .= '_all_part'.$p.'.sql';
			if ($this->write($sql,ROOT_PATH.'/'.$path.'/'.$filename)) $info[] = $filename;
		}
		if ($tip==1) return $this->success(NULL,'全部数据表备份成功，已保存到./'.$path.'目录，生成备份文件：<br>'.implode('<br>',$info),0,2);
		return '';
	}
	
	//备份自定义多表（不分卷）
	private function n($path='',$filename='',$tables=[],$tip=1,$tablestatus=1){
		$sql = "SET NAMES UTF8;\r\n";
		foreach ($tables as $value){
			if ($tablestatus) $sql .= $this->getInfo($value);
			$this->query('SELECT * FROM '.$value);
			$num_fields = $this->numFields();
			while ($this->nextRecord()){
				$sql .= $this->getRecord($value,$num_fields);
			}
		}
		$sql = substr($sql,0,-2);
		$filename .= '_n.sql';
		if ($this->write($sql,ROOT_PATH.'/'.$path.'/'.$filename) && $tip==1) return $this->success(NULL,'数据表备份成功，已保存到./'.$path.'目录，生成备份文件：'.$filename,0,2);
		return '';
	}
	
	//备份自定义多表（分卷）
	private function nPart($path='',$filename='',$filesize=2000,$tables=[],$tip=1,$tablestatus=1){
		$p = 1;
		$sql = "SET NAMES UTF8;\r\n";
		foreach ($tables as $value){
			if ($tablestatus) $sql .= $this->getInfo($value);
			$this->query('SELECT * FROM '.$value);
			$num_fields = $this->numFields();
			while ($this->nextRecord()){
				$sql .= $this->getRecord($value,$num_fields);
				if (strlen($sql) >= $filesize*1024){
					$sql = substr($sql,0,-2);
					$filename2 = $filename.'_n_part'.$p.'.sql';
					if ($this->write($sql,$path.'/'.$filename2)){
						$info[] = $filename2;
					}else{
						$info[] = '备份表-'.$value.'-失败';
					}
					$p++;
					$sql = '';
				}
			}
		}
		$info = [];
		if ($sql != ''){
			$sql = substr($sql,0,-2);
			$filename .= '_n_part'.$p.'.sql';
			if ($this->write($sql,ROOT_PATH.'/'.$path.'/'.$filename)) $info[] = $filename;
		}
		if ($tip==1) return $this->success(NULL,'数据表备份成功，已保存到./'.$path.'目录，生成备份文件：<br>'.implode('<br>',$info),0,2);
		return '';
	}
	
	public function bak($path='',$filename='',$filesize=2000,$tables=[],$tip=1,$tablestatus=1){
		if (empty($path)) return $this->failed('请设置保存数据库文件的目录！');
		if (!is_dir($path)) return $this->failed($path.'目录不存在，请手工创建！');
		if (empty($filename)) return $this->failed('请设置数据库文件名！');
		if (!is_numeric($filesize)) return $this->failed('分卷大小必须是数字！');
		if (!is_array($tables)) return $this->failed('数据表必须是数组！');
		$path = str_replace('\\','/',$path);
		if (!$this->linkid = mysqli_connect(Config::get('database.connections.mysql.hostname').(Config::get('database.connections.mysql.hostport') ? ':'.Config::get('database.connections.mysql.hostport') : ''),Config::get('database.connections.mysql.username'),Config::get('database.connections.mysql.password'))) return $this->failed('连接服务器失败');
		if (!mysqli_select_db($this->linkid,Config::get('database.connections.mysql.database'))) return $this->failed('无法打开数据库：'.mysqli_error($this->linkid));
		if (!mysqli_query($this->linkid,'SET NAMES '.Config::get('database.connections.mysql.charset'))) return $this->failed('字符集设置错误');

		set_time_limit(0);
		if (count($tables) == 0){
			if (empty($filesize)){
				return $this->all($path,$filename,$tip,$tablestatus);
			}else{
				return $this->allPart($path,$filename,$filesize,$tip,$tablestatus);
			}
		}elseif(empty($filesize)) {
			return $this->n($path, $filename, $tables, $tip, $tablestatus);
		}else{
			return $this->nPart($path,$filename,$filesize,$tables,$tip,$tablestatus);
		}
	}
}