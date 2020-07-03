{extend name="../../common/view/base/form" /}

{block name="title"}管理员{/block}
{block name="head"}<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>input('get.id')])}">修改</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>帐　　号：</td><td><input type="text" name="name" value="{$One['name']}" class="input-text"></td></tr>
    <tr><td>密　　码：</td><td><input type="password" name="pass" class="input-text"></td><td>留空则不修改</td></tr>
    <tr><td>重复密码：</td><td><input type="password" name="repass" class="input-text"></td></tr>
    {if condition="$One['id']!=1"}
    <tr><td>身　　份：</td><td>{$Level}</td></tr>
    <tr><td>是否激活：</td><td>{$IsActivation}</td></tr>
    <tbody class="permit">
    <tr><td>权 限 组：</td><td><select name="permit_group_id" class="select">{$PermitGroup}</select></td></tr>
    <tr><td>订单权限：</td><td>{$OrderPermit}</td><td>设置对普通管理员订单开放的权限，为普通管理员分配了订单模块的管理权限后，此设置才可生效（超级管理员不受限）</td></tr>
    </tbody>
    {/if}
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}