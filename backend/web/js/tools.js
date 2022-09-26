const tools = (function () {
    function utoa(str) {
        return window.btoa(unescape(encodeURIComponent(str)));
    }
// base64 encoded ascii to ucs-2 string
    function atou(str) {
        return decodeURIComponent(escape(window.atob(str)));
    }

    return {
        utoa: utoa,
        atou: atou
    };
})();