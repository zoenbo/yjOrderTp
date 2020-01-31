<?php
namespace app\home\model;

use Exception;
use think\Model;

class Ostate extends Model{
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id;
			return $this->field('name,color')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}