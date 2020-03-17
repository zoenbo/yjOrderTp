<?php
namespace app\admin\controller;

use think\facade\Route;
use think\facade\Request;
use think\facade\View;
use app\admin\model;

class OrderStatistic extends Base{
	public function index(){
		$Order = new model\Order();

		$data = [];
		//今天
		$data['day1']['time'] = date('Y-m-d');
		$data['day1']['data'] = $this->diyTime($Order->diyTime($data['day1']['time'],$data['day1']['time']));
		//昨天
		$data['day2']['time'] = date('Y-m-d',strtotime('-1 day'));
		$data['day2']['data'] = $this->diyTime($Order->diyTime($data['day2']['time'],$data['day2']['time']));
		//本周
		$data['week1']['time1'] = date('Y-m-d',time()-((date('w'))*86400));
		$data['week1']['time2'] = date('Y-m-d',time()+((6-date('w'))*86400));
		$data['week1']['data'] = $this->diyTime($Order->diyTime($data['week1']['time1'],$data['week1']['time2']));
		//最近一周
		$data['week2']['time1'] = date('Y-m-d',time()-518400);
		$data['week2']['time2'] = date('Y-m-d');
		$data['week2']['data'] = $this->diyTime($Order->diyTime($data['week2']['time1'],$data['week2']['time2']));
		//本月
		$data['month1']['time1'] = date('Y-m').'-01';
		$data['month1']['time2'] = date('Y-m-t');
		$data['month1']['data'] = $this->diyTime($Order->diyTime($data['month1']['time1'],$data['month1']['time2']));
		//最近一月
		$data['month2']['time1'] = date('Y-m-d',time()-2592000);
		$data['month2']['time2'] = date('Y-m-d');
		$data['month2']['data'] = $this->diyTime($Order->diyTime($data['month2']['time1'],$data['month2']['time2']));
		//今年
		$data['year1']['time1'] = date('Y').'-01-01';
		$data['year1']['time2'] = date('Y').'-12-31';
		$data['year1']['data'] = $this->diyTime($Order->diyTime($data['year1']['time1'],$data['year1']['time2']));
		//最近一年
		$data['year2']['time1'] = date('Y-m-d',time()-31449600);
		$data['year2']['time2'] = date('Y-m-d');
		$data['year2']['data'] = $this->diyTime($Order->diyTime($data['year2']['time1'],$data['year2']['time2']));
		//总计
		$old = $Order->older();
		$new = $Order->newer();
		$data['add']['time1'] = date('Y-m-d',$old['date']);
		$data['add']['time2'] = date('Y-m-d',$new['date']);
		$data['add']['data'] = $this->diyTime($Order->diyTime($data['add']['time1'],$data['add']['time2']));

		$OrderController = new Order();
		$OrderController->field(Request::get('field'));
		$OrderController->manager(Request::get('manager_id',-1));
		$OrderController->product(Request::get('product_id'));
		$OrderController->logistics(Request::get('logistics_id'));
		$OrderController->template(Request::get('template_id'));
		$OrderController->orderState(Request::get('order_state_id'));
		$OrderController->pay(Request::get('pay'));
		$OrderController->alipayScene(Request::get('alipay_scene'));
		$OrderController->wxpayScene(Request::get('wxpay_scene'));
		
		View::assign(['Data'=>$data]);
		return $this->view();
	}

	public function day(){
		return $this->dayMonthYear('%Y年%m月%d日');
	}

	public function month(){
		return $this->dayMonthYear('%Y年%m月');
	}

	public function year(){
		return $this->dayMonthYear('%Y年');
	}

	private function diyTime($object){
		$data = ['count1'=>0,'count2'=>0,'count3'=>0,'count4'=>0,'count5'=>0,'count6'=>0,'sum1'=>0,'sum2'=>0,'sum3'=>0,'sum4'=>0,'sum5'=>0,'sum6'=>0];
		foreach ($object as $value){
			$data['count1'] += $value['count1'];
			$data['count2'] += $value['count2'];
			$data['count3'] += $value['count3'];
			$data['count4'] += $value['count4'];
			$data['sum1'] += $value['sum1'];
			$data['sum2'] += $value['sum2'];
			$data['sum3'] += $value['sum3'];
			$data['sum4'] += $value['sum4'];
			$data['sum1'] = number_format($data['sum1'],2,'.','');
			$data['sum2'] = number_format($data['sum2'],2,'.','');
			$data['sum3'] = number_format($data['sum3'],2,'.','');
			$data['sum4'] = number_format($data['sum4'],2,'.','');
			$data['count5'] = $data['count1'] + $data['count2'] + $data['count3'] + $data['count4'];
			$data['count6'] = $data['count1'] + $data['count2'] + $data['count4'];
			$data['sum5'] = number_format($data['sum1'] + $data['sum2'] + $data['sum3'] + $data['sum4'],2,'.','');
			$data['sum6'] = number_format($data['sum1'] + $data['sum2'] + $data['sum4'],2,'.','');
		}
		return $data;
	}

	private function dayMonthYear($time){
		$Order = new model\Order();

		if (Request::isPost()){
			$this->checkPermit('Statistic','output');
			$object = $Order->dayMonthYear($time);
			$output = '"时间","未发货数","已发货数","已取消数","已签收数","未发货金额","已发货金额","已取消金额","已签收金额","订单数","成交数","订单金额","成交金额",';
			if ($object){
				$count1 = $count2 = $count3 = $count4 = $count5 = $count6 = $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
				foreach ($object as $value){
					$count1 += $value['count1'];
					$count2 += $value['count2'];
					$count3 += $value['count3'];
					$count4 += $value['count4'];
					$sum1 += $value['sum1'];
					$sum2 += $value['sum2'];
					$sum3 += $value['sum3'];
					$sum4 += $value['sum4'];
					$count5 = $count1 + $count2 + $count3 + $count4;
					$count6 = $count1 + $count2 + $count4;
					$sum5 = $sum1 + $sum2 + $sum3 + $sum4;
					$sum6 = $sum1 + $sum2 + $sum4;
					$output .= "\r\n".'"'.$value['time'].'","'.$count1.'","'.$count2.'","'.$count3.'","'.$count4.'","'.$sum1.'","'.$sum2.'","'.$sum3.'","'.$sum4.'","'.$count5.'","'.$count6.'","'.$sum5.'","'.$sum6.'",';
					$count1 = $count2 = $count3 = $count4 = $count5 = $count6 = $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
				}
			}
			$output = mb_convert_encoding($output,'GBK','UTF-8');
			downFile($output,mb_convert_encoding('订单统计报表_'.time().'.csv','GBK','UTF-8'));
			exit;
		}

		$data = ['count1'=>0,'count2'=>0,'count3'=>0,'count4'=>0,'count5'=>0,'count6'=>0,'sum1'=>0,'sum2'=>0,'sum3'=>0,'sum4'=>0,'sum5'=>0,'sum6'=>0];
		foreach ($Order->dayMonthYear($time) as $value){
			$data['count1'] += $value['count1'];
			$data['count2'] += $value['count2'];
			$data['count3'] += $value['count3'];
			$data['count4'] += $value['count4'];
			$data['sum1'] += $value['sum1'];
			$data['sum2'] += $value['sum2'];
			$data['sum3'] += $value['sum3'];
			$data['sum4'] += $value['sum4'];
			$data['sum1'] = number_format($data['sum1'],2,'.','');
			$data['sum2'] = number_format($data['sum2'],2,'.','');
			$data['sum3'] = number_format($data['sum3'],2,'.','');
			$data['sum4'] = number_format($data['sum4'],2,'.','');
			$data['count5'] = $data['count1'] + $data['count2'] + $data['count3'] + $data['count4'];
			$data['count6'] = $data['count1'] + $data['count2'] + $data['count4'];
			$data['sum5'] = number_format($data['sum1'] + $data['sum2'] + $data['sum3'] + $data['sum4'],2,'.','');
			$data['sum6'] = number_format($data['sum1'] + $data['sum2'] + $data['sum4'],2,'.','');
		}

		$object = $Order->dayMonthYear($time,$this->page(count($Order->dayMonthYear($time))));
		foreach ($object as $key=>$value){
			$object[$key]['count5'] = $value['count1'] + $value['count2'] + $value['count3'] + $value['count4'];
			$object[$key]['count6'] = $value['count1'] + $value['count2'] + $value['count4'];
			$object[$key]['sum5'] = number_format($value['sum1'] + $value['sum2'] + $value['sum3'] + $value['sum4'],2,'.','');
			$object[$key]['sum6'] = number_format($value['sum1'] + $value['sum2'] + $value['sum4'],2,'.','');
		}

		$param = Route::buildUrl('/'.parse_name(Request::controller()).'/'.parse_name(Request::action())).'?';
		foreach (Request::get('') as $key=>$value){
			if (!in_array($key,['page','order'])) $param .= '&'.$key.'='.$value;
		}
		
		$OrderController = new Order();
		$OrderController->field(Request::get('field'));
		$OrderController->manager(Request::get('manager_id',-1));
		$OrderController->product(Request::get('product_id'));
		$OrderController->logistics(Request::get('logistics_id'));
		$OrderController->template(Request::get('template_id'));
		$OrderController->orderState(Request::get('order_state_id'));
		$OrderController->pay(Request::get('pay'));
		$OrderController->alipayScene(Request::get('alipay_scene'));
		$OrderController->wxpayScene(Request::get('wxpay_scene'));

		View::assign([
			'All'=>$object,
			'Data'=>$data,
			'Param'=>$param
		]);
		return $this->view();
	}
}