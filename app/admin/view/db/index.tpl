{extend name="../../common/view/base/list" /}

{block name="title"}数据表状态{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['optimize'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/optimize')}">优化表</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['repairautoindex'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/repairAutoindex')}">修复Autoindex</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['schema'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/schema')}">更新表缓存</a></li>{/if}
{/block}

{block name="search"}{/block}

{block name="list"}
{if condition="$All"}
<div class="list">
  <table>
    <tr><th class="name">表</th><th class="rows">记录数</th><th class="autoindex">Autoindex</th><th class="size">大小</th><th class="free">多余</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['Name']}</td><td>{$value['Rows']}</td><td>{$value['Auto_increment']}</td><td>{$value['size']}</td><td>{$value['Data_free']} 字节</td></tr>
     {/foreach}
    <tr class="tj"><td>{$TableCount}个表</td><td>{$Rows}</td><td>-</td><td>{$Size}</td><td>{$Free} 字节</td></tr>
  </table>
</div>
{else/}
<p class="nothing">暂无数据表</p>
{/if}
{/block}