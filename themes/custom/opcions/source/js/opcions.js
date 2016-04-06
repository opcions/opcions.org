/* global require */
(function ($, Drupal) {
  'use strict';

  require('foundation-sites');
  require('velocity-animate');
  require('velocity-animate/velocity.ui');

  Drupal.behaviors.opcionsToggle = {
    attach: function (context, settings) {

      $(context).find('.js-navigation-top-toggle').on('click', function (e) {
        e.preventDefault();

        if ($(this).hasClass('close')) {
          $('.js-navitation-main').velocity('slideUp');
        }
        else {
          $('.js-navitation-main').velocity('slideDown');
        }
        $(this).toggleClass('close');
      });

    }
  };
  Drupal.behaviors.opcionsFoudation = {
    attach: function (context, settings) {

      $(context).foundation();

    }
  };
})(jQuery, Drupal);
