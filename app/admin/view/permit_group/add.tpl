{extend name="../../common/view/base/form" /}

{block name="title"}权限组{/block}
{block name="head"}<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js"></script>
<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css">{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>权限组名称：</td><td><input type="text" name="name" class="input-text"></td><td></td></tr>
    <tr><td>权　　限：</td><td colspan="2" class="tip">以黑色字体显示的权限为模块的主权限，以蓝色字体显示的权限为此模块中的子权限，以红色字体显示的权限为默认权限</td></tr>
    <tr><td></td><td colspan="2"><input type="button" value="全选" class="btn btn-primary radius all"> <input type="button" value="全部不选" class="btn btn-primary radius no"> <input type="button" value="默认权限" class="btn btn-primary radius selected"></td></tr>
    <tr><td></td><td colspan="2">{$Permit}</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}