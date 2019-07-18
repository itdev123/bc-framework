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
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Password;

use BriskCoder\Package\Component\bcFormControl;

final class Validate
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Password' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SETS VALIDATION BY RANGE APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validate range ie: 'focusout'|'keyup'
     * @param String $MIN Minimum Acceptable Length Within Range
     * @param String $MAX Maximum Acceptable Length Within Range
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRange( $EVENT, $MIN, $MAX, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        bcFormControl::types()->text()->validate()->validateRange( $EVENT, $MIN, $MAX, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER );
    }

    /**
     * SETS VALIDATION BY REGEX APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validate regex ie: 'focusout'|'keyup'
     * @param String $MASK Regex Validation
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRegex( $EVENT, $MASK, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        bcFormControl::types()->text()->validate()->validateRegex( $EVENT, $MASK, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER );
    }

    /**
     * SETS VALIDATION BY REQUIRING FIELDS NOT BE EMPTY
     * @param String $EVENT Set javascript event to trigger validate required ie: 'focusout'|'keyup'
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateRequired( $EVENT, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        bcFormControl::types()->text()->validate()->validateRequired( $EVENT, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER );
    }

    /**
     * SETS VALIDATION BY TYPE APPLICABLE TO INPUTS ONLY
     * @param String $EVENT Set javascript event to trigger validate type ie: 'focusout'|'keyup'
     * @param String $TYPE TYPE_ALPHANUMERIC|TYPE_DECIMAL|TYPE_HEXDECIMAL|TYPE_NUMERIC|TYPE_OCTAL|TYPE_STRING
     * bcFormControl already has its preset constants types ie: bcFormControl::TYPE_ALPHANUMERIC|bcFormControl::TYPE_DECIMAL...
     * @param String $MSG_FAIL Text|HTML Message Diplayed Within $MSG_CONTAINER On Error
     * @param String $MSG_PASS Text|HTML Message Diplayed Within $MSG_CONTAINER On Success
     * @param String $MSG_CONTAINER CSS ID|Class Definining Where Message is Displayed
     */
    public function validateType( $EVENT, $TYPE, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER )
    {
        bcFormControl::types()->text()->validate()->validateType( $EVENT, $TYPE, $MSG_FAIL, $MSG_PASS, $MSG_CONTAINER );
    }

}
