<?php

namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class PermitGroup extends Base
{
    public function index()
    {
        $PermitGroup = new model\PermitGroup();
        $object = $PermitGroup->all($this->page($PermitGroup->total()));
        if ($object) {
            $Permit = new model\Permit();
            foreach ($object as $key => $value) {
                $permitStr = '';
                if ($value['permit_ids']) {
                    $object2 = $Permit->all2($value['permit_ids']);
                    foreach ($object2 as $v) {
                        $permitStr .= '' . $v['name'] . '：<span class="blue">';
                        $object3 = $Permit->all5($value['permit_ids'], $v['id']);
                        foreach ($object3 as $v2) {
                            $permitStr .= $v2['name'] . '、';
                        }
                        $permitStr = (substr($permitStr, -3) == '、' ? substr($permitStr, 0, -3) : $permitStr) .
                            '</span><br>';
                    }
                }
                $object[$key]['permit'] = $permitStr;
            }
        }
        View::assign(['All' => $object]);
        return $this->view();
    }

    public function add()
    {
        if (Request::isPost()) {
            $PermitGroup = new model\PermitGroup();
            $object = $PermitGroup->add();
            if (is_numeric($object)) {
                return $object > 0 ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '权限组添加成功！') :
                    $this->failed('权限组添加失败！');
            } else {
                return $this->failed($object);
            }
        }
        $this->permit();
        return $this->view();
    }

    public function update()
    {
        if (Request::get('id')) {
            $PermitGroup = new model\PermitGroup();
            $object = $PermitGroup->one();
            if (!$object) {
                return $this->failed('不存在此权限组！');
            }
            if (Request::isPost()) {
                $object = $PermitGroup->modify();
                return is_numeric($object) ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '权限组修改成功！') :
                    $this->failed($object);
            }
            $this->permit($object['permit_ids']);
            View::assign(['One' => $object]);
            return $this->view();
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function isDefault()
    {
        if (Request::get('id')) {
            $PermitGroup = new model\PermitGroup();
            if (!$PermitGroup->one()) {
                return $this->failed('不存在此权限组！');
            }
            if (!$PermitGroup->isDefault()) {
                return $this->failed('设置默认权限组失败！');
            }
            return $this->success(Config::get('app.prev_url'));
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function delete()
    {
        if (Request::get('id')) {
            $PermitGroup = new model\PermitGroup();
            $object = $PermitGroup->one();
            if (!$object) {
                return $this->failed('不存在此权限组！');
            }
            if (Request::isPost()) {
                return $PermitGroup->remove() ?
                    $this->success(Request::post('prev'), '权限组删除成功！') :
                    $this->failed('权限组删除失败！');
            }
            return $this->confirm('您真的要删除这条数据么？');
        } else {
            return $this->failed('非法操作！');
        }
    }

    private function permit($ids = [])
    {
        $Permit = new model\Permit();
        $isDefault = arrToStr($Permit->all4(), 'id');
        $ids = is_array($ids) ? $isDefault : $ids;
        $html = '';
        $object = $Permit->all2();
        if ($object) {
            $html .= '<table>';
            foreach ($object as $value) {
                $html .= '<tr><td><div class="check-box"><label' .
                    (in_array($value['id'], explode(',', $isDefault)) ? ' class="red"' : '') .
                    '><input type="checkbox" name="permit_ids[]" ' .
                    (in_array($value['id'], explode(',', $ids)) ? 'checked' : '') . ' value="' . $value['id'] . '">' .
                    $value['name'] . '</label></div></td><td>';
                $object2 = $Permit->all3($value['id']);
                if ($object2) {
                    foreach ($object2 as $v) {
                        $html .= '<div class="check-box"><label class="' .
                            (in_array($v['id'], explode(',', $isDefault)) ? ' red' : 'blue') .
                            '"><input type="checkbox" name="permit_ids[]" ' .
                            (in_array($v['id'], explode(',', $ids)) ? 'checked' : '') . ' value="' . $v['id'] . '">' .
                            $v['name'] . '</label></div>';
                    }
                }
                $html .= '</td></tr>';
            }
            $html .= '</table>';
        }
        View::assign(['Permit' => $html]);
    }
}
