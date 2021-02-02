
function setCookie(name, value, expire) {
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() + expire);
    document.cookie = name + "=" + escape(value) + "; expires=" + expireDate.toGMTString() + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function deleteCookie(cookiname) {
    var d = new Date();
    d.setDate(d.getDate() - 1);
    var expires = ";expires=" + d;
    var value = "";
    document.cookie = cookiname + "=" + value + expires + "; path=/";
}