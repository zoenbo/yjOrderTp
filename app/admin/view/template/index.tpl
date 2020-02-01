{extend name="../../common/view/base/list" /}

{block name="title"}模板管理{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['add'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>模板设置默认后，在后台添加订单时将默认采用该模板勾选的字段进行验证。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="name">模板名</th><th class="template">使用模板</th><th class="sid">皮肤样式</th><th class="state">订单状态</th><th class="ordersearch">订单查询</th><th class="send">发货通知</th><th class="captcha">验证码</th><th class="qq">QQ登录</th><th class="selected">是否默认</th><th class="date">添加时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td>{$value['template']}</td><td>{if condition="$value['sid']"}{$value['sid']}号皮肤{else/}-{/if}</td><td>{$value['state']}</td><td>{if condition="$value['search']==0"}关闭{elseif condition="$value['search']==1"/}开启{/if}</td><td>{if condition="$value['send']==0"}关闭{elseif condition="$value['send']==1"/}开启{/if}</td><td>{$value['captcha']}</td><td>{if condition="$value['qq']==0"}关闭{elseif condition="$value['qq']==1"/}开启{/if}</td><td>{if condition="$value['selected']"}<span class="red">是</span>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/selected',['id'=>$value['id']])}">设为默认</a>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:config('app.web_url')}{:config('system.index_php')}id/{$value['id']}.html" target="_blank">访问</a>/<a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的模板</p>
{/if}
{/block}