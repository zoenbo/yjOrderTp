<extend name="Base/form" />

<block name="title">系统升级</block>

<block name="nav">
<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/dbbak')}">备份数据库</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbupdate')}">升级数据库</a></li>
</block>

<block name="form">
<div id="form">
  <form method="post" action="">
    <dl>
      <dd>此备份功能只能备份您在本系统中添加的个人数据，仅供系统升级时使用</dd>
      <dd><input type="submit" value="确认备份" class="btn btn-primary radius"></dd>
    </dl>
  </form>
</div>
</block>