<?php

namespace alipay\page\pay\buildermodel;

use alipay\common\pay\buildermodel\AlipayTradeContentBuilder;

class AlipayTradePagePayContentBuilder extends AlipayTradeContentBuilder
{
    protected $bizContentArr = ['product_code' => 'FAST_INSTANT_TRADE_PAY'];
}
