<?php

namespace alipay\common\pay\service;

use alipay\common\aop\AopClient;
use alipay\common\pay\buildermodel\AlipayTradeContentBuilder;
use alipay\page\aop\request\AlipayTradePagePayRequest;
use alipay\wap\aop\request\AlipayTradeWapPayRequest;
use Exception;

class AlipayTradeService
{
    public $gateway_url = 'https://openapi.alipay.com/gateway.do';
    public $alipay_public_key;
    public $private_key;
    public $appid;
    public $charset = 'UTF-8';
    public $token = null;
    public $format = 'json';
    public $sign_type = 'RSA2';

    /**
     * AlipayTradeService constructor.
     * @param $alipay_config
     * @throws Exception
     */
    public function __construct($alipay_config)
    {
        $this->gateway_url = $alipay_config['gatewayUrl'];
        $this->appid = $alipay_config['app_id'];
        $this->private_key = $alipay_config['merchant_private_key'];
        $this->alipay_public_key = $alipay_config['alipay_public_key'];
        $this->charset = $alipay_config['charset'];
        $this->sign_type = $alipay_config['sign_type'];

        if (empty($this->appid) || trim($this->appid) == '') {
            throw new Exception('appid should not be NULL!');
        }
        if (empty($this->private_key) || trim($this->private_key) == '') {
            throw new Exception('private_key should not be NULL!');
        }
        if (empty($this->alipay_public_key) || trim($this->alipay_public_key) == '') {
            throw new Exception('alipay_public_key should not be NULL!');
        }
        if (empty($this->charset) || trim($this->charset) == '') {
            throw new Exception('charset should not be NULL!');
        }
        if (empty($this->gateway_url) || trim($this->gateway_url) == '') {
            throw new Exception('gateway_url should not be NULL!');
        }
    }

    /**
     * @param AlipayTradePagePayRequest|AlipayTradeWapPayRequest $request
     * @param AlipayTradeContentBuilder $builder
     * @param $return_url
     * @param $notify_url
     * @return Exception|string
     */
    public function pay($request, $builder, $return_url, $notify_url)
    {
        $request->setNotifyUrl($notify_url);
        $request->setReturnUrl($return_url);
        $request->setBizContent($builder->getBizContent());
        return $this->aopClientRequestExecute($request);
    }

    public function check($arr)
    {
        $AopClient = new AopClient();
        $AopClient->alipayrsaPublicKey = $this->alipay_public_key;
        return $AopClient->rsaCheckV1($arr, $this->alipay_public_key, $this->sign_type);
    }

    private function aopClientRequestExecute($request)
    {
        $AopClient = new AopClient();
        $AopClient->gatewayUrl = $this->gateway_url;
        $AopClient->appId = $this->appid;
        $AopClient->rsaPrivateKey = $this->private_key;
        $AopClient->alipayrsaPublicKey = $this->alipay_public_key;
        $AopClient->apiVersion = '1.0';
        $AopClient->postCharset = $this->charset;
        $AopClient->format = $this->format;
        $AopClient->signType = $this->sign_type;
        $AopClient->debugInfo = true;

        try {
            return $AopClient->pageExecute($request, 'post');
        } catch (Exception $e) {
            return $e;
        }
    }
}
