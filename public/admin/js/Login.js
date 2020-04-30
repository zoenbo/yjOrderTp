$(function(){
	let $name = $('form.login input[name=name]'),
		$pass = $('form.login input[name=pass]');

	$name.focus();

	$('form.login').on('submit',function(e){
		if ($name.val()==='' || $name.val().length>20){
			alert('管理员帐号不得为空或大于20位！');
			$name.focus();
			e.preventDefault();
			return;
		}
		if ($pass.val() === ''){
			alert('管理员密码不得为空！');
			$pass.focus();
			e.preventDefault();
			return;
		}
		$.ajax({
			type : 'POST',
			url : ThinkPHP['AJAX'],
			async : false,
			data : $('form').serialize(),
			success : function(data){
				if (data === '0'){
					alert('您的帐号尚未激活，无法登录，请联系超级管理员进行激活！');
					$pass.focus();
					e.preventDefault();
				}else if (data === '2'){
					alert('管理员帐号或密码不正确！');
					$pass.focus();
					e.preventDefault();
				}
			}
		});
	});
});