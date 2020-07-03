$(function () {
  type($('input[name=type]:checked').val());
  $('input[name=type]').on('ifChecked', function () {
    type($(this).val());
  });
  function type (val) {
    let $single = $('.single');
    switch (val) {
      case '0':
        $single.hide();
        break;
      case '1':
        $single.show();
        break;
    }
  }

  let $template = $('select[name=template]');
  template($template);
  $template.on('change', function () {
    template($(this));
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

  $('select[name=sort1]').on('change', function () {
    product();
  });
  product();
  function product () {
    $.ajax({
      type: 'POST',
      url: ThinkPHP['AJAX'],
      data: {
        product_sort_id: $('select[name=sort1] option:selected').val()
      },
      success: function (data) {
        let $productPidSelect = $('.product_ids1 select');
        let html = '';
        let $pro = $('input[name=pro]');
        let pro = $pro.length ? $pro.val() : '';
        $productPidSelect.empty();
        $.each($.parseJSON(data), function (index, value) {
          html += '<option value="' + value.id + '"' + ($.inArray(value.id + '', pro.split(',')) !== -1 && $('input[name=product_type]:checked').val() === '0' ? 'selected' : '') + ' style="color:' + value.color + ';">' + value.name + '（' + (value.price + '元') + '）</option>';
        });
        $productPidSelect.append(html);
      }
    });
  }

  let $selected1 = $('select[name=selected1]');
  setTimeout(selected1, 500);
  function selected1 () {
    $selected1.empty();
    let html = '';
    let $pro = $('input[name=pro]');
    let pro = $pro.length ? $pro.val() : '';
    $('.product_ids1 select option').each(function () {
      if ($.inArray($(this).val() + '', pro.split(',')) !== -1 && $('input[name=product_type]:checked').val() === '0') html += '<option value="' + $(this).val() + '" ' + ($(this).val() === $('input[name=product_selected]').val() ? 'selected' : '') + ' style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
    });
    $selected1.append(html);
  }
  $('.product_ids1 select').on('change', function () {
    $selected1.empty();
    $('.product_ids1 select option:selected').each(function () {
      $selected1.append('<option value="' + $(this).val() + '" style="' + $(this).attr('style') + '">' + $(this).text() + '</option>');
    });
  });

  let $selected2 = $('select[name=selected2]');
  setTimeout(selected2, 500);
  function selected2 () {
    $selected2.empty();
    let html = '';
    let productSortId = '';
    $('.product_ids2 select option:selected').each(function () {
      if (!new RegExp('<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">').test(html)) {
        html += '<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">';
        productSortId += $(this).parent().attr('value') + ',';
      }
      html += '<option value="' + $(this).val() + '" ' + ($(this).val() === $('input[name=product_selected]').val() ? 'selected' : '') + ' style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
    });
    $selected2.append(html);
    $('input[name=sort2]').val(productSortId.substring(0, productSortId.length - 1));
  }
  $('.product_ids2 select').on('change', function () {
    $selected2.empty();
    let html = '';
    let productSortId = '';
    $('.product_ids2 select option:selected').each(function () {
      if (!new RegExp('<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">').test(html)) {
        html += '<optgroup label="' + $(this).parent().attr('label') + '" style="' + $(this).parent().attr('style') + '">';
        productSortId += $(this).parent().attr('value') + ',';
      }
      html += '<option value="' + $(this).val() + '" style="' + $(this).attr('style') + '">' + $(this).text() + '</option>';
    });
    $selected2.append(html);
    $('input[name=sort2]').val(productSortId.substring(0, productSortId.length - 1));
  });
});
