<?php

namespace app\home\model;

use Exception;
use think\Model;

class Smtp extends Model
{
    //查询总记录
    public function total()
    {
        return $this->count();
    }

    //查询运行中的服务器
    public function one()
    {
        try {
            $firstRow = date('H') % $this->total();
            return $this->field('smtp,port,email,user,pass')
                ->order(['id' => 'DESC'])
                ->limit($firstRow, 1)
                ->select()
                ->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}
