<?php
namespace app\admin\validate;

use think\Validate;

class Product extends Validate{
	protected $rule = [
		'name'=>'require|max:30',
		'sid'=>'require',
		'price'=>'require|regex:/^\d+(\.\d+)?$/',
		'price2'=>'regex:/^\d+(\.\d+)?$/',
		'commission'=>'regex:/^\d+(\.\d+)?$/',
		'color'=>'max:20',
		'email'=>'max:255',
	];
	protected $message = [
		'name'=>'产品名称不得为空或大于30位！',
		'sid'=>'请先在产品分类模块中添加一个分类！',
		'price'=>'产品价格必须是数字！',
		'price2'=>'成本价必须是数字！',
		'commission'=>'分销佣金必须是数字！',
		'color'=>'产品颜色不得大于20位！',
		'email'=>'管理邮箱不得大于255位！',
	];
}