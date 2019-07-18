<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Builder;

final class Config
{

    public
    /**
     * Builder DB STORAGE RESOURCE
     * If FALSE then built-in Model is used, use bcAMS::builder()->configModel() to setup Connection NS and table structure,
     * Otherwise must implement \BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\i_Model from your Project's Builder\Model layer
     * Default FALSE
     * @var bool $STORAGE_RESOURCE
     */
            $STORAGE_RESOURCE = FALSE;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Builder' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
