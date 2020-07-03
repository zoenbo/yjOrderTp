<?php

namespace app\admin\model;

use Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\Model;

class Permit extends Model
{
    //查询总记录（主权限）
    public function total()
    {
        try {
            $total = Db::query('SELECT COUNT(*) count FROM `' . $this->getTable() .
                '` WHERE `parent_id`=0 AND (`name` LIKE \'%' . Request::get('keyword') .
                '%\' OR `controller` LIKE \'%' . Request::get('keyword') . '%\' OR `action` LIKE \'%' .
                Request::get('keyword') . '%\' OR `id` IN (SELECT `parent_id` FROM `' . $this->getTable() .
                '` WHERE `name` LIKE \'%' . Request::get('keyword') . '%\' OR `controller` LIKE \'%' .
                Request::get('keyword') . '%\' OR `action` LIKE \'%' . Request::get('keyword') . '%\'))');
            return $total[0]['count'];
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（主权限）
    public function all($firstRow)
    {
        try {
            return Db::query('SELECT `id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort` FROM `' .
                $this->getTable() . '` WHERE `parent_id`=0 AND (`name` LIKE \'%' . Request::get('keyword') .
                '%\' OR `controller` LIKE \'%' . Request::get('keyword') . '%\' OR `action` LIKE \'%' .
                Request::get('keyword') . '%\' OR `id` IN (SELECT `parent_id` FROM `' . $this->getTable() .
                '` WHERE `name` LIKE \'%' . Request::get('keyword') . '%\' OR `controller` LIKE \'%' .
                Request::get('keyword') . '%\' OR `action` LIKE \'%' . Request::get('keyword') .
                '%\')) ORDER BY `sort` ASC LIMIT ' . $firstRow . ',' . Config::get('app.page_size'));
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（主权限，不分页）
    public function all2($ids = '')
    {
        try {
            $object = $this->field('id,name,controller,action')->order(['sort' => 'ASC'])->where(['parent_id' => 0]);
            return $ids ? $object->where('id', 'IN', $ids)->select()->toArray() : $object->select()->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（子权限）
    public function all3($parentId)
    {
        try {
            return $this->field('id,name,controller,action,is_default,sort')
                ->where('name|controller|action', 'LIKE', '%' . Request::get('keyword') . '%')
                ->where(['parent_id' => $parentId])
                ->order(['sort' => 'ASC'])
                ->select()
                ->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
    public function all5($ids, $parentId)
    {
        try {
            return $this->field('name')
                ->where('id', 'IN', $ids)
                ->where(['parent_id' => $parentId])
                ->order(['sort' => 'ASC'])
                ->select()
                ->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询所有（默认权限）
    public function all4()
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
            return $this->field('name,parent_id,is_default')->where($map)->find();
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

    //排序
    public function sort($id, $sort)
    {
        return $this->where(['id' => $id])->update(['sort' => $sort]);
    }
}
