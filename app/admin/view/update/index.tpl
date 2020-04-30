<extend name="Base/form" />

<block name="title">系统升级</block>

<block name="nav">
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbbak')}">备份数据库</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbupdate')}">升级数据库</a></li>
</block>

<block name="form">
<div id="form">
  <form method="post" action="">
    <dl>
      <dd>{$Version}</dd>
      <dd>升级前，请先认真阅读以下注意事项，确认无误后再进行备份操作</dd>
      <dd class="red">1、此功能仅限于非定制用户使用，定制用户无法使用；</dd>
      <dd class="red">2、请自行备份{:C('OUTPUT_DIR')}目录；另外，本系统目录中如果存在您自行创建的文件，也请自行备份；</dd>
      <dd class="red">3、请到官网下载最新版的程序包：<a href="http://www.yvjie.cn/" target="_blank">http://www.yvjie.cn/</a>；</dd>
      <dd class="red">4、配置文件备份成功后，再上传最新版程序包；</dd>
      <dd class="red">5、请按“备份配置文件 - 还原配置文件 - 备份数据库 - 升级数据库”步骤依次进行，尽量一次性完成所有升级步骤；</dd>
      <dd class="red">6、本升级方法为常规方法，一般情况下会升级成功，如不成功，请联系作者协助解决。</dd>
      <dd class="blue">升级成功后，请注意：</dd>
      <dd class="blue">1、为了确保您的数据安全，请检查Bak目录的bak_n.sql是否被删除；</dd>
      <dd class="blue">2、请在<a href="javascript:;" onclick="window.parent.addTab('{:url('/Template/index')}','模板管理')">模板管理</a>模块中重新生成下单页；</dd>
      <dd class="blue">3、会取消掉所有默认权限，请重新在<a href="javascript:;" onclick="window.parent.addTab('{:url('/Permit/index')}','权限管理')">权限管理</a>模块中进行勾选；</dd>
      <dd class="blue">4、有一些版本的升级，如果增加了模块，可能会（但不一定）打乱权限控制的顺序，请重新在<a href="javascript:;" onclick="window.parent.addTab('{:url('/Manager/index')}','管理员')">管理员</a>模块中为管理员分配权限。</dd>
      <dd>如果您阅读完以上注意事项，并且准备就绪后，请点击以下按钮备份配置文件</dd>
      <dd><input type="submit" value="确认备份" class="btn btn-primary radius"></dd>
    </dl>
  </form>
</div>
</block>