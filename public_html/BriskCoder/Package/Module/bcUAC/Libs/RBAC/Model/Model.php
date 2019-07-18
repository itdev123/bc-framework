<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model;

use BriskCoder\Package\Library\bcDB;

final class Model implements i_Model
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * uac_auth_roles TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_auth_roles
     */
    public function uac_auth_roles()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_auth_roles';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_permissions TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_permissions
     */
    public function uac_permissions()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_permissions';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_roles TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles
     */
    public function uac_roles()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_roles_text TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_text
     */
    public function uac_roles_text()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles_text';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_roles_groups TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups
     */
    public function uac_roles_groups()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles_groups';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_roles_groups_text TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups_text
     */
    public function uac_roles_groups_text()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles_groups_text';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * uac_roles_domains TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_domains
     */
    public function uac_roles_domains()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles_domains';
        static $obj;
        return $obj instanceof $cls ? $obj : $obj = new $cls( __CLASS__ );
    }

}
