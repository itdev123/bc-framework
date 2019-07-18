<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles;

use  BriskCoder\Package\Library\bcDB;

final class uac_auth_roles implements \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_auth_roles
{

    public function __construct( $CALLER )
    {      
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * uac_roles RIGHT JOIN uac_auth_roles ON $colRoles->id  = $colAuthRoles->role_id<br>
     * RIGHT JOIN uac_permissions ON $colAuthRoles->role_id  = $colPermissions->role_id  AS TABLE SQL OBJECT
     * @staticvar Object $uac_permissions
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_auth_roles\i_uac_permissions     
     */
    public function te_uac_permissions()
    {
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\\' . bcDB::resource( 'RDBMS' ) . '\uac_roles\uac_auth_roles\uac_permissions';
        static $uac_permissions;
        return $uac_permissions instanceof $cls ? $uac_permissions : $uac_permissions = new $cls( __CLASS__ );
    }

}
