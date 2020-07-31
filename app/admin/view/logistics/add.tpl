{extend name="../../common/view/base/form" /}

{block name="title"}物流管理{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量添加</a></li>{/if}
{/block}

{block name="form"}
<form method="post" action="" class="form layui-form">
  <table>
    <tr><td>公司名称：</td><td><input type="text" name="name" class="input-text"></td></tr>
    <tr><td>公司代码：</td><td><input type="text" name="code" class="input-text"></td><td><a href="https://www.yvjie.cn/help/detail.html?id=3" target="_blank">点击此处</a>查询公司代码</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}