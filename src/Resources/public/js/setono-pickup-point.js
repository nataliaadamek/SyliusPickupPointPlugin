(function ($) {
  $(function () {
    $('input.input-shipping-method').findPickupPoints();
    $('input.input-shipping-method:checked').change();
  });
})(jQuery);

(function ($) {
  'use strict';

  $.fn.extend({
    findPickupPoints: function () {
      return this.each(function () {
        let $element = $(this);
        let $container = $(this).closest('.item');
        let url = $element.data('pickup-point-provider-url');
        let csrfToken = $element.data('csrf-token');

        if (!url) {
          return;
        }

        $element.api({
          method: 'GET',
          on: 'change',
          cache: false,
          url: url,
          beforeSend: function (settings) {
            settings.data = {
              _csrf_token: csrfToken
            };

            removePickupPoints($container);
            $container.addClass('loading');

            return settings;
          },
          onSuccess: function (response) {
            addPickupPoints($container, response);
            $('.ui.radio.checkbox').checkbox('setting', 'onChange', function () {
              let id = ($('.ui.radio.checkbox').checkbox('get value'));
              $(".pickup-point-id").val(id);
            });
          },
          onFailure: function (response) {
            console.log(response);
          },
          onComplete: function () {
            $container.removeClass('loading');
          }
        });
      });
    }
  });

  function removePickupPoints($container) {
    $container.find('.pickup-points').remove();
  }

  function addPickupPoints($container, pickupPoints) {
    if (document.querySelector('.ui.radio.checkbox') == null) {
      let list = '<div class="ui radio checkbox pickup-point-dropdown" style="width:250px">' +
        '<input type="radio" name="pickupPoint">' +
        '<div class="hidden">'
      ;

      pickupPoints.forEach(function (element) {
        list += '<div class="item" data-value="' + element.id + '">';
        list += ' ' + element.name;
        list += ' ' + element.address;
        list += ' ' + element.zipCode;
        list += ' ' + element.country + '</div>'
      });

      list += '</div>' +
        '</div>' +
        '</div>'
      ;

      $container.find('.content').append(list);

      let $checkbox = $('.ui.radio.checkbox');

      $checkbox.checkbox();

      let id = $(".pickup-point-id").val();

      $checkbox.checkbox('set selected', id);
    }
  }
})(jQuery);
