/* global require */
(function ($, Drupal, Foundation) {
  'use strict';

  require('velocity-animate');
  require('velocity-animate');
  require('velocity-animate/velocity.ui');

  Drupal.behaviors.opcionsToggle = {
    attach: function (context, settings) {

      $(context).find('.js-navigation-main-toggle', '.js-navigation-main-close').on('click', function (e) {
        e.preventDefault();

        if ($('.js-navigation-main-toggle').hasClass('close')) {
          $('.js-navigation-main').velocity('slideUp');
          $('.layout-container').removeClass('is-navigation-open');
          $('html').removeClass('u-no-scroll');
        }
        else {
          $('.js-navigation-main').velocity('slideDown');
          $('.layout-container').addClass('is-navigation-open');
          if (Foundation.MediaQuery.current === 'small') {
            $('html').addClass('u-no-scroll');
          }

        }
        $('.js-navigation-main-toggle').toggleClass('close');
      });

    }
  };
  Drupal.behaviors.opcionsFoudation = {
    attach: function (context, settings) {

      $(context).foundation();

    }
  };
})(jQuery, Drupal, Foundation);
