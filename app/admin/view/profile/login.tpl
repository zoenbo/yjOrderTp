{extend name="../../common/view/base/list" /}

{block name="title"}登录记录{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/login')}">列表</a></li>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="ip">登录IP</th><th class="date">登录时间</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['ip']|keyword}</td><td>{$value['date']|dateFormat}</td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的登录记录</p>
{/if}
{/block}