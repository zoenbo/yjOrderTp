<?php
namespace QqLogin;

class QC extends Oauth{
	private $APIMap;
	private $keysArr;

	public function __construct($access_token='',$openid='',$callback=''){
		parent::__construct($callback);

		$this->keysArr['oauth_consumer_key'] = (int)$this->recorder->readInc('appid');
		if ($access_token==='' || $openid===''){
			$this->keysArr['access_token'] = $this->recorder->read('access_token');
			$this->keysArr['openid'] = $this->recorder->read('openid');
		}else{
			$this->keysArr['access_token'] = $access_token;
			$this->keysArr['openid'] = $openid;
		}

		$this->APIMap = ['get_user_info'=>['https://graph.qq.com/user/get_user_info',['format'=>'json']]];
	}

	private function _applyAPI($arr,$argsList,$baseUrl){
		$pre = '#';
		$keysArr = $this->keysArr;
		$optionArgList = [];

		foreach($argsList as $key => $val){
			$tmpKey = $key;
			$tmpVal = $val;

			if(!is_string($key)){
				$tmpKey = $val;
				if (strpos($val,$pre) === 0){
					$tmpVal = $pre;
					$tmpKey = substr($tmpKey,1);
					if (preg_match('/-(\d$)/',$tmpKey,$res)){
						$tmpKey = str_replace($res[0],'',$tmpKey);
						$optionArgList[$res[1]][] = $tmpKey;
					}
				}else{
					$tmpVal = null;
				}
			}

			if (!isset($arr[$tmpKey]) || $arr[$tmpKey]===''){
				if ($tmpVal == $pre){
					continue;
				} elseif($tmpVal){
					$arr[$tmpKey] = $tmpVal;
				}
			}

			$keysArr[$tmpKey] = $arr[$tmpKey];
		}

		foreach ($optionArgList as $val){
			$n = 0;
			foreach ($val as $v){
				if (in_array($v,array_keys($keysArr))) $n++;
			}

			if (!$n) exit('api调用参数错误，'.implode(',',$val).'必填一个');
		}

		return $this->urlUtils->get($baseUrl,$keysArr);
	}

	public function __call($name,$arg){
		if (empty($this->APIMap[$name])) exit('api调用名称错误，不存在的API: <span style="color:red;">'.$name.'</span>');

		$baseUrl = $this->APIMap[$name][0];
		$argsList = $this->APIMap[$name][1];

		if (empty($arg)) $arg[0] = null;

		$response = json_decode($this->_applyAPI($arg[0],$argsList,$baseUrl));
		$responseArr = $this->objToArr($response);
		if ($responseArr['ret'] == 0){
			return $responseArr;
		}else{
			exit($response->ret.'，'.$response->msg);
		}
	}
	
	private function objToArr($obj){
		if (!is_object($obj) && !is_array($obj)) return $obj;
		$arr = [];
		foreach($obj as $k=>$v){
			$arr[$k] = $this->objToArr($v);
		}
		return $arr;
	}
}