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

namespace BriskCoder\Package\Library;

use BriskCoder\Package\Library\bcData\Manipulate,
    BriskCoder\Package\Library\bcData\Validate;

final class bcData
{
    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * STRING MANIPULATION LIBRARY
     * @staticvar Manipulate $obj
     * @return \BriskCoder\Package\Library\bcData\Manipulate
     */
    public static function manipulate()
    {
        static $obj;
        return $obj instanceof Manipulate ? $obj : $obj = new Manipulate( __CLASS__ );
    }

    /**
     * DATA TYPE|FORMAT VALIDATION LIBRARY
     * @staticvar Validate $obj
     * @return \BriskCoder\Package\Library\bcData\Validate
     */
    public static function validate()
    {
        static $obj;
        return $obj instanceof Validate ? $obj : $obj = new Validate( __CLASS__ );
    }

}
