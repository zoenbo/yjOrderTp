<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}</title>
<base href="{:config('app.web_url')}">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/Main.css?{:staticCache()}">
</head>

<body>
<div class="main">
  <p class="copy">{:config('system.web_name')} &copy; {:config('system.copyright_start')}</p>
  
  <table>
    <caption>版本信息</caption>
    <tr><th>版本号</th><th>更新时间</th></tr>
    <tr><td>V{$Version[0]}</td><td>{$Version[1]}</td></tr>
  </table>
  
  <table>
    <caption>订单</caption>
    <tr><th>订单总数</th><th>未发货</th></tr>
    <tr><td>{$Data['order_total1']}单</td><td class="red">{$Data['order_total2']}单</td></tr>
    <tr><th>已发货</th><th>已取消</th></tr>
    <tr><td>{$Data['order_total3']}单</td><td>{$Data['order_total4']}单</td></tr>
    <tr><th>已签收</th><th></th></tr>
    <tr><td>{$Data['order_total5']}单</td><td></td></tr>
  </table>
  
  <table>
    <caption>产品</caption>
    <tr><th>产品总数</th><th>运作产品数</th></tr>
    <tr><td>{$Data['product_total1']}个</td><td>{$Data['product_total2']}个</td></tr>
  </table>
</div>

{$Run}
</body>
</html>