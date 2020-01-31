<?php
class JsApiPay{
	public function GetOpenid(){
		if (!isset($_GET['code'])){
			header('Location:'.$this->__CreateOauthUrlForCode(urlencode((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'])));
			exit;
		}else{
			return $this->getOpenidFromMp($_GET['code']);
		}
	}

	/**
	 * @param $UnifiedOrderResult
	 * @return false|string
	 * @throws Exception
	 */
	public function GetJsApiParameters($UnifiedOrderResult){
		if (!array_key_exists('appid',$UnifiedOrderResult) || !array_key_exists('prepay_id',$UnifiedOrderResult) || $UnifiedOrderResult['prepay_id']=='') throw new Exception('参数错误');
		
		$wxPayJsApiPay = new WxPayJsApiPay();
		$wxPayJsApiPay->SetAppid($UnifiedOrderResult['appid']);
		$wxPayJsApiPay->SetTimeStamp(time());
		$wxPayJsApiPay->SetNonceStr(WxPayApi::getNonceStr());
		$wxPayJsApiPay->SetPackage('prepay_id='.$UnifiedOrderResult['prepay_id']);
		$wxPayJsApiPay->SetSignType('MD5');
		$wxPayJsApiPay->SetPaySign($wxPayJsApiPay->MakeSign());
		return json_encode($wxPayJsApiPay->GetValues());
	}
	
	private function GetOpenidFromMp($code){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,30);
		curl_setopt($ch,CURLOPT_URL,$this->__CreateOauthUrlForOpenid($code));
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if (CURL_PROXY_HOST!='0.0.0.0' && CURL_PROXY_PORT!=0){
			curl_setopt($ch,CURLOPT_PROXY,CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT,CURL_PROXY_PORT);
		}
		$res = curl_exec($ch);
		curl_close($ch);
		return json_decode($res,true)['openid'];
	}

	private function ToUrlParams($urlObj){
		$buff = '';
		foreach ($urlObj as $k=>$v){
			if ($k != 'sign') $buff .= $k.'='.$v.'&';
		}
		return trim($buff,'&');
	}

	private function __CreateOauthUrlForCode($redirectUrl){
		return 'https://open.weixin.qq.com/connect/oauth2/authorize?'.$this->ToUrlParams([
			'appid'=>APPID,
			'redirect_uri'=>$redirectUrl,
			'response_type'=>'code',
			'scope'=>'snsapi_base',
			'state'=>'STATE#wechat_redirect'
		]);
	}

	private function __CreateOauthUrlForOpenid($code){
		return 'https://api.weixin.qq.com/sns/oauth2/access_token?'.$this->ToUrlParams([
			'appid'=>APPID,
			'secret'=>APPSECRET,
			'code'=>$code,
			'grant_type'=>'authorization_code'
		]);
	}
}