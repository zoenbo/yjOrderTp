<?php
namespace app\home\controller;

use alipay\common\pay\service\AlipayTradeService;
use alipay\page\aop\request\AlipayTradePagePayRequest;
use alipay\page\pay\buildermodel\AlipayTradePagePayContentBuilder;
use alipay\wap\aop\request\AlipayTradeWapPayRequest;
use alipay\wap\pay\buildermodel\AlipayTradeWapPayContentBuilder;
use Exception;
use JsApiPay;
use Mobile_Detect;
use PayNotifyCallBack;
use QRcode;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\home\model;
use WxPayApi;
use WxPayUnifiedOrder;

class Pay extends Base{
	private $paid = [3,5,7];
	private $payScene = [
		0=>['COUPON'=>1,'ALIPAYACCOUNT'=>2,'POINT'=>3,'DISCOUNT'=>4,'PCARD'=>5,'FINANCEACCOUNT'=>6,'MCARD'=>7,'MDISCOUNT'=>8,'MCOUPON'=>9,'PCREDIT'=>10],
		1=>['JSAPI'=>1,'NATIVE'=>2,'APP'=>3,'MWEB'=>4]
	];
	
	public function alipay(){
		if (Request::param('oid')){
			$Order = new model\Order();
			$object = $Order->one();
			if (!$object) return $this->failed('不存在此订单！');
			if (in_array($object['pay'],$this->paid)) return $this->failed('此订单已支付！');
			
			if (strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')) return $this->view();
			
			$Product = new model\Product();
			$object2 = $Product->one($object['pid']);
			include ROOT_PATH.'/extend/pay/alipay/autoload.php';
			include ROOT_PATH.'/extend/Mobile_Detect.php';
			$config = $this->alipayConfig();
			$MobileDetect = new Mobile_Detect();
			echo '<!doctype html><html lang="zh-cn"><head><meta charset="utf-8"><title></title></head><body>';
			if ($MobileDetect->isMobile() || $MobileDetect->isTablet()){
				$AlipayTradeRequest = new AlipayTradeWapPayRequest();
				$AlipayTradeContentBuilder = new AlipayTradeWapPayContentBuilder();
			}else{
				$AlipayTradeRequest = new AlipayTradePagePayRequest();
				$AlipayTradeContentBuilder = new AlipayTradePagePayContentBuilder();
			}
			$AlipayTradeContentBuilder->setBody('');
			$AlipayTradeContentBuilder->setSubject($object2 ? $object2['name'] : '');
			$AlipayTradeContentBuilder->setOutTradeNo(time().'_'.Request::param('oid'));
			$AlipayTradeContentBuilder->setTotalAmount($object['price']*$object['count']);
			try {
				$AlipayTradeService = new AlipayTradeService($config);
				echo $AlipayTradeService->pay($AlipayTradeRequest,$AlipayTradeContentBuilder,$config['return_url'],$config['notify_url']);
			} catch (Exception $e) {
				echo $e;
			}
			echo '</body></html>';
		}else{
			return $this->failed('非法操作！');
		}
		return '';
	}

	public function alipayReturn(){
		include ROOT_PATH.'/extend/pay/alipay/autoload.php';
		$alipayTradeService = null;
		try {
			$alipayTradeService = new AlipayTradeService($this->alipayConfig());
		} catch (Exception $e) {
		}
		$result = $alipayTradeService->check(Request::param(''));
		if ($result){
			if (Config::get('system.order_db') == '1'){
				$Order = new model\Order();
				$oid = explode('_',Request::param('out_trade_no'));
				$object = $Order->one($oid[1]);
				$Template = new model\Template();
				$object2 = $Template->one($object['tid']);
				return $this->success(NULL,str_replace('{oid}',$oid[1],$object2['success2']),0,2);
			}
		}else{
			return $this->failed('很遗憾，订单支付失败，如果您确定已经付款，请联系客服解决！',0,2);
		}
		return '';
	}
	
	public function alipayNotify(){
		include ROOT_PATH.'/extend/pay/alipay/autoload.php';
		$alipayTradeService = null;
		try {
			$alipayTradeService = new AlipayTradeService($this->alipayConfig());
		} catch (Exception $e) {
		}
		$result = $alipayTradeService->check($_POST);
		if ($result){
			if (Config::get('system.order_db') == '1'){
				$Order = new model\Order();
				$oid = explode('_',Request::post('out_trade_no'));
				$Order->modify($oid[1],3,Request::post('trade_no'),$this->payScene[0][json_decode(Request::post('fund_bill_list'))[0]->fundChannel],strtotime(Request::post('gmt_payment')));
				echo 'success';
			}
		}else{
			echo 'fail';
		}
	}

	private function alipayConfig(){
		return [
			'alipay_public_key'=>Config::get('system.alipay_public_key'),
			'app_id'=>Config::get('system.alipay_appid'),
			'charset'=>'UTF-8',
			'gatewayUrl'=>'https://openapi.alipay.com/gateway.do',
			'merchant_private_key'=>Config::get('system.alipay_merchant_private_key'),
			'notify_url'=>Config::get('app.web_url').Config::get('system.index_php').'pay/alipayNotify',
			'return_url'=>Config::get('app.web_url').Config::get('system.index_php').'pay/alipayReturn',
			'sign_type'=>'RSA2'
		];
	}

	public function wxpay(){
		if (Request::param('oid')){
			$Order = new model\Order();
			$object = $Order->one();
			if (!$object) return $this->failed('不存在此订单！');
			if (in_array($object['pay'],$this->paid)) return $this->failed('此订单已支付！');
			$Product = new model\Product();
			$object2 = $Product->one($object['pid']);

			include ROOT_PATH.'/extend/Mobile_Detect.php';
			$MobileDetect = new Mobile_Detect();
			if ((!$MobileDetect->isMobile()&&!$MobileDetect->isTablet()) || (strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')&&strstr($_SERVER['HTTP_USER_AGENT'],'Windows'))){
				$wxPayUnifiedOrder = $this->wxPayUnifiedOrder($object,$object2);
				$wxPayUnifiedOrder->SetTrade_type('NATIVE');
				$wxPayUnifiedOrder->SetProduct_id($object['pid']);
				try {
					View::assign([
						'Url'=>urlencode(WxPayApi::unifiedOrder($wxPayUnifiedOrder)['code_url']),
						'jsApiParameters'=>''
					]);
				} catch (Exception $e) {
				}
				return $this->view();
			}elseif (strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
				$wxPayUnifiedOrder = $this->wxPayUnifiedOrder($object,$object2);
				$wxPayUnifiedOrder->SetTrade_type('JSAPI');
				include ROOT_PATH.'/extend/pay/wxpay/WxPay.JsApiPay.php';
				$jsApiPay = new JsApiPay();
				$wxPayUnifiedOrder->SetOpenid($jsApiPay->GetOpenid());
				try {
					View::assign([
						'Url'=>'',
						'jsApiParameters'=>$jsApiPay->GetJsApiParameters(WxPayApi::unifiedOrder($wxPayUnifiedOrder))
					]);
				} catch (Exception $e){
				}
				return $this->view();
			}else{
				$wxPayUnifiedOrder = $this->wxPayUnifiedOrder($object,$object2);
				$wxPayUnifiedOrder->SetTrade_type('MWEB');
				try {
					return '<script type="text/javascript">window.location.href="'.WxPayApi::unifiedOrder($wxPayUnifiedOrder)['mweb_url'].'&redirect_url='.urldecode(Config::get('app.web_url').Config::get('system.index_php').'pay/wxpayh5/oid/'.Request::param('oid').'.html').'";</script>';
				} catch (Exception $e){
				}
			}
		}else{
			return $this->failed('非法操作！');
		}
		return '';
	}
	
	public function wxpayh5(){
		if (Request::param('oid')){
			$Order = new model\Order();
			$object = $Order->one();
			if (!$object) return $this->failed('不存在此订单！');
			if (in_array($object['pay'],$this->paid)) return $this->failed('此订单已支付！');
			return $this->view();
		}else{
			return $this->failed('非法操作！');
		}
	}
	
	private function wxPayUnifiedOrder($object,$object2){
		include ROOT_PATH.'/extend/pay/wxpay/WxPay.Api.php';
		$WxPayUnifiedOrder = new WxPayUnifiedOrder();
		$WxPayUnifiedOrder->SetBody($object2 ? $object2['name'] : '');
		$WxPayUnifiedOrder->SetAttach($object2 ? $object2['name'] : '');
		$WxPayUnifiedOrder->SetOut_trade_no(time().'-'.Request::param('oid'));
		$WxPayUnifiedOrder->SetTotal_fee($object['price']*$object['count']*100);
		$WxPayUnifiedOrder->SetGoods_tag($object2 ? $object2['name'] : '');
		$WxPayUnifiedOrder->SetNotify_url(Config::get('app.web_url').Config::get('system.index_php').'pay/wxpayReturn');
		$WxPayUnifiedOrder->SetProfit_sharing('N');
		return $WxPayUnifiedOrder;
	}
	
	public function wxpayImg(){
		ob_start();
		ob_clean();
		include ROOT_PATH.'/extend/phpqrcode.php';
		QRcode::png(urldecode(Request::get('data')));
	}
	 
	public function wxpayReturn(){
		if (Config::get('system.order_db') == '1'){
			include ROOT_PATH.'/extend/pay/wxpay/notify.php';
			$payNotifyCallBack = new PayNotifyCallBack();
			$result = (array)simplexml_load_string(file_get_contents('php://input'),'SimpleXMLElement',LIBXML_NOCDATA);
			if ($payNotifyCallBack->QueryOrder($result['transaction_id'])){
				$Order = new model\Order();
				$oid = explode('-',$result['out_trade_no']);
				$Order->modify($oid[1],7,$result['transaction_id'],$this->payScene[1][$result['trade_type']],strtotime($result['time_end']));
				echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
			}
		}
	}
	
	public function wxpayAjax(){
		if (Request::isAjax()){
			$Order = new model\Order();
			$object = $Order->one(Request::post('oid'));
			echo $object['pay'];
		}
	}
	
	public function wxpayTip(){
		if (Request::param('oid')){
			$Order = new model\Order();
			$object = $Order->one(Request::param('oid'));
			$Template = new model\Template();
			$object2 = $Template->one($object['tid']);
			return $this->success(NULL,str_replace('{oid}',Request::param('oid'),$object2['success2']),0,2);
		}
		return '';
	}
}