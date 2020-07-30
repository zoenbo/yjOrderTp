{extend name="../../common/view/base/form" /}

{block name="title"}模板管理{/block}
{block name="head"}<style type="text/css">
.form table tr td:nth-child(1){
	width:auto;
}
.form table tr td:nth-child(2){
	word-break:break-all;
}
.form table tr td:nth-child(3){
	text-indent:10px;
}
</style>{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/code',['id'=>input('get.id')])}">调用代码</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td colspan="3" class="left tip">请将您需要调用的下单页的页面与本系统放置同一域名下，否则下单页无法自适应高度</td></tr>
    <tr><td>调用代码1：</td><td>&lt;div style="width:{if condition="$One['template']==0"}{if condition="$One['is_show_send']==0"}616px{elseif condition="$One['is_show_send']==1"/}952px{/if}{elseif condition="$One['template']==1"/}600px{else/}100%{/if};margin:0 auto;"&gt;&lt;a name="order"&gt;&lt;/a&gt;&lt;iframe src="{:config('app.web_url')}{:config('system.index_php')}id/{:input('get.id')}.html" frameborder="0" style="width:100%;"&gt;&lt;/iframe&gt;&lt;/div&gt;&lt;script type="text/javascript" src="{:config('app.web_url')}public/home/js/FrameAuto.js?{:staticCache()}"&gt;&lt;/script&gt;</td><td>如果您的页面中引入了JQuery，请调用此代码，此代码可在<a href="https://www.yvjie.cn/web.php" target="_blank">《昱杰单页制作系统》</a>中调用</td></tr>
    <tr><td>调用代码2：</td><td>&lt;script type="text/javascript" src="{:config('app.web_url')}public/base/jquery.js?{:staticCache()}"&gt;&lt;/script&gt;&lt;div style="width:{if condition="$One['template']==0"}{if condition="$One['is_show_send']==0"}616px{elseif condition="$One['is_show_send']==1"/}952px{/if}{elseif condition="$One['template']==1"/}600px{else/}100%{/if};margin:0 auto;"&gt;&lt;a name="order"&gt;&lt;/a&gt;&lt;iframe src="{:config('app.web_url')}{:config('system.index_php')}id/{:input('get.id')}.html" frameborder="0" style="width:100%;"&gt;&lt;/iframe&gt;&lt;/div&gt;&lt;script type="text/javascript" src="{:config('app.web_url')}public/home/js/FrameAuto.js?{:staticCache()}"&gt;&lt;/script&gt;</td><td>如果您的页面中没有引入JQuery，请调用此代码</td></tr>
  </table>
</form>
{/block}