<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth;

use BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuth,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuthLock,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuthQuestions;

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
             * TABLE uac_auth
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_auth,
            /**
             * TABLE uac_auth_lock
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_auth_lock,
            /**
             * TABLE uac_auth_questions
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_auth_questions;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Table Auth Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuth
     */
    public function uac_auth()
    {
        static $obj;
        return $obj instanceof TableAuth ? $obj : $obj = new TableAuth( __CLASS__ );
    }

    /**
     * Table Auth Lock Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuthLock
     */
    public function uac_auth_lock()
    {
        static $obj;
        return $obj instanceof TableAuthLock ? $obj : $obj = new TableAuthLock( __CLASS__ );
    }

    /**
     * Table Auth Questions Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel\TableAuthQuestions
     */
    public function uac_auth_questions()
    {
        static $obj;
        return $obj instanceof TableAuthQuestions ? $obj : $obj = new TableAuthQuestions( __CLASS__ );
    }

}
