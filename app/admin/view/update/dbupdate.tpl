<extend name="Base/form" />

<block name="title">系统升级</block>

<block name="nav">
<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbbak')}">备份数据库</a></li>
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/dbupdate')}">升级数据库</a></li>
</block>

<block name="form">
<div id="form">
  <form method="post" action="">
    <dl>
      <dd>请确认您正在进行系统升级，并且系统中的Bak目录存在备份的数据库文件，然后点击以下按钮升级数据库</dd>
      <dd><input type="submit" value="确认升级" onclick="return confirm('此操作将会删除数据表，请确保您的个人数据已经通过上一步骤进行了\n备份，并已将备份的数据库文件下载到了您的电脑，再执行本操作，确\n定操作吗？') ? true : false" class="btn btn-primary radius"></dd>
    </dl>
  </form>
</div>
</block>