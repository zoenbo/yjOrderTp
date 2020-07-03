$(function () {
  let $headerLi = $('.header li');
  $headerLi.on('click', function () {
    $headerLi.removeClass('current');
    $(this).addClass('current');
    let $column = $('.form .column');
    $column.hide();
    $column.eq($(this).index()).show();

    if ($(this).index() === 1) {
      uploader.refresh();
    } else if ($(this).index() === $('.header li').length - 1) {
      uploader2.refresh();
    }
  });

  let uploader = WebUploader.create({
    auto: true,
    server: ThinkPHP['UPLOAD'],
    pick: {
      id: '.loginbg_picker',
      label: '上传背景图',
      multiple: false
    },
    fileSingleSizeLimit: 10240000,
    accept: {
      extensions: 'jpg',
      mimeTypes: '.jpg'
    },
    compress: false,
    resize: false,
    duplicate: true
  });
  uploader.on('uploadSuccess', function () {
    $('.loginbg').html('上传成功');
  });
  uploader.on('error', uploadValidate);

  let uploader2 = WebUploader.create({
    auto: true,
    server: ThinkPHP['UPLOAD2'],
    pick: {
      id: '.qqwry_picker',
      label: '更新IP数据库',
      multiple: false
    },
    fileSingleSizeLimit: 20480000,
    accept: {
      extensions: 'dat',
      mimeTypes: '.dat'
    },
    compress: false,
    resize: false,
    duplicate: true
  });
  uploader2.on('uploadSuccess', function (file, response) {
    $('.qqwry').html('更新成功，当前IP数据库更新日期为：' + response._raw);
  });
  uploader2.on('error', uploadValidate);
});
