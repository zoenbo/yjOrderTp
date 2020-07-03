<?php

namespace app\admin\controller;

use app\admin\model;
use think\facade\Config;
use think\facade\View;

class Db extends Base
{
    public function index()
    {
        $rows = $size = $free = 0;
        $Common = new model\Common();
        $object = $Common->info();
        foreach ($object as $key => $value) {
            $object[$key]['size'] = number_format(($value['Index_length'] + $value['Data_length']) / 1024, 1, '.', '');
            $rows += $value['Rows'];
            $size += $object[$key]['size'];
            $object[$key]['size'] = $object[$key]['size'] < 1024 ?
                $object[$key]['size'] . ' KB' : number_format($object[$key]['size'] / 1024, 1, '.', '') . ' MB';
            $free += $value['Data_free'];
        }
        View::assign([
            'All' => $object,
            'TableCount' => count($object),
            'Rows' => $rows,
            'Size' => $size < 1024 ? $size . ' KB' : number_format($size / 1024, 1, '.', '') . ' MB',
            'Free' => $free
        ]);
        return $this->view();
    }

    public function optimize()
    {
        $Common = new model\Common();
        foreach ($Common->info() as $value) {
            $Common->optimizeTable($value['Name']);
        }
        return $this->success(Config::get('app.prev_url'), '数据表优化成功！');
    }

    public function repairAutoIncrement()
    {
        $Common = new model\Common();
        foreach ($Common->info() as $value) {
            $Common->repairAutoIncrement($value['Name']);
        }
        return $this->success(Config::get('app.prev_url'), 'AutoIncrement修复成功！');
    }

    public function schema()
    {
        return databaseSchema() ? $this->success(Config::get('app.prev_url'), '数据表缓存更新成功！') :
            $this->failed('数据表缓存更新失败！');
    }
}
