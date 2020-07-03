<?php

namespace alipay\wap\aop\request;

use alipay\common\aop\request\AlipayTradeRequest;

class AlipayTradeWapPayRequest extends AlipayTradeRequest
{
    public function getApiMethodName()
    {
        return 'alipay.trade.wap.pay';
    }
}
