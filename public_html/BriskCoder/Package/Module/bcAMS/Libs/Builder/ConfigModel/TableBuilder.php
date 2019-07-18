<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel;

final class TableBuilder
{

    public
    /**
     * TABLE ams_builder COLUMN id
     * PK NN UN AI BIGINT(20)
     */
            $id;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
