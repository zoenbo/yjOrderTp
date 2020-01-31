$(function(){
	$('.list input.all').on('ifChecked',function(){
		$('.list input.files').each(function(){
			$(this).iCheck('check');
		});
	}).on('ifUnchecked',function(){
		$('.list input.files').each(function(){
			$(this).iCheck('uncheck');
		});
	});
	
	$('.list input.files').on('ifChecked',check).on('ifUnchecked',check);
	function check(){
		if ($('.list input.files:checked').length == 0){
			$('.list input.all').iCheck('uncheck');
			$('.list input.all').iCheck('determinate');
		}else if ($('.list input.files:checked').length == $('.list input.files').length){
			$('.list input.all').iCheck('check');
		}else{
			$('.list input.all').iCheck('indeterminate');
		}
	}
});