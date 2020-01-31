{extend name="../../common/view/base/form" /}

{block name="title"}订单管理{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量修改物流</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>修改物流：</td><td><textarea name="multi" class="textarea"></textarea></td><td>格式：订单号|物流ID|物流编号，物流ID请在<a href="javascript:;" onclick="addTab('{:url('/logistics/index')}','物流管理')">物流管理</a>模块中查询</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认修改" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}