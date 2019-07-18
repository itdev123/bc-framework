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

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config;

use BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\User,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Password,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\SecurityAnswers,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Button;

final class Types
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Type User
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\User
     */
    public function user()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new User( __CLASS__ );
    }

    /**
     * Type Password
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Password
     */
    public function password()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Password( __CLASS__ );
    }

    /**
     * Type SecurityAnswers
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\SecurityAnswers
     */
    public function securityAnswers()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new SecurityAnswers( __CLASS__ );
    }

    /**
     * Type Remember
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Remember
     */
    public function remember()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Remember( __CLASS__ );
    }

    /**
     * Type Button
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types\Button
     */
    public function button()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Button( __CLASS__ );
    }

}
