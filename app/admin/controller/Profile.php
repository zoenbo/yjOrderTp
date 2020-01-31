<?php
namespace app\admin\controller;

use QC;
use QQWry;
use think\facade\Route;
use think\facade\Session;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Profile extends Base{
	public function index(){
		$Manager = new model\Manager();
		if (Request::isPost()){
			if (Config::get('app.demo')) return $this->failed('演示站，数据无法修改！');
			$object = $Manager->modify2();
			return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'个人资料修改成功！') : $this->failed($object);
		}
		$session = Session::get(Config::get('system.session_key'));
		$object = $Manager->one($session['id']);
		if ($object['level'] == 1){
			$object['group'] = '超级管理员';
		}else{
			$PermitGroup = new model\PermitGroup();
			$object2 = $PermitGroup->one($object['gid']);
			$object['group'] = $object2 ? $object2['name'] : '此权限组已被删除';
		}
		View::assign(['One'=>$object]);
		return $this->view();
	}
	
	public function login(){
		$LoginRecord = new model\LoginRecord();
		$object = $LoginRecord->all($this->page($LoginRecord->total(1)),1);
		if ($object){
			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			foreach ($object as $key=>$value){
				$object[$key]['ip'] = $value['ip'].' - '.$QQWry->getAddr($value['ip']);
			}
		}
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	//QQ登录
	public function qq(){
		include ROOT_PATH.'/extend/qq/autoload.php';
		$qc = new QC('','',Config::get('app.web_url').'callback.php/qq_profile');
		$qc->qq_login();
	}
}