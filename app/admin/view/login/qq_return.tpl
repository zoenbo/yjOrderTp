<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:C('WEB_NAME')}</title>
<base href="{:C('WEB_URL')}">
<script type="text/javascript" src="__BASE__/jquery.js"></script>
<script type="text/javascript" src="__JS__/{$Think.const.CONTROLLER_NAME}.js"></script>
<link rel="stylesheet" type="text/css" href="__BASE__/H-ui.admin/css/H-ui.min.css">
<link rel="stylesheet" type="text/css" href="__CSS__/Basic.css">
<link rel="stylesheet" type="text/css" href="__CSS__/{$Think.const.CONTROLLER_NAME}.css">
<script type="text/javascript">
var ThinkPHP = {
	'AJAX' : '{:C("WEB_URL")}{:C("MANAGE_ENTER")}?m=admin&c=login&a=qqajax'
};
</script>
<style type="text/css">
body{
    background:none;
}
</style>
</head>

<body>
<div id="form">
  <form method="post" action="">
    <input type="hidden" name="qqau" value="{$Qqau}">
    <dl>
      <dd style="text-align:left;">　　QQ网名：{$Nickname}</dd>
      <dd>管理员帐号：<input type="text" name="name" class="input-text"></dd>
      <dd>管理员密码：<input type="password" name="pass" class="input-text"></dd>
      <dd><input type="submit" value="确认绑定" class="btn btn-primary radius"> <a href="?skip=1">暂不绑定</a></dd>
    </dl>
  </form>
</div>

{$run}
</body>
</html>