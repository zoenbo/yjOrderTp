<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">
<script type="text/javascript">
var ThinkPHP = {
	AJAX : '{:url("/".parse_name(request()->controller())."/ajax")}'
};
</script>
</head>

<body class="bg">
<form method="post" action="" class="login">
  <p><label>管理员帐号：<input type="text" name="name" {if condition="config('app.demo')"}value="风形火影"{/if} class="text"></label></p>
  <p><label>密　　　码：<input type="password" name="pass" {if condition="config('app.demo')"}value="tyj"{/if} class="text"></label></p>
  <p><input type="submit" value="登录" class="submit"></p>
  <p style="text-align:right;"><a href="{:url('/'.parse_name(request()->controller()).'/qq')}"><img src="public/admin/images/qq_login.png?{:staticCache()}" alt="QQ登录"></a></p>
  <p style="text-align:right;">忘记密码？<a href="{:url('/'.parse_name(request()->controller()).'/reset')}">点此重置</a></p>
</form>
</body>
</html>