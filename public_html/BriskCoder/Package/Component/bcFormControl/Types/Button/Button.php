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
    BriskCoder\Package\Component\bcFormControl\Types\Button\Events;

final class Button
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Button Events
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Button\Events
     */
    public function events()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Events( __CLASS__ );
    }

    /**
     * Get Button Markup
     * @param type $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param string $VALUE Button value
     * @param string $_ATTRIBUTES Set attribites such as CLASS|ID|DATA-
     * @param boolean $SUBMIT Set to FALSE to use type button. TRUE type submit.
     * @return string Html Markup
     */
    public function getMarkup( $IDENTIFIER, $VALUE, $_ATTRIBUTES, $SUBMIT )
    {
        $_events_settings = $this->events()->getSettings();
        if ( !empty( $_events_settings['TRIGGER'] ) ):
            $event = isset( $_events_settings['TRIGGER']['EVENT'] ) ? $_events_settings['TRIGGER']['EVENT'] : NULL;
            $function = isset( $_events_settings['TRIGGER']['FUNCTION'] ) ? $_events_settings['TRIGGER']['FUNCTION'] : NULL;
            bc::publisher()->addHeadIncludes( 'bcFormControl.events.trigger(\'' . $IDENTIFIER . '\',\'' . $event . '\',\'' . $function . '\');', 'js', TRUE );
        endif;

        if ( bcFormControl::$BIND === TRUE ):
            $_ATTRIBUTES[] = 'data-bc-bind="' . $IDENTIFIER . '"';
        endif;
        if ( $SUBMIT ):
            bcHTML::form()->submit( $VALUE, $_ATTRIBUTES );
        else:
            bcHTML::form()->button( $VALUE, $_ATTRIBUTES );
        endif;
        return bcHTML::form()->getMarkup();
    }

}
