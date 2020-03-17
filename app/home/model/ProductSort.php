<?php
namespace app\home\model;

use Exception;
use think\Model;

class ProductSort extends Model{
	//查询所有（不分页）
	public function all($ids=0){
		try {
			$object = $this->field('id,name,color')->order(['sort'=>'ASC']);
			return $ids ? $object->where('id','IN',$ids)->select()->toArray() : $object->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}