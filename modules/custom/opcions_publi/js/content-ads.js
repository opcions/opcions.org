(function ($, LazyAds) {
    Drupal.behaviors.opcionsPubliContentAds = {
        attach: function (context, settings) {
            selector = '.node--type-article.node--view-mode-full .node__content .field--name-body > p:nth-of-type(5n+1)';
            $(context).find(selector).once('myCustomBehavior').after(settings.opcions_publi.content_ads);
            LazyAds.init();
        }
    };
})(jQuery, LazyAds);