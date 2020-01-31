<?php
require __DIR__.'/WxPay.Config.php';
require __DIR__.'/WxPay.Data.php';

class WxPayApi{
	/**
	 * @param WxPayUnifiedOrder $inputObj
	 * @param int $timeOut
	 * @return array
	 * @throws Exception
	 */
	public static function unifiedOrder(WxPayUnifiedOrder $inputObj,$timeOut=6){
		if (!$inputObj->IsOut_trade_noSet()) throw new Exception('缺少统一支付接口必填参数out_trade_no！');
		if (!$inputObj->IsBodySet()) throw new Exception('缺少统一支付接口必填参数body！');
		if (!$inputObj->IsTotal_feeSet()) throw new Exception('缺少统一支付接口必填参数total_fee！');
		if (!$inputObj->IsTrade_typeSet())throw new Exception('缺少统一支付接口必填参数trade_type！');
		if ($inputObj->GetTrade_type()=='JSAPI' && !$inputObj->IsOpenidSet()) throw new Exception('统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！');
		if ($inputObj->GetTrade_type()=='NATIVE' && !$inputObj->IsProduct_idSet()) throw new Exception('统一支付接口中，缺少必填参数product_id！trade_type为JSAPI时，product_id为必填参数！');
		
		$inputObj->SetAppid(APPID);
		$inputObj->SetMch_id(MCHID);
		$inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);
		$inputObj->SetNonce_str(self::getNonceStr());
		$inputObj->SetSign();
		
		return WxPayResults::Init(self::postXmlCurl($inputObj->ToXml(),'https://api.mch.weixin.qq.com/pay/unifiedorder',false,$timeOut));
	}

	/**
	 * @param WxPayOrderQuery $inputObj
	 * @param int $timeOut
	 * @return array
	 * @throws Exception
	 */
	public static function orderQuery(WxPayOrderQuery $inputObj,$timeOut=6){
		if (!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) throw new Exception('订单查询接口中，out_trade_no、transaction_id至少填一个！');

		$inputObj->SetAppid(APPID);
		$inputObj->SetMch_id(MCHID);
		$inputObj->SetNonce_str(self::getNonceStr());
		$inputObj->SetSign();

		try {
			$response = self::postXmlCurl($inputObj->ToXml(),'https://api.mch.weixin.qq.com/pay/orderquery',false,$timeOut);
			return WxPayResults::Init($response);
		} catch (Exception $e){
			return [];
		}
	}


	public static function getNonceStr($length=32){
		$key = '';
		$charset = 'abcdefghijklmnopqrstuvwxyz0123456789';
		for ($i=0;$i<$length;$i++){
			$key .= $charset[mt_rand(0,strlen($charset)-1)];
		}
		return $key;
	}

	/**
	 * @param $xml
	 * @param $url
	 * @param bool $useCert
	 * @param int $second
	 * @return bool|string
	 * @throws Exception
	 */
	private static function postXmlCurl($xml,$url,$useCert=false,$second=30){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		if (CURL_PROXY_HOST!='0.0.0.0' && CURL_PROXY_PORT!=0){
			curl_setopt($ch,CURLOPT_PROXY,CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT,CURL_PROXY_PORT);
		}
		curl_setopt($ch,CURLOPT_URL,$url);
		if (stripos($url,'https://') !== false){
			curl_setopt($ch,CURLOPT_SSLVERSION,1);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		}else{
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
		}
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if ($useCert){
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT,SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY,SSLKEY_PATH);
		}
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);

		$data = curl_exec($ch);
		if ($data){
			curl_close($ch);
			return $data;
		}else{
			$error = curl_errno($ch);
			curl_close($ch);
			throw new Exception('curl出错，错误码:'.$error);
		}
	}
}