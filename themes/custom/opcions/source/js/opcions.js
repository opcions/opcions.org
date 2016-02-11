/* global require */
(function ($, Drupal) {
  'use strict';

  require('foundation-sites');

  Drupal.behaviors.opcionsToggle = {
    attach: function (context, settings) {

      $(context).foundation();

      $(context).find('.js-navigation-top-toggle').on('click', function (e) {
        $(this).toggleClass('close');
        e.preventDefault();
      });

      $(context).find("[data-toggler='navigation']").on('on.zf.toggler', function () {
      });

      $(context).find("[data-toggler='navigation']").on('off.zf.toggler', function () {
      });



    }
  };
})(jQuery, Drupal);
