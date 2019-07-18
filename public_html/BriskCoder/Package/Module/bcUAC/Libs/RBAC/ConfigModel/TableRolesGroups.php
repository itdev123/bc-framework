<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableRolesGroups
{

    public

    /**
     * TABLE uac_roles_groups COLUMN id
     * PK NN UN AI TINYINT(3)
     */
            $id,
            /**
             * TABLE uac_roles_groups COLUMN status
             * NN varchar(20) 
             */
            $name;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
