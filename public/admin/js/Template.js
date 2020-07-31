$(function () {
  template($('select[name=template]'));
  layui.use(['form'], function () {
    layui.form.on('select(template)', function (data) {
      template($(data.elem));
    });
  });
  function template (element) {
    let $style = $('.style');
    element.val() === '1' ? $style.hide() : $style.show();
    $('.view').html('<a href="' + element.find('option:selected').attr('view') + '" target="_blank">预览</a>');
  }

  $('.all').on('click', function () {
    $('.field input[type=checkbox]').each(function () {
      $(this).iCheck('check');
    });
  });
  $('.no').on('click', function () {
    $('.field input[type=checkbox]').each(function () {
      $(this).iCheck('uncheck');
    });
  });
  $('.selected').on('click', function () {
    $('.field input[type=checkbox]').each(function () {
      $(this).iCheck('uncheck');
    });
    $('.field label.red input[type=checkbox]').each(function () {
      $(this).iCheck('check');
    });
  });

  pro($('input[name=product_type]:checked').val());
  $('input[name=product_type]').on('ifChecked', function () {
    pro($(this).val());
  });
  function pro (val) {
    let $pro1 = $('.pro1');
    let $pro2 = $('.pro2');
    switch (val) {
      case '0':
        $pro1.show();
        $pro2.hide();
        break;
      case '1':
        $pro1.hide();
        $pro2.show();
        break;
    }
  }

  product();
  layui.use(['form'], function () {
    layui.form.on('select(sort1)', function () {
      product();
    });
  });
  let $selected1 = $('select[name=selected1]');
  let productSelect1 = xmSelect.render({
    el: '.product_select1',
    toolbar: {
      show: true
    },
    filterable: true,
    autoRow: true,
    on: function (data) {
      let html = '';
      let productIds = [];
      $.each(data.arr, function (index, value) {
        html += '<option value="' + value.value + '" style="color:' + value.color + ';">' + value.name + '</option>';
        productIds.push(value.value);
      });
      $selected1.html(html);
      layui.use(['form'], function () {
        layui.form.render();
      });
      productIds.sort((num1, num2) => num1 - num2);
      $('input[name=product_ids1]').val(productIds.join(','));
    }
  });
  function product () {
    $.ajax({
      type: 'POST',
      url: ThinkPHP['AJAX'],
      data: {
        product_sort_id: $('select[name=sort1] option:selected').val(),
        product_ids1: $('input[name=product_ids1]').val()
      },
      success: function (data) {
        productSelect1.update({
          data: $.parseJSON(data)
        });
      }
    });
  }
  setTimeout(selected1, 500);
  function selected1 () {
    let html = '';
    $.each(productSelect1.getValue(), function (index, value) {
      if ($.inArray(value.value + '', $('input[name=product_ids1]').val().split(',')) !== -1 && $('input[name=product_type]:checked').val() === '0') html += '<option value="' + value.value + '"' + (value.value + '' === $('input[name=product_selected]').val() ? 'selected' : '') + ' style="color:' + value.color + ';">' + value.name + '</option>';
    });
    $selected1.html(html);
    layui.use(['form'], function () {
      layui.form.render();
    });
  }

  product2();
  let $selected2 = $('select[name=selected2]');
  let productSelect2 = xmSelect.render({
    el: '.product_select2',
    toolbar: {
      show: true
    },
    filterable: true,
    autoRow: true,
    on: function (data) {
      let html = '';
      let productSortId = '';
      let productIds = [];
      $.each(data.arr, function (index, value) {
        if (!new RegExp('<optgroup label="' + value.parent_name + '" style="color:' + value.parent_color + ';">').test(html)) {
          html += '<optgroup label="' + value.parent_name + '" style="color:' + value.parent_color + ';">';
          productSortId += value.parent_value + ',';
        }
        html += '<option value="' + value.value + '" style="color:' + value.color + ';"' + (value.value + '' === $('input[name=product_selected]').val() ? ' selected' : '') + '>' + value.name + '</option>';
        productIds.push(value.value);
      });
      $selected2.html(html);
      layui.use(['form'], function () {
        layui.form.render();
      });
      $('input[name=sort2]').val(productSortId.substring(0, productSortId.length - 1));
      productIds.sort((num1, num2) => num1 - num2);
      $('input[name=product_ids2]').val(productIds.join(','));
    }
  });
  function product2 () {
    $.ajax({
      type: 'POST',
      url: ThinkPHP['AJAX2'],
      data: {
        product_ids2: $('input[name=product_ids2]').val()
      },
      success: function (data) {
        productSelect2.update({
          data: $.parseJSON(data)
        });
      }
    });
  }
  setTimeout(selected2, 1500);
  function selected2 () {
    let html = '';
    let productSortId = '';
    $.each(productSelect2.getValue(), function (index, value) {
      if (!new RegExp('<optgroup label="' + value.parent_name + '" style="color:' + value.parent_color + ';">').test(html)) {
        html += '<optgroup label="' + value.parent_name + '" style="color:' + value.parent_color + ';">';
        productSortId += value.parent_value + ',';
      }
      html += '<option value="' + value.value + '" style="color:' + value.color + ';"' + (value.value + '' === $('input[name=product_selected]').val() ? ' selected' : '') + '>' + value.name + '</option>';
    });
    $selected2.html(html);
    $('input[name=sort2]').val(productSortId.substring(0, productSortId.length - 1));
    layui.use(['form'], function () {
      layui.form.render();
    });
  }
});
