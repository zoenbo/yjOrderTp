{extend name="../../common/view/base/list" /}

{block name="title"}模板管理{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
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
    <tr><th class="name">模板名</th><th class="template">使用模板</th><th class="template_style_id">皮肤样式</th><th class="order_state">订单状态</th><th class="is_show_search">订单查询</th><th class="is_show_send">发货通知</th><th class="is_captcha">验证码</th><th class="is_qq">QQ登录</th><th class="is_default">是否默认</th><th class="date">添加时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['name']|keyword}</td><td>{$value['template']}</td><td>{if condition="$value['template_style_id']"}{$value['template_style_id']}号皮肤{else/}-{/if}</td><td>{$value['order_state']}</td><td>{if condition="$value['is_show_search']==0"}关闭{elseif condition="$value['is_show_search']==1"/}开启{/if}</td><td>{if condition="$value['is_show_send']==0"}关闭{elseif condition="$value['is_show_send']==1"/}开启{/if}</td><td>{if condition="$value['is_captcha']==0"}不添加{elseif condition="$value['is_captcha']==1"/}添加{/if}</td><td>{if condition="$value['is_qq']==0"}关闭{elseif condition="$value['is_qq']==1"/}开启{/if}</td><td>{if condition="$value['is_default']"}<span class="red">是</span>{else/}<a href="{:url('/'.parse_name(request()->controller()).'/isDefault',['id'=>$value['id']])}">设为默认</a>{/if}</td><td>{$value['date']|dateFormat}</td><td><a href="{:config('app.web_url')}{:config('system.index_php')}id/{$value['id']}.html" target="_blank">访问</a>/<a href="{:url('/'.parse_name(request()->controller()).'/code',['id'=>$value['id']])}">调用代码</a>/<a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的模板</p>
{/if}
{/block}