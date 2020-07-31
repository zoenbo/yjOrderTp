{extend name="../../common/view/base/list" /}

{block name="title"}模板样式{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.add'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>{/if}
{/block}

{block name="list"}
{if condition="$All"}
{$Page}
<div class="list">
  <table>
    <tr><th class="id">样式编号</th><th class="bg_color">背景颜色</th><th class="border_color">边框颜色</th><th class="button_color">按钮颜色</th><th class="select_current_bg_color">下拉框选中背景颜色</th><th class="date">添加时间</th><th class="control">操作</th></tr>
    {foreach name="All" key="key" item="value"}
    <tr><td>{$value['id']}</td><td>{$value['bg_color']|keyword} <span style="background:{$value['bg_color']};"></span></td><td>{$value['border_color']|keyword} <span style="background:{$value['border_color']};"></span></td><td>{$value['button_color']|keyword} <span style="background:{$value['button_color']};"></span></td><td>{$value['select_current_bg_color']|keyword} <span style="background:{$value['select_current_bg_color']};"></span></td><td>{$value['date']|dateFormat}</td><td><a href="{:url('/'.parse_name(request()->controller()).'/update',['id'=>$value['id']])}">修改</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$value['id']])}">删除</a></td></tr>
     {/foreach}
  </table>
</div>
{$Page}
{else/}
<p class="nothing">没有找到您搜索的模板样式</p>
{/if}
{/block}