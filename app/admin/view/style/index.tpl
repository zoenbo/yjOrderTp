{extend name="../../common/view/base/list" /}

{block name="title"}模板样式{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="id">样式编号</th><th class="bgcolor">背景颜色</th><th class="bordercolor">边框颜色</th><th class="buttoncolor">按钮颜色</th><th class="date">添加时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['id']}</td><td>{$value['bgcolor']|keyword} <span style="background:{$value['bgcolor']};"></span></td><td>{$value['bordercolor']|keyword} <span style="background:{$value['bordercolor']};"></span></td><td>{$value['buttoncolor']|keyword} <span style="background:{$value['buttoncolor']};"></span></td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的模板样式</p>
{/if}
{/block}