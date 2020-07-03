<?php

namespace app\admin\validate;

use think\Validate;

class Product extends Validate
{
    protected $rule = [
        'name' => 'require|max:30',
        'product_sort_id' => 'require',
        'price' => 'require|regex:/^\d+(\.\d+)?$/',
        'color' => 'max:20',
    ];
    protected $message = [
        'name' => '产品名称不得为空或大于30位！',
        'product_sort_id' => '请先在产品分类模块中添加一个分类！',
        'price' => '产品价格必须是数字！',
        'color' => '产品颜色不得大于20位！',
    ];
}
