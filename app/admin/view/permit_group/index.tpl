{extend name="../../common/view/base/list" /}

{block name="title"}权限组{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="name">权限组</th><th class="permit">拥有权限</th><th class="is_default">是否默认</th><th class="date">添加时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td style="text-align:left;padding:5px;">{$value['permit']}</td><td>{if condition="$value['is_default']"}<span class="red">是</span>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$value['id']])}">设为默认</a>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的权限组</p>
{/if}
{/block}