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

final class Events
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== ' BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SET TRIGGER
     * @param String $EVENT Set javascript event to trigger events trigger ie: 'focusout'|'keyup'
     * @param String $FUNCTION Any javascript function to be triggered
     */
    public function setTrigger( $EVENT, $FUNCTION )
    {
        bcFormControl::types()->text()->events()->setTrigger( $EVENT, $FUNCTION );
    }

}
