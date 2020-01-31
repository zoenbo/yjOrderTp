{extend name="../../common/view/base/form" /}

{block name="title"}物流管理{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['multi'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>input('get.id')])}">修改</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>公司名称：</td><td><input type="text" name="name" value="{$One['name']}" class="input-text"></td></tr>
    <tr><td>公司代码：</td><td><input type="text" name="code" value="{$One['code']}" class="input-text"></td><td><a href="https://www.yvjie.cn/help/detail.html?id=3" target="_blank">点击此处</a>查询公司代码</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}