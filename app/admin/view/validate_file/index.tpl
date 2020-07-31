{extend name="../../common/view/base/form" /}

{block name="title"}生成验证文件{/block}

{block name="nav"}
<li class="current"><a href="{:url('/'.parse_name(request()->controller()).'/index')}">生成验证文件</a></li>
{/block}

{block name="form"}
<form method="post" action="" class="form layui-form">
  <table>
    <tr><td colspan="2" class="tip left">此功能可按照您输入的内容在您的系统根目录生成对应的文件，用于第三方平台中的网站所属权验证；每次生成验证文件，将会自动删除上一次生成的验证文件。</td></tr>
    <tr><td>文 件 名：</td><td><input type="text" name="name" value="{:config('validate_file.name')}" class="input-text"></td></tr>
    <tr><td>扩 展 名：</td><td>{$Extension}</td></tr>
    <tr><td>文件内容：</td><td><textarea name="content" class="textarea">{:config('validate_file.content')}</textarea></td></tr>
    <tr><td colspan="2" class="left"><input type="submit" value="确认生成" class="btn btn-primary radius"></td></tr>
  </table>
</form>
{/block}