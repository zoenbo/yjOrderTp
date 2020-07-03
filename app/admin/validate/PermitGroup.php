<?php

namespace app\admin\validate;

use think\Validate;

class PermitGroup extends Validate
{
    protected $rule = [
        'name' => 'require|max:20',
    ];
    protected $message = [
        'name' => '权限组名称不得为空或大于20位！',
    ];
}
