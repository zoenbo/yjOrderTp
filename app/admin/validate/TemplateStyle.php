<?php
namespace app\admin\validate;

use think\Validate;

class TemplateStyle extends Validate{
	protected $rule = [
		'bg_color'=>'require|max:20',
		'border_color'=>'require|max:20',
		'button_color'=>'require|max:20',
	];
	protected $message = [
		'bg_color'=>'背景颜色不得为空或大于20位！',
		'border_color'=>'边框颜色不得为空或大于20位！',
		'button_color'=>'按钮颜色不得为空或大于20位！',
	];
}