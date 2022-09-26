let TreeView = function () {
    return {
        init: function (dataSource) {
            $('#department-tree').tree({
                selectable: false,
                cacheItems: false,
                dataSource: dataSource,
                loadingHTML: '<img src="/img/input-spinner.gif" alt=""/>'
            });
        }
    };
}();

let DataSourceTree = function (options) {
    this._data  = options.data;
    this._delay = options.delay;
};

DataSourceTree.prototype = {
    data: function (options, callback) {
        let self = this;

        setTimeout(function () {
            let data = $.extend(true, [], self._data);

            callback({ data: data });

        }, this._delay)
    }
};