$(function () {
  let $price = $('input[name=price]');
  let $productId = $('select[name=product_id]');
  if ($price.val() === '') {
    $price.val($productId.find('option:selected').attr('price'));
  }
  layui.use(['form'], function () {
    layui.form.on('select(product_id)', function (data) {
      $price.val($(data.elem).find('option:selected').attr('price'));
    });
  });

  type($('input[name=type]:checked').val());
  $('input[name=type]').on('ifChecked', function () {
    type($(this).val());
  });
  function type (val) {
    let $aa = $('.aa');
    let $bb = $('.bb');
    switch (val) {
      case 'a':
        $aa.show();
        $bb.hide();
        break;
      case 'b':
        $aa.hide();
        $bb.show();
        break;
    }
  }
});
