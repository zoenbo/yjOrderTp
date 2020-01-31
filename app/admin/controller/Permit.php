<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Permit extends Base{
	public function index(){
		$Permit = new model\Permit();
		$object = $Permit->all($this->page($Permit->total()));
		foreach ($object as $key=>$value){
			$object[$key]['obj'] = $Permit->all3($value['id']);
		}
		View::assign(['All'=>$object]);
		return $this->view();
	}
	
	public function sort(){
		if (Request::isPost()){
			$Permit = new model\Permit();
			foreach (Request::post('sort') as $key=>$value){
				if (!is_numeric($value)) continue;
				$Permit->sort($key,$value);
			}
			return $this->success(Config::get('app.prev_url'),'权限排序成功！');
		}
		return '';
	}
	
	public function selected(){
		if (Request::get('id')){
			$Permit = new model\Permit();
			$object = $Permit->one();
			if (!$object) return $this->failed('不存在此权限！');
			if ($object['selected'] == 0){
				if (!$Permit->selected(1)) return $this->failed('设置默认权限失败！');
			}else{
				if (!$Permit->selected(0)) return $this->failed('取消默认权限失败！');
			}
			return $this->success(Config::get('app.prev_url'));
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function output(){
		$Permit = new model\Permit();
		$object = $Permit->all2();
		$output = '<?php return [';
		if ($object){
			$output .= "'permit'=>[";
			foreach ($object as $value){
				$output .= "'".$value['c']."'=>['".strtolower($value['a'])."'=>".$value['id'];
				$object2 = $Permit->all3($value['id']);
				if ($object2){
					foreach ($object2 as $v){
						$output .= ",'".strtolower($v['a'])."'=>".$v['id'];
					}
				}
				$output .= '],';
			}
			$output = substr($output,0,-1).']';
		}
		$output .= '];';
		return file_put_contents(ROOT_PATH.'/'.Config::get('app.config_path_admin').'/permit.php',$output) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'配置文件更新成功！') : $this->failed('配置文件更新失败！');
	}
}