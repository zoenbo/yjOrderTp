<?php

namespace app\admin\validate;

use think\Validate;

class Smtp extends Validate
{
    protected $rule = [
        'smtp' => 'require|max:20',
        'port' => 'require|number|max:6',
        'email' => 'require|email',
        'user' => 'require|email',
        'pass' => 'require|max:50',
    ];
    protected $message = [
        'smtp' => 'SMTP服务器不得为空或大于20位！',
        'port' => 'SMTP端口必须是数字，且不得大于6位！',
        'email' => '发信人邮件地址必须为邮箱格式！',
        'user' => 'SMTP身份验证用户名必须为邮箱格式！',
        'pass' => 'SMTP身份验证密码不得为空或大于50位！',
    ];
}
