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

use BriskCoder\Package\Library\bcHTML\Form,
    BriskCoder\Package\Library\bcHTML\Head,
    BriskCoder\Package\Library\bcHTML\Table,
    BriskCoder\Package\Library\bcHTML\Tag;

class bcHTML
{

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }
    
    /**
     * HTML Form Elements Constructor
     * @static $obj
     * @return \BriskCoder\Package\Library\bcHTML\Form;
     */
    public static function form()
    {
        static $obj;
        return $obj instanceof Form ? $obj : $obj = new Form( __CLASS__ );
    }

    /**
     * HTML Head Elements Constructor
     * @static $obj
     * @return \BriskCoder\Package\Library\bcHTML\Head;
     */
    public static function head()
    {
        static $obj;
        return $obj instanceof Head ? $obj : $obj = new Head( __CLASS__ );
    }

    /**
     * HTML Table Elements Constructor
     * @static $obj
     * @return \BriskCoder\Package\Library\bcHTML\Table;
     */
    public static function table()
    {
        static $obj;
        return $obj instanceof Table ? $obj : $obj = new Table( __CLASS__ );
    }
    
    /**
     * HTML Tag Elements Constructor
     * @static $obj
     * @return \BriskCoder\Package\Library\bcHTML\Tag;
     */
    public static function tag()
    {
        static $obj;
        return $obj instanceof Tag ? $obj : $obj = new Tag( __CLASS__ );
    }
}