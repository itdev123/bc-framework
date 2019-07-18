/**
 * bcFormControl
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     bcFormControl JS
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2015 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */
var bcFormControl = {
    thisNode: [],
    version: '1.0',
    /**
     * bcFormControl JS Reference
     */
    events: {
        /**
         * SET AUTO COMPLETE
         * @param {mixed} el Set identifier CLASS|ID|ELEMENT string or obj
         * @param {string} event Set event to trigger events auto complete ie: 'focusout'|'keyup'
         * @param {string} url Set request url
         * @param {string} method Set request method
         * @return {Boolean}
         */
        autoComplete: function (el, event, url, method) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        },
        /**
         * SET EDIT IN PLACE
         * @param {mixed} el Set identifier CLASS|ID|ELEMENT string or obj
         * @param {string} event Set event to trigger events edit in place ie: 'focusout'|'keyup'
         * @param {string} url Set request url
         * @param {string} method Set request method
         * @return {Boolean}
         */
        editInPlace: function (el, event, url, method) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        },
        /**
         * SET TRIGGER
         * @param {mixed} el Set identifier CLASS|ID|ELEMENT string or obj
         * @param {string} event Set event to trigger events trigger ie: 'click'|'change'
         * @param {function} func Set javascript function to execute when triggered
         * @return {Boolean}
         */
        trigger: function (el, event, func) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        }
    },
    validate: {
        /**
         * SETS A RANGE FIELD VALIDATION TO INPUTS ONLY
         * @param {mixed} el Set identifier CLASS||ID|ELEMENT string or obj
         * @param {string} event Set event to trigger validate range ie: 'focusout'|'keyup'
         * @param {string} min Acceptable Length Within Range
         * @param {string} max Acceptable Length Within Range
         * @param {string} msgFail Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
         * @param {string} msgPass Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
         * @param {string} msgContainer CSS ID|Class Definining Where Message is Displayed
         * @return {Boolean}
         */
        range: function (el, event, min, max, msgFail, msgPass, msgContainer) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        },
        /**
         * SETS A REGEX FIELD VALIDATION TO INPUTS ONLY
         * @param {mixed} el Set identifier CLASS||ID|ELEMENT string or obj
         * @param {string} event Set event to trigger validate regex ie: 'focusout'|'keyup'
         * @param {string} mask Regex Validation
         * @param {string} msgFail Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
         * @param {string} msgPass Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
         * @param {string} msgContainer CSS ID|Class Definining Where Message is Displayed
         * @return {Boolean}
         */
        regex: function (el, event, mask, msgFail, msgPass, msgContainer) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        },
        /**
         * SETS A REQUIRED FIELD VALIDATION
         * @param {mixed} el Set identifier CLASS||ID|ELEMENT string or obj
         * @param {string} event Set event to trigger validate required ie: 'focusout'|'keyup'         
         * @param {string} msgFail Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
         * @param {string} msgPass Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
         * @param {string} msgContainer CSS ID|Class Definining Where Message is Displayed
         * @return {Boolean}
         */
        required: function (el, event, msgFail, msgPass, msgContainer) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {
                    var val = bc.selector(bc.thisNode).getValue();
                    if ((typeof val !== 'undefined') && (val.trim() !== '')) {
                        if (msgFail)
                            bc.selector(msgContainer).setHTML(msgPass);
                        return true;
                    } else {
                        if (msgPass)
                            bc.selector(msgContainer).setHTML(msgFail);
                        return false;
                    }
                });
            });
        },
        /**
         * SETS A TYPE FIELD VALIDATION TO INPUTS ONLY
         * @param {mixed} el Set identifier CLASS||ID|ELEMENT string or obj
         * @param {string} event Set event to trigger validate type ie: 'focusout'|'keyup'
         * @param {string} type TYPE_ALFANUMERIC|TYPE_DECIMAL|TYPE_HEXDECIMAL|TYPE_NUMERIC|TYPE_OCTAL|TYPE_STRING
         * @param {string} msgFail Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
         * @param {string} msgPass Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
         * @param {string} msgContainer CSS ID|Class Definining Where Message is Displayed
         * @return {Boolean}
         */
        type: function (el, event, type, msgFail, msgPass, msgContainer) {
            bc.ready(function () {
                bc.selector(document).event(event, el, function () {

                });
            });
        }
    }

};