<?php
use think\facade\Config;

class QQWry{
	private $Country = '';
	private $Local = '';
	private $CountryFlag = 0;
	private $fp;
	private $FirstStartIp = 0;
	private $LastStartIp = 0;
	private $EndIpOff = 0;
	static private $instance;
	private $StartIp;
	private $EndIp;

	private function __construct(){}
	
	private function __clone(){}
	
	static public function getInstance(){
		if (!(self::$instance instanceof self)) self::$instance = new self();
		return self::$instance;
	}
	
	private function getStartIp($RecNo){
		$offset = $this->FirstStartIp + $RecNo * 7;
		@fseek($this->fp,$offset,SEEK_SET);
		$buf = fread($this->fp,7);
		$this->EndIpOff = ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256);
		$this->StartIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		return $this->StartIp;
	}
	
	private function getEndIp(){
		@fseek($this->fp,$this->EndIpOff,SEEK_SET);
		$buf = fread($this->fp,5);
		$this->EndIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		$this->CountryFlag = ord($buf[4]);
		return $this->EndIp;
	}

	private function getCountry(){
		switch($this->CountryFlag){
			case 1: 
			case 2: 
				$this->Country = mb_convert_encoding($this->getFlagStr($this->EndIpOff + 4),'UTF-8','GBK'); 
				$this->Local = mb_convert_encoding($this->CountryFlag == 1 ? '' : $this->getFlagStr($this->EndIpOff + 8),'UTF-8','GBK');
				break; 
			default: 
				$this->Country = mb_convert_encoding($this->getFlagStr($this->EndIpOff + 4),'UTF-8','GBK'); 
				$this->Local = mb_convert_encoding($this->getFlagStr(ftell($this->fp)),'UTF-8','GBK'); 
		}
	}
	
	private function getFlagStr($offset){
		while(1){
			@fseek($this->fp,$offset,SEEK_SET);
			$flag = ord(fgetc($this->fp));
			if($flag == 1 || $flag == 2){
				$buf = fread($this->fp,3);
				if($flag == 2){
					$this->CountryFlag = 2;
					$this->EndIpOff = $offset - 4;
				}
				$offset = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256);
			}else
				break;
		}
		if($offset < 12) return '';
		@fseek($this->fp,$offset,SEEK_SET);
		return $this->getStr();
	}

	private function getStr(){
		$str = '';
		while(1){
			$c = fgetc($this->fp);
			if(ord($c[0]) == 0) break;
			$str .= $c;
		}
		return $str;
	}

	private function QQwry($dotip = ''){
		if (!$dotip) return '';
		if (preg_match('/(^127)/',$dotip)){
			$this->Country = '本地网络';
			return '';
		}elseif (preg_match('/(^192)/',$dotip)){
			$this->Country = '局域网';
			return '';
		}
		$ip = $this->IpToInt($dotip);
		$this->fp = fopen(Config::get('app.qqwry'),'rb');
		if($this->fp == NULL){
			return 1;
		}
		@fseek($this->fp,0,SEEK_SET);
		$buf = fread($this->fp,8);
		$this->FirstStartIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		$this->LastStartIp = ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256) + (ord($buf[7]) * 256 * 256 * 256);
		$RecordCount = floor(($this->LastStartIp - $this->FirstStartIp) / 7);
		if($RecordCount <= 1){
			$this->Country = 'FileDataError';
			fclose($this->fp);
			return 2;
		}
		$RangB = 0;
		$RangE = $RecordCount;
		while($RangB < $RangE - 1){
			$RecNo = floor(($RangB + $RangE) / 2);
			$this->getStartIp($RecNo);
			if($ip == $this->StartIp){
				$RangB = $RecNo;
				break;
			}
			if($ip > $this->StartIp) $RangB = $RecNo;
			else $RangE = $RecNo;
		}
		$this->getStartIp($RangB);
		$this->getEndIp();
		if(($this->StartIp <= $ip) && ($this->EndIp >= $ip)){
			$this->getCountry();
		}else{
			$this->Country = '未知';
			$this->Local = '';
		}
		fclose($this->fp);
		return '';
	}
	
	private function IpToInt($Ip){
		$array = explode('.',$Ip);
		return (($array[0]??0) * 256 * 256 * 256) + (($array[1]??0) * 256 * 256) + (($array[2]??0) * 256) + ($array[3]??0);
	}

	public function getVersion(){
		preg_match_all('/[\d]{4}年[\d]{1,2}月[\d]{1,2}日/',mb_convert_encoding(file_get_contents(Config::get('app.qqwry')),'UTF-8','GBK'),$version);
		return $version[0][0];
	}
	
	public function getAddr($Ip=''){
		$this->QQwry($Ip);
		return trim(str_replace(' CZ88.NET','',$this->Country.' '.$this->Local));
	}
}