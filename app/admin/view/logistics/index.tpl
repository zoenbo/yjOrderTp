{extend name="../../common/view/base/list" /}

{block name="title"}物流管理{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量添加</a></li>{/if}
{/block}


{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="id">ID</th><th class="name">公司名称</th><th class="code">公司代码</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['id']}</td><td>{$value['name']|keyword}</td><td>{$value['code']|keyword}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的物流</p>
{/if}
{/block}