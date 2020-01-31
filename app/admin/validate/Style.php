<?php
namespace app\admin\validate;

use think\Validate;

class Style extends Validate{
	protected $rule = [
		'bgcolor'=>'require|max:20',
		'bordercolor'=>'require|max:20',
		'buttoncolor'=>'require|max:20',
	];
	protected $message = [
		'bgcolor'=>'背景颜色不得为空或大于20位！',
		'bordercolor'=>'边框颜色不得为空或大于20位！',
		'buttoncolor'=>'按钮颜色不得为空或大于20位！',
	];
}