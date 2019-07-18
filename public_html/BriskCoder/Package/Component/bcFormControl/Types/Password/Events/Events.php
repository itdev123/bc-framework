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

namespace BriskCoder\Package\Component\bcFormControl\Types\Password;

use BriskCoder\Package\Component\bcFormControl;

final class Events
{

    private
            $_events = array();

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types\Password' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * EDIT_IN_PLACE
     * AUTO_COMPLETE
     * TRIGGER
     * @return array $_settings
     */
    public function getSettings()
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( !isset( $this->_events[$currNS] ) ):
            /* CurrNs No Using Events return empty array */
            return $this->_events;
        endif;
        $_settings = $this->_events[$currNS];
        //reset statics before new component
        $this->_events[$currNS]['EDIT_IN_PLACE'] = array();
        $this->_events[$currNS]['AUTO_COMPLETE'] = array();
        $this->_events[$currNS]['TRIGGER'] = array();
        $_settings['NAMESPACE'] = $currNS; //used for custom html attr  data-ns-
        return $_settings;
        //returns array with all settings
    }

    /**
     * SET EDIT IN PLACE
     * @param String $EVENT Set javascript event to trigger events edit in place ie: 'focusout'|'keyup'
     * @param String $URI Set request uri
     * @param type $METHOD Set request method
     */
    public function setEditInPlace( $EVENT, $URI, $METHOD )
    {
        $settings = bcFormControl::getSettings();
        if ( $EVENT ):
            $this->_events[$settings['NAMESPACE']]['EDIT_IN_PLACE']['EVENT'] = $EVENT;
        endif;
        if ( $URI ):
            $this->_events[$settings['NAMESPACE']]['EDIT_IN_PLACE']['URL'] = $URI;
        endif;
        if ( $METHOD ):
            $this->_events[$settings['NAMESPACE']]['EDIT_IN_PLACE']['METHOD'] = $METHOD;
        endif;
    }

    /**
     * SET AUTO COMPLETE
     * @param String $EVENT Set javascript event to trigger events auto complete ie: 'focusout'|'keyup'
     * @param String $URI Set request uri
     * @param type $METHOD Set request method
     */
    public function setAutoComplete( $EVENT, $URI, $METHOD )
    {
        $settings = bcFormControl::getSettings();
        if ( $EVENT ):
            $this->_events[$settings['NAMESPACE']]['AUTO_COMPLETE']['EVENT'] = $EVENT;
        endif;
        if ( $URI ):
            $this->_events[$settings['NAMESPACE']]['AUTO_COMPLETE']['URL'] = $URI;
        endif;
        if ( $METHOD ):
            $this->_events[$settings['NAMESPACE']]['AUTO_COMPLETE']['METHOD'] = $METHOD;
        endif;
    }

    /**
     * SET TRIGGER
     * @param String $EVENT Set javascript event to trigger events trigger ie: 'focusout'|'keyup'
     * @param String $FUNCTION Any javascript function to be triggered
     */
    public function setTrigger( $EVENT, $FUNCTION )
    {
        $settings = bcFormControl::getSettings();
        if ( $EVENT ):
            $this->_events[$settings['NAMESPACE']]['TRIGGER']['EVENT'] = $EVENT;
        endif;
        if ( $FUNCTION ):
            $this->_events[$settings['NAMESPACE']]['TRIGGER']['FUNCTION'] = $FUNCTION;
        endif;
    }

}
