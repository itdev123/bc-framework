/**
 * bc
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     bc JS
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2015 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

var bcTabs = {
    thisNode: [],
    version: '1.0',
    selector: function (sel) {
        bc.selector(sel);
        bcDatePicker.thisNode = bc.thisNode;
        var loop = function (el, fn) {
            Array.prototype.forEach.call(el, function (e, i) {
                fn(e, i);
            });
        };
        if (typeof sel === 'string') {
            if (sel.charAt(0) === '<') {
                bc.thisNode = [document.createElement('div').innerHTML = sel];
            } else {
                if (sel.indexOf(':first-child') > -1) {
                    _sel = document.querySelectorAll(sel.replace(':first-child', ''));
                    if (_sel[0]) {
                        loop(_sel, function (el, i) {
                            bc.thisNode[i] = el.firstElementChild;
                        });
                    } else {
                        bc.thisNode = [];
                    }
                } else if (sel.indexOf(':last-child') > -1) {
                    _sel = document.querySelectorAll(sel.replace(':last-child', ''));
                    if (_sel[0]) {
                        loop(_sel, function (el, i) {
                            bc.thisNode[i] = el.lastElementChild;
                        });
                    } else {
                        bc.thisNode = [];
                    }
                } else {
                    _sel = document.querySelectorAll(sel);
                    if (_sel[0]) {
                        bc.thisNode = _sel;
                    } else {
                        bc.thisNode = [];
                    }
                }
            }
        } else {
            bc.thisNode = [sel];
        }

        var BriskCoderTabs = {
            /**
             * Create tabs
             * @param {obj} ie: <br>
             * obj.tabs = 'vtabs'|'htabs'. Vertical or Horizontal Tabs. Default is htabs <br>
             * obj.tabHeader = 'tabHeaderElement'. '.className'|'#idName' ...
             * obj.tabContent = 'tabContentElement'. '.className'|'#idName' ...
             * @return {String}
             */
            tabs: function (options) {
                options = options || {}; //must be object  
                options.tabs = options.tabs || 'htabs';
                options.tabHeader = options.tabHeader || '';
                options.tabContent = options.tabContent || '';
                loop(bc.thisNode, function (el, i) {
                    bc.selector(el).addClass('bc-tabs-container');
                    var totalItems = 0;
                    var dataHeaderID = options.tabHeader + '-tab-' + i;
                    var dataContentID = options.tabContent + '-tab-content-' + i;
                    bc.selector(el).children().each(function (e) {//looping selector childrens to find (this) children   
                        if (bc.selector(e).is(options.tabHeader)) {
                            if (options.tabs === 'vtabs') {
                                bc.selector(options.tabHeader).addClass('bc-vtabs-header');
                            } else {
                                bc.selector(options.tabHeader).addClass('bc-htabs-header');
                                bc.selector(options.tabHeader).children().each(function (e) {
                                    bc.selector(e).addClass('bc-htabs');
                                });
                            }
                            bc.selector(e).children().each(function (e) {
                                totalItems++;
                                var data = [];
                                data['data-id'] = dataHeaderID + '_' + totalItems;
                                bc.selector(e).addClass('bc-tabs').setAttribute(data); // adding ids     
                                if (bc.selector(e).getAttribute('data-id') === dataHeaderID + '_1') {
                                    bc.selector(e).addClass('tab-active');
                                }
                            });
                        }
                        totalItems = 0;
                        if (bc.selector(e).is(options.tabContent)) {
                            if (options.tabs === 'vtabs') {
                                bc.selector(options.tabContent).addClass('bc-vtabs-content');
                            }
                            bc.selector(e).children().each(function (e) {
                                bc.selector(e).hide();
                                totalItems++;
                                var data = [];
                                data['data-id'] = dataContentID + '_' + totalItems;
                                bc.selector(e).setAttribute(data); // adding ids   
                                if (bc.selector(e).getAttribute('data-id') === dataContentID + '_1') {
                                    bc.selector(e).addClass('tab-content-active').show();
                                }
                            });
                        }
                        bc.selector('.bc-tabs').event('click', function () {
                            var $this = bc.thisNode;
                            if (bc.selector($this).hasClass('tab-active')) {
                                return false;
                            }
                            bc.selector($this).parent().children().removeClass('tab-active');
                            bc.selector($this).addClass('tab-active');
                            var id = bc.selector($this).getAttribute('data-id').split('_');
                            bc.selector($this).parent().next().children().each(function (e) {
                                bc.selector(e).removeClass('tab-content-active').hide();
                                if (bc.selector(e).getAttribute('data-id') === dataContentID + '_' + id[1]) {
                                    bc.selector(e).addClass('tab-content-active').show();
                                }
                            });
                        });
                    });
                });
            }
        };
        return BriskCoderTabs;
    }
};