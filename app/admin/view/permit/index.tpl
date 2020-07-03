{extend name="../../common/view/base/list" /}

{block name="title"}权限管理{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>以黑色字体显示的权限为模块的主权限，以蓝色字体显示的权限为此模块中的子权限，分页中的总条数为主权限的总条数；</td></tr>
  <tr><td class="num">2、</td><td>可在<a href="javascript:" onclick="window.parent.addTab('{:url('/permit_group/index')}','权限组')">权限组</a>模块中的添加和修改中为相应的权限组分配权限；</td></tr>
  <tr><td class="num">3、</td><td>超级管理员不受权限的限制；</td></tr>
  <tr><td class="num">4、</td><td>您可将权限设置为默认权限，在添加权限组时，将自动勾选上默认权限；</td></tr>
  <tr><td class="num">5、</td><td>您还可对权限进行排序操作，在添加或修改权限组时，权限列表将以您设置的顺序进行显示。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <form method="post" action="{:url('/'.parse_name(request()->controller()).'/sort')}">
    <table>
      <tr><th class="name">权限名称</th><th class="controller">模块</th><th class="action">子模块</th><th class="is_default">是否默认</th><th class="sort"><input type="submit" value="排序" class="btn btn-primary radius"></th></tr>
      {foreach name="All" key="key" item="value"}
      <tr><td>{$value['name']|keyword}</td><td>{$value['controller']|keyword}</td><td>{$value['action']|keyword}</td><td>{if condition="$value['is_default']"}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$value['id']])}">取消默认</a>{else/}<span class="green">否</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$value['id']])}">设为默认</a>{/if}</td><td><input type="text" name="sort[{$value['id']}]" value="{$value['sort']}" class="input-text"></td></tr>
        {foreach name="value['obj']" key="k" item="v"}
        <tr><td class="blue">{$v['name']|keyword}</td><td>{$v['controller']|keyword}</td><td>{$v['action']|keyword}</td><td>{if condition="$v['is_default']"}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$v['id']])}">取消默认</a>{else/}<span class="green">否</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$v['id']])}">设为默认</a>{/if}</td><td><input type="text" name="sort[{$v['id']}]" value="{$v['sort']}" class="input-text"></td></tr>
        {/foreach}
      {/foreach}
    </table>
  </form>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的权限</p>
{/if}
{/block}