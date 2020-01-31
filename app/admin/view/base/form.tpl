<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:C('WEB_NAME')}-<block name="title"></block></title>
<base href="{:C('WEB_URL')}">
<script type="text/javascript" src="__BASE__/jquery.js"></script>
<script type="text/javascript" src="__BASE__/H-ui.admin/js/H-ui.js"></script>
<script type="text/javascript" src="__BASE__/H-ui.admin/js/H-ui.admin.js"></script>
<link rel="stylesheet" type="text/css" href="__BASE__/H-ui.admin/css/H-ui.min.css">
<link rel="stylesheet" type="text/css" href="__CSS__/Basic.css">
<script type="text/javascript">
var ThinkPHP = {
	'H-ui-skin' : '{:C("MANAGE_SKIN")}'
};
</script>
<block name="head"></block>
</head>

<body>
<div id="nav">
  <h3><block name="title"></block></h3>
  
  <ul>
    <block name="nav"></block>
  </ul>
</div>

<block name="form"></block>

{$run}
</body>
</html>