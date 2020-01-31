<?php
class WxPayDataBase{
	protected $values = [];
	
	public function SetSign(){
		$sign = $this->MakeSign();
		$this->values['sign'] = $sign;
		return $sign;
	}
	
	public function GetSign(){
		return $this->values['sign'];
	}
	
	public function IsSignSet(){
		return array_key_exists('sign',$this->values);
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function ToXml(){
		if (!is_array($this->values) || count($this->values)<=0) throw new Exception('数组数据异常！');
    	$xml = '<xml>';
    	foreach ($this->values as $key=>$val){
			$xml .= is_numeric($val) ? '<'.$key.'>'.$val.'</'.$key.'>' : '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
        }
        $xml .= '</xml>';
        return $xml; 
	}

	/**
	 * @param $xml
	 * @return array|mixed
	 * @throws Exception
	 */
	public function FromXml($xml){	
		if (!$xml) throw new Exception('xml数据异常！');
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);		
		return $this->values;
	}

	public function ToUrlParams(){
		$buff = '';
		foreach ($this->values as $k=>$v){
			if ($k!='sign' && $v!='' && !is_array($v)) $buff .= $k.'='.$v.'&';
		}
		return trim($buff,'&');
	}
	
	public function MakeSign(){
		ksort($this->values);
		return strtoupper(md5($this->ToUrlParams().'&key='.KEY));
	}

	public function GetValues(){
		return $this->values;
	}
}

class WxPayResults extends WxPayDataBase
{
	/**
	 * @return bool
	 * @throws Exception
	 */
	public function CheckSign(){
		if (!$this->IsSignSet()) throw new Exception('签名错误！');
		if ($this->GetSign() == $this->MakeSign()) return true;
		throw new Exception('签名错误！');
	}

	/**
	 * @param $xml
	 * @return array
	 * @throws Exception
	 */
	public static function Init($xml){	
		$obj = new self();
		$obj->FromXml($xml);
		if ($obj->values['return_code'] != 'SUCCESS') return $obj->GetValues();
		$obj->CheckSign();
        return $obj->GetValues();
	}
}

class WxPayNotifyReply extends WxPayDataBase{
}

class WxPayUnifiedOrder extends WxPayDataBase{
	public function SetAppid($value){
		$this->values['appid'] = $value;
	}

	public function SetMch_id($value){
		$this->values['mch_id'] = $value;
	}

	public function SetNonce_str($value){
		$this->values['nonce_str'] = $value;
	}

	public function SetBody($value){
		$this->values['body'] = $value;
	}

	public function IsBodySet(){
		return array_key_exists('body',$this->values);
	}

	public function SetAttach($value){
		$this->values['attach'] = $value;
	}

	public function SetOut_trade_no($value){
		$this->values['out_trade_no'] = $value;
	}

	public function IsOut_trade_noSet(){
		return array_key_exists('out_trade_no',$this->values);
	}

	public function SetTotal_fee($value){
		$this->values['total_fee'] = $value;
	}

	/*public function SetFee_type($value){
		$this->values['fee_type'] = $value;
	}*/

	public function IsTotal_feeSet(){
		return array_key_exists('total_fee',$this->values);
	}

	public function SetSpbill_create_ip($value){
		$this->values['spbill_create_ip'] = $value;
	}

	public function SetGoods_tag($value){
		$this->values['goods_tag'] = $value;
	}

	public function SetProfit_sharing($value){
		$this->values['profit_sharing'] = $value;
	}

	public function SetNotify_url($value){
		$this->values['notify_url'] = $value;
	}

	public function SetTrade_type($value){
		$this->values['trade_type'] = $value;
	}

	public function GetTrade_type(){
		return $this->values['trade_type'];
	}

	public function IsTrade_typeSet(){
		return array_key_exists('trade_type',$this->values);
	}

	public function SetProduct_id($value){
		$this->values['product_id'] = $value;
	}

	public function IsProduct_idSet(){
		return array_key_exists('product_id',$this->values);
	}

	public function SetOpenid($value){
		$this->values['openid'] = $value;
	}

	public function IsOpenidSet(){
		return array_key_exists('openid',$this->values);
	}
}

class WxPayOrderQuery extends WxPayDataBase{
	public function SetAppid($value){
		$this->values['appid'] = $value;
	}

	public function SetMch_id($value){
		$this->values['mch_id'] = $value;
	}

	public function SetTransaction_id($value){
		$this->values['transaction_id'] = $value;
	}

	public function IsTransaction_idSet(){
		return array_key_exists('transaction_id',$this->values);
	}

	public function IsOut_trade_noSet(){
		return array_key_exists('out_trade_no',$this->values);
	}

	public function SetNonce_str($value){
		$this->values['nonce_str'] = $value;
	}
}

class WxPayJsApiPay extends WxPayDataBase{
	public function SetAppid($value){
		$this->values['appId'] = $value;
	}

	public function SetTimeStamp($value){
		$this->values['timeStamp'] = $value.'';
	}

	public function SetNonceStr($value){
		$this->values['nonceStr'] = $value;
	}

	public function SetPackage($value){
		$this->values['package'] = $value;
	}

	public function SetSignType($value){
		$this->values['signType'] = $value;
	}

	public function SetPaySign($value){
		$this->values['paySign'] = $value;
	}
}