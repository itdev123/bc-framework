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

/*TO DO bcEffects Library, and bcIO Library*/

var bcLayout = {
    version: '1.0',
    set: function (wrapper, element, gridMode, options) {
        options = options || {};//must be object
        options.slide = options.slide || 1;
        options.duration = options.duration || 800;

        if (gridMode) {
            bc.selector('body').style({overflow: 'hidden'});
            bc.selector(wrapper).style({position: 'relative', width: (options.slide * 100) + '%', height: '100%'});

            bc.selector(element + ':nth-child(1)').addClass('active');
            bc.selector(element).style({width: (100 / options.slide) + '%', height: '100%', float: 'left'});

            bc.selector(element).each(function (e, i) {
                i++;
                bc.selector(element + ':nth-child(' + i + ')').attribute({'data-id': 'element' + i});
            });
        }

        var animated = true,
                callback = [];


//                    bc.selector(callback).each(function (e, i) {
//                        if (parseInt(activeId.replace(/^\D+/g, '')) + 1 == i) {
//                            e();
//                        }
//                    });


        var slideUp = function () {
            var activeId = bc.selector(element + '.active').attribute(['data-id']);
            if (parseInt(activeId.replace(/^\D+/g, '')) === 1)
                return false;
            var prev = document.querySelector(element + '.active').previousElementSibling;
            prev.classList.add('active');
            prev.nextElementSibling.classList.remove('active');
            animated = false;
            bcFX.selector(wrapper).animate({
                style: {
                    left: -prev.offsetLeft + 'px',
                    top: -prev.offsetTop + 'px'
                },
                duration: options.duration,
                complete: function () {
                    animated = true;
                }
            });
        };

        var slideDown = function () {

            var activeId = bc.selector(element + '.active').attribute(['data-id']);
            if (parseInt(activeId.replace(/^\D+/g, '')) === bc.selector(element).length())
                return false;
            var next = document.querySelector(element + '.active').nextElementSibling;
            next.classList.add('active');
            next.previousElementSibling.classList.remove('active');
            animated = false;
            bcFX.selector(wrapper).animate({
                style: {
                    left: -next.offsetLeft + 'px',
                    top: -next.offsetTop + 'px'
                },
                duration: options.duration,
                complete: function () {
                    animated = true;
                    
                }
            });
        };

            
        bc.selector(wrapper).event("mousewheel DOMMouseScroll", function (event) {
            var delta = event.detail ? -event.detail : event.wheelDelta;           
            if (delta >= 0) {               
                if (animated) {
                    slideUp();
                }
            } else {
                if (animated) {
                    slideDown();
                }
            }            
        });

        var BriskCoderContainer = {
            callback: function (settings) {
                settings = settings || {};//must be object                
                settings.slider = settings.slider || false;
                settings.action = settings.action || {};

                if (settings.slider !== false) {
                    callback[settings.slider] = settings.action;
                }
                return BriskCoderContainer;
            },
            control: function (controls) {
                controls = controls || {};//must be object
                controls.indexes = controls.indexes || false;
                if (controls.indexes) {
                    /*TO DO INDEXES*/

                }
                return BriskCoderContainer;
            },
            effect: function () {

                return BriskCoderContainer;
            },
            position: function () {

                return BriskCoderContainer;
            }
        };

        return BriskCoderContainer;
    }
};