{extend name="../../common/view/base/form" /}

{block name="title"}系统升级{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbBak')}">备份数据库</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbUpdate')}">升级数据库</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form layui-form">
  <table>
    <tr><td>请确认您正在进行系统升级，并且系统中的bak目录存在备份的配置文件，然后点击以下按钮还原配置文件</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认还原" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}