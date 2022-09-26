(function() {
    'use strict';

    $(function() {
        let body = jQuery('body');
        jQuery('#block-add-btn').on('click', app.onBlockAdd);
        jQuery('#reference-value-add-btn').on('click', app.onReferenceValueAdd);
        jQuery('#form-field-add-btn').on('click', app.onFormFieldAdd);
        jQuery('#content-add-btn').on('click', app.onContentBlockAdd);
        jQuery('#content-setting-add-btn').on('click', app.onContenSettingtBlockAdd);

        let fieldList =  jQuery("#block-form-field-list");
        fieldList.on("click", "a.block-form-field-delete", app.deleteBlockField);
        fieldList.on("click", "a.block-form-field-edit", app.editBlockField);

        let refValueList =  jQuery("#reference-value-form-list");
        refValueList.on("click", "a.reference-value-form-field-edit", app.editReferenceValue);
        refValueList.on("click", "a.reference-value-form-field-delete", app.deleteReferenceValue);

        let formFieldList =  jQuery("#form-field-form-list");
        formFieldList.on("click", "a.form-field-form-field-edit", app.editFormField);
        formFieldList.on("click", "a.form-field-form-field-delete", app.deleteFormField);

        body.on("click", "#field-list-add-btn", app.addFieldListItem);
        body.on("click", "#block-field-list-add-btn", app.addBlockFieldListItem);
        body.on("click", "#field-values-list-add-btn", app.addBlockFieldValuesListItem);
        body.on("click", "button.block-form-field-list-delete", app.addBlockFieldListItemDelete);
        body.on("click", "button.block-form-field-values-list-delete", app.addBlockFieldValuesListItemDelete);
        body.on("change", "#blockfield-type", app.addBlockFieldChange);
        body.on("change", "#contentblockform-type", app.contentBlockTypeChange);
        body.on("click", "button.content-block-delete-btn", app.deleteContentBlock);
        body.on("click", "button.content-block-ready-btn", app.readyContentBlock);
        body.on("click", "button.content-block-field-list-delete-btn", app.blockFieldListDelete);
        body.on("click", "button.image-gallery-btn", app.imageGallerySelect);
        body.on("click", "a.image-gallery-select-btn", app.imageGalleryItemSelect);
        body.on("click", "a.image-gallery-open-btn", app.imageGalleryDirectoryOpen);
        body.on("click", "a.settings-checkout-view-btn", app.onSettingsCheckoutView);
        body.on("click", "a.departments-tree-view-btn", app.onDepartmentsTreeView);
        body.on("click", "a.department-tree-create-btn", app.onDepartmentTreeCreate);
    });
})();

var app = app || {};

app.blockUI = function(message) {
    'use strict';

    $.blockUI({
        message: !!message ? message : 'Пожалуйста, подождите...',
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });
};

app.urls = {
    blockFieldList : '/blocks/field/list',
    referenceValuesList : '/reference/reference-value/list',
    formFieldsList : '/form/form-field/list',
    blockFieldAdd: '/blocks/field/add',
    referenceValueAdd: '/reference/reference-value/add',
    formFieldAdd: '/form/form-field/add',
    blockFieldUpdate: '/blocks/field/update',
    referenceValueUpdate: '/reference/reference-value/update',
    formFieldUpdate: '/form/form-field/update',
    contentBlockAdd: '/content/block/add',
    settingsCheckoutView: '/settings-checkout/tree',
    departmentsTreeView: '/department/department/tree',
    contentSettingBlockAdd: '/content/block/add-setting',
    contentBlocksList : '/content/block/list',
    blockFieldDelete : '/blocks/field/delete',
    referenceValueDelete : '/reference/reference-value/delete',
    formFieldDelete : '/form/form-field/delete',
    contentBlockDelete : '/content/block/delete',
    blockFieldListItems : '/blocks/field/field-list',
    blockFieldListValuesItems : '/blocks/field/field-values-list',
    blockFieldListItem : '/blocks/field/field-list-item',
    blockFieldListAdd : '/blocks/field/field-list-add',
    imageGalleryList : '/image-gallery/list',
    blockFieldValuesListItem : '/blocks/field/field-values-list-item'
};

app.preloader = '<img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка формы...';
app.imageGalleryFilename = '';

app.addNotification = function(msg) {
    jQuery.gritter.add({
        title: 'Уведомление',
        text: msg
    });
};

app.addError = function(msg) {
    jQuery.gritter.add({
        title: 'Ошибка!',
        text: msg,
        class_name: 'gritter-danger'
    });
};

app.getDialogAjaxContent = function (url, data, dialog) {
    jQuery.ajax({
        url: url,
        cache: false,
        method: 'GET',
        data: data,
        dataType: 'html',
        async: true,
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            dialog.dialog(
                !!html ? jQuery(html) : 'Данные отсутствуют...',
                function(result) {}
            );
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.onDepartmentTreeCreate = function (e) {
    e.preventDefault();

    let btn = jQuery(this);

    app.getTreeAjaxContent(btn.attr('href'), {});
};

app.getTreeAjaxContent = function (url, data) {
    jQuery.ajax({
        url: url,
        cache: false,
        method: 'GET',
        data: data,
        dataType: 'html',
        async: true,
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery("#department-tree-content").html(!!html ? jQuery(html) : 'Данные отсутствуют...');
        },
        error: function(html){
            jQuery("#department-tree-content").html("Ошибка загрузки данных!");
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.getCurrentTreeNode = function (nodes, id, type) {
    let node = null;

    for(let key in nodes){
        if(nodes.hasOwnProperty(key)){
            let root = nodes[key];
            if (!!root.children) {
                for(let rootChildrenKey in root.children) {
                    if (root.children.hasOwnProperty(rootChildrenKey)) {
                        let department = root.children[rootChildrenKey];
                        if (type === 'department' && department.id === id) {
                            return department;
                        }

                        if (!!department.children) {
                            for(let departmentChildrenKey in department.children){
                                if(department.children.hasOwnProperty(departmentChildrenKey)){
                                    let menu = department.children[departmentChildrenKey];
                                    if (type === 'menu' && menu.id === id) {
                                        return menu;
                                    }

                                    if (!!menu.children) {
                                        for (let menuTagChildrenKey in menu.children) {
                                            if (menu.children.hasOwnProperty(menuTagChildrenKey)) {
                                                let menuTag = menu.children[menuTagChildrenKey];
                                                if (type === 'menu_tag' && menuTag.id === id) {
                                                    return menuTag;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return node;
};

app.onBeforeClickTreeNode = function (treeId, treeNode) {
    if (!!treeNode.url) {
        app.getTreeAjaxContent(treeNode.url, {});
    }
};

app.onClickTreeNode = function (e, treeId, treeNode) {
    e.preventDefault();
};

app.getAjaxContentImageGallery = function (url, data, btn) {
    jQuery.ajax({
        url: url,
        cache: false,
        method: 'GET',
        data: data,
        dataType: 'html',
        async: true,
        success: function(html){
            btn.closest('.bootstrap-dialog-message').html(!!html ? jQuery(html) : 'Данные отсутствуют...');
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.loadBlockFieldList = function (id) {
    jQuery.ajax({
        url: app.urls.blockFieldListItems,
        cache: false,
        method: 'GET',
        data: {id: id},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#form-block-field-list-container').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.loadBlockFieldValuesList = function (id) {
    jQuery.ajax({
        url: app.urls.blockFieldListValuesItems,
        cache: false,
        method: 'GET',
        data: {id: id},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#form-block-field-list-container').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.addFieldListItem = function (e) {
    e.preventDefault();
    let btn = jQuery(this);

    jQuery.ajax({
        url: app.urls.blockFieldListItem,
        cache: false,
        method: 'GET',
        data: {id: btn.data('field_id')},
        dataType: 'html',
        // beforeSend: function(){
        //     app.blockUI();
        // },
        // complete: function(){
        //     jQuery.unblockUI();
        // },
        success: function(html){
            jQuery('#form-block-field-list-container ul').append(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.addBlockFieldListItem = function (e) {
    e.preventDefault();
    let btn = jQuery(this);
    let len = btn.closest('.panel').find('div.panel-body > div.panel').length;

    jQuery.ajax({
        url: app.urls.blockFieldListAdd,
        cache: false,
        method: 'GET',
        data: {id: btn.data('field_id'), block_id: btn.data('block_id'), content_block_id: btn.data('content_block_id'), length: len},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            btn.closest(".panel").children(".panel-body").append(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.addBlockFieldValuesListItem = function (e) {
    e.preventDefault();
    let btn = jQuery(this);

    jQuery.ajax({
        url: app.urls.blockFieldValuesListItem,
        cache: false,
        method: 'GET',
        data: {id: btn.data('field_id')},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#form-block-field-list-container ul').append(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.addBlockFieldListItemDelete = function (e) {
    e.preventDefault();

    jQuery(this).closest('li').remove();
};

app.addBlockFieldValuesListItemDelete = function (e) {
    e.preventDefault();

    jQuery(this).closest('li').remove();
};

app.blockFieldListDelete = function () {
    // jQuery(this).closest('.panel').remove();

    jQuery(this).closest('.panel').fadeOut(300, function(){ jQuery(this).remove();});
};

app.addBlockFieldChange = function (e) {
    let select = jQuery(this);
    let value = select.val();

    if (value === 'list') {
        let fieldID = parseInt(jQuery('#blockfield-id').val());

        if (!!fieldID) {
            app.loadBlockFieldList(fieldID);
        }
    } else {
        jQuery('#form-block-field-list-container').html('');
    }
};

app.contentBlockTypeChange = function (e) {
    let select = jQuery(this);
    let value = select.val();

    if (!!value) {
        app._emptySelect('#form-content-block-container');

        let typeList = blocks[value];
        jQuery.each(typeList, function(key, value) {
            jQuery('#form-content-block-container')
                .append(jQuery("<option></option>")
                    .attr("value", value.id)
                    .text(value.name));
        });

    } else {
        app._emptySelect('#form-content-block-container');
    }
};

app._emptySelect = function(id) {
    jQuery(id)
        .find('option')
        .remove()
        .end()
        .append('<option value="">Выбрать...</option>')
        .val("");

};

app.sendAjaxForm = function(ajax_form) {
    let form = jQuery("#"+ajax_form);

    return jQuery.ajax({
        url: form.attr('action'),
        async: false,
        type: "POST", //метод отправки
        dataType: "json", //формат данных
        data: form.serialize()
    });
};

app._deleteBlockField = function(blockID, fieldID) {
    return jQuery.ajax({
        url: app.urls.blockFieldDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {block_id: blockID, id: fieldID},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app._deleteReferenceValue = function(referenceID, id) {
    return jQuery.ajax({
        url: app.urls.referenceValueDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {reference_id: referenceID, id: id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app._deleteFormField = function(formID, id) {
    return jQuery.ajax({
        url: app.urls.formFieldDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {form_id: formID, id: id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app._deleteContentBlock = function(contentBlockID) {
    return jQuery.ajax({
        url: app.urls.contentBlockDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: contentBlockID},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app.deleteBlockField = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить это поле?", function (result) {
        if (result) {
            jQuery.when( app._deleteBlockField(btn.data('block_id'), btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.loadBlockFields(btn.data('block_id'));
                    app.addNotification('Поле удалено');
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.deleteReferenceValue = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить это значение?", function (result) {
        if (result) {
            jQuery.when( app._deleteReferenceValue(btn.data('reference_id'), btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.loadReferenceValues(btn.data('reference_id'));
                    app.addNotification('Значение удалено');
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.deleteFormField = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить это поле?", function (result) {
        if (result) {
            jQuery.when( app._deleteFormField(btn.data('form_id'), btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.loadFormFields(btn.data('form_id'));
                    app.addNotification('Поле удалено');
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.deleteContentBlock = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogContentDelete.confirm("Вы уверены, что хотите удалить этот блок?", function (result) {
        if (result) {
            let id = btn.data('id');
            jQuery.when( app._deleteContentBlock(id) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    jQuery('div.content-block-'+id).remove();
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.readyContentBlock = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogContentReady.confirm("Данный блок со всеми полями и данными будет скопирован в раздел 'Готовые блоки'. Вы уверены, что хотите это сделать?", function (result) {
        if (result) {
            let id = btn.data('id');
            // location.href = '/blocks/ready/clone?id='+id;
            window.open('/blocks/ready/clone?id='+id);
        }
    });
};

app.onBlockAdd = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.blockFieldAdd, {block_id: jQuery(this).data('block_id')}, krajeeDialogCustomAdd);
};

app.onReferenceValueAdd = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.referenceValueAdd, {reference_id: jQuery(this).data('reference_id')}, krajeeDialogCustomAdd);
};

app.onFormFieldAdd = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.formFieldAdd, {form_id: jQuery(this).data('form_id')}, krajeeDialogCustomAdd);
};

app.onContentBlockAdd = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.contentBlockAdd, {content_id: jQuery(this).data('content_id')}, krajeeDialogContentAdd);
};

app.onSettingsCheckoutView = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.settingsCheckoutView, {id: jQuery(this).data('id')}, krajeeDialogSettingsCheckoutView);
};

app.onDepartmentsTreeView = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.departmentsTreeView, {}, krajeeDialogDepartmentsTreeView);
};

app.onContenSettingtBlockAdd = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.contentSettingBlockAdd, {content_id: jQuery(this).data('content_id')}, krajeeDialogContentAdd);
};

app.editBlockField = function(e) {
    'use strict';
    e.preventDefault();

    let btn = jQuery(this);
    app.getDialogAjaxContent(app.urls.blockFieldUpdate, {block_id: btn.data('block_id'), id: btn.data('id')}, krajeeDialogCustomUpdate);
};

app.editReferenceValue = function(e) {
    'use strict';
    e.preventDefault();

    let btn = jQuery(this);
    app.getDialogAjaxContent(app.urls.referenceValueUpdate, {reference_id: btn.data('reference_id'), id: btn.data('id')}, krajeeDialogCustomUpdate);
};

app.editFormField = function(e) {
    'use strict';
    e.preventDefault();

    let btn = jQuery(this);
    app.getDialogAjaxContent(app.urls.formFieldUpdate, {form_id: btn.data('form_id'), id: btn.data('id')}, krajeeDialogCustomUpdate);
};

app.loadBlockFields = function (blockID) {
    jQuery.ajax({
        url: app.urls.blockFieldList,
        cache: false,
        method: 'GET',
        data: {id: blockID},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#block-form-field-list').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
            jQuery('#block-form-field-list').html('<i class="fas fa-exclamation-circle"></i> Ошибка загрузки данных');
        }
    });
};

app.loadReferenceValues = function (referenceID) {
    jQuery.ajax({
        url: app.urls.referenceValuesList,
        cache: false,
        method: 'GET',
        data: {id: referenceID},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#reference-value-form-list').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
            jQuery('#reference-value-form-list').html('<i class="fas fa-exclamation-circle"></i> Ошибка загрузки данных');
        }
    });
};

app.loadFormFields = function (formID) {
    jQuery.ajax({
        url: app.urls.formFieldsList,
        cache: false,
        method: 'GET',
        data: {id: formID},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#form-field-form-list').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
            jQuery('#form-field-form-list').html('<i class="fas fa-exclamation-circle"></i> Ошибка загрузки данных');
        }
    });
};

app.loadContentBlocks = function (contentID, expanded) {
    jQuery.ajax({
        url: app.urls.contentBlocksList,
        cache: false,
        method: 'GET',
        data: {id: contentID, expanded: expanded},
        dataType: 'html',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            jQuery('#content-form-block-list').html(jQuery(html));
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
            jQuery('#content-form-block-list').html('<span class="fas fa-exclamation-circle" title=""></span> Ошибка загрузки данных!');
        }
    });
};

app.imageGallerySelect = function () {
    'use strict';

    let btn = jQuery(this);
    app._setImageGalleryFilename(btn.data('filepath'));

    app.getDialogAjaxContent(app.urls.imageGalleryList, {initdir: btn.data('initdir'), dir: btn.data('dir'), filepath: app.getImageGalleryFilename(), init: 1}, eval(btn.data('libname')));
};

app.imageGalleryItemSelect = function (e) {
    e.preventDefault();
    'use strict';

    let btn = jQuery(this);
    app._setImageGalleryFilename(btn.data('path'));

    btn.closest('div.row').find('div.card.active').removeClass('active');
    btn.closest('div.card').addClass('active');
};

app.imageGalleryDirectoryOpen = function (e) {
    e.preventDefault();
    'use strict';

    let btn = jQuery(this);
    app.getAjaxContentImageGallery(app.urls.imageGalleryList, {initdir: btn.data('initdir'), dir: btn.data('path'), filepath: app.getImageGalleryFilename(), init: 0}, btn);
};

app._setImageGalleryFilename = function (path) {
    app.imageGalleryFilename = path;
};

app.getImageGalleryFilename = function () {
    return app.imageGalleryFilename;
};