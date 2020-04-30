{extend name="../../common/view/base/list" /}

{block name="title"}访问统计{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.output'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/output')}">导出并清空</a></li>{/if}
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>在需要统计的页面引入&lt;script type="text/javascript" src="{:config('app.web_url')}public/home/js/Visit.js?{:staticCache()}"&gt;&lt;/script&gt;即可进行统计；</td></tr>
  <tr><td class="num">2、</td><td>为了节省数据库空间，系统会每天自动将统计的数据导出到文件，请到<a href="javascript:;" onclick="addTab('{:url('/output/index')}','导出的数据')">导出的数据</a>模块中进行下载。您也可以点击上方的“导出并清空”自行导出数据；</td></tr>
  <tr><td class="num">3、</td><td>如果发生统计不到的情况，请尝试<a href="{:url('/'.parse_name(request()->controller()).'/js')}">点击此处</a>配置Visit.js?{:staticCache()}文件。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="ip" rowspan="2">IP</th><th class="url" rowspan="2">访问页面</th><th colspan="3">当日访问</th></tr>
    <tr><th class="count">次数</th><th class="date">第一次</th><th class="date">最后一次</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['ip']|keyword}</td><td><a href="{$value['url']}" target="_blank" title="{$value['url']}">{$value['url']|truncate=0,26|keyword}</a></td><td>{$value['count']}</td><td>{$value['date1']|dateFormat}</td><td>{$value['date2']|dateFormat}</td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的访问记录</p>
{/if}
{/block}