(function($) {

  "use strict";

  Drupal.behaviors.opcionsSubscription ={
    attach: function (context, settings) {
      var radios = $(context).find('input[name="price"]');

      radios.each(function () {
        if($(this).prop('checked')) {
          $(this).parent().addClass('selected');
        }
        else {
          $(this).parent().removeClass('selected');
        }
      });

      radios.on('change', function (e) {
        if($(this).val() < 54) {
          $('.paper-info').css('display', 'inline');
        }
        else {
          $('.paper-info').css('display', 'none');
        }
        $(this).parent().siblings('.selected').removeClass('selected')
        $(this).parent().addClass('selected');
      });
    }
  };

})(jQuery);