<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-订单查询</title>
<base href="{:config('app.web_url')}">
<link rel="stylesheet" type="text/css" href="public/home/styles/{:request()->controller()}.css">
</head>

<body>
<div class="order">
  <p>共查询到{$Total}个订单：</p>
  {foreach name="All" key="key" item="value"}
  <table>
    <tr><td class="n">订 单 号：</td><td>{$value['oid']}</td></tr>
    <tr><td class="n">订购产品：</td><td>{$value['product']}</td></tr>
    <tr><td class="n">产品属性：</td><td>{$value['attr']}</td></tr>
    <tr><td class="n">成交单价：</td><td>{$value['price']}元</td></tr>
    <tr><td class="n">订购数量：</td><td>{$value['count']}</td></tr>
    <tr><td class="n">成交总价：</td><td>{$value['total']}元</td></tr>
    <tr><td class="n">姓　　名：</td><td>{$value['name']}</td></tr>
    <tr><td class="n">联系电话：</td><td>{$value['tel']}</td></tr>
    <tr><td class="n">所在地区：</td><td>{$value['province']} {$value['city']} {$value['county']} {$value['town']}</td></tr>
    <tr><td class="n">详细地址：</td><td>{$value['address']}</td></tr>
    <tr><td class="n">邮政编码：</td><td>{$value['post']}</td></tr>
    <tr><td class="n">备　　注：</td><td>{$value['note']}</td></tr>
    <tr><td class="n">电子邮箱：</td><td>{$value['email']}</td></tr>
    <tr><td class="n">支付方式：</td><td>{$value['pay']}</td></tr>
    <tr><td class="n">下单IP：</td><td>{$value['ip']}</td></tr>
    <tr><td class="n">QQ标识符：</td><td>{$value['qqau']}</td></tr>
    <tr><td class="n">下单来路：</td><td>{if condition="$value['referrer']=='小程序'"}小程序{elseif condition="$value['referrer']"/}<a href="{$value['referrer']}" target="_blank">{$value['referrer']}</a>{else/}直接进入{/if}</td></tr>
    <tr><td class="n">下单时间：</td><td>{$value['date']|dateFormat}</td></tr>
    <tr><td class="n">订单状态：</td><td>{$value['state']}</td></tr>
    <tr><td class="n">物流公司：</td><td>{$value['logistics_name']}</td></tr>
    <tr><td class="n">物流编号：</td><td>{$value['logistics_id']}{if condition="$value['logistics_name']&&$value['logistics_id']"}，<a href="http://www.kuaidi100.com/chaxun?com={$value['logistics_code']}&nu={$value['logistics_id']}" target="_blank">查询进度</a>{/if}</td></tr>
  </table>
  {/foreach}
</div>

<script type="text/javascript" src="public/home/js/Visit.js"></script>
{if condition="config('app.demo')"}<p style="display:none;"><script language="javascript" type="text/javascript" src="//js.users.51.la/19104960.js"></script><noscript><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="//img.users.51.la/19104960.asp"></noscript></p>{/if}
</body>
</html>