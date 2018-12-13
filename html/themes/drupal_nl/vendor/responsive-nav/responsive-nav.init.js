(function ($) {
  'use strict';

  Drupal.behaviors.responsiveNav = {
    attach: function(context, settings) {
      var nav = responsiveNav(".primary-nav");
    }
  };

}(jQuery));
