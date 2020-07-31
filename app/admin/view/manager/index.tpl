{extend name="../../common/view/base/list" /}

{block name="title"}管理员{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/base/EasyUI/themes/default/easyui.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="search"}{/block}

{block name="tools"}
<div class="tools">
  <h3>高级搜索</h3>
  <form method="get" action="" class="layui-form">
    <label>帐号：<input type="text" name="keyword" value="{:input('get.keyword')}" class="input-text"></label>
    <label>身份：<select name="level" lay-search><option value="0">不限</option>{$Level}</select></label>
    <label>是否激活：<select name="is_activation" lay-search><option value="-1">不限</option>{$IsActivation}</select></label>
    <label>权限组：<select name="permit_group_id" lay-search><option value="0">不限</option>{$PermitGroup}</select></label>
    <label>订单权限：<select name="order_permit" lay-search><option value="0">不限</option>{$OrderPermit}</select></label>
    <label>QQ绑定：<select name="qq" lay-search><option value="-1">不限</option>{$Qq}</select></label>
    <label>加入时间：<input type="text" name="date1" value="{:input('get.date1')}" class="date"> ～ <input type="text" name="date2" value="{:input('get.date2')}" class="date"></label>
    <label><input type="submit" value="搜索" class="btn btn-primary radius"></label>
  </form>
</div>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="name">帐号</th><th class="level">身份</th><th class="is_activation">是否激活</th><th class="group">所属权限组</th><th class="order_permit">订单权限</th><th class="qqau">QQ绑定</th><th class="date">加入时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td>{if condition="$value['id']==1"}<span class="red">创始人</span>{else/}{$value['level_name']}{/if}</td><td>{if condition="$value['id']==1"}-{else/}{if condition="$value['is_activation']==0"}<span class="green">否</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isActivation',['id'=>$value['id']])}">帮他激活</a>{elseif condition="$value['is_activation']==1"/}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/isActivation',['id'=>$value['id']])}">取消激活</a>{/if}{/if}</td><td>{if condition="$value['level']==1"}-{else/}{$value['group']}{/if}</td><td>{$value['order_permit']}</td><td>{if condition="$value['qqau']"}<span class="red">是</span> | <a href="{:url('/'.parse_name(request()->controller()).'/qq',['id'=>$value['id']])}">解除绑定</a>{else/}<span class="green">否</span>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的管理员</p>
{/if}

<script type="text/javascript" src="public/base/EasyUI/jquery.easyui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/EasyUI/locale/easyui-lang-zh_CN.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
{/block}