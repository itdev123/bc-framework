bc.ready(function () {
    if (bc.selector('.bcFormControl-contact-uri').length()) {
        var uri = bc.selector('.bcFormControl-contact-uri').getValue();
        bc.selector('.bcFormControl-contact-button').event('click', function (e) {
            e.preventDefault();
            alert('todo: serialize and then post with ajax');
        });
    }
});