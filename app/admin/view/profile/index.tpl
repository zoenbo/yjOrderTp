{extend name="../../common/view/base/form" /}

{block name="title"}个人资料{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">个人资料</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form layui-form">
  <table>
    <tr><td>用 户 名：</td><td>{$One['name']}</td></tr>
    <tr><td>身　　份：</td><td>{if condition="$One['id']==1"}创始人{else/}{if condition="$One['level']==1"}超级管理员{elseif condition="$One['level']==2"/}普通管理员{/if}{/if}</td></tr>
    <tr><td>所属权限组：</td><td>{:session(config('system.session_key').'.permit_group')}</td></tr>
    <tr><td>订单权限：</td><td>{if condition="$One['level']==1"}超级管理员，不受限{else/}{if condition="$One['order_permit']==1"}自己订单{elseif condition="$One['order_permit']==2"/}自己订单 + 前台订单{elseif condition="$One['order_permit']==3"/}所有订单{/if}{/if}</td></tr>
    <tr><td>旧 密 码：</td><td><input type="password" name="old_pass" class="input-text"></td></tr>
    <tr><td>新 密 码：</td><td><input type="password" name="pass" class="input-text"></td><td>留空则不修改</td></tr>
    <tr><td>重复密码：</td><td><input type="password" name="repass" class="input-text"></td></tr>
    <tr><td>　QQ绑定：</td><td>{if condition="$One['qqau']"}是 | <div class="check-box"><label><input type="checkbox" name="qqau" value="1">解除绑定</label>{else/}否 | <a href="javascript:" onClick="window.open('{:url('/'.parse_name(request()->controller()).'/qq')}','qq')">点此绑定</a>{/if}</td></tr>
    <tr><td>加入时间：</td><td>{$One['date']|dateFormat}</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}