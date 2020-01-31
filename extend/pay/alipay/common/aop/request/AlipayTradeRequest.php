<?php
namespace alipay\common\aop\request;

class AlipayTradeRequest{
	private $bizContent;
	private $apiParas = [];
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion = '1.0';
	private $notifyUrl;
	private $returnUrl;

	public function setBizContent($bizContent){
		$this->bizContent = $bizContent;
		$this->apiParas['biz_content'] = $bizContent;
	}

	public function setNotifyUrl($notifyUrl){
		$this->notifyUrl = $notifyUrl;
	}

	public function getNotifyUrl(){
		return $this->notifyUrl;
	}

	public function setReturnUrl($returnUrl){
		$this->returnUrl = $returnUrl;
	}

	public function getReturnUrl(){
		return $this->returnUrl;
	}

	public function getApiParas(){
		return $this->apiParas;
	}

	public function getTerminalType(){
		return $this->terminalType;
	}

	public function getTerminalInfo(){
		return $this->terminalInfo;
	}

	public function getProdCode(){
		return $this->prodCode;
	}

	public function getApiVersion(){
		return $this->apiVersion;
	}
}