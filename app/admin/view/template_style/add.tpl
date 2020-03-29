{extend name="../../common/view/base/form" /}

{block name="title"}模板样式{/block}
{block name="head"}<script type="text/javascript" src="public/base/jquery.colorpicker.js"></script>
<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js"></script>{/block}

{block name="nav"}
{if condition="session(config('system.session_key').'.level')==1||in_array(config('permit_manage.'.request()->controller().'.index'),session(config('system.session_key').'.permit_manage'))"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add')}">添加</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>背景颜色：</td><td><input type="text" name="bg_color" class="input-text"></td><td rowspan="3">颜色值可以为：表示颜色的英文单词，如red；16进制的颜色代码，如#FF0000；10进制的颜色代码，如rgb(255,0,0)。</td></tr>
    <tr><td>边框颜色：</td><td><input type="text" name="border_color" class="input-text"></td></tr>
    <tr><td>按钮颜色：</td><td><input type="text" name="button_color" class="input-text"></td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}