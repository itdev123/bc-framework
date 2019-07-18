var bcGoogleUser = {};
var bcGoogleStartApp = function () {
    var clientID = bc.selector(".bcFormControl-login-g").getAttribute("data-bcFormControl-login-google-clientid");
    gapi.load("auth2", function () {
        auth2 = gapi.auth2.init({
            client_id: clientID + '.apps.googleusercontent.com',
            cookiepolicy: "single_host_origin",
            scope: "https://www.googleapis.com/auth/plus.login"
        });
//        auth2.then(function (authInstance) {
//            var response = authInstance.currentUser.get().getAuthResponse();
//            var id_token = response.id_token;
//            if (typeof id_token !== 'undefined') {
//                bcGoogleOnSucces(id_token);
//            }
//        }, function (error) {
//            bcGoogleOnFailure(error);
//        });
        bcGoogleAttachSignin(document.getElementById("bcFormControl-login-g"));
    });
};
function bcGoogleAttachSignin(element) {
    auth2.attachClickHandler(element, {},
            function (bcGoogleUser) {
                var id_token = bcGoogleUser.getAuthResponse().id_token;
                bcGoogleOnSucces(id_token);
            },
            function (error) {
                bcGoogleOnFailure(error);
            }
    );
}
function bcGoogleOnSucces(id_token) {
    var c = bc.selector('.bcFormControl-login-g').getAttribute('data-bcFormControl-login-callback');
    var callback = (c !== '') ? c : window.location.href;
    var redirect = bc.selector('.bcFormControl-login-g').getAttribute('data-bcFormControl-login-redirect');
    bc.ajax({
        type: 'POST',
        dataType: 'json',
        url: callback,
        data: {app: 'google', response: true, redirect: redirect, id_token: id_token},
        success: function (response) {
            if (response['redirect']) {
                window.location.href = redirect;
            }
        }
    });
}
function bcGoogleOnFailure(error) {
    var c = bc.selector('.bcFormControl-login-g').getAttribute('data-bcFormControl-login-callback');
    var callback = (c !== '') ? c : window.location.href;
    bc.ajax({
        type: 'POST',
        url: callback,
        data: {app: 'google', response: false}
    });
    if (bc.selector("#bcFormControl-login-google-msg").length()) {
        bc.selector("#bcFormControl-login-google-msg").show();
    }
}
bc.ready(function () {
    /*Login With Google*/
    if (bc.selector(".bcFormControl-login-g").length()) {
        (function (d, s, id) {
            var js, gjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://apis.google.com/js/api:client.js?onload=bcGoogleStartApp";
            gjs.parentNode.insertBefore(js, gjs);
        }(document, 'script', 'google-oauth2'));
    }
});