$(function () {
  let $provinceSelect = $('select.province');
  let $citySelect = $('select.city');
  let $countySelect = $('select.county');
  let $townSelect = $('select.town');
  let $province = $('input[name=province]');
  let $city = $('input[name=city]');
  let $county = $('input[name=county]');
  let $town = $('input[name=town]');

  if ($provinceSelect.length) {
    $.ajax({
      type: 'POST',
      url: DISTRICT,
      data: {
        parent_id: 0
      },
      success: function (data) {
        $province.val('');
        $city.val('');
        $county.val('');
        $town.val('');
        $.each($.parseJSON(data), function (index, value) {
          $provinceSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
        });
        layui.form.render();
      }
    });
  }

  layui.use(['form'], function () {
    layui.form.on('select(province)', function (data) {
      $citySelect.empty().append('<option value="0">城市</option>');
      $countySelect.empty().append('<option value="0">区/县</option>');
      $townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

      $province.val('');
      $city.val('');
      $county.val('');
      $town.val('');

      if (data.value !== '0') {
        $province.val(data.elem[data.value].innerText);
        $.ajax({
          type: 'POST',
          url: DISTRICT,
          data: {
            parent_id: data.value
          },
          success: function (data) {
            $.each($.parseJSON(data), function (index, value) {
              $citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            layui.form.render();
          }
        });
      }
    });

    layui.form.on('select(city)', function (data) {
      $countySelect.empty().append('<option value="0">区/县</option>');
      $townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

      $city.val('');
      $county.val('');
      $town.val('');

      if (data.value !== '0') {
        $city.val(data.elem[data.elem.selectedIndex].text);
        $.ajax({
          type: 'POST',
          url: DISTRICT,
          data: {
            parent_id: data.value
          },
          success: function (data) {
            $.each($.parseJSON(data), function (index, value) {
              $('select.county').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            layui.form.render();
          }
        });
      }
    });

    layui.form.on('select(county)', function (data) {
      $townSelect.empty().append('<option value="0">乡镇/街道（若不清楚，可不选）</option>');

      $county.val('');
      $town.val('');

      if (data.value !== '0') {
        $county.val(data.elem[data.elem.selectedIndex].text);
        $.ajax({
          type: 'POST',
          url: DISTRICT,
          data: {
            parent_id: data.value
          },
          success: function (data) {
            $.each($.parseJSON(data), function (index, value) {
              $('select.town').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            layui.form.render();
          }
        });
      }
    });

    layui.form.on('select(town)', function (data) {
      $town.val('');
      if (data.value !== '0') $town.val(data.elem[data.elem.selectedIndex].text);
    });
  });
});
