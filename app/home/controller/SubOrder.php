<?php
namespace app\home\controller;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use QQWry;
use think\facade\Request;
use think\facade\Config;
use app\home\model;

class SubOrder extends Base{
	public function index(){
		if (Request::isPost()){
			$Order = new model\Order();
			$object = $Order->add();
			if (is_array($object)){
				$this->sendmail($object);
				if (Request::post('pay') == 2){
					return $this->success(Config::get('app.web_url').Config::get('system.index_php').'pay/alipay/oid/'.$object['oid'].'.html');
				}elseif (Request::post('pay') == 6){
					return $this->success(Config::get('app.web_url').Config::get('system.index_php').'pay/wxpay/oid/'.$object['oid'].'.html');
				}
				return $this->success(NULL,$object['success'],0,2);
			}else{
				return $this->failed($object);
			}
		}
		return '';
	}
	
	private function sendmail($object){
		$Smtp = new model\Smtp();
		if ($Smtp->total() > 0){
			$object2 = $Smtp->one();
			if ($object2){
				try{
					include ROOT_PATH.'/extend/PHPMailer/SMTP.php';
					include ROOT_PATH.'/extend/PHPMailer/PHPMailer.php';
					$PHPMailer = new PHPMailer();
					$PHPMailer->CharSet = 'UTF-8';
					$PHPMailer->IsSMTP();
					$PHPMailer->SMTPAuth = true;
					$PHPMailer->Port = $object2[0]['port'];
					$PHPMailer->Host = $object2[0]['smtp'];
					$PHPMailer->Username = $object2[0]['user'];
					$PHPMailer->Password = $object2[0]['pass'];
					$PHPMailer->From = $object2[0]['email'];
					$PHPMailer->FromName = $object2[0]['email'];
					foreach (array_unique(array_filter(explode(',',Config::get('system.admin_mail').','.$object['admin_mail']))) as $value){
						$PHPMailer->AddAddress($value,$PHPMailer->FromName);
					}
					$PHPMailer->IsHTML(true);
					include ROOT_PATH.'/extend/QQWry.class.php';
					$PHPMailer->Subject = $this->mail(Config::get('system.mail_order_subject'),$object);
					$PHPMailer->Body = $this->mail(Config::get('system.mail_order_content'),$object);
					$PHPMailer->Send();
				}catch (Exception $e){
					echo $e->getMessage();
				}
			}
		}
	}
	
	private function mail($content,$object){
		return str_replace([
			'{oid}',
			'{proname}',
			'{proprice}',
			'{procount}',
			'{prototal}',
			'{name}',
			'{tel}',
			'{province}',
			'{city}',
			'{county}',
			'{town}',
			'{address}',
			'{post}',
			'{note}',
			'{email}',
			'{ip}',
			'{referrer}',
			'{pay}'
		],[
			$object['oid'] ?? '',
			$object['pro'] ?? '',
			$object['price'] ?? '',
			$object['count'] ?? '',
			isset($object['price']) ? number_format($object['price']*$object['count'],2,'.','') : '0.00',
			$object['name'] ?? '',
			$object['tel'] ?? '',
			$object['province'] ?? '',
			$object['city'] ?? '',
			$object['county'] ?? '',
			$object['town'] ?? '',
			$object['address'] ?? '',
			$object['post'] ?? '',
			$object['note'] ?? '',
			$object['email'] ?? '',
			isset($object['ip']) ? $object['ip'].' '.QQWry::getInstance()->getAddr($object['ip']) : '',
			isset($object['referrer']) ? $object['referrer']=='小程序' ? '小程序' : '<a href="'.$object['referrer'].'" target="_blank">'.$object['referrer'].'</a>' : '直接进入',
			Config::get('app.pay2')[$object['pay']]
		],$content);
	}
}