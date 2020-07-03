<?php

namespace app\home\model;

use app\home\validate\Order as valid;
use Exception;
use think\captcha\facade\Captcha;
use think\facade\Request;
use think\facade\Config;
use think\facade\Cookie;
use think\facade\Session;
use think\Model;

class Order extends Model
{
    //前台查单
    public function all()
    {
        try {
            $map['recycle'] = 0;
            if (Config::get('system.order_search_step') == '0') {
                $map['template_id'] = Request::get('template_id');
            }
            if (Request::get('field') == 1) {
                $map['order_id'] = Request::get('keyword');
            } elseif (Request::get('field') == 2) {
                $map['name'] = Request::get('keyword');
            } elseif (Request::get('field') == 3) {
                $map['tel'] = Request::get('keyword');
            }
            return $this->field('id,order_id,manager_id,template_id,product_id,price,count,name,tel,province,city,' .
                'county,town,address,post,note,email,ip,qqau,referrer,pay,order_state_id,logistics_id,' .
                'logistics_number,date')
                ->where($map)
                ->order(['date' => 'DESC'])
                ->select()
                ->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //查询支付信息
    public function one($orderId = 0)
    {
        try {
            $map = [
                'order_id' => $orderId ? $orderId : Request::param('oid'),
                'recycle' => 0
            ];
            return $this->field('template_id,product_id,price,count,pay')->where($map)->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    //添加
    public function add()
    {
        $Template = new Template();
        $object = $Template->one(Request::post('template_id'));
        if (!$object) {
            return '此下单模板已被删除！';
        }
        $scene = [
            'count',
            'pay'
        ];
        $data = [
            'id' => '',
            'order_id' => time() . rand(100, 999),
            'manager_id' => $object['manager_id'],
            'template_id' => Request::post('template_id'),
            'product_id' => Request::post('product_id'),
            'referrer' => Request::post('referrer'),
            'pay' => Request::post('pay'),
            'order_state_id' => $object['order_state_id'],
            'ip' => getUserIp(),
            'date' => time()
        ];
        $data['success'] = str_replace('{oid}', $data['order_id'], $object['success']);
        $fieldTemp = explode(',', $object['field']);
        $data['count'] = in_array(1, $fieldTemp) ? Request::post('count') : 1;
        if (in_array(2, $fieldTemp) || Request::post('name')) {
            $data['name'] = Request::post('name');
            $scene[] = 'name';
        }
        if (in_array(3, $fieldTemp) || Request::post('tel')) {
            $data['tel'] = Request::post('tel');
            $scene[] = 'tel';
        }
        if (in_array(4, $fieldTemp) && in_array(5, $fieldTemp)) {
            if (Request::post('type') == 'a') {
                $data['province'] = Request::post('province');
                $data['city'] = Request::post('city');
                $data['county'] = Request::post('county');
                $data['town'] = Request::post('town');
                $scene[] = 'province';
                $scene[] = 'city';
                $scene[] = 'county';
                $scene[] = 'town';
            } elseif (Request::post('type') == 'b') {
                $data['province'] = Request::post('province2');
                $data['city'] = Request::post('city2');
                $data['county'] = Request::post('county2');
                $data['town'] = Request::post('town2');
                $scene[] = 'province2';
                $scene[] = 'city2';
                $scene[] = 'county2';
                $scene[] = 'town2';
            }
        } elseif (in_array(4, $fieldTemp)) {
            $data['province'] = Request::post('province');
            $data['city'] = Request::post('city');
            $data['county'] = Request::post('county');
            $data['town'] = Request::post('town');
            $scene[] = 'province';
            $scene[] = 'city';
            $scene[] = 'county';
            $scene[] = 'town';
        } elseif (in_array(5, $fieldTemp)) {
            $data['province'] = Request::post('province2');
            $data['city'] = Request::post('city2');
            $data['county'] = Request::post('county2');
            $data['town'] = Request::post('town2');
            $scene[] = 'province2';
            $scene[] = 'city2';
            $scene[] = 'county2';
            $scene[] = 'town2';
        }
        if (in_array(6, $fieldTemp) || Request::post('address')) {
            $data['address'] = Request::post('address');
            $scene[] = 'address';
        }
        if (in_array(7, $fieldTemp) || Request::post('post')) {
            $data['post'] = Request::post('post');
            $scene[] = 'post';
        }
        if (in_array(8, $fieldTemp) || Request::post('note')) {
            $data['note'] = Request::post('note');
            $scene[] = 'note';
        }
        if (in_array(9, $fieldTemp) || Request::post('email')) {
            $data['email'] = Request::post('email');
            $scene[] = 'email';
        }

        $Product = new Product();
        $object2 = $Product->one(Request::post('product_id'));

        if ($object2) {
            $data['pro'] = $object2['name'];
            $data['price'] = $object2['price'];
        } else {
            return '不存在此产品，或已被删除，无法下单！';
        }
        $data['admin_mail'] = $object2['email'];
        if ($object['is_qq']) {
            $session = Session::get('QC_userData');
            if (strlen($session['openid']) == 32) {
                $data['qqau'] = $session['openid'];
            } else {
                return '请登录QQ后下单！';
            }
        }
        $validate = new valid();
        if ($validate->only($scene)->check($data)) {
            if ($object['is_captcha']) {
                $captcha = Config::get('captcha');
                if (
                    isset($captcha[$object['is_captcha']]) &&
                    !Captcha::check(Request::post('captcha'), $object['is_captcha'])
                ) {
                    return '验证码不正确！';
                }
            }
            if ($this->repeat($object['is_qq'])) {
                return $object['often'];
            }
            if (Config::get('system.order_db') == '0') {
                return $data;
            }
            $id = $this->save($data);
            if ($id) {
                Cookie::delete('verify');
                return $data;
            } else {
                return 0;
            }
        } else {
            return $validate->getError();
        }
    }

    //修改支付状态
    public function modify($orderId, $pay, $payId = 0, $payScene = '', $payDate = '')
    {
        $data = [
            'pay' => $pay,
            'pay_id' => $payId,
            'pay_scene' => $payScene,
            'pay_date' => $payDate
        ];
        return $this->where(['order_id' => $orderId])->update($data);
    }

    //验证重复
    private function repeat($qq)
    {
        try {
            $map['where'] = '`recycle`=:recycle AND `date`>=:date AND (`ip`=:ip';
            $map['value'] = [
                'ip' => getUserIp(),
                'recycle' => 0,
                'date' => time() - Config::get('system.order_time') * 60
            ];
            if ($qq) {
                $session = Session::get('QC_userData');
                $map['where'] .= ' OR `qqau`=:qqau';
                $map['value']['qqau'] = $session['openid'];
            }
            $map['where'] .= ')';
            return $this->field('id')->where($map['where'], $map['value'])->find();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}
