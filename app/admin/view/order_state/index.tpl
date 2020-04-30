{extend name="../../common/view/base/list" /}

{block name="title"}订单状态{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>此模块中的“是否默认”设置仅在后台添加订单和添加模板时有效，前台下单的默认状态请在<a href="javascript:;" onclick="window.parent.addTab('{:url('/template/index')}','模板管理')">模板管理</a>模块中进行设置。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <form method="post" action="{:url('/'.parse_name(request()->controller()).'/sort')}">
    <table>
      <tr><th class="name">状态名称</th><th class="sort"><input type="submit" value="排序" class="btn btn-primary radius"></th><th class="is_default">是否默认</th><th class="date">添加时间</th><th class="control">操作</th></tr>
      {foreach name="All" key="key" item="value"}
      <tr><td style="color:{$value['color']};">{$value['name']|keyword}</td><td><input type="text" name="sort[{$value['id']}]" value="{$value['sort']}" class="input-text"></td><td>{if condition="$value['is_default']"}<span class="red">是</span>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/isdefault',['id'=>$value['id']])}">设为默认</a>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
       {/foreach}
    </table>
  </form>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的订单状态</p>
{/if}
{/block}