$(function () {
  let $list = $('div.list');
  if ($list.length) {
    let width = 0;
    $.each($('div.list th'), function () {
      if (typeof ($(this).attr('class')) !== 'undefined') width += $(this).width() + 1;
    });
    $list.width(width + 31);
  }

  $('.check-box input,.radio-box input').iCheck({
    checkboxClass: 'icheckbox-blue',
    radioClass: 'iradio-blue'
  });

  $('.input-text,.textarea').Huifocusblur();

  layui.use(['form'], function () {
    layui.form.on('select(page)', function (data) {
      if (location.href !== data.value) location.href = data.value;
    });
  });
});
