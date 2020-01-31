<?php
namespace app\admin\controller;

use QQWry;
use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class LoginRecord extends Base{
	public function index(){
		$LoginRecord = new model\LoginRecord();
		$object = $LoginRecord->all($this->page($LoginRecord->total()));
		if ($object){
			$Manager = new model\Manager();
			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			foreach ($object as $key=>$value){
				$object2 = $Manager->one($value['uid']);
				$object[$key]['manager'] = $object2 ? $object2['name'] : '此管理员已被删除';
				$object[$key]['ip'] = $value['ip'].' - '.$QQWry->getAddr($value['ip']);
			}
		}
		View::assign(['All'=>$object]);
		$this->manager(Request::get('uid'));
		return $this->view();
	}
	
	public function output(){
		if (Request::isPost()){
			$output = '"管理员","登录IP","登录时间",';
			$LoginRecord = new model\LoginRecord();
			$object = $LoginRecord->all2();
			if ($object){
			include ROOT_PATH.'/extend/QQWry.class.php';
				$QQWry = QQWry::getInstance();
				$Manager = new model\Manager();
				foreach ($object as $value){
					$object2 = $Manager->one($value['uid']);
					$output .= "\r\n".'"'.($object2 ? $object2['name'] : '此管理员已被删除').'","'.$value['ip'].' -- '.$QQWry->getAddr($value['ip']).'","'.dateFormat($value['date']).'",';
				}
			}
			$output = mb_convert_encoding($output,'GBK','UTF-8');
			$file = Config::get('app.output_dir').'login_'.date('YmdHis').'.csv';
			if (file_put_contents(ROOT_PATH.'/'.$file,$output)){
				$LoginRecord->truncate();
				return $this->success(NULL,'文件生成成功！<a href="'.Config::get('app.web_url').$file.'">下载</a> <a href="javascript:;" onclick="addTab(\''.Route::buildUrl('/output/index').'\',\'导出的数据\')">去管理文件</a> <a href="'.Route::buildUrl('/'.parse_name(Request::controller()).'/index').'">返回</a>',0,2);
			}else{
				return $this->failed('文件生成失败，请检查'.Config::get('app.output_dir').'目录权限！');
			}
		}
		return $this->confirm('确定要将数据导出到文件并清空数据表吗？');
	}
	
	private function manager($id=0){
		$html = '';
		$Manager = new model\Manager();
		foreach ($Manager->all2() as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
		}
		View::assign(['Manager'=>$html]);
	}
}