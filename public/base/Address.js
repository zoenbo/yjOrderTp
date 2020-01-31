$(function(){
	if ($('select.province').length){
		$.ajax({
			type : 'POST',
			url : DISTRICT,
			data : {
				pid : 0
			},
			success : function(data,textStatus,jqXHR){
				$('input[name="province"],input[name="city"],input[name="county"],input[name="town"]').val('');
				$.each($.parseJSON(data),function(index,value){
					$('select.province').append('<option value="' + value.id + '">' + value.name + '</option>');
				});
			}
		});
	}
	
	$('select.province').change(function(){
		$('select.city').empty().append('<option value="0">城市</option>');
		$('select.county').empty().append('<option value="0">区/县</option>');
		$('select.town').empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');
		$('input[name="province"],input[name="city"],input[name="county"],input[name="town"]').val('');
		if ($(this.options[this.selectedIndex]).val() != '0'){
			$('input[name="province"]').val($(this.options[this.selectedIndex]).text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					pid : $(this.options[this.selectedIndex]).val()
				},
				success : function(data,textStatus,jqXHR){
					$.each($.parseJSON(data),function(index,value){
						$('select.city').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$('select.city').change(function(){
		$('select.county').empty().append('<option value="0">区/县</option>');
		$('select.town').empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');
		$('input[name="city"],input[name="county"],input[name="town"]').val('');
		if ($(this.options[this.selectedIndex]).val() != '0'){
			$('input[name="city"]').val($(this.options[this.selectedIndex]).text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					pid : $(this.options[this.selectedIndex]).val()
				},
				success : function(data,textStatus,jqXHR){
					$.each($.parseJSON(data),function(index,value){
						$('select.county').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$('select.county').change(function(){
		$('select.town').empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');
		$('input[name="county"],input[name="town"]').val('');
		if ($(this.options[this.selectedIndex]).val() != '0'){
			$('input[name="county"]').val($(this.options[this.selectedIndex]).text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					pid : $(this.options[this.selectedIndex]).val()
				},
				success : function(data,textStatus,jqXHR){
					$.each($.parseJSON(data),function(index,value){
						$('select.town').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$('select.town').change(function(){
		$('input[name="town"]').val('');
		if ($(this.options[this.selectedIndex]).val() != '0'){
			$('input[name="town"]').val($(this.options[this.selectedIndex]).text());
		}
	});
});