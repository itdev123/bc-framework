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

namespace BriskCoder\Package\Component\bcFormControl\Types;

use BriskCoder\Package\Component\bcFormControl;

final class i18n extends bcFormControl
{

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\Types' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;

        $this->basePath = BC_COMPONENTS_PUBLIC_URI . 'bcFormControl/Input/Validate';
    }

    public function en_us()
    {
        
    }
    
    public function en_uk()
    {
        
    }
    
    


}
