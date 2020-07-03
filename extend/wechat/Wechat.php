<?php

namespace wechat;

class Wechat
{
    public $errCode = 40001;
    public $errMsg = 'no access';
    protected $appId;
    protected $appSecret;
    protected $accessToken;
    private const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
    private const AUTH_URL = '/token?grant_type=client_credential&';
    private const GET_TICKET_URL = '/ticket/getticket?';

    public function __construct($options)
    {
        $this->appId = isset($options['appid']) ? $options['appid'] : '';
        $this->appSecret = isset($options['appsecret']) ? $options['appsecret'] : '';
    }

    public function checkAuth()
    {
        $result = $this->httpGet(self::API_URL_PREFIX . self::AUTH_URL . 'appid=' . $this->appId . '&secret=' .
            $this->appSecret);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->accessToken = $json['access_token'];
            return $this->accessToken;
        }
        return false;
    }

    public function getJsTicket()
    {
        if (!$this->accessToken && !$this->checkAuth2()) {
            return false;
        }
        $result = $this->httpGet(self::API_URL_PREFIX . self::GET_TICKET_URL . 'access_token=' . $this->accessToken .
            '&type=jsapi');
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json['ticket'];
        }
        return false;
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        if (stripos($url, 'https://') !== false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        return intval($status['http_code']) == 200 ? $content : false;
    }
}
