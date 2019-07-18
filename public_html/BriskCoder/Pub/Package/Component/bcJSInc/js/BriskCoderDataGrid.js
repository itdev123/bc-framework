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

var bcDataGrid = {
    thisNode: [],
    version: '1.0',
    selector: function (sel) {
        bc.selector(sel);
        bcDataGrid.thisNode = bc.thisNode;
        var loop = function (el, fn) {
            Array.prototype.forEach.call(el, function (e, i) {
                fn(e, i);
            });
        };



        var BriskCoderDataGrid = {
            /**
             * Edit in Place
             * @param {obj} options ie:
             * editInPlace({
             *      event: 'dblclick|focus...' Default 'click',
             *      Set data-bc-file="true" on element if it is a file
             *      uploadURL: 'my/url/path' Set if using bc file upload
             *      uploadDirectory: 'mydirectory/' Set if using bc file upload
             *      url: 'my/url/path' Set path to send edit
             *      addtionalDataName: [id] addtional data to send with post,
             *      create a data on the element being edit, ie: data-id="1" and set only the name in addtionalDataName.
             *      Name and Value is being posted as default.
             *      success: function(data){} return data from edit ajax
             * });
             * @return {bc.selector.BriskCoder}
             */
            editInPlace: function (options) {
                options = options || {}; //must be object  
                options.event = options.event || 'click';
                options.uploadURL = options.uploadURL || '';
                options.uploadDirectory = options.uploadDirectory || '';
                options.url = options.url || '';
                options.addtionalDataName = options.addtionalDataName || [];
                options.success = options.success || function () {
                };
                loop(bcDataGrid.thisNode, function (el, i) {
                    var readonly = [];
                    readonly['readonly'] = 'readonly';
                    bc.selector(el).setAttribute(readonly);
                    bc.selector(el).event(options.event, function () {
                        var $this = bc.thisNode;
                        bc.selector($this).removeAttribute('readonly');
                        if (bc.selector($this).getAttribute(['data-bc-file']) === 'true') {
                            bc.selector($this).parent().children('.bc-file').remove();
                            bc.selector($this).after('<input type="file" class="bc-file" style="display:none;">');
                            bc.selector($this).next('.bc-file').trigger('click');
                            bcUploader.selector($this).next('.bc-file').upload({
                                url: options.uploadURL,
                                success: function (res) {
                                    bc.selector($this).setValue(options.uploadDirectory + res.filename).trigger('change').next('.bc-file').remove();
                                }
                            });
                        }
                    });
                    bc.selector(el).event('change', function (e) {
                        var $this = bc.thisNode;
                        var readonly = [];
                        readonly['readonly'] = 'readonly';
                        bc.selector($this).setAttribute(readonly);
                        var name = bc.selector($this).getAttribute(['name']);
                        var obj = {};
                        loop(options.addtionalDataName, function (n) {
                            obj[n] = bc.selector($this).getAttribute(['data-' + n]);
                        });
                        obj[name] = bc.selector($this).getValue();
                        bc.ajax({
                            url: options.url,
                            type: 'POST',
                            dataType: 'json',
                            data: obj,
                            success: function (json) {
                                options.success(json);
                            }
                        });
                    });

                });
                return BriskCoderDataGrid;
            },
            /**
             * Hide Columns
             * @param {obj} options ie:
             * hideColumns({
             *      appendBtnTo: 'th' Append button to element .
             *      appendBtnToException: ':first-child' append to all appendBtnTo except this, for multiple separate by comma.
             *      triggerWrapper: 'wrapper' Wrapper that contains the column's checkboxes, it's opened when clicking on the appended button.
             *      trigger: 'checkboxes element' It must be checkboxes in the same order as the table columns to match indexes.
             * })
             * @return {bc.selector.BriskCoder}
             */
            hideColumns: function (options) {
                options = options || {}; //must be object  
                options.appendBtnTo = options.appendBtnTo || 'th';
                options.appendBtnToException = options.appendBtnToException || 'null';
                options.triggerWrapper = options.triggerWrapper || '';
                options.trigger = options.trigger || '';
                options.name = options.name || false;
                loop(bcDataGrid.thisNode, function (el, i) {
                    options.name = options.name ? options.name : i;
                    bc.selector(options.appendBtnTo).each(function (e) {
                        if (!bc.selector(e).is(options.appendBtnToException)) {
                            bc.selector(e).append('<span class="bc-hide-columns-btn bc-hide-columns-btn-' + i + '"></span>');
                        }
                    });
                    bc.selector(options.triggerWrapper).addClass('bc-hide-columns-wrapper').addClass('bc-hide-columns-wrapper-' + i).addClass('hidden');
                    bc.selector(options.trigger).addClass('bc-columns-trigger').addClass('bc-columns-trigger-' + i);
                    var btnWidth = bc.selector('.bc-hide-columns-btn-' + i).getWidth();
                    var storage = [];
                    storage[i] = [];
                    var columnsStorage = JSON.parse(localStorage.getItem("hideColumns-" + options.name));
                    if (columnsStorage) {
                        storage = columnsStorage;
                        var checked = [];
                        checked['checked'] = 'checked';
                        bc.selector('.bc-columns-trigger-' + i).setAttribute(checked);
                        for (var key in columnsStorage[i]) {
                            var index = columnsStorage[i][key];
                            bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').addClass('hidden');
                            bc.selector('.bc-columns-trigger-' + i).each(function (e) {
                                if (bc.selector(e).getValue() === index) {
                                    bc.selector(e).removeAttribute('checked');
                                }
                            });
                        }
                    } else {
                        bc.selector('.bc-columns-trigger-' + i).each(function ($this) {
                            if (!bc.selector($this).getAttribute(['checked'])) {
                                var index = bc.selector($this).getValue();
                                if (!bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').hasClass('hidden')) {
                                    bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').addClass('hidden');
                                    var position = bc.selector('.bc-hide-columns-btn-' + i + '.open').position();
                                    var left = ((position.left + btnWidth) - bc.selector('.bc-hide-columns-wrapper-' + i).getWidth()) + 'px';
                                    bc.selector('.bc-hide-columns-wrapper-' + i).setStyle({left: left});
                                    storage[i].push(index);
                                    localStorage.setItem("hideColumns-" + options.name, JSON.stringify(storage));
                                }
                            }
                        });
                    }
                    bc.selector('.bc-hide-columns-btn-' + i).event('click', function () {
                        var $this = bc.thisNode;
                        if (bc.selector($this).hasClass('open')) {
                            bc.selector('.bc-hide-columns-btn-' + i).removeClass('open');
                            bc.selector('.bc-hide-columns-wrapper-' + i).addClass('hidden');
                            return;
                        }
                        bc.selector('.bc-hide-columns-wrapper-' + i).removeClass('hidden');
                        var position = bc.selector($this).position();
                        var top = (position.top - bc.selector('.bc-hide-columns-btn-' + i).getHeight()) + 'px';
                        var left = ((position.left + btnWidth) - bc.selector('.bc-hide-columns-wrapper-' + i).getWidth()) + 'px';
                        bc.selector('.bc-hide-columns-wrapper-' + i).setStyle({top: top, left: left});
                        bc.selector('.bc-hide-columns-btn-' + i).removeClass('open');
                        bc.selector($this).addClass('open');
                    });

                    var idx = 0;
                    bc.selector('.bc-columns-trigger-' + i).event('click', function () {
                        var $this = bc.thisNode;
                        var index = bc.selector($this).getValue();
                        bc.selector('.bc-columns-trigger-' + i).each(function (e) {
                            if (bc.selector(e).getValue() === index) {
                                bc.selector(e).removeAttribute('checked');
                            }
                        });
                        if (bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').hasClass('hidden')) {
                            bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').removeClass('hidden');
                            var position = bc.selector('.bc-hide-columns-btn-' + i + '.open').position();
                            var left = ((position.left + btnWidth) - bc.selector('.bc-hide-columns-wrapper-' + i).getWidth()) + 'px';
                            bc.selector('.bc-hide-columns-wrapper-' + i).setStyle({left: left});

                            var s = storage[i];
                            storage[i] = [];
                            loop(s, function (val, k) {
                                if (index !== val) {
                                    storage[i].push(val);
                                }
                            });
                            idx--;
                        } else {
                            bc.selector(el).children('th:nth-child(' + index + '), td:nth-child(' + index + ')').addClass('hidden');
                            var position = bc.selector('.bc-hide-columns-btn-' + i + '.open').position();
                            var left = ((position.left + btnWidth) - bc.selector('.bc-hide-columns-wrapper-' + i).getWidth()) + 'px';
                            bc.selector('.bc-hide-columns-wrapper-' + i).setStyle({left: left});

                            storage[i].push(index);
                            idx++;
                        }
                        if (typeof (Storage) !== "undefined") {
                            if (idx === 0) {
                                storage[i] = [];
                            }
                            localStorage.setItem("hideColumns-" + options.name, JSON.stringify(storage));
                        }
                    });
                });
                return BriskCoderDataGrid;
            }
        };
        return BriskCoderDataGrid;
    }
};