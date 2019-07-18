<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Layout\Model;

use BriskCoder\Package\Library\bcDB;

final class Model implements i_Model
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Layout' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * ams_layout TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_ams_layout
     */
    public function ams_layout()
    {
        $cls = 'BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\\' . bcDB::resource( 'RDBMS' ) . '\ams_layout';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

}
