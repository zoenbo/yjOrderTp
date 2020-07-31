{extend name="../../common/view/base/list" /}

{block name="title"}登录记录{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.output'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/output')}">导出并清空</a></li>{/if}
{/block}

{block name="search"}
<form method="get" action="" class="search layui-form">搜索：<select name="manager_id" lay-search><option value="0">查看所有管理员</option>{$Manager}</select> <input type="text" name="keyword" value="{:input('get.keyword')}" class="input-text"><input type="submit" value="搜索" class="btn btn-primary radius"></form>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="manager">管理员</th><th class="ip">登录IP</th><th class="date">登录时间</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['manager']}</td><td>{$value['ip']|keyword}</td><td>{$value['date']|dateFormat}</td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的登录记录</p>
{/if}
{/block}