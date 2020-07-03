$(function () {
  let $permitManageCheckbox = $('.permit_manage input[type=checkbox]');
  $('.all').on('click', function () {
    $permitManageCheckbox.each(function () {
      $(this).iCheck('check');
    });
  });
  $('.no').on('click', function () {
    $permitManageCheckbox.each(function () {
      $(this).iCheck('uncheck');
    });
  });
  $('.default').on('click', function () {
    $permitManageCheckbox.each(function () {
      $(this).iCheck('uncheck');
    });
    $('.permit_manage label.red input[type=checkbox]').each(function () {
      $(this).iCheck('check');
    });
  });
});
