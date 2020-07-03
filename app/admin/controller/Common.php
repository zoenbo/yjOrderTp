<?php

namespace app\admin\controller;

use extend\QQWry;
use think\exception\ValidateException;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Config;

class Common extends Base
{
    //上传登录页背景图
    public function loginBg()
    {
        if (Request::isPost()) {
            if (Config::get('app.demo')) {
                return '';
            }
            try {
                validate(['file' => 'fileExt:jpg'])->check(Request::file());
                $path = ROOT_PATH . '/' . Config::get('app.upload_dir') . Filesystem::putFile(
                    date('Y-m'),
                    Request::file('file'),
                    function () {
                        return date('dHis') . rand(1000, 9999);
                    }
                );
                rename($path, ROOT_PATH . '/public/admin/images/loginbg.jpg');
                return 1;
            } catch (ValidateException $e) {
                return $e->getMessage();
            }
        }
        return '';
    }

    //上传IP数据库
    public function qqwry()
    {
        if (Request::isPost()) {
            if (Config::get('app.demo')) {
                return '';
            }
            try {
                validate(['file' => 'fileExt:dat'])->check(Request::file());
                $path = ROOT_PATH . '/' . Config::get('app.upload_dir') .
                    Filesystem::putFile(date('Y-m'), Request::file('file'), function () {
                        return date('dHis') . rand(1000, 9999);
                    });
                rename($path, ROOT_PATH . '/data/qqwry.dat');
                include ROOT_PATH . '/extend/QQWry.php';
                return QQWry::getInstance()->getVersion();
            } catch (ValidateException $e) {
                return $e->getMessage();
            }
        }
        return '';
    }
}
