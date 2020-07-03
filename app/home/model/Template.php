<?php

namespace app\home\model;

use Exception;
use think\facade\Request;
use think\Model;

class Template extends Model
{
    //查询一条
    public function one($id = 0)
    {
        try {
            $map['id'] = $id ? $id : Request::get('id');
            return $this->field('name,manager_id,template,template_style_id,product,field,pay,order_state_id,' .
                'is_show_search,is_show_send,is_captcha,is_qq,success,success2,often')
                ->where($map)
                ->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}
