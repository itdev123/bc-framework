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

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types;

use BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember\Events,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember\Validate;

final class Remember
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Remember Events
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember\Events
     */
    public function events()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Events( __CLASS__ );
    }

    /**
     * Remember Validate
     * Use BriskCoder\Package\Component\bcJSInc::briskCoderFormControl() to add briskCoderFormControl.js to head includes.     
     * Requires <!--bc.head--><!--bc--> in the view page to include css and js resource or links
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember\Validate
     */
    public function validate()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Validate( __CLASS__ );
    }

}
