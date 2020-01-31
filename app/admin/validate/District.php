<?php
namespace app\admin\validate;

use think\Validate;

class District extends Validate{
	protected $rule = [
		'name'=>'require|max:25',
	];
	protected $message = [
		'name'=>'区划名称不得为空或大于25位！',
	];
}