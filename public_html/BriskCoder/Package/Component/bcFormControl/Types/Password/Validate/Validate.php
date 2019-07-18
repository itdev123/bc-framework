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

final class Validate
{

    private
            $_validations = array();

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types\Password' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * VALIDATE_RANGE
     * VALIDATE_REGEX
     * VALIDATE_REQUIRED
     * VALIDATE_TYPE
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
        $this->_validations[$currNS]['VALIDATE_RANGE'] = array();
        $this->_validations[$currNS]['VALIDATE_REGEX'] = array();
        $this->_validations[$currNS]['VALIDATE_REQUIRED'] = array();
        $this->_validations[$currNS]['VALIDATE_TYPE'] = array();
        $_settings['NAMESPACE'] = $currNS; //used for custom html attr  data-ns-
        return $_settings;
//returns array with all settings
    }

    /**
     * SETS VALIDATION BY RANGE APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validation  ie: 'focusout'|'keyup'
     * @param String $MIN Minimum Acceptable Length Within Range
     * @param String $MAX Maximum Acceptable Length Within Range
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRange( $EVENT, $MIN, $MAX, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( $EVENT ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['EVENT'] = $EVENT;
        endif;
        if ( $MIN ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['MIN'] = $MIN;
        endif;
        if ( $MAX ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['MAX'] = $MAX;
        endif;
        if ( $MSG_FAIL ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['MSG_FAIL'] = $MSG_FAIL;
        endif;
        if ( $MSG_PASS ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['MSG_PASS'] = $MSG_PASS;
        endif;
        if ( $MSG_CONTAINER ):
            $this->_validations[$currNS]['VALIDATE_RANGE']['MSG_CONTAINER'] = $MSG_CONTAINER;
        endif;
    }

    /**
     * SETS VALIDATION BY REGEX APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validation  ie: 'focusout'|'keyup'
     * @param String $MASK Regex Validation
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRegex( $EVENT, $MASK, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( $EVENT ):
            $this->_validations[$currNS]['VALIDATE_REGEX']['EVENT'] = $EVENT;
        endif;
        if ( $MASK ):
            $this->_validations[$currNS]['VALIDATE_REGEX']['MASK'] = $MASK;
        endif;
        if ( $MSG_FAIL ):
            $this->_validations[$currNS]['VALIDATE_REGEX']['MSG_FAIL'] = $MSG_FAIL;
        endif;
        if ( $MSG_PASS ):
            $this->_validations[$currNS]['VALIDATE_REGEX']['MSG_PASS'] = $MSG_PASS;
        endif;
        if ( $MSG_CONTAINER ):
            $this->_validations[$currNS]['VALIDATE_REGEX']['MSG_CONTAINER'] = $MSG_CONTAINER;
        endif;
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

    /**
     * SETS VALIDATION BY TYPE APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validation  ie: 'focusout'|'keyup'
     * @param String $TYPE TYPE_ALPHANUMERIC|TYPE_DECIMAL|TYPE_HEXDECIMAL|TYPE_NUMERIC|TYPE_OCTAL|TYPE_STRING
     * bcFormControl already has its preset constants types ie: bcFormControl::TYPE_ALPHANUMERIC|bcFormControl::TYPE_DECIMAL...
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateType( $EVENT, $TYPE, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        if ( $EVENT ):
            $this->_validations[$currNS]['VALIDATE_TYPE']['EVENT'] = $EVENT;
        endif;
        if ( $TYPE ):
            $this->_validations[$currNS]['VALIDATE_TYPE']['TYPE'] = $TYPE;
        endif;
        if ( $MSG_FAIL ):
            $this->_validations[$currNS]['VALIDATE_TYPE']['MSG_FAIL'] = $MSG_FAIL;
        endif;
        if ( $MSG_PASS ):
            $this->_validations[$currNS]['VALIDATE_TYPE']['MSG_PASS'] = $MSG_PASS;
        endif;
        if ( $MSG_CONTAINER ):
            $this->_validations[$currNS]['VALIDATE_TYPE']['MSG_CONTAINER'] = $MSG_CONTAINER;
        endif;
    }

}
