<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Layout;

use BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel\TableLayout;

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
             * TABLE ams_layout
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_ams_layout;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Layout' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Table Layout Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel\TableLayout
     */
    public function ams_layout()
    {
        static $obj;
        return $obj instanceof TableLayout ? $obj : $obj = new TableLayout( __CLASS__ );
    }

}
