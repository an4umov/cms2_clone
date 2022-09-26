(function() {
    'use strict';

    jQuery(function() {
        var body = jQuery('body');

        body.on('click', 'button.add-cart-button', app.onClickAddToCart);
        body.on('click', 'button.clear-cart-button', app.onClickClearCart);
    });
})();

var app = app || {};

app.cartCounter = jQuery('body header div.cart div.num');
app.cartCheckout = {
    step1: {type: '', typeFL: {}, typeIP: {}, typeUL: {}},
    step2: {type: '', typeSelf: {}, typeMoscow: {}, typeTK: {}},
    step3: {type: '', typeCashCourier: {}, typeCashOffice: {}, typeCashlessCard: {}, typeCashlessBank: {}},
    step4: {totalCost: 0, discount: {percent: 0, cost: 0, couponCost: 0}, totalCostWithDiscount: 0}
};

app.onClickAddToCart = function () {
    var btn = jQuery(this);
    var id = btn.data('id');

    if (!!id) {
        app.addToCart(id, btn);
    } else {
        console.log('Unknown article number');
    }
};

app.setCartCounter = function (count) {
    app.cartCounter.text(count);
};

app.onClickClearCart = function () {
    app.clearCart();
};

app.setCartCheckoutStep1Type = function (type) {
    app.cartCheckout.step1.type = type;
};

app.setCartCheckoutStep2Type = function (type) {
    app.cartCheckout.step2.type = type;
};

app.setCartCheckoutStep3Type = function (type) {
    app.cartCheckout.step3.type = type;
};

app.setCartCheckoutStep4TotalCost = function (cost) {
    app.cartCheckout.step4.totalCost = cost;
};

app.setCartCheckoutStep4DiscountPercent = function (percent) {
    app.cartCheckout.step4.discount.percent = percent;

    if (!!app.cartCheckout.step4.totalCost) {
        app.cartCheckout.step4.discount.cost = app.cartCheckout.step4.totalCost / 100 * app.cartCheckout.step4.discount.percent;

        app.setCartCheckoutStep4TotalCostWithDiscount();
    }
};

app.setCartCheckoutStep4DiscountCouponCost = function (couponCost) {
    app.cartCheckout.step4.discount.couponCost = couponCost;

    if (!!app.cartCheckout.step4.totalCost) {
        app.setCartCheckoutStep4TotalCostWithDiscount();
    }
};

app.setCartCheckoutStep4TotalCostWithDiscount = function () {
    app.cartCheckout.step4.totalCostWithDiscount = app.cartCheckout.step4.totalCost - app.cartCheckout.step4.discount.cost - app.cartCheckout.step4.discount.couponCost;
};









