<?php

namespace extend;

use think\facade\Config;

class QQWry
{
    private static $instance;
    private $country = '';
    private $local = '';
    private $countryFlag = 0;
    private $fp;
    private $firstStartIp = 0;
    private $lastStartIp = 0;
    private $endIpOff = 0;
    private $startIp;
    private $endIp;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getStartIp($recNo)
    {
        $offset = $this->firstStartIp + $recNo * 7;
        @fseek($this->fp, $offset, SEEK_SET);
        $buf = fread($this->fp, 7);
        $this->endIpOff = ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256);
        $this->startIp =
            ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
        return $this->startIp;
    }

    private function getEndIp()
    {
        @fseek($this->fp, $this->endIpOff, SEEK_SET);
        $buf = fread($this->fp, 5);
        $this->endIp =
            ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
        $this->countryFlag = ord($buf[4]);
        return $this->endIp;
    }

    private function getCountry()
    {
        switch ($this->countryFlag) {
            case 1:
            case 2:
                $this->country = mb_convert_encoding($this->getFlagStr($this->endIpOff + 4), 'UTF-8', 'GBK');
                $this->local = mb_convert_encoding($this->countryFlag == 1 ?
                    '' : $this->getFlagStr($this->endIpOff + 8), 'UTF-8', 'GBK');
                break;
            default:
                $this->country = mb_convert_encoding($this->getFlagStr($this->endIpOff + 4), 'UTF-8', 'GBK');
                $this->local = mb_convert_encoding($this->getFlagStr(ftell($this->fp)), 'UTF-8', 'GBK');
        }
    }

    private function getFlagStr($offset)
    {
        while (1) {
            @fseek($this->fp, $offset, SEEK_SET);
            $flag = ord(fgetc($this->fp));
            if ($flag == 1 || $flag == 2) {
                $buf = fread($this->fp, 3);
                if ($flag == 2) {
                    $this->countryFlag = 2;
                    $this->endIpOff = $offset - 4;
                }
                $offset = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256);
            } else {
                break;
            }
        }
        if ($offset < 12) {
            return '';
        }
        @fseek($this->fp, $offset, SEEK_SET);
        return $this->getStr();
    }

    private function getStr()
    {
        $str = '';
        while (1) {
            $c = fgetc($this->fp);
            if (ord($c[0]) == 0) {
                break;
            }
            $str .= $c;
        }
        return $str;
    }

    private function QQwry($dotIp = '')
    {
        if (!$dotIp) {
            return '';
        }
        if (preg_match('/(^127)/', $dotIp)) {
            $this->country = '本地网络';
            return '';
        } elseif (preg_match('/(^192)/', $dotIp)) {
            $this->country = '局域网';
            return '';
        }
        $ip = $this->ipToInt($dotIp);
        $this->fp = fopen(Config::get('app.qqwry'), 'rb');
        if ($this->fp == null) {
            return 1;
        }
        @fseek($this->fp, 0, SEEK_SET);
        $buf = fread($this->fp, 8);
        $this->firstStartIp =
            ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
        $this->lastStartIp =
            ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256) + (ord($buf[7]) * 256 * 256 * 256);
        $RecordCount = floor(($this->lastStartIp - $this->firstStartIp) / 7);
        if ($RecordCount <= 1) {
            $this->country = 'FileDataError';
            fclose($this->fp);
            return 2;
        }
        $rangB = 0;
        $rangE = $RecordCount;
        while ($rangB < $rangE - 1) {
            $recNo = floor(($rangB + $rangE) / 2);
            $this->getStartIp($recNo);
            if ($ip == $this->startIp) {
                $rangB = $recNo;
                break;
            }
            if ($ip > $this->startIp) {
                $rangB = $recNo;
            } else {
                $rangE = $recNo;
            }
        }
        $this->getStartIp($rangB);
        $this->getEndIp();
        if (($this->startIp <= $ip) && ($this->endIp >= $ip)) {
            $this->getCountry();
        } else {
            $this->country = '未知';
            $this->local = '';
        }
        fclose($this->fp);
        return '';
    }

    private function ipToInt($ip)
    {
        $array = explode('.', $ip);
        return (($array[0] ?? 0) * 256 * 256 * 256) + (($array[1] ?? 0) * 256 * 256) + (($array[2] ?? 0) * 256) +
            ($array[3] ?? 0);
    }

    public function getVersion()
    {
        preg_match_all(
            '/[\d]{4}年[\d]{1,2}月[\d]{1,2}日/',
            mb_convert_encoding(file_get_contents(Config::get('app.qqwry')), 'UTF-8', 'GBK'),
            $version
        );
        return $version[0][0];
    }

    public function getAddr($ip = '')
    {
        $this->QQwry($ip);
        return trim(str_replace(' CZ88.NET', '', $this->country . ' ' . $this->local));
    }
}
