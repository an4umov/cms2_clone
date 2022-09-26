$(function () {

    let tree = $("#menu_tree"),
        currentKey = tree.data('key')
    ;


    $("#menu_tree").on('treeview.beforeselect', function(event, key, jqXHR, settings) {
        console.log('treeview.beforeselect');
    });

    $("#menu_tree").on('treeview.selected', function(event, key, data, textStatus, jqXHR) {
        console.log('treeview.selected');
    });



    $("#menu_tree").on('treeview.selectcomplete', function(event, jqXHR) {
        console.log('treeview.selectcomplete');
        console.dir([event, jqXHR]);
    });


});