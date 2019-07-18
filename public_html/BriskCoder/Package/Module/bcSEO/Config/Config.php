<?php

namespace BriskCoder\Package\Module\bcSEO;

use BriskCoder\bc;

final class Config
{

    public
    /**
     * SEO DB STORAGE RESOURCE SETTER
     * If FALSE then built-in Model is used, use bcSEO::configModel()->seo() to setup Connection NS and table structure,
     * Otherwise must implement \BriskCoder\Package\Module\bcSEO\Model\i_seo from your Project's Logic\Model layer
     * Default FALSE
     * @var bool $STORAGE_RESOURCE
     */
            $STORAGE_RESOURCE = FALSE;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcSEO' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SET DYNAMIC ROUTE
     * Must be used for SEO Friendly URL by stopping router<br>
     * and before using bcSEO::urlTrannslate();
     * @param String $DYNAMIC_ROUTE
     * Dispatcher or Dispatcher alias
     * @param Boolean $PERMANENT 
     * Set $permanent to FALSE to allow to read dispatcher within dynamic route,<br>
     * otherwise always read as dynamic route even if it's a dispatcher
     */
    public function setDynamicRoute( $DYNAMIC_ROUTE, $PERMANENT )
    {
        bc::registry()->_DYNAMIC_ROUTE[$DYNAMIC_ROUTE] = $PERMANENT;
    }

}
