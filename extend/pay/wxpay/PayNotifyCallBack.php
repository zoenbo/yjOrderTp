<?php

namespace wxpay;

use Exception;

class PayNotifyCallBack extends NotifyReply
{
    //查询订单
    public function queryOrder($transaction_id)
    {
        $input = new OrderQuery();
        $input->setTransactionId($transaction_id);
        try {
            $result = Api::orderQuery($input);
        } catch (Exception $e) {
            $result = [];
        }
        return array_key_exists('return_code', $result) && array_key_exists('result_code', $result) &&
            $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }
}
