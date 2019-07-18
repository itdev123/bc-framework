<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Builder\Model;

use BriskCoder\Package\Library\bcDB;

final class Model implements i_Model
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Builder' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * ams_builder TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcAMS\Builder\Model\i_ams_builder
     */
    public function ams_builder()
    {
        $cls = 'BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\\' . bcDB::resource( 'RDBMS' ) . '\ams_builder';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

}
