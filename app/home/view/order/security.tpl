<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-防伪查询</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js"></script>
<script type="text/javascript" src="public/base/Validform.js"></script>
<script type="text/javascript" src="public/home/js/Security.js"></script>
<link rel="stylesheet" type="text/css" href="public/home/styles/Order3.css">
<style type="text/css">.order{background:#FFFFFF;border:3px solid #FC4400;}.order .buy{border-bottom:1px solid #FC4400;}.order dl dd.submit input{background:#FF6633;}</style>
</head>

<body>

<div class="order">
  <div class="buy2">防伪查询</div>
  
  <form method="get" action="{:url('/'.parse_name(request()->controller()).'/security')}" class="search">
    <dl>
      <dd><span class="left">查询方式：</span><span class="right">按 <label><input type="radio" name="field" value="1" checked>下单联系电话</label></span></dd>
      <dd><span class="left">关 键 词：</span><span class="right"><input type="text" name="keyword" class="text"></span></dd>
      <dd class="info info3">请填写查询关键词！</dd>
      <dd class="submit"><input type="submit" value="查询真伪"></dd>
    </dl>
  </form>
</div>
</html>