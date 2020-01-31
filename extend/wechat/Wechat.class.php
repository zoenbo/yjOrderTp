<?php
class Wechat{
	const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
	const AUTH_URL = '/token?grant_type=client_credential&';
	const GET_TICKET_URL = '/ticket/getticket?';
	public $errCode = 40001;
	public $errMsg = 'no access';
	protected $appid;
	protected $appsecret;
	protected $access_token;

	public function __construct($options){
		$this->appid = isset($options['appid']) ? $options['appid'] : '';
		$this->appsecret = isset($options['appsecret']) ? $options['appsecret'] : '';
	}

	public function checkAuth(){
		$result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$this->appid.'&secret='.$this->appsecret);
		if ($result){
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])){
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->access_token = $json['access_token'];
			return $this->access_token;
		}
		return false;
	}

	public function getJsTicket(){
		if (!$this->access_token && !$this->checkAuth2()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::GET_TICKET_URL.'access_token='.$this->access_token.'&type=jsapi');
		if ($result){
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])){
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json['ticket'];
		}
		return false;
	}

	private function http_get($url){
		$curl = curl_init();
		if (stripos($url,'https://') !== false){
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt($curl,CURLOPT_SSLVERSION,1);
		}
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$content = curl_exec($curl);
		$status = curl_getinfo($curl);
		curl_close($curl);
		return intval($status['http_code'])==200 ? $content : false;
	}
}