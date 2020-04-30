<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/H-ui/H-ui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/{:app('http')->getName()}/js/Common.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/Login.css?{:staticCache()}">
<script type="text/javascript">
var ThinkPHP = {
	AJAX : '{:url("/".parse_name(request()->controller())."/qqajax")}'
};
</script>
<style type="text/css">
.form table tr td:nth-child(1){
	width:56px;
}
</style>
</head>

<body>
<form method="post" action="" class="form">
  <input type="hidden" name="qqau" value="{$Qqau}">
  <table>
    <tr><td>QQ网名：</td><td>{$Nickname}</td></tr>
    <tr><td>帐　号：</td><td><input type="text" name="name" class="input-text"></td></tr>
    <tr><td>密　码：</td><td><input type="password" name="pass" class="input-text"></td></tr>
    <tr><td colspan="2" style="text-align:center;"><input type="submit" value="确认绑定" class="btn btn-primary radius"> <a href="?skip=1">暂不绑定</a></td></tr>
  </table>
</form>
</body>
</html>