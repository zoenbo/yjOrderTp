<?php

namespace app\admin\controller;

use app\admin\model;
use think\facade\Config;
use think\facade\Request;
use think\facade\Route;
use think\facade\View;

class Template extends Base
{
    private $template = [
        '电脑版（新版）',
        '电脑版（经典版）',
        '手机版1',
        '手机版2',
        '手机版3',
        '手机版4'
    ];

    public function index()
    {
        $Template = new model\Template();
        $object = $Template->all($this->page($Template->total()));
        if ($object) {
            $Manager = new model\Manager();
            $OrderState = new model\OrderState();
            foreach ($object as $key => $value) {
                if ($value['manager_id']) {
                    $object2 = $Manager->one($value['manager_id']);
                    $object[$key]['admin'] = $object2 ? $object2['name'] : '此管理员已被删除';
                } else {
                    $object[$key]['admin'] = '不指定';
                }
                $object[$key]['template'] = $this->template[$value['template']];
                $object3 = $OrderState->one($value['order_state_id']);
                $object[$key]['order_state'] = $object3 ?
                    '<span style="color:' . $object3['color'] . ';">' . $object3['name'] . '</span>' : '此状态已被删除';
            }
        }
        View::assign(['All' => $object]);
        return $this->view();
    }

    public function add()
    {
        if (Request::isPost()) {
            $Template = new model\Template();
            $object = $Template->add();
            if (is_numeric($object)) {
                return $object > 0 ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '模板添加成功！') :
                    $this->failed('模板添加失败！');
            } else {
                return $this->failed($object);
            }
        }
        $this->template();
        $this->manager();
        $this->templateStyle();
        $this->sort();
        $this->field();
        $this->pay();
        $this->orderState();
        return $this->view();
    }

    public function update()
    {
        if (Request::get('id')) {
            $Template = new model\Template();
            $object = $Template->one();
            if (!$object) {
                return $this->failed('不存在此模板！');
            }
            if (Request::isPost()) {
                if (Config::get('app.demo') && Request::get('id') <= 6) {
                    return $this->failed('演示站，id<=6的模板无法修改！');
                }
                $object = $Template->modify();
                return is_numeric($object) ?
                    $this->success(Route::buildUrl('/' . parse_name(Request::controller()) . '/index'), '模板修改成功！') :
                    $this->failed($object);
            }
            $this->template($object['template']);
            $this->manager($object['manager_id']);
            $this->templateStyle($object['template_style_id']);

            $product = explode('|', $object['product']);
            $this->sort($product[1] ?? 0);
            $object['product_type'] = $product[0];
            $object['product_ids'] = $product[2] ?? '';
            $object['product_selected'] = $product[3] ?? '';
            $object['view_type'] = $product[4] ?? 1;

            $this->field($object['field']);
            $this->pay($object['pay']);
            $this->orderState($object['order_state_id']);
            View::assign(['One' => $object]);
            return $this->view();
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function code()
    {
        if (Request::get('id')) {
            $Template = new model\Template();
            $object = $Template->one();
            if (!$object) {
                return $this->failed('不存在此模板！');
            }
            View::assign(['One' => $object]);
            return $this->view();
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function order()
    {
        echo (new \app\common\controller\Template())->html(Request::get('id'), 1);
    }

    public function delete()
    {
        if (Request::get('id')) {
            if (Config::get('app.demo') && Request::get('id') <= 6) {
                return $this->failed('演示站，id<=6的模板无法删除！');
            }
            $Template = new model\Template();
            if (!$Template->one()) {
                return $this->failed('不存在此模板！');
            }
            if (Request::isPost()) {
                return $Template->remove() ?
                    $this->success(Request::post('prev'), '模板删除成功！') :
                    $this->failed('模板删除失败！');
            }
            return $this->confirm('您真的要删除这条数据么？');
        } else {
            return $this->failed('非法操作！');
        }
    }

    public function ajaxProduct()
    {
        if (Request::isAjax()) {
            $data = [];
            $Product = new model\Product();
            foreach ($Product->all2(Request::post('product_sort_id')) as $key => $value) {
                $data[$key]['value'] = $value['id'];
                $data[$key]['name'] = $value['name'];
                $data[$key]['selected'] = in_array($value['id'], explode(',', Request::post('product_ids1')));
                $data[$key]['color'] = $value['color'];
            }
            return json_encode($data);
        }
        return '';
    }

    public function ajaxProduct2()
    {
        if (Request::isAjax()) {
            $data = [];
            $ProductSort = new model\ProductSort();
            $object = $ProductSort->all2();
            if ($object) {
                $Product = new model\Product();
                foreach ($object as $key => $value) {
                    $data[$key]['name'] = $value['name'];
                    $data[$key]['color'] = $value['color'];
                    $object2 = $Product->all2($value['id']);
                    if ($object2) {
                        foreach ($object2 as $k => $v) {
                            $data[$key]['children'][$k]['value'] = $v['id'];
                            $data[$key]['children'][$k]['name'] = $v['name'];
                            $data[$key]['children'][$k]['selected'] =
                                in_array($v['id'], explode(',', Request::post('product_ids2')));
                            $data[$key]['children'][$k]['color'] = $v['color'];
                            $data[$key]['children'][$k]['parent_value'] = $value['id'];
                            $data[$key]['children'][$k]['parent_name'] = $value['name'];
                            $data[$key]['children'][$k]['parent_color'] = $value['color'];
                        }
                    } else {
                        $data[$key]['children'][0] = ['name' => '此分类下暂无产品', 'disabled' => true];
                    }
                }
            }
            return json_encode($data);
        }
        return '';
    }

    public function isDefault()
    {
        if (Request::get('id')) {
            $Template = new model\Template();
            if (!$Template->one()) {
                return $this->failed('不存在此模板！');
            }
            if (!$Template->isDefault()) {
                return $this->failed('设置默认模板失败！');
            }
            return $this->success(Config::get('app.prev_url'));
        } else {
            return $this->failed('非法操作！');
        }
    }

    private function template($id = 0)
    {
        $html = '';
        foreach ($this->template as $key => $value) {
            $html .= '<option value="' . $key . '" ' . ($key == $id ? 'selected' : '') . ' view="' .
                Route::buildUrl('/' . parse_name(Request::controller()) . '/order', ['id' => $key]) . '">' . $value .
                '</option>';
        }
        View::assign(['Template' => $html]);
    }

    private function manager($id = 0)
    {
        $html = '';
        $Manager = new model\Manager();
        foreach ($Manager->all2() as $value) {
            $html .= '<option value="' . $value['id'] . '" ' . ($value['id'] == $id ? 'selected' : '') . '>' .
                $value['name'] . '</option>';
        }
        View::assign(['Manager' => $html]);
    }

    private function templateStyle($id = 0)
    {
        $html = '';
        $TemplateStyle = new model\TemplateStyle();
        foreach ($TemplateStyle->all2() as $value) {
            $html .= '<option value="' . $value['id'] . '" ' . ($value['id'] == $id ? 'selected' : '') . '>' .
                $value['id'] . '号样式</option>';
        }
        View::assign(['TemplateStyle' => $html]);
    }

    private function sort($id = 0)
    {
        $html = '';
        $ProductSort = new model\ProductSort();
        foreach ($ProductSort->all2() as $value) {
            $html .= '<option value="' . $value['id'] . '" ' . ($value['id'] == $id ? 'selected' : '') .
                ' style="color:' . $value['color'] . ';">' . $value['name'] . '</option>';
        }
        View::assign(['ProductSort' => $html]);
    }

    private function field($ids = [])
    {
        $html = '';
        $Field = new model\Field();
        $isDefault = arrToStr($Field->all3(), 'id');
        $ids = is_array($ids) ? $isDefault : $ids;
        foreach ($Field->all2() as $value) {
            $html .= '<div class="check-box"><label' . (in_array($value['id'], explode(',', $isDefault)) ?
                    ' class="red"' : '') . '><input type="checkbox" name="field[]" ' .
                (in_array($value['id'], explode(',', $ids)) ? 'checked' : '') . ' value="' . $value['id'] . '">' .
                $value['name'] . '</label></div>';
        }
        View::assign(['Field' => $html]);
    }

    private function pay($ids = '')
    {
        $html = $html2 = '';
        $ids = explode('|', $ids);
        $pay = Config::get('app.pay2');
        foreach ($pay as $key => $value) {
            $html .= '<div class="check-box"><label><input type="checkbox" name="pay[]" value="' . $key . '" ' .
                (isset($ids[1]) && in_array($key, explode(',', $ids[1])) ? 'checked' : '') . '>' . $value .
                '</label></div>';
        }
        foreach ($pay as $key => $value) {
            $html2 .= '<option value="' . $key . '" ' . (in_array($key, explode(',', $ids[0])) ? 'selected' : '') .
                '>' . $value . '</option>';
        }
        View::assign([
            'Pay' => $html,
            'Pay2' => $html2
        ]);
    }

    private function orderState($id = 0)
    {
        $html = '';
        $OrderState = new model\OrderState();
        foreach ($OrderState->all2() as $value) {
            $html .= '<option value="' . $value['id'] . '" ' . ($value['id'] == $id ? 'selected' : '') .
                ' style="color:' . $value['color'] . ';">' . $value['name'] . '</option>';
        }
        View::assign(['OrderState' => $html]);
    }
}
