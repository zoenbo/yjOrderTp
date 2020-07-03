<?php

namespace wechat;

use think\facade\Config;

class WechatExtra extends Wechat
{
    public function getShareConfig()
    {
        $config = [
            'appid' => $this->appId,
            'jsapi_ticket' => $this->getJsTicket2(),
            'nonce_str' => getKey(16),
            'timestamp' => time(),
            'url' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .
                $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
        ];
        $config['signature'] = sha1('jsapi_ticket=' . $config['jsapi_ticket'] . '&noncestr=' . $config['nonce_str'] .
            '&timestamp=' . $config['timestamp'] . '&url=' . $config['url']);
        return $config;
    }

    public function getJsTicket2()
    {
        if (time() - Config::get('wechat.cache') < 5400) {
            return Config::get('wechat.js_ticket');
        } else {
            $jsTicket = parent::getJsTicket();
            file_put_contents(
                ROOT_PATH . '/' . Config::get('app.config_path_home') . '/wechat.php',
                "<?php return ['cache'=>" . time() . ",'js_ticket'=>'" . $jsTicket . "'];"
            );
            return $jsTicket;
        }
    }

    public function checkAuth2()
    {
        if ($_SERVER['HTTP_HOST'] == 'www.yvjie.cn') {
            $file = dirname(dirname(dirname(ROOT_PATH))) . '/common/' . $this->appId . '.php';
            $config = include($file);
            if (time() - $config['cache'] < 5400) {
                $this->accessToken = $config['token'];
                return $config['token'];
            } else {
                $token = parent::checkAuth();
                file_put_contents($file, "<?php return ['cache'=>" . time() . ",'token'=>'" . $token . "'];");
                return $token;
            }
        } else {
            if (time() - Config::get($this->appId . '.cache') < 5400) {
                $this->accessToken = Config::get($this->appId . '.token');
                return Config::get($this->appId . '.token');
            } else {
                $token = parent::checkAuth();
                file_put_contents(
                    ROOT_PATH . '/' . Config::get('app.config_path') . '/' . $this->appId . '.php',
                    "<?php return ['cache'=>" . time() . ",'token'=>'" . $token . "'];"
                );
                return $token;
            }
        }
    }
}
