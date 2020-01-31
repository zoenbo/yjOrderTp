<?php
namespace QqLogin;

class URL{
	public function combineURL($baseURL,$keysArr){
		$combined = $baseURL.'?';
		$valueArr = [];
		foreach ($keysArr as $key=>$val){
			$valueArr[] = $key.'='.$val;
		}
		return $combined.implode('&',$valueArr);
	}

	public function get_contents($url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_URL,$url);
		$response = curl_exec($ch);
		curl_close($ch);
		if (empty($response)) exit('50001');
		return $response;
	}

	public function get($url,$keysArr){
		return $this->get_contents($this->combineURL($url,$keysArr));
	}
}