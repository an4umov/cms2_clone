/* global tools */
tinymce.PluginManager.add('json_visualizer', function (editor, url) {

    let listBoxValues;
    let params = {
        'css_prefix': 'mce',
        'modal_body_css': 'jv-modal',
        'modal_input_css': 'jv-item',
        'mode': 'insert',
        'visualise': 1,
        'visual_block_class': 'redactor-visual'
    };

    const MODE_UPDATE = 'update', MODE_INSERT = 'insert';

    let pluginTitle = "Визуальные блоки", mode = MODE_INSERT, currentBlock;

    listBoxValues = function () {
        let values = [];

        for (let item in editor.settings.templates) {
            values.push({
                text: editor.settings.templates[item]['name'],
                value: item
            });
        }

        return values;
    };

    editor.addButton('visual_blocks', {
        type: 'listbox',
        text: pluginTitle,
        icon: false,
        onselect: function (e) {
            //editor.insertContent(this.value());
            mode = MODE_INSERT;
            buildModal(this.value());
        },
        //cmd: 'color_block',
        values: listBoxValues(),
    });

    /*editor.addCommand('color_block', function () {
        // Check we have selected some text that we want to link
        editor.windowManager.open({
            title: 'Add a color block',
            body: [
                {
                    type: 'listbox',
                    name: 'color',
                    label: 'Colors',
                    values: [
                        {text: 'Blue', value: 'blue'},
                        {text: 'Green', value: 'green'},
                        {text: 'Sand', value: 'sand'}
                    ],
                    minWidth: 350
                },
                {
                    type: 'textbox',
                    name: 'title',
                    label: 'Title',
                    minWidth: 350
                },
                {
                    type: 'textbox',
                    multiline: true,
                    name: 'content',
                    label: 'Content',
                    minWidth: 350,
                    minHeight: 150
                },
                {
                    type: 'textbox',
                    multiline: true,
                    name: 'micetype',
                    label: 'Mice Type (Optional)',
                    minWidth: 350,
                    minHeight: 50
                }

            ],
            onsubmit: function (e) {
                editor.focus();
                // Insert selected callout back into editor, wrapping it in a shortcode
                var micetype = (e.data.micetype) ? (' micetype="' + e.data.micetype + '"') : ('');
                editor.execCommand('mceInsertContent', false, '[color_block color="' + e.data.color + '" title="' + e.data.title + '"' + micetype + ']' + e.data.content + '[/color_block]');
            }
        });
    });*/

    let buildModal = function (alias, fillTemplate) {
        let createBody = function () {

            let template = editor.settings.templates[alias]
                , templateData = template['content']
                , body = [];

            let includes = templateData.match(/{%.+?%}/g);
            includes.forEach(function (item) {
                let change = item.replace(/{%/, '').replace(/%}/, '').split('|');
                body.push({
                    type: 'textbox',
                    label: change[1],
                    classes: params['modal_input_css'],
                    name: change[0],
                    value: (typeof fillTemplate !== "undefined" && typeof fillTemplate[change[0]] !== "undefined" && fillTemplate[change[0]] !== null) ? fillTemplate[change[0]] : null,
                    id: injectId(change[0]),
                });
            });

            return body;
        };
        editor.windowManager.open({
            width: parseInt(editor.getParam("plugin_preview_width", "650"), 10),
            autoScroll: true,
            height: 300,
            title: pluginTitle,
            resizable: true,
            body: createBody(),
            data: {
                'templateId': editor.settings.templates[alias]['id'],
                'templateName': alias,
            },
            onsubmit: function (e) {
                //editor.insertContent('Title: ' + e.data.title);
                if (mode === MODE_INSERT) {
                    insertData(alias);
                } else if (mode === MODE_UPDATE) {
                    updateData(alias, fillTemplate);
                }

            },
            classes: params['modal_body_css']
        });

    };

    let insertData = function (alias) {
        let modalData = editor.windowManager.getWindows()
            , modal
            , body
        ;

        if (modalData.length === 0) {
            return true;
        } else if (modalData.length === 1) {
            modal = modalData[0];
        } else {
            for (let m in modalData) {
                if (m.classes.cls.indexOf(params['modal_body_css']) !== -1) {
                    modal = m;
                    break;
                }
            }
        }

        if (typeof modal === 'undefined') {
            return true;
        }

        body = $(modal.$el[0]);
        let insert = {}, modalDataset = modal.data.data;

        body.find('input.' + cssWithPrefix(params['modal_input_css'])).each(function (i, input) {
            input = $(input);
            let name = extractIdParamId(input.attr('id'));
            //insert[input.attr('name')] = input.val();
            insert[name] = input.val();
            console.dir(input);
        });

        let toSave = {
            WidgetTemplate: {
                content: editor.settings.templates[alias]['content'],
                fields: insert,
                name: modalDataset['templateName'],
                parent: modalDataset['templateId'],
                title: editor.settings.templates[alias]['name'],
            }
        };

        saveTemplate(toSave, onSaveCallback);

        return true;
    };

    let updateData = function (alias, fillTemplate) {
        let modalData = editor.windowManager.getWindows()
            , modal
            , body
        ;

        if (modalData.length === 0) {
            return true;
        } else if (modalData.length === 1) {
            modal = modalData[0];
        } else {
            for (let m in modalData) {
                if (m.classes.cls.indexOf(params['modal_body_css']) !== -1) {
                    modal = m;
                    break;
                }
            }
        }

        if (typeof modal === 'undefined') {
            return true;
        }

        body = $(modal.$el[0]);
        let insert = {}, modalDataset = modal.data.data;

        body.find('input.' + cssWithPrefix(params['modal_input_css'])).each(function (i, input) {
            input = $(input);
            let name = extractIdParamId(input.attr('id'));
            //insert[input.attr('name')] = input.val();
            insert[name] = input.val();
            console.dir(input);
        });

        let toSave = {
            WidgetTemplate: {
                content: editor.settings.templates[alias]['content'],
                fields: insert,
                name: modalDataset['templateName'],
                parent: modalDataset['templateId'],
                title: editor.settings.templates[alias]['name'],
            }
        };

        if (typeof fillTemplate !== "undefined" && typeof fillTemplate.id !== "undefined" && fillTemplate.id > 0) {
            toSave.WidgetTemplate.id = fillTemplate.id;
            toSave.id = fillTemplate.id;
        }

        saveTemplate(toSave, onSaveCallback);

        return true;
    };

    let saveTemplate = function (template, handler) {
        template = template || {};
        handler = handler || function () {
        };

        $.ajax({
            url: '/widget-template/create-or-update/',
            data: template,
            method: "POST",
            dataType: "json"
        }).done(function (data) {
            handler(data);
        }).fail(function (error) {
            handler(['error', error]);
        });
    };

    let onSaveCallback = function (data) {
        if (typeof data.error === "undefined" && typeof data.fields !== "undefined" && typeof data.id !== "undefined") {
            let fields = data.fields;
            fields.id = data.id;
            fields.name = data.name;
            fields.title = data.title;

            let code = editor.getContent(), section = wrapMatch(JSON.stringify(fields));

            if (mode === MODE_INSERT) {
                editor.insertContent(section)
            } else if (mode === MODE_UPDATE) {
                if ( typeof currentBlock === "undefined") {
                    return false;
                }

                if (params['visualise'] === 1) {
                    let curMatchHtml = $(currentBlock).prop('outerHTML'), newContent = code.replace(curMatchHtml, section);

                    editor.setContent(newContent);
                } else {
                    editor.setContent(code.replace(currentBlock, JSON.stringify(fields)));
                }
            }
            tinymce.activeEditor.windowManager.close();
        }
        return true;
    };

    let wrapMatch = function (match) {
        if (params['visualise'] === 1) {
            let b = template(match);
            //return '<br>' + b.outerHTML + '<br>';
            return b.outerHTML;
        }
        return match;
    };
    let template = function (dataJson) {
        let data = JSON.parse(dataJson)
            , title = data.title || "Блок";

        let b = $('<section>', {
            class : params['visual_block_class'],
            'data-json': tools.utoa(dataJson),
        });
        b.append($(document.createElement('strong')).text(title));
        return b[0];
    };

    let wrap = function () {
        if (params['visualise'] === 1) {
            //let code = this.clean.stripTags(this.code.get())
            let code = editor.getContent()
                , matches = code.match(/{.+?}/g)
                // , visual = ''
                , visual = code
            ;
            $.each(matches, function (i, match) {
                let w = wrapMatch(match);
                visual = visual.replace(match, w);
            });
            //this.insert.set(code.replace(code, visual), 0);
            editor.setContent(visual);
        }
    };

    let editorClickCallback = function (event) {
        if (event.path.length === 0) {
            return false;
        }

        let currentNode = $(event.path[0])
            , node
            , currentMatch
            //, currentMatch = currentNode.parents(params['visual_block_class'])
        ;

        if (currentNode.hasClass(params['visual_block_class'])) {
            currentMatch = currentNode;
        } else {
            let p = currentNode.closest('.' + params['visual_block_class']);

            if (p.length === 0) {
                return false;
            }

            currentMatch = p;
        }
        currentBlock = currentMatch;
        refresh(currentMatch);
    };

    let refresh = function (section) {
        let selection;

        if (params['visualise'] === 1) {
            selection = tools.atou(section.data('json'));
        }

        selection = JSON.parse(selection);
        mode = MODE_UPDATE;

        if (typeof selection.id === "undefined" || typeof selection.name === "undefined") {
            return true;
        }
        buildModal(selection.name, selection);
    };


    let cssWithPrefix = function (css) {
        return params['css_prefix'] + '-' + css;
    };

    let injectId = function (id_param) {
        return 'jv_' + id_param;
    };

    let extractIdParamId = function (id) {
        return id.replace('jv_', '');
    };

    let init = function () {
        wrap();
    };

    editor.on('init', function(e) {
        init();
    });

    editor.on('dblclick', function (event) {
        editorClickCallback(event);
    });




    return {
        getMetadata: function () {
            return {
                name: pluginTitle,
            };
        }
    };
});

