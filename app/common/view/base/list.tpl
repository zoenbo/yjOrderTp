<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}-{block name="title"}{/block}</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js"></script>
<script type="text/javascript" src="public/base/H-ui.admin/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="public/base/H-ui.admin/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="public/{:app('http')->getName()}/js/Common.js"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/h-ui/css/H-ui.min.css">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css">
{block name="basecss"}<link rel="stylesheet" type="text/css" href="public/{:app('http')->getName()}/styles/{:request()->controller()}.css">{/block}
<script type="text/javascript">
var ThinkPHP = {
	'H-ui-skin' : '{:config("system.manage_skin")}'
};
</script>
{block name="head"}{/block}
</head>

<body>
<div class="header">
  <h3>{block name="title"}{/block}</h3>
  
  <ul>
    {block name="nav"}{/block}
  </ul>
  
  {block name="search"}<form method="get" action="" class="search">搜索：<input type="text" name="keyword" value="{:input('get.keyword')}" class="input-text"><input type="submit" value="搜索" class="btn btn-primary radius"></form>{/block}
</div>

{block name="tip"}{/block}

{block name="tools"}{/block}

{block name="list"}{/block}

{$Run}
</body>
</html>