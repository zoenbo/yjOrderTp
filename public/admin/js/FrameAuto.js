$(function(){
	$('iframe').on('load',function(){
		iframeSize(this);
	});
	function iframeSize(element){
		if (element && !window.opera){
			if (element.contentDocument && element.contentDocument.body.offsetHeight){
				$(element).height(element.contentDocument.body.offsetHeight);
			}else if (element.document && element.document.body.scrollHeight){
				$(element).height(element.document.body.scrollHeight);
			}
		}
	}
	
	$(window).on('load',function(){
		setTimeout(function(){
			$('.code',window.opener.document).html($('.code').html().replace(new RegExp(/</g),'&lt;').replace(new RegExp(/>/g),'&gt;').replace(new RegExp(/; /g),';').replace(new RegExp(/: /g),':').replace('width:480px;','width:100%;') + '<br>此代码可嵌入到由<a href="http://www.yvjie.cn/web.php" target="_blank">《昱杰单页制作系统》</a>制作的产品单页中');
			window.close();
		},500);
	});
});