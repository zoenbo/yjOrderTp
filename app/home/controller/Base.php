<?php
namespace app\home\controller;

use think\facade\View;

class Base extends \app\common\controller\Base{
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
				return $this->view('../../home/view/public/tip');
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
		return $this->view('../../home/view/public/tip');
	}
}