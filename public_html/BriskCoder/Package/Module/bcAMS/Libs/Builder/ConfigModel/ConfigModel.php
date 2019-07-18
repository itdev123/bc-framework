<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Builder;

use BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel\TableBuilder;

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
             * TABLE ams_builder
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_ams_builder;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Builder' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Table Builder Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel\TableBuilder
     */
    public function ams_builder()
    {
        static $obj;
        return $obj instanceof TableBuilder ? $obj : $obj = new TableBuilder( __CLASS__ );
    }

}
