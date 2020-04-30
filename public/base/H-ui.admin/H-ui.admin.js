/* -----------H-ui前端框架-------------
* H-ui.admin.js v3.1.4
* http://www.h-ui.net/
* Created & Modified by guojunhui
* Date modified 2019.01.21
* Copyright 2013-2019 北京颖杰联创科技有限公司 All rights reserved.
* Licensed under MIT license.
* http://opensource.org/licenses/MIT
*/
let num = 0,
	oUl = $('#min_title_list'),
	hide_nav = $('#Hui-tabNav');

function tabNavallwidth(){
	let taballwidth = 0,
		$tabNav = hide_nav.find('.acrossTab'),
		$tabNavWp = hide_nav.find('.Hui-tabNav-wp'),
		$tabNavitem = hide_nav.find('.acrossTab li'),
		$tabNavmore =hide_nav.find('.Hui-tabNav-more');
	if (!$tabNav[0]) return;
	$tabNavitem.each(function(){
		taballwidth += Number(parseFloat($(this).width() + 60));
	});
	$tabNav.width(taballwidth + 25);
	if (taballwidth + 25 > $tabNavWp.width()){
		$tabNavmore.show()
	}else{
		$tabNavmore.hide();
		$tabNav.css({
			left : 0
		});
	}
}

function Huiasidedisplay(){
	if ($(window).width() >= 768) $('.Hui-aside').show();
}

function getskincookie(){
	$('body').removeClass('blue default orange red yellow green').addClass($.cookie('Huiskin') || ThinkPHP['H-ui-skin']);
}

function Hui_admin_tab(obj){
	let bStop = false,
		bStopIndex = 0,
		href = $(obj).attr('data-href'),
		title = $(obj).attr('data-title'),
		topWindow = $(window.parent.document),
		show_navLi = topWindow.find('#min_title_list li'),
		iframe_box = topWindow.find('#iframe_box');
	if(!href || href===''){
		return;
	}else if(!title){
		alert('v2.5版本之后使用data-title属性');
		return;
	}else if(title === ''){
		alert('data-title属性不能为空');
		return;
	}
	show_navLi.each(function(){
		if($(this).find('span').attr('data-href') === href){
			bStop = true;
			bStopIndex = show_navLi.index($(this));
			return false;
		}
	});
	if (!bStop){
		creatIframe(href,title);
	}else{
		show_navLi.removeClass('active').eq(bStopIndex).addClass('active');			
		iframe_box.find('.show_iframe').hide().eq(bStopIndex).show().find('iframe').attr('src',href);
	}	
}

function creatIframe(href,titleName){
	let topWindow = $(window.parent.document),
		show_nav = topWindow.find('#min_title_list'),
		iframe_box = topWindow.find('#iframe_box'),
		iframeBox = iframe_box.find('.show_iframe'),
		$tabNav = topWindow.find('.acrossTab'),
		$tabNavWp = topWindow.find('.Hui-tabNav-wp'),
		$tabNavmore = topWindow.find('.Hui-tabNav-more'),
		taballwidth = 0;

	show_nav.find('li').removeClass('active');
	show_nav.append('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');

	if (!$tabNav[0]) return;

	let $tabNavitem = topWindow.find('.acrossTab li');
	$tabNavitem.each(function(){
		taballwidth += Number(parseFloat($(this).width() +60));
	});
	$tabNav.width(taballwidth + 25);
	if (taballwidth+25 > $tabNavWp.width()){
		$tabNavmore.show();
	}else{
		$tabNavmore.hide();
		$tabNav.css({
			left : 0
		});
	}
	iframeBox.hide();
	iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe data-scrollTop="0" frameborder="0" src='+href+'></iframe></div>');
	let showBox=iframe_box.find('.show_iframe:visible');
	showBox.find('iframe').on('load',function(){
		showBox.find('.loading').hide();
	});
}

function toNavPos(){
	oUl.stop().animate({left : -num * 100},100);
}

$(function(){
	getskincookie();
	Huiasidedisplay();

	let resizeID;
	$(window).on('resize',function(){
		clearTimeout(resizeID);
		resizeID = setTimeout(function(){
			Huiasidedisplay();
		},500);
	});
	let $HuiAside = $('.Hui-aside');
	$('.nav-toggle').on('click',function(){
		$HuiAside.slideToggle();
	});
	$HuiAside.on('click','.menu_dropdown dd li a',function(){
		if ($(window).width() < 768) $HuiAside.slideToggle();
	});
	$HuiAside.Huifold({
		titCell : '.menu_dropdown dl dt',
		mainCell : '.menu_dropdown dl dd',
	});
	$HuiAside.on('click','.menu_dropdown a',function(){
		Hui_admin_tab(this);
		$HuiAside.find('.menu_dropdown dl dd ul li').removeClass('current');
		$(this).parent().addClass('current');
	});
	$(document).on('click','#min_title_list li',function(e){
		e.preventDefault();

		let bStopIndex = $(this).index();
		$('#min_title_list li').removeClass('active').eq(bStopIndex).addClass('active');
		$('#iframe_box').find('.show_iframe').hide().eq(bStopIndex).show();

		$HuiAside.find('.menu_dropdown dl dd ul li').removeClass('current');
		$HuiAside.find('.menu_dropdown dl dd ul li a[data-href="' + $(this).find('span').attr('data-href') + '"]').parent().addClass('current');
	});
	$(document).on('click','#min_title_list li i',function(){
		/*$('.menu_dropdown dl dd ul li').eq(0).removeAttr('class');
		alert($HuiAside.find('.menu_dropdown dl dd ul li').eq(0).html());
		$HuiAside.find('.menu_dropdown dl dd ul li a[data-href="' + $('#min_title_list li.current').attr('data-href') + '"]').addClass('current');*/

		let aCloseIndex = $(this).parents('li').index();
		$(this).parent().remove();
		$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
		num===0 ? num=0 : num--;
		tabNavallwidth();
	});
	$(document).on('dblclick','#min_title_list li',function(){
		let aCloseIndex = $(this).index();
		if(aCloseIndex > 0){
			let iframe_box = $('#iframe_box');
			$(this).remove();
			iframe_box.find('.show_iframe').eq(aCloseIndex).remove();
			num===0 ? num=0 : num--;
			$('#min_title_list li').removeClass('active').eq(aCloseIndex-1).addClass('active');
			iframe_box.find('.show_iframe').hide().eq(aCloseIndex-1).show();
			tabNavallwidth();
		}else{
			return false;
		}
	});
	tabNavallwidth();
	
	$('#js-tabNav-next').on('click',function(){
		num===oUl.find('li').length-1 ? num=oUl.find('li').length-1 : num++;
		toNavPos();
	});
	$('#js-tabNav-prev').on('click',function(){
		num===0 ? num=0 : num--;
		toNavPos();
	});

	$('#Hui-skin .dropDown-menu a').on('click',function(){
		let v = $(this).attr('data-val');
		$.cookie('Huiskin',v);
		$('body').removeClass('blue default orange red yellow green').addClass(v);
	});
});

function addTab(href,titleName){
	if (titleName){
		let bStop = false,
			bStopIndex = 0,
			topWindow = $(window.parent.document),
			show_navLi = topWindow.find('#min_title_list li');

		show_navLi.each(function(){
			if ($(this).find('span').text() === titleName){
				bStop = true;
				bStopIndex = show_navLi.index($(this));
				return false;
			}
		});
		if (!bStop){
			creatIframe(href,titleName);
		}else{
			show_navLi.removeClass('active').eq(bStopIndex).addClass('active');
			topWindow.find('#iframe_box').find('.show_iframe').hide().eq(bStopIndex).show().find('iframe').attr('src',href);
		}

		let $HuiAside = $('.Hui-aside');
		$HuiAside.find('.menu_dropdown dl dd ul li').removeClass('current');
		$HuiAside.find('.menu_dropdown dl dd ul li a[data-href="' + href + '"]').parent().addClass('current');
	}
}