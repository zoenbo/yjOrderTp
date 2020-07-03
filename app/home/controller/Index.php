<?php

namespace app\home\controller;

use app\common\controller\Template;
use app\home\model;
use think\facade\Request;

class Index extends Base
{
    public function index()
    {
        $Template = new model\Template();
        $object = $Template->one(Request::param('id'));
        if (!$object) {
            return $this->failed('不存在此下单模板！');
        }
        return (new Template())->html(Request::param('id'));
    }
}
