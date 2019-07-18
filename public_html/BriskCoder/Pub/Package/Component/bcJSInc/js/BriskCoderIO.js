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

/*
 * bcIO.bind = function(){}
 */

var bcIO = {
    version: '1.0',
    bind: function (el, evt, input, fn) {
        bc.selector(el).event(evt, function (e) {
            //console.log(event.wheelDelta);
            /*Position: 1 = bottomLeft | 2 = bottom | 3 = bottomRight | 4 = left | 6 = right | 7 = topLeft | 8 = top | 9 = topRight*/
            var obj = {pos: 0, code: 0, name: ''};

            switch (evt) {
                case 'click':
                case 'contextmenu':
                case 'dblclick':
                case 'mousedown':
                case 'mouseup':
                    //collect buttonCode
                    obj.code = e.which;
                    //collect names
                    switch (obj.code) {
                        case 1:
                            obj.name = 'leftButton';
                            break;
                        case 2:
                            obj.name = 'middleButton';
                            break;
                        case 3:
                            obj.name = 'rightButton';
                            break;
                    }
                    if (input !== null) {
                        var code = null;
                        switch (input) {
                            case 'leftButton':
                                code = 1;
                                break;
                            case 'middleButton':
                                code = 2;
                                break;
                            case 'rightButton':
                                code = 3;
                                break;
                        }
                        if (obj.code === code) {
                            fn(obj);
                        }
                    } else {
                        fn(obj);
                    }
                    break;
                case 'mousemove':
                case 'mouseenter':
                case 'mouseover':
                case 'mouseout':
                case 'mouseleave':
                    /*RETURNS CLIENTE POSITION*/
                    obj.name = evt;
                    obj.pos = {x: e.clientX, y: e.clientY};
                    fn(obj);
                    break;
                case 'wheel':
                case 'mousewheel':
                case 'DOMMouseScroll':
                case 'wheel DOMMouseScroll':
                case 'mousewheel DOMMouseScroll':
                    obj.code = e.detail ? -e.detail : e.wheelDelta;
                    if (obj.code >= 0) {
                        obj.pos = 8;
                        obj.name = 'mousewheelUp';
                    } else {
                        obj.pos = 2;
                        obj.name = 'mousewheelDown';
                    }
                    if (input !== null) {
                        var code = null;
                        switch (input) {
                            case 'mousewheelUp':
                                if (obj.code >= 0) {
                                    fn(obj);
                                }
                                break;
                            case 'mousewheelDown':
                                if (obj.code < 0) {
                                    fn(obj);
                                }
                                break;
                        }
                    } else {
                        fn(obj);
                    }
                    break;
                case 'keydown':
                case 'keypress':
                case 'keyup':
                    //collect keycode
                    obj.code = e.keyCode;
                    //collect names
                    switch (obj.code) {
                        case 65:
                            obj.name = 'a';
                            break;
                        case 107:
                            obj.name = 'add';
                            break;
                        case 18:
                            obj.name = 'alt';
                            break;
                        case 66:
                            obj.name = 'b';
                            break;
                        case 220:
                            obj.name = 'backSlash';
                            break;
                        case 8:
                            obj.name = 'backspace';
                            break;
                        case 67:
                            obj.name = 'c';
                            break;
                        case 20:
                            obj.name = 'capsLock';
                            break;
                        case 221:
                            obj.name = 'closeBraket';
                            break;
                        case 188:
                            obj.name = 'comma';
                            break;
                        case 17:
                            obj.name = 'ctrl';
                            break;
                        case 68:
                            obj.name = 'd';
                            break;
                        case 189:
                            obj.name = 'dash';
                            break;
                        case 110:
                            obj.name = 'decimalPoint';
                            break;
                        case 46:
                            obj.name = 'delete';
                            break;
                        case 111:
                            obj.name = 'divide';
                            break;
                        case 40:
                            obj.name = 'downArrow';
                            obj.pos = 2;
                            break;
                        case 69:
                            obj.name = 'e';
                            break;
                        case 35:
                            obj.name = 'end';
                            break;
                        case 13:
                            obj.name = 'enter';
                            break;
                        case 187:
                            obj.name = 'equalSgn';
                            break;
                        case 27:
                            obj.name = 'escape';
                            break;
                        case 70:
                            obj.name = 'f';
                            break;
                        case 191:
                            obj.name = 'forwardSlash';
                            break;
                        case 112:
                            obj.name = 'f1';
                            break;
                        case 113:
                            obj.name = 'f2';
                            break;
                        case 114:
                            obj.name = 'f3';
                            break;
                        case 115:
                            obj.name = 'f4';
                            break;
                        case 116:
                            obj.name = 'f5';
                            break;
                        case 117:
                            obj.name = 'f6';
                            break;
                        case 118:
                            obj.name = 'f7';
                            break;
                        case 119:
                            obj.name = 'f8';
                            break;
                        case 120:
                            obj.name = 'f9';
                            break;
                        case 121:
                            obj.name = 'f10';
                            break;
                        case 122:
                            obj.name = 'f11';
                            break;
                        case 123:
                            obj.name = 'f12';
                            break;
                        case 71:
                            obj.name = 'g';
                            break;
                        case 192:
                            obj.name = 'graveAccent';
                            break;
                        case 72:
                            obj.name = 'h';
                            break;
                        case 36:
                            obj.name = 'home';
                            break;
                        case 73:
                            obj.name = 'i';
                            break;
                        case 45:
                            obj.name = 'insert';
                            break;
                        case 74:
                            obj.name = 'j';
                            break;
                        case 75:
                            obj.name = 'k';
                            break;
                        case 76:
                            obj.name = 'l';
                            break;
                        case 37:
                            obj.name = 'leftArrow';
                            obj.pos = 4;
                            break;
                        case 91:
                            obj.name = 'leftWindowKey';
                            break;
                        case 77:
                            obj.name = 'm';
                            break;
                        case 106:
                            obj.name = 'multiply';
                            break;
                        case 78:
                            obj.name = 'n';
                            break;
                        case 144:
                            obj.name = 'numLock';
                            break;
                        case 96:
                            obj.name = 'numpad0';
                            break;
                        case 97:
                            obj.name = 'numpad1';
                            obj.pos = 1;
                            break;
                        case 98:
                            obj.name = 'numpad2';
                            obj.pos = 2;
                            break;
                        case 99:
                            obj.name = 'numpad3';
                            obj.pos = 3;
                            break;
                        case 100:
                            obj.name = 'numpad4';
                            obj.pos = 4;
                            break;
                        case 101:
                            obj.name = 'numpad5';
                            break;
                        case 102:
                            obj.name = 'numpad6';
                            obj.pos = 6;
                            break;
                        case 103:
                            obj.name = 'numpad7';
                            obj.pos = 7;
                            break;
                        case 104:
                            obj.name = 'numpad8';
                            obj.pos = 8;
                            break;
                        case 105:
                            obj.name = 'numpad9';
                            obj.pos = 9;
                            break;
                        case 79:
                            obj.name = 'o';
                            break;
                        case 219:
                            obj.name = 'openBraket';
                            break;
                        case 80:
                            obj.name = 'p';
                            break;
                        case 34:
                            obj.name = 'pageDown';
                            obj.pos = 2;
                            break;
                        case 33:
                            obj.name = 'pageUp';
                            obj.pos = 8;
                            break;
                        case 19:
                            obj.name = 'pause/break';
                            break;
                        case 190:
                            obj.name = 'period';
                            break;
                        case 81:
                            obj.name = 'q';
                            break;
                        case 82:
                            obj.name = 'r';
                            break;
                        case 39:
                            obj.name = 'rightArrow';
                            obj.pos = 6;
                            break;
                        case 92:
                            obj.name = 'rightWindowKey';
                            break;
                        case 83:
                            obj.name = 's';
                            break;
                        case 145:
                            obj.name = 'scrollLock';
                            break;
                        case 93:
                            obj.name = 'selectKey';
                            break;
                        case 186:
                            obj.name = 'semiColon';
                            break;
                        case 16:
                            obj.name = 'shift';
                            break;
                        case 222:
                            obj.name = 'singleQuote';
                            break;
                        case 32:
                            obj.name = 'space';
                            break;
                        case 109:
                            obj.name = 'subtract';
                            break;
                        case 84:
                            obj.name = 't';
                            break;
                        case 9:
                            obj.name = 'tab';
                            break;
                        case 85:
                            obj.name = 'u';
                            break;
                        case 38:
                            obj.name = 'upArrow';
                            obj.pos = 8;
                            break;
                        case 86:
                            obj.name = 'v';
                            break;
                        case 87:
                            obj.name = 'w';
                            break;
                        case 88:
                            obj.name = 'x';
                            break;
                        case 89:
                            obj.name = 'y';
                            break;
                        case 90:
                            obj.name = 'z';
                            break;
                        case 48:
                            obj.name = '0';
                            break;
                        case 49:
                            obj.name = '1';
                            break;
                        case 50:
                            obj.name = '2';
                            break;
                        case 51:
                            obj.name = '3';
                            break;
                        case 52:
                            obj.name = '4';
                            break;
                        case 53:
                            obj.name = '5';
                            break;
                        case 54:
                            obj.name = '6';
                            break;
                        case 55:
                            obj.name = '7';
                            break;
                        case 56:
                            obj.name = '8';
                            break;
                        case 57:
                            obj.name = '9';
                            break;
                    }
                    //colect positions                  
                    if (input !== null) {
                        var code = null;
                        switch (input) {
                            case 'a':
                                code = 65;
                                break;
                            case 'add':
                                code = 107;
                                break;
                            case 'alt':
                                code = 18;
                                break;
                            case 'b':
                                code = 66;
                                break;
                            case 'backSlash':
                                code = 220;
                                break;
                            case 'backspace':
                                code = 8;
                                break;
                            case 'c':
                                code = 67;
                                break;
                            case 'capsLock':
                                code = 20;
                                break;
                            case 'closeBraket':
                                code = 221;
                                break;
                            case 'comma':
                                code = 188;
                                break;
                            case 'ctrl':
                                code = 17;
                                break;
                            case 'd':
                                code = 68;
                                break;
                            case 'dash':
                                code = 189;
                                break;
                            case 'decimalPoint':
                                code = 110;
                                break;
                            case 'delete':
                                code = 46;
                                break;
                            case 'divide':
                                code = 111;
                                break;
                            case 'downArrow':
                                code = 40;
                                obj.pos = 2;
                                break;
                            case  'e':
                                code = 69;
                                break;
                            case 'end':
                                code = 35;
                                break;
                            case 'enter':
                                code = 13;
                                break;
                            case 'equalSgn':
                                code = 187;
                                break;
                            case 'escape':
                                code = 27;
                                break;
                            case 'f':
                                code = 70;
                                break;
                            case 'forwardSlash':
                                code = 191;
                                break;
                            case 'f1':
                                code = 112;
                                break;
                            case 'f2':
                                code = 113;
                                break;
                            case 'f3':
                                code = 114;
                                break;
                            case 'f4':
                                code = 115;
                                break;
                            case 'f5':
                                code = 116;
                                break;
                            case 'f6':
                                code = 117;
                                break;
                            case 'f7':
                                code = 118;
                                break;
                            case 'f8':
                                code = 119;
                                break;
                            case 'f9':
                                code = 120;
                                break;
                            case 'f10':
                                code = 121;
                                break;
                            case 'f11':
                                code = 122;
                                break;
                            case 'f12':
                                code = 123;
                                break;
                            case 'g':
                                code = 71;
                                break;
                            case 'graveAccent':
                                code = 192;
                                break;
                            case 'h':
                                code = 72;
                                break;
                            case 'home':
                                code = 36;
                                break;
                            case 'i':
                                code = 73;
                                break;
                            case 'insert':
                                code = 45;
                                break;
                            case 'j':
                                code = 74;
                                break;
                            case 'k':
                                code = 75;
                                break;
                            case 'l':
                                code = 76;
                                break;
                            case 'leftArrow':
                                code = 37;
                                obj.pos = 4;
                                break;
                            case 'leftWindowKey':
                                code = 91;
                                break;
                            case 'm':
                                code = 77;
                                break;
                            case 'multiply':
                                code = 106;
                                break;
                            case 'n':
                                code = 78;
                                break;
                            case 'numLock':
                                code = 144;
                                break;
                            case 'numpad0':
                                code = 96;
                                break;
                            case 'numpad1':
                                code = 97;
                                obj.pos = 1;
                                break;
                            case 'numpad2':
                                code = 98;
                                obj.pos = 2;
                                break;
                            case 'numpad3':
                                code = 99;
                                obj.pos = 3;
                                break;
                            case 'numpad4':
                                code = 100;
                                obj.pos = 4;
                                break;
                            case 'numpad5':
                                code = 101;
                                break;
                            case 'numpad6':
                                code = 102;
                                obj.pos = 6;
                                break;
                            case 'numpad7':
                                code = 103;
                                obj.pos = 7;
                                break;
                            case 'numpad8':
                                code = 104;
                                obj.pos = 8;
                                break;
                            case 'numpad9':
                                code = 105;
                                obj.pos = 9;
                                break;
                            case 'o':
                                code = 79;
                                break;
                            case 'openBraket':
                                code = 219;
                                break;
                            case 'p':
                                code = 80;
                                break;
                            case 'pageDown':
                                code = 34;
                                obj.pos = 2;
                                break;
                            case 'pageUp':
                                code = 33;
                                obj.pos = 8;
                                break;
                            case 'pause/break':
                                code = 19;
                                break;
                            case 'period':
                                code = 190;
                                break;
                            case 'q':
                                code = 81;
                                break;
                            case 'r':
                                code = 82;
                                break;
                            case 'rightArrow':
                                code = 39;
                                obj.pos = 6;
                                break;
                            case 'rightWindowKey':
                                code = 92;
                                break;
                            case 's':
                                code = 83;
                                break;
                            case 'scrollLock':
                                code = 145;
                                break;
                            case 'selectKey':
                                code = 93;
                                break;
                            case 'semiColon':
                                code = 186;
                                break;
                            case 'shift':
                                code = 16;
                                break;
                            case 'singleQuote':
                                code = 222;
                                break;
                            case 'space':
                                code = 32;
                                break;
                            case 'subtract':
                                code = 109;
                                break;
                            case 't':
                                code = 84;
                                break;
                            case 'tab':
                                code = 9;
                                break;
                            case 'u':
                                code = 85;
                                break;
                            case 'upArrow':
                                code = 38;
                                obj.pos = 8;
                                break;
                            case 'v':
                                code = 86;
                                break;
                            case 'w':
                                code = 87;
                                break;
                            case 'x':
                                code = 88;
                                break;
                            case 'y':
                                code = 89;
                                break;
                            case 'z':
                                code = 90;
                                break;
                            case '0':
                                code = 48;
                                break;
                            case '1':
                                code = 49;
                                break;
                            case '2':
                                code = 50;
                                break;
                            case '3':
                                code = 51;
                                break;
                            case '4':
                                code = 52;
                                break;
                            case '5':
                                code = 53;
                                break;
                            case '6':
                                code = 54;
                                break;
                            case '7':
                                code = 55;
                                break;
                            case '8':
                                code = 56;
                                break;
                            case '9':
                                code = 57;
                                break;
                        }
                        if (obj.code === code) {
                            fn(obj);
                        }
                    } else {
                        fn(obj);
                    }
                    break;
                case 'touchstart':
                case 'touchmove':/*DO SOMETHING ELSE FOR TOUCHMOVE TO DETECT DIRECTION UP|DOWN*/
                    /*obj.name = EVENT NAME TO */
                    /*obj.position = {x: e.touches[0].clientX, y: e.touches[0].clientY} */
                    break;
                case 'touchend':
                case 'touchcancel':
                    /*obj.name = EVENT NAME TO */
                    /*obj.position = {x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY} */
                    break;
                default:

            }





            // obj.code = e.keyCode;

            // fn(obj);
        });
        /* Returns obj = {pos: '', code: '', name: ''} into callback*/
    },
    key: function (event, key, fn) {
        switch (event.keyCode) {
            case key:
                return fn();
            default:
                return false;
//            case 8:
//                /*backspace*/
//                break;
//            case 9:
//                /*tab*/
//                break;
//            case 13:
//                /*enter*/
//                break;
//            case 16:
//                /*shift*/
//                break;
//            case 17:
//                /*ctrl*/
//                break;
//            case 18:
//                /*alt*/
//                break;
//            case 19:
//                /*pause/break*/
//                break;
//            case 20:
//                /*caps lock*/
//                break;
//            case 27:
//                /*escape*/
//                break;
//            case 33:
//                /*page up*/
//                break;
//            case 34:
//                /*page down*/
//                break;
//            case 35:
//                /*end*/
//                break;
//            case 36:
//                /*home*/
//                break;
//            case 37:
//                /*left arrow*/
//                break;
//            case 38:
//                /*up arrow*/
//                break;
//            case 39:
//                /*right arrow*/
//                break;
//            case 40:
//                /*down arrow*/
//                break;
//            case 45:
//                /*insert*/
//                break;
//            case 46:
//                /*delete*/
//                break;
//            case 48:
//                /*0*/
//                break;
//            case 49:
//                /*1*/
//                break;
//            case 50:
//                /*2*/
//                break;
//            case 51:
//                /*3*/
//                break;
//            case 52:
//                /*4*/
//                break;
//            case 53:
//                /*5*/
//                break;
//            case 54:
//                /*6*/
//                break;
//            case 55:
//                /*7*/
//                break;
//            case 56:
//                /*8*/
//                break;
//            case 57:
//                /*9*/
//                break;
//            case 65:
//                /*a*/
//                break;
//            case 66:
//                /*b*/
//                break;
//            case 67:
//                /*c*/
//                break;
//            case 68:
//                /*d*/
//                break;
//            case 69:
//                /*e*/
//                break;
//            case 70:
//                /*f*/
//                break;
//            case 71:
//                /*g*/
//                break;
//            case 72:
//                /*h*/
//                break;
//            case 73:
//                /*i*/
//                break;
//            case 74:
//                /*j*/
//                break;
//            case 75:
//                /*k*/
//                break;
//            case 76:
//                /*l*/
//                break;
//            case 77:
//                /*m*/
//                break;
//            case 78:
//                /*n*/
//                break;
//            case 79:
//                /*o*/
//                break;
//            case 80:
//                /*p*/
//                break;
//            case 81:
//                /*q*/
//                break;
//            case 82:
//                /*r*/
//                break;
//            case 83:
//                /*s*/
//                break;
//            case 84:
//                /*t*/
//                break;
//            case 85:
//                /*u*/
//                break;
//            case 86:
//                /*v*/
//                break;
//            case 87:
//                /*w*/
//                break;
//            case 88:
//                /*x*/
//                break;
//            case 89:
//                /*y*/
//                break;
//            case 90:
//                /*z*/
//                break;
//            case 91:
//                /*left window key*/
//                break;
//            case 92:
//                /*right window key*/
//                break;
//            case 93:
//                /*select key*/
//                break;
//            case 96:
//                /*numpad 0*/
//                break;
//            case 97:
//                /*numpad 1*/
//                break;
//            case 98:
//                /*numpad 2*/
//                break;
//            case 99:
//                /*numpad 3*/
//                break;
//            case 100:
//                /*numpad 4*/
//                break;
//            case 101:
//                /*numpad 5*/
//                break;
//            case 102:
//                /*numpad 6*/
//                break;
//            case 103:
//                /*numpad 7*/
//                break;
//            case 104:
//                /*numpad 8*/
//                break;
//            case 105:
//                /*numpad 9*/
//                break;
//            case 106:
//                /*multiply*/
//                break;
//            case 107:
//                /*add*/
//                break;
//            case 109:
//                /*subtract*/
//                break;
//            case 110:
//                /*decimal point*/
//                break;
//            case 111:
//                /*divide*/
//                break;
//            case 112:
//                /*f1*/
//                break;
//            case 113:
//                /*f2*/
//                break;
//            case 114:
//                /*f3*/
//                break;
//            case 115:
//                /*f4*/
//                break;
//            case 116:
//                /*f5*/
//                break;
//            case 117:
//                /*f6*/
//                break;
//            case 118:
//                /*f7*/
//                break;
//            case 119:
//                /*f8*/
//                break;
//            case 120:
//                /*f9*/
//                break;
//            case 121:
//                /*f10*/
//                break;
//            case 122:
//                /*f11*/
//                break;
//            case 123:
//                /*f12*/
//                break;
//            case 144:
//                /*num lock*/
//                break;
//            case 145:
//                /*scroll lock*/
//                break;
//            case 186:
//                /*semi-colon*/
//                break;
//            case 187:
//                /*equal sign*/
//                break;
//            case 188:
//                /*comma*/
//                break;
//            case 189:
//                /*dash*/
//                break;
//            case 190:
//                /*period*/
//                break;
//            case 191:
//                /*forward slash*/
//                break;
//            case 192:
//                /*grave accent*/
//                break;
//            case 219:
//                /*open bracket*/
//                break;
//            case 220:
//                /*back slash*/
//                break;
//            case 221:
//                /*close braket*/
//                break;
//            case 222:
//                /*single quote*/
//                break;
//            default :
//                return false;
        }
    },
    mouse: function (event, mouse, fn) {
        switch (event.button) {
            case mouse:
                return fn();
            default:
                return false;
        }
//        if (right) {
//            switch (event.button) {    
//                case 0:
//                    /*Left mouse button*/
//                    break;
//                case 1:
//                    /*Wheel button or middle button (if present)*/
//                    break;
//                case 2:
//                    /*Right mouse button*/
//                    break;
//                default :
//                    return false;
//            }
//        } else {
//            switch (event.button) {
//                case 2:
//                    /*Left mouse button*/
//                    break;
//                case 1:
//                    /*Wheel button or middle button (if present)*/
//                    break;
//                case 0:
//                    /*Right mouse button*/
//                    break;
//                default :
//                    return false;
//            }
//        }
    }
};