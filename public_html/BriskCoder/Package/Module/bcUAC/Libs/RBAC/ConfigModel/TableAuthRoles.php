<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableAuthRoles
{

    public

    /**
     * TABLE uac_auth_roles COLUMN id
     * PK NN AI INT(10)
     */
            $id,
            /**
             * TABLE uac_auth_roles COLUMN auth_id
             * NN UN INT(10)
             */
            $auth_id,
            /**
             * TABLE uac_auth_roles COLUMN role_id
             * NN UN SAMLLINT(5)
             */
            $role_id;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
