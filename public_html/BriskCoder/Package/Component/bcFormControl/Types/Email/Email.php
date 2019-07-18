<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     Package
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\Package\Component\bcFormControl\Types;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcHTML,
    BriskCoder\Package\Component\bcFormControl,
    BriskCoder\Package\Component\bcFormControl\Types\Email\Events,
    BriskCoder\Package\Component\bcFormControl\Types\Email\Validate;

final class Email
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Email Events
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Email\Events
     */
    public function events()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Events( __CLASS__ );
    }

    /**
     * Email Validate
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Email\Validate
     */
    public function validate()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Validate( __CLASS__ );
    }

    /**
     * Get Email Markup
     * @param type $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param string $_ATTRIBUTES Set attribites such as CLASS|ID|DATA-
     * @param type $CUSTOM Set to TRUE to use custom field instead of an input
     * @return string Html Markup
     */
    public function getMarkup( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM )
    {
        //TODO... check if  bcFormControl::$BIND and then if each validation requires events to trigger on submit only
        //need to add this flag for each validate function then find a way to trigger them on click of submit button
        //probably using a Trigger function and then looking for all data-bc-bind-{namespace}={attr names} and trigger the events on the list
        //creaTE A private property that will gather all validation events available per component and then check when calling this method and set the entire list
        //on data-bc-val-events="onblur,onchage" 

        $_validate_settings = $this->validate()->getSettings();
        if ( !empty( $_validate_settings['VALIDATE_RANGE'] ) ):
            $event = isset( $_validate_settings['VALIDATE_RANGE']['EVENT'] ) ? $_validate_settings['VALIDATE_RANGE']['EVENT'] : NULL;
            $min = isset( $_validate_settings['VALIDATE_RANGE']['MIN'] ) ? $_validate_settings['VALIDATE_RANGE']['MIN'] : NULL;
            $max = isset( $_validate_settings['VALIDATE_RANGE']['MAX'] ) ? $_validate_settings['VALIDATE_RANGE']['MAX'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_RANGE']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_RANGE']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_RANGE']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_RANGE']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_RANGE']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_RANGE']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.range(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $min . '\',\'' . $max . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
        endif;
        if ( !empty( $_validate_settings['VALIDATE_REGEX'] ) ):
            $event = isset( $_validate_settings['VALIDATE_REGEX']['EVENT'] ) ? $_validate_settings['VALIDATE_REGEX']['EVENT'] : NULL;
            $mask = isset( $_validate_settings['VALIDATE_REGEX']['MASK'] ) ? $_validate_settings['VALIDATE_REGEX']['MASK'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_REGEX']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_REGEX']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_REGEX']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_REGEX']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_REGEX']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_REGEX']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.regex(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $mask . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
        endif;
        if ( !empty( $_validate_settings['VALIDATE_REQUIRED'] ) ):
            $event = isset( $_validate_settings['VALIDATE_REQUIRED']['EVENT'] ) ? $_validate_settings['VALIDATE_REQUIRED']['EVENT'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.required(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
        endif;
        if ( !empty( $_validate_settings['VALIDATE_TYPE'] ) ):
            $event = isset( $_validate_settings['VALIDATE_TYPE']['EVENT'] ) ? $_validate_settings['VALIDATE_TYPE']['EVENT'] : NULL;
            $type = isset( $_validate_settings['VALIDATE_TYPE']['TYPE'] ) ? $_validate_settings['VALIDATE_TYPE']['TYPE'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_TYPE']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_TYPE']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_TYPE']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_TYPE']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_TYPE']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_TYPE']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.type(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $type . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
        endif;

        $_events_settings = $this->events()->getSettings();
        if ( !empty( $_events_settings['EDIT_IN_PLACE'] ) ):
            $event = isset( $_events_settings['EDIT_IN_PLACE']['EVENT'] ) ? $_events_settings['EDIT_IN_PLACE']['EVENT'] : NULL;
            $url = isset( $_events_settings['EDIT_IN_PLACE']['URL'] ) ? $_events_settings['EDIT_IN_PLACE']['URL'] : NULL;
            $method = isset( $_events_settings['EDIT_IN_PLACE']['METHOD'] ) ? $_events_settings['EDIT_IN_PLACE']['METHOD'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.events.editInPlace(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $url . '\',\'' . $method . '\');', 'js', TRUE );
        endif;
        if ( !empty( $_events_settings['AUTO_COMPLETE'] ) ):
            $event = isset( $_events_settings['AUTO_COMPLETE']['EVENT'] ) ? $_events_settings['AUTO_COMPLETE']['EVENT'] : NULL;
            $url = isset( $_events_settings['AUTO_COMPLETE']['URL'] ) ? $_events_settings['AUTO_COMPLETE']['URL'] : NULL;
            $method = isset( $_events_settings['AUTO_COMPLETE']['METHOD'] ) ? $_events_settings['AUTO_COMPLETE']['METHOD'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.events.autoComplete(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $url . '\',\'' . $method . '\');', 'js', TRUE );
        endif;
        if ( !empty( $_events_settings['TRIGGER'] ) ):
            $event = isset( $_events_settings['TRIGGER']['EVENT'] ) ? $_events_settings['TRIGGER']['EVENT'] : NULL;
            $function = isset( $_events_settings['TRIGGER']['FUNCTION'] ) ? $_events_settings['TRIGGER']['FUNCTION'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.events.trigger(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $function . '\');', 'js', TRUE );
        endif;

        if ( !$CUSTOM ):
            if ( bcFormControl::$BIND === TRUE ):
                $_ATTRIBUTES[] = 'data-bc-bind="' . $IDENTIFIER . '"';
            endif;
            bcHTML::form()->text( $_ATTRIBUTES );
            return bcHTML::form()->getMarkup();
        endif;
    }

}
