<?php
use think\facade\Config;
use think\facade\Console;
use think\facade\Request;

//日期格式化
function dateFormat($timestamp=0,$format='Y-m-d H:i:s'){
	return date($format,$timestamp);
}

//密码加盐
function passEncode($pass='',$passKey=''){
	$key = $passKey ? $passKey : Config::get('system.pass_key');
	return sha1(substr($key,0,10).substr($key,20,10).substr($key,10,10).substr($key,30,10).$pass);
}

//将数组转化成以逗号分隔的字符串，并且去掉最后的逗号
function arrToStr($object,$field){
	$str = '';
	foreach ($object as $value){
		$str .= $value[$field].',';
	}
	return substr($str,0,-1);
}

//文件下载
function downFile($content,$filename){
	@ob_end_clean();
	header('Content-Encoding: none');
	header('Content-Type: '.(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
	header('Content-Disposition: '.(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'inline;' : 'attachment;').' filename='.$filename);
	header('Content-Length: '.strlen($content));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $content;
	ob_get_contents();
}

//字符串截取
function truncate($data,$start=0,$len=80,$etc='...',$magic=true){
	if ($len == '') $len = strlen($data);
	if ($start != 0){
		$startv = ord(substr($data,$start,1));
		if ($startv >= 128){
			if ($startv < 192){
				for ($i=$start-1;$i>0;$i--){
					$tempv = ord(substr($data,$i,1));
					if ($tempv >= 192) break;
				}
				$start = $i;
			}
		}
	}
	$alen = $blen = $realnum = $length = 0;
	for ($i=$start;$i<strlen($data);$i++){
		$ctype = $cstep = 0;
		$cur = substr($data,$i,1);
		if ($cur == '&'){
			if (substr($data,$i,4) == '&lt;'){
				$cstep = 4;
				$length += 4;
				$i += 3;
				$realnum ++;
				if ($magic) $alen ++;
			}elseif (substr($data,$i,4) == '&gt;'){
				$cstep = 4;
				$length += 4;
				$i += 3;
				$realnum ++;
				if ($magic) $alen ++;
			}elseif (substr($data,$i,5) == '&amp;'){
				$cstep = 5;
				$length += 5;
				$i += 4;
				$realnum ++;
				if ($magic)$alen ++;
			}elseif (substr($data,$i,6) == '&quot;'){
				$cstep = 6;
				$length += 6;
				$i += 5;
				$realnum ++;
				if ($magic) $alen ++;
			}elseif (preg_match('/&#(\d+);?/i',substr($data,$i,8),$match)){
				$cstep = strlen($match[0]);
				$length += strlen($match[0]);
				$i += strlen($match[0])-1;
				$realnum ++;
				if ($magic){
					$blen ++;
					$ctype = 1;
				}
			}
		}else{
			if (ord($cur)>=252){
				$cstep = 6;
				$length += 6;
				$i += 5;
				$realnum ++;
				if ($magic){
					$blen ++;
					$ctype = 1;
				}
			}elseif (ord($cur)>=248){
				$cstep = 5;
				$length += 5;
				$i += 4;
				$realnum ++;
				if ($magic){
					$ctype = 1;
					$blen ++;
				}
			}elseif (ord($cur)>=240){
				$cstep = 4;
				$length += 4;
				$i += 3;
				$realnum ++;
				if ($magic){
					$ctype = 1;
					$blen ++;
				}
			}elseif (ord($cur)>=224){
				$cstep = 3;
				$length += 3;
				$i += 2;
				$realnum ++;
				if ($magic){
					$ctype = 1;
					$blen ++;
				}
			}elseif (ord($cur)>=192){
				$cstep = 2;
				$length += 2;
				$i += 1;
				$realnum ++;
				if ($magic){
					$ctype = 1;
					$blen ++;
				}
			}elseif (ord($cur)>=128){
				$length += 1;
			}else{
				$cstep = 1;
				$length +=1;
				$realnum ++;
				if ($magic) ord($cur) >= 65 && ord($cur) <= 90 ? $blen++ : $alen++;
			}
		}
		if ($magic){
			if (($blen*2+$alen) == ($len*2)) break;
			if (($blen*2+$alen) == ($len*2+1)){
				if ($ctype == 1){
					$length -= $cstep;
					break;
				}else{
					break;
				}
			}
		}else{
			if ($realnum == $len) break;
		}
	}
	return strlen($data)<=$length ? $data : substr($data,$start,$length).$etc;
}

//关键词加亮
function keyword($data,$keyword=''){
	return str_replace($keyword?$keyword:Request::get('keyword'),'<span class="keyword">'.($keyword?$keyword:Request::get('keyword')).'</span>',$data);
}

//判断时间格式
function checkTime($data){
	return strtotime($data) ? strtotime($data) : time();
}

//生成随机字符串
function getKey($length){
	$key = '';
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	for ($i=0;$i<$length;$i++){
		$key .= $charset[mt_rand(0,strlen($charset)-1)];
	}
	return $key;
}

//透过代理获取用户真实IP
function getUserIp(){
	$ip = '';
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'],'unknown')){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	if (false !== strpos($ip,',')){
		$array = explode(',',$ip);
		$ip = reset($array);
	}
	if ($ip == '::1') $ip = '127.0.0.1';
	return $ip;
}

//生成数据表缓存
function databaseSchema(){
    if (trim(Console::call('optimize:schema', ['--connection','mysql'])->fetch()) != '<info>Succeed!</info>') {
        return false;
    }
    $mysql = Config::get('database.connections.mysql');
    if (!is_dir($mysql['schema_cache_path'])) {
        return true;
    }
    $handler = opendir($mysql['schema_cache_path']);
    while (!!$name = readdir($handler)) {
        if (!in_array($name, ['.', '..']) && strstr($name, $mysql['database'] . '.' . $mysql['prefix']) === false) {
            if (!unlink($mysql['schema_cache_path'] . $name)) {
                return false;
            }
        }
    }
    closedir($handler);
    return true;
}

//静态资源缓存后缀生成
function staticCache(){
	if (Config::get('static.cache')){
		return Config::get('static.cache');
	}else{
		$staticCache = time();
		file_put_contents(ROOT_PATH.'/'.Config::get('app.config_path').'/static.php','<?php return [\'cache\'=>'.$staticCache.'];');
		return $staticCache;
	}
}