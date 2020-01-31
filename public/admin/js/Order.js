$(function(){
	$('.tools .multi').click(function(){
		switch ($('.tools input[name=type]:checked').val()){
			case '2':
			  return confirm('确定将所选的订单移入到回收站么？');
			  break;
			case '3':
			  return confirm('确定将所选的订单还原到订单管理模块么？');
			  break;
			case '4':
			  return confirm('【注意】订单回收站中的订单一旦批量删除，无法恢复，您确定进行此操作？');
			  break;
		}
	});
	
	$('.list input.all').on('ifChecked',function(){
		$('.list input[name=id]').each(function(){
			$(this).iCheck('check');
		});
		checked();
	}).on('ifUnchecked',function(){
		$('.list input[name=id]').each(function(){
			$(this).iCheck('uncheck');
		});
		checked();
	});
	$('.list input[name=id]').on('ifChecked',function(){
		check();
		checked();
	}).on('ifUnchecked',function(){
		check();
		checked();
	});
	function check(){
		if ($('.list input[name=id]:checked').length == 0){
			$('.list input.all').iCheck('uncheck');
			$('.list input.all').iCheck('determinate');
		}else if ($('.list input[name=id]:checked').length == $('.list input[name=id]').length){
			$('.list input.all').iCheck('check');
		}else{
			$('.list input.all').iCheck('indeterminate');
		}
	}
	function checked(){
		var ids = '';
		$('.list input[name=id]:checked').each(function(){
			ids += $(this).val() + ',';
		});
		$('.tools input[name=ids]').val(ids.substring(0,ids.length-1));
	}
	
	$('.tools input.number').numberspinner({
		width : 80,
		height : 30,
		min : 0
	});
	
	$('.tools input.date').datebox({
		width : 115,
		height : 30,
		editable : false
	});
	
	pay($('.tools select[name=pay] option:selected').val());
	$('.tools select[name=pay]').click(function(){
		pay($(this).val());
	});
	function pay(val){
		if (val == '3'){
			$('.tools .alipay_scene').show();
			$('.tools .wxpay_scene').hide();
		}else if (val == '7'){
			$('.tools .alipay_scene').hide();
			$('.tools .wxpay_scene').show();
		}else{
			$('.tools .alipay_scene').hide();
			$('.tools .wxpay_scene').hide();
		}
	}
});