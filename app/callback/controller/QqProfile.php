<?php

namespace app\callback\controller;

use app\common\controller\Base;
use qqlogin\QC;
use think\facade\Session;
use think\facade\Config;
use app\admin\model;

class QqProfile extends Base
{
    public function index()
    {
        $qc = new QC('', '', Config::get('app.web_url') . 'callback.php/qq_profile');
        $callback = $qc->qqCallback();
        $openid = $qc->getOpenid();
        if ($callback && $openid) {
            $Manager = new model\Manager();
            $session = Session::get(Config::get('system.session_key'));
            $object = $Manager->qq($openid, $session['id']);
            if ($object) {
                echo '<script type="text/javascript">window.opener.location.reload();window.close();</script>';
            } else {
                return $this->failed('QQ绑定失败，请重试！');
            }
        }
        return '';
    }
}
