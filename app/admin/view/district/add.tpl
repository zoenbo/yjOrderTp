{extend name="../../common/view/base/form" /}

{block name="title"}行政区划{/block}

{block name="nav"}
{if condition="$Admin['level']==1||in_array($Permission[request()->controller()]['index'],$AdminPermit)"}<li><a href="{:url('/'.parse_name(request()->controller()).'/index',['parent_id'=>input('get.parent_id',0)])}">{if condition="$Map"}{$Map}{else/}一级区划{/if}</a></li>{/if}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/add',['parent_id'=>input('get.parent_id',0)])}">添加</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td>区划名称：</td><td><input type="text" name="name" class="input-text"></td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认添加" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}