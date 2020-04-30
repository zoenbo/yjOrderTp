$(function(){
	let $all = $('.list input.all'),
		$files = $('.list input.files');

	$all.on('ifChecked',function(){
		$files.each(function(){
			$(this).iCheck('check');
		});
	}).on('ifUnchecked',function(){
		$files.each(function(){
			$(this).iCheck('uncheck');
		});
	});

	$files.on('ifChecked',function(){
		check();
	}).on('ifUnchecked',function(){
		check();
	});
	function check(){
		let $filesChecked = $('.list input.files:checked');
		if ($filesChecked.length === 0){
			$all.iCheck('uncheck');
			$all.iCheck('determinate');
		}else if ($filesChecked.length === $files.length){
			$all.iCheck('check');
		}else{
			$all.iCheck('indeterminate');
		}
	}
});