<?php

namespace app\common\controller;

use app\home\model;
use think\facade\Config;

class Template
{
    public function html($id, $demo = 0)
    {
        $templates = [
            0 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order1.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    width:950px;
    background:#EBF7FF;
    border:1px solid #B8E3FF;
}
.order .left{
    border-right:1px solid #B8E3FF;
}
.order .left dl dd.submit input{
    background:#09F;
}
.order .left .buy,.order .right .send{
    border-bottom:1px solid #B8E3FF;
}
.order dl dd .layui-form-select dl dd.layui-this{
	background:#09F;
}
</style>

<div class="order">
  <div class="left">
    <div class="buy"></div>
    
    <form method="post" action="" target="_parent" class="form layui-form">
      <dl class="order_form">
        <dd>请认真填写订单信息，以便您尽快收到货物</dd>
        <dd class="pro">订购产品：<select name="product_id"></select></dd>
        <dd>订购数量：<input type="text" name="count" value="1" class="text"></dd>
        <dd>姓　　名：<input type="text" name="name" class="text"></dd>
        <dd>联系电话：<input type="text" name="tel" class="text"></dd>
        <dd>所在地区：<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
            '<label><input type="radio" name="type" value="b">手动填写</label></dd>
		<div id="aa">
		<input type="hidden" name="province">
		<input type="hidden" name="city">
		<input type="hidden" name="county">
		<input type="hidden" name="town">
        <dd>　　　　　<select class="province" lay-filter="province"><option value="0">省份</option></select></dd>
        <dd>　　　　　<select class="city" lay-filter="city"><option value="0">城市</option></select></dd>
        <dd>　　　　　<select class="county" lay-filter="county"><option value="0">区/县</option></select></dd>
        <dd>　　　　　<select class="town" lay-filter="town"><option value="0">乡镇/街道（若不清楚，可不选）</option></select></dd>
		</div>
		<div id="bb">
		<dd>省　　份：<input type="text" name="province2" class="text"></dd>
		<dd>城　　市：<input type="text" name="city2" class="text"></dd>
		<dd>区 / 县 ：<input type="text" name="county2" class="text"></dd>
		<dd>乡镇/街道：<input type="text" name="town2" class="text" style="width:435px;" placeholder="若不清楚，可留空"></dd>
		</div>
        <dd>详细地址：<input type="text" name="address" class="text"></dd>
        <dd>邮政编码：<input type="text" name="post" maxlength="6" class="text2"></dd>
        <dd class="textarea"><span>备　　注：</span><textarea name="note"></textarea></dd>
        <dd>电子邮箱：<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></dd>
        <dd>支付方式：<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
            '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
            '<label><input type="radio" name="pay" value="6">微信支付</label></dd>
        <dd class="captcha"><span>验 证 码：<input type="text" name="captcha" class="text2"></span> <img src="' .
            Config::get('system.index_php') . 'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php')
            . 'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></dd>
        <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
        <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
            staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
            'common/qq\',\'qq\')"></dd>
      </dl>
    </form>
    
    <form method="get" action="" target="_blank" class="search">
      <dl>
        <input type="hidden" name="template_id" value="">
        <dd>订单查询</dd>
        <dd>查询方式：<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
            '<label><input type="radio" name="field" value="2">姓名</label> ' .
            '<label><input type="radio" name="field" value="3">联系电话</label></dd>
        <dd>关 键 词：<input type="text" name="keyword" class="text"></dd>
        <dd class="submit"><input type="submit" value="查询订单"></dd>
      </dl>
    </form>
  </div>
  
  <div class="right">
    <div class="send"></div><div class="list"><div class="list1"></div><div class="list2"></div></div>
  </div>
  
  <p style="clear:both"></p>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>',
            1 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order2.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    background-color:#423628;
    color:yellow;
}
</style>

<div class="order">
  <form method="post" action="" target="_parent" class="form layui-form">
    <dl class="order_form">
      <dd>请认真填写订单信息，以便您尽快收到货物</dd>
      <dd class="pro">订购产品：<select name="product_id"></select></dd>
      <dd>订购数量：<input type="text" name="count" value="1" class="text"></dd>
      <dd>姓　　名：<input type="text" name="name" class="text"></dd>
      <dd>联系电话：<input type="text" name="tel" class="text"></dd>
      <dd>所在地区：<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
            '<label><input type="radio" name="type" value="b">手动填写</label></dd>
	  <div id="aa">
	  <input type="hidden" name="province">
	  <input type="hidden" name="city">
	  <input type="hidden" name="county">
	  <input type="hidden" name="town">
      <dd>　　　　　<select class="province" lay-filter="province"><option value="0">省份</option></select></dd>
      <dd>　　　　　<select class="city" lay-filter="city"><option value="0">城市</option></select></dd>
      <dd>　　　　　<select class="county" lay-filter="county"><option value="0">区/县</option></select></dd>
      <dd>　　　　　<select class="town" lay-filter="town"><option value="0">乡镇/街道（若不清楚，可不选）</option></select></dd>
	  </div>
	  <div id="bb">
	  <dd>省　　份：<input type="text" name="province2" class="text"></dd>
	  <dd>城　　市：<input type="text" name="city2" class="text"></dd>
	  <dd>区 / 县 ：<input type="text" name="county2" class="text"></dd>
	  <dd>乡镇/街道：<input type="text" name="town2" class="text" style="width:435px;" placeholder="若不清楚，可留空"></dd>
	  </div>
      <dd>详细地址：<input type="text" name="address" class="text"></dd>
      <dd>邮政编码：<input type="text" name="post" maxlength="6" class="text2"></dd>
      <dd class="textarea"><span>备　　注：</span><textarea name="note"></textarea></dd>
      <dd>电子邮箱：<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></dd>
      <dd>支付方式：<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
            '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
            '<label><input type="radio" name="pay" value="6">微信支付</label></dd>
      <dd class="captcha"><span>验 证 码：<input type="text" name="captcha" class="text2"></span> <img src="' .
            Config::get('system.index_php') . 'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php')
            . 'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></dd>
      <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
      <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
            staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
            'common/qq\',\'qq\')"></dd>
    </dl>
  </form>
  
  <form method="get" action="" target="_blank" class="search">
    <dl>
      <input type="hidden" name="template_id" value="">
      <dd>订单查询</dd>
      <dd>查询方式：<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
          '<label><input type="radio" name="field" value="2">姓名</label> ' .
          '<label><input type="radio" name="field" value="3">联系电话</label></dd>
      <dd>关 键 词：<input type="text" name="keyword" class="text"></dd>
      <dd class="submit"><input type="submit" value="查询订单"></dd>
    </dl>
  </form>
  
  <p>&nbsp;</p>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>',
            2 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order3.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    background:#EBF7FF;
    border:1px solid #B8E3FF;
}
.order .buy{
    border-bottom:1px solid #B8E3FF;
}
.order dl dd.submit input{
    background:#09F;
}
.order dl dd .layui-form-select dl dd.layui-this{
	background:#09F;
}
</style>

<div class="order">
  <div class="buy"></div>
  
  <form method="post" action="" target="_parent" class="form layui-form">
    <dl class="order_form">
      <dd class="center">请认真填写订单信息，以便您尽快收到货物</dd>
      <dd class="pro"><span class="left">订购产品：</span><span class="right"><select name="product_id"></select></span></dd>
      <dd><span class="left">订购数量：</span><span class="right">' .
            '<input type="text" name="count" value="1" class="text"></span></dd>
      <dd><span class="left">姓　　名：</span><span class="right"><input type="text" name="name" class="text"></span></dd>
      <dd><span class="left">联系电话：</span><span class="right"><input type="text" name="tel" class="text"></span></dd>
      <dd><span class="left">所在地区：</span><span class="right">' .
            '<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
            '<label><input type="radio" name="type" value="b">手动填写</label></span></dd>
	  <div id="aa">
	  <input type="hidden" name="province">
	  <input type="hidden" name="city">
	  <input type="hidden" name="county">
	  <input type="hidden" name="town">
      <dd><span class="left"></span><span class="right"><select class="province" lay-filter="province">' .
                '<option value="0">省份</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="city" lay-filter="city">' .
                '<option value="0">城市</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="county" lay-filter="county">' .
                '<option value="0">区/县</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>
	  </div>
	  <div id="bb">
      <dd><span class="left">省　　份：</span><span class="right"><input type="text" name="province2" class="text"></span>' .
            '</dd>
	  <dd><span class="left">城　　市：</span><span class="right"><input type="text" name="city2" class="text"></span>' .
            '</dd>
	  <dd><span class="left">区 / 县 ：</span><span class="right"><input type="text" name="county2" class="text"></span>' .
            '</dd>
	  <dd><span class="left">乡镇/街道：</span><span class="right">' .
            '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>
	  </div>
      <dd><span class="left">详细地址：</span><span class="right"><input type="text" name="address" class="text"></span></dd>
      <dd><span class="left">邮政编码：</span><span class="right">' .
            '<input type="text" name="post" maxlength="6" class="text"></span></dd>
      <dd class="textarea"><span class="left">备　　注：</span><span class="right"><textarea name="note"></textarea>' .
            '</span></dd>
      <dd><span class="left">电子邮箱：</span><span class="right">' .
            '<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></span></dd>
      <dd class="pay"><span class="left">支付方式：</span><span class="right">' .
            '<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
            '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
            '<label><input type="radio" name="pay" value="6">微信支付</label></span></dd>
      <dd><span class="left">验 证 码：</span><span class="right"><input type="text" name="captcha" class="text2"></span>' .
            '</dd>
      <dd class="captcha"><span class="left"></span><span class="right"><img src="' . Config::get('system.index_php') .
            'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php') .
            'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></span></dd>
      <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
      <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
            staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
            'common/qq\',\'qq\')"></dd>
    </dl>
  </form>
  
  <form method="get" action="" target="_blank" class="search">
    <dl>
      <input type="hidden" name="template_id" value="">
      <dd class="center">订单查询</dd>
      <dd><span class="left">查询方式：</span><span class="right">' .
            '<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
            '<label><input type="radio" name="field" value="2">姓名</label> ' .
            '<label><input type="radio" name="field" value="3">联系电话</label></span></dd>
      <dd><span class="left">关 键 词：</span><span class="right">' .
            '<input type="text" name="keyword" class="text"></span></dd>
      <dd class="submit"><input type="submit" value="查询订单"></dd>
    </dl>
  </form>
  
  <div class="new"></div>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>',
            3 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order3.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    background:#FFF;
    border:3px solid #FC4400;
}
.order .buy{
    border-bottom:1px solid #FC4400;
}
.order dl dd.submit input{
    background:#F63;
}
.order dl dd .layui-form-select dl dd.layui-this{
	background:#F63;
}
</style>

<div class="order">
  <div class="buy2">在线快速订购</div>
  
  <form method="post" action="" target="_parent" class="form layui-form">
    <dl class="order_form">
      <dd class="pro"><span class="left">订购产品：</span><span class="right"><select name="product_id"></select></span></dd>
      <dd><span class="left">订购数量：</span><span class="right"><input type="text" name="count" value="1" class="text">' .
            '</span></dd>
      <dd><span class="left">姓　　名：</span><span class="right"><input type="text" name="name" class="text"></span></dd>
      <dd><span class="left">联系电话：</span><span class="right"><input type="text" name="tel" class="text"></span></dd>
      <dd><span class="left">所在地区：</span><span class="right"><label><input type="radio" name="type" value="a" checked>'
            . '选择填写</label> <label><input type="radio" name="type" value="b">手动填写</label></span></dd>
	  <div id="aa">
	  <input type="hidden" name="province">
	  <input type="hidden" name="city">
	  <input type="hidden" name="county">
	  <input type="hidden" name="town">
      <dd><span class="left"></span><span class="right"><select class="province" lay-filter="province">' .
                '<option value="0">省份</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="city" lay-filter="city">' .
                '<option value="0">城市</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="county" lay-filter="county">' .
                '<option value="0">区/县</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>
	  </div>
	  <div id="bb">
      <dd><span class="left">省　　份：</span><span class="right"><input type="text" name="province2" class="text">' .
            '</span></dd>
	  <dd><span class="left">城　　市：</span><span class="right"><input type="text" name="city2" class="text"></span></dd>
	  <dd><span class="left">区 / 县 ：</span><span class="right"><input type="text" name="county2" class="text">' .
            '</span></dd>
	  <dd><span class="left">乡镇/街道：</span><span class="right">' .
            '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>
	  </div>
      <dd><span class="left">详细地址：</span><span class="right"><input type="text" name="address" class="text"></span></dd>
      <dd><span class="left">邮政编码：</span><span class="right">' .
            '<input type="text" name="post" maxlength="6" class="text"></span></dd>
      <dd class="textarea"><span class="left">备　　注：</span><span class="right"><textarea name="note"></textarea>' .
            '</span></dd>
      <dd><span class="left">电子邮箱：</span><span class="right">' .
            '<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></span></dd>
      <dd class="pay"><span class="left">支付方式：</span><span class="right">' .
            '<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
            '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
            '<label><input type="radio" name="pay" value="6">微信支付</label></span></dd>
      <dd><span class="left">验 证 码：</span><span class="right"><input type="text" name="captcha" class="text2"></span>' .
            '</dd>
      <dd class="captcha"><span class="left"></span><span class="right"><img src="' . Config::get('system.index_php') .
            'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php') .
            'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></span></dd>
      <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
      <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
            staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
            'common/qq\',\'qq\')"></dd>
    </dl>
  </form>
  
  <form method="get" action="" target="_blank" class="search">
    <dl>
      <input type="hidden" name="template_id" value="">
      <dd class="center">订单查询</dd>
      <dd><span class="left">查询方式：</span><span class="right">' .
            '<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
            '<label><input type="radio" name="field" value="2">姓名</label> ' .
            '<label><input type="radio" name="field" value="3">联系电话</label></span></dd>
      <dd><span class="left">关 键 词：</span><span class="right"><input type="text" name="keyword" class="text"></span>' .
            '</dd>
      <dd class="submit"><input type="submit" value="查询订单"></dd>
    </dl>
  </form>
  
  <div class="new"></div>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>',
            4 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order4.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    background:#FFF;
    border:1px solid #FC4400;
}
.order .buy{
    border-bottom:1px solid #FC4400;
}
.order dl dd.submit input{
    background:#F63;
}
.order dl dd .layui-form-select dl dd.layui-this{
	background:#F63;
}
</style>

<div class="order">
  <div class="buy"></div>
  
  <form method="post" action="" target="_parent" class="form layui-form">
    <dl class="order_form">
      <dd class="pro"><span class="left">订购产品：</span><span class="right"><select name="product_id"></select></span></dd>
      <dd><span class="left">订购数量：</span><span class="right">' .
            '<input type="text" name="count" value="1" class="text"></span></dd>
      <dd><span class="left">姓　　名：</span><span class="right"><input type="text" name="name" class="text"></span></dd>
      <dd><span class="left">联系电话：</span><span class="right"><input type="text" name="tel" class="text"></span></dd>
      <dd><span class="left">所在地区：</span><span class="right">' .
            '<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
            '<label><input type="radio" name="type" value="b">手动填写</label></span></dd>
	  <div id="aa">
	  <input type="hidden" name="province">
	  <input type="hidden" name="city">
	  <input type="hidden" name="county">
	  <input type="hidden" name="town">
      <dd><span class="left"></span><span class="right"><select class="province" lay-filter="province">' .
                '<option value="0">省份</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="city" lay-filter="city">' .
                '<option value="0">城市</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="county" lay-filter="county">' .
                '<option value="0">区/县</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>
	  </div>
	  <div id="bb">
      <dd><span class="left">省　　份：</span><span class="right">' .
            '<input type="text" name="province2" class="text"></span></dd>
	  <dd><span class="left">城　　市：</span><span class="right"><input type="text" name="city2" class="text"></span></dd>
	  <dd><span class="left">区 / 县 ：</span><span class="right"><input type="text" name="county2" class="text"></span>' .
            '</dd>
	  <dd><span class="left">乡镇/街道：</span><span class="right">' .
            '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>
	  </div>
      <dd><span class="left">详细地址：</span><span class="right"><input type="text" name="address" class="text"></span></dd>
      <dd><span class="left">邮政编码：</span><span class="right">' .
            '<input type="text" name="post" maxlength="6" class="text"></span></dd>
      <dd class="textarea"><span class="left">备　　注：</span><span class="right"><textarea name="note"></textarea>' .
            '</span></dd>
      <dd><span class="left">电子邮箱：</span><span class="right">' .
            '<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></span></dd>
      <dd class="pay"><span class="left">支付方式：</span><span class="right">' .
            '<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
            '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
            '<label><input type="radio" name="pay" value="6">微信支付</label></span></dd>
      <dd><span class="left">验 证 码：</span><span class="right"><input type="text" name="captcha" class="text2"></span>' .
            '</dd>
      <dd class="captcha"><span class="left"></span><span class="right"><img src="' . Config::get('system.index_php') .
            'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php') .
            'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></span></dd>
      <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
      <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
            staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
            'common/qq\',\'qq\')"></dd>
    </dl>
  </form>
  
  <form method="get" action="" target="_blank" class="search">
    <dl>
      <input type="hidden" name="template_id" value="">
      <dd class="center">订单查询</dd>
      <dd><span class="left">查询方式：</span><span class="right">' .
            '<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
            '<label><input type="radio" name="field" value="2">姓名</label> ' .
            '<label><input type="radio" name="field" value="3">联系电话</label></span></dd>
      <dd><span class="left">关 键 词：</span><span class="right"><input type="text" name="keyword" class="text"></span>' .
            '</dd>
      <dd class="submit"><input type="submit" value="查询订单"></dd>
    </dl>
  </form>
  
  <div class="new"></div>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>',
            5 => '<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>填写订单</title>
<base href="' . Config::get('app.web_url') . '">
<script type="text/javascript" src="public/base/jquery.js?' . staticCache() . '"></script>
</head>

<body>
<script type="text/javascript" src="public/base/jquery.cookie.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/ValidForm.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/Address.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?' . staticCache() . '"></script>
<script type="text/javascript" src="public/home/js/Order.js?' . staticCache() . '"></script>
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?' . staticCache() . '">
<link rel="stylesheet" type="text/css" href="public/home/styles/Order5.css?' . staticCache() . '">
<script type="text/javascript">let DISTRICT="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'common/district";</script>
<style type="text/css">
.order{
    background:#FFF;
    border:1px solid #FFF;
}
.order .buy{
    border-bottom:1px solid #FFF;
}
.order dl dd.submit input{
    background:#BE0F22;
}
.order dl dd .layui-form-select dl dd.layui-this{
	background:#BE0F22;
}
</style>

<div class="order">
  <div class="buy"></div>
  
  <form method="post" action="" target="_parent" class="form layui-form">
    <dl class="order_form">
      <dd class="pro"><span class="left">订购产品：</span><span class="right"><select name="product_id"></select></span></dd>
      <dd><span class="left">订购数量：</span><span class="right"><input type="text" name="count" value="1" class="text">' .
                '</span></dd>
      <dd><span class="left">姓　　名：</span><span class="right"><input type="text" name="name" class="text"></span></dd>
      <dd><span class="left">联系电话：</span><span class="right"><input type="text" name="tel" class="text"></span></dd>
      <dd><span class="left">所在地区：</span><span class="right">' .
                '<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
                '<label><input type="radio" name="type" value="b">手动填写</label></span></dd>
	  <div id="aa">
	  <input type="hidden" name="province">
	  <input type="hidden" name="city">
	  <input type="hidden" name="county">
	  <input type="hidden" name="town">
      <dd><span class="left"></span><span class="right"><select class="province" lay-filter="province">' .
                '<option value="0">省份</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="city" lay-filter="city">' .
                '<option value="0">城市</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="county" lay-filter="county">' .
                '<option value="0">区/县</option></select></span></dd>
      <dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>
	  </div>
	  <div id="bb">
      <dd><span class="left">省　　份：</span><span class="right"><input type="text" name="province2" class="text"></span>' .
                '</dd>
	  <dd><span class="left">城　　市：</span><span class="right"><input type="text" name="city2" class="text"></span></dd>
	  <dd><span class="left">区 / 县 ：</span><span class="right"><input type="text" name="county2" class="text"></span>' .
                '</dd>
	  <dd><span class="left">乡镇/街道：</span><span class="right">' .
                '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>
	  </div>
      <dd><span class="left">详细地址：</span><span class="right"><input type="text" name="address" class="text"></span></dd>
      <dd><span class="left">邮政编码：</span><span class="right">' .
                '<input type="text" name="post" maxlength="6" class="text"></span></dd>
      <dd class="textarea"><span class="left">备　　注：</span><span class="right"><textarea name="note"></textarea>' .
                '</span></dd>
      <dd><span class="left">电子邮箱：</span><span class="right">' .
                '<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></span></dd>
      <dd class="pay"><span class="left">支付方式：</span><span class="right">' .
                '<label><input type="radio" name="pay" value="1" checked>货到付款</label> ' .
                '<label><input type="radio" name="pay" value="2">支付宝</label> ' .
                '<label><input type="radio" name="pay" value="6">微信支付</label></span></dd>
      <dd><span class="left">验 证 码：</span><span class="right"><input type="text" name="captcha" class="text2"></span>' .
                '</dd>
      <dd class="captcha"><span class="left"></span><span class="right"><img src="' . Config::get('system.index_php') .
                'common/captcha2" onClick="this.src=\'' . Config::get('system.index_php') .
                'common/captcha2?tm=\'+Math.random();" alt="验证码" title="看不清？换一张"></span></dd>
      <dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>
      <dd class="submit"><input type="submit" value="立即提交订单"> <img src="public/home/images/qq_login.png?' .
                staticCache() . '" alt="QQ登录" onClick="window.open(\'' . Config::get('system.index_php') .
                'common/qq\',\'qq\')"></dd>
    </dl>
  </form>
  
  <form method="get" action="" target="_blank" class="search">
    <dl>
      <input type="hidden" name="template_id" value="">
      <dd class="center">订单查询</dd>
      <dd><span class="left">查询方式：</span><span class="right">' .
                '<label><input type="radio" name="field" value="1" checked>订单号</label> ' .
                '<label><input type="radio" name="field" value="2">姓名</label> ' .
                '<label><input type="radio" name="field" value="3">联系电话</label></span></dd>
      <dd><span class="left">关 键 词：</span><span class="right"><input type="text" name="keyword" class="text"></span>' .
                '</dd>
      <dd class="submit"><input type="submit" value="查询订单"></dd>
    </dl>
  </form>
  
  <div class="new"></div>
</div>

<script type="text/javascript" src="public/home/js/Visit.js?' . staticCache() . '"></script>
<div class="tip"></div>
</body>
</html>'
        ];
        if ($demo) {
            return $templates[$id];
        }

        $Template = new model\Template();
        $object = $Template->one($id);
        if (!$object) {
            return '';
        }

        $output = '';
        if ($object['template'] == 1) {
            $output = $templates[1];
        } else {
            $TemplateStyle = new model\TemplateStyle();
            $styleObject = $TemplateStyle->one($object['template_style_id']);
            if ($object['template'] == 0) {
                $output = $templates[0];
                $output = preg_replace(
                    '/<style type="text\/css">[\w\W]*<\/style>/U',
                    '<style type="text/css">.order{width:' . ($object['is_show_send'] ? 950 : 614) . 'px;background:' .
                    $styleObject['bg_color'] . ';border:1px solid ' . $styleObject['border_color'] .
                    ';}.order div.left{border-right:1px solid ' . $styleObject['border_color'] .
                    ';}.order div.left dl dd.submit input{background:' . $styleObject['button_color'] .
                    ';}.order div.left .buy,.order div.right .send{border-bottom:1px solid ' .
                    $styleObject['border_color'] . ';}</style>',
                    $output
                );
                $output = str_replace(
                    '<div class="right">
    <div class="send"></div><div class="list"><div class="list1"></div><div class="list2"></div></div>
  </div>',
                    $object['is_show_send'] ?
                        '<div class="right"><div class="send"></div><div class="list"><div class="list1"></div>' .
                        '<div class="list2"></div></div></div>' :
                        '',
                    $output
                );
            } elseif (in_array($object['template'], [2, 3, 4, 5])) {
                $output = $templates[$object['template']];
                $styleObject = $TemplateStyle->one($object['template_style_id']);
                $output = preg_replace(
                    '/<style type="text\/css">[\w\W]*<\/style>/U',
                    '<style type="text/css">.order{background:' . $styleObject['bg_color'] . ';border:1px solid ' .
                    $styleObject['border_color'] . ';}.order .buy{border-bottom:1px solid ' .
                    $styleObject['border_color'] . ';}.order dl dd.submit input{background:' .
                    $styleObject['button_color'] . ';}</style>',
                    $output
                );
                $output = preg_replace(
                    '/<div class="new"><\/div>/',
                    $object['is_show_send'] ? '<div class="new"></div>' : '',
                    $output
                );
            }
        }

        $output = preg_replace(
            '/<form method="post" action="[\w\W]*"/U',
            '<form method="post" action="' . Config::get('app.web_url') . Config::get('system.index_php') .
            'sub_order.html' . '"',
            $output
        );

        $productHtml = '';
        $productTemp = explode('|', $object['product']);
        $Product = new model\Product();
        if ($productTemp[0] == 0) {
            if ($productTemp[4] == 0) {
                $productHtml .= '<select name="product_id">';
                $productObject = $Product->all($productTemp[2]);
                if ($productObject) {
                    foreach ($productObject as $value) {
                        $productHtml .= '<option value="' . $value['id'] . '" ' . ($value['id'] == $productTemp[3] ?
                                'selected' : '') . ' style="color:' . $value['color'] . ';" price="' . $value['price'] .
                            '">' . $value['name'] . '（' . $value['price'] . '元）</option>';
                    }
                }
                $productHtml .= '</select>';
            } elseif ($productTemp[4] == 1) {
                $productObject = $Product->all($productTemp[2]);
                if ($productObject) {
                    foreach ($productObject as $value) {
                        $productHtml .= '<label style="color:' . $value['color'] .
                            ';"><input type="radio" name="product_id" value="' . $value['id'] . '" ' .
                            ($value['id'] == $productTemp[3] ? 'checked' : '') . ' price="' . $value['price'] . '">' .
                            $value['name'] . '（' . $value['price'] . '元）</label><br>';
                    }
                }
            }
        } elseif ($productTemp[0] == 1) {
            $ProductSort = new model\ProductSort();
            $productSortObject = $ProductSort->all($productTemp[1]);
            if ($productSortObject) {
                if ($productTemp[4] == 0) {
                    $productHtml .= '<select name="product_id">';
                    foreach ($productSortObject as $value) {
                        $productHtml .= '<optgroup label="' . $value['name'] . '" style="color:' .
                            $value['color'] . ';">';
                        $productObject = $Product->all($productTemp[2], $value['id']);
                        if ($productObject) {
                            foreach ($productObject as $v) {
                                $productHtml .= '<option value="' . $v['id'] . '" ' . ($v['id'] == $productTemp[3] ?
                                        'selected' : '') . ' style="color:' . ($v['color'] ? $v['color'] : '#000') .
                                    ';" price="' . $v['price'] . '">└—' . $v['name'] . '（' . $v['price'] .
                                    '元）</option>';
                            }
                        }
                        $productHtml .= '</optgroup>';
                    }
                    $productHtml .= '</select>';
                } elseif ($productTemp[4] == 1) {
                    foreach ($productSortObject as $value) {
                        $productHtml .= '<span style="color:' . $value['color'] . ';">' . $value['name'] .
                            '</span><br>';
                        $productObject = $Product->all($productTemp[2], $value['id']);
                        if ($productObject) {
                            foreach ($productObject as $v) {
                                $productHtml .= '<label style="color:' . $v['color'] .
                                    ';"><input type="radio" name="product_id" value="' . $v['id'] . '" ' .
                                    ($v['id'] == $productTemp[3] ? 'checked' : '') . ' price="' . $v['price'] . '">' .
                                    $v['name'] . '（' . $v['price'] . '元）</label><br>';
                            }
                        }
                    }
                }
            }
        }

        $payHtml = '';
        $payTemp = [];
        if ($object['pay']) {
            $payTemp = explode('|', $object['pay']);
            foreach (Config::get('app.pay2') as $key => $value) {
                if (isset($payTemp[1]) && in_array($key, explode(',', $payTemp[1]))) {
                    $payHtml .= '<label><input type="radio" name="pay" value="' . $key . '" ' .
                        ($key == $payTemp[0] ? 'checked' : '') . '>' . $value . '</label> ';
                }
            }
        }

        $dd = "\r\n    " . '<div class="fields"><input type="hidden" name="template_id" value="' . $id . '">';
        $dd .= "\r\n    " . '<input type="hidden" name="price">';
        $dd .= "\r\n    " . '<input type="hidden" name="referrer">';
        $fieldTemp = explode(',', $object['field']);
        if (in_array($object['template'], [0, 1])) {
            $dd .= "\r\n	<dd>请认真填写订单信息，以便您尽快收到货物</dd>";
            $dd .= "\r\n    " . '<dd class="pro"><span class="protext">订购产品：</span><span class="prolist">' .
                $productHtml . '</span></dd>';
            $dd .= in_array(1, $fieldTemp) ?
                "\r\n    " . '<dd>订购数量：<input type="text" name="count" value="1" class="text"></dd>' :
                '<input type="hidden" name="count" value="1">';
            $dd .= "\r\n    " . '<dd>总价合计：<span class="total"></span></dd>';
            if (in_array(2, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd>姓　　名：<input type="text" name="name" class="text"></dd>';
            }
            if (in_array(3, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd>联系电话：<input type="text" name="tel" class="text"></dd>';
            }
            if (in_array(4, $fieldTemp) && in_array(5, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd>所在地区：<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
                    '<label><input type="radio" name="type" value="b">手动填写</label></dd>';
                $dd .= "\r\n    " . '<div id="aa">';
                $dd .= "\r\n    " . '<input type="hidden" name="province">';
                $dd .= "\r\n    " . '<input type="hidden" name="city">';
                $dd .= "\r\n    " . '<input type="hidden" name="county">';
                $dd .= "\r\n    " . '<input type="hidden" name="town">';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="province" lay-filter="province">' .
                    '<option value="0">省份</option></select></dd>';
                $dd .= "\r\n    " .
                    '<dd>　　　　　<select class="city" lay-filter="city"><option value="0">城市</option></select></dd>';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="county" lay-filter="county">' .
                    '<option value="0">区/县</option></select></dd>';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="town" lay-filter="town">' .
                    '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></dd>';
                $dd .= "\r\n    " . '</div>';
                $dd .= "\r\n    " . '<div id="bb">';
                $dd .= "\r\n    " . '<dd>省　　份：<input type="text" name="province2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>城　　市：<input type="text" name="city2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>区 / 县 ：<input type="text" name="county2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>乡镇/街道：' .
                    '<input type="text" name="town2" class="text" style="width:435px;" placeholder="若不清楚，可留空"></dd>';
                $dd .= "\r\n    " . '</div>';
            } elseif (in_array(4, $fieldTemp)) {
                $dd .= "\r\n    " .
                    '<dd>所在地区：<input type="radio" name="type" value="a" checked style="display:none;"></dd>';
                $dd .= "\r\n    " . '<div id="aa">';
                $dd .= "\r\n    " . '<input type="hidden" name="province">';
                $dd .= "\r\n    " . '<input type="hidden" name="city">';
                $dd .= "\r\n    " . '<input type="hidden" name="county">';
                $dd .= "\r\n    " . '<input type="hidden" name="town">';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="province" lay-filter="province">' .
                    '<option value="0">省份</option></select></dd>';
                $dd .= "\r\n    " .
                    '<dd>　　　　　<select class="city" lay-filter="city"><option value="0">城市</option></select></dd>';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="county" lay-filter="county">' .
                    '<option value="0">区/县</option></select></dd>';
                $dd .= "\r\n    " . '<dd>　　　　　<select class="town" lay-filter="town">' .
                    '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></dd>';
                $dd .= "\r\n    " . '</div>';
            } elseif (in_array(5, $fieldTemp)) {
                $dd .= "\r\n    " .
                    '<dd>所在地区：<input type="radio" name="type" value="b" checked style="display:none;"></dd>';
                $dd .= "\r\n    " . '<div id="bb">';
                $dd .= "\r\n    " . '<dd>省　　份：<input type="text" name="province2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>城　　市：<input type="text" name="city2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>区 / 县 ：<input type="text" name="county2" class="text"></dd>';
                $dd .= "\r\n    " . '<dd>乡镇/街道：' .
                    '<input type="text" name="town2" class="text" style="width:435px;" placeholder="若不清楚，可留空"></dd>';
                $dd .= "\r\n    " . '</div>';
            }
            if (in_array(6, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd>详细地址：<input type="text" name="address" class="text"></dd>';
            }
            if (in_array(7, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd>邮政编码：<input type="text" name="post" maxlength="6" class="text2"></dd>';
            }
            if (in_array(8, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd class="textarea"><span>备　　注：</span><textarea name="note"></textarea></dd>';
            }
            if (in_array(9, $fieldTemp)) {
                $dd .= "\r\n    " .
                    '<dd>电子邮箱：<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></dd>';
            }
            $dd .= "\r\n    " . ($payHtml ? '<dd>支付方式：' . $payHtml . '</dd>' :
                    '<input type="hidden" name="pay" value="' . $payTemp[0] . '">');
            if ($object['is_captcha']) {
                $captcha = Config::get('captcha');
                if (isset($captcha[$object['is_captcha']])) {
                    $dd .= "\r\n    " . '<dd class="captcha"><span>验 证 码：' .
                        '<input type="text" name="captcha" class="text2"></span> <img src="' .
                        Config::get('app.web_url') . Config::get('system.index_php') . 'common/captcha?id=' .
                        $object['is_captcha'] . '" alt="验证码" onClick="this.src=\'' . Config::get('app.web_url') .
                        Config::get('system.index_php') . 'common/captcha?id=' . $object['is_captcha'] .
                        '&tm=\'+Math.random();" title="看不清？换一张"></dd>';
                }
            }
        } elseif (in_array($object['template'], [2, 3, 4, 5])) {
            $dd .= "\r\n    " . '<dd class="center">请认真填写订单信息，以便您尽快收到货物</dd>';
            $dd .= "\r\n    " . '<dd class="pro"><span class="left">订购产品：</span><span class="right">' .
                $productHtml . '</span></dd>';
            $dd .= in_array(1, $fieldTemp) ? "\r\n    " . '<dd><span class="left">订购数量：</span><span class="right">' .
                '<input type="text" name="count" value="1" class="text"></span></dd>' :
                '<input type="hidden" name="count" value="1">';
            $dd .= "\r\n    " . '<dd><span class="left">总价合计：</span><span class="right">' .
                '<span class="total"></span></span></dd>';
            if (in_array(2, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">姓　　名：</span><span class="right">' .
                    '<input type="text" name="name" class="text"></span></dd>';
            }
            if (in_array(3, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">联系电话：</span><span class="right">' .
                    '<input type="text" name="tel" class="text"></span></dd>';
            }
            if (in_array(4, $fieldTemp) && in_array(5, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">所在地区：</span><span class="right">' .
                    '<label><input type="radio" name="type" value="a" checked>选择填写</label> ' .
                    '<label><input type="radio" name="type" value="b">手动填写</label></span></dd>';
                $dd .= "\r\n    " . '';
                $dd .= "\r\n    " . '<div id="aa">';
                $dd .= "\r\n    " . '<input type="hidden" name="province">';

                $dd .= "\r\n    " . '<input type="hidden" name="city">';
                $dd .= "\r\n    " . '<input type="hidden" name="county">';
                $dd .= "\r\n    " . '<input type="hidden" name="town">';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="province" lay-filter="province"><option value="0">省份</option></select></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="city" lay-filter="city"><option value="0">城市</option></select></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="county" lay-filter="county"><option value="0">区/县</option></select></span></dd>';
                $dd .= "\r\n    " .
                    '<dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                    '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>';
                $dd .= "\r\n    " . '</div>';
                $dd .= "\r\n    " . '<div id="bb">';
                $dd .= "\r\n    " . '<dd><span class="left">省　　份：</span><span class="right">' .
                    '<input type="text" name="province2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">城　　市：</span><span class="right">' .
                    '<input type="text" name="city2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">区 / 县 ：</span><span class="right">' .
                    '<input type="text" name="county2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">乡镇/街道：</span><span class="right">' .
                    '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>';
                $dd .= "\r\n    " . '</div>';
            } elseif (in_array(4, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">所在地区：</span><span class="right">' .
                    '<input type="radio" name="type" value="a" checked style="display:none;"></span></dd>';
                $dd .= "\r\n    " . '<div id="aa">';
                $dd .= "\r\n    " . '<input type="hidden" name="province">';
                $dd .= "\r\n    " . '<input type="hidden" name="city">';
                $dd .= "\r\n    " . '<input type="hidden" name="county">';
                $dd .= "\r\n    " . '<input type="hidden" name="town">';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="province" lay-filter="province"><option value="0">省份</option></select></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="city" lay-filter="city"><option value="0">城市</option></select></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left"></span><span class="right">' .
                    '<select class="county" lay-filter="county"><option value="0">区/县</option></select></span></dd>';
                $dd .= "\r\n    " .
                    '<dd><span class="left"></span><span class="right"><select class="town" lay-filter="town">' .
                    '<option value="0">乡镇/街道（若不清楚，可不选）</option></select></span></dd>';
                $dd .= "\r\n    " . '</div>';
            } elseif (in_array(5, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">所在地区：</span><span class="right">' .
                    '<input type="radio" name="type" value="b" checked style="display:none;"></span></dd>';
                $dd .= "\r\n    " . '<div id="bb">';
                $dd .= "\r\n    " . '<dd><span class="left">省　　份：</span><span class="right">' .
                    '<input type="text" name="province2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">城　　市：</span><span class="right">' .
                    '<input type="text" name="city2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">区 / 县 ：</span><span class="right">' .
                    '<input type="text" name="county2" class="text"></span></dd>';
                $dd .= "\r\n    " . '<dd><span class="left">乡镇/街道：</span><span class="right">' .
                    '<input type="text" name="town2" class="text" placeholder="若不清楚，可留空"></span></dd>';
                $dd .= "\r\n    " . '</div>';
            }
            if (in_array(6, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">详细地址：</span><span class="right">' .
                    '<input type="text" name="address" class="text"></span></dd>';
            }
            if (in_array(7, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">邮政编码：</span><span class="right">' .
                    '<input type="text" name="post" maxlength="6" class="text"></span></dd>';
            }
            if (in_array(8, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd class="textarea"><span class="left">备　　注：</span><span class="right">' .
                    '<textarea name="note"></textarea></span></dd>';
            }
            if (in_array(9, $fieldTemp)) {
                $dd .= "\r\n    " . '<dd><span class="left">电子邮箱：</span><span class="right">' .
                    '<input type="text" name="email" placeholder="选填，可接收物流信息" class="text"></span></dd>';
            }
            $dd .= "\r\n    " . ($payHtml ?
                    '<dd class="pay"><span class="left">支付方式：</span><span class="right">' . $payHtml . '</span></dd>' :
                    '<input type="hidden" name="pay" value="' . $payTemp[0] . '">');
            if ($object['is_captcha']) {
                $captcha = Config::get('captcha');
                if (isset($captcha[$object['is_captcha']])) {
                    $dd .= "\r\n    " . '<dd><span class="left">验 证 码：</span><span class="right">' .
                        '<input type="text" name="captcha" class="text2"></span></dd>';
                    $dd .= "\r\n    " . '<dd class="captcha"><span class="left"></span><span class="right"><img src="' .
                        Config::get('app.web_url') . Config::get('system.index_php') . 'common/captcha?id=' .
                        $object['is_captcha'] . '" alt="验证码" onClick="this.src=\'' . Config::get('app.web_url') .
                        Config::get('system.index_php') . 'common/captcha?id=' . $object['is_captcha'] .
                        '&tm=\'+Math.random();" title="看不清？换一张"></span></dd>';
                }
            }
        }
        if ($object['is_qq'] == 0) {
            $dd .= "\r\n    " . '<dd class="submit"><input type="submit" value="立即提交订单"></dd>';
        } else {
            $dd .= "\r\n    " . '<dd class="info info2">为防止刷单，本站需登录QQ才能下单，登录后即可看见提交按钮</dd>';
            $dd .= "\r\n    " . '<dd class="submit"><input type="submit" value="立即提交订单" style="display:none;"> ' .
                '<img src="' . Config::get('app.web_url') . 'public/home/images/qq_login.png?' . staticCache() .
                '" alt="QQ登录" onClick="window.open(\'' . Config::get('app.web_url') . Config::get('system.index_php') .
                'common/qq\',\'qq\')"></dd>';
        }
        $dd .= '</div>';
        $output = str_replace('<title>填写订单</title>', '<title>' . $object['name'] . '</title>', $output);
        $output = preg_replace('/<dl class="order_form">[\w\W]*<\/dl>/U', '<dl>' . $dd . "\r\n  </dl>", $output);
        if ($object['is_show_search']) {
            $output = preg_replace(
                '/<form method="get" action="[\w\W]*"/U',
                '<form method="get" action="' . Config::get('app.web_url') . Config::get('system.index_php') .
                'order/search.html"',
                $output
            );
            $output = str_replace(
                '<input type="hidden" name="template_id" value="">',
                '<input type="hidden" name="template_id" value="' . $id . '">',
                $output
            );
        } else {
            $output = preg_replace(
                '/<form method="get" action="" target="_blank" class="search">[\w\W]*<\/form>/',
                '',
                $output
            );
        }
        return $output;
    }
}
