$(function(){
	permit($('input[name=level]:checked').val());
	$('input[name=level]').on('ifChecked',function(){
		permit($(this).val());
	});
	function permit(val){
		switch (val){
			case '1':
			  $('.permit').hide();
			  break;
			case '2':
			  $('.permit').show();
			  break;
		}
	}
	
	$('input.date').datebox({
		width : 115,
		height : 30,
		editable : false
	});
});