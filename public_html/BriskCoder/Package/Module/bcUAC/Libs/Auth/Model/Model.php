<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Model;

use BriskCoder\Package\Library\bcDB;

final class Model implements i_Model
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * uac_auth TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth
     */
    public function uac_auth()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_auth';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_auth_lock TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth_lock
     */
    public function uac_auth_lock()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_auth_lock';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_auth_questions TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth_questions
     */
    public function uac_auth_questions()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_auth_questions';
        static $obj;
        return $obj instanceof$cls ? $obj : $obj = new $cls( __CLASS__ );
    }

}
