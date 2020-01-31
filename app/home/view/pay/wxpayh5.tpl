<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-微信支付</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="public/home/styles/{:request()->controller()}.css">
<script type="text/javascript">
$(function(){
	var TIP = '{:url("/".parse_name(request()->controller())."/wxpayTip",["oid"=>input("oid")])}';
	setInterval(function(){
		$.ajax({
			type : 'POST',
			url : '{:url("/".parse_name(request()->controller())."/wxpayAjax")}',
			data : {
				oid : '{:input("oid")}'
			},
			success : function(data,textStatus,jqXHR){
				if (data == 7) window.location.href = TIP;
			}
		});
	},1000);
});
</script>
</head>

<body>
<div class="pay">
  <p>请在微信端完成支付</p>
</div>
</body>
</html>