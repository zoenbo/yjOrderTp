{extend name="../../common/view/base/list" /}

{block name="title"}SMTP服务器{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.state'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/state')}">运行状态</a></li>{/if}
{/block}

{block name="tip"}
<table class="tip">
  <tr><th colspan="2">技巧提示</th></tr>
  <tr><td class="num">1、</td><td>本系统可以每小时自动切换一台SMTP服务器，若想实现切换效果，请至少设置两台SMTP服务器；</td></tr>
  <tr><td class="num">2、</td><td>建议使用QQ邮箱，但注意：①要开通SMTP服务，开通方法请<a href="http://service.mail.qq.com/cgi-bin/help?subtype=1&no=166&id=28" target="_blank">点击此处</a>查看 ②“发信人邮件地址”和“身份验证用户名”请不要和<a href="javascript:;" onclick="window.parent.addTab('{:url('/system/index')}','系统设置')">系统设置</a>模块中的管理员邮箱重复；</td></tr>
  <tr><td class="num">3、</td><td>设置参数，以QQ邮箱为例。服务器和端口分别为：smtp.qq.com、25或ssl://smtp.qq.com、465（后者较稳定） | 发信人邮件地址、身份验证用户名均为邮箱地址（注意加@qq.com） | 身份验证密码为邮箱密码（如果是新开通的STMP服务，开通时会生成一个授权码，身份验证密码为这个授权码）。</td></tr>
</table>
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="smtp">SMTP服务器</th><th class="port">SMTP端口</th><th class="email">发信人邮件地址</th><th class="email">SMTP身份验证用户名</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['smtp']|keyword}</td><td>{$value['port']|keyword}</td><td>{$value['email']|keyword}</td><td>{$value['user']|keyword}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
    {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的SMTP服务器</p>
{/if}
{/block}