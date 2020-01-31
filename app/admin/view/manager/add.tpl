{extend name="../../common/view/base/form" /}

{block name="title"}管理员{/block}
{block name="head"}<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js"></script>
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css">{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>帐　　号：</td><td><input type="text" name="name" class="input-text"></td></tr>
    <tr><td>密　　码：</td><td><input type="password" name="pass" class="input-text"></td></tr>
    <tr><td>重复密码：</td><td><input type="password" name="repass" class="input-text"></td></tr>
    <tr><td>身　　份：</td><td>{$Level}</td></tr>
    <tr><td>是否激活：</td><td>{$Activation}</td></tr>
    <tbody class="permit">
    <tr><td>权 限 组：</td><td><select name="gid" class="select">{$Group}</select></td></tr>
    <tr><td>订单权限：</td><td>{$OrderPermit}</td><td>设置对普通管理员订单开放的权限，为普通管理员分配了订单模块的管理权限后，此设置才可生效（超级管理员不受限）</td></tr>
    </tbody>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}