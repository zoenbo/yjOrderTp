$(function(){
	$('form.login input[name=name]').focus();
	
	$('form.login').submit(function(e){
		if ($('input[name=name]').val()=='' || $('input[name=name]').val().length>20){
			alert('管理员帐号不得为空或大于20位！');
			$('input[name=name]').focus();
			e.preventDefault();
			return;
		}
		if ($('input[name=pass]').val() == ''){
			alert('管理员密码不得为空！');
			$('input[name=pass]').focus();
			e.preventDefault();
			return;
		}
		$.ajax({
			type : 'POST',
			url : ThinkPHP['AJAX'],
			async : false,
			data : $('form').serialize(),
			success : function(data,textStatus,jqXHR){
				if (data == 0){
					alert('您的帐号尚未激活，无法登录，请联系超级管理员进行激活！');
					$('input[name=pass]').focus();
					e.preventDefault();
					return;
				}else if (data == 2){
					alert('管理员帐号或密码不正确！');
					$('input[name=pass]').focus();
					e.preventDefault();
					return;
				}
			}
		});
	});
	
	distribution($('input[name=level]:checked').val());
	$('input[name=level]').on('ifChecked',function(){
		distribution($(this).val());
	});
	function distribution(val){
		switch (val){
			case '2':
			  $('.permit').show();
			  $('.distribution').hide();
			  break;
			case '3':
			  $('.permit').hide();
			  $('.distribution').show();
			  break;
		}
	}
});