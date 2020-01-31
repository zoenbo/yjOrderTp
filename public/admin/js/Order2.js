$(function(){
	if ($('input[name=price]').val() == ''){
		$('input[name=price]').val($($('select[name=pid]').get(0).options[$('select[name=pid]').get(0).selectedIndex]).attr('price'));
	}
	$('select[name=pid]').change(function(){
		$('input[name=price]').val($(this.options[this.selectedIndex]).attr('price'));
	});
	
	type($('input[name=type]:checked').val());
	$('input[name=type]').on('ifChecked',function(){
		type($(this).val());
	});
	function type(val){
		switch (val){
			case 'a':
			  $('.aa').show();
			  $('.bb').hide();
			  break;
			case 'b':
			  $('.aa').hide();
			  $('.bb').show();
			  break;
		}
	}
});