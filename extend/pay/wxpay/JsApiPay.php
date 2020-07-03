<?php

namespace wxpay;

use Exception;

class JsApiPay
{
    public function getOpenid()
    {
        if (!isset($_GET['code'])) {
            header('Location:' . $this->createOauthUrlForCode(urlencode((isset($_SERVER['HTTPS']) &&
                    $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] .
                    $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'])));
            exit;
        } else {
            return $this->getOpenidFromMp($_GET['code']);
        }
    }

    /**
     * @param $UnifiedOrderResult
     * @return false|string
     * @throws Exception
     */
    public function getJsApiParameters($UnifiedOrderResult)
    {
        if (
            !array_key_exists('appid', $UnifiedOrderResult) ||
            !array_key_exists('prepay_id', $UnifiedOrderResult) ||
            $UnifiedOrderResult['prepay_id'] == ''
        ) {
            throw new Exception('参数错误');
        }

        $JsApi = new JsApi();
        $JsApi->setAppid($UnifiedOrderResult['appid']);
        $JsApi->setTimeStamp(time());
        $JsApi->setNonceStr(Api::getNonceStr());
        $JsApi->setPackage('prepay_id=' . $UnifiedOrderResult['prepay_id']);
        $JsApi->setSignType('MD5');
        $JsApi->setPaySign($JsApi->makeSign());
        return json_encode($JsApi->GetValues());
    }

    private function getOpenidFromMp($code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $this->createOauthUrlForOpenid($code));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (CURL_PROXY_HOST != '0.0.0.0' && CURL_PROXY_PORT != 0) {
            curl_setopt($ch, CURLOPT_PROXY, CURL_PROXY_HOST);
            curl_setopt($ch, CURLOPT_PROXYPORT, CURL_PROXY_PORT);
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true)['openid'];
    }

    private function toUrlParams($urlObj)
    {
        $buff = '';
        foreach ($urlObj as $k => $v) {
            if ($k != 'sign') {
                $buff .= $k . '=' . $v . '&';
            }
        }
        return trim($buff, '&');
    }

    private function createOauthUrlForCode($redirectUrl)
    {
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?' . $this->toUrlParams([
                'appid' => APPID,
                'redirect_uri' => $redirectUrl,
                'response_type' => 'code',
                'scope' => 'snsapi_base',
                'state' => 'STATE#wechat_redirect'
            ]);
    }

    private function createOauthUrlForOpenid($code)
    {
        return 'https://api.weixin.qq.com/sns/oauth2/access_token?' . $this->toUrlParams([
                'appid' => APPID,
                'secret' => APPSECRET,
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]);
    }
}
