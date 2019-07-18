<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Design\Model;

use BriskCoder\Package\Library\bcDB;

final class Model implements i_Model
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Design' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
