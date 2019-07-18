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
var bc = {
    thisNode: [],
    version: '1.0',
    /**
     * Ajax
     * @param {Object} options type(Default GET)|url(Default document.URL)|dataType(Default html)|data|username(Default null)|password(Default null)|success|error <br>
     * ie: {<br>
     *      type: 'POST', <br>
     *      url: 'full url', <br>
     *      dataType: 'json', <br>
     *      data: 'val=1&val2=3'|{val: '1',val2:'3'},<br>
     *      username: 'value', <br>
     *      password: 'value', <br>
     *      success: function(){}, <br>
     *      error: function(){}<br>
     *   }
     * @return {Void}
     */
    ajax: (function (options) {
        options = options || {}; //must be object
        options.type = options.type || 'GET';
        options.url = options.url || document.URL; //set to current full URI if unset
        options.dataType = options.dataType || 'html'; //data type response expected from server xml, json, or html 
        options.contentType = (options.contentType === false) ? options.contentType : true; /*If set to false it will not set any content type header*/
        options.processData = (options.processData === false) ? options.processData : true; /*By default data option as an object will be processed and transformed into a query string. f you want to send a DOMDocument, or other non-processed data, set this option to false.*/
        options.username = options.username || null;
        options.password = options.password || null;
        options.success = options.success || function () {
        };
        options.error = options.error || function () {
        };
        //convert data to string
        if (typeof options.data === "object") {
            if (options.processData) {
                var qs = '';
                for (var key in options.data) {
                    qs += key + '=' + options.data[key] + '&';
                }
                options.data = qs.slice(0, qs.length - 1);
            }
        }
        //check if type GET
        if (options.type.toUpperCase() === 'GET') {
            if (options.data) {
                options.url += ((/\?/).test(options.url) ? "&" : "?") + options.data;
            }
        }
        var request = new XMLHttpRequest();
        request.open(options.type, options.url, true, options.username, options.password); //add username and password feature
        request.onload = function () {
            var requestResponse = request.responseText;
            if ((request.status >= 200 && request.status < 300) || request.status === 304) {
                switch (options.dataType) {
                    case 'json':
                        requestResponse = JSON.parse(request.responseText + ""); //+ "" is a work around for Android 2.3 according to jquery                           
                        break;
                    case 'xml':
                        var XMLparse = new DOMParser();
                        requestResponse = XMLparse.parseFromString(request.responseXML, "text/xml");
                        break;
                }
                options.success(requestResponse); // Success!
            } else {
                options.success(requestResponse, request.status);
            }
        };
        request.onerror = function () {
            options.error(); //connection error
        };
        if (options.type.toUpperCase() === 'POST') {
            if (options.contentType) {
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            }
            request.send(options.data);
        } else {
            request.send();
        }
    }),
    inArray: function (item, array) {
        return array.indexOf(item);
    },
    /**
     * Selector Element
     * @param {Mixed} Selector: The element to be manipulated.<br>
     * It accepts string and object to be used as parameter
     * @return {bc.selector.BriskCoder}
     */
    selector: function (sel) {

        var loop = function (el, fn) {
            Array.prototype.forEach.call(el, function (e, i) {
                fn(e, i);
            });
        };

        var matches = function (elm, selector) { //same as elm.matches(), since some browsers does not support use this function
            var matches = (elm.document || elm.ownerDocument).querySelectorAll(selector),
                    i = matches.length;
            while (--i >= 0 && matches.item(i) !== elm)
                ;
            return i > -1;
        };


        if (typeof sel === 'string') {
            if (sel.charAt(0) === '<') {
                bc.thisNode = [document.createElement('div').innerHTML = sel];
            } else {
//                if (sel.indexOf(':first-child') > -1) {
//                    _sel = document.querySelectorAll(sel.replace(':first-child', ''));
//                    if (_sel[0]) {
//                        loop(_sel, function (el, i) {
//                            bc.thisNode[i] = el.firstElementChild;
//                        });
//                    } else {
//                        bc.thisNode = [];
//                    }
//                } else if (sel.indexOf(':last-child') > -1) {
//                    _sel = document.querySelectorAll(sel.replace(':last-child', ''));
//                    if (_sel[0]) {
//                        loop(_sel, function (el, i) {
//                            bc.thisNode[i] = el.lastElementChild;
//                        });
//                    } else {
//                        bc.thisNode = [];
//                    }
//                } else {
                _sel = document.querySelectorAll(sel);
                if (_sel[0]) {
                    bc.thisNode = _sel;
                } else {
                    bc.thisNode = [];
                }
                //}
            }
        } else {
            bc.thisNode = [sel];
        }


        var BriskCoder = {
            /**
             * Add Class to Element
             * @param {String} Class Name to be applied to current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            addClass: function (className) {
                loop(bc.thisNode, function (el) {
                    if (el.classList) {
                        el.classList.add(className);
                    } else {
                        el.className += ' ' + className;
                    }
                });
                return BriskCoder;
            },
            /**
             * After Element
             * @param {String} String to be injected after current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            after: function (string) {
                loop(bc.thisNode, function (el) {
                    el.insertAdjacentHTML('afterend', string);
                });
                return BriskCoder;
            },
            /**
             * Append to Element
             * @param {String} String to be inject into current Selecor Element
             * @return {bc.selector.BriskCoder}
             */
            append: function (string) {
                loop(bc.thisNode, function (el) {
                    if (typeof string === 'object') {
                        el.appendChild(string);
                    } else {
                        el.innerHTML = el.innerHTML + string;
                    }
                }); //el.appendChild(string);
                return BriskCoder;
            },
            /**
             * Append To Selector
             * @param {Mixed} Selector to be appended Element
             * @return {bc.selector.BriskCoder}
             */
            appendTo: function (sel) {
                loop(document.querySelectorAll(sel), function (el) {
                    if (typeof bc.thisNode === 'object') {
                        loop(bc.thisNode, function (e) {
                            el.innerHTML = el.innerHTML += e.outerHTML;
                        });
                    } else {
                        el.innerHTML = el.innerHTML += bc.thisNode;
                    }
                });
                return BriskCoder;
            },
            /**
             * Before Element
             * @param {String} String to be injected before current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            before: function (string) {
                loop(bc.thisNode, function (el) {
                    el.insertAdjacentHTML('beforebegin', string);
                });
                return BriskCoder;
            },
            /*
             * Element Children
             * @param {String} Child:  Filter specific child of current Selector Element 
             * @return {bc.selector.BriskCoder}
             */
            children: function (child) {
                var _el = [];
                loop(bc.thisNode, function (el, i) {

                    if (child) {
                        var f = bc.thisNode[i].querySelectorAll(child);
                        if (f[0]) {
                            loop(f, function (fe) {
                                _el.push(fe);
                            });
                        }
                    } else {
                        loop(el.children, function (n) {
                            _el.push(n);
                        });
                    }
                });
                bc.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            /**
             * Clone Element
             * @param {Boolean} Clone current Selector Element with data and events. Defautl false
             * @return {bc.selector.BriskCoder}
             */
            clone: function (withDataAndEvents, eventsDeeper) {
                var _el = [];
                loop(bc.thisNode, function (el) {
                    _el.push(el.cloneNode(withDataAndEvents ? true : false));
                });
                bc.thisNode = _el.length ? _el : '';
                return BriskCoder;
            },
            /**
             * Element Parents
             * @param {Mixed} Filter current Selector Element Parent Children <br>
             * If using multiple selector parent children can be filtered as an array: bc.selector('selector1', 'selector2').parent(['child1' , 'child2'])
             * @return {bc.selector.BriskCoder}
             */
            closest: function (filter) {
                if (!filter) {
                    return false;
                }
                var _el = [];
                var closeRecursive = function (el, match) {
                    if (!el) {
                        return false;
                    }
                    if (('#' + el.id === filter) || ('.' + el.className === filter) || (el.tagName === filter.toUpperCase())) {
                        return el;
                    }
                    return closeRecursive(el.parentNode, match);
                };
                loop(bc.thisNode, function (el, i) {
                    var item = closeRecursive(el.parentNode, filter);
                    if (item) {
                        _el.push(item);
                    }
                });
                bc.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            /**
             * Loop Through Elements             
             * @param {Function} Function to be executed for each curret Selector Element
             * @return {bc.selector.BriskCoder}
             */
            each: function (fn) {
                Array.prototype.forEach.call(bc.thisNode, function (e, i) {
                    fn(e, i);
                });
                return BriskCoder;
            },
            /**
             * Events
             * @param {String} Event Type ie: 'click'|'change'|'mouseover'|'mouseout'|'mousemove' ... <br>
             * For a list of all HTML DOM events, look at w3schools manual at http://www.w3schools.com/jsref/dom_obj_event.asp 
             * @param {String} Filter Element
             * @param {Boolean} Once TRUE defines eventListener to happen only one time. Default FALSE.
             * @param {Function} Function to be executed when event happens
             * @return {Boolean}
             */
            event: function () {
                var evt;
                var ftr;
                var once = false;
                var fnc;
                //check length of arguments                      
                switch (arguments.length) {
                    case 2:
                        evt = arguments[0].split(' ');
                        fnc = arguments[1];
                        if (typeof fnc !== 'function') {
                            return false;
                        }
                        break;
                    case 3:
                        evt = arguments[0].split(' ');
                        if (arguments[1] === true) {
                            once = true;
                        } else {
                            ftr = arguments[1];
                        }
                        fnc = arguments[2];
                        if (typeof fnc !== 'function') {
                            return false;
                        }
                        break;
                    case 4:
                        evt = arguments[0].split(' ');
                        ftr = arguments[1];
                        once = arguments[2];
                        fnc = arguments[3];
                        break;
                    default:
                        return false;
                }

                function evtOnce(element, event) {
                    element.addEventListener(event, function (e) {
                        element.removeEventListener(event, arguments.callee);
                        bc.thisNode = e.currentTarget;
                        return fnc(e);
                    });
                }
                var len = evt.length;
                loop(bc.thisNode, function (el, i) {
                    if (ftr) {
                        var nonExistentEl = [];
                        var f = bc.thisNode[i].querySelectorAll(ftr);
                        if (f[0]) {
                            loop(f, function (fe) {
                                for (var i = 0; i < len; i++) {
                                    if (once === true) {
                                        evtOnce(fe, evt[i]);
                                    } else {
                                        fe.addEventListener(evt[i], function (e) {
                                            bc.thisNode = e.currentTarget;
                                            nonExistentEl[i] = fe;
                                            fnc(e);
                                        });
                                    }
                                }
                            });
                            bc.thisNode = f;
                        }
                        //if elements does not exist, search inside dom
                        document.addEventListener(evt[i], function (e) {
                            for (var target = e.target; target && target != this; target = target.parentNode) {
                                if (matches(target, ftr) && (bc.inArray(target, nonExistentEl) === -1)) {//only if does not exis
                                    if (once === true) {
                                        evtOnce(target, evt[i]);
                                    } else {
                                        bc.thisNode = target;
                                        fnc(e);
                                    }
                                }
                            }
                        });
                    } else {
                        for (var i = 0; i < len; i++) {
                            if (once === true) {
                                evtOnce(el, evt[i]);
                            } else {
                                el.addEventListener(evt[i], function (e) {
                                    bc.thisNode = e.currentTarget;
                                    fnc(e);
                                });
                            }
                        }
                    }
                });
            },
            /**
             * Get Element Attribute
             * @param {String} Attribute ie: 'data-'|'id'|'class'|'name'|'src'|'href' ...
             * @return {attribute} Current Selector Element filtered Attribute Value
             */
            getAttribute: function (attr) {
                return  bc.thisNode[0].getAttribute(attr);
            },
            /**
             * Get Selector Element
             * @return {undefined}
             */
            getElement: function () {
                return bc.thisNode;
            },
            /**
             * Get Element Height
             * @param {Boolean} Margin true gets current Selector Element Height with margin. Default false.
             * @return {offsetHeight} Current Selecor Element Height
             */
            getHeight: function (margin) {
                if (!margin) {
                    return bc.thisNode[0].offsetHeight;
                }
                var height = bc.thisNode[0].offsetHeight;
                var style = getComputedStyle(bc.thisNode[0]);
                height += parseInt(style.marginTop) + parseInt(style.marginBottom);
                return height;
            },
            /**
             * Get Element Html
             * @return {el.innerHTML}
             */
            getHTML: function () {
                var html = '';
                loop(bc.thisNode, function (el) {
                    html += el.innerHTML;
                });
                return html;
            },
            /**
             * Get Element Offset
             * @param {offset} type ie: left|top|height|width|parent
             * @return {el.offset} integer
             */
            getOffset: function (offset) {
                var o = 0;
                switch (offset) {
                    case 'left':
                        o = bc.thisNode[0].offsetLeft;
                        break;
                    case 'top':
                        o = bc.thisNode[0].offsetTop;
                        break;
                    case 'height':
                        o = bc.thisNode[0].offsetHeight;
                        break;
                    case 'width':
                        o = bc.thisNode[0].offsetWidth;
                        break;
                    case 'parent':
                        o = bc.thisNode[0].offsetParent;
                        break;
                }
                return o;
            },
            /**
             * Get Element Html
             * @return {el.innerHTML}
             */
            getOuterHTML: function () {
                var html = '';
                loop(bc.thisNode, function (el) {
                    html += el.outerHTML;
                });
                return html;
            },
            /**
             * Get Element Screen
             * @param {screen} screen type ie: left|top|x|y
             * @return {el.screen} integer
             */
            getScreen: function (screen) {
                var s = 0;
                switch (screen) {
                    case 'left':
                        s = bc.thisNode[0].screenLeft;
                        break;
                    case 'top':
                        s = bc.thisNode[0].screenTop;
                        break;
                    case 'x':
                        s = bc.thisNode[0].screenX;
                        break;
                    case 'y':
                        s = bc.thisNode[0].screenY;
                        break;
                }
                return s;
            },
            /**
             * Get Element Scroll
             * @param {scroll} scroll type ie: left|top|height|width|maxX|maxY|x|y
             * @return {el.scroll} integer
             */
            getScroll: function (scroll) {
                var s = 0;
                switch (scroll) {
                    case 'left':
                        s = bc.thisNode[0].scrollLeft;
                        break;
                    case 'top':
                        s = bc.thisNode[0].scrollTop;
                        break;
                    case 'height':
                        s = bc.thisNode[0].scrollHeight;
                        break;
                    case 'width':
                        s = bc.thisNode[0].scrollWidth;
                        break;
                    case 'maxX':
                        s = bc.thisNode[0].scrollMaxX;
                        break;
                    case 'maxY':
                        s = bc.thisNode[0].scrollMaxY;
                        break;
                    case 'x':
                        s = bc.thisNode[0].scrollX;
                        break;
                    case 'y':
                        s = bc.thisNode[0].scrollY;
                        break;
                }
                return s;
            },
            /**
             * Get Element Style
             * @param {Array}  Attribute ie: ['background']|['color']|['width']|['height']|['margin']|['padding'] ...
             * @return {Array} Array of filtered Style Attributes
             */
            getStyle: function (attr) {
                var _r = [];
                if (!bc.thisNode[0]) {
                    return _r;
                }
                loop(attr, function (key) {//classes and elements only returns the first match 
                    _r[key] = window.getComputedStyle(bc.thisNode[0]).getPropertyValue(key);
                });
                return _r;
            },
            /**
             * Get Element Tag Name
             * @return {string} Current Selector Tag Name UPPERCASE
             */
            getTagName: function () {
                return  bc.thisNode[0].tagName;
            },
            /**
             * Get Element Text
             * @return {text} Current Element Text
             */
            getText: function () {
                var text = '';
                loop(bc.thisNode, function (el) {
                    text += el.textContent;
                });
                return text;
            },
            /**
             * Element Value
             * @return {element value}
             */
            getValue: function () {
                return  bc.thisNode[0].value;
            },
            /**
             * Get Element Width
             * @param {Boolean} Margin true gets current Selector Element Width with margin. Default false.
             * @return {offsetWidth} Current Selecor Element Width
             */
            getWidth: function (margin) {
                if (!margin) {
                    return bc.thisNode[0].offsetWidth;
                }
                var width = bc.thisNode[0].offsetWidth;
                var style = getComputedStyle(bc.thisNode[0]);
                width += parseInt(style.marginLeft) + parseInt(style.marginRight);
                return width;
            },
            /**
             * Whether Element Has Class
             * @param {String} Class name to be found on current Selector Element
             * @return {Boolean} TRUE|FALSE
             */
            hasClass: function (className) {
                if (bc.thisNode[0].classList) {
                    return bc.thisNode[0].classList.contains(className);
                } else {
                    return new RegExp('(^| )' + className + '( |$)', 'gi').test(bc.thisNode[0].className);
                }
            },
            /**
             * Hide Current Selector Element
             * @param {Function} Function to execute after element is hidden
             * @return {bc.selector.BriskCoder}
             */
            hide: function (fn) {
                loop(bc.thisNode, function (el) {
                    el.style.display = 'none';
                    if (typeof fn === 'function') {
                        fn(el);
                    }
                });
                return BriskCoder;
            },
            /**
             * Matches Selector
             * @return {undefined}
             */
            is: function (string) {
                var matches = function (el, selector) {
                    return (el.matches || el.matchesSelector || el.msMatchesSelector || el.mozMatchesSelector || el.webkitMatchesSelector || el.oMatchesSelector).call(el, selector);
                };
                return matches(bc.thisNode[0], string);
            },
            /**
             * Length
             * @return {_el.length, Number, e.target.length, Boolean.length, f.length, document@call;createElement.innerHTMLsel.length, _sel.length}
             */
            length: function () {
                return bc.thisNode.length;
            },
            /*
             * Next Element
             * @return {bc.selector.BriskCoder}
             */
            next: function () {
                var _el = [];
                loop(bc.thisNode, function (el) {
                    _el.push(el.nextElementSibling);
                });
                bc.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            /**
             * Element Parent
             * @param {Mixed} Filter current Selector Element Parent Children <br>
             * If using multiple selector parent children can be filtered as an array: bc.selector('selector1', 'selector2').parent(['child1' , 'child2'])
             * @return {bc.selector.BriskCoder}
             */
            parent: function (child) {
                var _el = [];
                loop(bc.thisNode, function (el, i) {
                    if (child) {
                        var c = child;
                        if (child[i]) {
                            c = child[i];
                        }
                        bc.selector(el.parentNode).children(c);
                        if (bc.thisNode.length) {
                            _el.push(bc.thisNode[i]);
                        }
                    } else {
                        _el.push(el.parentNode);
                    }
                });
                bc.thisNode = _el.length ? _el : false;

                return BriskCoder;
            },
            /**
             * Previous Element
             * @return {bc.selector.BriskCoder}
             */
            prev: function () {
                var _el = [];
                loop(bc.thisNode, function (el) {
                    _el.push(el.previousElementSibling);
                });
                bc.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            /**
             * 
             * @return {bc.selector.BriskCoder.position.BriskCoderAnonym$0}
             */
            position: function () {
                var top = 0, left = 0;
                var el = bc.thisNode[0];
                while (el) {
                    top = top + parseInt(el.offsetTop);
                    left = left + parseInt(el.offsetLeft);
                    el = el.offsetParent;
                }
                return {top: top, left: left};
            },
            /**
             * Remove Element
             * @return {bc.selector.BriskCoder}
             */
            remove: function () {
                loop(bc.thisNode, function (el) {
                    el.parentNode.removeChild(el);
                });
                return BriskCoder;
            },
            /**
             * Remove Attribute
             * @param {String} Attribute ie: 'data-'|'id'|'class'|'name'|'src'|'href' ...
             * @return {bc.selector.BriskCoder}
             */
            removeAttribute: function (attr) {
                loop(bc.thisNode, function (el) {
                    el.removeAttribute(attr);
                });
                return BriskCoder;
            },
            /**
             * Remove Element Class
             * @param {String} Class Name to be remove from current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            removeClass: function (className) {
                loop(bc.thisNode, function (el) {
                    if (el.classList) {
                        el.classList.remove(className);
                    } else {
                        el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
                    }
                });
                return BriskCoder;
            },
            /**
             * Serialize form
             * @param {boolean} obj Set to true to return data as an object. False as a query string
             * @return {mixed} object or string
             */
            serialize: function (obj) {
                var form = bc.thisNode[0];
                if (!form || form.nodeName !== "FORM") {
                    return;
                }
                var i, j, q = [];
                var _obj = {};
                for (i = form.elements.length - 1; i >= 0; i = i - 1) {
                    if (form.elements[i].name === "") {
                        continue;
                    }
                    var name = form.elements[i].name;
                    var value = encodeURIComponent(form.elements[i].value);
                    _obj[name] = [];
                    switch (form.elements[i].nodeName) {
                        case 'INPUT':
                            switch (form.elements[i].type) {
                                case 'text':
                                case 'tel':
                                case 'email':
                                case 'hidden':
                                case 'password':
                                case 'button':
                                case 'reset':
                                case 'submit':
                                    q.push(name + "=" + value);
                                    _obj[name] = value;
                                    break;
                                case 'checkbox':
                                case 'radio':
                                    if (form.elements[i].checked) {
                                        q.push(name + "=" + value);
                                        _obj[name] = value;
                                    }
                                    break;
                            }
                            break;
                        case 'file':
                            break;
                        case 'TEXTAREA':
                            q.push(name + "=" + value);
                            _obj[name] = value;
                            break;
                        case 'SELECT':
                            switch (form.elements[i].type) {
                                case 'select-one':
                                    q.push(name + "=" + value);
                                    _obj[name] = value;
                                case 'select-multiple':
                                    for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
                                        if (form.elements[i].options[j].selected) {
                                            var name = form.elements[i].name;
                                            var value = encodeURIComponent(form.elements[i].options[j].value);
                                            q.push(name + "=" + value);
                                            _obj[name] = value;
                                        }
                                    }
                                    break;
                            }
                            break;
                        case 'BUTTON':
                            switch (form.elements[i].type) {
                                case 'reset':
                                case 'submit':
                                case 'button':
                                    q.push(name + "=" + value);
                                    _obj[name] = value;
                                    break;
                            }
                            break;
                    }
                }
                if (obj) {
                    return _obj;
                }
                return q.join("&");
            },
            /**
             * Set Element Attribute
             * @param {Array} Attribute ie: ['data-','value']|['id','value']|['class','value']|['name','value']|['src','value']|['href','value'] ...
             * @return {bc.selector.BriskCoder}
             */
            setAttribute: function (attr) {
                loop(bc.thisNode, function (el) {
                    for (var key in attr) {
                        el.setAttribute(key, attr[key]);
                    }
                });
                return BriskCoder;
            },
            /**
             * Set Elemt Height
             * @param {Mixed} Set  current Selector Element Height. If type interger pixels are added automatically.<br>
             * If another height measurements desired enter as a string ie: '10%'|'10em'
             * @return {bc.selector.BriskCoder}
             */
            setHeight: function (height) {
                if (height === parseInt(height)) {
                    height = height + 'px';
                }
                loop(bc.thisNode, function (el) {
                    el.style.height = height;
                });
                return BriskCoder;
            },
            /**
             * Set Element Html
             * @param {String} String to be inject into current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            setHTML: function (string) {
                loop(bc.thisNode, function (el) {
                    el.innerHTML = string;
                });
                return BriskCoder;
            },
            /**
             * Set Element Style
             * @param {Array} Attribute ie: {background: 'value', 'color: 'value', width: 'value', height: 'value', margin:'value', padding:'value'}...
             * @return {bc.selector.BriskCoder}
             */
            setStyle: function (attr) {
                loop(bc.thisNode, function (el) {
                    for (var key in attr) {
                        el.style[key] = attr[key];
                    }
                });
                return BriskCoder;
            },
            /**
             * Set Element Text
             * @param {String} String to be inject as text of the current Selector Element
             * @return {bc.selector.BriskCoder}
             */
            setText: function (string) {
                loop(bc.thisNode, function (el) {
                    el.textContent = string;
                });
                return BriskCoder;
            },
            /**
             * Set Element Value
             * @return {bc.selector.BriskCoder}
             */
            setValue: function (string) {
                loop(bc.thisNode, function (el) {
                    el.value = string;
                });
                return BriskCoder;
            },
            /**
             * Set Element Width
             * @param {Mixed} Set current Selector Element  width. If type interger pixels are added automatically.<br>
             * If another width measurements desired enter as a string ie: '10%'|'10em'
             * @return {bc.selector.BriskCoder}
             */
            setWidth: function (width) {
                if (width === parseInt(width)) {
                    width = width + 'px';
                }
                loop(bc.thisNode, function (el) {
                    el.style.width = width;
                });
                return BriskCoder;
            },
            /**
             * Show Current Selector Element
             * @param {Function} Function to execute after element is shown
             * @return {bc.selector.BriskCoder}
             */
            show: function (fn) {
                loop(bc.thisNode, function (el) {
                    el.style.display = 'block';
                    if (typeof fn === 'function') {
                        fn(el);
                    }
                });
                return BriskCoder;
            },
            /**
             * Trigger Event
             * @param {type} Event name ie: click|change ...
             * @return {bc.selector.BriskCoder}
             */
            trigger: function (string) {
                loop(bc.thisNode, function (el) {
                    var event = document.createEvent('HTMLEvents');
                    event.initEvent(string, true, false);
                    el.dispatchEvent(event);
                });
                return BriskCoder;
            }
        };
        return BriskCoder;
    },
    /**
     * Documents Ready Event Listener
     * @param {Function} fn
     * @return {Void}
     */
    ready: function (fn) {
        // if (document.readyState !== 'loading') {
        //    fn();
        //  } else {
        document.addEventListener('DOMContentLoaded', fn);
        //  }
    }
};