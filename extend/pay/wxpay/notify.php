<?php
require __DIR__.'/WxPay.Api.php';

class PayNotifyCallBack extends WxPayNotifyReply{
	//查询订单
	public function QueryOrder($transaction_id){
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		try {
			$result = WxPayApi::orderQuery($input);
		} catch (Exception $e){
			$result = [];
		}
		return array_key_exists('return_code',$result) && array_key_exists('result_code',$result) && $result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS';
	}
}