<?php
namespace app\admin\controller;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use QQWry;
use think\facade\Config;
use think\facade\Route;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;
use app\admin\model;

class Order extends Base{
	private $payScene = [
		0=>[0=>'',1=>'支付宝红包',2=>'支付宝余额',3=>'集分宝',4=>'折扣券',5=>'预付卡',6=>'余额宝',7=>'商家储值卡',8=>'商户优惠券',9=>'商户红包',10=>'蚂蚁花呗'],
		1=>[0=>'',1=>'公众号支付',2=>'扫码支付',3=>'APP支付',4=>'H5支付',5=>'小程序支付']
	];

	public function index(){
		$Order = new model\Order();
		if (Request::isPost()){
			if (Request::post('type') == 0){
				$this->output($Order->all2());
			}else{
				if (Request::post('ids')){
					if (Request::post('type') == 1){
						$this->output($Order->all3());
					}elseif (Request::post('type') == 2){
						if (Config::get('app.demo')) return $this->failed('演示站，数据无法批量删除！');
						$this->checkPermit('Order','recycle2');
						return $Order->recycle() ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单已被批量移入回收站！') : $this->failed('订单批量移入回收站失败！');
					}elseif (Request::post('type') == 3){
						$this->checkPermit('Recycle','recover2');
						return $Order->recover() ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单批量还原成功！') : $this->failed('订单批量还原失败！');
					}elseif (Request::post('type') == 4){
						if (Config::get('app.demo')) return $this->failed('演示站，数据无法批量删除！');
						$this->checkPermit('Recycle','remove2');
						return $Order->remove() ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单批量删除成功！') : $this->failed('订单批量删除失败！');
					}elseif (Request::post('type') == 5){
						$this->checkPermit(Request::controller(),'state');
						return $Order->state() ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单状态修改成功！') : $this->failed('订单状态修改失败！');
					}
				}else{
					return $this->failed('您未勾选任何订单！');
				}
			}
		}
		$object = $Order->all($this->page($Order->total()));
		if ($object){
			$Template = new model\Template();
			$Manager = new model\Manager();
			$Product = new model\Product();
			$Logistics = new model\Logistics();
			$Ostate = new model\Ostate();
			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			foreach ($object as $key=>$value){
				if ($value['uid']){
					$object2 = $Manager->one($value['uid']);
					$object[$key]['admin'] = $object2 ? $object2['name'] : '此管理员已被删除';
				}else{
					$object[$key]['admin'] = '前台下单';
				}
				$object3 = $Product->one($value['pid']);
				$object[$key]['pro'] = $object3 ? '<span style="color:'.$object3['color'].';">'.$object3['name'].'（'.$object3['price'].'元）</span>' : '此产品已被删除';
				$object[$key]['total'] = number_format($value['price']*$value['count'],2,'.','');
				$object[$key]['address'] = $value['province'].' '.$value['city'].' '.$value['county'].' '.$value['address'];
				$object4 = $Logistics->one($value['lid']);
				$object[$key]['loginame'] = $object4 ? $object4['name'] : '';
				$object[$key]['logicode'] = $object4 ? $object4['code'] : '';
				$object5 = $Template->one($value['tid']);
				$object[$key]['template'] = $object5 ? $object5['name'] : '此模板已被删除';
				$object6 = $Ostate->one($value['state']);
				$object[$key]['state'] = $object6 ? '<span style="color:'.$object6['color'].';">'.$object6['name'].'</span>' : '此状态已被删除';
				$object[$key]['pay'] = Config::get('app.pay1')[$value['pay']];
				if ($value['pay'] == 3){
					$object[$key]['pay_scene'] = $this->payScene[0][$value['pay_scene']];
				}elseif ($value['pay'] == 7){
					$object[$key]['pay_scene'] = $this->payScene[1][$value['pay_scene']];
				}else{
					$object[$key]['pay_scene'] = '';
				}
				$object[$key]['ipaddr'] = $QQWry->getAddr($value['ip']);
			}
		}
		$this->field(Request::get('field'));
		$this->manager(Request::get('uid',-1));
		$this->product(Request::get('pid'));
		$this->logistics(Request::get('lid'));
		$this->template(Request::get('tid'));
		$this->ostate(Request::get('state'));
		$this->pay(Request::get('pay'));
		$this->alipayScene(Request::get('alipay_scene'));
		$this->wxpayScene(Request::get('wxpay_scene'));
		View::assign(['All'=>$object]);
		return $this->view('order/index');
	}
	
	public function add(){
		if (Request::isPost()){
			$Order = new model\Order();
			$object = $Order->add();
			if (is_numeric($object)){
				return $object>0 ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单添加成功！') : $this->failed('订单添加失败！');
			}else{
				return $this->failed($object);
			}
		}
		$this->product(0,1);
		$this->logistics(0,1);
		$this->template(0,1);
		$this->pay();
		$this->ostate2();
		View::assign(['Pay'=>Config::get('app.pay1')]);
		return $this->view();
	}
	
	public function multi(){
		if (Request::isPost()){
			$Order = new model\Order();
			$object = $Order->multi();
			return is_numeric($object) ? $this->success(Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'物流单号修改成功！') : $this->failed($object);
		}
		return $this->view();
	}
	
	public function update(){
		if (Request::get('id')){
			$Order = new model\Order();
			if (Request::isPost()){
				$object = $Order->modify();
				if (is_numeric($object)){
					if (Request::post('sendmail') == 1){
						$this->sendmail(Config::get('system.mail_pay_subject'),Config::get('system.mail_pay_content'));
					}elseif (Request::post('sendmail') == 2){
						$this->sendmail(Config::get('system.mail_send_subject'),Config::get('system.mail_send_content'));
					}
					return $this->success(Request::get('from')==1 ? Route::buildUrl('/'.parse_name(Request::controller()).'/detail',['id'=>Request::get('id')]) : Route::buildUrl('/'.parse_name(Request::controller()).'/index'),'订单修改成功！');
				}else{
					return $this->failed($object);
				}
			}
			$object = $Order->one();
			if (!$object) return $this->failed('不存在此订单，或没有此订单的管理权限！');
			$this->product($object['pid']);
			$this->logistics($object['lid'],1);
			$this->template($object['tid'],1);
			$this->pay($object['pay']);
			$this->ostate2($object['state']);
			$object['payUrl'] = $this->payUrl($object['oid']);
			View::assign(['One'=>$object,'Pay'=>Config::get('app.pay1')]);
			return $this->view('order/update');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function detail(){
		if (Request::get('id')){
			$Order = new model\Order();
			$object = $Order->one();
			if (!$object) return $this->failed('不存在此订单，或没有此订单的管理权限！');
			
			if ($object['uid']){
				$Manager = new model\Manager();
				$object2 = $Manager->one($object['uid']);
				$object['manager'] = $object2 ? $object2['name'] : '此管理员已被删除';
			}else{
				$object['manager'] = '前台下单';
			}
			
			$Product = new model\Product();
			$object3 = $Product->one($object['pid']);
			$object['product'] = $object3 ? '<span style="color:'.$object3['color'].';">'.$object3['name'].'（'.$object3['price'].'元）</span>' : '此产品已被删除';
			
			$object['total'] = number_format($object['price']*$object['count'],2,'.','');
			
			if ($object['lid']){
				$Logistics = new model\Logistics();
				$object4 = $Logistics->one($object['lid']);
				$object['logistics_name'] = $object4 ? $object4['name'] : '此物流已被删除';
				$object['logistics_code'] = $object4 ? $object4['code'] : '';
			}else{
				$object['logistics_name'] = $object['logistics_code'] = '';
			}
			
			$Template = new model\Template();
			$object5 = $Template->one($object['tid']);
			$object['template'] = $object5 ? $object5['name'] : '此模板已被删除';
			
			$Ostate = new model\Ostate();
			$object6 = $Ostate->one($object['state']);
			$object['state'] = $object6 ? '<span style="color:'.$object6['color'].';">'.$object6['name'].'</span>' : '此状态已被删除';

			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			$object['ip'] = $object['ip'].' '.$QQWry->getAddr($object['ip']);

			if ($object['pay'] == 3){
				$object['pay_scene'] = $this->payScene[0][$object['pay_scene']];
			}elseif ($object['pay'] == 7){
				$object['pay_scene'] = $this->payScene[1][$object['pay_scene']];
			}else{
				$object['pay_scene'] = '';
			}
			$object['pay'] = Config::get('app.pay1')[$object['pay']];
			$object['payUrl'] = $this->payUrl($object['oid']);
			
			View::assign(['One'=>$object]);
			return $this->view('order/detail');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	public function recycle(){
		if (Request::get('id')){
			$Order = new model\Order();
			if (Request::isPost()) return $Order->recycle() ? $this->success(Request::post('prev'),'订单已被移入回收站！') : $this->failed('订单移入回收站失败！');
			if (!$Order->one()) return $this->failed('不存在此订单，或没有此订单的管理权限！');
			return $this->confirm('您真的要将这个订单移入回收站么？');
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	private function output($object){
		$this->checkPermit(Request::controller(),'output');
		$output = '"订单号","下单管理员","下单模板","姓名","订购产品","成交单价","订购数量","成交总价","联系电话","详细地址","邮政编码","备注","电子邮箱","下单IP","下单来路","下单时间","支付状态","支付订单号","支付场景","支付时间","订单状态","物流公司","物流编号",';
		if ($object){
			$Template = new model\Template();
			$Manager = new model\Manager();
			$Product = new model\Product();
			$Logistics = new model\Logistics();
			$Ostate = new model\Ostate();
			include ROOT_PATH.'/extend/QQWry.class.php';
			$QQWry = QQWry::getInstance();
			foreach ($object as $value){
				if ($value['uid']){
					$object2 = $Manager->one($value['uid']);
					$manager = $object2 ? $object2['name'] : '此管理员已被删除';
				}else{
					$manager = '前台下单';
				}
				$object3 = $Product->one($value['pid']);
				if ($value['lid']){
					$object4 = $Logistics->one($value['lid']);
					$loginame = $object4 ? $object4['name'] : '此物流已被删除';
				}else{
					$loginame = '';
				}
				$object5 = $Template->one($value['tid']);
				$object6 = $Ostate->one($value['state']);
				if ($value['pay'] == 3){
					$pay_scene = $this->payScene[0][$value['pay_scene']];
				}elseif ($value['pay'] == 7){
					$pay_scene = $this->payScene[1][$value['pay_scene']];
				}else{
					$pay_scene = '';
				}
				$output .= "\r\n".'"'.$value['oid'].'","'.$manager.'","'.($object5 ? $object5['name'] : '此模板已被删除').'","'.$value['name'].'","'.($object3 ? $object3['name'].'（'.$object3['price'].'元）' : '此产品已被删除').'","'.$value['price'].'元","'.$value['count'].'","'.number_format($value['price']*$value['count'],2,'.','').'元","\''.$value['tel'].'","'.$value['province'].' '.$value['city'].' '.$value['county'].' '.$value['address'].'","\''.$value['post'].'","'.$value['note'].'","'.$value['email'].'","'.($value['ip'] ? $value['ip'].' -- '.$QQWry->getAddr($value['ip']) : '').'","'.htmlspecialchars_decode($value['referrer']).'","'.dateFormat($value['date']).'","'.Config::get('app.pay1')[$value['pay']].'","\''.$value['pay_oid'].'","'.$pay_scene.'","'.($value['pay_date'] ? dateFormat($value['pay_date']) : '').'","'.($object6 ? $object6['name'] : '此状态已被删除').'","'.$loginame.'","'.$value['logistics_id'].'",';
			}
		}
		$output = mb_convert_encoding($output,'GBK','UTF-8');
		downFile($output,'order_'.time().'.csv');
		exit;
	}

	public function pay($id=0){
		$html = '';
		foreach (Config::get('app.pay1') as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').'>'.$value.'</option>';
		}
		View::assign(['Pay'=>$html]);
	}

	public function alipayScene($id=0){
		$html = '';
		unset($this->payScene[0][0]);
		foreach ($this->payScene[0] as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').'>'.$value.'</option>';
		}
		View::assign(['AlipayScene'=>$html]);
	}

	public function wxpayScene($id=0){
		$html = '';
		unset($this->payScene[1][0]);
		foreach ($this->payScene[1] as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').'>'.$value.'</option>';
		}
		View::assign(['WxpayScene'=>$html]);
	}
	
	public function field($id=0){
		$html = '';
		foreach (['所有字段','订单号','姓名','联系电话','省份','城市','区/县','乡镇/街道','详细地址','邮政编码','电子邮箱','IP','下单来路','物流编号','支付订单号'] as $key=>$value){
			$html .= '<option value="'.$key.'" '.($key==$id ? 'selected' : '').'>'.$value.'</option>';
		}
		View::assign(['Field'=>$html]);
	}
	
	public function manager($id=0){
		$session = Session::get(Config::get('system.session_key'));
		$Manager = new model\Manager();
		$object = $Manager->all2();
		$html = '';
		if ($session['level']==1 || ($session['level']==2 && $session['order_permit']!=1)) $html .= '<option value="0" '.($id==0 ? 'selected' : '').'>前台下单</option>';
		if ($object){
			foreach ($object as $value){
				$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
			}
		}
		View::assign(['Manager'=>$html]);
	}
	
	public function product($id=0,$flag=0){
		$html = '';
		$Psort = new model\Psort();
		$object = $Psort->all2();
		if ($object){
			$Product = new model\Product();
			foreach ($object as $value){
				$html .= '<optgroup label="'.$value['name'].'" style="color:'.$value['color'].';">';
				$object2 = $Product->all2($value['id']);
				if ($object2){
					foreach ($object2 as $v){
						if ($id == 0){
							$html .= '<option value="'.$v['id'].'" '.($v['selected']&&$flag ? 'selected' : '').' style="color:'.$v['color'].';" price="'.$v['price'].'">└—'.$v['name'].'（'.$v['price'].'元）</option>';
						}else{
							$html .= '<option value="'.$v['id'].'" '.($v['id']==$id ? 'selected' : '').' style="color:'.$v['color'].';" price="'.$v['price'].'">└—'.$v['name'].'（'.$v['price'].'元）</option>';
						}
					}
				}
				$html .= '</optgroup>';
			}
		}
		View::assign(['Product'=>$html]);
	}
	
	public function logistics($id=0,$flag=0){
		$html = $flag ? '<option value="0">请选择物流公司</option>' : '';
		$Logistics = new model\Logistics();
		$object = $Logistics->all2();
		foreach ($object as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
		}
		View::assign(['Logistics'=>$html]);
	}
	
	public function template($id=0,$flag=0){
		$html = '';
		$Template = new model\Template();
		$object = $Template->all2();
		foreach ($object as $value){
			if ($id == 0){
				$html .= '<option value="'.$value['id'].'" '.($value['selected']&&$flag ? 'selected' : '').'>'.$value['name'].'</option>';
			}else{
				$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').'>'.$value['name'].'</option>';
			}
		}
		View::assign(['Template'=>$html]);
	}
	
	public function ostate($id=0){
		$html = '';
		$Ostate = new model\Ostate();
		$object = $Ostate->all2();
		foreach ($object as $value){
			$html .= '<option value="'.$value['id'].'" '.($value['id']==$id ? 'selected' : '').' style="color:'.$value['color'].';">'.$value['name'].'</option>';
		}
		View::assign(['Ostate'=>$html]);
	}
	
	private function ostate2($id=0){
		$html = '';
		$Ostate = new model\Ostate();
		$object = $Ostate->all2();
		foreach ($object as $value){
			if ($id == 0){
				$html .= '<label style="color:'.$value['color'].';"><input type="radio" name="state" value="'.$value['id'].'" '.($value['selected'] ? 'checked' : '').'>'.$value['name'].'</label>&nbsp;';
			}else{
				$html .= '<label style="color:'.$value['color'].';"><input type="radio" name="state" value="'.$value['id'].'" '.($value['id']==$id ? 'checked' : '').'>'.$value['name'].'</label>&nbsp;';
			}
		}
		View::assign(['Ostate'=>$html]);
	}
	
	private function payUrl($oid){
		return [
			'alipay'=>Config::get('app.web_url').Config::get('system.index_php').'pay/alipay/oid/'.$oid.'.html',
			'wxpay'=>Config::get('app.web_url').Config::get('system.index_php').'pay/wxpay/oid/'.$oid.'.html'
		];
	}
	
	private function sendmail($subject,$content){
		$Smtp = new model\Smtp();
		if ($Smtp->total() > 0){
			$object = $Smtp->one2();
			if ($object){
				try{
					include ROOT_PATH.'/extend/PHPMailer/SMTP.php';
					include ROOT_PATH.'/extend/PHPMailer/PHPMailer.php';
					$PHPMailer = new PHPMailer();
					$PHPMailer->CharSet = 'UTF-8';
					$PHPMailer->IsSMTP();
					$PHPMailer->SMTPAuth = true;
					$PHPMailer->Port = $object[0]['port'];
					$PHPMailer->Host = $object[0]['smtp'];
					$PHPMailer->Username = $object[0]['user'];
					$PHPMailer->Password = $object[0]['pass'];
					$PHPMailer->From = $object[0]['email'];
					$PHPMailer->FromName = $object[0]['email'];
					foreach (explode(',',Request::post('email')) as $value){
						$PHPMailer->AddAddress($value,$PHPMailer->FromName);
					}
					$PHPMailer->IsHTML(true);
					$PHPMailer->Subject = $this->mail($subject);
					$PHPMailer->Body = $this->mail($content);
					$PHPMailer->Send();
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
		}
	}
	
	private function mail($content){
		include ROOT_PATH.'/extend/QQWry.class.php';
		$QQWry = QQWry::getInstance();
		
		$Product = new model\Product();
		$object = $Product->one(Request::post('pid'));
		
		$Logistics = new model\Logistics();
		$object2 = $Logistics->one(Request::post('lid'));
		
		$Ostate = new model\Ostate();
   		$object3 = $Ostate->one(Request::post('state'));

		$payScene = '';
		if (Request::post('pay') == 3){
			$payScene = $this->payScene[0][Request::post('pay_scene')];
		}elseif (Request::post('pay') == 7){
			$payScene = $this->payScene[1][Request::post('pay_scene')];
		}
		
		return str_replace([
			'{oid}',
			'{proname}',
			'{proprice}',
			'{procount}',
			'{prototal}',
			'{name}',
			'{tel}',
			'{province}',
			'{city}',
			'{county}',
			'{town}',
			'{address}',
			'{post}',
			'{note}',
			'{email}',
			'{ip}',
			'{referrer}',
			'{alipay}',
			'{wxpay}',
			'{pay}',
			'{pay_oid}',
			'{pay_scene}',
			'{pay_date}',
			'{state}',
			'{loginame}',
			'{logiid}',
			'{logiurl}',
			'{date}'
		],[
			Request::post('oid'),
			$object ? $object['name'] : '',
			$object ? $object['price'] : '',
			Request::post('count'),
			$object ? number_format($object['price']*Request::post('count'),2,'.','') : '0.00',
			Request::post('name'),
			Request::post('tel'),
			Request::post('province2'),
			Request::post('city2'),
			Request::post('county2'),
			Request::post('town2'),
			Request::post('address'),
			Request::post('post'),
			Request::post('note'),
			Request::post('email'),
			Request::post('ip').' '.$QQWry->getAddr(Request::post('ip')),
			Request::post('referrer') ? '<a href="'.Request::post('referrer').'" target="_blank">'.Request::post('referrer').'</a>' : '直接进入',
			Config::get('app.web_url').Config::get('system.index_php').'pay/alipay/oid/'.Request::post('oid').'.html',
			Config::get('app.web_url').Config::get('system.index_php').'pay/wxpay/oid/'.Request::post('oid').'.html',
			Config::get('app.pay1')[Request::post('pay')],
			Request::post('pay_oid'),
			$payScene,
			Request::post('pay_date') ? dateFormat(Request::post('pay_date')) : '',
			$object3 ? '<span style="color:'.$object3['color'].';">'.$object3['name'].'</span>' : '',
			$object2 ? $object2['name'] : '',
			Request::post('logistics_id'),
			'http://www.kuaidi100.com/chaxun?com='.($object2 ? $object2['code'] : '').'&nu='.Request::post('logistics_id'),
			dateFormat(Request::post('date'))
		],$content);
	}
}