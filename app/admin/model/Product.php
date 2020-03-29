<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use app\admin\validate\Product as valid;

class Product extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['where'],$this->map()['value'])->count();
	}
	
	//查询运作产品数
	public function total2(){
		$map['is_view'] = 1;
		return $this->where($map)->count();
	}
	
	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,name,product_sort_id,price,color,sort,is_view,is_default,date')
						->where($this->map()['where'],$this->map()['value'])
						->order(['sort'=>'ASC'])
						->limit($firstRow,Config::get('app.page_size'))
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询分类下的产品
	public function all2($product_sort_id=0){
		try {
			return $this->field('id,name,price,color,is_default')
						->where(['product_sort_id'=>$product_sort_id])
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
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('name,product_sort_id,price,color,is_view')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//添加
	public function add(){
		$data = [
			'name'=>Request::post('name'),
			'product_sort_id'=>Request::post('product_sort_id'),
			'price'=>Request::post('price'),
			'color'=>Request::post('color'),
			'sort'=>$this->nextId(),
			'date'=>time()
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat()) return '此产品已存在！';
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}
	
	//修改
	public function modify(){
		$data = [
			'name'=>Request::post('name'),
			'product_sort_id'=>Request::post('product_sort_id'),
			'price'=>Request::post('price'),
			'color'=>Request::post('color')
		];
		$validate = new valid();
		if ($validate->check($data)){
			if ($this->repeat(true)) return '此产品已存在！';
			return $this->where(['id'=>Request::get('id')])->update($data);
		}else{
			return $validate->getError();
		}
	}
	
	//设置默认
	public function isDefault(){
		$this->where(['is_default'=>1])->update(['is_default'=>0]);
		return $this->where(['id'=>Request::get('id')])->update(['is_default'=>1]);
	}
	
	//确认和取消显示
	public function isView($is_view=0){
		return $this->where(['id'=>Request::get('id')])->update(['is_view'=>$is_view]);
	}
	
	//排序
	public function sort($id,$sort){
		return $this->where(['id'=>$id])->update(['sort'=>$sort]);
	}
	
	//删除
	public function remove(){
		try {
			$affected_rows = $this->where(['id'=>Request::get('id')])->delete();
			if ($affected_rows) $this->execute('OPTIMIZE TABLE `'.$this->getTable().'`');
			return $affected_rows;
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//自增ID
	private function nextId(){
		try {
			$object = $this->query('SHOW TABLE STATUS FROM `'.Config::get('database.connections.mysql.database').'` LIKE \''.$this->getTable().'\'');
			return $object[0]['Auto_increment'];
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//验证重复
	private function repeat($update=false){
		try {
			$object = $this->field('id')->where(['name'=>Request::post('name'),'product_sort_id'=>Request::post('product_sort_id')]);
			return $update ? $object->where('id','<>',Request::get('id'))->find() : $object->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//搜索
	private function map(){
		$map['where'] = '(`name` LIKE :name OR `price` LIKE :price)';
		$map['value'] = ['name'=>'%'.Request::get('keyword').'%','price'=>'%'.Request::get('keyword').'%'];
		if (Request::get('product_sort_id')){
			$map['where'] .= ' AND `product_sort_id`=:product_sort_id';
			$map['value']['product_sort_id'] = Request::get('product_sort_id');
		}
		return $map;
	}
}