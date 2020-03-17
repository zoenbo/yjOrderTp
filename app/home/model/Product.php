<?php
namespace app\home\model;

use Exception;
use think\Model;

class Product extends Model{
	//查询所有运作中的产品
	public function all($ids,$product_sort_id=0){
		try {
			$map['is_view'] = 1;
			if ($product_sort_id) $map['product_sort_id'] = $product_sort_id;
			return $this->field('id,name,price,color')
						->where($map)
						->where('id','IN',$ids)
						->order(['sort'=>'ASC'])
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id;
			return $this->field('name,product_sort_id,price,color,is_view')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}