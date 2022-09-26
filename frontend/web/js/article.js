(function() {
    'use strict';

    jQuery(function() {
        if (window.pluso) if (typeof window.pluso.start == "function") return;

        if (window.ifpluso === undefined) {
            window.ifpluso = 1;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript';
            s.charset = 'UTF-8';
            s.async = true;
            s.src = ('https:' === window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
            var h = d[g]('body')[0];
            h.appendChild(s);
        }

        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 155,
            itemMargin: 5,
            asNavFor: '#slider'
        });

        jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            start: function (slider) {
                jQuery('body').removeClass('loading');
            }
        });

        jQuery('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
})();
