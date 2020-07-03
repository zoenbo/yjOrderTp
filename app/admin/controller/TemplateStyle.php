<?php

namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class TemplateStyle extends Base
{
    public function index()
    {
        $TemplateStyle = new model\TemplateStyle();
        View::assign(['All' => $TemplateStyle->all($this->page($TemplateStyle->total()))]);
        return $this->view();
    }

    public function add()
    {
        if (Request::isPost()) {
            $TemplateStyle = new model\TemplateStyle();
            $object = $TemplateStyle->add();
            if (is_numeric($object)) {
                return $object > 0 ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '模板样式添加成功！') :
                    $this->failed('模板样式添加失败！');
            } else {
                return $this->failed($object);
            }
        }
        return $this->view();
    }

    public function update()
    {
        if (Request::get('id')) {
            $TemplateStyle = new model\TemplateStyle();
            $object = $TemplateStyle->one();
            if (!$object) {
                return $this->failed('不存在此模板样式！');
            }
            if (Request::isPost()) {
                if (Config::get('app.demo') && Request::get('id') <= 12) {
                    return $this->failed('演示站，id<=12的模板样式无法修改！');
                }
                $object = $TemplateStyle->modify();
                return is_numeric($object) ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '模板样式修改成功！') :
                    $this->failed($object);
            }
            View::assign(['One' => $object]);
            return $this->view();
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function delete()
    {
        if (Request::get('id')) {
            if (Config::get('app.demo') && Request::get('id') <= 12) {
                return $this->failed('演示站，id<=12的模板样式无法删除！');
            }
            $TemplateStyle = new model\TemplateStyle();
            if (!$TemplateStyle->one()) {
                return $this->failed('不存在此模板样式！');
            }
            if (Request::isPost()) {
                return $TemplateStyle->remove() ?
                    $this->success(Request::post('prev'), '模板样式删除成功！') :
                    $this->failed('模板样式删除失败！');
            }
            return $this->confirm('您真的要删除这条数据么？');
        } else {
            return $this->failed('非法操作！');
        }
    }
}
