{extend name="../../common/view/base/list" /}

{block name="title"}导出的数据{/block}
{block name="head"}<script type="text/javascript" src="public/admin/js/{:request()->controller()}.js"></script>{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">列表</a></li>
{/block}

{block name="search"}{/block}

{block name="list"}
{if condition="$All"}
<div class="list">
  <form method="post" action="{:url('/'.parse_name(request()->controller()).'/zip')}">
    <table>
      <tr><th class="zip">打包</th><th class="name">文件名</th><th class="size">文件大小</th><th class="control">操作</th></tr>
      {foreach name="All" key="key" item="value"}
      {foreach name="value" key="k1" item="v1"}
      <tr class="title"><td colspan="4">{$k1}</td></tr>
      {foreach name="v1" key="k2" item="v2"}
      <tr><td>{if condition="$key!='zip'"}<div class="radio-box"><label><input type="checkbox" name="files[]" value="{$v2['name']}" class="files"><span>.</span></label></div>{else/}-{/if}</td><td>{$v2['name']}</td><td>{$v2['size']}</td><td><a href="{:config('app.web_url')}{:config('app.output_dir')}{$v2['name']}">下载</a>/<a href="{:url('/'.parse_name(request()->controller()).'/delete',['id'=>$v2['name']])}">删除</a></td></tr>
      {/foreach}
      {/foreach}
      {/foreach}
      <tr class="footer"><td><div class="radio-box"><label><input type="checkbox" class="all">全选</label></div></td><td colspan="3"><div class="radio-box"><label><input type="checkbox" name="del" checked>打包完成后删除源文件</label></div><input type="submit" value="立即打包" class="btn btn-primary radius"></td></tr>
    </table>
  </form>
</div>
{else/}
<p class="nothing">暂无数据文件</p>
{/if}
{/block}