{extend name="../../common/view/base/form" /}

{block name="title"}数据库备份{/block}
{block name="head"}<link rel="stylesheet" type="text/css" href="public/admin/styles/{:request()->controller()}.css?{:staticCache()}">{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">备份</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form">
  <table>
    <tr><td class="tip">数据表，不选则为备份全部数据表</td></tr>
  </table>
  <table>
    {foreach name="All" key="key" item="value"}
    {if condition="($key+1)%4==1"}<tr>{/if}
    <td>{if condition="$value['Name']"}<div class="check-box"><label><input type="checkbox" name="tablename[]" value="{$value['Name']}">{$value['Name']}</label></div>{/if}</td>
    {if condition="($key+1)%4==0"}</tr>{/if}
    {/foreach}
  </table>
  <table>
    <tr><td>分　　卷：</td><td><input type="text" name="filesize" value="2000" class="input-text"></td><td>（KB，填0为不分卷）</td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认备份" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}