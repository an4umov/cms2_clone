$.noConflict();

(function() {
    'use strict';

    jQuery(function() {
        let body = jQuery('body');

        body.on('click', 'button.news-toggler', app.showHideNewsContent);
        body.on('click', 'a.form_modal_dialog', app.showFormDialog);
        // body.on('click', 'a.news-read-less-btn', app.hideContentExtended);

        body.on('click', 'div.readmore a', function (e) {
            e.preventDefault();
            let btn = jQuery(this);

            let items = btn.closest('.latest_news').find('.carousel-inner .carousel-item:not(:first) div.latest_news_item');
            let firstCarouselItem = btn.closest('.latest_news').find('.carousel-inner .carousel-item:first');
            let firstContainer = firstCarouselItem.find('div.row');
            firstContainer.append(items);
            firstCarouselItem.addClass('active');
            btn.closest('.latest_news').carousel('dispose');
            btn.closest('.latest_news').find('.carousel-inner .carousel-item:not(:first)').remove();
            btn.closest('.latest_news').find('a.news-control-prev, a.news-control-next').remove();
            btn.hide();
        });

        jQuery('.news-slider').carousel();
        jQuery('div.carousel').carousel();

        jQuery(".special_carousel, .latest_news").carousel({
            interval : false
        });

        jQuery("#customRadioInline3").change(function (e) {
            let togglePanel = jQuery(".hide-panel");
            e.preventDefault();
            togglePanel.hide();
            if (this.prop("checked")) {
                togglePanel.show();
            } else {
                togglePanel.hide();
            }
        });

        let assentingCheck = jQuery('input.assentingCheck');
        let all_checkboxes = assentingCheck.length;

        assentingCheck.change(function(e){
            let checked_checkboxes = jQuery('input.assentingCheck:checked').length;

            if(all_checkboxes === checked_checkboxes) {
                jQuery(".btn-accept").prop('disabled', false);
            } else {
                jQuery(".btn-accept").prop('disabled', true);
            }
        });

        body.on('click', 'button.btn-accept', function (e) {
            e.preventDefault();

            let btn = jQuery(this);
            let overlay = btn.closest('div.overlay');
            let overlayName = overlay.data('name');
            let checked_checkboxes = jQuery('input.assentingCheck:checked').length;

            if(all_checkboxes === checked_checkboxes) {
                app.setCookie(overlayName, 1);
                overlay.remove();
            } else {
                app.showMessage("Вы должны согласится с условиями");
            }
        });

        jQuery('.banner-agreement-close').click(function (e) {
            e.preventDefault();
            jQuery('.overlay').hide();
        });

        jQuery('.readmore_price').click(function (e) {
            let btn = jQuery(this);
            btn.closest('div.oneproduct1').find('.product_pred').toggle();
            // let icon = btn.find('i');
            // if (icon.hasClass('fa-chevron-down')) {
            //     icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            // } else {
            //     icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            // }
        });

        let c = '.panel-collapse';
        jQuery(c).on('show.bs.collapse', function () {
            jQuery(this).siblings('.panel-heading').addClass('active');
        });

        jQuery(c).on('hide.bs.collapse', function () {
            jQuery(this).siblings('.panel-heading').removeClass('active');
        });

        baguetteBox.run('.compact-gallery', {animation: 'slideIn'});

        jQuery('[data-toggle="popover"]').popover({
            container: 'body'
        });

        let video = jQuery('video')[0];
        jQuery('.play').click(function (e) {
            e.preventDefault();
            video.play();
            jQuery('.play').css('display', 'none');
            jQuery('.stop').css('display', 'block');
        });
        jQuery('.stop').click(function (e) {
            e.preventDefault();
            video.pause();
            jQuery('.play').css('display', 'block');
            jQuery('.stop').css('display', 'none');
        });

        body.on('click', 'div.product_pred div.number span.minus', function () {
            let btn = jQuery(this);
            let div = btn.closest('div');
            let id = div.data('id');
            let input = div.find('input');

            let newValue = parseInt(input.val()) - 1;
            if (newValue < 1) {
                input.val(1);
                app.removeFromCart(id, btn);
            } else {
                input.val(newValue);
                input.change();

                app.changeCart(id, newValue);
            }

            return false;
        });

        body.on('click', 'div.product_pred div.number span.plus', function () {
            let btn = jQuery(this);
            let div = btn.closest('div');
            let input = div.find('input');
            let id = div.data('id');
            let newValue = parseInt(input.val()) + 1;

            input.val(newValue);
            input.change();

            app.changeCart(id, newValue);

            return false;
        });

        body.on('click', '.btn-close', function (e) {
            e.preventDefault();
            let btn = jQuery(this);

            if (btn.closest('.overlay').length) {
                btn.closest('.overlay').hide();
            }
            if (btn.closest('.modal-form').length) {
                btn.closest('.modal-form').hide();
            }
        });
    });
})();

var app = {
    urls : {
        addToCart: "/cart/add",
        changeCart: "/cart/change",
        removeFromCart: "/cart/remove",
        clearCart: "/cart/clear"
    },
    showMessage: function(message) {
        alert(message);
    },
    hideGalleryBlock: function() {
        let compactGallery = jQuery('.gallery-block.compact-gallery');

        if (jQuery(window).width() < 768) {
            compactGallery.find(".item").not(":first-child").addClass("table-mobile-hide");

        }else{
            compactGallery.find(".item").not(":first-child").removeClass("table-mobile-hide");
        }
    },
    addToCart: function(id, button) {
        if (!!id) {
            let loader = button.find('div.cart-loader img');
            let cart = button.find('i.fas');

            jQuery.ajax({
                url: app.urls.addToCart,
                cache: false,
                method: 'POST',
                data: {'id': id},
                dataType: 'json',
                beforeSend: function(){
                    cart.hide();
                    loader.show();
                },
                complete: function(){
                    cart.show();
                    loader.hide();
                },
                error: function(){
                    cart.show();
                    loader.hide();
                },
                success: function(data){
                    if (data.ok) {
                        if (data.count > 0) {
                            button.closest('div').find('button').hide();
                            button.closest('div').find('div.number').show();

                            app.setCartCounter(data.count);
                            // app.showMessage('Товар добавлен к корзину');
                        } else {
                            app.showMessage('Ошибка добавления товара в корзину!');
                        }
                    } else {
                        app.showMessage(data.message);
                    }
                }
            });
        }
    },
    changeCart: function(id, quantity) {
        if (!!id && !!quantity) {
            jQuery.ajax({
                url: app.urls.changeCart,
                cache: false,
                method: 'POST',
                data: {'id': id, 'qty': parseInt(quantity)},
                dataType: 'json',
                success: function(data){
                    if (data.ok) {
                          app.setCartCounter(data.count);
                        // app.showMessage('Количество товара изменено');
                    } else {
                        app.showMessage(data.message);
                    }
                }
            });
        }
    },
    removeFromCart: function(id, button) {
        if (!!id) {
            jQuery.ajax({
                url: app.urls.removeFromCart,
                cache: false,
                method: 'POST',
                data: {'id': id},
                dataType: 'json',
                success: function(data){
                    if (data.ok) {
                        app.setCartCounter(data.count);
                        // app.showMessage('Товар удален из корзины');

                        button.closest('div.dop7').find('button').show();
                        button.closest('div.dop7').find('div.number').hide();
                    } else {
                        app.showMessage(data.message);
                    }
                }
            });
        }
    },
    clearCart: function() {
        jQuery.ajax({
            url: app.urls.clearCart,
            cache: false,
            method: 'POST',
            data: {},
            dataType: 'json',
            success: function(data){
                if (data.ok) {
                    app.setCartCounter(0);
                    app.showMessage('Корзина очищена')
                } else {
                    app.showMessage(data.message);
                }
            }
        });
    },

    getWpPosts: function(url, container) {
        // http://wptest.lr.ru/wp-json/wp/v2/posts

        jQuery.ajax({
            url: url,
            cache: false,
            method: 'GET',
            data: {},
            dataType: 'json',
            success: function(data){
                jQuery.each(data,function(index, post){
                    container.append("<div class='post'><h1>"+post.title.rendered+"</h1><p>"+post.content.rendered+"</p></div>\n");
                });
            }
        });
    },

    getWpSearchResult: function(params, container) {
        // http://wptest.lr.ru/wp-json/wp/v2/pages

        jQuery.ajax({
            url: '/wp/search',
            cache: false,
            method: 'GET',
            data: params,
            dataType: 'json',
            beforeSend: function(){
                app.showSearchLoader();
            },
            complete: function(){
                app.hideSearchLoader();
            },
            error: function(){
                app.hideSearchLoader();
                app.showMessage('Ошибка поиска...');
            },
            success: function(data){
                container.html(data);
            }
        });
    },

    getWpPost: function(url, container) {
        // http://wptest.lr.ru/wp-json/wp/v2/posts/1

        jQuery.ajax({
            url: url,
            cache: false,
            method: 'GET',
            data: {},
            dataType: 'json',
            success: function(post){
                if (!!post.id) {
                    container.append("<div class='post'><h1>"+post.title.rendered+"</h1><p>"+post.content.rendered+"</p></div>\n");
                } else {
                    app.showMessage('Запись не найдена');
                }
            }
        });
    },

    showSearchLoader: function() {
        console.log('Идет поиск...');
    },

    hideSearchLoader: function() {
        console.log('Поиск завершен');
    },

    diplayHide: function(blockId) {
        if (jQuery(blockId).css('display') === 'none') {
            jQuery(blockId).animate({height: 'show'}, 500);
        } else {
            jQuery(blockId).animate({height: 'hide'}, 500);
        }
    },

    showHideNewsContent: function (e) {
        e.preventDefault();

        let newsToggler = jQuery(this).parents('.news_0').find('.blockk3');

        newsToggler.toggleClass("show");
        if (newsToggler.css('display') !== 'none') {
            jQuery(this).html('Свернуть <i class="fas fa-angle-double-right"></i>');
        } else {
            jQuery(this).html('Развернуть <i class="fas fa-angle-double-right"></i>');
        }
    },

    showFormDialog: function (e) {
        e.preventDefault();

        let link = jQuery(this);
        let formID = link.data('id');
        let modalID = link.data('modal');
        let url = location.href;
        let modal = jQuery('#'+modalID);

        if (modal.length) {
            modal.show();
        }
    },


    showContentExtended: function (e) {
        e.preventDefault();
        let btn = jQuery(this);

        jQuery('div.news-read-more').show('fast');
        btn.hide('fast');
    },

    hideContentExtended: function (e) {
        e.preventDefault();
        let btn = jQuery(this);

        jQuery('a.news-read-more-btn').show('fast');
        jQuery('div.news-read-more').hide('fast');
    },

    encodeQueryData: function(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));

        return ret.join('&');
    },

    prepareQueryData: function (theme, model) {
        let data = {};
        if (!!theme) {
            data.theme = theme;
        }
        if (!!model) {
            data.model = model;
        }

        return data;
    },

    setCookie: function(name, value, options = {}) {
        options = {
            path: '/',
            expires: new Date(Date.now() + 7 * 86400e3)
        };

        if (options.expires.toUTCString) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    },

    getCookie: function(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));

        return matches ? decodeURIComponent(matches[1]) : undefined;
    },

    deleteCookie: function(name) {
        app.setCookie(name, "", {
            'max-age': -1
        })
    },

    maskPhone: function(countryID, phoneID) {
        let country = jQuery('#'+countryID+' option:selected').val();
        let phoneInput = jQuery('#'+phoneID);
        let mask = '';

        switch (country) {
            case "ru":
                mask = "+7(999) 999-99-99";
                break;
            case "ua":
                mask = "+380(999) 999-99-99";
                break;
            case "by":
                mask = "+375(999) 999-99-99";
                break;
        }

        if (mask) {
            phoneInput.mask(mask);
        } else {
            phoneInput.unmask();
        }
    },

    equivalentHeight: function (blocks) {
        //примем за максимальную высоту - высоту первого блока в выборке и запишем ее в переменную maxH
        maxH = blocks.eq(0).height();
        //делаем сравнение высоты каждого блока с максимальной
        blocks.each(function () {
            maxH = (jQuery(this).height() > maxH) ? jQuery(this).height() : maxH;
        });

        //устанавливаем найденное максимальное значение высоты для каждого блока jQuery выборки
        blocks.height(maxH);
    }
};
