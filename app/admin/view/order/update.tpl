{extend name="../../common/view/base/form" /}

{block name="title"}{if condition="request()->controller()=='Order'"}订单管理{else/}订单回收站{/if}{/block}
{block name="head"}<script type="text/javascript" src="public/admin/js/Order2.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/admin/styles/Order.css?{:staticCache()}">
<style type="text/css">
.form table tr td:nth-child(1){
	width:80px;
}
</style>{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="request()->controller()=='Order'"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量修改物流</a></li>{/if}
{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>input('get.id'),'from'=>input('get.from')])}">修改</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form layui-form">
  <input type="hidden" name="order_id" value="{$One['order_id']}">
  <input type="hidden" name="ip" value="{$One['ip']}">
  <input type="hidden" name="referrer" value="{$One['referrer']}">
  <input type="hidden" name="pay_id" value="{$One['pay_id']}">
  <input type="hidden" name="pay_scene" value="{$One['pay_scene']}">
  <input type="hidden" name="pay_date" value="{$One['pay_date']}">
  <input type="hidden" name="date" value="{$One['date']}">
  <table>
    <tr><td>下单模板：</td><td><select name="template_id" lay-search>{$Template}</select></td><td>只对模板中勾选的字段进行验证</td></tr>
    <tr><td>订购产品：</td><td><select name="product_id" lay-search>{$Product}</select></td></tr>
    <tr><td>成交单价：</td><td><input type="text" name="price" value="{$One['price']}" class="input-text"></td></tr>
    <tr><td>订购数量：</td><td><input type="text" name="count" value="{$One['count']}" class="input-text"></td></tr>
    <tr><td>姓　　名：</td><td><input type="text" name="name" value="{$One['name']}" class="input-text"></td></tr>
    <tr><td>联系电话：</td><td><input type="text" name="tel" value="{$One['tel']}" class="input-text"></td></tr>
    <tr><td>省　　份：</td><td><input type="text" name="province2" value="{$One['province']}" class="input-text"></td></tr>
    <tr><td>城　　市：</td><td><input type="text" name="city2" value="{$One['city']}" class="input-text"></td></tr>
    <tr><td>区 / 县 ：</td><td><input type="text" name="county2" value="{$One['county']}" class="input-text"></td></tr>
    <tr><td>乡镇/街道：</td><td><input type="text" name="town2" value="{$One['town']}" class="input-text text" placeholder="若不清楚，可留空"></td></tr>
    <tr><td>详细地址：</td><td><input type="text" name="address" value="{$One['address']}" class="input-text"></td></tr>
    <tr><td>邮政编码：</td><td><input type="text" name="post" value="{$One['post']}" class="input-text"></td></tr>
    <tr><td>备　　注：</td><td><textarea name="note" class="textarea">{$One['note']}</textarea></td></tr>
    <tr><td>电子邮箱：</td><td><input type="text" name="email" value="{$One['email']}" class="input-text"></td></tr>
    <tr><td>支付状态：</td><td><select name="pay" lay-search>{foreach name="Pay" key="key" item="value"}<option value="{$key}" {if condition="$key==$One['pay']"}selected{/if}>{$value}</option>{/foreach}</select></td></tr>
    <tr><td>支付链接：</td><td>支付宝 <a href="{$One['payUrl']['alipay']}" target="_blank">{$One['payUrl']['alipay']}</a><br>微信支付 <a href="{$One['payUrl']['wxpay']}" target="_blank">{$One['payUrl']['wxpay']}</a><br>可发送以上链接给客户进行网上支付</td></tr>
    <tr><td>订单状态：</td><td>{$OrderState}</td></tr>
    <tr><td>物流公司：</td><td><select name="logistics_id" lay-search>{$Logistics}</select></td></tr>
    <tr><td>物流编号：</td><td><input type="text" name="logistics_number" value="{$One['logistics_number']}" class="input-text"></td></tr>
    <tr><td>发送邮件：</td><td><div class="radio-box"><label><input type="radio" name="sendmail" value="0" checked>不发送</label></div><div class="radio-box"><label><input type="radio" name="sendmail" value="1">发送支付信息给客户</label></div><div class="radio-box"><label><input type="radio" name="sendmail" value="2">发送发货信息给客户</label></div></td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}