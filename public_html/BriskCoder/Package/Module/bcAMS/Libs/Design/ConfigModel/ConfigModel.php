<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Design;

final class ConfigModel
{

    public
    /**
     * bcDB Connection NAMESPACE
     * Used with bcDB Library only
     * @var string $bcDB_NS
     */
            $bcDB_NS;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Design' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
