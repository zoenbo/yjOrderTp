<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}-{block name="title"}{/block}</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/H-ui/H-ui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/LayUI/LayUI.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/Common.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/base/LayUI/LayUI.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
{block name="head"}{/block}
</head>

<body>
<div class="header">
  <h3>{block name="title"}{/block}</h3>
  
  <ul>
    {block name="nav"}{/block}
    <p style="clear:both"></p>
  </ul>
</div>

{block name="form"}{/block}

{$Run}
</body>
</html>