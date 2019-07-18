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

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember;

use BriskCoder\Package\Component\bcFormControl;

final class Validate
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
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

}
