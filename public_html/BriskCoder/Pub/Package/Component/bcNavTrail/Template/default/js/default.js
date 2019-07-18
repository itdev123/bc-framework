bc.ready(function () {

    bc.selector('.bcNavTrail-attr-img').event('click', function () {
        var param = bc.selector(bc.thisNode).parent().getAttribute('data-url-param');
        var currUrl = window.location.href;
        var fullQS = '';
        var repQS = '';

        bc.selector('.bcNavTrail-attr').each(function (e) {                 
            fullQS += bc.selector(e).getAttribute('data-url-param');
        });
        
        //treating non get query strings
        var glue = param.substring(1, param.length);
        var lastChar = '';
        if (glue !== '&') {
            lastChar = currUrl.substring(currUrl.length - 1, currUrl.length);
            if (lastChar === '/') {
                currUrl = currUrl.substring(currUrl, currUrl.length - 1);
            } else {
                lastChar = '';
            }
        }
        repQS = fullQS.replace(param, '');
        repQS = repQS.substring(1, repQS.length);
        fullQS = fullQS.substring(1, fullQS.length);
        var urlNoQS = currUrl.replace(fullQS, '');
        var redir = repQS === '' ? urlNoQS.substring(urlNoQS, urlNoQS.length - 1) : urlNoQS + repQS;

        window.location = redir + lastChar;
    });
});