<?php

use app\admin\model;
use think\facade\Config;
use think\facade\Console;
use think\facade\Request;

//日期格式化
function dateFormat($timestamp = 0, $format = 'Y-m-d H:i:s')
{
    return date($format, $timestamp);
}

//密码加盐
function passEncode($pass = '', $passKey = '')
{
    $key = $passKey ? $passKey : Config::get('system.pass_key');
    return sha1(substr($key, 0, 10) . substr($key, 20, 10) . substr($key, 10, 10) . substr($key, 30, 10) . $pass);
}

//将数组转化成以逗号分隔的字符串，并且去掉最后的逗号
function arrToStr($object, $field)
{
    $str = '';
    foreach ($object as $value) {
        $str .= $value[$field] . ',';
    }
    return substr($str, 0, -1);
}

//文件下载
function downFile($content, $filename)
{
    ob_end_clean();
    header('Content-Encoding:none');
    header('Content-Type:application/octet' . (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? '' : '-') . 'stream');
    header('Content-Disposition:' .
        (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline' : 'attachment') . ';filename=' . $filename);
    header('Content-Length:' . strlen($content));
    header('Pragma:no-cache');
    header('Expires:0');
    echo $content;
    ob_get_contents();
}

//字符串截取
function truncate($data, $start = 0, $len = 80, $etc = '...', $magic = true)
{
    if ($len == '') {
        $len = strlen($data);
    }
    if ($start != 0) {
        $startV = ord(substr($data, $start, 1));
        if ($startV >= 128) {
            if ($startV < 192) {
                for ($i = $start - 1; $i > 0; $i--) {
                    $tempV = ord(substr($data, $i, 1));
                    if ($tempV >= 192) {
                        break;
                    }
                }
                $start = $i;
            }
        }
    }
    $aLen = $bLen = $realNum = $length = 0;
    for ($i = $start; $i < strlen($data); $i++) {
        $cType = $cStep = 0;
        $cur = substr($data, $i, 1);
        if ($cur == '&') {
            if (substr($data, $i, 4) == '&lt;') {
                $cStep = 4;
                $length += 4;
                $i += 3;
                $realNum++;
                if ($magic) {
                    $aLen++;
                }
            } elseif (substr($data, $i, 4) == '&gt;') {
                $cStep = 4;
                $length += 4;
                $i += 3;
                $realNum++;
                if ($magic) {
                    $aLen++;
                }
            } elseif (substr($data, $i, 5) == '&amp;') {
                $cStep = 5;
                $length += 5;
                $i += 4;
                $realNum++;
                if ($magic) {
                    $aLen++;
                }
            } elseif (substr($data, $i, 6) == '&quot;') {
                $cStep = 6;
                $length += 6;
                $i += 5;
                $realNum++;
                if ($magic) {
                    $aLen++;
                }
            } elseif (preg_match('/&#(\d+);?/i', substr($data, $i, 8), $match)) {
                $cStep = strlen($match[0]);
                $length += strlen($match[0]);
                $i += strlen($match[0]) - 1;
                $realNum++;
                if ($magic) {
                    $bLen++;
                    $cType = 1;
                }
            }
        } else {
            if (ord($cur) >= 252) {
                $cStep = 6;
                $length += 6;
                $i += 5;
                $realNum++;
                if ($magic) {
                    $bLen++;
                    $cType = 1;
                }
            } elseif (ord($cur) >= 248) {
                $cStep = 5;
                $length += 5;
                $i += 4;
                $realNum++;
                if ($magic) {
                    $cType = 1;
                    $bLen++;
                }
            } elseif (ord($cur) >= 240) {
                $cStep = 4;
                $length += 4;
                $i += 3;
                $realNum++;
                if ($magic) {
                    $cType = 1;
                    $bLen++;
                }
            } elseif (ord($cur) >= 224) {
                $cStep = 3;
                $length += 3;
                $i += 2;
                $realNum++;
                if ($magic) {
                    $cType = 1;
                    $bLen++;
                }
            } elseif (ord($cur) >= 192) {
                $cStep = 2;
                $length += 2;
                $i += 1;
                $realNum++;
                if ($magic) {
                    $cType = 1;
                    $bLen++;
                }
            } elseif (ord($cur) >= 128) {
                $length += 1;
            } else {
                $cStep = 1;
                $length += 1;
                $realNum++;
                if ($magic) {
                    ord($cur) >= 65 && ord($cur) <= 90 ? $bLen++ : $aLen++;
                }
            }
        }
        if ($magic) {
            if ($bLen * 2 + $aLen == $len * 2) {
                break;
            }
            if ($bLen * 2 + $aLen == $len * 2 + 1) {
                if ($cType == 1) {
                    $length -= $cStep;
                    break;
                } else {
                    break;
                }
            }
        } else {
            if ($realNum == $len) {
                break;
            }
        }
    }
    return strlen($data) <= $length ? $data : substr($data, $start, $length) . $etc;
}

//关键词加亮
function keyword($data, $keyword = '')
{
    return str_replace(
        $keyword ? $keyword : Request::get('keyword'),
        '<span class="keyword">' . ($keyword ? $keyword : Request::get('keyword')) . '</span>',
        $data
    );
}

//判断时间格式
function checkTime($data)
{
    return strtotime($data) ? strtotime($data) : time();
}

//生成随机字符串
function getKey($length)
{
    $key = '';
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[mt_rand(0, strlen($charset) - 1)];
    }
    return $key;
}

//透过代理获取用户真实IP
function getUserIp()
{
    $ip = '';
    if (
        isset($_SERVER['HTTP_X_FORWARDED_FOR']) &&
        $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')
    ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (
        isset($_SERVER['REMOTE_ADDR']) &&
        $_SERVER['REMOTE_ADDR'] &&
        strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')
    ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if (false !== strpos($ip, ', ')) {
        $array = explode(', ', $ip);
        $ip = reset($array);
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }
    return $ip;
}

//生成数据表缓存
function databaseSchema()
{
    $Common = new model\Common();
    foreach ($Common->info() as $value) {
        if (trim(Console::call('optimize:schema', ['--table', $value['Name']])->fetch()) != '<info>Succeed!</info>') {
            return false;
        }
    }
    return true;
}

//静态资源缓存后缀生成
function staticCache()
{
    if (Config::get('static.cache')) {
        return Config::get('static.cache');
    } else {
        $staticCache = time();
        file_put_contents(
            ROOT_PATH . '/' . Config::get('app.config_path') . '/static.php',
            '<?php

return [\'cache\' => ' . $staticCache . '];
'
        );
        return $staticCache;
    }
}
