<?php

return [
    'openid' => 'owlp6t_835G2OwVxr09msFo72kII',  //OpenID
    'web_name' => '昱杰订单管理系统',  //站点名称
    'session_key' => 'zTU2lH9T9I7xZH2OsvHikvD28LeYRYwgzCbQjQbX',  //网站session key
    'pass_key' => '',  //密码的盐
    'reset_pass_key' => '40SX0dkLUmN3Gi1QqEst5GoAWnkVnB00MRkCw6Dv',  //重置密码的密钥
    'admin_mail' => '1.',  //管理员邮箱
    'www' => '0',  //是否强制www
    'https' => '0',  //是否强制https
    'manage_enter' => 'n.php',  //后台入口
    'manage_skin' => 'default',  //后台皮肤
    'index_php' => '',  //隐藏index.php
    'copyright_top' => '昱杰多功能订单管理系统',  //左上角版权
    'copyright_start' => '<a href="https://www.yvjie.cn/" target="_blank">昱杰软件</a>版权所有',  //起始页版权
    'copyright_footer' => 'Powered by <a href="https://www.yvjie.cn/" target="_blank">昱杰多功能订单系统</a> © 2015-2020',  //页面底部版权
    'order_db' => '1',  //订单入库
    'order_time' => '5',  //防刷单间隔
    'order_search' => '1',  //订单查询
    'order_search_step' => '1',  //跨模板查询
    'alipay_appid' => '',  //支付宝APPID
    'alipay_merchant_private_key' => '',  //支付宝应用私钥
    'alipay_public_key' => '',  //支付宝公钥
    'wxpay_appid' => '',  //微信支付APPID
    'wxpay_appsecret' => '',  //微信支付APPSECRET
    'wxpay_mchid' => '',  //微信支付MCHID
    'wxpay_key' => '',  //微信支付KEY
    'qq_appid' => '',  //QQ互联APP ID
    'qq_appkey' => '',  //QQ互联APP KEY
    'mail_order_subject' => '您有一笔新订单，请及时发货',  //订单提醒邮件标题
    'mail_order_content' => '<p>订单详情</p>
<p>订单编号：{oid}</p>
<p>订购产品：{product_name}</p>
<p>产品属性：{proattr}</p>
<p>成交单价：{product_price}元</p>
<p>订购数量：{product_count}</p>
<p>成交总价：{product_total}元</p>
<p>姓　　名：{name}</p>
<p>联系电话：{tel}</p>
<p>详细地址：{province} {city} {county} {town} {address}</p>
<p>邮政编码：{post}</p>
<p>备　　注：{note}</p>
<p>电子邮箱：{email}</p>
<p>　下单IP：{ip}</p>
<p>下单来路：{referrer}</p>
<p>支付方式：{pay}</p>',  //订单提醒邮件内容
    'mail_pay_subject' => '您的订单尚未支付，请及时支付',  //支付提醒邮件标题
    'mail_pay_content' => '<p>您的订单尚未支付，请及时支付，支付链接：<a href="{alipay}" target="_blank">支付宝支付</a>　<a href="{wxpay}" target="_blank">微信支付</a>。</p>
<p>订单详情</p>
<p>订单编号：{oid}</p>
<p>订购产品：{product_name}</p>
<p>产品属性：{proattr}</p>
<p>产品单价：{product_price}元</p>
<p>订购数量：{product_count}</p>
<p>产品总价：{product_total}元</p>
<p>姓　　名：{name}</p>
<p>联系电话：{tel}</p>
<p>详细地址：{province} {city} {county} {town} {address}</p>
<p>邮政编码：{post}</p>
<p>备　　注：{note}</p>
<p>电子邮箱：{email}</p>
<p>　下单IP：{ip}</p>
<p>下单来路：{referrer}</p>
<p>支付状态：{pay}</p>
<p>订单状态：{state}</p>
<p>下单时间：{date}</p>',  //支付提醒邮件内容
    'mail_send_subject' => '您的订单已发货，请注意查收',  //发货提醒邮件标题
    'mail_send_content' => '<p>您的物流信息为：物流公司 {logistics_name}　物流编号 {logistics_id}。您可以<a href="{logistics_url}" target="_blank">点击此处</a>查询物流详情。</p>
<p>订单详情</p>
<p>订单编号：{oid}</p>
<p>订购产品：{product_name}</p>
<p>产品属性：{proattr}</p>
<p>产品单价：{product_price}元</p>
<p>订购数量：{product_count}</p>
<p>产品总价：{product_total}元</p>
<p>姓　　名：{name}</p>
<p>联系电话：{tel}</p>
<p>详细地址：{province} {city} {county} {town} {address}</p>
<p>邮政编码：{post}</p>
<p>备　　注：{note}</p>
<p>电子邮箱：{email}</p>
<p>　下单IP：{ip}</p>
<p>下单来路：{referrer}</p>
<p>支付状态：{pay}</p>
<p>支付订单号：{pay_oid}</p>
<p>支付场景：{pay_scene}</p>
<p>支付时间：{pay_date}</p>
<p>订单状态：{state}</p>
<p>下单时间：{date}</p>',  //发货提醒邮件内容
    'install_time' => '',  //安装时间
];
