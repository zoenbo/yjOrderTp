{extend name="../../common/view/base/form" /}

{block name="title"}订单管理{/block}
{block name="head"}<script type="text/javascript" src="public/base/Address.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/Order2.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">
<script type="text/javascript">let DISTRICT = '{:config("app.web_url")}{:config("system.index_php")}common/district';</script>
<style type="text/css">
.form table tr td:nth-child(1){
	width:80px;
}
</style>{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量修改物流</a></li>{/if}
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>下单模板：</td><td><select name="template_id" class="select">{$Template}</select></td><td>只对模板中勾选的字段进行验证</td></tr>
    <tr><td>订购产品：</td><td><select name="product_id" class="select">{$Product}</select></td></tr>
    <tr><td>成交单价：</td><td><input type="text" name="price" class="input-text"></td></tr>
    <tr><td>订购数量：</td><td><input type="text" name="count" value="1" class="input-text"></td></tr>
    <tr><td>姓　　名：</td><td><input type="text" name="name" class="input-text"></td></tr>
    <tr><td>联系电话：</td><td><input type="text" name="tel" class="input-text"></td></tr>
    <tr><td>所在地区：</td><td><div class="radio-box"><label><input type="radio" name="type" value="a" checked>选择填写</label></div><div class="radio-box"><label><input type="radio" name="type" value="b">手动填写</label></div></td></tr>
    <tr class="aa"><td></td><td><input type="hidden" name="province"><select class="select province"><option value="0">省份</option></select></td></tr>
    <tr class="aa"><td></td><td><input type="hidden" name="city"><select class="select city"><option value="0">城市</option></select></td></tr>
    <tr class="aa"><td></td><td><input type="hidden" name="county"><select class="select county"><option value="0">区/县</option></select></td></tr>
    <tr class="aa"><td></td><td><input type="hidden" name="town"><select class="select town"><option value="0">乡镇/街道（若不清楚，可不选）</option></select></td></tr>
    <tr class="bb"><td>省　　份：</td><td><input type="text" name="province2" class="input-text"></td></tr>
    <tr class="bb"><td>城　　市：</td><td><input type="text" name="city2" class="input-text"></td></tr>
    <tr class="bb"><td>区 / 县 ：</td><td><input type="text" name="county2" class="input-text"></td></tr>
    <tr class="bb"><td>乡镇/街道：</td><td><input type="text" name="town2" class="input-text text" placeholder="若不清楚，可留空"></td></tr>
    <tr><td>详细地址：</td><td><input type="text" name="address" class="input-text"></td></tr>
    <tr><td>邮政编码：</td><td><input type="text" name="post" class="input-text"></td></tr>
    <tr><td>备　　注：</td><td><textarea name="note" class="textarea"></textarea></td></tr>
    <tr><td>电子邮箱：</td><td><input type="text" name="email" class="input-text"></td></tr>
    <tr><td>支付状态：</td><td><select name="pay" class="select">{foreach name="Pay" key="key" item="value"}<option value="{$key}">{$value}</option>{/foreach}</select></td></tr>
    <tr><td>订单状态：</td><td>{$OrderState}</td></tr>
    <tr><td>物流公司：</td><td><select name="logistics_id" class="select">{$Logistics}</select></td></tr>
    <tr><td>物流编号：</td><td><input type="text" name="logistics_number" class="input-text"></td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}