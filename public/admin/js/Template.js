$(function(){
	type($('input[name=type]:checked').val());
	$('input[name=type]').on('ifChecked',function(){
		type($(this).val());
	});
	function type(val){
		switch (val){
			case '0':
			  $('.single').hide();
			  break;
			case '1':
			  $('.single').show();
			  break;
		}
	}
	
	template($('select[name=template]'));
	$('select[name=template]').change(function(){
		template($(this));
	});
	function template(element){
		if (element.val() == '1'){
			$('.style').hide();
		}else{
			$('.style').show();
		}
		$('.view').html('<a href="' + $($('select[name=template]').get(0).options[$('select[name=template]').get(0).selectedIndex]).attr('view') + '" target="_blank">预览</a>');
	}
	
	$('.all').click(function(){
		$('.field input[type=checkbox]').each(function(){
			$(this).iCheck('check');
		});
	});
	$('.no').click(function(){
		$('.field input[type=checkbox]').each(function(){
			$(this).iCheck('uncheck');
		});
	});
	$('.selected').click(function(){
		$('.field input[type=checkbox]').each(function(){
			$(this).iCheck('uncheck');
		});
		$('.field label.red').each(function(){
			$(this).find('input').iCheck('check');
		});
	});
	
	pro($('input[name=protype]:checked').val());
	$('input[name=protype]').on('ifChecked',function(){
		pro($(this).val());
	});
	function pro(val){
		switch (val){
			case '0':
			  $('.pro1').show();
			  $('.pro2').hide();
			  break;
			case '1':
			  $('.pro1').hide();
			  $('.pro2').show();
			  break;
		}
	}
	
	$('select[name="sort1"]').change(product);
	product();
	function product(){
		$.ajax({
			type : 'POST',
			url : ThinkPHP['AJAX'],
			data : {
				product_sort_id : $($('select[name="sort1"]').get(0).options[$('select[name="sort1"]').get(0).selectedIndex]).val()
			},
			success : function(data,textStatus,jqXHR){
				$('.pid1 select').empty();
				var html = '',pro = $('input[name=pro]').length ? $('input[name=pro]').val() : '';
				$.each($.parseJSON(data),function(index,value){
					html += '<option value="' + value.id + '"' + ($.inArray(value.id+'',pro.split(','))!=-1&&$('input[name=protype]:checked').val()==0 ? 'selected' : '') + ' style="color:' + value.color + ';">' + value.name + '（' + value.price + '元）</option>';
				});
				$('.pid1 select').append(html);
			}
		});
	}
	
	setTimeout(selected1,500);
	function selected1(){
		$('select[name="selected1"]').empty();
		var html = '',pro = $('input[name=pro]').length ? $('input[name=pro]').val() : '';
		$('.pid1 select option').each(function(){
			if ($.inArray($(this).val()+'',pro.split(','))!=-1&&$('input[name=protype]:checked').val()==0) html += '<option value="' + $(this).val() + '" ' + ($(this).val()==$('input[name=proselected]').val() ? 'selected' : '') + ' style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
		});
		$('select[name="selected1"]').append(html);
	}
	$('.pid1 select').change(function(){
		$('select[name="selected1"]').empty();
		var html = '';
		$('.pid1 select option:selected').each(function(){
			html += '<option value="' + $(this).val() + '" style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
		});
		$('select[name="selected1"]').append(html);
	});
	
	setTimeout(selected2,500);
	function selected2(){
		$('select[name="selected2"]').empty();
		var html = product_sort_id = '';
		$('.pid2 select option:selected').each(function(){
			if (!new RegExp('<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">').test(html)){
				html += '<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">';
				product_sort_id += $(this).parent().attr('value') + ',';
			}
			html += '<option value="' + $(this).val() + '" ' + ($(this).val()==$('input[name=proselected]').val() ? 'selected' : '') + ' style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
		});
		$('select[name="selected2"]').append(html);
		$('input[name=sort2]').val(product_sort_id.substring(0,product_sort_id.length-1));
	}
	$('.pid2 select').change(function(){
		$('select[name="selected2"]').empty();
		var html = product_sort_id = '';
		$('.pid2 select option:selected').each(function(){
			if (!new RegExp('<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">').test(html)){
				html += '<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">';
				product_sort_id += $(this).parent().attr('value') + ',';
			}
			html += '<option value="' + $(this).val() + '" style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
		});
		$('select[name="selected2"]').append(html);
		$('input[name=sort2]').val(product_sort_id.substring(0,product_sort_id.length-1));
	});
});