<?php

namespace app\admin\validate;

use think\Validate;

class ProductSort extends Validate
{
    protected $rule = [
        'name' => 'require|max:20',
        'color' => 'max:20',
    ];
    protected $message = [
        'name' => '分类名称不得为空或大于20位！',
        'color' => '分类颜色不得大于20位！',
    ];
}
