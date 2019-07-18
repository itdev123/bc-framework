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
    BriskCoder\Package\Component\bcFormControl\Types\Checkbox\Events,
    BriskCoder\Package\Component\bcFormControl\Types\Checkbox\Validate;

final class Checkbox
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Checkbox Events
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Checkbox\Events
     */
    public function events()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Events( __CLASS__ );
    }

    /**
     * Checkbox Validate
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Checkbox\Validate
     */
    public function validate()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Validate( __CLASS__ );
    }

    /**
     * Get Checkbox Markup
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
        if ( !empty( $_validate_settings['VALIDATE_REQUIRED'] ) ):
            $event = isset( $_validate_settings['VALIDATE_REQUIRED']['EVENT'] ) ? $_validate_settings['VALIDATE_REQUIRED']['EVENT'] : NULL;
            $msg_fail = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_FAIL'] : NULL;
            $msg_pass = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_PASS'] : NULL;
            $msg_container = isset( $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] ) ? $_validate_settings['VALIDATE_REQUIRED']['MSG_CONTAINER'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.validate.required(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $msg_fail . '\', \'' . $msg_pass . '\', \'' . $msg_container . '\');', 'js', TRUE );
        endif;

        $_events_settings = $this->events()->getSettings();
        if ( !empty( $_events_settings['TRIGGER'] ) ):
            $event = isset( $_events_settings['TRIGGER']['EVENT'] ) ? $_events_settings['TRIGGER']['EVENT'] : NULL;
            $function = isset( $_events_settings['TRIGGER']['FUNCTION'] ) ? $_events_settings['TRIGGER']['FUNCTION'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.events.trigger(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $function . '\');', 'js', TRUE );
        endif;

        if ( !$CUSTOM ):
            if ( bcFormControl::$BIND === TRUE ):
                $_ATTRIBUTES[] = 'data-bc-bind="' . $IDENTIFIER . '"';
            endif;
            bcHTML::form()->checkbox( $_ATTRIBUTES );
            return bcHTML::form()->getMarkup();
        endif;
    }

}
