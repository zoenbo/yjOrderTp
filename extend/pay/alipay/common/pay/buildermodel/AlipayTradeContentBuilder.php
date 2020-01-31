<?php
namespace alipay\common\pay\buildermodel;

class AlipayTradeContentBuilder{
    private $body;
    private $subject;
    private $outTradeNo;
    private $totalAmount;
    private $bizContent = NULL;
	protected $bizContentArr = [];

    public function getBizContent(){
        if (!empty($this->bizContentArr)) $this->bizContent = json_encode($this->bizContentArr,JSON_UNESCAPED_UNICODE);
        return $this->bizContent;
    }

    public function setBody($body){
        $this->body = $body;
        $this->bizContentArr['body'] = $body;
    }

    public function setSubject($subject){
        $this->subject = $subject;
        $this->bizContentArr['subject'] = $subject;
    }

    public function setOutTradeNo($outTradeNo){
        $this->outTradeNo = $outTradeNo;
        $this->bizContentArr['out_trade_no'] = $outTradeNo;
    }

    public function setTotalAmount($totalAmount){
        $this->totalAmount = $totalAmount;
        $this->bizContentArr['total_amount'] = $totalAmount;
    }
}