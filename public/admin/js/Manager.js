$(function(){
	permit($('input[name=level]:checked').val());
	$('input[name=level]').on('ifChecked',function(){
		permit($(this).val());
	});
	function permit(val){
		let $permit = $('.permit');
		switch (val){
			case '1':
				$permit.hide();
				break;
			case '2':
				$permit.show();
				break;
		}
	}

	let $date = $('input.date');
	if ($date.length) $date.datebox({
		width : 115,
		height : 30,
		editable : false
	});
});