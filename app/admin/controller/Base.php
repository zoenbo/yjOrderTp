<?php
namespace app\admin\controller;

use function think\_runtime;
use think\facade\Route;
use think\facade\Session;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;

class Base extends \app\common\controller\Base{
	//初始化
	protected function initialize(){
		parent::initialize();
		$this->checkLogin();
		if (Session::has(Config::get('system.session_key'))){
			$this->checkPermit(Request::controller(),strtolower(Request::action()));
			$this->publicAssign();
		}
	}

	//注入公共变量
	protected function publicAssign(){
		$session = Session::get(Config::get('system.session_key'));
		View::assign([
			'Admin'=>$session,
			'AdminPermit'=>explode(',',$session['permit']),
			'Permission'=>Config::get('permit.permit')
		]);
	}

	//登录验证
	protected function checkLogin(){
		if (Session::has(Config::get('system.session_key')) && Request::controller()=='Login' && Request::action()!='logout'){
			$this->success(Route::buildUrl('/index/index'));
		}elseif (!Session::has(Config::get('system.session_key')) && Request::controller()=='Index'){
			$this->success(Route::buildUrl('/login/index'));
		}elseif (!Session::has(Config::get('system.session_key')) && Request::controller()!='Login'){
			$this->error('非法登录！',5,1,Route::buildUrl('/login/index'));
		}
	}

	//权限验证
	protected function checkPermit($c,$a){
		$session = Session::get(Config::get('system.session_key'));
		$permit = Config::get('permit.permit');
		if ($session['level']!=1 && isset($permit[$c][$a]) && !in_array($permit[$c][$a],explode(',',$session['permit']))) $this->error('权限不足！');
	}

	//模板引入方法重写
	protected function view($template=''){
		$run = '<script type="text/javascript">var run=window.parent.document.getElementById(\'run\');if(run!=null)run.innerHTML=\'执行耗时：'.(_runtime()-START_TIME).'秒\';</script>';
		if (Config::get('app.demo')) $run .= '<p style="display:none;"><script type="text/javascript" src="http://js.users.51.la/19104960.js"></script><noscript><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/19104960.asp"></noscript></p><script type="text/javascript" src="'.Config::get('app.web_url').'public/home/js/Visit.js"></script>';
		View::assign(['Run'=>$run]);
		return parent::view($template);
	}
}