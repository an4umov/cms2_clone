(function() {
    'use strict';

    jQuery(function() {
        var body = jQuery('body');

        body.on('click', '.catalog0 div.catalog1', app.onClickCatalog);
        body.on('click', '.catalog0 i.cl', app.onClickRemoveCatalog);

        jQuery('.product-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.product-slider-nav',
            infinite: false
        });
        jQuery('.product-slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-slider',
            focusOnSelect: true,
            infinite: false,
            nextArrow: '<button type="button" class="slick-next"><img src="/img/chevron-right.svg" alt="" srcset=""></button>',
            prevArrow: '<button type="button" class="slick-prev"><img src="/img/chevron-left.svg" alt="" srcset=""></button>',
        });
    });
})();

var app = app || {};

app.parentContainer = jQuery('#catalog-tree-parent-container');
app.container = jQuery('#catalog-container');
app.breadcrumbsContainer = jQuery('div.mycontainer div.breadcrumb');

app.onClickCatalog = function () {
    var btn = jQuery(this);
    var loader = btn.closest('.row').find('div.catalog-loader img');
    var code = btn.data('code');
    var level = btn.closest('.container').data('level');

    if (!!code && !!level) {
        app.removeSubCatalogs(level);

        var catalog0 = btn.closest('.catalog0');
        catalog0.find('div.catalog1').removeClass('active');
        btn.addClass('active');

        jQuery.ajax({
            url: "/catalog/view",
            cache: false,
            method: 'GET',
            data: {'code': code, 'level': level},
            dataType: 'html',
            beforeSend: function(){
                loader.show();
            },
            complete: function(){
                loader.hide();
            },
            success: function(data){
                var html = jQuery(data);
                var title = html.closest('div.breadcrumbs').find('li').last().text();
                var breadcrumbs = html.closest('div.breadcrumbs').html();
                html.closest('div.breadcrumbs').html('');
                html.closest('div.breadcrumbs').remove();

                app.container.append(html);
                app.breadcrumbsContainer.html(breadcrumbs);

                history.pushState({code: code}, title, '/shop/code/'+code);
                window.document.title = title;

                jQuery('html, body').animate({
                    scrollTop: jQuery('#container-'+code).offset().top
                }, 'slow');
            }
        });
    } else {
        console.log('Unknown catalog data');
    }
};

app.onClickRemoveCatalog = function () {
    var level = jQuery(this).closest('.catalog0').data('level');
    var currentCode = jQuery(this).closest('.catalog0').data('code');

    if (!!level) {
        app.removeSubCatalogs(level - 1);

        var title = code = url = "";
        if (app.container.find('.catalog0').last().length) {
            title = jQuery.trim(app.container.find('.catalog0').last().find('h3').text());
            code = app.container.find('.catalog0').last().data('code');
            url = '/shop/code/'+code;
        } else {
            title = jQuery.trim(app.parentContainer.find('h3').text());
            code = app.parentContainer.data('code');
            url = '/catalog';
        }

        app.breadcrumbsContainer.find('a.bc.code-'+currentCode).closest('li').prev('li').prev('li').nextAll('li').remove();

        history.replaceState({code: code}, title, url);
        window.document.title = title;

    } else {
        console.log('Unknown close level');
    }
};

app.removeSubCatalogs = function ( level) {
    app.container.find('div.container.catalog0').filter(function() {
        return parseInt(jQuery(this).attr("data-level")) > level;
    }).remove();
    jQuery('.product_pred').remove();
    jQuery('.bottom_product1').remove();
    app.container.find('div.breadcrumbs').remove();
};
