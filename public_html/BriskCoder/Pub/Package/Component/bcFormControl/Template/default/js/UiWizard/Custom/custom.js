bc.ready(function () {
    if (bc.selector('.bcFormControl-custom-uri').length()) {
        var uri = bc.selector('.bcFormControl-custom-uri').getValue();
        bc.selector('.bcFormControl-custom-button').event('click', function (e) {
            e.preventDefault();
            alert('todo: serialize and then post with ajax');
        });
    }
});