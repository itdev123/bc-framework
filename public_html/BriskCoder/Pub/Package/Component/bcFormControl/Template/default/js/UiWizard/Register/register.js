bc.ready(function () {
    if (bc.selector('.bcFormControl-register-uri').length()) {
        var uri = bc.selector('.bcFormControl-register-uri').getValue();
        bc.selector('.bcFormControl-register-button').event('click', function (e) {
            e.preventDefault();
            alert('todo: serialize and then post with ajax');
        });
    }
});