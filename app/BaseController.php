<?php
declare (strict_types = 1);

namespace app;

use function think\_runtime;
use think\facade\Config;

abstract class BaseController{
	public function __construct(){
		$this->initialize();
	}

	protected function initialize(){}

	protected function error($tip='',$second=5,$type=0,$url=''){
		$a = $type ? '如果您的浏览器没有自动跳转，请点击这里' : '点击这里返回上一页';
		$html = '<!doctype html><html lang="zh-cn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"><title>'.Config::get('system.web_name').'-提示</title><base href="'.Config::get('app.web_url').'"><script type="text/javascript" src="public/base/jquery.js"></script><script type="text/javascript" src="public/base/H-ui.admin/h-ui/js/H-ui.min.js"></script><script type="text/javascript" src="public/base/H-ui.admin/h-ui.admin/js/H-ui.admin.js"></script><link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/h-ui/css/H-ui.min.css"><link rel="stylesheet" type="text/css" href="public/base/styles/Tip.css"><script type="text/javascript">var ThinkPHP = {\'H-ui-skin\' : \''.Config::get('system.manage_skin').'\'};</script></head><body><div class="tip"><h3>提示</h3><div><h4 class="failed">'.$tip.'</h4>';
		if ($type == 0){
			$html .= '<p><a href="javascript:history.go(-1)">'.$a.'</a></p><script type="text/javascript">setTimeout(\'history.go(-1)\','.$second.'*1000);</script>';
		}elseif ($type == 1){
			$html .= '<p><a href="'.htmlspecialchars_decode($url.'').'">'.$a.'</a></p><script type="text/javascript">setTimeout("location.href=\''.htmlspecialchars_decode($url.'').'\'",'.$second.'*1000);</script>';
		}
		$html .= '</div></div><script type="text/javascript">var run=window.parent.document.getElementById(\'run\');if(run!=null)run.innerHTML=\'执行耗时：'.(_runtime()-START_TIME).'秒\';</script></body></html>';
		exit($html);
	}
}