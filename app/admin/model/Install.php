<?php
namespace app\admin\model;

use app\admin\validate\Install as valid;
use think\facade\Request;
use think\Model;

class Install extends Model{
	//第二步表单验证
	public function step2(){
		//if (I('post.pass') != preg_replace('/^\xEF\xBB\xBF/','',file_get_contents('http://www.yvjie.cn/public/pass/id/2.html'))) return '安装密钥错误，请确保您的服务器处于联网状态，并检查是否输入正确！';
		$data = [
			'db_host'=>Request::post('db_host'),
			'db_port'=>Request::post('db_port'),
			'db_name'=>Request::post('db_name'),
			'db_user'=>Request::post('db_user'),
			'db_pwd'=>Request::post('db_pwd'),
			'db_prefix'=>Request::post('db_prefix')
		];
		$validate = new valid();
		if ($validate->scene('step2')->check($data)){
			return $data;
		}else{
			return $validate->getError();
		}
	}

	//第三步表单验证
	public function step3(){
		$data = [
			'web_name'=>Request::post('web_name'),
			'manage_enter'=>Request::post('manage_enter')
		];
		$validate = new valid();
		if ($validate->scene('step3')->check($data)){
			if (substr(Request::post('manage_enter'),-4) != '.php') return '后台入口必须以.php结尾！';
			if (Request::post('manage_enter',NULL,'strtolower') == 'admin.php') return '后台入口不得是admin.php！';
			if (is_file(ROOT_PATH.'/'.Request::post('manage_enter'))) return '系统根目录中已存在'.Request::post('manage_enter').'文件，请重新指定一个后台入口！';
			return 1;
		}else{
			return $validate->getError();
		}
	}
}