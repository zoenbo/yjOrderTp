$(function(){
	height();
	$(window).resize(height);
	function height(){
		$('.tip').height($(window).height()-100);
	}
});