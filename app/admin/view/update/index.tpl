{extend name="../../common/view/base/form" /}

{block name="title"}系统升级{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/restore')}">还原配置文件</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbBak')}">备份数据库</a></li>
<li><a href="{:url('/'.parse_name(request()->controller()).'/dbUpdate')}">升级数据库</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>{$Version}</td></tr>
    <tr><td>升级前，请先认真阅读以下注意事项，确认无误后再进行备份操作</td></tr>
    <tr><td class="red">1、此功能仅限于非定制用户使用，定制用户无法使用；</td></tr>
    <tr><td class="red">2、请自行备份{:config('app.output_dir')}目录；另外，本系统目录中如果存在您自行创建的文件，也请自行备份；</td></tr>
    <tr><td class="red">3、此功能不会备份<a href="javascript:" onclick="window.parent.addTab('{:url('/district/index')}','行政区划')">行政区划</a>模块中的数据；</td></tr>
    <tr><td class="red">4、请到官网下载最新版的程序包：<a href="http://www.yvjie.cn/" target="_blank">http://www.yvjie.cn/</a>；</td></tr>
    <tr><td class="red">5、配置文件备份成功后，再上传最新版程序包；</td></tr>
    <tr><td class="red">6、请按“备份配置文件 - 还原配置文件 - 备份数据库 - 升级数据库”步骤依次进行，尽量一次性完成所有升级步骤；</td></tr>
    <tr><td class="red">7、此升级方法为常规方法，一般情况下会升级成功，如不成功，请联系作者协助解决。</td></tr>
    <tr><td class="blue">升级成功后，请注意：</td></tr>
    <tr><td class="blue">1、为了确保您的数据安全，请检查bak目录的bak_n.sql是否被删除；</td></tr>
    <tr><td class="blue">2、会取消掉所有默认权限，请重新在<a href="javascript:" onclick="window.parent.addTab('{:url('/permit/index')}','权限管理')">权限管理</a>模块中进行勾选；</td></tr>
    <tr><td class="blue">3、有一些版本的升级，如果增加了模块，可能会打乱权限控制的顺序，请重新在<a href="javascript:" onclick="window.parent.addTab('{:url('/permit_group/index')}','权限组')">权限组</a>模块中为权限组分配权限。</td></tr>
    <tr><td>如果您阅读完以上注意事项，并且准备就绪后，请点击以下按钮备份配置文件</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认备份" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}