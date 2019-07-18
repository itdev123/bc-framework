bc.ready(function () {
    if (bc.selector('.bcFormControl-login-t').length()) {
        /*Login With Twitter*/
        var c = bc.selector('.bcFormControl-login-t').getAttribute('data-bcFormControl-login-callback');
        var callback = (c !== '') ? c : window.location.href;
        bc.selector('.bcFormControl-login-t').event('click', function () {
            var newWindow = window.open('about:blank', '', 'toolbar=0, resizeble=1, width=400, height=300, top=20, left=20');
            bc.ajax({
                type: 'GET',
                url: window.location.href,
                dataType: 'json',
                data: {bc_twitter_login: true},
                success: function (response) {
                    if (response['redirect']) {
                        var oauth_token = response['oauth_token'];
                        var oauth_token_secret = response['oauth_token_secret'];
                        bc.ajax({
                            type: 'POST',
                            url: callback,
                            data: {app: 'twitter', response: true, oauth_token: oauth_token, oauth_token_secret: oauth_token_secret}
                        });
                        //   popupCenter(redirect, 'twitter', '900', '500');
                        newWindow.location.replace(response['redirect']);
                    }
                }
            });
        });
        if (getQueryStrByName('denied')) {
            bc.ajax({
                type: 'GET',
                url: window.location.href,
                dataType: 'json',
                data: {bc_twitter_login_status: true},
                success: function (response) {
                    bc.ajax({
                        type: 'POST',
                        url: callback,
                        data: {app: 'twitter', response: false}
                    });
                    if (response['message'].length) {
                        var opener = window.opener;
                        var oDom = opener.document;
                        var elem = oDom.getElementById("bcFormControl-login-twitter-msg");
                        bc.selector(elem).show();
                    }
                    window.close();
                }
            });
        }
        if (getQueryStrByName('oauth_token') && getQueryStrByName('oauth_verifier')) {
            var redirect = bc.selector('.bcFormControl-login-t').getAttribute('data-bcFormControl-login-redirect');
            var oauth_token = getQueryStrByName('oauth_token');
            var oauth_verifier = getQueryStrByName('oauth_verifier');
            bc.ajax({
                type: 'POST',
                dataType: 'json',
                url: callback,
                data: {app: 'twitter', response: true, redirect: redirect, oauth_token: oauth_token, oauth_verifier: oauth_verifier},
                success: function (response) {
                    if (response['redirect']) {
                        var opener = window.opener;
                        opener.location.href = redirect;
                    }
                    window.close();
                }
            });
        }

        bc.selector('#bcFormControl-login-twitter-msg .button-close, #bcFormControl-login-twitter-msg .button-confirm').event('click', function () {
            bc.selector("#bcFormControl-login-twitter-msg").hide();
            window.location = window.location.href;
        });
    }
});

function popupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

function getQueryStrByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}