<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-提示</title>
<base href="{:config('app.web_url')}">
<link rel="shortcut icon" type="image/x-icon" href="public/home/images/favicon.ico">
<script type="text/javascript" src="public/base/jquery.js"></script>
<script type="text/javascript" src="public/home/js/Tip.js"></script>
<link rel="stylesheet" type="text/css" href="public/home/styles/Tip.css">
</head>

<body>
<div class="tip">
  <p><img src="public/home/images/{$Kind}.png" alt="{$Kind}"></p>
  <p>{$Tip}</p>
  {if condition="$Kind=='success'"}
  {if condition="$Type==0"}
  <p><a href="{$Url}">{$A}</a></p>
  <script type="text/javascript">setTimeout("location.href='{$Url}'",{$Refresh}*1000);</script>
  {/if}
  {elseif condition="$Kind=='failed'"/}
  {if condition="$Type==0"}
  <p><a href="javascript:history.go(-1)">{$A}</a></p>
  <script type="text/javascript">setTimeout('history.go(-1)',{$Refresh}*1000);</script>
  {elseif condition="$Type==1"/}
  <p><a href="{$Url}">{$A}</a></p>
  <script type="text/javascript">setTimeout("location.href='{$Url}'",{$Refresh}*1000);</script>
  {/if}
  {/if}
</div>

{if condition="isset($Run)"}{$Run}{/if}
</body>
</html>