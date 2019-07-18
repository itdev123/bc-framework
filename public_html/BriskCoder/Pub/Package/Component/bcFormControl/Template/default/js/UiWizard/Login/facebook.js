bc.ready(function () {
    /*Login With Facebook*/
    if (bc.selector('.bcFormControl-login-fb').length()) {
        var appID = bc.selector('.bcFormControl-login-fb').getAttribute('data-bcFormControl-login-fb-appid');
        var c = bc.selector('.bcFormControl-login-fb').getAttribute('data-bcFormControl-login-callback');
        var callback = (c !== '') ? c : window.location.href;
        var redirect = bc.selector('.bcFormControl-login-fb').getAttribute('data-bcFormControl-login-redirect');
        function  bcFacebookCheckLoginState(click)
        {
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    var signed_request = response.authResponse.signedRequest;
                    var access_token = response.authResponse.accessToken;
                    bc.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: callback,
                        data: {app: 'facebook', response: true, redirect: redirect, access_token: access_token, signed_request: signed_request},
                        success: function (response) {
                            if (response['redirect']) {
                                window.location.href = redirect;
                            }
                        }
                    });
                } else if (response.status === 'not_authorized') {
                    // The person is logged into Facebook, but not your app.
                    bc.ajax({
                        type: 'POST',
                        url: callback,
                        data: {app: 'facebook', response: false}
                    });
                    if (bc.selector("#bcFormControl-login-fb-msg").length()) {
                        bc.selector("#bcFormControl-login-fb-msg").show();
                    }
                    window.location.href = callback;
                } else {
                    //Normal Status: not logged in
                    // The person is not logged into Facebook, so we're not sure if
                    // they are logged into this app or not.
                }
            });
        }
        window.fbAsyncInit = function () {
            FB.init({
                appId: appID,
                status: true,
                cookie: true,
                xfbml: true,
                version: 'v2.5'
            });
            bc.selector('.bcFormControl-login-fb').event('click', function () {
                FB.getLoginStatus(function (response) {
                    FB.login(function () {
                        bcFacebookCheckLoginState(true);
                    }, {scope: 'public_profile,email'});
                });
            });
            /*bcFacebookCheckLoginState()*/
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = '//connect.facebook.net/en_US/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        bc.selector('#bcFormControl-login-fb-msg .button-close, #bcFormControl-login-fb-msg .button-confirm').event('click', function () {
            bc.selector("#bcFormControl-login-fb-msg").hide();
        });
    }
});