{extend name="../../common/view/base/list" /}

{block name="title"}下单字段{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>您可将字段设置为默认字段，在添加模板时，将自动勾选上默认字段。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="name">字段名称</th><th class="selected">是否默认</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td>{if condition="$value['selected']"}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/selected',['id'=>$value['id']])}">取消默认</a>{else/}<span class="green">否</span> | <a href="{:url('/'.parse_name(request()->controller()).'/selected',['id'=>$value['id']])}">设为默认</a>{/if}</td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的下单字段</p>
{/if}
{/block}