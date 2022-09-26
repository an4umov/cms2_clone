/* global tools */
if (typeof RedactorPlugins === 'undefined') window.RedactorPlugins = {};
(function ($) {

    $.Redactor.prototype.codes = function () {
        return {
            codesModalTemplate: function () {
                return String()
                    + '<section id="redactor-modal-codes">'
                    + '</section>';
            },
            params: function () {
                const modeInsert = 1, modeUpdate = 2, modeFree = 0, visualise = 1;
                return {
                    modeFree: modeFree,
                    modeInsert: modeInsert,
                    modeUpdate: modeUpdate,
                    visualise: visualise
                }
            },
            init: function () {
                let items = this.opts.templates || []
                    , button = this.button.add('codes', 'Шаблоны');
                //this.code.sync();
                this.codes.templatesDropdown = {};
                this.codes.mode = this.codes.params().modeFree;

                $.each(items, $.proxy(this.codes.dropdownCallback, this));
                $(button).text('Виджеты');

                this.button.setAwesome('codes', 'fa-tasks');
                this.button.addDropdown(button, this.codes.templatesDropdown);
                this.$editor.on('dblclick', $.proxy(this.codes.editorClickCallback, this));
                this.codes.wrap();

                //$.proxy(this.codes.wrap, this)
            },
            dropdownCallback: function (i, item) {
                this.codes.templatesDropdown[i] = {
                    title: item.name,
                    func: this.codes.toggle
                };
            },
            fieldTemplate: function () {
                let div = $('<div class="item"></div>')
                    , label = $('<label></label>')
                    , input = $('<input type="text" placeholder="">')
                ;
                div.append(label).append(input);
                return div;
            },
            editorClickCallback: function (e) {
                this.selection.removeMarkers();
                this.selection.restore();
                let code = this.clean.stripTags(this.code.get()),
                    currentPosition = this.caret.getOffset(),
                    matches,
                    currentMatch;

                if (this.codes.params().visualise === 1) {
                    currentMatch = $(document.elementFromPoint(e.clientX, e.clientY));
                } else {
                    matches = code.match(/{.+?}/g);
                    let start = 0;
                    $.each(matches, function (i, match) {
                        start = code.indexOf(match);
                        let end = start + match.length - 1;

                        if (currentPosition > start && currentPosition < end) {
                            currentMatch = match;
                        }
                    });
                }


                this.selection.save();
                this.codes.currentMatch = currentMatch;
                this.codes.refresh(currentMatch);
                this.code.sync();
            },
            toggle: function (template) {
                this.codes.mode = this.codes.params().modeInsert;
                this.codes.buildModal(template);
            },
            refresh: function (selection) {
                selection = selection || JSON.stringify({});
                if (this.codes.params().visualise === 1) {
                    let section = $(selection);
                    selection = tools.atou(section.data('json'));
                }

                selection = JSON.parse(selection);
                this.codes.mode = this.codes.params().modeUpdate;

                if (typeof selection.id === "undefined" || typeof selection.name === "undefined") {
                    return true;
                }
                this.codes.buildModal(selection.name, selection);
            },
            buildModal: function (templateName, jsonData) {
                jsonData = jsonData || JSON.stringify({});
                let items = this.opts.templates || []
                    , currentSelection = jsonData
                    , templateInput = this.codes.fieldTemplate()
                    , modalInner = $('<div></div>')
                    , templateData = items[templateName]['content']
                ;

                if (typeof templateData === 'undefined' || templateData === "" || templateData === null) {
                    modalInner = "<span>Шаблон пуст или поврежден!</span>";
                } else {
                    let includes = templateData.match(/{%.+?%}/g);

                    $.each(includes, function (i, include) {
                        let change = include.replace(/{%/, '').replace(/%}/, '').split('|');
                        let element = templateInput.clone();
                        $(element).find('label').text(change[1]);
                        $(element).find('input').attr('name', change[0]).attr('placeholder', change[1]);
                        if (typeof jsonData[change[0]] !== "undefined") {
                            $(element).find('input').val(jsonData[change[0]]);
                        }
                        modalInner.append(element);
                    });
                }
                modalInner.attr('data-template', templateName);
                if (typeof jsonData.id !== "undefined") {
                    modalInner.attr('data-id', jsonData.id);
                }

                this.modal.addTemplate('codes', $(this.codes.codesModalTemplate()).append(modalInner));
                this.modal.load('codes', templateData.name, 600);

                this.modal.createCancelButton();
                let actionButton = this.modal.createActionButton('Сохранить');
                this.button.addCallback(actionButton, this.codes.insert);
                this.selection.save();
                this.modal.show();
            },
            insert: function () {
                let modalInner = $(this.modal.getModal());
                let items = this.opts.templates || [];
                this.selection.restore();

                var insert = {};
                $.each($(modalInner).find('.item'), function (i, item) {
                    let input = $(item).find('input');
                    insert[input.attr('name')] = input.val()
                });
                let templateName = $(modalInner).find('div[data-template]').data('template');
                let templateID   = $(modalInner).find('div[data-id]').data('id');

                let toSave = {
                    WidgetTemplate: {
                        content: items[templateName]['content'],
                        fields: insert,
                        name: templateName,
                        parent: items[templateName]['id'],
                        title: items[templateName]['name'],
                    }
                };

                if (typeof templateID !== "undefined" && templateID > 0) {
                    toSave.WidgetTemplate.id = templateID;
                    toSave.id = templateID;
                }

                this.codes.saveTemplate(toSave, $.proxy(this.codes.onSaveCallback, this));
            },
            matchesFromHtml: function(html) {
                html = $(html);
                let contentStr = "";
                $.each(html, function (i, element) {
                    if ($(element).hasClass('redactor-visual')) {
                        contentStr += tools.atou($(element).data('json'));
                    }
                });
                return contentStr.replace( /<[^p].*?>/g, '' );
            },
            saveTemplate(template, handler) {
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
            },
            onSaveCallback: function (data) {
                if (typeof data.error === "undefined" && typeof data.fields !== "undefined" && typeof data.id !== "undefined") {
                    let fields = data.fields;
                    fields.id = data.id;
                    fields.name = data.name;
                    fields.title = data.title;

                    let section = this.codes.wrapMatch(JSON.stringify(fields));
                    if (this.codes.mode === this.codes.params().modeInsert) {
                        this.insert.html(section, false);
                    } else if (this.codes.mode === this.codes.params().modeUpdate) {
                        let code;
                        if (this.codes.params().visualise === 1) {
                            code = $(this.core.getEditor()).html();
                            let curMatchHtml = this.codes.currentMatch.prop('outerHTML');
                            section = section.replace(new RegExp('<br>', 'g'), '');
                            this.insert.set(code.replace(curMatchHtml, section), false);
                        } else {
                            code = this.clean.stripTags(this.code.get());
                            this.insert.set(code.replace(this.codes.currentMatch, JSON.stringify(fields)));
                        }
                    }
                    this.modal.close();
                    this.code.sync();
                }
                return true;
            },
            /**   VISUAL BLOCKS  ***/
            wrap: function () {
                if (this.codes.params().visualise === 1) {
                    //let code = this.clean.stripTags(this.code.get())
                    let code = $(this.core.getEditor()).html()
                        //, templateFunc = this.codes.template
                        , wrapMatch = this.codes.wrapMatch
                        , matches = code.match(/{.+?}/g)
                       // , visual = ''
                        , visual = code
                    ;
                    $.each(matches, function (i, match) {
                        let w = wrapMatch(match);
                        visual = visual.replace(match, w);
                        //visual += wrapMatch(match);
                    });
                    //this.insert.set(code.replace(code, visual), 0);
                    this.insert.set(visual, 0);
                    this.code.sync();
                }
            },
            wrapMatch: function (match) {
                if (this.codes.params().visualise === 1) {
                    let b = this.codes.template(match);
                    //return '<br>' + b.outerHTML + '<br>';
                    return b.outerHTML;
                }
                return match;
            },
            template: function (dataJson) {
                let data = JSON.parse(dataJson)
                    , title = data.title || "Блок";

                let b = $('<section>', {
                    'data-json': tools.utoa(dataJson),
                    class : 'redactor-visual'
                });
                b.append($(document.createElement('strong')).text(title));
                return b[0];
            }
        };
    };
})(jQuery);