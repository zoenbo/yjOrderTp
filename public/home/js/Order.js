$(function(){
	if (!$.cookie('referrer')) $.cookie('referrer',window.document.referrer || window.parent.document.referrer,{path:'/'});
	if ($('input[name=referrer]').val() == '') $('input[name=referrer]').val($.cookie('referrer'));
	
	type($('input[name=type]:checked').val());
	$('input[name=type]').click(function(){
		type($(this).val());
	});
	function type(val){
		switch (val){
			case 'a':
			  $('#aa').show();
			  $('#bb').hide();
			  break;
			case 'b':
			  $('#aa').hide();
			  $('#bb').show();
			  break;
		}
	}
	
	var a = $('form.form').Validform({
		tiptype : function(msg,o,cssctl){
			var objtip = $('.info1');
			cssctl(objtip,o.type);
			objtip.text(msg);
		},
		showAllError : false,
		dragonfly : true,
		ignoreHidden : true,
		datatype : {
			'province' : function(gets){
				return $('input[name=type]:checked').val()=='a' && gets!='0';
			},
			'county' : function(gets){
				return $('input[name=type]:checked').val()=='a' && gets!='0';
			},
			'city' : function(gets){
				return $('input[name=type]:checked').val()=='a' && gets!='0';
			},
			/*'town' : function(gets){
				return $('input[name=type]:checked').val()=='a' && gets!='0';
			},*/
			'province2' : function(gets){
				return $('input[name=type]:checked').val()=='b' && !(gets.length<2 || gets.length>10);
			},
			'county2' : function(gets){
				return $('input[name=type]:checked').val()=='b' && !(gets.length<2 || gets.length>15);
			},
			'city2' : function(gets){
				return $('input[name=type]:checked').val()=='b' && !(gets.length<2 || gets.length>15);
			},
			'town2' : function(gets){
				return $('input[name=type]:checked').val()=='b' && gets.length<=25;
			},
			'post' : function(gets){
				return gets!=''&&!/^[\d]{6}$/.test(gets) ? false : true;
			},
			'note' : function(gets){
				return gets.length <= 250;
			},
			'email' : function(gets){
				return gets!=''&&!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(gets) ? false : true;
			}
		}
	}).addRule([{
		ele : 'input[name=count]',
		datatype : /^[\d]+$/,
		nullmsg : '请填写订购数量！',
		errormsg : '订购数量必须是数字！'
	},{
		ele : 'input[name=name]',
		datatype : /^[\w\W]{2,20}$/,
		nullmsg : '请填写姓名！',
		errormsg : '姓名不得小于2位或大于20位！'
	},{
		ele : 'input[name=tel]',
		datatype : /^[\d\-]{7,20}$/,
		nullmsg : '请填写联系电话！',
		errormsg : '联系电话必须是数字和-号，且不得小于7位或大于20位！'
	},{
		ele : 'select.province',
		datatype : 'province',
		errormsg : '请选择省份！'
	},{
		ele : 'select.city',
		datatype : 'city',
		errormsg : '请选择城市！'
	},{
		ele : 'select.county',
		datatype : 'county',
		errormsg : '请选择区/县！'
	}/*,{
		ele : 'select.town',
		datatype : 'town',
		errormsg : '请选择乡镇/街道！'
	}*/,{
		ele : 'input[name=province2]',
		datatype : 'province2',
		nullmsg : '请填写省份！',
		errormsg : '省份不得小于2位或大于10位！'
	},{
		ele : 'input[name=city2]',
		datatype : 'city2',
		nullmsg : '请填写城市！',
		errormsg : '城市不得小于2位或大于15位！'
	},{
		ele : 'input[name=county2]',
		datatype : 'county2',
		nullmsg : '请填写区/县！',
		errormsg : '区/县不得小于2位或大于15位！'
	},{
		ele : 'input[name=town2]',
		datatype : 'town2',
		errormsg : '乡镇/街道不得大于25位！'
	},{
		ele : 'input[name=address]',
		datatype : /^[\w\W]{5,200}$/,
		nullmsg : '请填写详细地址！',
		errormsg : '详细地址不得小于5位或大于200位！'
	},{
		ele : 'input[name=post]',
		datatype : 'post',
		errormsg : '邮政编码必须是6位的数字！'
	},{
		ele : 'input[name=note]',
		datatype : 'note',
		errormsg : '备注不得大于250位！'
	},{
		ele : 'input[name=email]',
		datatype : 'email',
		errormsg : '电子邮箱格式不合法！'
	},{
		ele : 'input[name=verify]',
		datatype : '*',
		nullmsg : '请填写验证码！'
	}]);
	
	$('.search').Validform({
		tiptype : function(msg,o,cssctl){
			var objtip = $('.info3');
			cssctl(objtip,o.type);
			objtip.text(msg);
		},
		showAllError : false,
		dragonfly : true
	}).addRule([{
		ele : 'input[name=keyword]',
		datatype : '*',
		nullmsg : '请填写查询关键词！'
	}]);
	
	function getDateStr(addDayCount){
		var day = new Date();
		day.setDate(day.getDate() + addDayCount);
		return day.getFullYear() + '-' + (day.getMonth()+1) + '-' + day.getDate();
	}
	
	function getList(){
		var str = '';
		var pro = new Object();
		if ($('.pro select option').length){
			pro = $('.pro select option');
		}else{
			pro = $('.pro label');
		}
		for (var i=0;i<22;i++){
			var addressRand = Math.floor(Math.random()*22+1)-1,
				 address = ['北京','上海','天津','湖南','湖北','湖北','广东','广西','重庆','四川','山东','河南','河北','山西','贵州','黑龙江','福建','浙江','江苏','江西','海南','陕西'],
				 nameRand = Math.floor(Math.random()*22+1)-1,
				 name = ['张女士','刘先生','周女士','朱先生','陈女士','田先生','钟女士','马先生','韩女士','吴先生','顾女士','王先生','李女士','卢先生','崔女士','段先生','胡女士','陈先生','林女士','代先生','潘女士','苏先生'],
				 telRand = Math.floor(Math.random()*4+1)-1,
				 tel = ['13'+Math.floor(Math.random()*10)+ '****'+ Math.floor(Math.random()*10)+ Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+'' ,'15'+Math.floor(Math.random()*10)+ '****'+ Math.floor(Math.random()*10)+ Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+'' ,'13'+Math.floor(Math.random()*10)+ '****'+ Math.floor(Math.random()*10)+ Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+'' ,'18'+Math.floor(Math.random()*10)+ '****'+ Math.floor(Math.random()*10)+ Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+'' ,'13'+Math.floor(Math.random()*10)+ '****'+ Math.floor(Math.random()*10)+ Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+Math.floor(Math.random()*10)+''],
				 logisticsRand = Math.floor(Math.random()*4+1)-1,
				 logistics = ['邮政EMS','顺丰速递','申通快递','中通速递'];
			var productRand = Math.floor(Math.random()*pro.length+1)-1;
			str += '<dl><dt>' + getDateStr(-1) + ' ' + address[addressRand] + '的' + name[nameRand] + '（' + tel[telRand] + '）</dt><dd>您订购的 ' + pro.eq(productRand).text().replace(/（[\d\.]+元）/,'').replace(/（[\d\.]+元～[\d\.]+元）/,'').replace(/└—/,'') + ' [' + logistics[logisticsRand] + '] 已发货，请注意查收</dd></dl>';
		}
		return str;
	}
	
	if ($('.list').length && $('.list1').length && $('.list2').length){
		$('.list1').html(getList());
		var speed = 80,list = $('.list'),list1 = $('.list1'),list2 = $('.list2');
		list.css('height',$('.left').height() - 100);
		list2.html(list1.html());
		function marquee(){
			if (list2.get(0).offsetHeight - list.get(0).scrollTop <= 0){
				list.get(0).scrollTop -= list1.get(0).offsetHeight;
			}else{
				list.get(0).scrollTop++;
			}
		}
		var mar = setInterval(marquee,speed);
		list.mouseover(function(){
			clearInterval(mar);
		}).mouseout(function(){
			mar = setInterval(marquee,speed);
		});
	}
	
	if ($('.new').length){
		var marquee = ['张**（130****3260）在1','李**（136****7163）在3','赵**（139****1955）在5','刘**（180****6999）在2','张**（151****2588）在4','王**（133****4096）在6'],marquee1 = 0,marquee2 = 1,marquee3 = 2,pro = new Object();
		if ($('.pro select option').length){
			pro = $('.pro select option');
		}else{
			pro = $('.pro label');
		}
		function newList(){
			if (marquee1 > marquee.length - 1) marquee1 = 0;
			if (marquee2 > marquee.length - 1) marquee1 = 0;
			if (marquee3 > marquee.length - 1) marquee1 = 0;
			marquee2 = marquee1 + 1;
			marquee3 = marquee2 + 1;
			var str = '<p>[最新购买]：' + marquee[marquee1] + '分钟前订购了【' + pro.eq(Math.floor(Math.random()*pro.length+1)-1).text().replace(/（[\d\.]+元）/,'').replace(/（[\d\.]+元～[\d\.]+元）/,'').replace(/└—/,'') + '】</p>' + '<p>[最新购买]：' + marquee[marquee2] + '分钟前订购了【' + pro.eq(Math.floor(Math.random()*pro.length+1)-1).text().replace(/（[\d\.]+元）/,'').replace(/（[\d\.]+元～[\d\.]+元）/,'').replace(/└—/,'') + '】</p>' + '<p>[最新购买]：' + marquee[marquee3] + '分钟前订购了【' + pro.eq(Math.floor(Math.random()*pro.length+1)-1).text().replace(/（[\d\.]+元）/,'').replace(/（[\d\.]+元～[\d\.]+元）/,'').replace(/└—/,'') + '】</p>';
			$('.new').html(str);
			window.parent.$('.new').html(str);
			marquee1++;
			marquee2++;
			marquee3++;
		}
		newList();
		setInterval(newList,2000);
	}
	
	total();
	$('input[name=count]').keyup(total).blur(total);
	$('.pro label input').click(total);
	$('.pro select').change(total);
	function total(){
		var pro = new Object();
		if ($('.pro select option').length){
			pro = $('.pro select option:selected');
		}else{
			pro = $('.pro label input:checked');
		}
		$('.total').html('<span class="price">' + (pro.attr('price') * $('input[name=count]').val()) + '元</span>');
	}
});