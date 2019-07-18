var bcNavPager = {
    pageSelector: function (val, url, total)
    {
        if (val.length === 0)
            return;
        val = (val > parseInt(total)) ? total : val;
        val = (val < 1) ? 1 : val;
        window.location = url.replace('{page}', val);
    },
    pageSizeSelector: function (val, url) {
        window.location = url.replace('{limit}', val);
    }
};
bc.ready(function () {

    if (!bc.selector('.bcNavPager-btn-current').length()) {
        if (bc.selector('.bcNavPager-page-selector').length()) {
            bc.selector('.bcNavPager-page-selector').each(function (e) {
                var curr = bc.selector(e).getAttribute('data-bcnavpager-total-pages');
                if (curr < bc.selector(e).getValue() && bc.selector(e).getValue() > 1) {
                    var url = bc.selector(e).getAttribute('data-bcNavPager-page-selector-url');
                    window.location = url.replace('{page}', 1);
                }
            });
        }
    }

    bc.selector('.bcNavPager-page-selector-btn').event('click', function () {
        var $this = bc.thisNode;
        var total = bc.selector($this).prev().getAttribute('data-bcnavpager-total-pages');
        bcNavPager.pageSelector(bc.selector($this).prev().getValue(), bc.selector($this).prev().getAttribute('data-bcNavPager-page-selector-url'), total);
    });

    bc.selector('.bcNavPager-page-selector').event('keypress', function (e) {
        if (e.keyCode === 13) {
            var $this = bc.thisNode;
            var total = bc.selector($this).getAttribute('data-bcnavpager-total-pages');
            bcNavPager.pageSelector(bc.selector($this).getValue(), bc.selector($this).getAttribute('data-bcNavPager-page-selector-url'), total);
        }
    });

    var pageVal = '';
    bc.selector('.bcNavPager-page-selector').event('focusin', function () {
        var $this = bc.thisNode;
        pageVal = bc.selector($this).getValue();
        bc.selector($this).getValue('');
    });

    bc.selector('.bcNavPager-page-selector').event('focusout', function () {
        var $this = bc.thisNode;
        if (bc.selector($this).getValue() === '') {
            bc.selector($this).getValue(pageVal);
        }
    });

    if (bc.selector('.bcNavPager-page-size-selector').length()) {
        if (bc.selector('.bcNavPager-page-size-selector').is('select')) {
            bc.selector('.bcNavPager-page-size-selector').event('change', function () {
                var $this = bc.thisNode;
                bcNavPager.pageSizeSelector(bc.selector($this).getValue(), bc.selector($this).getAttribute('data-bcnavpager-page-size-selector-url'));
            });
        } else {
            bc.selector('body').event('click', function () {
                bc.selector('.bcNavPager-page-size-selector-list').hide();
            });
            var show = false;
            bc.selector('.bcNavPager-page-size-selector').event('click', function (e) {
                e.stopPropagation();
                var $this = bc.thisNode;
                if (show) {
                    bc.selector($this).next().hide();
                    show = false;
                    return;
                }
                bc.selector($this).next().show();
                show = true;
            });
            bc.selector('.bcNavPager-page-size-selector-list > li').event('click', function () {
                var $this = bc.thisNode;
                bcNavPager.pageSizeSelector(bc.selector($this).getText(), bc.selector($this).parent().prev().getAttribute('data-bcnavpager-page-size-selector-url'));
            });
        }
    }

});