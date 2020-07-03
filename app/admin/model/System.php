<?php

namespace app\admin\model;

use app\admin\validate\System as valid;
use think\facade\Config;
use think\facade\Request;
use think\Model;

class System extends Model
{
    //表单验证
    public function form()
    {
        $data = [
            'web_name' => Request::post('web_name'),
            'admin_mail' => Request::post('admin_mail'),
            'manage_enter' => Request::post('manage_enter'),
            'order_time' => Request::post('order_time'),
            'mail_order_subject' => Request::post('mail_order_subject'),
            'mail_order_content' => Request::post('mail_order_content'),
            'mail_pay_subject' => Request::post('mail_pay_subject'),
            'mail_pay_content' => Request::post('mail_pay_content'),
            'mail_send_subject' => Request::post('mail_send_subject'),
            'mail_send_content' => Request::post('mail_send_content')
        ];
        $validate = new valid();
        if ($validate->check($data)) {
            if (substr(Request::post('manage_enter'), -4) != '.php') {
                return '后台入口必须以.php结尾！';
            }
            if (Request::post('manage_enter', '', 'strtolower') == 'admin.php') {
                return '后台入口不得是admin.php！';
            }
            if (
                Request::post('manage_enter') != Config::get('system.manage_enter') &&
                is_file(ROOT_PATH . '/' . Request::post('manage_enter'))
            ) {
                return '系统根目录中已存在' . Request::post('manage_enter') . '文件，请重新指定一个后台入口！';
            }
            return 1;
        } else {
            return $validate->getError();
        }
    }
}
