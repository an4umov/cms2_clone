(function() {
    'use strict';

    jQuery(function() {
        let body = jQuery('body');

        body.on('change', '#reference_buyer_id', app.onChangeReferenceBuyer);

    });
})();

var app = app || {};

app.onChangeReferenceBuyer = function (e) {
    let select = jQuery(this);
    let value = select.val();

    if (!!value) {
        jQuery('#settings-checkout-submit').removeAttr('disabled');
    } else {
        jQuery('#settings-checkout-submit').attr('disabled', 'disabled');
    }
};


