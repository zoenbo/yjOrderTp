<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>昱杰订单管理系统（ThinkPHP版）-系统安装-第3步</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/H-ui/H-ui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/Common.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">
</head>

<body>
<form method="post" action="" class="form">
  <input type="hidden" name="pass_key" value="{$PassKey}">
  <table>
    <tr><td colspan="2" style="text-align:center;">系统信息</td></tr>
    <tr><td>OpenID：</td><td><input type="text" name="openid" class="input-text"></td></tr>
    <tr><td></td><td class="tip">请使用微信扫一扫如下二维码或直接搜索“yvjie_cn”关注我们的公众号，回复“bind:{$Code}”获取您的OpenID，此操作完全免费，仅仅是为了统计使用量情况，感谢您的配合（请不要取消关注，否则将无法登录系统后台）</td></tr>
    <tr><td colspan="2" style="text-align:center;"><img src="public/admin/images/wx.jpg?{:staticCache()}" alt="昱杰软件" style="width:200px;"></td></tr>
    <tr><td>网站名称：</td><td><input type="text" name="web_name" class="input-text" placeholder="显示在后台起始页和后台所有网页的标题中，中英文均可"></td></tr>
    <tr><td>后台入口：</td><td><input type="text" name="manage_enter" class="input-text" placeholder="英文、数字、英文+数字.php，如abc.php、abc123.php"></td></tr>
    <tr><td></td><td class="tip">说明：默认为admin.php，但为了不让其他人猜解到后台入口，请设置一个不太为人知的入口（.php不能省略）。</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td colspan="2" style="text-align:center;">管理员信息</td></tr>
    <tr><td>用 户 名：</td><td><input type="text" name="admin_name" class="input-text" placeholder="安装成功后，用来登录后台的管理员帐号"></td></tr>
    <tr><td>密　　码：</td><td><input type="password" name="admin_pass" class="input-text" placeholder="管理员密码"></td></tr>
    <tr><td>确认密码：</td><td><input type="password" name="admin_repass" class="input-text" placeholder="同上"></td></tr>
    <tr><td>电子邮箱：</td><td><input type="text" name="admin_mail" class="input-text" placeholder="管理员邮箱，可用来接收订单提醒邮件"></td></tr>
    <tr><td colspan="2" style="text-align:center;"><input type="submit" value="确认安装" class="btn btn-primary radius"></td></tr>
  </table>
</form>
</body>
</html>