{extend name="../../common/view/base/list" /}

{block name="title"}产品分类{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <form method="post" action="{:url('/'.parse_name(request()->controller()).'/sort')}">
    <table>
      <tr><th class="name">分类名称</th><th class="sort"><input type="submit" value="排序" class="btn btn-primary radius"></th><th class="date">添加时间</th><th class="control">操作</th></tr>
      {foreach name="All" key="key" item="value"}
      <tr><td style="color:{$value['color']};">{$value['name']|keyword}</td><td><input type="text" name="sort[{$value['id']}]" value="{$value['sort']}" class="input-text"></td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
       {/foreach}
    </table>
  </form>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的产品分类</p>
{/if}
{/block}