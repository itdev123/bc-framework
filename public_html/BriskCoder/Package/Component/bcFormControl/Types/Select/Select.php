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
    BriskCoder\Package\Component\bcFormControl\Types\Select\Events,
    BriskCoder\Package\Component\bcFormControl\Types\Select\Validate;

final class Select
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Select Events
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Select\Events
     */
    public function events()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Events( __CLASS__ );
    }

    /**
     * Select Validate
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Select\Validate
     */
    public function validate()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Validate( __CLASS__ );
    }

    /**
     * Get Select Markup
     * @param String $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param Array $_OPTIONS Select options ie: $_options[value] = 'text' || if setting optGroup then <br>
     * $_options[label] = array( value => 'text'), if array value is identified as array type the optgroup is set.
     * @param Array $_OPTION_ATTRIBUTES Options & optgroup attributes ie:  $_option_attributes[$_options key] = array('disabled="disabled"', 'label="your_label"') <br>
     * As longs as $_option_attributes has the matching key from $_options it works for optgroup parameters and option parameters.
     * @param Boolean $CUSTOM Set to TRUE to use custom field instead of an input
     * @return string Html Markup
     */
    public function getMarkup( $IDENTIFIER, $_OPTIONS, $_OPTION_ATTRIBUTES, $CUSTOM )
    {
        //use identifier to pass to getValidation() so it can bind to trigger executions of
        //events list
        //get bcFormControl::getSettings()
        //test for bind, autocomplete, editinplace, validation etc
        //create input and set custom attribute data-ns- as namespace
        //TODO... check if  bcFormControl::$BIND and then if each validation requires events to trigger on submit only
        //need to add this flag for each validate function then find a way to trigger them on click of submit button
        //probably using a Trigger function and then looking for all data-bc-bind-{namespace}={attr names} and trigger the events on the list
        //creaTE A private property that will gather all validation events available per component and then check when calling this method and set the entire list
        //on data-bc-val-events="onblur,onchage" 

        $_validate_settings = $this->validate()->getSettings();
        if ( !empty( $_validate_settings['VALIDATE_REQUIRED'] ) ):
            $event = isset( $_validate_settings['VALIDATE_REQUIRED']['EVENT'] ) ? $_validate_settings['VALIDATE_REQUIRED']['EVENT'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.required(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
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
            $_SELECT_ATTRIBUTES[] = 'name="' . $IDENTIFIER . '"';
            if ( bcFormControl::$BIND === TRUE ):
                $_SELECT_ATTRIBUTES[] = 'data-bc-bind="' . $IDENTIFIER . '"';
            endif;
            bcHTML::form()->select( $_OPTIONS, $_SELECT_ATTRIBUTES, $_OPTION_ATTRIBUTES );
            return bcHTML::form()->getMarkup();
        endif;
        /* CUSTOM FORM SELECT */
    }

}
