<?php
namespace app\common\controller;

use function think\_runtime;
use Page;
use think\facade\Config;
use think\facade\View;

class Base{
	public function __construct(){
		$this->initialize();
	}

	protected function initialize(){}
	
	//数据分页
	protected function page($total,$pageSize=0,$url='',$parameter=[]){
		include ROOT_PATH.'/extend/Page.class.php';
		$Page = new Page($total,$pageSize ? $pageSize : Config::get('app.page_size'),$url,$parameter);
		View::assign(['Page'=>$Page->show()]);
		return $Page->firstRow;
	}
	
	//成功提示
	protected function success($url='',$tip='',$second=3,$type=0){
		$url = htmlspecialchars_decode($url);
		if (empty($tip)){
			header('Location:'.$url);
			exit;
		}else{
			if (in_array($type,[0,2])){
				View::assign([
					'Refresh'=>$second,
					'Url'=>$url,
					'Kind'=>'success',
					'Tip'=>$tip,
					'Type'=>$type,
					'A'=>'如果您的浏览器没有自动跳转，请点击这里'
				]);
				return $this->view('../../common/view/public/tip');
			}elseif ($type == 1){
				exit('<script type="text/javascript">alert(\''.$tip.'\');parent.location.href=\''.$url.'\';</script>');
			}else{
				return $this->success($url,$tip,$second,0);
			}
		}
	}
	
	//错误提示
	protected function failed($tip='',$second=5,$type=0,$url=''){
		View::assign([
			'Refresh'=>$second,
			'Url'=>htmlspecialchars_decode($url),
			'Kind'=>'failed',
			'Tip'=>$tip,
			'Type'=>$type,
			'A'=>$type ? '如果您的浏览器没有自动跳转，请点击这里' : '点击这里返回上一页'
		]);
		return $this->view('../../common/view/public/tip');
	}
	protected function error($tip='',$second=5,$type=0,$url=''){
		$a = $type ? '如果您的浏览器没有自动跳转，请点击这里' : '点击这里返回上一页';
		$html = '<!doctype html><html lang="zh-cn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"><title>'.Config::get('system.web_name').'-提示</title><base href="'.Config::get('app.web_url').'"><link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css?'.staticCache().'"><link rel="stylesheet" type="text/css" href="public/base/styles/Tip.css?'.staticCache().'"></head><body><div class="tip"><h3>提示</h3><div><h4 class="failed">'.$tip.'</h4>';
		if ($type == 0){
			$html .= '<p class="location"><a href="javascript:history.go(-1)">'.$a.'</a></p><script type="text/javascript">setTimeout(\'history.go(-1)\','.$second.'*1000)</script>';
		}elseif ($type == 1){
			$html .= '<p class="location"><a href="'.htmlspecialchars_decode($url.'').'">'.$a.'</a></p><script type="text/javascript">setTimeout("location.href=\''.htmlspecialchars_decode($url.'').'\'",'.$second.'*1000)</script>';
		}
		$html .= '</div></div><script type="text/javascript">let run=window.parent.document.getElementById(\'run\');if(run!=null)run.innerHTML=\'执行耗时：'.(_runtime()-START_TIME).'秒\';</script></body></html>';
		exit($html);
	}
	
	//确认提示框
	protected function confirm($message){
		return $this->failed('<form method="post" action=""><input type="hidden" name="prev" value="'.Config::get('app.prev_url').'"><p>'.$message.'</p><p><input type="submit" value="确定" class="btn btn-warning radius"> <input type="button" value="取消" onclick="history.back();" class="btn btn-primary radius"></p></form>',0,2);
	}
	
	//模板引入方法重写
	protected function view($template=''){
		return View::fetch($template);
	}
}