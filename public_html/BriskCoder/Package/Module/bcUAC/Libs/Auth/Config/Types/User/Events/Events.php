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

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\User;

use BriskCoder\Package\Component\bcFormControl;

final class Events
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== ' BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\User' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SET EDIT IN PLACE
     * @param String $EVENT Set javascript event to trigger events edit in place ie: 'focusout'|'keyup'
     * @param String $URI Set request uri
     * @param type $METHOD Set request method
     */
    public function setEditInPlace( $EVENT, $URI, $METHOD )
    {
        bcFormControl::types()->text()->events()->setEditInPlace( $EVENT, $URI, $METHOD );
    }

    /**
     * SET AUTO COMPLETE
     * @param String $EVENT Set javascript event to trigger events auto complete ie: 'focusout'|'keyup'
     * @param String $URI Set request uri
     * @param type $METHOD Set request method
     */
    public function setAutoComplete( $EVENT, $URI, $METHOD )
    {
        bcFormControl::types()->text()->events()->setAutoComplete( $EVENT, $URI, $METHOD );
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
