<?php
return [
	'version'=>'22.0|2020-03-17',  //版本
	'page_size'=>50,  //默认每页条数
	'output_dir'=>'data/output/',  //导出的数据路径
	'qqwry'=>ROOT_PATH.'/data/qqwry.dat',  //IP数据库

	'prev_url'=>$_SERVER['HTTP_REFERER'] ?? '',  //上一页地址
	'web_url'=>(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1),  //站点URL
	'web_url2'=>'//'.$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1),  //站点URL
	'web_url3'=>(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/',  //站点URL

	'pay1'=>[1=>'货到付款',2=>'支付宝（未支付）',3=>'支付宝（已支付）',6=>'微信支付（未支付）',7=>'微信支付（已支付）'],
	'pay2'=>[1=>'货到付款',2=>'支付宝',6=>'微信支付'],
	
	'config_path'=>'config',
	'config_path_admin'=>'app/admin/config',
	'config_path_home'=>'app/home/config',

	'demo'=>$_SERVER['HTTP_HOST']=='www.yvjie.cn',
	'test'=>$_SERVER['HTTP_HOST']=='demo.yjgzs.org',
	
	'error_message'=>'页面错误！请稍后再试～',
	'show_error_msg'=>false,
];