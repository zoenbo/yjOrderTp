<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-支付宝支付</title>
<base href="{:config('app.web_url')}">
<link rel="stylesheet" type="text/css" href="public/home/styles/{:request()->controller()}.css">
</head>

<body>
<div class="pay2">
  <p>您当前使用的是微信端访问，无法进行支付宝支付，请复制以下链接，然后通过浏览器打开进行支付</p>
  <p>{:config('app.web_url')}{:config('system.index_php')}pay/alipay/oid/{:input('oid')}.html</p>
</div>
</body>
</html>