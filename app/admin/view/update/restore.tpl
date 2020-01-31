<extend name="Base/form" />

<block name="title">系统升级</block>

<block name="nav">
<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbbak')}">备份数据库</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbupdate')}">升级数据库</a></li>
</block>

<block name="form">
<div id="form">
  <form method="post" action="">
    <dl>
      <dd>请确认您正在进行系统升级，并且系统中的Bak目录存在备份的配置文件，然后点击以下按钮还原配置文件</dd>
      <dd><input type="submit" value="确认还原" class="btn btn-primary radius"></dd>
    </dl>
  </form>
</div>
</block>