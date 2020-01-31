$(function(){
	if ($('div.list').length){
		var width = 0;
		$.each($('div.list th'),function(index,value){
			if (typeof($(this).attr('class')) != 'undefined') width += $(this).width() + 1;
		});
		$('div.list').width(width + 31);
	}
	
	$('.check-box input,.radio-box input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
	});
});