<?php

namespace app\admin\validate;

use think\Validate;

class Template extends Validate
{
    protected $rule = [
        'name' => 'require|max:20',
        'success' => 'require|max:255',
        'success2' => 'require|max:255',
        'often' => 'require|max:255',
    ];
    protected $message = [
        'name' => '模板名称不得为空或大于20位！',
        'success' => '提交成功的提示信息不得为空或大于255位！',
        'success2' => '支付成功的提示信息不得为空或大于255位！',
        'often' => '频繁提交的提示信息不得为空或大于255位！',
    ];
}
