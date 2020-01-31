<?php
namespace app\home\model;

use Exception;
use think\Model;
use think\facade\Request;

class Template extends Model{
	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			return $this->field('name,uid,template,sid,product,field,pay,state,search,send,cid,qq,success,success2,often')->where($map)->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
}