<?php
namespace app\home\model;

use Exception;
use think\Model;

class Style extends Model{
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id;
			return $this->field('bgcolor,bordercolor,buttoncolor')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}