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

var bcUploader = {
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

        var BriskCoderUpload = {
            /**
             * Upload Files
             * @param {obj} options
             * {options.url,
             * options.fileExt,
             * options.stop,
             * options.success}
             * @return {undefined}
             */
            upload: function (options)
            {
                options = options || {}; //must be object  
                options.url = options.url || null;
                options.fileExt = options.fileExt || [];
                options.stop = options.stop || false;
                options.success = options.success || function () {
                };
                options.error = options.error || function () {
                };
                loop(bc.thisNode, function (el, i) {
                    bc.selector(el).addClass('bc-fileUploader');
                    bc.selector(el).event("change", function (evt) {
                        var $this = bc.thisNode;
                        var formData = new FormData();
                        var files = $this.files;
                        var len = files.length;

                        for (var i = 0; i < len; i++) {
                            var file = files[i];
                            var fileInfo = file.type.split('/');
                            var fileExt = fileInfo[1];
                            if (options.fileExt.length && bc.inArray(fileExt, options.fileExt) === -1) {
                                options.error('fileExt');
                                bc.selector($this).setValue('');
                                return false;
                            }
                            if (formData) {
                                formData.append(bc.selector(el).getAttribute('name'), file);
                            }
                        }
                        if (options.url) {
                            formData.append('upload', true);
                            bc.ajax({
                                url: options.url,
                                type: 'POST',
                                dataType: 'json',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (res) {
                                    options.success(res, el);
                                }
                            });
                        }
                    });
                });
            }
        };
        return BriskCoderUpload;
    }
};