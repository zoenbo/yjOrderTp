$(function(){
	$('.header li').click(function(){
		$('.header li').removeClass('current');
		$(this).addClass('current');
		$('.form .column').hide();
		$('.form .column').eq($(this).index()).show();
		
		if ($(this).index() == 1){
			uploader.refresh();
		}else if ($(this).index() == $('.header li').length-1){
			uploader2.refresh();
		}
	});
	
	var uploader = WebUploader.create({
		auto : true,
		server : ThinkPHP['UPLOAD'],
		pick : {
			id : '.loginbg_picker',
			label : '上传背景图',
			multiple : false
		},
		fileVal : 'Filedata',
		fileSingleSizeLimit : 10240000,
		accept : {
			extensions : 'jpg',
			mimeTypes : '.jpg'
		},
		compress : false,
		resize : false,
		duplicate : true
	});
	uploader.on('uploadSuccess',function(file,response){
		$('.loginbg').html('上传成功');
	});
	uploader.on('error',function(code,maxSize,file){
		uploadValidate(code,maxSize,file);
	});
	
	var uploader2 = WebUploader.create({
		auto : true,
		server : ThinkPHP['UPLOAD2'],
		pick : {
			id : '.qqwry_picker',
			label : '更新IP数据库',
			multiple : false
		},
		fileVal : 'Filedata',
		fileSingleSizeLimit : 20480000,
		accept : {
			extensions : 'dat',
			mimeTypes : '.dat'
		},
		compress : false,
		resize : false,
		duplicate : true
	});
	uploader2.on('uploadSuccess',function(file,response){
		$('.qqwry').html('更新成功，当前IP数据库更新日期为：' + response._raw);
	});
	uploader2.on('error',function(code,maxSize,file){
		uploadValidate(code,maxSize,file);
	});
});