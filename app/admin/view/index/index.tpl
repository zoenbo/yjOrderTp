<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:config('system.web_name')}</title>
<base href="{:config('app.web_url')}">
<link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/h-ui/css/H-ui.min.css">
<link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/h-ui.admin/css/H-ui.admin.css">
<link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/lib/Hui-iconfont/1.0.8/iconfont.css">
<link rel="stylesheet" type="text/css" href="public/base/H-ui.admin/h-ui.admin/skin/{:config('system.manage_skin')}/skin.css" id="skin">
<script type="text/javascript">
var ThinkPHP = {
	'H-ui-skin' : '{:config("system.manage_skin")}'
};
</script>
</head>

<body>
{if condition="config('app.demo')"}
<style type="text/css">
.a{position:absolute;z-index:100000;width:100%;text-align:center;}
.a a{background:#fefee9;border-color:#ccc;border-style:solid;border-width:0 1px 1px;color:red;display:inline-block;padding:5px 10px;}
</style>
<div class="a"><a href="https://github.com/HeroTianTYJ/yjOrderTp" target="_blank">下载本系统源码</a> <a href="https://www.yvjie.cn/order/index.html" target="_blank">功能更强大的《昱杰多功能订单管理系统》</a> <a href="https://www.yvjie.cn/web/index.html" target="_blank">《昱杰单页制作系统》，可视化制作产品单页</a></div>
{/if}

<header class="navbar-wrapper">
  <div class="navbar navbar-fixed-top">
    <div class="container-fluid cl">
      <a class="logo navbar-logo f-l mr-10 hidden-xs" href="{:url('/'.parse_name(request()->controller()).'/index')}">{:config('system.copyright_top')}</a> <span class="logo navbar-slogan f-l mr-10 hidden-xs">V{$Version[0]}</span>
      <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
        <ul class="cl">
          <li>{$Admin['name']}（{$Admin['group']}） [<a href="javascript:;" onclick="addTab('{:url('/profile/index')}','个人资料')">个人资料</a>] [<a href="javascript:;" onclick="addTab('{:url('/profile/login')}','登录记录')">登录记录</a>] [<a href="{:url('/login/logout')}">退出</a>] [<a href="https://item.taobao.com/item.htm?id=531038056831" target="_blank">赞助作者</a>]</li>
          <li id="Hui-skin" class="dropDown right dropDown_hover">
           <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
            <ul class="dropDown-menu menu radius box-shadow">
              <li><a href="javascript:;" data-val="default" title="黑色">黑色</a></li>
              <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
              <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
              <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
              <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
              <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<aside class="Hui-aside">
  <div class="menu_dropdown bk_2">
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Order']['index'],$Permission['Recycle']['index'],$Permission['OrderStatistic']['index'],$Permission['OrderState']['index'],$Permission['Logistics']['index']])"}
    <dl>
      <dt>订单<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Order']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/order/index')}" data-title="订单管理">订单管理</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Recycle']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/recycle/index')}" data-title="订单回收站">订单回收站</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['OrderStatistic']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/order_statistic/index')}" data-title="订单统计">订单统计</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['OrderState']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/order_state/index')}" data-title="订单状态">订单状态</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Logistics']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/logistics/index')}" data-title="物流管理">物流管理</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Product']['index'],$Permission['ProductSort']['index']])"}
    <dl>
      <dt>产品<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Product']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/product/index')}" data-title="产品管理">产品管理</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['ProductSort']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/product_sort/index')}" data-title="产品分类">产品分类</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Template']['index'],$Permission['TemplateStyle']['index'],$Permission['Field']['index']])"}
    <dl>
      <dt>下单模板<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Template']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/template/index')}" data-title="模板管理">模板管理</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['TemplateStyle']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/template_style/index')}" data-title="模板样式">模板样式</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Field']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/field/index')}" data-title="下单字段">下单字段</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    <dl>
      <dt>页面<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="https://www.yvjie.cn/web.php" target="_blank">单页制作</a></li>
        </ul>
      </dd>
    </dl>
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Visit']['index'],$Permission['Output']['index'],$Permission['District']['index']])"}
    <dl>
      <dt>数据<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Visit']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/visit/index')}" data-title="访问统计">访问统计</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Output']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/output/index')}" data-title="导出的数据">导出的数据</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['District']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/district/index')}" data-title="行政区划">行政区划</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Manager']['index'],$Permission['LoginRecord']['index'],$Permission['PermitGroup']['index'],$Permission['Permit']['index']])"}
    <dl>
      <dt>管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Manager']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/manager/index')}" data-title="管理员">管理员</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['LoginRecord']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/login_record/index')}" data-title="登录记录">登录记录</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['PermitGroup']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/permit_group/index')}" data-title="权限组">权限组</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Permit']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/permit/index')}" data-title="权限管理">权限管理</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['System']['index'],$Permission['ValidateFile']['index'],$Permission['Smtp']['index']])"}
    <dl>
      <dt>系统<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['System']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/system/index')}" data-title="系统设置">系统设置</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['ValidateFile']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/validate_file/index')}" data-title="生成验证文件">生成验证文件</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Smtp']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/smtp/index')}" data-title="SMTP服务器">SMTP服务器</a></li>{/if}
          {if condition="$Admin['level']==1"}<li><a href="javascript:;" data-href="{:url('/update/index')}" data-title="系统升级">系统升级</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
    {if condition="$Admin['level']==1||array_intersect($AdminPermit,[$Permission['Db']['index'],$Permission['Dbbak']['index']])"}
    <dl>
      <dt>数据库<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          {if condition="$Admin['level']==1||in_array($Permission['Db']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/db/index')}" data-title="数据表状态">数据表状态</a></li>{/if}
          {if condition="$Admin['level']==1||in_array($Permission['Dbbak']['index'],$AdminPermit)"}<li><a href="javascript:;" data-href="{:url('/dbbak/index')}" data-title="数据库备份">数据库备份</a></li>{/if}
        </ul>
      </dd>
    </dl>
    {/if}
  </div>
</aside>

<div class="dislpayArrow"><a class="pngfix" href="javascript:;" onClick="displaynavbar(this)"></a></div>

<section class="Hui-article-box">
  <div id="Hui-tabNav" class="Hui-tabNav">
    <div class="Hui-tabNav-wp">
      <ul id="min_title_list" class="acrossTab cl">
        <li class="active"><span title="起始页" data-href="{:url('/'.parse_name(request()->controller()).'/main')}">起始页</span><em></em></li>
      </ul>
    </div>
    
    <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
  </div>
  
  <div id="iframe_box" class="Hui-article" style="bottom:35px;">
    <div class="show_iframe">
      <div style="display:none" class="loading"></div>
      <iframe src="{:url('/'.parse_name(request()->controller()).'/main')}" scrolling="yes" frameborder="0"></iframe>
    </div>
  </div>
  
  <div style="width:100%;position:absolute;bottom:0;height:35px;line-height:35px;text-align:center;">
    <p>{:config('system.copyright_footer')}　|　<span id="run"></span></p>
  </div>
</section>

<script type="text/javascript" src="public/base/jquery.js"></script>
<script type="text/javascript" src="public/base/H-ui.admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="public/base/H-ui.admin/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="public/base/H-ui.admin/h-ui.admin/js/H-ui.admin.js"></script>
</body>
</html>