{extend name="../../common/view/base/list" /}

{block name="title"}产品管理{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="search"}
<form method="get" action="" class="search">搜索：<select name="product_sort_id" class="select"><option value="0">查看所有分类</option>{$ProductSort}</select> <input type="text" name="keyword" value="{:input('get.keyword')}" class="input-text"><input type="submit" value="搜索" class="btn btn-primary radius"></form>
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>此模块中的“是否默认”设置仅在后台添加订单时有效，前台订单页面中的默认产品请在<a href="javascript:" onclick="window.parent.addTab('{:url('/template/index')}','模板管理')">模板管理</a>模块中进行设置。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <form method="post" action="{:url('/'.parse_name(request()->controller()).'/sort')}">
    <table>
      <tr><th class="name">产品名称</th><th class="product_sort">产品分类</th><th class="price">产品价格</th><th class="sort"><input type="submit" value="排序" class="btn btn-primary radius"></th><th class="is_view">前台显示</th><th class="is_default">是否默认</th><th class="date">添加时间</th><th class="control">操作</th></tr>
      {foreach name="All" key="key" item="value"}
      <tr><td style="color:{$value['color']};">{$value['name']|keyword}</td><td>{$value['product_sort']}</td><td>{$value['price']|keyword}元</td><td><input type="text" name="sort[{$value['id']}]" value="{$value['sort']}" class="input-text"></td><td>{if condition="$value['is_view']==0"}<span class="green">否</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isView',['id'=>$value['id']])}">前台显示</a>{elseif condition="$value['is_view']==1"/}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isView',['id'=>$value['id']])}">取消显示</a>{/if}</td><td>{if condition="$value['is_default']"}<span class="red">是</span>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$value['id']])}">设为默认</a>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
       {/foreach}
    </table>
  </form>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的产品</p>
{/if}
{/block}