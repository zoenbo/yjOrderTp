<?php
namespace alipay\wap\pay\buildermodel;

use alipay\common\pay\buildermodel\AlipayTradeContentBuilder;

class AlipayTradeWapPayContentBuilder extends AlipayTradeContentBuilder{
	protected $bizContentArr = ['product_code'=>'QUICK_WAP_PAY'];
}