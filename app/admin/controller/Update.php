<?php
namespace app\admin\controller;

use app\admin\model;
use think\facade\Config;
use think\facade\Request;
use think\facade\Route;
use think\facade\View;

class Update extends Base
{
	protected function initialize(){
		if (file_exists(ROOT_PATH.'/data/install.lock')) $this->error('安装锁定，已经安装过了，如果您确定要进行升级，请到服务器上删除：./data/install.lock。',0,2);
	}
	
	public function index(){
		if (Request::isPost()){
			if (!is_dir(ROOT_PATH.'/bak')) if (!mkdir(ROOT_PATH.'/bak')) return $this->failed('备份目录创建失败，请检查系统根目录权限！');
			if (copy(ROOT_PATH.'/'.Config::get('app.config_path').'/database.php',ROOT_PATH.'/bak/database.php') && copy(ROOT_PATH.'/'.Config::get('app.config_path').'/system.php',ROOT_PATH.'/bak/system.php')){
				return $this->success(NULL,'配置文件备份成功，请删除本系统中<span style="color:red;">除去bak目录之外</span>的所有目录及文件，并上传最新版的程序包。<br>上传完毕后，请将系统根目录下的admin.php重命名为'.Config::get('system.manage_enter').'，然后<a href="'.Route::buildUrl('/'.parse_name(Request::controller()).'/restore').'">点击此处</a>进行还原配置文件。',0,2);
			}else{
				return $this->failed('配置文件备份失败，请检查bak目录权限！');
			}
		}
		$newVersion = explode('|',file_get_contents('https://www.yvjie.cn/1/api.php/version/index.html?id=2'));
		$nowVersion = explode('|',Config::get('app.version'));
		$version = '您当前系统版本为：V'.$nowVersion[0].'（'.$nowVersion[1].'），最新系统版本为：';
		$version .= count($newVersion)==2 ? 'V'.$newVersion[0].'（'.$newVersion[1].'）' : '由于网络原因，未获取到最新版的版本信息，请稍后重试，或登录官网查看';
		View::assign(['Version'=>$version]);
		return $this->view();
	}
	
	public function restore(){
		if (Request::isPost()){
			if (rename(ROOT_PATH.'/bak/database.php',ROOT_PATH.'/'.Config::get('app.config_path').'/database.php') && rename(ROOT_PATH.'/bak/system.php',ROOT_PATH.'/'.Config::get('app.config_path').'/system.php')){
				return $this->success(NULL,'配置文件还原成功，请<a href="'.Route::buildUrl('/'.parse_name(Request::controller()).'/dbbak').'">点击此处</a>进行备份数据库。',0,2);
			}else{
				return $this->failed('配置文件还原失败，请检查'.Config::get('app.config_path').'目录权限！');
			}
		}
		return $this->view();
	}

	public function dbbak(){
		if (Request::isPost()){
			$prefix = Config::get('database.connections.mysql.prefix');
			(new Dbbak())->bak('bak','bak',0,[
				$prefix.'login_record',
				$prefix.'logistics',
				$prefix.'manager',
				$prefix.'order',
				$prefix.'order_state',
				$prefix.'permit_group',
				$prefix.'product',
				$prefix.'product_sort',
				$prefix.'smtp',
				$prefix.'template',
				$prefix.'template_style',
				$prefix.'visit'
			],0,0);
			return $this->success(NULL,'数据库备份成功，请将bak/bak_n.sql文件在您的电脑中备份一份，以防数据没有还原成功，然后<a href="'.Route::buildUrl('/'.parse_name(Request::controller()).'/dbupdate').'">点击此处</a>进行升级数据库。',0,2);
		}
		return $this->view();
	}
	
	public function dbupdate(){
		if (Request::isPost()){
			if (Config::get('app.demo')) return $this->failed('演示站，无法操作升级！');
			if (!is_file(ROOT_PATH.'/data/install.sql')) return $this->failed('data目录中不存在install.sql文件，请检查！');
			if (!is_file(ROOT_PATH.'/data/yjorder_district.sql')) return $this->failed('data目录中不存在yjorder_district.sql文件，请检查！');
			if (!is_file(ROOT_PATH.'/bak/bak_n.sql')) return $this->failed('bak目录中不存在bak_n.sql文件，请检查！');

			$mysql = Config::get('database.connections.mysql');
			if (!$link = mysqli_connect($mysql['hostname'].($mysql['hostport'] ? ':'.$mysql['hostport'] : ''),$mysql['username'],$mysql['password'])) return $this->failed('无法连接数据库！');
			mysqli_select_db($link,$mysql['database']);
			$Common = new model\Common();
			$object = $Common->info();
			if ($object){
				foreach ($object as $value){
					mysqli_query($link,'DROP TABLE IF EXISTS `'.$value['Name'].'`;');
				}
			}
			foreach (explode(';',str_replace('yjorder_',$mysql['prefix'],file_get_contents(ROOT_PATH.'/data/install.sql'))) as $value){
				if ($value && !mysqli_query($link,$value)) return $this->failed('数据库导入失败！',0,2);
			}
			foreach (explode(';',str_replace('yjorder_',$mysql['prefix'],file_get_contents(ROOT_PATH.'/data/yjorder_district.sql'))) as $value){
				if ($value && !mysqli_query($link,$value)) return $this->failed('行政区划数据表导入失败！',0,2);
			}
			mysqli_query($link,'TRUNCATE `'.$mysql['prefix'].'order_state`');
			mysqli_query($link,'TRUNCATE `'.$mysql['prefix'].'template_style`');
			foreach (explode(';',file_get_contents(ROOT_PATH.'/bak/bak_n.sql')) as $value){
				if ($value && !mysqli_query($link,$value)) return $this->failed('数据导入失败！'.mysqli_error($link),0,2);
			}

			if (!file_put_contents(ROOT_PATH.'/data/install.lock',' ')) return $this->failed('安装锁定写入失败，请检查data目录权限！');
			$tip = '恭喜您，系统升级成功！';
			if (!unlink(ROOT_PATH.'/bak/bak_n.sql')) $tip .= '<br>但数据库备份文件删除失败，安全起见，请登录服务器或FTP自行将bak目录删除。';
			$tip .= '<br>请检查各模块是否正常，如有问题随时联系客服解决。';
			return $this->success(NULL,$tip,0,2);
		}
		return $this->view();
	}
}