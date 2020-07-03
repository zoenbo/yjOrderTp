<?php

namespace app\admin\model;

use Exception;
use think\facade\Config;
use think\facade\Request;
use think\Model;

class Field extends Model
{
    //查询总记录
    public function total()
    {
        return $this->where($this->map()['field'], $this->map()['condition'], $this->map()['value'])->count();
    }

    //查询所有
    public function all($firstRow = 0)
    {
        try {
            return $this->field('id,name,is_default')
                ->where($this->map()['field'], $this->map()['condition'], $this->map()['value'])
                ->order(['id' => 'ASC'])
                ->limit($firstRow, Config::get('app.page_size'))
                ->select()
                ->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（不分页）
    public function all2()
    {
        try {
            return $this->field('id,name,is_default')->order(['id' => 'ASC'])->select()->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（默认字段）
    public function all3()
    {
        try {
            return $this->field('id')->where(['is_default' => 1])->order(['id' => 'ASC'])->select()->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询一条
    public function one($id = 0)
    {
        try {
            $map['id'] = $id ? $id : Request::get('id');
            return $this->field('is_default')->where($map)->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //设置和取消默认
    public function isDefault($isDefault)
    {
        return $this->where(['id' => Request::get('id')])->update(['is_default' => $isDefault]);
    }

    //搜索
    private function map()
    {
        return [
            'field' => 'name',
            'condition' => 'LIKE',
            'value' => '%' . Request::get('keyword') . '%'
        ];
    }
}
