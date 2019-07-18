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

namespace BriskCoder\Package\Component\bcFormControl;

use BriskCoder\Package\Component\bcFormControl\Types\Email,
    BriskCoder\Package\Component\bcFormControl\Types\Checkbox,
    BriskCoder\Package\Component\bcFormControl\Types\Password,
    BriskCoder\Package\Component\bcFormControl\Types\Radio,
    BriskCoder\Package\Component\bcFormControl\Types\Select,
    BriskCoder\Package\Component\bcFormControl\Types\Text,
    BriskCoder\Package\Component\bcFormControl\Types\Button,
    BriskCoder\Package\Component\bcFormControl\Types\i18n;

final class Types
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Type Email
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Email
     */
    public function email()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Email( __CLASS__ );
    }

    /**
     * Type Checkbox
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Checkbox
     */
    public function checkbox()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Checkbox( __CLASS__ );
    }

    /**
     * Type Password
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Password
     */
    public function password()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Password( __CLASS__ );
    }

    /**
     * Type Radio
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Radio
     */
    public function radio()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Radio( __CLASS__ );
    }

    /**
     * Type Select
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Select
     */
    public function select()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Select( __CLASS__ );
    }

    /**
     * Type Text
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Text
     */
    public function text()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Text( __CLASS__ );
    }

    /**
     * Type Button
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\Button
     */
    public function button()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Button( __CLASS__ );
    }

    /**
     * Type i18n
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types\i18n
     */
    public function i18n()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new i18n( __CLASS__ );
    }

}
