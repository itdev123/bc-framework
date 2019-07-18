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

namespace BriskCoder\Package\Component\bcFormControl\Types\Radio;

use BriskCoder\Package\Component\bcFormControl;

final class Validate
{

    private
            $_validations = array();

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types\Radio' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * VALIDATE_REQUIRED
     * @return array $_settings
     */
    public function getSettings()
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( !isset( $this->_validations[$currNS] ) ):
            /* CurrNs No Using Validate return empty array */
            return $this->_validations;
        endif;
        $_settings = $this->_validations[$currNS];
//reset before new component
        $this->_validations[$currNS]['VALIDATE_REQUIRED'] = array();
        $_settings['NAMESPACE'] = $currNS; //used for custom html attr  data-ns-
        return $_settings;
//returns array with all settings
    }

    /**
     * SETS VALIDATION BY REQUIRING FIELDS NOT BE EMPTY
     * @param String $EVENT Set javascript event to trigger validation  ie: 'focusout'|'keyup'
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRequired( $EVENT, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( $EVENT ):
            $this->_validations[$currNS]['VALIDATE_REQUIRED']['EVENT'] = $EVENT;
        endif;
        if ( $MSG_FAIL ):
            $this->_validations[$currNS]['VALIDATE_REQUIRED']['MSG_FAIL'] = $MSG_FAIL;
        endif;
        if ( $MSG_PASS ):
            $this->_validations[$currNS]['VALIDATE_REQUIRED']['MSG_PASS'] = $MSG_PASS;
        endif;
        if ( $MSG_CONTAINER ):
            $this->_validations[$currNS]['VALIDATE_REQUIRED']['MSG_CONTAINER'] = $MSG_CONTAINER;
        endif;
    }

}
