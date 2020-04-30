{extend name="../../common/view/base/list" /}

{block name="title"}订单统计{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/base/EasyUI/themes/default/easyui.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">概况</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.day'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/day')}">按天</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.month'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/month')}">按月</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.year'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/year')}">按年</a></li>{/if}
{/block}

{block name="search"}{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>成交数和成交金额不计算已取消的订单。</td></tr>
</table>
{/block}

{block name="tools"}
<div class="tools">
  {include file="order/search" /}
  <p style="clear:both">&nbsp;</p>
</div>
{/block}

{block name="list"}
<div class="list">
  <table>
    <thead>
      <tr><th class="date" rowspan="2">时间</th><th colspan="4">订单数（单位：笔）</th><th colspan="4">订单金额（单位：元）</th><th colspan="4">合计</th></tr>
      <tr><th class="row">未发货</th><th class="row">已发货</th><th class="row">已取消</th><th class="row">已签收</th><th class="row">未发货</th><th class="row">已发货</th><th class="row">已取消</th><th class="row">已签收</th><th class="row">订单数</th><th class="row">成交数</th><th class="row">订单金额</th><th class="row">成交金额</th></tr>
    </thead>
    <tr><td>今天（{$Data['day1']['time']}）</td><td>{$Data['day1']['data']['count1']}</td><td>{$Data['day1']['data']['count2']}</td><td>{$Data['day1']['data']['count3']}</td><td>{$Data['day1']['data']['count4']}</td><td>{$Data['day1']['data']['sum1']}</td><td>{$Data['day1']['data']['sum2']}</td><td>{$Data['day1']['data']['sum3']}</td><td>{$Data['day1']['data']['sum4']}</td><td>{$Data['day1']['data']['count5']}</td><td>{$Data['day1']['data']['count6']}</td><td>{$Data['day1']['data']['sum5']}</td><td>{$Data['day1']['data']['sum6']}</td></tr>
    <tr><td>昨天（{$Data['day2']['time']}）</td><td>{$Data['day2']['data']['count1']}</td><td>{$Data['day2']['data']['count2']}</td><td>{$Data['day2']['data']['count3']}</td><td>{$Data['day2']['data']['count4']}</td><td>{$Data['day2']['data']['sum1']}</td><td>{$Data['day2']['data']['sum2']}</td><td>{$Data['day2']['data']['sum3']}</td><td>{$Data['day2']['data']['sum4']}</td><td>{$Data['day2']['data']['count5']}</td><td>{$Data['day2']['data']['count6']}</td><td>{$Data['day2']['data']['sum5']}</td><td>{$Data['day2']['data']['sum6']}</td></tr>
    <tr><td>本周（{$Data['week1']['time1']}～{$Data['week1']['time2']}）</td><td>{$Data['week1']['data']['count1']}</td><td>{$Data['week1']['data']['count2']}</td><td>{$Data['week1']['data']['count3']}</td><td>{$Data['week1']['data']['count4']}</td><td>{$Data['week1']['data']['sum1']}</td><td>{$Data['week1']['data']['sum2']}</td><td>{$Data['week1']['data']['sum3']}</td><td>{$Data['week1']['data']['sum4']}</td><td>{$Data['week1']['data']['count5']}</td><td>{$Data['week1']['data']['count6']}</td><td>{$Data['week1']['data']['sum5']}</td><td>{$Data['week1']['data']['sum6']}</td></tr>
    <tr><td>最近一周（{$Data['week2']['time1']}～{$Data['week2']['time2']}）</td><td>{$Data['week2']['data']['count1']}</td><td>{$Data['week2']['data']['count2']}</td><td>{$Data['week2']['data']['count3']}</td><td>{$Data['week2']['data']['count4']}</td><td>{$Data['week2']['data']['sum1']}</td><td>{$Data['week2']['data']['sum2']}</td><td>{$Data['week2']['data']['sum3']}</td><td>{$Data['week2']['data']['sum4']}</td><td>{$Data['week2']['data']['count5']}</td><td>{$Data['week2']['data']['count6']}</td><td>{$Data['week2']['data']['sum5']}</td><td>{$Data['week2']['data']['sum6']}</td></tr>
    <tr><td>本月（{$Data['month1']['time1']}～{$Data['month1']['time2']}）</td><td>{$Data['month1']['data']['count1']}</td><td>{$Data['month1']['data']['count2']}</td><td>{$Data['month1']['data']['count3']}</td><td>{$Data['month1']['data']['count4']}</td><td>{$Data['month1']['data']['sum1']}</td><td>{$Data['month1']['data']['sum2']}</td><td>{$Data['month1']['data']['sum3']}</td><td>{$Data['month1']['data']['sum4']}</td><td>{$Data['month1']['data']['count5']}</td><td>{$Data['month1']['data']['count6']}</td><td>{$Data['month1']['data']['sum5']}</td><td>{$Data['month1']['data']['sum6']}</td></tr>
    <tr><td>最近一月（{$Data['month2']['time1']}～{$Data['month2']['time2']}）</td><td>{$Data['month2']['data']['count1']}</td><td>{$Data['month2']['data']['count2']}</td><td>{$Data['month2']['data']['count3']}</td><td>{$Data['month2']['data']['count4']}</td><td>{$Data['month2']['data']['sum1']}</td><td>{$Data['month2']['data']['sum2']}</td><td>{$Data['month2']['data']['sum3']}</td><td>{$Data['month2']['data']['sum4']}</td><td>{$Data['month2']['data']['count5']}</td><td>{$Data['month2']['data']['count6']}</td><td>{$Data['month2']['data']['sum5']}</td><td>{$Data['month2']['data']['sum6']}</td></tr>
    <tr><td>今年（{$Data['year1']['time1']}～{$Data['year1']['time2']}）</td><td>{$Data['year1']['data']['count1']}</td><td>{$Data['year1']['data']['count2']}</td><td>{$Data['year1']['data']['count3']}</td><td>{$Data['year1']['data']['count4']}</td><td>{$Data['year1']['data']['sum1']}</td><td>{$Data['year1']['data']['sum2']}</td><td>{$Data['year1']['data']['sum3']}</td><td>{$Data['year1']['data']['sum4']}</td><td>{$Data['year1']['data']['count5']}</td><td>{$Data['year1']['data']['count6']}</td><td>{$Data['year1']['data']['sum5']}</td><td>{$Data['year1']['data']['sum6']}</td></tr>
    <tr><td>最近一年（{$Data['year2']['time1']}～{$Data['year2']['time2']}）</td><td>{$Data['year2']['data']['count1']}</td><td>{$Data['year2']['data']['count2']}</td><td>{$Data['year2']['data']['count3']}</td><td>{$Data['year2']['data']['count4']}</td><td>{$Data['year2']['data']['sum1']}</td><td>{$Data['year2']['data']['sum2']}</td><td>{$Data['year2']['data']['sum3']}</td><td>{$Data['year2']['data']['sum4']}</td><td>{$Data['year2']['data']['count5']}</td><td>{$Data['year2']['data']['count6']}</td><td>{$Data['year2']['data']['sum5']}</td><td>{$Data['year2']['data']['sum6']}</td></tr>
    <tr><td>总计（{$Data['add']['time1']}～{$Data['add']['time2']}）</td><td>{$Data['add']['data']['count1']}</td><td>{$Data['add']['data']['count2']}</td><td>{$Data['add']['data']['count3']}</td><td>{$Data['add']['data']['count4']}</td><td>{$Data['add']['data']['sum1']}</td><td>{$Data['add']['data']['sum2']}</td><td>{$Data['add']['data']['sum3']}</td><td>{$Data['add']['data']['sum4']}</td><td>{$Data['add']['data']['count5']}</td><td>{$Data['add']['data']['count6']}</td><td>{$Data['add']['data']['sum5']}</td><td>{$Data['add']['data']['sum6']}</td></tr>
  </table>
</div>

<script type="text/javascript" src="public/base/EasyUI/jquery.easyui.min.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/EasyUI/locale/easyui-lang-zh_CN.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/base/jquery.freezeheader.js?{:staticCache()}"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js?{:staticCache()}"></script>
{/block}