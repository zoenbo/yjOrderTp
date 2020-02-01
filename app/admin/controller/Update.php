<?php
namespace app\admin\controller;

class Update extends Base{
	protected function initialize(){
		/*if (file_exists(ROOT_PATH.'/data/install.lock'))*/ $this->error('安装锁定，已经安装过了，如果您确定要进行升级，请到服务器上删除：./data/install.lock。',0,2);
	}
	
	/*public function index(){
		if (IS_POST){
			if (!is_dir(ROOT_PATH.'/Bak')) if (!mkdir(ROOT_PATH.'/Bak')) $this->failed('备份目录创建失败，请检查系统根目录权限！');
			if (copy(ROOT_PATH.'/App/Common/Conf/db.php',ROOT_PATH.'/Bak/db.php') && copy(ROOT_PATH.'/App/Common/Conf/system.php',ROOT_PATH.'/Bak/system.php')){
				$this->success(NULL,'配置文件备份成功，请删除本系统中<span style="color:red;">除去Bak目录之外</span>的所有目录及文件，并上传最新版的程序包。<br>上传完毕后，请将系统根目录下的admin.php重命名为'.C('MANAGE_ENTER').'，然后<a href="'.U(CONTROLLER_NAME.'/restore').'">点击此处</a>进行还原配置文件。',0,2);
			}else{
				$this->failed('配置文件备份失败，请检查Bak目录权限！');
			}
		}
		$newVersion = explode('|',file_get_contents('http://www.yvjie.cn/public/version/id/2.html'));
		$nowVersion = explode('|',C('VERSION'));
		$version = '您当前系统版本为：V'.$nowVersion[0].'（'.$nowVersion[1].'），最新系统版本为：';
		$version .= count($newVersion)==2 ? 'V'.$newVersion[0].'（'.$newVersion[1].'）' : '由于网络原因，未获取到最新版的版本信息，请稍后重试，或登录官网查看';
		$this->assign('Version',$version);
		$this->display();
	}
	
	public function restore(){
		if (IS_POST){
			if (rename(ROOT_PATH.'/Bak/db.php',ROOT_PATH.'/App/Common/Conf/db.php') && rename(ROOT_PATH.'/Bak/system.php',ROOT_PATH.'/App/Common/Conf/system.php')){
				$this->success(NULL,'配置文件还原成功，请<a href="'.U(CONTROLLER_NAME.'/dbbak').'">点击此处</a>进行备份数据库。',0,2);
			}else{
				$this->failed('配置文件还原失败，请检查App/Common/Conf目录权限！');
			}
		}
		$this->display();
	}
	
	public function dbbak(){
		if (IS_POST){
			$Dbbak = new DbbakController();
			$Dbbak->bak('Bak','bak',0,[
				C('DB_PREFIX').'logistics',
				C('DB_PREFIX').'manager',
				C('DB_PREFIX').'order',
				C('DB_PREFIX').'ostate',
				C('DB_PREFIX').'product',
				C('DB_PREFIX').'psort',
				C('DB_PREFIX').'smtp',
				C('DB_PREFIX').'style',
				C('DB_PREFIX').'template',
				C('DB_PREFIX').'visit'
			],0,0);
			$this->success(NULL,'数据库备份成功，请检查备份成功的Bak/bak_n.sql文件是否有乱码。<br>如果有乱码，请不要进行下一步操作，<a href="http://www.yvjie.cn/help/detail/id/5.html" target="_blank">点击此处</a>查看解决方案。<br>如果没有乱码，或已经通过以上解决方案得到解决，请将其在您的电脑中备份一份，以防数据没有还原成功，然后<a href="'.U(CONTROLLER_NAME.'/dbupdate').'">点击此处</a>进行升级数据库。',0,2);
		}
		$this->display();
	}
	
	public function dbupdate(){
		if (IS_POST){
			if (Config::get('app.demo')) $this->failed('演示站，无法操作升级！');
			if (!is_file(ROOT_PATH.'/Data/install.sql')) $this->failed('Data目录中不存在install.sql文件，请检查！');
			if (!is_file(ROOT_PATH.'/Bak/bak_n.sql')) $this->failed('Bak目录中不存在bak_n.sql文件，请检查！');
			$Common = D('Common');
			$object = $Common->info();
			if ($object){
				foreach ($object as $value){
					$Common->execute('DROP TABLE IF EXISTS `'.$value['Name'].'`;');
				}
			}
			$Common->execute(str_replace('yjorder_',C('DB_PREFIX'),file_get_contents(ROOT_PATH.'/Data/install.sql')));
			$Common->execute('TRUNCATE `__PREFIX__style`');
			$Common->execute(file_get_contents(ROOT_PATH.'/Bak/bak_n.sql'));
			if (!file_put_contents(ROOT_PATH.'/Data/install.lock',' ')) $this->failed('安装锁定写入失败，请检查Data目录权限！');;
			$tip = '恭喜您，系统升级成功！';
			if (!unlink(ROOT_PATH.'/Bak/bak_n.sql')) $tip .= '<br>但数据库备份文件删除失败，安全起见，请登录服务器或FTP自行将Bak目录删除。';
			$tip .= '<br>请检查各模块是否正常，如有问题随时联系作者解决。';  
			$this->success(NULL,$tip,0,2);
		}
		$this->display();
	}*/
}