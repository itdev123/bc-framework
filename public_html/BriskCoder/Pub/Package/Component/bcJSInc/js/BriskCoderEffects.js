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

var bcFX = {
    thisNode: [],
    version: '1.0',
    selector: function (sel) {
        if (typeof sel === 'string') {
            if (sel.charAt(0) === '<') {
                bcFX.thisNode = [document.createElement('div').innerHTML = sel];
            } else {
                var _sel = document.querySelectorAll(sel);
                if (_sel[0]) {
                    bcFX.thisNode = _sel;
                } else {
                    bcFX.thisNode = [];
                }
            }
        } else {
            bcFX.thisNode = [sel];
        }
        var loop = function (el, fn) {
            Array.prototype.forEach.call(el, function (e, i) {
                fn(e, i);
            });
        };

        var easing = {
            linear: function (progress) {
                return progress;
            },
            quadratic: function (progress) {
                return Math.pow(progress, 2);
            },
            swing: function (progress) {
                return 0.5 - Math.cos(progress * Math.PI) / 2;
            },
            circ: function (progress) {
                return 1 - Math.sin(Math.acos(progress));
            },
            back: function (progress, x) {
                return Math.pow(progress, 2) * ((x + 1) * progress - x);
            },
            bounce: function (progress) {
                for (var a = 0, b = 1; 1; a += b, b /= 2) {
                    if (progress >= (7 - 4 * a) / 11) {
                        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
                    }
                }
            },
            elastic: function (progress, x) {
                return Math.pow(2, 10 * (progress - 1)) * Math.cos(20 * Math.PI * x / 3 * progress);
            }
        };

        var BriskCoder = {
            animate: function (options) {
                if (options.style) {

                    loop(bcFX.thisNode, function (el) {
//                        var flag = true,
//                                from = 0;
                        options.delta = function (progress) {
                            progress = this.progress;
                            return easing[(options.easing) ? options.easing : 'swing'](progress);
                        };

                        options.step = function (delta) {
                            for (var property in options.style) {
                                var unit = '';
                                if (typeof options.style[property] === 'string') {
                                    unit = options.style[property].split(/[0-9-.]+/)[1];
                                }
                                var to = parseFloat(options.style[property]);
                                //  if (flag === true) {
                                var from = (parseFloat(window.getComputedStyle(el).getPropertyValue(property))) ? parseFloat(window.getComputedStyle(el).getPropertyValue(property)) : 0;
                                //  flag = false;
                                //  }
                                /*ISSUE TO FIX : IF STYLE IS INT OR STR, (PIXEL, EM, PERCENTAGE)*/
                                el.style[property] = (to - from) * delta + (from) + unit;
                            }
                        };
                    });
                }
                var start = new Date;
                var id = setInterval(function () {
                    var timePassed = new Date - start;
                    var progress = timePassed / options.duration;
                    if (progress > 1) {
                        progress = 1;
                    }
                    options.progress = progress;
                    var delta = options.delta(progress);
                    options.step(delta);
                    if (progress === 1) {
                        clearInterval(id);
                        if (typeof options.complete === 'function') {
                            options.complete();
                        }
                    }
                }, options.delay || 10);
                return BriskCoder;
            },
            /**
             * Element Parents
             * @param {Mixed} Filter current Selector Element Parent Children <br>
             * If using multiple selector parent children can be filtered as an array: bcFX.selector('selector1', 'selector2').parent(['child1' , 'child2'])
             * @return {bcFX.selector.BriskCoder}
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
                loop(bcFX.thisNode, function (el, i) {
                    var item = closeRecursive(el.parentNode, filter);
                    if (item) {
                        _el.push(item);
                    }
                });
                bcFX.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            /*
             * Element Children
             * @param {String} Child:  Filter specific child of current Selector Element 
             * @return {bcFX.selector.BriskCoder}
             */
            children: function (child) {
                var _el = [];
                loop(bcFX.thisNode, function (el, i) {
                    if (child) {
                        var f = bcFX.thisNode[i].querySelectorAll(child);
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
                bcFX.thisNode = _el.length ? _el : false;
                return BriskCoder;
            },
            fadeOut: function (options) {
                var to = 1;
                BriskCoder.animate({
                    duration: options.duration,
                    delta: function (progress) {
                        progress = this.progress;
                        return  easing[(options.easing) ? options.easing : 'swing'](progress);
                    },
                    complete: options.complete,
                    step: function (delta) {
                        loop(bcFX.thisNode, function (el) {
                            el.style.opacity = to - delta;
                        });
                    }
                });
                return BriskCoder;
            },
            fadeIn: function (options) {
                var to = 0;
                BriskCoder.animate({
                    duration: options.duration,
                    delta: function (progress) {
                        progress = this.progress;
                        return  easing[(options.easing) ? options.easing : 'swing'](progress);
                    },
                    complete: options.complete,
                    step: function (delta) {
                        loop(bcFX.thisNode, function (el) {
                            el.style.opacity = to + delta;
                            el.style.display = 'block';
                        });
                    }
                });
                return BriskCoder;
            },
            /*
             * Next Element
             * @return {bcFX.selector.BriskCoder}
             */
            next: function () {
                var _el = [];
                loop(bcFX.thisNode, function (el) {
                    _el.push(el.nextElementSibling);
                });
                bcFX.thisNode = _el.length ? _el : false;
                return BriskCoder;
            }
        };
        return BriskCoder;
    }
};