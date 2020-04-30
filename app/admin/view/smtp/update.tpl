{extend name="../../common/view/base/form" /}

{block name="title"}SMTP服务器{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.state'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/state')}">运行状态</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>input('get.id')])}">修改</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>SMTP服务器：</td><td><input type="text" name="smtp" value="{$One['smtp']}" class="input-text"></td></tr>
    <tr><td>SMTP端口：</td><td><input type="text" name="port" value="{$One['port']}" class="input-text"></td></tr>
    <tr><td>发信人邮件地址：</td><td><input type="text" name="email" value="{$One['email']}" class="input-text"></td></tr>
    <tr><td>SMTP身份验证用户名：</td><td><input type="text" name="user" value="{$One['user']}" class="input-text"></td></tr>
    <tr><td>SMTP身份验证密码：</td><td><input type="text" name="pass" class="input-text"></td><td>留空则不修改</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}