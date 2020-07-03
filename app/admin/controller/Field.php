<?php

namespace app\admin\controller;

use app\admin\model;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;

class Field extends Base
{
    public function index()
    {
        $Field = new model\Field();
        $object = $Field->all($this->page($Field->total()));
        View::assign(['All' => $object]);
        return $this->view();
    }

    public function isDefault()
    {
        if (Request::get('id')) {
            $Field = new model\Field();
            $object = $Field->one();
            if (!$object) {
                return $this->failed('不存在此字段！');
            }
            if ($object['is_default'] == 0) {
                if (!$Field->isDefault(1)) {
                    return $this->failed('设置默认字段失败！');
                }
            } else {
                if (!$Field->isDefault(0)) {
                    return $this->failed('取消默认字段失败！');
                }
            }
            return $this->success(Config::get('app.prev_url'));
        } else {
            return $this->failed('非法操作！');
        }
    }
}
