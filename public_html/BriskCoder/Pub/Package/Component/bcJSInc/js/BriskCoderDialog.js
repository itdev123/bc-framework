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

var bcDialog = {
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

        var BriskCoderDialog = {
            /**
             * Dialog Box
             * @param {obj} options
             * If using trigger add DISABLED ATTRIBUTE to stop dialog to open
             * @return {bc.selector.BriskCoder}
             */
            box: function (options) {
                options = options || {}; //must be object  
                options.hideCloseButton = options.hideCloseButton || false;
                options.buttons = options.buttons || {};
                options.buttonText = options.buttonText || false;
                options.close = options.close || false;
                options.trigger = options.trigger || false;
                options.triggerEvent = options.triggerEvent || 'click';
                options.triggerFN = options.triggerFN || function () {
                };
                loop(bc.thisNode, function (el, i) {
                    i = bc.selector('.bc-js-dialog').length();

                    function dialog(originalEl) {
                        var html = '<div class="bc-js-dialog" id="bc-js-dialog-' + i + '">';
                        html += '       <div class="bc-js-dialog-inner">';
                        html += '       <div class="bc-js-dialog-header">';
                        html += '           <span class="bc-js-dialog-header-title">' + bc.selector(el).getAttribute('title') + '</span>';
                        if (!options.hideCloseButton) {
                            html += '           <button type="button" class="bc-js-dialog-header-button">';
                            html += '               <span class="bc-js-dialog-header-button-img">x</span>';
                            if (options.buttonText !== false) {
                                html += '               <span class="bc-js-dialog-header-button-text">' + options.buttonText + '</span>';
                            }
                            html += '           </button>';
                        }
                        html += '       </div>';
                        html += '       <div class="bc-js-dialog-contents"></div>';
                        html += '       <div class="bc-js-dialog-buttons">';
                        for (var btnName in options.buttons) {
                            html += '           <button type="button" class="bc-js-dialog-button" data-bc-js-dialog-button="' + btnName + '" >' + btnName + '</button>';
                        }
                        html += '       </div>';
                        html += '   </div>';
                        html += '</div>';
                        bc.selector(el).before(html).remove();
                        if (!options.trigger) {
                            bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-contents').setHTML('');
                            bc.selector(originalEl).appendTo('#bc-js-dialog-' + i + ' .bc-js-dialog-contents');
                        }
                    }

                    bc.selector(el).clone(true);
                    var originalEl = bc.thisNode[0];
                    dialog(originalEl);
                    var btnEL = el;
                    if (options.trigger) {
                        bc.selector('#bc-js-dialog-' + i).hide();
                        bc.selector(document).event(options.triggerEvent, options.trigger, function (e) {
                            e.preventDefault();
                            btnEL = bc.thisNode;
                            options.triggerFN(btnEL);
                            if (!bc.selector(btnEL).getAttribute('disabled')) {
                                bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-contents').setHTML('');
                                bc.selector(originalEl).appendTo('#bc-js-dialog-' + i + ' .bc-js-dialog-contents');
                                bc.selector('#bc-js-dialog-' + i).show();
                            }
                        });
                    }

                    bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-button').event('click', function () {
                        var name = bc.selector(bc.thisNode).getAttribute('data-bc-js-dialog-button');
                        if (typeof options.buttons !== "undefined") {
                            options.buttons[name](btnEL);
                            if (options.close) {
                                bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-contents').setHTML('');
                                bc.selector('#bc-js-dialog-' + i).hide();
                            }
                        }
                    });
                    bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-header-button').event('click', function () {
                        bc.selector('#bc-js-dialog-' + i + ' .bc-js-dialog-contents').setHTML('');
                        bc.selector('#bc-js-dialog-' + i).hide();
                    });
                });
            }
        };
        return BriskCoderDialog;
    }
};