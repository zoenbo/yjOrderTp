<?php

namespace app\admin\model;

use app\admin\validate\PermitGroup as valid;
use Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\Model;

class PermitGroup extends Model
{
    //查询总记录
    public function total()
    {
        return $this->where($this->map()['field'], $this->map()['condition'], $this->map()['value'])->count();
    }

    //查询所有
    public function all($firstRow)
    {
        try {
            return $this->field('id,name,permit_ids,is_default,date')
                ->where($this->map()['field'], $this->map()['condition'], $this->map()['value'])
                ->order(['date' => 'DESC'])
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
            return $this->field('id,name,is_default')->order(['date' => 'DESC'])->select()->toArray();
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
            return $this->field('name,permit_ids,is_default')->where($map)->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //添加
    public function add()
    {
        $data = [
            'name' => Request::post('name'),
            'date' => time()
        ];
        $permitIds = Request::post('permit_ids');
        if ($permitIds) {
            asort($permitIds);
            $data['permit_ids'] = implode(',', $permitIds);
        } else {
            $data['permit_ids'] = '';
        }
        $validate = new valid();
        if ($validate->check($data)) {
            if ($this->repeat()) {
                return '此权限组已存在！';
            }
            return $this->insertGetId($data);
        } else {
            return $validate->getError();
        }
    }

    //修改
    public function modify()
    {
        $data = [
            'name' => Request::post('name')
        ];
        $permitIds = Request::post('permit_ids');
        if ($permitIds) {
            asort($permitIds);
            $data['permit_ids'] = implode(',', $permitIds);
        } else {
            $data['permit_ids'] = '';
        }
        $validate = new valid();
        if ($validate->check($data)) {
            if ($this->repeat(true)) {
                return '此权限组已存在！';
            }
            return $this->where(['id' => Request::get('id')])->update($data);
        } else {
            return $validate->getError();
        }
    }

    //设置默认
    public function isDefault()
    {
        $this->where(['is_default' => 1])->update(['is_default' => 0]);
        return $this->where(['id' => Request::get('id')])->update(['is_default' => 1]);
    }

    //删除
    public function remove()
    {
        try {
            $affectedRows = $this->where(['id' => Request::get('id')])->delete();
            if ($affectedRows) {
                Db::execute('OPTIMIZE TABLE `' . $this->getTable() . '`');
            }
            return $affectedRows;
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //验证重复
    private function repeat($update = false)
    {
        try {
            $object = $this->field('id')->where(['name' => Request::post('name')]);
            return $update ? $object->where('id', '<>', Request::get('id'))->find() : $object->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
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
