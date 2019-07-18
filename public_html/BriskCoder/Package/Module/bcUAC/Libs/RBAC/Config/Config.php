<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC;

final class Config
{

    public
    /**
     * RBAC DB STORAGE RESOURCE
     * If FALSE then built-in Model is used, use bcUAC->rbac()->configModel() to setup Connection NS and table structure,
     * Otherwise must implement \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_Model from your Project's Logic\Model layer
     * @var bool $STORAGE_RESOURCE
     */
            $STORAGE_RESOURCE = FALSE;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
