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
        body.on("change", "#lrpartsrubricblockform-type", app.lrPartsRubricsBlockTypeChange);
        body.on("click", "button.content-block-delete-btn", app.deleteContentBlock);
        body.on("click", "button.content-block-ready-btn", app.readyContentBlock);
        body.on("click", "button.content-block-field-list-delete-btn", app.blockFieldListDelete);
        body.on("click", "button.image-gallery-btn", app.imageGallerySelect);
        body.on("click", "a.image-gallery-select-btn", app.imageGalleryItemSelect);
        body.on("click", "a.image-gallery-open-btn", app.imageGalleryDirectoryOpen);
        body.on("click", "a.settings-checkout-view-btn", app.onSettingsCheckoutView);
        body.on("click", "a.departments-tree-view-btn", app.onDepartmentsTreeView);
        body.on("click", "a.departments-analize-view-btn", app.onDepartmentsAnalizeView);
        body.on("click", "a.department-tree-create-btn", app.onDepartmentTreeCreate);
        body.on("click", "a.lrparts-item-btn", app.onLrPartsItemUpdate);
        body.on("click", "#form-lrparts-rubrics-add-btn", app.onLrPartsRubricAdd);
        body.on("click", "#form-cart-settings-add-btn", app.onCartSettingsAdd);
        body.on("click", "#form-cart-settings-remove-btn", app.onCartSettingsRemove);
        body.on("click", "#form-lrparts-items-add-btn", app.onLrPartsItemAdd);
        body.on("click", "#form-lrparts-rubrics-delete-btn", app.deleteLrPartsRubric);
        body.on("click", "#form-lrparts-items-delete-btn", app.deleteLrPartsItem);
        body.on("click", "#form-lrparts-rubrics-add-block-btn", app.addLrPartsRubricBlock);
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
    lrPartsItemUpdate: '/parsing/lrparts/update',
    formFieldUpdate: '/form/form-field/update',
    contentBlockAdd: '/content/block/add',
    settingsCheckoutView: '/settings-checkout/tree',
    departmentsTreeView: '/department/department/tree',
    departmentsAnalizeView: '/department/department/analize',
    contentSettingBlockAdd: '/content/block/add-setting',
    contentBlocksList : '/content/block/list',
    lrPartsBlocksList : '/parsing/lrparts/block-list',
    blockFieldDelete : '/blocks/field/delete',
    referenceValueDelete : '/reference/reference-value/delete',
    formFieldDelete : '/form/form-field/delete',
    lrPartsRubricDelete : '/parsing/lrparts/delete-rubric',
    lrPartsItemDelete : '/parsing/lrparts/delete-item',
    cartSettingRemove : '/cart/cart-settings/remove-setting',
    contentTreeFolderDelete : '/content/tree/delete-folder',
    contentTreeDragDropContent : '/content/tree/drag-drop-content',
    lrPartsRubricBlockAdd: '/parsing/lrparts/block-add',
    contentBlockDelete : '/content/block/delete',
    blockFieldListItems : '/blocks/field/field-list',
    blockFieldListValuesItems : '/blocks/field/field-values-list',
    blockFieldListItem : '/blocks/field/field-list-item',
    blockFieldListAdd : '/blocks/field/field-list-add',
    imageGalleryList : '/image-gallery/list',
    blockFieldValuesListItem : '/blocks/field/field-values-list-item',
    migrateTables : '/settings/migrate',
    departmentTreeNodeDelete : '/department/department-tree/delete'
};

app.preloader = '<img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка формы...';
app.imageGalleryFilename = '';
app.departmentTreeID = '';
app.lrpartsTreeID = '';
app.cartSettingsTreeID = '';

app.contentTreeID = '';
app.contentTreeTypeFolder = '';
app.contentTreeTypeContent = '';
app.contentTreeNewFolder = '';
app.contentTreeFolderFont = '';

app.lrpartsTreeActiveUrl = '';
app.cartSettingsTreeActiveUrl = '';
app.treeTypes = {
    department : '',
    menu : '',
    tag : ''
};

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

app.onLrPartsItemUpdate = function (e) {
    e.preventDefault();

    let btn = jQuery(this);

    app.getDialogAjaxContent(app.urls.lrPartsItemUpdate, {id: jQuery(this).data('id')}, krajeeDialogLrPartsItemUpdate);
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

app.determineNode = function (curNode, id, type) {

    if(!!curNode.type && curNode.type === type && !!curNode.id && curNode.id === id) {
        return curNode;
    }

    if (!!curNode.children) {
        for(const node of curNode.children) {
            let result = app.determineNode(node, id, type);

            if (!!result) {
                return result;
            }
        }
    }

    return null;
};

app.getCurrentTreeNode2 = function (nodes, id, type) {
    let node = null;

    for(let key in nodes){
        if(nodes.hasOwnProperty(key)){
            let root = nodes[key];
            if (!!root.children) {
                for(let rootChildrenKey in root.children) {
                    if (root.children.hasOwnProperty(rootChildrenKey)) {
                        let item = root.children[rootChildrenKey];

                        node = app.determineNode(item, id, type);

                        if (!!node) {
                            return node;
                        }
                    }
                }
            }
        }
    }

    return node;
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

app.addHoverDomContentTree = function (treeId, treeNode) {
    var sObj = $("#" + treeNode.tId + "_span");

    if ($("#addBtn_"+treeNode.tId).length > 0) return;
    if (treeNode.type === app.contentTreeTypeContent) return;
    if (treeNode.id === 0) return;

    var addStr = "<span class='button add' id='addBtn_" + treeNode.tId + "' title='Добавить папку' onfocus='this.blur();'></span>";
    sObj.after(addStr);

    var btn = $("#addBtn_"+treeNode.tId);
    if (btn) btn.bind("click", function(){
        var zTree = $.fn.zTree.getZTreeObj(app.contentTreeID);
        zTree.addNodes(treeNode, {id:0, parent_id:treeNode.id, name:app.contentTreeNewFolder, url: '/content/tree/add-folder?pid='+treeNode.id, type: app.contentTreeTypeFolder, font: app.contentTreeFolderFont});

        return false;
    });
};

app.removeHoverDomContentTree = function (treeId, treeNode) {
    $("#addBtn_"+treeNode.tId).unbind().remove();
};

app.showRenameBtnContentTree = function (treeId, treeNode) {
    return false;
};

app.showRemoveBtnContentTree = function (treeId, treeNode) {
    return treeNode.type === app.contentTreeTypeFolder && treeNode.id > 0 && !treeNode.isParent;
};

app.beforeRemoveContentTree = function (treeId, treeNode) {
    var zTree = $.fn.zTree.getZTreeObj(treeId);
    zTree.selectNode(treeNode);

    return confirm("Удалить папку '" + treeNode.name + "'? ");
};

app.onRemoveContentTree = function (e, treeId, treeNode) {
    jQuery.ajax({
        url: app.urls.contentTreeFolderDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: treeNode.id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(response){
            location.href = '/content/tree';
        },
        error: function(response){
            app.addError(response.message);
        }
    });
};

app.beforeDragContentTree = function (treeId, treeNodes) {
    for (var i = 0, l = treeNodes.length; i < l; i++) {
        if (treeNodes[i].type === app.contentTreeTypeContent) {
            return true;
        }
    }

    return false;
};

app.beforeDropContentTree = function (treeId, treeNodes, targetNode, moveType) {
    if (targetNode) {
        if (targetNode.contentType !== treeNodes[0].contentType) {
            return false;
        }

        if (targetNode.type === app.contentTreeTypeFolder && targetNode.id > 0 && moveType === 'inner') {
            return true;
        }
        if (targetNode.type === app.contentTreeTypeContent && moveType !== 'inner') {
            return true;
        }
    }

    return false;
};

app.onDropContentTree = function (event, treeId, treeNodes, targetNode, moveType, isCopy) {
    var pNode = targetNode ? targetNode.getParentNode() : null;
    if (!pNode) {
        console.log('[onDropContentTree] pNode EMPTY');

        return;
    }
    var tid = 0;
    var children = [];

    if (targetNode.type === app.contentTreeTypeFolder && targetNode.id > 0) {
        tid = targetNode.id;
    }
    if (targetNode.type === app.contentTreeTypeContent && pNode.id > 0 && moveType !== 'inner') {
        tid = pNode.id;

        for (var i = 0, l = pNode.children.length; i < l; i++) {
            children.push(pNode.children[i].id);
        }

        console.log(children);
    }
    if (!tid) {
        console.log('[onDropContentTree] tid EMPTY');

        return;
    }

    jQuery.ajax({
        url: app.urls.contentTreeDragDropContent,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: treeNodes[0].id, tid: tid, children: children},
        success: function(response){
            if (!response.ok) {
                app.addError(response.message);
            }
        },
        error: function(response){
            app.addError(response.message);
        }
    });
};

app.dropPrevContentTree = function (treeId, nodes, targetNode) {
    var pNode = targetNode.getParentNode();

    return (pNode && pNode.type === app.contentTreeTypeFolder && pNode.contentType === nodes[0].contentType);
};

app.dropInnerContentTree = function (treeId, nodes, targetNode) {
    return (targetNode && targetNode.type === app.contentTreeTypeFolder && targetNode.contentType === nodes[0].contentType);
};

app.dropNextContentTree = function (treeId, nodes, targetNode) {
    var pNode = targetNode.getParentNode();

    return (pNode && pNode.type === app.contentTreeTypeFolder && pNode.contentType === nodes[0].contentType);
};

app.onBeforeClickTreeNode = function (treeId, treeNode) {
    if (!!treeNode.url) {
        app.lrpartsTreeActiveUrl = treeNode.url;
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
            //jQuery('.blockfield-info').tinymce({    });
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

    if (value === 'list' || value === 'radio') {
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

app.lrPartsRubricsBlockTypeChange = function (e) {
    let select = jQuery(this);
    let value = select.val();

    if (!!value) {
        app._emptySelect('#form-lrparts-block-container');

        let typeList = blocks[value];
        jQuery.each(typeList, function(key, value) {
            jQuery('#form-lrparts-block-container')
                .append(jQuery("<option></option>")
                    .attr("value", value.id)
                    .text(value.name));
        });

    } else {
        app._emptySelect('#form-lrparts-block-container');
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

app.sendAjaxFileForm = function(formName) {
    let form = document.forms[formName];
    let formData = new FormData(form);
    // formData.append('imageFile', jQuery("#form-lrparts-rubrics-upload-btn")[0].files[0]);

    return jQuery.ajax({
        type: "POST",
        url: form.action,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType : 'json',
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app.onLrPartsRubricAdd = function(e) {
    let btn = jQuery(this);
    let url = '/parsing/lrparts/add?pid='+btn.data('pid');

    app.getTreeAjaxContent(url, {});
};

app.onCartSettingsAdd = function(e) {
    let btn = jQuery(this);
    let url = '/cart/cart-settings/add?pid='+btn.data('pid');

    app.getTreeAjaxContent(url, {});
};

app.onCartSettingsRemove = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить подуровень?", function (result) {
        if (result) {
            jQuery.when( app._removeCartSetting(btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.addNotification('Подуровень удален');
                    location.href = '/cart/cart-settings';
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.onLrPartsItemAdd = function(e) {
    let btn = jQuery(this);
    let url = '/parsing/lrparts/add-item?rid='+btn.data('rid');

    app.getDialogAjaxContent(url, {id: jQuery(this).data('id')}, krajeeDialogLrPartsItemAdd);
};

app.deleteLrPartsRubric = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить рубрику?", function (result) {
        if (result) {
            jQuery.when( app._deleteLrPartsRubric(btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.addNotification('Рубрика удалена');
                    location.href = location.href;
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app.deleteLrPartsItem = function(e) {
    e.preventDefault();
    let btn = jQuery(this);

    krajeeDialogCustDelete.confirm("Вы уверены, что хотите удалить товар?", function (result) {
        if (result) {
            jQuery.when( app._deleteLrPartsItem(btn.data('id')) ).then(function( response, textStatus, jqXHR ) {
                if (!!response.ok) {
                    app.addNotification('Товар удален');

                    let url = '/parsing/lrparts/view?id='+btn.data('rid');
                    app.getTreeAjaxContent(url, {});
                } else {
                    if (!!response.message) {
                        app.addError(response.message);
                    }
                }
            });
        }
    });
};

app._deleteLrPartsRubric = function(id) {
    return jQuery.ajax({
        url: app.urls.lrPartsRubricDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app._removeCartSetting = function(id) {
    return jQuery.ajax({
        url: app.urls.cartSettingRemove,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
    });
};

app._deleteLrPartsItem = function(id) {
    return jQuery.ajax({
        url: app.urls.lrPartsItemDelete,
        async: false,
        type: "POST",
        dataType: "json",
        data: {id: id},
        beforeSend: function(){
            app.blockUI();
        },
        complete: function(){
            jQuery.unblockUI();
        },
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

app.addLrPartsRubricBlock = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.lrPartsRubricBlockAdd, {rubric_id: jQuery(this).data('rubric_id')}, krajeeDialogContentAdd);
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

app.onDepartmentsAnalizeView = function(e) {
    'use strict';
    e.preventDefault();

    app.getDialogAjaxContent(app.urls.departmentsAnalizeView, {}, krajeeDialogDepartmentsAnalizeView);
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

app.loadLrPartsBlocks = function (rubricID) {
    jQuery.ajax({
        url: app.urls.lrPartsBlocksList,
        cache: false,
        method: 'GET',
        data: {id: rubricID},
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

app.refreshPage = function (time) {
    setTimeout("location.reload(true);", time);
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

app.migrate = function (data) {
    jQuery.ajax({
        url: app.urls.migrateTables,
        cache: false,
        method: 'POST',
        data: jQuery("#migrate-form").serialize(),
        dataType: 'html',
        async: true,
        beforeSend: function(){
            app.blockUI('<img src="/img/loader.gif" alt=""> Миграция таблиц, наберитесь терпения ;)');
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(html){
            let div = jQuery('#migration-result');
            div.html(html);
            div.show();
            div.get(0).scrollIntoView();
            jQuery('#migration-select-all').click().click();
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });
};

app.beforeDrag = function (treeId, treeNodes) {
    return false;
};

app.addHoverDom = function () {
    return false;
};

app.removeHoverDom = function () {
    return false;
};

app.showRemoveBtn = function (treeId, treeNode) {
    if (treeNode.type === app.treeTypes.department || treeNode.type === app.treeTypes.menu || treeNode.type === app.treeTypes.tag) {
        return true;
    }

    return false;
};

app.beforeRemove = function (treeId, treeNode) {
    var zTree = jQuery.fn.zTree.getZTreeObj(app.departmentTreeID);
    zTree.selectNode(treeNode);

    return confirm("Удалить '" + treeNode.name + "'?");
};

app.onRemove = function (e, treeId, treeNode) {
    jQuery.ajax({
        url: app.urls.departmentTreeNodeDelete,
        cache: false,
        method: 'POST',
        data: {id: treeNode.id, type: treeNode.type},
        dataType: 'json',
        async: true,
        beforeSend: function(){
            app.blockUI('<img src="/img/loader.gif" alt=""> Удаление элемента дерева департаментов...');
        },
        complete: function(){
            jQuery.unblockUI();
        },
        success: function(data){
            if (data.ok) {
                app.addNotification('Элемент "'+treeNode.name+'" удален');
            } else {
                app.addNotification(data.message);
            }
        },
        error: function(html){
            app.addError('Ошибка загрузки данных!');
        }
    });



};

app.removeTreeNode = function (treeNode) {
    app.addNotification('Удален '+treeNode.name+', '+treeNode.id+', '+treeNode.type);
};

