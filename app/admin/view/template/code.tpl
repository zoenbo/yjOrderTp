{extend name="../../common/view/base/form" /}

{block name="title"}模板管理{/block}

{block name="form"}
<div class="code"><div style="width:{if condition="$One['template']==0"}{if condition="$One['send']==0"}616px{elseif condition="$One['send']==1"/}952px{/if}{elseif condition="$One['template']==1"/}600px{else/}480px{/if};margin:0 auto;"><a name="order"></a><iframe src="{:config('app.web_url')}{:config('system.index_php')}id/{:input('get.id')}.html" frameborder="0" style="border:none;width:100%;"></iframe></div></div>

<script type="text/javascript" src="public/admin/js/FrameAuto.js"></script>
{/block}