{extend name="../../common/view/base/form" /}

{block name="title"}系统设置{/block}
{block name="head"}<script type="text/javascript" src="public/base/webuploader/html5.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/base/webuploader/style.css?{:staticCache()}">
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">
<script type="text/javascript">
var ThinkPHP = {
	UPLOAD : '{:url("/common/loginbg")}',
	UPLOAD2 : '{:url("/common/qqwry")}'
};
</script>{/block}

{block name="nav"}
<li class="current"><a href="javascript:;">系统信息</a></li>
<li><a href="javascript:;">版权信息</a></li>
<li><a href="javascript:;">订单设置</a></li>
<li><a href="javascript:;">支付宝</a></li>
<li><a href="javascript:;">微信支付</a></li>
<li><a href="javascript:;">QQ登录</a></li>
<li><a href="javascript:;">邮件设置</a></li>
<li><a href="javascript:;">IP数据库</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table class="column" style="display:block;">
    <tr><td>OpenID：</td><td><input type="text" name="openid" value="{:config('system.openid')}" class="input-text"></td></tr>
    <tr><td>站点名称：</td><td><input type="text" name="web_name" value="{:config('system.web_name')}" class="input-text"></td></tr>
    <tr><td>管理员邮箱：</td><td><input type="text" name="admin_mail" value="{:config('system.admin_mail')}" class="input-text"></td><td>多个邮箱请用“,”隔开，不得与<a href="javascript:;" onclick="addTab('{:url('/smtp/index')}','SMTP服务器')">SMTP服务器</a>模块中的邮箱重复。<a href="https://www.yvjie.cn/help/detail.html?id=1" target="_blank">如何设置短信提醒？</a></td></tr>
    <tr><td>访问模式：</td><td><div class="check-box"><label><input type="checkbox" name="www" value="1" {if condition="config('system.www')==1"}checked{/if}>强制www访问</label></div><div class="check-box"><label><input type="checkbox" name="https" value="1" {if condition="config('system.https')==1"}checked{/if}>强制https访问</label></div></td><td>开启强制www访问前，请先确保您的主域名加上www后可以访问；开启强制https访问前，请先确保您的网站支持https访问。以上两项若不能确保，请先咨询客服人员，若在不能确保的情况下开启，会导致网站无法访问。变更设置后可能需要重新登录。</td></tr>
    <tr><td>后台入口：</td><td><input type="text" name="manage_enter" value="{:config('system.manage_enter')}" class="input-text"></td><td>修改后会自动跳转到新入口</td></tr>
    <tr><td>后台皮肤：</td><td><select name="manage_skin" class="select">{$Skin}</select></td></tr>
    <tr><td>隐藏index.php：</td><td><div class="radio-box"><label><input type="radio" name="index_php" value="" {if condition="config('system.index_php')==''"}checked{/if}>是</label></div><div class="radio-box"><label><input type="radio" name="index_php" value="index.php/" {if condition="config('system.index_php')=='index.php/'"}checked{/if}>否</label></div></td><td>设置前台的访问地址中是否隐藏掉index.php，开启此设置，服务器需支持伪静态，若开启后导致前台无法访问，请联系您的服务商解决</td></tr>
  </table>
  <table class="column">
    <tr><td>登录页背景图：</td><td><span class="loginbg"><span class="loginbg_picker"></span></span></td><td>请上传jpg格式的图片，您可<a href="public/admin/images/loginbg.fw.png" target="_blank">点此下载</a>原图，用PS或fireworks等软件编辑版权信息后上传</td></tr>
    <tr><td>后台左上角：</td><td><input type="text" name="copyright_top" value="{:config('system.copyright_top')}" class="input-text"></td></tr>
    <tr><td>后台起始页：</td><td><textarea name="copyright_start" class="textarea">{:config('system.copyright_start')}</textarea></td></tr>
    <tr><td>后台底部：</td><td><textarea name="copyright_footer" class="textarea">{:config('system.copyright_footer')}</textarea></td></tr>
  </table>
  <table class="column">
    <tr><td>订单入库：</td><td><div class="radio-box"><label><input type="radio" name="order_db" value="1" {if condition="config('system.order_db')==1"}checked{/if}>是</label></div><div class="radio-box"><label><input type="radio" name="order_db" value="0" {if condition="config('system.order_db')==0"}checked{/if}>否</label></div></td><td>选择“否”，客户下的订单将不写入数据库，直接将订单信息发送到管理员邮箱中，防止盗单</td></tr>
    <tr><td>防刷单间隔：</td><td><input type="text" name="order_time" value="{:config('system.order_time')}" class="input-text"></td><td>设置同一IP或QQ下，订单提交间隔，防止刷单（订单入库时有效，单位：分钟）</td></tr>
    <tr><td>订单查询：</td><td><div class="radio-box"><label><input type="radio" name="order_search" value="1" {if condition="config('system.order_search')==1"}checked{/if}>是</label></div><div class="radio-box"><label><input type="radio" name="order_search" value="0" {if condition="config('system.order_search')==0"}checked{/if}>否</label></div></td><td>是否开启前台查单</td></tr>
    <tr><td>跨模板查询：</td><td><div class="radio-box"><label><input type="radio" name="order_search_step" value="1" {if condition="config('system.order_search_step')==1"}checked{/if}>是</label></div><div class="radio-box"><label><input type="radio" name="order_search_step" value="0" {if condition="config('system.order_search_step')==0"}checked{/if}>否</label></div></td><td>开启后，可跨模板查单。举例：通过A模板下的订单，通过B模板的查询入口也可查询到，即便A模板没有开启查询入口；注意，如果所有模板均没开启查单功能，但开启了此设置，也可通过输入网址进行查单。</td></tr>
  </table>
  <table class="column">
    <tr><td>APPID：</td><td><input type="text" name="alipay_appid" value="{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.alipay_appid')}{/if}" class="input-text"></td></tr>
    <tr><td>应用私钥：</td><td><textarea name="alipay_merchant_private_key" class="textarea">{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.alipay_merchant_private_key')}{/if}</textarea></td></tr>
    <tr><td>支付宝公钥：</td><td><textarea name="alipay_public_key" class="textarea">{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.alipay_public_key')}{/if}</textarea></td></tr>
    <tr><td></td><td class="tip"><a href="https://www.yvjie.cn/help/detail.html?id=36" target="_blank">支付宝商户签约及配置流程</a></td></tr>
  </table>
  <table class="column">
    <tr><td>AppID：</td><td><input type="text" name="wxpay_appid" value="{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.wxpay_appid')}{/if}" class="input-text"></td></tr>
    <tr><td>AppSecret：</td><td><input type="text" name="wxpay_appsecret" value="{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.wxpay_appsecret')}{/if}" class="input-text"></td></tr>
    <tr><td>MCHID：</td><td><input type="text" name="wxpay_mchid" value="{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.wxpay_mchid')}{/if}" class="input-text"></td></tr>
    <tr><td>KEY：</td><td><input type="text" name="wxpay_key" value="{if condition="config('app.demo')"}演示站，不能修改{else/}{:config('system.wxpay_key')}{/if}" class="input-text"></td></tr>
    <tr><td></td><td class="tip">如果您还没有签约，请先签约，<a href="https://kf.qq.com/faq/180910jimEvQ180910Zj6jQV.html" target="_blank">点击此处</a>查看签约教程</td></tr>
    <tr><td></td><td class="tip">1、如果已完成签约，请<a href="https://pay.weixin.qq.com/index.php/extend/product/lists?tid=3" target="_blank">点击此处</a>进入到微信支付商户平台的产品中心，开通H5支付业务，此举是为了实现移动端浏览器（非微信端）支持微信支付；</td></tr>
    <tr><td></td><td class="tip">2、以上四个字段的获取方法：</td><td></td></tr>
    <tr><td></td><td class="tip">2-1、请登录开通了微信支付的微信公众号，点击“开发 - 基本配置”，即可获取到开发者ID（AppID）和开发者密码（AppSecret）；</td></tr>
    <tr><td></td><td class="tip">2-2、点击微信公众平台中的“微信支付”，即可获取MCHID（即微信支付商户号）；</td></tr>
    <tr><td></td><td class="tip">2-3、KEY（即微信支付商户API密钥），请<a href="https://pay.weixin.qq.com/index.php/core/cert/api_cert" target="_blank">点击此处</a>进行设置；</td></tr>
    <tr><td></td><td class="tip">3-1、登录微信公众平台，然后点击“设置 - 公众号设置 - 功能设置”，将“{:request()->server('HTTP_HOST')}”分别填入“JS接口安全域名”和“网页授权域名”设置项中，保存即可；</td></tr>
    <tr><td></td><td class="tip">3-2、如需验证网站所属权，请<a href="javascript:;" onclick="addTab('{:url('/validate_file/index')}','生成验证文件')">点击此处</a>；</td></tr>
    <tr><td></td><td class="tip">4-1、<a href="https://pay.weixin.qq.com/index.php/extend/pay_setting" target="_blank">点击此处</a>登录到微信支付商户平台的开发配置中；</td></tr>
    <tr><td></td><td class="tip">4-2、在“支付授权目录”设置项中添加{:config('app.web_url')}pay/wxpay/oid/、{:config('app.web_url')}index.php/pay/wxpay/oid/；</td></tr>
    <tr><td></td><td class="tip">4-3、在“扫码回调链接”设置项中输入{:config('app.web_url')}{:config('system.index_php')}pay/wxpayReturn。</td></tr>
  </table>
  <table class="column">
    <tr><td>APP ID：</td><td><input type="text" name="qq_appid" value="{:config('system.qq_appid')}" class="input-text"></td></tr>
    <tr><td>APP KEY：</td><td><input type="text" name="qq_appkey" value="{:config('system.qq_appkey')}" class="input-text"></td></tr>
    <tr><td></td><td class="tip"><a href="http://wiki.connect.qq.com/%e6%88%90%e4%b8%ba%e5%bc%80%e5%8f%91%e8%80%85" target="_blank">申请教程</a>，申请时，请将网站地址填写为：{:config('app.web_url3')}，网站回调地址填写为：{:config('app.web_url')}callback.php/qq_admin;{:config('app.web_url')}callback.php/qq_profile;{:config('app.web_url')}{:config('system.index_php')}common/qqReturn</td></tr>
  </table>
  <table class="column">
    <tr><td colspan="2" class="tip left"><a href="https://www.yvjie.cn/help/detail.html?id=2" target="_blank">点击此处</a>查看邮件变量列表</td></tr>
    <tr><td colspan="2" class="left">订单提醒邮件</td></tr>
    <tr><td>邮件标题：</td><td><input type="text" name="mail_order_subject" value="{:config('system.mail_order_subject')}" class="input-text"></td></tr>
    <tr><td>邮件内容：</td><td><textarea name="mail_order_content" class="textarea">{:config('system.mail_order_content')}</textarea></td><td>支持HTML</td></tr>
    <tr><td colspan="2" class="left">支付提醒邮件</td></tr>
    <tr><td>邮件标题：</td><td><input type="text" name="mail_pay_subject" value="{:config('system.mail_pay_subject')}" class="input-text"></td></tr>
    <tr><td>邮件内容：</td><td><textarea name="mail_pay_content" class="textarea">{:config('system.mail_pay_content')}</textarea></td><td>支持HTML</td></tr>
    <tr><td colspan="2" class="left">发货提醒邮件</td></tr>
    <tr><td>邮件标题：</td><td><input type="text" name="mail_send_subject" value="{:config('system.mail_send_subject')}" class="input-text"></td></tr>
    <tr><td>邮件内容：</td><td><textarea name="mail_send_content" class="textarea">{:config('system.mail_send_content')}</textarea></td><td>支持HTML</td></tr>
  </table>
  <table class="column">
    <tr><td><span class="qqwry">当前IP数据库更新日期为：{$IpVersion}</span> <span class="qqwry_picker"></span> <a href="https://www.yvjie.cn/help/detail.html?id=37" target="_blank">最新版IP数据库获取方法</a></td></tr>
  </table>
  <table>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}