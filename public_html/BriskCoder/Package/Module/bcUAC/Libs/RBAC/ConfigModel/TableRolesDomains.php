<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableRolesDomains
{

    public

    /**
     * TABLE uac_roles_domains COLUMN id
     * PK NN UN AI INT(10)
     */
            $id,
            /**
             * TABLE uac_roles_domains COLUMN domain_id
             * NN UN SMALLINT(5)
             */
            $domain_id,
            /**
             * TABLE uac_roles_domains COLUMN role_id
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
