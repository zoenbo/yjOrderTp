<?php
namespace QqLogin;

use think\facade\Config;
use think\facade\Session;

class Recorder{
	private static $data;
	private $inc;

	public function __construct($callback=''){
		$this->inc = json_decode('{"appid":"'.Config::get('system.qq_appid').'","appkey":"'.Config::get('system.qq_appkey').'","callback":"'.$callback.'","scope":"get_user_info"}');
		self::$data = Session::get('QC_userData') ? Session::get('QC_userData') : [];
	}

	public function write($name,$value){
		self::$data[$name] = $value;
	}

	public function read($name){
		return empty(self::$data[$name]) ? null : self::$data[$name];
	}

	public function readInc($name){
		return empty($this->inc->$name) ? null :$this->inc->$name;
	}

	function __destruct(){
		Session::set('QC_userData',self::$data);
	}
}