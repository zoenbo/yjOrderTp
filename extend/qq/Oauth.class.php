<?php
namespace QqLogin;

class Oauth{
	//const VERSION = '2.0';
	const GET_AUTH_CODE_URL = 'https://graph.qq.com/oauth2.0/authorize';
	const GET_ACCESS_TOKEN_URL = 'https://graph.qq.com/oauth2.0/token';
	const GET_OPENID_URL = 'https://graph.qq.com/oauth2.0/me';
	protected $recorder;
	public $urlUtils;

	function __construct($callback=''){
		$this->recorder = new Recorder($callback);
		$this->urlUtils = new URL();
	}

	public function qq_login(){
		$state = md5(uniqid(rand(),true));
		$this->recorder->write('state',$state);
		header('Location:'.$this->urlUtils->combineURL(self::GET_AUTH_CODE_URL,[
			'response_type'=>'code',
			'client_id'=>$this->recorder->readInc('appid'),
			'redirect_uri'=>$this->recorder->readInc('callback'),
			'state'=>$state,
			'scope'=>$this->recorder->readInc('scope')
		]));
	}

	public function qq_callback(){
		$state = $this->recorder->read('state');
		if (!$state || $_GET['state']!=$state) exit('30001');

		$response = $this->urlUtils->get_contents($this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL,[
			'grant_type'=>'authorization_code',
			'client_id'=>$this->recorder->readInc('appid'),
			'redirect_uri'=>urlencode($this->recorder->readInc('callback')),
			'client_secret'=>$this->recorder->readInc('appkey'),
			'code'=>$_GET['code']
		]));
		if (strpos($response,'callback') !== false){
			$lpos = strpos($response,'(');
			$rpos = strrpos($response,')');
			$response = substr($response,$lpos+1,$rpos-$lpos-1);
			$msg = json_decode($response);
			if (isset($msg->error)) exit($msg->error.'，'.$msg->error_description);
		}

		$params = [];
		parse_str($response,$params);
		$this->recorder->write('access_token',$params['access_token']);
		return $params['access_token'];
	}

	public function get_openid(){
		$response = $this->urlUtils->get_contents($this->urlUtils->combineURL(self::GET_OPENID_URL,['access_token'=>$this->recorder->read('access_token')]));
		if (strpos($response,'callback') !== false){
			$lpos = strpos($response,'(');
			$rpos = strrpos($response,')');
			$response = substr($response,$lpos+1,$rpos-$lpos-1);
		}

		$user = json_decode($response);
		if (isset($user->error)) exit($user->error.'，'.$user->error_description);
		$this->recorder->write('openid',$user->openid);
		return $user->openid;
	}
}