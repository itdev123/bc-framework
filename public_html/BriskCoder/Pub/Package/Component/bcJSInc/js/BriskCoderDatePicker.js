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

var bcDatePicker = {
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

        var BriskCoderDatePicker = {
            /**
             * Date Picker
             * @param {obj} options
             * datepicker({
             *      locale: 'en-UK',
             *      readonly: true,
             * });
             * Set locale to build calendar by language.
             * If Selector input is readonly set it to true.
             * @return {bc.selector.BriskCoder}
             */
            calendar: function (options) {
                options = options || {}; //must be object    
                options.locale = options.locale || navigator.language;
                options.readonly = options.readonly || false;
                var localeString = function (d, opts) {
                    return d.toLocaleString(options.locale, opts);
                };
                var getDaysInMonth = function (month, year) {
                    var date = new Date(year, month, 1);
                    var days = [];
                    while (date.getMonth() === month) {
                        days.push(new Date(date));
                        date.setDate(date.getDate() + 1);
                    }
                    return days;
                };
                var createDays = function (currDay, _days) {
                    var html = '<table class="bc-datepicker-tbl-days">';
                    loop(_days, function (day) {
                        if (day % 7 === 7) {
                            html += '<tr>';
                        }
                        var cls = (currDay == day) ? 'selected' : '';
                        html += '<td><span class="bc-datepicker-day ' + cls + '">' + day + '</span></td>';
                        if (day % 7 === 0) {
                            html += '</tr>';
                        }
                    });
                    html += '</table>';
                    return html;
                };
                var datepickerDay = function () {
                    bc.selector('.bc-datepicker-day').event('click', function () {
                        var $this = bc.thisNode;
                        bc.selector($this).closest('.bc-datepicker-tbl-days').children('.bc-datepicker-day').removeClass('selected');
                        bc.selector($this).addClass('selected');
                        currDay = bc.selector($this).getText();
                        var currMonth = bc.selector($this).closest('.bc-datepicker-days').prev('.bc-datepicker-controls').children('.curr-month').getValue();
                        var currYear = bc.selector($this).closest('.bc-datepicker-days').prev('.bc-datepicker-controls').children('.curr-year').getValue();
                        var date = new Date(currYear, (parseInt(currMonth) - 1), currDay);
                        bc.selector($this).closest('.bc-datepicker-wrapper').prev().setValue(localeString(date, {year: 'numeric', month: 'numeric', day: 'numeric'}));
                        bc.selector($this).closest('.bc-datepicker-wrapper').addClass('hidden');
                    });
                };
                loop(bc.thisNode, function (el) {
                    var date = new Date();
                    var _days = [];
                    var currDay = localeString(date, {day: 'numeric'});
                    var month = localeString(date, {month: 'numeric'});
                    var monthYear = localeString(date, {month: 'long', year: 'numeric'});
                    var year = localeString(date, {year: 'numeric'});
                    var _d = getDaysInMonth(parseInt(month - 1), parseInt(year));
                    loop(_d, function (v, i) {
                        _days.push(v.getDate());
                    });
                    var _atrr = [];
                    if (options.readonly) {
                        _atrr['readonly'] = 'readonly';
                    }
                    var html = '<div class="bc-datepicker-wrapper hidden" style="width:' + bc.selector(el).getWidth() + 'px;">';
                    html += '<div class="bc-datepicker-controls"><span class="bc-datepicker-controls-l use-selec-none"><</span>';
                    html += '<span class="bc-datepicker-month">' + monthYear + '<input type="hidden" name="curr_month" value="' + month + '" class="curr-month" ><input type="hidden" name="curr_year" value="' + year + '" class="curr-year" ></span>';
                    html += '<span class="bc-datepicker-controls-r use-selec-none">></span></div>';
                    html += '<div class="bc-datepicker-days">';
                    html += createDays(currDay, _days);
                    html += '</div></div>';
                    bc.selector(el).addClass('bc-datepicker').setAttribute(_atrr).after(html);
                    bc.selector(el).event('focusin', function () {
                        var $this = bc.thisNode;
                        bc.selector('.bc-datepicker-wrapper').addClass('hidden');
                        bc.selector($this).next().removeClass('hidden');
                    });
                    bc.selector('html').event('click', function () {
                        bc.selector('.bc-datepicker-wrapper').addClass('hidden');
                    });
                    bc.selector(el).event('click', function (e) {
                        e.stopPropagation();
                    });
                    bc.selector('.bc-datepicker-wrapper').event('click', function (e) {
                        e.stopPropagation();
                    });
                    datepickerDay();
                    bc.selector('.bc-datepicker-controls-r, .bc-datepicker-controls-l').event('click', function () {
                        var $this = bc.thisNode;
                        if (bc.selector($this).hasClass('bc-datepicker-controls-r')) {
                            month = parseInt(month) + 1;
                            if (month > 12) {
                                month = 1;
                                year = parseInt(year) + 1;
                            }
                        } else {
                            month = parseInt(month) - 1;
                            if (month < 1) {
                                month = 12;
                                year = parseInt(year) - 1;
                            }
                        }
                        var date = new Date(year, (month - 1));
                        monthYear = localeString(date, {month: 'long', year: 'numeric'});
                        year = localeString(date, {year: 'numeric'});
                        _d = getDaysInMonth(parseInt(month - 1), parseInt(year));
                        _days = [];
                        loop(_d, function (v, i) {
                            _days.push(v.getDate());
                        });
                        if (bc.selector($this).hasClass('bc-datepicker-controls-r')) {
                            bc.selector($this).prev().setHTML(monthYear + '<input type="hidden" name="curr_month" value="' + month + '" class="curr-month" ><input type="hidden" name="curr_year" value="' + year + '" class="curr-year" >');
                        } else {
                            bc.selector($this).next().setHTML(monthYear + '<input type="hidden" name="curr_month" value="' + month + '" class="curr-month" ><input type="hidden" name="curr_year" value="' + year + '" class="curr-year" >');
                        }
                        bc.selector($this).closest('.bc-datepicker-wrapper').children('.bc-datepicker-days').setHTML(createDays(currDay, _days));
                        datepickerDay();
                    });
                });
                return BriskCoderDatePicker;
            }
        };
        return BriskCoderDatePicker;
    }
};