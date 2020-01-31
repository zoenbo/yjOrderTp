{extend name="../../common/view/base/list" /}

{block name="title"}SMTP服务器{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/state')}">运行状态</a></li>
{/block}

{block name="search"}{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>以红色显示的表示当前运行中的服务器。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
<div class="list" style="width:817px;">
  <table>
    <tr><th class="hour">时间</th><th class="smtp">SMTP服务器</th><th class="port">SMTP端口</th><th class="email">发信人邮件地址</th><th class="email">SMTP身份验证用户名</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr {if condition="$value['hour']==date('H')"}class="red"{/if}><td>{$value['hour']}:00 ～ {$value['hour']}:59</td><td>{$value[0]['smtp']}</td><td>{$value[0]['port']}</td><td>{$value[0]['email']}</td><td>{$value[0]['user']}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value[0]['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value[0]['id']])}">删除</a></td></tr>
    {/foreach}
  </table>
</div>
{else/}
<p class="nothing">尚未添加SMTP服务器</p>
{/if}
{/block}