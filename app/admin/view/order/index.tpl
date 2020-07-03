{extend name="../../common/view/base/list" /}

{block name="title"}{if condition="request()->controller()=='Order'"}订单管理{else/}订单回收站{/if}{/block}
{block name="base_css"}<link rel="stylesheet" type="text/css" href="public/admin/styles/Order.css?{:staticCache()}">{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/base/EasyUI/themes/default/easyui.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="request()->controller()=='Order'"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.multi'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/multi')}">批量修改物流</a></li>{/if}
{/if}
{/block}

{block name="search"}{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>列表中的详细地址默认显示25个字符（1个汉字表示2个字符），鼠标悬停在地址上，将显示地址的全部内容；</td></tr>
  <tr><td class="num">2、</td><td>鼠标悬停在订单IP上，将显示此IP的地理位置；悬停在订单来路上，将显示来路的URL；</td></tr>
  <tr><td class="num">3、</td><td>点击物流编号可查询物流进度。</td></tr>
</table>
{/block}

{block name="tools"}
<div class="tools">
  {include file="order/search" /}
  
  <h3>批量操作</h3>
  <form method="post" action="" class="multi_form">
    <input type="hidden" name="ids">
    {if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.output'),session(config('system.session_key').'.permit_manage'))"}
    <div class="radio-box"><label><input type="radio" name="type" value="0" checked>导出当前所有订单</label></div>
    <div class="radio-box"><label><input type="radio" name="type" value="1">导出选定订单</label></div>
    {/if}
    {if condition="request()->controller()=='Order'"}
    {if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.recycle2'),session(config('system.session_key').'.permit_manage'))"}
    <div class="radio-box"><label><input type="radio" name="type" value="2">删除选定订单</label></div>
    {/if}
    {else/}
    {if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.OrderRecycle.recover2'),session(config('system.session_key').'.permit_manage'))"}
    <div class="radio-box"><label><input type="radio" name="type" value="3">还原选定订单</label></div>
    {/if}
    {if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.OrderRecycle.delete2'),session(config('system.session_key').'.permit_manage'))"}
    <div class="radio-box"><label><input type="radio" name="type" value="4">删除选定订单</label></div>
    {/if}
    {/if}
    {if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.state'),session(config('system.session_key').'.permit_manage'))"}
    <div class="radio-box"><label><input type="radio" name="type" value="5">修改订单状态：</label></div><select name="order_state_id" class="select">{$OrderState}</select>
    {/if}
    <input type="submit" value="确认操作" class="btn btn-primary radius multi">
  </form>
</div>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="all"><div class="check-box"><label><input type="checkbox" class="all">全选</label></div></th><th class="order_id">订单号</th><th class="manager">下单管理员</th><th class="template">下单模板</th><th class="name">姓名</th><th class="pro">订购产品</th><th class="price">成交单价</th><th class="count">订购数量</th><th class="total">成交总价</th><th class="tel">联系电话</th><th class="address">详细地址</th><th class="post">邮政编码</th><th class="email">电子邮箱</th><th class="ip">下单IP</th><th class="referrer">下单来路</th><th class="date">下单时间</th><th class="pay">支付状态</th><th class="pay_id">支付订单号</th><th class="pay_scene">支付场景</th><th class="pay_date">支付时间</th><th class="order_state">订单状态</th><th class="logistics">物流信息</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td><div class="check-box"><label><input type="checkbox" name="id" value="{$value['id']}"><span>.</span></label></div></td><td>{$value['order_id']|keyword}</td><td>{$value['manager']}</td><td>{$value['template']}</td><td>{$value['name']|keyword}</td><td>{$value['pro']}</td><td>{$value['price']}元</td><td>{$value['count']}</td><td>{$value['total']}元</td><td>{$value['tel']|keyword}</td><td title="{$value['address']}">{$value['address']|truncate=0,25|keyword}</td><td>{$value['post']|keyword}</td><td>{$value['email']|keyword}</td><td title="{$value['ip_address']}">{$value['ip']|keyword}</td><td>{if condition="$value['referrer']"}<a href="{$value['referrer']}" target="_blank" title="{$value['referrer']}">来路</a>{else/}直接进入{/if}</td><td>{$value['date']|dateFormat}</td><td>{$value['pay']}</td><td>{$value['pay_id']|keyword}</td><td>{$value['pay_scene']}</td><td>{if condition="$value['pay_date']"}{$value['pay_date']|dateFormat}{/if}</td><td>{$value['order_state']}</td><td>{$value['logistics_name']}<br><a href="http://www.kuaidi100.com/chaxun?com={$value['logistics_code']}&nu={$value['logistics_number']}" target="_blank">{$value['logistics_number']|keyword}</a></td><td><a href="{:url('/'.parse_name(request()->controller()).'/detail',['id'=>$value['id']])}">详情</a>/<a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id'],'from'=>0])}">修改</a>/{if condition="request()->controller()=='Order'"}<a href="{:url('/'.parse_name(request()->controller()).'/recycle',['id'=>$value['id']])}">删除</a>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/recover',['id'=>$value['id']])}">还原</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a>{/if}</td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的订单</p>
{/if}

<script type="text/javascript" src="public/base/EasyUI/jquery.easyui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/EasyUI/locale/easyui-lang-zh_CN.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/Order.js?{:staticCache()}"></script>
{/block}