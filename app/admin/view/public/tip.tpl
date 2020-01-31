<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>{:C('WEB_NAME')}-提示</title>
<base href="{:C('WEB_URL')}">
<script type="text/javascript" src="__BASE__/jquery.js"></script>
<script type="text/javascript" src="__BASE__/H-ui.admin/js/H-ui.js"></script>
<script type="text/javascript" src="__BASE__/H-ui.admin/js/H-ui.admin.js"></script>
<link rel="stylesheet" type="text/css" href="__CSS__/Tip.css">
<script type="text/javascript">
var ThinkPHP = {
	'H-ui-skin' : '{:C("MANAGE_SKIN")}'
};
</script>
</head>

<body>
<div id="tip">
  <h3>提示</h3>
  
  <div>
    <h4 class="{$Kind}">{$Tip}</h4>
    <if condition="$Kind=='success'">
    <if condition="$Type==0">
    <p><a href="{$Url}">{$A}</a></p>
    <script type="text/javascript">setTimeout("location.href='{$Url}'",{$Refresh}*1000);</script>
    </if>
    <elseif condition="$Kind=='failed'"/>
    <if condition="$Type==0">
    <p><a href="javascript:history.go(-1)">{$A}</a></p>
    <script type="text/javascript">setTimeout('history.go(-1)',{$Refresh}*1000);</script>
    <elseif condition="$Type==1"/>
    <p><a href="{$Url}">{$A}</a></p>
    <script type="text/javascript">setTimeout("location.href='{$Url}'",{$Refresh}*1000);</script>
    </if>
    </if>
  </div>
</div>

{$run}
</body>
</html>