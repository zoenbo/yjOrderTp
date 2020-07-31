/*
 @Name：layui.form 表单组件
 @Author：贤心
 @License：MIT
*/

layui.define(function (exports) {
  'use strict';

  let $ = layui.$;
  let hint = layui.hint();
  let MOD_NAME = 'form';
  const ELEM = '.layui-form';
  const THIS = 'layui-this';
  const HIDE = 'layui-hide';
  const DISABLED = 'layui-disabled';
  let Form = function () {};

  Form.prototype.on = function (events, callback) {
    return layui.onevent.call(this, MOD_NAME, events, callback);
  };
  Form.prototype.render = function (type, filter) {
    let that = this;
    let elemForm = $(ELEM + (function () { return filter ? ('[lay-filter="' + filter + '"]') : ''; }()));
    let items = {
      select: function () {
        const TIPS = '请选择';
        const CLASS = 'layui-form-select';
        const TITLE = 'layui-select-title';
        const NONE = 'layui-select-none';
        let initValue = '';
        let thatInput;
        let selects = elemForm.find('select');
        let hide = function (e, clear) {
          if (!$(e.target).parent().hasClass(TITLE) || clear) {
            $('.' + CLASS).removeClass(CLASS + 'ed ' + CLASS + 'up');
            thatInput && initValue && thatInput.val(initValue);
          }
          thatInput = null;
        };
        let events = function (reElem, disabled, isSearch) {
          if (disabled) return;

          let select = $(this);
          let title = reElem.find('.' + TITLE);
          let input = title.find('input');
          let dl = reElem.find('dl');
          let dds = dl.children('dd');
          let index = this.selectedIndex;
          let nearElem;
          let showDown = function () {
            let top = reElem.offset().top + reElem.outerHeight() + 5 - $win.scrollTop();
            let dlHeight = dl.outerHeight();
            index = select[0].selectedIndex;
            reElem.addClass(CLASS + 'ed');
            dds.removeClass(HIDE);
            nearElem = null;
            dds.eq(index).addClass(THIS).siblings().removeClass(THIS);
            if (top + dlHeight > $win.height() && top >= dlHeight) {
              reElem.addClass(CLASS + 'up');
            }
            followScroll();
          };
          let hideDown = function (choose) {
            reElem.removeClass(CLASS + 'ed ' + CLASS + 'up');
            input.blur();
            nearElem = null;
            if (choose) return;
            notOption(input.val(), function (none) {
              let selectedIndex = select[0].selectedIndex;
              if (none) {
                initValue = $(select[0].options[selectedIndex]).html();
                if (selectedIndex === 0 && initValue === input.attr('placeholder')) {
                  initValue = '';
                }
                input.val(initValue || '');
              }
            });
          };
          let followScroll = function () {
            let thisDd = dl.children('dd.' + THIS);
            if (!thisDd[0]) return;
            let posTop = thisDd.position().top;
            let dlHeight = dl.height();
            let ddHeight = thisDd.height();
            if (posTop > dlHeight) {
              dl.scrollTop(posTop + dl.scrollTop() - dlHeight + ddHeight - 5);
            } else if (posTop < 0) {
              dl.scrollTop(posTop + dl.scrollTop() - 5);
            }
          };
          title.on('click', function (e) {
            if (reElem.hasClass(CLASS + 'ed')) {
              hideDown();
            } else {
              hide(e, true);
              showDown();
            }
            dl.find('.' + NONE).remove();
          });
          title.find('.layui-edge').on('click', function () {
            input.focus();
          });
          input.on('keyup', function (e) {
            if (e.keyCode === 9) {
              showDown();
            }
          }).on('keydown', function (e) {
            let keyCode = e.keyCode;
            if (keyCode === 9) {
              hideDown();
            }
            let setThisDd = function (prevNext, thisElem1) {
              let nearDd, cacheNearElem;
              e.preventDefault();
              let thisElem = (function () {
                let thisDd = dl.children('dd.' + THIS);
                if (dl.children('dd.' + HIDE)[0] && prevNext === 'next') {
                  let showDd = dl.children('dd:not(.' + HIDE + ',.' + DISABLED + ')');
                  let firstIndex = showDd.eq(0).index();
                  if (firstIndex >= 0 && firstIndex < thisDd.index() && !showDd.hasClass(THIS)) {
                    return showDd.eq(0).prev()[0] ? showDd.eq(0).prev() : dl.children(':last');
                  }
                }
                if (thisElem1 && thisElem1[0]) {
                  return thisElem1;
                }
                if (nearElem && nearElem[0]) {
                  return nearElem;
                }
                return thisDd;
              }());
              cacheNearElem = thisElem[prevNext]();
              nearDd = thisElem[prevNext]('dd:not(.' + HIDE + ')');
              if (!cacheNearElem[0]) {
                return nearElem = null;
              }
              nearElem = thisElem[prevNext]();
              if ((!nearDd[0] || nearDd.hasClass(DISABLED)) && nearElem[0]) {
                return setThisDd(prevNext, nearElem);
              }
              nearDd.addClass(THIS).siblings().removeClass(THIS);
              followScroll();
            };
            if (keyCode === 38) setThisDd('prev');
            if (keyCode === 40) setThisDd('next');
            if (keyCode === 13) {
              e.preventDefault();
              dl.children('dd.' + THIS).trigger('click');
            }
          });
          let notOption = function (value, callback, origin) {
            let num = 0;
            layui.each(dds, function () {
              let othis = $(this);
              let text = othis.text();
              let not = text.indexOf(value) === -1;
              if (value === '' || (origin === 'blur') ? value !== text : not) num++;
              origin === 'keyup' && othis[not ? 'addClass' : 'removeClass'](HIDE);
            });
            return callback(num === dds.length);
          };
          let search = function (e) {
            let value = this.value;
            let keyCode = e.keyCode;
            if (keyCode === 9 || keyCode === 13 || keyCode === 37 || keyCode === 38 || keyCode === 39 || keyCode === 40) {
              return false;
            }
            notOption(value, function (none) {
              if (none) {
                dl.find('.' + NONE)[0] || dl.append('<p class="' + NONE + '">无匹配项</p>');
              } else {
                dl.find('.' + NONE).remove();
              }
            }, 'keyup');
            if (value === '') {
              dl.find('.' + NONE).remove();
            }
            followScroll();
          };
          if (isSearch) {
            input.on('keyup', search).on('blur', function () {
              let selectedIndex = select[0].selectedIndex;
              thatInput = input;
              initValue = $(select[0].options[selectedIndex]).html();
              if (selectedIndex === 0 && initValue === input.attr('placeholder')) {
                initValue = '';
              }
              setTimeout(function () {
                notOption(input.val(), function () {
                  initValue || input.val('');
                }, 'blur');
              }, 200);
            });
          }
          dds.on('click', function () {
            let othis = $(this);
            let value = othis.attr('lay-value');
            let filter = select.attr('lay-filter');
            if (othis.hasClass(DISABLED)) return false;
            if (othis.hasClass('layui-select-tips')) {
              input.val('');
            } else {
              input.val(othis.text());
              othis.addClass(THIS);
            }
            othis.siblings().removeClass(THIS);
            select.val(value).removeClass('layui-form-danger');
            layui.event.call(this, MOD_NAME, 'select(' + filter + ')', {
              elem: select[0],
              value: value,
              othis: reElem
            });
            hideDown(true);
            return false;
          });
          reElem.find('dl>dt').on('click', function () {
            return false;
          });
          $(document).off('click', hide).on('click', hide);
        };
        selects.each(function (index, select) {
          let othis = $(this);
          let hasRender = othis.next('.' + CLASS);
          let disabled = this.disabled;
          let value = select.value;
          let selected = $(select.options[select.selectedIndex]);
          let optionsFirst = select.options[0];

          if (typeof othis.attr('lay-ignore') === 'string') return othis.show();

          let isSearch = typeof othis.attr('lay-search') === 'string';
          let placeholder = optionsFirst ? (optionsFirst.value ? TIPS : (optionsFirst.innerHTML || TIPS)) : TIPS;
          let reElem = $(['<div class="' + (isSearch ? '' : 'layui-unselect ') + CLASS,
            (disabled ? ' layui-select-disabled' : '') + '">',
            '<div class="' + TITLE + '">'
            , ('<input type="text" placeholder="' + placeholder + '" ' +
              ('value="' + (value ? selected.html() : '') + '"') + // 默认值
              ((!disabled && isSearch) ? '' : ' readonly') + // 是否开启搜索
              ' class="layui-input' +
              (isSearch ? '' : ' layui-unselect') +
              (disabled ? (' ' + DISABLED) : '') + '">'), // 禁用状态
            '<i class="layui-edge"></i></div>',
            '<dl class="layui-anim layui-anim-upbit' + (othis.find('optgroup')[0] ? ' layui-select-group' : '') + '">',
            (function (options) {
              let arr = [];
              layui.each(options, function (index, item) {
                let attr = '';
                layui.each(item.attributes, function (index2) {
                  attr += item.attributes[index2].name + '="' + item.attributes[index2].nodeValue + '" ';
                });
                if (index === 0 && !item.value) {
                  // arr.push('<dd lay-value="" class="layui-select-tips">' + (item.innerHTML || TIPS) + '</dd>');
                }
                if (item.tagName.toLowerCase() === 'optgroup') {
                  arr.push('<dt ' + attr + '>' + item.label + '</dt>');
                }
                if (item.tagName.toLowerCase() === 'option') {
                  arr.push('<dd lay-value="' + item.value + '" class="' + (value === item.value ? THIS : '') + (item.disabled ? (' ' + DISABLED) : '') + '" ' + attr + '>' + item.innerHTML + '</dd>');
                }
              });
              arr.length === 0 && arr.push('<dd lay-value="" class="' + DISABLED + '">没有选项</dd>');
              return arr.join('');
            }(othis.find('*'))) + '</dl>',
            '</div>'].join(''));

          hasRender[0] && hasRender.remove(); // 如果已经渲染，则Rerender
          othis.after(reElem);
          events.call(this, reElem, disabled, isSearch);
        });
      }

    };
    type ? (
      items[type] ? items[type]() : hint.error('不支持的' + type + '表单渲染')
    ) : layui.each(items, function (index, item) {
      item();
    });
    return that;
  };

  let form = new Form();
  let $win = $(window);
  form.render();

  exports(MOD_NAME, form);
});
