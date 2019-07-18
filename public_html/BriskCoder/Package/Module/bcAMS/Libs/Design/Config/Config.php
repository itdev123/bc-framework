<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Design;

final class Config
{

    public
    /**
     * Design DB STORAGE RESOURCE
     * If FALSE then built-in Model is used, use bcAMS::design()->configModel() to setup Connection NS and table structure,
     * Otherwise must implement \BriskCoder\Package\Module\bcAMS\Libs\Design\Model\i_Model from your Project's Logic\Model layer
     * Default FALSE
     * @var bool $STORAGE_RESOURCE
     */
            $STORAGE_RESOURCE = FALSE;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Design' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
