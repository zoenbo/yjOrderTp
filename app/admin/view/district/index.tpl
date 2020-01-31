{extend name="../../common/view/base/list" /}

{block name="title"}行政区划{/block}

{block name="nav"}
{if condition="input('get.pid',0)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index',['pid'=>$ParentId])}">返回上一级</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index',['pid'=>input('get.pid',0)])}">{if condition="input('get.pid',0)"}{$Map}{else/}一级区划{/if}</a></li>
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add',['pid'=>input('get.pid',0)])}">添加</a></li>{/if}
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="name">区划名称</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td>{if condition="$value['child']"}<a href="{:url('/'.parse_name(request()->controller()).'/index',['pid'=>$value['id']])}">查看子区划</a>/{/if}<a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的行政区划</p>
{/if}
{/block}