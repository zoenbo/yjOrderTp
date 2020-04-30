$(function(){
	let $provinceSelect = $('select.province'),
		$citySelect = $('select.city'),
		$countySelect = $('select.county'),
		$townSelect = $('select.town'),
		$province = $('input[name=province]'),
		$city = $('input[name=city]'),
		$county = $('input[name=county]'),
		$town = $('input[name=town]');

	if ($provinceSelect.length){
		$.ajax({
			type : 'POST',
			url : DISTRICT,
			data : {
				parent_id : 0
			},
			success : function(data){
				$province.val('');
				$city.val('');
				$county.val('');
				$town.val('');
				$.each($.parseJSON(data),function(index,value){
					$provinceSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
				});
			}
		});
	}
	
	$provinceSelect.on('change',function(){
		$citySelect.empty().append('<option value="0">城市</option>');
		$countySelect.empty().append('<option value="0">区/县</option>');
		$townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

		$province.val('');
		$city.val('');
		$county.val('');
		$town.val('');

		let $selected = $(this).find('option:selected');
		if ($selected.val() !== '0'){
			$province.val($selected.text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					parent_id : $selected.val()
				},
				success : function(data){
					$.each($.parseJSON(data),function(index,value){
						$citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$citySelect.on('change',function(){
		$countySelect.empty().append('<option value="0">区/县</option>');
		$townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

		$city.val('');
		$county.val('');
		$town.val('');

		let $selected = $(this).find('option:selected');
		if ($selected.val() !== '0'){
			$city.val($selected.text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					parent_id : $selected.val()
				},
				success : function(data){
					$.each($.parseJSON(data),function(index,value){
						$('select.county').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$countySelect.on('change',function(){
		$townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

		$county.val('');
		$town.val('');

		let $selected = $(this).find('option:selected');
		if ($selected.val() !== '0'){
			$county.val($selected.text());
			$.ajax({
				type : 'POST',
				url : DISTRICT,
				data : {
					parent_id : $selected.val()
				},
				success : function(data){
					$.each($.parseJSON(data),function(index,value){
						$('select.town').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		}
	});
	
	$townSelect.on('change',function(){
		$town.val('');
		let $selected = $(this).find('option:selected');
		if ($selected.val() !== '0') $town.val($selected.text());
	});
});