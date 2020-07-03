{extend name="../../common/view/base/form" /}

{block name="title"}系统升级{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbBak')}">备份数据库</a></li>
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/dbUpdate')}">升级数据库</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>请确认您正在进行系统升级，并且系统中的bak目录存在备份的数据库文件，然后点击以下按钮升级数据库</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认升级" onclick="return confirm('此操作将会删除数据表，请确保您的个人数据已经通过上一步骤进行了备份，并已将备份的数据库文件下载到了您的电脑，再执行本操作，确定操作吗？')" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}