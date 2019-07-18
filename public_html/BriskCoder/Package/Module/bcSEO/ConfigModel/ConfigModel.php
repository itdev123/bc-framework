<?php

namespace BriskCoder\Package\Module\bcSEO;

use BriskCoder\Package\Module\bcSEO\ConfigModel\TableSEO;

final class ConfigModel
{

    public
    /**
     * bcDB Connection NAMESPACE
     * Used with bcDB Library only
     * @var string $bcDB_NS
     */
            $bcDB_NS,
            /**
             * TABLE seo
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_seo;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcSEO' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Table URL Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcSEO\ConfigModel\TableSEO
     */
    public function seo()
    {
        static $obj;
        return $obj instanceof TableSEO ? $obj : $obj = new TableSEO( __CLASS__ );
    }
}
