<?php

namespace alipay\page\aop\request;

use alipay\common\aop\request\AlipayTradeRequest;

class AlipayTradePagePayRequest extends AlipayTradeRequest
{
    public function getApiMethodName()
    {
        return 'alipay.trade.page.pay';
    }
}
