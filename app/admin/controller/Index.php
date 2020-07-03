<?php

namespace app\admin\controller;

use think\facade\Config;
use think\facade\View;
use app\admin\model;

class Index extends Base
{
    public function index()
    {
        View::assign(['Version' => explode('|', Config::get('app.version'))]);
        return $this->view();
    }

    public function main()
    {
        $Order = new model\Order();
        $Product = new model\Product();
        View::assign([
            'Version' => explode('|', Config::get('app.version')),
            'Data' => [
                'order_total1' => $Order->total2(),
                'order_total2' => $Order->total2(1),
                'order_total3' => $Order->total2(2),
                'order_total4' => $Order->total2(3),
                'order_total5' => $Order->total2(4),
                'product_total1' => $Product->total(),
                'product_total2' => $Product->total2()
            ]
        ]);
        return $this->view();
    }
}
