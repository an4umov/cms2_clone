jQuery.noConflict();

(function() {
    'use strict';

    jQuery(function() {
        var body = jQuery('body');

        body.on('click', '.user-contact-phones-add', app.onClickPhoneAdd);
        body.on('click', '.user-contact-phones-delete', app.onClickPhoneDelete);
        body.on('click', '.user-delivery-index-detect', app.onClickDeliveryIndexDetect);
        body.on('click', '.user-contractor-entity-detect-inn', app.onClickContractorEntityInnDetect);
        body.on('click', '.user-contractor-entity-detect-name', app.onClickContractorEntityNameDetect);
        body.on('change', '#usercontractorentity-name-select', app.onClickContractorEntityNameSelect);
        body.on('change', '#usercontractorentity-inn-select', app.onClickContractorEntityInnSelect);
        body.on('click', '.user-contractor-person-fill', app.onClickUserContractorReasonFill);
        body.on('click', '.user-contractor-payment-detect-bik', app.onClickContractorPaymentBikDetect);
        body.on('change', 'select.user-contractor-entity-payment-type', app.onChangeContractorEntityPaymentTypeSelect);
        body.on('change', 'select.user-contractor-person-payment-type', app.onChangeContractorPersonPaymentTypeSelect);
        body.on('click', '.contractor-entity-payment-delete', app.onClickContractorEntityPaymentDelete);
        body.on('click', '.contractor-person-payment-delete', app.onClickContractorPersonPaymentDelete);
    });
})();

var app = {
    urls : {
        getContactPhoneTemplate: "/settings/phone-template",
        getDataByAddress: "/data/find",
        getDataSuggest: "/data/suggest",
        getDataFindByID: "/data/find-by-id",
        getMainContactPerson: "/contractors/main-contact-person",
        entityPaymentDelete: "/contractors/entity-payment-delete",
        personPaymentDelete: "/contractors/person-payment-delete"
    },
    showMessage: function(message) {
        toastr.clear();
        NioApp.Toast(message, 'info', {position: 'top-center'});
    },
    showSuccessMessage: function(message) {
        toastr.clear();
        NioApp.Toast(message, 'success', {position: 'top-center'});
    },
    showErrorMessage: function(message) {
        toastr.clear();
        NioApp.Toast(message, 'error', {position: 'top-center'});
    },
    tempData: []
};

app.onClickPhoneAdd = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let loader = btn.closest('div.row').find('div.cart-loader img');

    jQuery.ajax({
        url: app.urls.getContactPhoneTemplate,
        cache: false,
        method: 'GET',
        data: {},
        dataType: 'json',
        beforeSend: function(){
            loader.show();
        },
        complete: function(){
            loader.hide();
        },
        error: function(){
            loader.hide();
        },
        success: function(data){
            btn.closest('div.row').find('.user-contact-phones-container').append(data.html);
        }
    });
};

app.onClickUserContractorReasonFill = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let loader = btn.closest('div.row').find('div.icon-loader div');
    let tab = btn.closest('div.user-contractor-tab');

    jQuery.ajax({
        url: app.urls.getMainContactPerson,
        cache: false,
        method: 'GET',
        data: {},
        dataType: 'json',
        beforeSend: function(){
            loader.show();
        },
        complete: function(){
            loader.hide();
        },
        error: function(){
            loader.hide();
        },
        success: function(data){
            if (!!data) {
                tab.find('input.user-contractor-person-firstname').val(data.firstname);
                tab.find('input.user-contractor-person-lastname').val(data.lastname);
                tab.find('input.user-contractor-person-secondname').val(data.secondname);
            } else {
                app.showMessage('Основное контактное лицо отсутствует');
            }
        }
    });
};

app.onClickContractorEntityPaymentDelete = function (e) {
    e.preventDefault();

    let btn = jQuery(this);

    Swal.fire({
        title: 'Действительно удалить форму оплаты?',
        text: "Отменить возможности не будет!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then((result) => {
        if (result.value) {
            let id = btn.data('id');
            let entity_id = btn.data('entity_id');
            let loader = btn.closest('td').find('div.icon-loader div');

            jQuery.ajax({
                url: app.urls.entityPaymentDelete,
                cache: false,
                method: 'POST',
                data: {id: id, entity_id: entity_id},
                dataType: 'json',
                beforeSend: function(){
                    loader.show();
                },
                complete: function(){
                    loader.hide();
                },
                error: function(){
                    loader.hide();
                },
                success: function(data){
                    if (!!data.ok) {
                        btn.closest('tr').remove();

                        Swal.fire(
                            'Удалено!',
                            'Форма оплаты удалена',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Ошибка!',
                            'Форма оплаты не удалена',
                            'error'
                        );
                    }
                }
            });
        }
    });
};

app.onClickContractorPersonPaymentDelete = function (e) {
    e.preventDefault();

    let btn = jQuery(this);

    Swal.fire({
        title: 'Действительно удалить форму оплаты?',
        text: "Отменить возможности не будет!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then((result) => {
        if (result.value) {
            let id = btn.data('id');
            let person_id = btn.data('person_id');
            let loader = btn.closest('td').find('div.icon-loader div');

            jQuery.ajax({
                url: app.urls.personPaymentDelete,
                cache: false,
                method: 'POST',
                data: {id: id, person_id: person_id},
                dataType: 'json',
                beforeSend: function(){
                    loader.show();
                },
                complete: function(){
                    loader.hide();
                },
                error: function(){
                    loader.hide();
                },
                success: function(data){
                    if (!!data.ok) {
                        btn.closest('tr').remove();

                        Swal.fire(
                            'Удалено!',
                            'Форма оплаты удалена',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Ошибка!',
                            'Форма оплаты не удалена',
                            'error'
                        );
                    }
                }
            });
        }
    });
};

app.onClickDeliveryIndexDetect = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let tab = btn.closest('div.user-delivery-tab');
    let loader = btn.closest('div.row').find('div.cart-loader img');

    let country = jQuery.trim(tab.find('input.user-delivery-country').val());
    let region = jQuery.trim(tab.find('input.user-delivery-region').val());
    let city = jQuery.trim(tab.find('input.user-delivery-city').val());
    let street = jQuery.trim(tab.find('input.user-delivery-street').val());
    let house = jQuery.trim(tab.find('input.user-delivery-house').val());

    let address = '';
    if (!!country) {
        address += country + ' ';
    }
    if (!!region) {
        address += region + ' ';
    }
    if (!!city) {
        address += city + ' ';
    }
    if (!!street) {
        address += street + ' ';
    }
    if (!!house) {
        address += house + ' ';
    }

    jQuery.ajax({
        url: app.urls.getDataByAddress,
        cache: false,
        method: 'GET',
        data: {'address': address},
        dataType: 'json',
        beforeSend: function(){
            loader.show();
        },
        complete: function(){
            loader.hide();
        },
        error: function(){
            loader.hide();
        },
        success: function(data){
            if (!!data && !!data.postal_code) {
                app.showMessage('Почтовый индекс получен и установлен');
                btn.closest('div.row').find('input.user-delivery-index').val(data.postal_code);
            } else {
                app.showErrorMessage('Не удалось получить почтовый индекс');
            }
            // console.log(data);
        }
    });
};

app.onClickContractorEntityInnDetect = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let row = btn.closest('div.row');
    let tab = btn.closest('div.user-contractor-tab');
    let loader = row.find('div.icon-loader div');

    let inn = jQuery.trim(row.find('input.user-contractor-entity-inn').val());

    if (!!inn) {
        jQuery.ajax({
            url: app.urls.getDataSuggest,
            cache: false,
            method: 'GET',
            data: {'name': inn},
            dataType: 'json',
            beforeSend: function(){
                loader.show();
            },
            complete: function(){
                loader.hide();
            },
            error: function(){
                loader.hide();
            },
            success: function(data){
                app.tempData = data;

                if (!!data) {
                    let select = '<select class="form-control" id="usercontractorentity-name-select" data-msg="Пожалуйста, выберите значение" name="UserContractorEntity[name_select]" aria-required="true" required>';
                    jQuery.each(data, function( index, item ) {
                        select += '<option value="'+index+'">'+item.value+'</option>';
                    });
                    select += '</select>';

                    tab.find('input.user-contractor-entity-name').hide();
                    tab.find('div.user-contractor-entity-name-select-container').html(select);
                    jQuery('#usercontractorentity-name-select').change();
                    tab.find('a.user-contractor-entity-detect-name').hide();
                } else {
                    tab.find('input.user-contractor-entity-name').show();
                    tab.find('div.user-contractor-entity-name-select-container').html('');
                    app.resetContractorEntityFields(tab);
                    app.showErrorMessage('Поиск по ИНН не дал резутатов');
                    tab.find('a.user-contractor-entity-detect-name').show();
                }
            }
        });
    } else {
        app.showErrorMessage('Заполните поле "ИНН"');
    }
};

app.onClickContractorEntityNameDetect = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let row = btn.closest('div.row');
    let tab = btn.closest('div.user-contractor-tab');
    let loader = row.find('div.icon-loader div');

    let name = jQuery.trim(row.find('input.user-contractor-entity-name').val());

    if (!!name) {
        jQuery.ajax({
            url: app.urls.getDataSuggest,
            cache: false,
            method: 'GET',
            data: {'name': name},
            dataType: 'json',
            beforeSend: function(){
                loader.show();
            },
            complete: function(){
                loader.hide();
            },
            error: function(){
                loader.hide();
            },
            success: function(data){
                app.tempData = data;

                if (!!data) {
                    let select = '<select class="form-control" id="usercontractorentity-inn-select" data-msg="Пожалуйста, выберите значение" name="UserContractorEntity[inn_select]" aria-required="true" required>';
                    jQuery.each(data, function( index, item ) {
                        select += '<option value="'+index+'">'+item.data.inn+'</option>';
                    });
                    select += '</select>';

                    tab.find('input.user-contractor-entity-inn').hide();
                    tab.find('div.user-contractor-entity-inn-select-container').html(select);
                    jQuery('#usercontractorentity-inn-select').change();
                    tab.find('a.user-contractor-entity-detect-inn').hide();
                } else {
                    tab.find('input.user-contractor-entity-inn').show();
                    tab.find('div.user-contractor-entity-inn-select-container').html('');
                    app.resetContractorEntityFields(tab);
                    app.showErrorMessage('Поиск по названию не дал резутатов');
                    tab.find('a.user-contractor-entity-detect-inn').show();
                }
            }
        });
    } else {
        app.showErrorMessage('Заполните поле "Название"');
    }
};

app.onClickContractorPaymentBikDetect = function (e) {
    e.preventDefault();

    let btn = jQuery(this);
    let row = btn.closest('div.row');
    let tab = btn.closest('div.user-contractor-payment-tab');
    let loader = row.find('div.icon-loader div');

    let bik = jQuery.trim(row.find('input.user-contractor-payment-bik').val());

    if (!!bik) {
        jQuery.ajax({
            url: app.urls.getDataFindByID,
            cache: false,
            method: 'GET',
            data: {'bik': bik},
            dataType: 'json',
            beforeSend: function(){
                loader.show();
            },
            complete: function(){
                loader.hide();
            },
            error: function(){
                loader.hide();
            },
            success: function(data){
                if (!!data && data[0]) {
                    tab.find('input.user-contractor-payment-bik').val(data[0].data.bic);
                    tab.find('input.user-contractor-payment-correspondent_account').val(data[0].data.correspondent_account);
                    tab.find('input.user-contractor-payment-bank').val(data[0].value);
                    // tab.find('input.user-contractor-payment-payment_account').val(data.correspondent_account);
                } else {
                    app.showErrorMessage('Не найдено...')
                }
            }
        });
    } else {
        app.showErrorMessage('Заполните поле "БИК"');
    }
};

app.onClickContractorEntityNameSelect = function (e) {
    let select = jQuery(this);
    let index = select.val();
    let listItem = app.tempData[index];
    let tab = select.closest('div.user-contractor-tab');

    if (!!listItem) {
        tab.find('input.user-contractor-entity-inn').val(listItem.data.inn);
        tab.find('input.user-contractor-entity-name').val(listItem.value);
        tab.find('input.user-contractor-entity-kpp').val(listItem.data.kpp);
        tab.find('input.user-contractor-entity-ogrn').val(listItem.data.ogrn);
        tab.find('textarea.user-contractor-entity-address').val(listItem.data.address.value);
    }
};

app.onClickContractorEntityInnSelect = function (e) {
    let select = jQuery(this);
    let index = select.val();
    let listItem = app.tempData[index];
    let tab = select.closest('div.user-contractor-tab');

    if (!!listItem) {
        tab.find('input.user-contractor-entity-inn').val(listItem.data.inn);
        tab.find('input.user-contractor-entity-name').val(listItem.value);
        tab.find('input.user-contractor-entity-kpp').val(listItem.data.kpp);
        tab.find('input.user-contractor-entity-ogrn').val(listItem.data.ogrn);
        tab.find('textarea.user-contractor-entity-address').val(listItem.data.address.value);
    }
};

app.onChangeContractorEntityPaymentTypeSelect = function () {
    let select = jQuery(this);
    let type = select.val();
    let tab = select.closest('div.user-contractor-payment-tab');

    if (type === 'transfer') {
        tab.find('.user-contractor-payment-type-transfer-container').show();
        tab.find('.user-contractor-payment-type-cash-container').hide();
        tab.find('.user-contractor-payment-type-card-container').hide();
    } else if (type === 'cash') {
        tab.find('.user-contractor-payment-type-transfer-container').hide();
        tab.find('.user-contractor-payment-type-cash-container').show();
        tab.find('.user-contractor-payment-type-card-container').hide();
    } else if (type === 'card') {
        tab.find('.user-contractor-payment-type-transfer-container').hide();
        tab.find('.user-contractor-payment-type-cash-container').hide();
        tab.find('.user-contractor-payment-type-card-container').show();
    }
};

app.onChangeContractorPersonPaymentTypeSelect = function () {
    let select = jQuery(this);
    let type = select.val();
    let tab = select.closest('div.user-contractor-payment-tab');

    if (type === 'cash') {
        tab.find('.user-contractor-payment-type-cash-container').show();
        tab.find('.user-contractor-payment-type-card-container').hide();
    } else if (type === 'card') {
        tab.find('.user-contractor-payment-type-cash-container').hide();
        tab.find('.user-contractor-payment-type-card-container').show();
    }
};

app.resetContractorEntityFields = function (tab) {
    tab.find('input.user-contractor-entity-kpp').val('');
    tab.find('input.user-contractor-entity-ogrn').val('');
    tab.find('textarea.user-contractor-entity-address').val('');
};

app.onClickPhoneDelete = function (e) {
    e.preventDefault();

    var btn = jQuery(this);
    btn.closest('.user-contact-phones-container-item').remove();
};


