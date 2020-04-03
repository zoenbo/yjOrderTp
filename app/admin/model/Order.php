<?php
namespace app\admin\model;

use Exception;
use think\Model;
use think\facade\Request;
use think\facade\Config;
use think\facade\Session;
use app\admin\validate\Order as valid;

class Order extends Model{
	//查询总记录
	public function total(){
		return $this->where($this->map()['where'],$this->map()['value'])->count();
	}

	//按订单状态查询总记录
	public function total2($order_state_id=0){
		$map['recycle'] = 0;
		if ($order_state_id) $map['order_state_id'] = $order_state_id;
		return $this->where($map)->where($this->managerId())->count();
	}

	//查询所有
	public function all($firstRow){
		try {
			return $this->field('id,order_id,manager_id,template_id,product_id,price,count,name,tel,province,city,county,town,address,post,note,email,ip,referrer,pay,pay_id,pay_scene,pay_date,order_state_id,logistics_id,logistics_number,date')
						->where($this->map()['where'],$this->map()['value'])
						->order(['date'=>'DESC'])
						->limit($firstRow,Config::get('app.page_size'))
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询所有（不分页）
	public function all2(){
		try {
			return $this->field('id,order_id,manager_id,template_id,product_id,price,count,name,tel,province,city,county,town,address,post,note,email,ip,referrer,pay,pay_id,pay_scene,pay_date,order_state_id,logistics_id,logistics_number,date')
						->where($this->map()['where'],$this->map()['value'])
						->order(['date'=>'DESC'])
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询所有（不分页，IN）
	public function all3(){
		try {
			return $this->field('id,order_id,manager_id,template_id,product_id,price,count,name,tel,province,city,county,town,address,post,note,email,ip,referrer,pay,pay_id,pay_scene,pay_date,order_state_id,logistics_id,logistics_number,date')
						->where('id','IN',Request::post('ids'))
						->where('recycle',Request::controller()=='OrderRecycle' ? 1 : 0)
						->where($this->managerId())
						->order(['date'=>'DESC'])
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//按自定义时间统计
	public function diyTime($time1,$time2){
		try {
			$map = $this->map();
			$map['where'] .= ' AND `date`>=:date3 AND `date`<=:date4';
			$map['value']['date3'] = strtotime($time1.' 00:00:00');
			$map['value']['date4'] = strtotime($time2.' 23:59:59');
			return $this->field('COUNT(CASE WHEN `order_state_id`=1 THEN `id` END) `count1`,SUM(CASE WHEN `order_state_id`=1 THEN `price`*`count` ELSE 0 END) `sum1`,COUNT(CASE WHEN `order_state_id`=2 THEN `id` END) `count2`,SUM(CASE WHEN `order_state_id`=2 THEN `price`*`count` ELSE 0 END) `sum2`,COUNT(CASE WHEN `order_state_id`=3 THEN `id` END) `count3`,SUM(CASE WHEN `order_state_id`=3 THEN `price`*`count` ELSE 0 END) `sum3`,COUNT(CASE WHEN `order_state_id`=4 THEN `id` END) `count4`,SUM(CASE WHEN `order_state_id`=4 THEN `price`*`count` ELSE 0 END) `sum4`')
						->where($map['where'],$map['value'])
						->select()
						->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	
	//按天、月、年统计
	public function dayMonthYear($time,$firstRow=-1){
		try {
			switch (Request::get('order')){
				case 1: $order = 'count1';
					break;
				case 2: $order = 'count2';
					break;
				case 3: $order = 'count3';
					break;
				case 4: $order = 'count4';
					break;
				case 5: $order = 'sum1';
					break;
				case 6: $order = 'sum2';
					break;
				case 7: $order = 'sum3';
					break;
				case 8: $order = 'sum4';
					break;
				default: $order = 'time';
			}
			$object = $this->field('COUNT(CASE WHEN `order_state_id`=1 THEN `id` END) `count1`,SUM(CASE WHEN `order_state_id`=1 THEN `price`*`count` ELSE 0 END) `sum1`,COUNT(CASE WHEN `order_state_id`=2 THEN `id` END) `count2`,SUM(CASE WHEN `order_state_id`=2 THEN `price`*`count` ELSE 0 END) `sum2`,COUNT(CASE WHEN `order_state_id`=3 THEN `id` END) `count3`,SUM(CASE WHEN `order_state_id`=3 THEN `price`*`count` ELSE 0 END) `sum3`,COUNT(CASE WHEN `order_state_id`=4 THEN `id` END) `count4`,SUM(CASE WHEN `order_state_id`=4 THEN `price`*`count` ELSE 0 END) `sum4`,FROM_UNIXTIME(`date`,\''.$time.'\') `time`')
						->group('time')
						->where($this->map()['where'],$this->map()['value'])
						->order([$order=>'DESC']);
			return $firstRow>=0 ? $object->limit($firstRow,Config::get('app.page_size'))->select()->toArray() : $object->select()->toArray();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询一条
	public function one($id=0){
		try {
			$map['id'] = $id ? $id : Request::get('id');
			$map['recycle'] = Request::controller()=='OrderRecycle' ? 1 : 0;
			return $this->field('order_id,manager_id,template_id,product_id,price,count,name,tel,province,city,county,town,address,post,note,email,ip,qqau,referrer,pay,pay_id,pay_scene,pay_date,order_state_id,logistics_id,logistics_number,date')->where($map)->where($this->managerId())->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}
	public function one2(){
		try {
			$map['id'] = Request::get('id');
			$map['recycle'] = Request::controller()=='OrderRecycle' ? 1 : 0;
			return $this->field('manager_id')->where($map)->where($this->managerId())->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询最老一条
	public function older(){
		try {
			$map['recycle'] = 0;
			return $this->field('date')->where($map)->where($this->managerId())->order(['date'=>'ASC'])->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//查询最新一条
	public function newer(){
		try {
			$map['recycle'] = 0;
			return $this->field('date')->where($map)->where($this->managerId())->order(['date'=>'DESC'])->find();
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//添加
	public function add(){
		$scene = ['template_id','product_id','price','count'];
		$session = Session::get(Config::get('system.session_key'));
		$Template = new Template();
		$object = $Template->one(Request::post('template_id'));
		$data = [
			'order_id'=>time().rand(100,999),
			'template_id'=>Request::post('template_id'),
			'product_id'=>Request::post('product_id'),
			'manager_id'=>$session['id'],
			'price' =>Request::post('price'),
			'count'=>Request::post('count'),
			'pay'=>Request::post('pay'),
			'ip'=>getUserIp(),
			'date'=>time()
		];
		$fieldTemp = explode(',',$object['field']);
		if (in_array(2,$fieldTemp) || Request::post('name')){
			$data['name'] = Request::post('name');
			$scene[] = 'name';
		}
		if (in_array(3,$fieldTemp) || Request::post('tel')){
			$data['tel'] = Request::post('tel');
			$scene[] = 'tel';
		}
		if (in_array(4,$fieldTemp) && in_array(5,$fieldTemp)){
			if (Request::post('type') == 'a'){
				$data['province'] = Request::post('province');
				$data['city'] = Request::post('city');
				$data['county'] = Request::post('county');
				$data['town'] = Request::post('town');
				$scene[] = 'province';
				$scene[] = 'city';
				$scene[] = 'county';
				$scene[] = 'town';
			}elseif (Request::post('type') == 'b'){
				$data['province'] = Request::post('province2');
				$data['city'] = Request::post('city2');
				$data['county'] = Request::post('county2');
				$data['town'] = Request::post('town2');
				$scene[] = 'province2';
				$scene[] = 'city2';
				$scene[] = 'county2';
				$scene[] = 'town2';
			}
		}else{
			if (in_array(4,$fieldTemp) || Request::post('province')){
				$data['province'] = Request::post('province');
				$scene[] = 'province';
			}
			if (in_array(4,$fieldTemp) || Request::post('city')){
				$data['city'] = Request::post('city');
				$scene[] = 'city';
			}
			if (in_array(4,$fieldTemp) || Request::post('county')){
				$data['county'] = Request::post('county');
				$scene[] = 'county';
			}
			if (in_array(4,$fieldTemp) || Request::post('town')){
				$data['town'] = Request::post('town');
				$scene[] = 'town';
			}
			if (in_array(5,$fieldTemp) || Request::post('province2')){
				$data['province'] = Request::post('province2');
				$scene[] = 'province2';
			}
			if (in_array(5,$fieldTemp) || Request::post('city2')){
				$data['city'] = Request::post('city2');
				$scene[] = 'city2';
			}
			if (in_array(5,$fieldTemp) || Request::post('county2')){
				$data['county'] = Request::post('county2');
				$scene[] = 'county2';
			}
			if (in_array(5,$fieldTemp) || Request::post('town2')){
				$data['town'] = Request::post('town2');
				$scene[] = 'town2';
			}
		}
		if (in_array(6,$fieldTemp) || Request::post('address')){
			$data['address'] = Request::post('address');
			$scene[] = 'address';
		}
		if (in_array(7,$fieldTemp) || Request::post('post')){
			$data['post'] = Request::post('post');
			$scene[] = 'post';
		}
		if (in_array(8,$fieldTemp) || Request::post('note')){
			$data['note'] = Request::post('note');
			$scene[] = 'note';
		}
		if (in_array(9,$fieldTemp) || Request::post('email')){
			$data['email'] = Request::post('email');
			$scene[] = 'email';
		}
		$data['order_state_id'] = Request::post('order_state_id');
		$data['logistics_id'] = Request::post('logistics_id');
		$data['logistics_number'] = Request::post('logistics_number');
		$scene[] = 'logistics_number';
		$validate = new valid();
		if ($validate->only($scene)->check($data)){
			return $this->insertGetId($data);
		}else{
			return $validate->getError();
		}
	}

	//修改
	public function modify(){
		$scene = ['template_id','product_id','price','count'];
		$data = [
			'template_id'=>Request::post('template_id'),
			'product_id'=>Request::post('product_id'),
			'price'=>Request::post('price'),
			'count'=>Request::post('count'),
			'name'=>Request::post('name'),
			'tel'=>Request::post('tel'),
			'province'=>Request::post('province2'),
			'city'=>Request::post('city2'),
			'county'=>Request::post('county2'),
			'town'=>Request::post('town2'),
			'address'=>Request::post('address'),
			'post'=>Request::post('post'),
			'note'=>Request::post('note'),
			'email'=>Request::post('email'),
			'count'=>Request::post('count'),
		];
		$data['pay'] = Request::post('pay');
		$data['order_state_id'] = Request::post('order_state_id');
		$data['logistics_id'] = Request::post('logistics_id');
		$data['logistics_number'] = Request::post('logistics_number');
		$scene[] = 'logistics_number';
		$Template = new Template();
		$object2 = $Template->one(Request::post('template_id'));
		$fieldTemp = explode(',',$object2['field']);
		if (in_array(2,$fieldTemp) || Request::post('name')) $scene[] = 'name';
		if (in_array(3,$fieldTemp) || Request::post('tel')) $scene[] = 'tel';
		if (in_array(4,$fieldTemp) || in_array(5,$fieldTemp) || Request::post('province2')) $scene[] = 'province';
		if (in_array(4,$fieldTemp) || in_array(5,$fieldTemp) || Request::post('city2')) $scene[] = 'city';
		if (in_array(4,$fieldTemp) || in_array(5,$fieldTemp) || Request::post('county2')) $scene[] = 'county';
		if (in_array(4,$fieldTemp) || in_array(5,$fieldTemp) || Request::post('town2')) $scene[] = 'town';
		if (in_array(6,$fieldTemp) || Request::post('address')) $scene[] = 'address';
		if (in_array(7,$fieldTemp) || Request::post('post')) $scene[] = 'post';
		if (in_array(8,$fieldTemp) || Request::post('note')) $scene[] = 'note';
		if (in_array(9,$fieldTemp) || Request::post('email')) $scene[] = 'email';
		$map['id'] = Request::get('id');
		$map['recycle'] = Request::controller()=='OrderRecycle' ? 1 : 0;
		$validate = new valid();
		if ($validate->only($scene)->check($data)){
			return $this->where($map)->where($this->managerId())->update($data);
		}else{
			return $validate->getError();
		}
	}

	//回收
	public function recycle(){
		return Request::get('id') ? $this->where(['id'=>Request::get('id')])->where($this->managerId())->update(['recycle'=>1]) : $this->where('id','IN',Request::post('ids'))->where($this->managerId())->update(['recycle'=>1]);
	}

	//还原
	public function recover(){
		return Request::get('id') ? $this->where(['id'=>Request::get('id')])->where($this->managerId())->update(['recycle'=>0]) : $this->where('id','IN',Request::post('ids'))->where($this->managerId())->update(['recycle'=>0]);
	}

	//删除
	public function remove(){
		try {
			$affected_rows = Request::get('id') ? $this->where(['id'=>Request::get('id')])->where($this->managerId())->delete() : $this->where('id','IN',Request::post('ids'))->where($this->managerId())->delete();
			if ($affected_rows) $this->execute('OPTIMIZE TABLE `'.$this->getTable().'`');
			return $affected_rows;
		} catch (Exception $e){
			echo $e->getMessage();
			return [];
		}
	}

	//批量修改订单状态
	public function state(){
		return $this->where('id','IN',Request::post('ids'))->where($this->managerId())->update(['order_state_id'=>Request::post('order_state_id')]);
	}

	//批量修改物流
	public function multi(){
		foreach (explode("\r\n",Request::post('multi')) as $value){
			$value = explode('|',$value);
			if (count($value) != 3) return '批量修改格式有误！';
			$this->where(['order_id'=>$value[0]])->where($this->managerId())->update([	'logistics_id'=>$value[1],'logistics_number'=>$value[2]]);
		}
		return 1;
	}

	//高级搜索
	private function map(){
		$map['where'] = '1=1';
		$map['value'] = [];
		if (Request::get('field') < 14){
			$keyword = [];
			$map['where'] .= ' AND (';
			if (in_array(Request::get('field'),[0,1])) $keyword[] = 'order_id';
			if (in_array(Request::get('field'),[0,2])) $keyword[] = 'name';
			if (in_array(Request::get('field'),[0,3])) $keyword[] = 'tel';
			if (in_array(Request::get('field'),[0,4])) $keyword[] = 'province';
			if (in_array(Request::get('field'),[0,5])) $keyword[] = 'city';
			if (in_array(Request::get('field'),[0,6])) $keyword[] = 'county';
			if (in_array(Request::get('field'),[0,7])) $keyword[] = 'town';
			if (in_array(Request::get('field'),[0,8])) $keyword[] = 'address';
			if (in_array(Request::get('field'),[0,9])) $keyword[] = 'post';
			if (in_array(Request::get('field'),[0,10])) $keyword[] = 'email';
			if (in_array(Request::get('field'),[0,11])) $keyword[] = 'ip';
			if (in_array(Request::get('field'),[0,12])) $keyword[] = 'referrer';
			if (in_array(Request::get('field'),[0,13])) $keyword[] = 'logistics_number';
			if (in_array(Request::get('field'),[0,14])) $keyword[] = 'pay_id';
			foreach ($keyword as $value){
				$map['where'] .= '`'.$value.'` LIKE :'.$value.' OR ';
				$map['value'][$value] = '%'.Request::get('keyword').'%';
			}
			$map['where'] = substr($map['where'], 0, -4);
			$map['where'] .= ')';
		}
		if (Request::get('manager_id',-1) != -1){
			$map['where'] .= ' AND `manager_id`=:manager_id';
			$map['value']['manager_id'] = Request::get('manager_id');
		}
		if (Request::get('template_id')){
			$map['where'] .= ' AND `template_id`=:template_id';
			$map['value']['template_id'] = Request::get('template_id');
		}
		if (Request::get('product_id')){
			$map['where'] .= ' AND `product_id`=:product_id';
			$map['value']['product_id'] = Request::get('product_id');
		}
		if (Request::get('pay')){
			$map['where'] .= ' AND `pay`=:pay';
			$map['value']['pay'] = Request::get('pay');
			if (Request::get('pay') == 3){
				if (Request::get('alipay_scene')){
					$map['where'] .= ' AND `pay_scene`=:alipay_scene';
					$map['value']['alipay_scene'] = Request::get('alipay_scene');
				}
			}elseif (Request::get('pay') == 7){
				if (Request::get('wxpay_scene')){
					$map['where'] .= ' AND `pay_scene`=:wxpay_scene';
					$map['value']['wxpay_scene'] = Request::get('wxpay_scene');
				}
			}
		}
		if (Request::get('order_state_id')){
			$map['where'] .= ' AND `order_state_id`=:order_state_id';
			$map['value']['order_state_id'] = Request::get('order_state_id');
		}
		if (Request::get('logistics_id')){
			$map['where'] .= ' AND `logistics_id`=:logistics_id';
			$map['value']['logistics_id'] = Request::get('logistics_id');
		}
		if (Request::get('price1')){
			$map['where'] .= ' AND `price`>=:price1';
			$map['value']['price1'] = Request::get('price1');
		}
		if (Request::get('price2')){
			$map['where'] .= ' AND `price`<=:price2';
			$map['value']['price2'] = Request::get('price2');
		}
		if (Request::get('count1')){
			$map['where'] .= ' AND `count`>=:count1';
			$map['value']['count1'] = Request::get('count1');
		}
		if (Request::get('count2')){
			$map['where'] .= ' AND `count`<=:count2';
			$map['value']['count2'] = Request::get('count2');
		}
		if (Request::get('total1')){
			$map['where'] .= ' AND `price`*`count`>=:total1';
			$map['value']['total1'] = Request::get('total1');
		}
		if (Request::get('total2')){
			$map['where'] .= ' AND `price`*`count`<=:total2';
			$map['value']['total2'] = Request::get('total2');
		}
		if (Request::get('date1')){
			$map['where'] .= ' AND `date`>=:date1';
			$map['value']['date1'] = strtotime(Request::get('date1').' 00:00:00');
		}
		if (Request::get('date2')){
			$map['where'] .= ' AND `date`<=:date2';
			$map['value']['date2'] = strtotime(Request::get('date2').' 23:59:59');
		}
		if (Request::get('pay_date1')){
			$map['where'] .= ' AND `pay_date`>=:pay_date1';
			$map['value']['pay_date1'] = strtotime(Request::get('pay_date1').' 00:00:00');
		}
		if (Request::get('pay_date2')){
			$map['where'] .= ' AND `pay_date`<=:pay_date2';
			$map['value']['pay_date2'] = strtotime(Request::get('pay_date2').' 23:59:59');
		}
		$map['where'] .= ' AND `recycle`='.(Request::controller()=='OrderRecycle' ? 1 : 0);
 		$map['where'] .= ' AND '.$this->managerId();
		return $map;
	}

	//管理权限
	private function managerId(){
		$session = Session::get(Config::get('system.session_key'));
		$sqlWhere = [
			1=>'`manager_id`='.$session['id'],
			2=>'`manager_id` IN ('.$session['id'].',0)',
			3=>'1=1'
		];
		return $session['level']!=1 ? $sqlWhere[$session['order_permit']] : $sqlWhere[3];
	}
}