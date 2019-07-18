<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Builder;

final class Utils
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Builder' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
