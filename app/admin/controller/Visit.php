<?php

namespace app\admin\controller;

use extend\QQWry;
use think\facade\Route;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Visit extends Base
{
    public function index()
    {
        $Visit = new model\Visit();
        $object = $Visit->all($this->page($Visit->total()));
        if ($object) {
            include ROOT_PATH . '/extend/QQWry.php';
            $QQWry = QQWry::getInstance();
            foreach ($object as $key => $value) {
                $object[$key]['ip'] = $value['ip'] . '<br>' . $QQWry->getAddr($value['ip']);
            }
        }
        View::assign(['All' => $object]);
        return $this->view();
    }

    public function output()
    {
        if (Request::isPost()) {
            $output = '"IP","访问页面","当日次数","第一次","最后一次",';
            $Visit = new model\Visit();
            $object = $Visit->all2();
            if ($object) {
                include ROOT_PATH . '/extend/QQWry.php';
                $QQWry = QQWry::getInstance();
                foreach ($object as $value) {
                    $output .= "\r\n" . '"' . $value['ip'] . ' -- ' . $QQWry->getAddr($value['ip']) . '","' .
                        $value['url'] . '","' . $value['count'] . '","' . dateFormat($value['date1']) . '","' .
                        dateFormat($value['date2']) . '",';
                }
            }
            $output = mb_convert_encoding($output, 'GBK', 'UTF-8');
            $file = Config::get('app.output_dir') . 'visit_' . date('YmdHis') . '.csv';
            if (file_put_contents(ROOT_PATH . '/' . $file, $output)) {
                $Visit->truncate();
                return $this->success(
                    '',
                    '文件生成成功！<a href="' . Config::get('app.web_url') . $file . '">下载</a>' .
                    '<a href="javascript:" onclick="window.parent.addTab(\'' . Route::buildUrl('/output/index') .
                    '\',\'导出的数据\')">去管理文件</a> <a href="' . Route::buildUrl('/' .
                        parse_name(Request::controller()) . '/index') . '">返回</a>',
                    0,
                    2
                );
            } else {
                return $this->failed('文件生成失败，请检查' . Config::get('app.output_dir') . '目录权限！');
            }
        }
        return $this->confirm('确定要将数据导出到文件并清空数据表吗？');
    }

    public function js()
    {
        $js = ROOT_PATH . '/public/home/js/Visit.js';
        return file_put_contents(
            $js,
            preg_replace(
                '/url: \'.*\',/U',
                'url: \'' . Config::get('app.web_url2') . Config::get('system.index_php') . 'common/visit.html\',',
                file_get_contents($js)
            )
        ) ? $this->success(Config::get('app.prev_url'), '配置更新成功！') : $this->failed('配置更新失败，请检查public/home/js目录权限！');
    }
}
