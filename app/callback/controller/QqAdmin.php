<?php

namespace app\callback\controller;

use qqlogin\QC;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;
use app\admin\controller\Login;

class QqAdmin extends Login
{
    protected function initialize()
    {
    }

    public function index()
    {
        $Manager = new model\Manager();
        if (Request::isPost()) {
            $object = $Manager->login();
            if (is_object($object)) {
                if (passEncode(Request::post('pass')) != $object['pass']) {
                    return $this->failed('帐号或密码不正确！');
                }
                if (!empty($object['qqau'])) {
                    return $this->failed('此帐号已绑定了其它QQ，无法再次绑定，如需改绑，请联系超级管理员进行解绑！');
                }
                if (empty($object['is_activation'])) {
                    return $this->failed('您的帐号尚未激活，无法绑定QQ，请联系超级管理员进行激活！');
                }
                if ($Manager->qq(Request::post('qqau'), $object['id'])) {
                    $loginDo = $this->loginDo($object);
                    if ($loginDo != '1') {
                        return $loginDo;
                    }
                    return $this->success(
                        Config::get('app.web_url') . Config::get('system.manage_enter'),
                        'QQ绑定成功，即将跳转到后台！'
                    );
                } else {
                    return $this->failed('QQ绑定失败，请重试！');
                }
            } else {
                return $this->failed($object);
            }
        }
        $qc = new QC('', '', Config::get('app.web_url') . 'callback.php/qq_admin');
        $callback = $qc->qqCallback();
        $openid = $qc->getOpenid();
        $object = $Manager->qqLogin($openid);
        if ($object) {
            $loginDo = $this->loginDo($object);
            if ($loginDo != '1') {
                return $loginDo;
            }
            return $this->success(Config::get('app.web_url') . Config::get('system.manage_enter'), '登录成功！', 1);
        } else {
            $qc2 = new QC($callback, $openid);
            $info = $qc2->get_user_info();
            View::assign([
                'Nickname' => $info['nickname'],
                'Qqau' => $openid
            ]);
            return $this->view('../../admin/view/login/qq_return');
        }
    }

    public function qqAjax()
    {
        if (Request::isAjax()) {
            $Manager = new model\Manager();
            $object = $Manager->login();
            if ($object) {
                if (passEncode(Request::post('pass')) == $object['pass']) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        }
    }
}
