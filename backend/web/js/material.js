/* global tools */
$(function () {

    let material = $('.material_save')//$("[data-main]")
        , form = material.parents('form')
        //, content = $('#tinymce')
        , content = $('document').find('#tinymce')
        , contentStr = ""
    ;

    //let x = tinyMCE.activeEditor.getContent();


    material.on('click', function (e) {
        e.preventDefault();

        if (tinyMCE.activeEditor === null) {
            form.submit();
        }

        // if ($(this).data('main') !== 1) {
        //     form.submit();
        // }

        let contentText = tinyMCE.activeEditor.getContent()
            , contentHtml = $(contentText)
        ;



        $.each(contentHtml, function (i, element) {
            if ($(element).hasClass('redactor-visual')) {
                let dataJson = tools.atou($(element).data('json'));
                contentStr += tools.atou($(element).data('json'));
                ///content.val(contentStr.replace( /<[^p].*?>/g, '' ));

                let elementAsText  = element.outerHTML, change = dataJson.replace( /<[^p].*?>/g, '' );
                contentText = contentText.replace(elementAsText, change);

            }
        });
        tinyMCE.activeEditor.setContent(contentText);
        form.submit();
    });









    // let material = $('.material_save')//$("[data-main]")
    //     , form = material.parents('form')
    //     , content = $('#material-content')
    //     , contentStr = ""
    // ;
    //
    // material.on('click', function (e) {
    //     e.preventDefault();
    //
    //     // if ($(this).data('main') !== 1) {
    //     //     form.submit();
    //     // }
    //
    //     let contentText = content.val()
    //         , contentHtml = $(contentText)
    //     ;
    //
    //     $.each(contentHtml, function (i, element) {
    //         if ($(element).hasClass('redactor-visual')) {
    //             let dataJson = tools.atou($(element).data('json'));
    //             contentStr += tools.atou($(element).data('json'));
    //             ///content.val(contentStr.replace( /<[^p].*?>/g, '' ));
    //
    //             let elementAsText  = element.outerHTML, change = dataJson.replace( /<[^p].*?>/g, '' );
    //             contentText = contentText.replace(elementAsText, change);
    //
    //         }
    //     });
    //     content.val(contentText);
    //     form.submit();
    // });
});