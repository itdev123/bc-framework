bc.ready(function () {
    if (bc.selector('.bcFormControl-login-uri').length()) {
        var uri = bc.selector('.bcFormControl-login-uri').getValue();
        bc.selector('.bcFormControl-login-button').event('click', function (e) {
            e.preventDefault();
            var data = bc.selector(bc.thisNode).closest('form').serialize(true);
            console.log(data);
            // alert('todo: serialize and then post with ajax');
        });
    }
});