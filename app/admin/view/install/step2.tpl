<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>昱杰订单管理系统（ThinkPHP版）-系统安装-第2步</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/H-ui/H-ui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/Common.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">
<style type="text/css">
.form table tr td:nth-child(1){
	width:98px;
}
</style>
</head>

<body>
<form method="post" action="" class="form layui-form">
  <table>
    <tr><td colspan="2" style="text-align:center;">数据库信息</td></tr>
    <tr><td>数据库服务器：</td><td><input type="text" name="db_host" value="127.0.0.1" class="input-text"></td></tr>
    <tr><td>服务器端口：</td><td><input type="text" name="db_port" value="3306" class="input-text"></td></tr>
    <tr><td>数据库名：</td><td><input type="text" name="db_name" class="input-text"></td></tr>
    <tr><td>数据库用户名：</td><td><input type="text" name="db_user" value="root" class="input-text"></td></tr>
    <tr><td>数据库密码：</td><td><input type="text" name="db_pwd" class="input-text"></td></tr>
    <tr><td>数据表前缀：</td><td><input type="text" name="db_prefix" value="yjorder_" class="input-text"></td></tr>
    <tr><td colspan="2" style="text-align:center;"><input type="submit" value="下一步" class="btn btn-primary radius"></td></tr>
  </table>
</form>
</body>
</html>