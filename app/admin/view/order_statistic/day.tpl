{extend name="../../common/view/base/list" /}

{block name="title"}订单统计{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/base/EasyUI/themes/default/easyui.css">{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">概况</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/day')}">按天</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.month'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/month')}">按月</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.year'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/year')}">按年</a></li>{/if}
{/block}

{block name="search"}{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>成交数和成交金额不计算已取消的订单；</td></tr>
  <tr><td class="num">2、</td><td>点击表头中的链接可进行排序操作。</td></tr>
</table>
{/block}

{block name="tools"}
<div class="tools">
  {include file="order/search" /}
  
  <h3>导出</h3>
  <form method="post" action="" class="multi_form">
    <div class="radio-box"><label><input type="radio" name="type" value="0" checked>导出当前统计结果</label></div><input type="submit" value="确认操作" class="btn btn-primary radius">
  </form>
</div>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <thead>
      <tr><th class="time" rowspan="2"><a href="{$Param}&order=0">时间</a></th><th colspan="4">订单数（单位：笔）</th><th colspan="4">订单金额（单位：元）</th><th colspan="4">合计</th></tr>
      <tr><th class="row"><a href="{$Param}&order=1">未发货</a></th><th class="row"><a href="{$Param}&order=2">已发货</a></th><th class="row"><a href="{$Param}&order=3">已取消</a></th><th class="row"><a href="{$Param}&order=4">已签收</a></th><th class="row"><a href="{$Param}&order=5">未发货</a></th><th class="row"><a href="{$Param}&order=6">已发货</a></th><th class="row"><a href="{$Param}&order=7">已取消</a></th><th class="row"><a href="{$Param}&order=8">已签收</a></th><th class="row">订单数</th><th class="row">成交数</th><th class="row">订单金额</th><th class="row">成交金额</th></tr>
    </thead>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['time']}</td><td>{$value['count1']}</td><td>{$value['count2']}</td><td>{$value['count3']}</td><td>{$value['count4']}</td><td>{$value['sum1']}</td><td>{$value['sum2']}</td><td>{$value['sum3']}</td><td>{$value['sum4']}</td><td>{$value['count5']}</td><td>{$value['count6']}</td><td>{$value['sum5']}</td><td>{$value['sum6']}</td></tr>
     {/foreach}
    <tr class="footer"><td>总计</td><td>{$Data['count1']}</td><td>{$Data['count2']}</td><td>{$Data['count3']}</td><td>{$Data['count4']}</td><td>{$Data['sum1']}</td><td>{$Data['sum2']}</td><td>{$Data['sum3']}</td><td>{$Data['sum4']}</td><td>{$Data['count5']}</td><td>{$Data['count6']}</td><td>{$Data['sum5']}</td><td>{$Data['sum6']}</td></tr>
  </table>
</div>
{$Page}
{else/}
<p class="nothing">暂无统计数据，订单管理模块中存在订单数据才会显示统计数据</p>
{/if}

<script type="text/javascript" src="public/base/EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="public/base/EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="public/base/jquery.freezeheader.js"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js"></script>
{/block}