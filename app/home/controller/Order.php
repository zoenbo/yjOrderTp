<?php
namespace app\home\controller;

use QQWry;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\home\model;

class Order extends Base{
	public function index(){
	}
	
	public function search(){
		if (Config::get('system.order_search') == '0') return $this->failed('本站未开启查单服务！');
		$Template = new model\Template();
		if (Config::get('system.order_search_step') == '0'){
			$object = $Template->one(Request::get('template_id'));
			if (!$object) return $this->failed('不存在此下单模板！');
			if ($object['is_show_search'] == 0) return $this->failed('此下单模板未开启查单服务！');
		}
		if (Request::get('keyword') == '') return $this->failed('查询关键词不得为空！');
		if (!in_array(Request::get('field'),[1,2,3])) return $this->failed('查询参数有误！');
		
		$Order = new model\Order();
		$object = $Order->all();
		if ($object){
			$Manager = new model\Manager();
			$Product = new model\Product();
			$Logistics = new model\Logistics();
			$OrderState = new model\OrderState();
			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			foreach ($object as $key=>$value){
				if ($value['manager_id']){
					$object2 = $Manager->one($value['manager_id']);
					$object[$key]['manager'] = $object2 ? $object2['name'] : '此管理员已被删除';
				}else{
					$object[$key]['manager'] = '前台下单';
				}
				
				$object3 = $Product->one($value['product_id']);
				$object[$key]['product'] = $object3 ? '<span style="color:'.$object3['color'].';">'.$object3['name'].'（'.$object3['price'].'元）</span>' : '此产品已被删除';
				$object[$key]['total'] = number_format($value['price']*$value['count'],2,'.','');
				
				if ($value['logistics_id']){
					$object4 = $Logistics->one($value['logistics_id']);
					$object[$key]['logistics_name'] = $object4 ? $object4['name'] : '此物流已被删除';
					$object[$key]['logistics_code'] = $object4 ? $object4['code'] : '';
				}else{
					$object[$key]['logistics_name'] = $object[$key]['logistics_code'] = '';
				}
				
				$object5 = $Template->one($value['template_id']);
				$object[$key]['template'] = $object5 ? $object5['name'] : '此模板已被删除';
				
				$object6 = $OrderState->one($value['order_state_id']);
				$object[$key]['order_state'] = $object6 ? '<span style="color:'.$object6['color'].';">'.$object6['name'].'</span>' : '此状态已被删除';
				
				$object[$key]['ip'] = $value['ip'].' '.$QQWry->getAddr($value['ip']);

				$pay = Config::get('app.pay1');
				$object[$key]['pay'] = $pay[$value['pay']];
				$object[$key]['payUrl'] = $this->payUrl($value['order_id']);
			}
			View::assign([
				'All'=>$object,
				'Total'=>count($object)
			]);
			return $this->view();
		}else{
			return $this->failed('抱歉，没有查询到任何结果！');
		}
	}
	
	private function payUrl($order_id){
		return [
			'alipay'=>Config::get('app.web_url').Config::get('system.index_php').'pay/alipay/oid/'.$order_id.'.html',
			'wxpay'=>Config::get('app.web_url').Config::get('system.index_php').'pay/wxpay/oid/'.$order_id.'.html'
		];
	}
}