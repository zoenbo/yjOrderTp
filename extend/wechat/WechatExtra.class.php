<?php
require dirname(__FILE__).'/Wechat.class.php';

class WechatExtra extends Wechat{
	public function getShareConfig(){
		$config = array(
			'appid'=>$this->appid,
			'jsapi_ticket'=>$this->getJsTicket2(),
			'noncestr'=>getKey(16),
			'timestamp'=>time(),
			'url'=>(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
		);
		$config['signature'] = sha1('jsapi_ticket='.$config['jsapi_ticket'].'&noncestr='.$config['noncestr'].'&timestamp='.$config['timestamp'].'&url='.$config['url']);
		return $config;
	}
	
	public function getJsTicket2(){
		if (time() - config('wechat.cache') < 5400){
			return config('wechat.js_ticket');
		}else{
			$jsTicket = parent::getJsTicket();
			file_put_contents(ROOT_PATH.'/'.config('app.config_path_home').'/wechat.php',"<?php return ['cache'=>".time().",'js_ticket'=>'".$jsTicket."'];");
			return $jsTicket;
		}
	}
	
	public function checkAuth2(){
		if ($_SERVER['HTTP_HOST'] == 'www.yvjie.cn'){
			$file = dirname(dirname(dirname(ROOT_PATH))).'/common/'.$this->appid.'.php';
			$config = include($file);
			if (time() - $config['cache'] < 5400){
				$this->access_token = $config['token'];
				return $config['token'];
			}else{
				$token = parent::checkAuth();
				file_put_contents($file,"<?php return ['cache'=>".time().",'token'=>'".$token."'];");
				return $token;
			}
		}else{
			if (time() - config($this->appid.'.cache') < 5400){
				$this->access_token = config($this->appid.'.token');
				return config($this->appid.'.token');
			}else{
				$token = parent::checkAuth();
				file_put_contents(ROOT_PATH.'/'.config('app.config_path').'/'.$this->appid.'.php',"<?php return ['cache'=>".time().",'token'=>'".$token."'];");
				return $token;
			}
		}
	}
}