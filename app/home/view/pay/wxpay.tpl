<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<title>{:config('system.web_name')}-微信支付</title>
<base href="{:config('app.web_url')}">
<script type="text/javascript" src="public/base/jquery.js?{:staticCache()}"></script>
<link rel="stylesheet" type="text/css" href="public/home/styles/{:request()->controller()}.css?{:staticCache()}">
<script type="text/javascript">
$(function(){
	var TIP = '{:url("/".parse_name(request()->controller())."/wxpayTip",["order_id"=>input("oid")])}';
	{if condition="$jsApiParameters"}
	function jsApiCall(){
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{$jsApiParameters},
			function(res){
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				if (res.err_msg=='get_brand_wcpay_request:ok') window.location.href = TIP;
			}
		);
	}
	if (typeof WeixinJSBridge == 'undefined'){
		if (document.addEventListener){
			document.addEventListener('WeixinJSBridgeReady',jsApiCall,false);
		}else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady',jsApiCall);
			document.attachEvent('onWeixinJSBridgeReady',jsApiCall);
		}
	}else{
		jsApiCall();
	}
	{elseif condition="$Url"/}
	setInterval(function(){
		$.ajax({
			type : 'POST',
			url : '{:url("/".parse_name(request()->controller())."/wxpayAjax")}',
			data : {
				order_id : '{:input("oid")}'
			},
			success : function(data,textStatus,jqXHR){
				if (data == 7) window.location.href = TIP;
			}
		});
	},1000);
	{/if}
});
</script>
</head>

<body>
{if condition="$Url"}
<div class="pay">
  <p><img src="{:config('system.index_php')}pay/wxpayimg?data={$Url}" alt="微信扫码支付"></p>
  <p>请使用微信扫一扫进行扫码支付</p>
</div>
{/if}
</body>
</html>