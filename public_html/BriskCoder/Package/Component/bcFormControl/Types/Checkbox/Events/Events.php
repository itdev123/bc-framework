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

namespace BriskCoder\Package\Component\bcFormControl\Types\Checkbox;

use BriskCoder\Package\Component\bcFormControl;

final class Events
{

    private
            $_events = array();

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types\Checkbox' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
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
        $this->_events[$currNS]['TRIGGER'] = array();
        $_settings['NAMESPACE'] = $currNS; //used for custom html attr  data-ns-
        return $_settings;
        //returns array with all settings
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
