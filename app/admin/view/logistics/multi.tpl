{extend name="../../common/view/base/form" /}

{block name="title"}物流管理{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量添加</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>批量添加：</td><td><textarea name="multi" class="textarea"></textarea></td><td>格式：公司名称|公司代码，每一行代表一个物流公司，<a href="https://www.yvjie.cn/help/detail.html?id=3" target="_blank">点击此处</a>查询或下载公司代码</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}