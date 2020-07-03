<?php

namespace app\admin\model;

use app\admin\validate\TemplateStyle as valid;
use Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\Model;

class TemplateStyle extends Model
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
            return $this->field('id,bg_color,border_color,button_color,date')
                ->where($this->map()['field'], $this->map()['condition'], $this->map()['value'])
                ->order(['date' => 'DESC', 'id' => 'DESC'])
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
            return $this->field('id')->order(['id' => 'ASC'])->select()->toArray();
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
            return $this->field('bg_color,border_color,button_color')->where($map)->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //添加
    public function add()
    {
        $data = [
            'bg_color' => Request::post('bg_color'),
            'border_color' => Request::post('border_color'),
            'button_color' => Request::post('button_color'),
            'date' => time()
        ];
        $validate = new valid();
        if ($validate->check($data)) {
            return $this->insertGetId($data);
        } else {
            return $validate->getError();
        }
    }

    //修改
    public function modify()
    {
        $data = [
            'bg_color' => Request::post('bg_color'),
            'border_color' => Request::post('border_color'),
            'button_color' => Request::post('button_color')
        ];
        $validate = new valid();
        if ($validate->check($data)) {
            return $this->where(['id' => Request::get('id')])->update($data);
        } else {
            return $validate->getError();
        }
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

    //搜索
    private function map()
    {
        return [
            'field' => 'bg_color|border_color|button_color',
            'condition' => 'LIKE',
            'value' => '%' . Request::get('keyword') . '%'
        ];
    }
}
