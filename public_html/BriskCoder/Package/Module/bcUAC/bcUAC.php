<?php

namespace BriskCoder\Package\Module;

use BriskCoder\Package\Module\bcUAC\Libs\Auth,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC,
    BriskCoder\Package\Module\bcUAC\Libs\Session;

/**
 * BC User Access Control 
 * If using bcDB, set desired connection namespace before operations.
 * Only once is necessary if not working with muliple databases.
 */
final class bcUAC
{

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * bcUAC Role-Based Access Control
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC
     */
    public static function rbac()
    {
        static $obj;
        return $obj instanceof  RBAC ? $obj : $obj = new RBAC( __CLASS__ );
    }

    /**
     * bcUAC Authentication
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth
     */
    public static function auth()
    {
        static $obj;
        return $obj instanceof  Auth ? $obj : $obj = new Auth( __CLASS__ );
    }

    /**
     * bcUAC Session
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Session
     */
    public static function session()
    {
        static $obj;
        return $obj instanceof  Session ? $obj : $obj = new Session( __CLASS__ );
    }

}