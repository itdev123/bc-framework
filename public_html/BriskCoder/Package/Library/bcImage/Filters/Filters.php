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
 * @author RJ Anderson <rj@xpler.com>
 */
namespace BriskCoder\Package\Library\bcImage;

use BriskCoder\bc;

final class Filters
{
    
     public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcImage' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
    
    
    public function negate()
    {
       
    }

}