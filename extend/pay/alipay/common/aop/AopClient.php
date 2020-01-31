<?php
namespace alipay\common\aop;

use alipay\page\aop\request\AlipayTradePagePayRequest;
use alipay\wap\aop\request\AlipayTradeWapPayRequest;
use Exception;

class AopClient{
	public $appId;
	public $rsaPrivateKeyFilePath;
	public $rsaPrivateKey;
	public $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	public $format = 'json';
	public $apiVersion = '1.0';
	public $postCharset = 'UTF-8';
	public $alipayPublicKey = null;
	public $alipayrsaPublicKey;
	public $debugInfo = false;
	protected $fileCharset = 'UTF-8';
	public $signType = 'RSA';
	protected $alipaySdkVersion = 'alipay-sdk-php-20161101';

	private function generateSign($params,$signType='RSA'){
		return $this->sign($this->getSignContent($params),$signType);
	}

	private function getSignContent($params){
		ksort($params);

		$stringToBeSigned = '';
		$i = 0;
		foreach ($params as $k=>$v){
			if (false===$this->checkEmpty($v) && '@'!=substr($v,0,1)){
				$v = $this->charset($v,$this->postCharset);
				$stringToBeSigned .= ($i==0 ? '' : '&').$k . '=' . $v;
				$i++;
			}
		}

		unset($k,$v);
		return $stringToBeSigned;
	}

	private function sign($data,$signType='RSA'){
		if ($this->checkEmpty($this->rsaPrivateKeyFilePath)){
			$priKey = $this->rsaPrivateKey;
			$res = '-----BEGIN RSA PRIVATE KEY-----'."\n".wordwrap($priKey,64,"\n",true)."\n".'-----END RSA PRIVATE KEY-----';
		}else{
			$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
			$res = openssl_get_privatekey($priKey);
		}

		($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

		if ('RSA2' == $signType){
			openssl_sign($data,$sign,$res,OPENSSL_ALGO_SHA256);
		}else{
			openssl_sign($data,$sign,$res);
		}

		if (!$this->checkEmpty($this->rsaPrivateKeyFilePath)) openssl_free_key($res);
		return base64_encode($sign);
	}

	/**
	 * @param AlipayTradePagePayRequest|AlipayTradeWapPayRequest $request
	 * @param string $httpmethod
	 * @return string
	 * @throws Exception
	 */
	public function pageExecute($request,$httpmethod='POST'){
		$this->setupCharsets($request);

		if (strcasecmp($this->fileCharset,$this->postCharset)) throw new Exception('文件编码：['.$this->fileCharset.']与表单提交编码：['.$this->postCharset.']两者不一致!');

		$iv = !$this->checkEmpty($request->getApiVersion()) ? $request->getApiVersion() : $this->apiVersion;

		$sysParams['app_id'] = $this->appId;
		$sysParams['version'] = $iv;
		$sysParams['format'] = $this->format;
		$sysParams['sign_type'] = $this->signType;
		$sysParams['method'] = $request->getApiMethodName();
		$sysParams['timestamp'] = date('Y-m-d H:i:s');
		$sysParams['alipay_sdk'] = $this->alipaySdkVersion;
		$sysParams['terminal_type'] = $request->getTerminalType();
		$sysParams['terminal_info'] = $request->getTerminalInfo();
		$sysParams['prod_code'] = $request->getProdCode();
		$sysParams['notify_url'] = $request->getNotifyUrl();
		$sysParams['return_url'] = $request->getReturnUrl();
		$sysParams['charset'] = $this->postCharset;

		$apiParams = $request->getApiParas();

		$totalParams = array_merge($apiParams,$sysParams);
		$totalParams['sign'] = $this->generateSign($totalParams,$this->signType);
		if ('GET' == strtoupper($httpmethod)){
			return $this->gatewayUrl.'?'.$this->getSignContentUrlencode($totalParams);
		}else{
			return $this->buildRequestForm($totalParams);
		}
	}

	private function buildRequestForm($para_temp){
		$sHtml = '<form id="alipaysubmit" name="alipaysubmit" action="'.$this->gatewayUrl.'?charset='.trim($this->postCharset).'" method="POST">';
		foreach ($para_temp as $key=>$val){
			if (false === $this->checkEmpty($val)){
				$sHtml.= '<input type="hidden" name="'.$key.'" value="'.str_replace('"','&quot;',$val).'">';
			}
		}
		return $sHtml.'<input type="submit" value="ok" style="display:none;"></form><script type="text/javascript">document.forms["alipaysubmit"].submit();</script>';
	}

	private function setupCharsets($request){
		if ($this->checkEmpty($this->postCharset)) $this->postCharset = 'UTF-8';
		$str = preg_match('/[\x80-\xff]/',$this->appId) ? $this->appId : print_r($request,true);
		$this->fileCharset = mb_detect_encoding($str,'UTF-8,GBK')=='UTF-8' ? 'UTF-8' : 'GBK';
	}

	private function verify($data,$sign,$rsaPublicKeyFilePath,$signType='RSA'){
		if ($this->checkEmpty($this->alipayPublicKey)){
			$res = '-----BEGIN PUBLIC KEY-----'."\n".wordwrap($this->alipayrsaPublicKey,64,"\n",true)."\n".'-----END PUBLIC KEY-----';
		}else{
			$res = openssl_get_publickey(file_get_contents($rsaPublicKeyFilePath));
		}

		($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

		if ('RSA2' == $signType){
			$result = (bool)openssl_verify($data,base64_decode($sign),$res,OPENSSL_ALGO_SHA256);
		}else{
			$result = (bool)openssl_verify($data,base64_decode($sign),$res);
		}

		if (!$this->checkEmpty($this->alipayPublicKey)) openssl_free_key($res);

		return $result;
	}

	public function rsaCheckV1($params,$rsaPublicKeyFilePath,$signType='RSA') {
		$sign = $params['sign'];
		$params['sign_type'] = null;
		$params['sign'] = null;
		return $this->verify($this->getSignContent($params),$sign,$rsaPublicKeyFilePath,$signType);
	}

	private function checkEmpty($value){
		if (!isset($value)) return true;
		if ($value === null) return true;
		if (trim($value) === '') return true;
		return false;
	}

	private function getSignContentUrlencode($params) {
		ksort($params);

		$stringToBeSigned = '';
		$i = 0;
		foreach ($params as $k=>$v){
			if (false===$this->checkEmpty($v) && '@'!=substr($v,0,1)){
				$v = $this->charset($v,$this->postCharset);
				$stringToBeSigned .= ($i==0 ? '' : '&').$k . '=' . $v;
				$i++;
			}
		}

		unset($k,$v);
		return $stringToBeSigned;
	}

	private function charset($data,$targetCharset){
		if (!empty($data)){
			$fileType = $this->fileCharset;
			if (strcasecmp($fileType,$targetCharset) != 0) $data = mb_convert_encoding($data,$targetCharset,$fileType);
		}
		return $data;
	}
}