$(function () {
  $('.tools .multi').on('click', function () {
    switch ($('.tools input[name=type]:checked').val()) {
      case '2':
        return confirm('确定将所选的订单移入到回收站么？');
      case '3':
        return confirm('确定将所选的订单还原到订单管理模块么？');
      case '4':
        return confirm('【注意】订单回收站中的订单一旦批量删除，无法恢复，您确定进行此操作？');
    }
  });

  let $all = $('.list input.all');
  let $id = $('.list input[name=id]');
  $all.on('ifChecked', function () {
    $('.list input[name=id]').each(function () {
      $(this).iCheck('check');
    });
    checked();
  }).on('ifUnchecked', function () {
    $id.each(function () {
      $(this).iCheck('uncheck');
    });
    checked();
  });
  $id.on('ifChecked', function () {
    check();
    checked();
  }).on('ifUnchecked', function () {
    check();
    checked();
  });
  function check () {
    let $idChecked = $('.list input[name=id]:checked');
    if ($idChecked.length === 0) {
      $all.iCheck('uncheck');
      $all.iCheck('determinate');
    } else if ($idChecked.length === $id.length) {
      $all.iCheck('check');
    } else {
      $all.iCheck('indeterminate');
    }
  }
  function checked () {
    let ids = '';
    $('.list input[name=id]:checked').each(function () {
      ids += $(this).val() + ',';
    });
    $('.tools input[name=ids]').val(ids.substring(0, ids.length - 1));
  }

  $('.tools input.number').numberspinner({
    width: 80,
    height: 30,
    min: 0
  });

  $('.tools input.date').datebox({
    width: 115,
    height: 30,
    editable: false
  });

  pay($('.tools select[name=pay] option:selected').val());
  $('.tools select[name=pay]').on('click', function () {
    pay($(this).val());
  });
  function pay (val) {
    let $alipayScene = $('.tools .alipay_scene');
    let $wxpayScene = $('.tools .wxpay_scene');
    switch (val) {
      case '3':
        $alipayScene.show();
        $wxpayScene.hide();
        break;
      case '7':
        $alipayScene.hide();
        $wxpayScene.show();
        break;
      default:
        $alipayScene.hide();
        $wxpayScene.hide();
    }
  }
});
