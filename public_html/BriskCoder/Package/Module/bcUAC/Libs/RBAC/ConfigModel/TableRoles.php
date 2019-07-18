<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableRoles
{

    public

    /**
     * TABLE uac_roles COLUMN id
     * PK NN UN AI SAMLLINT(5)
     */
            $id,
            /**
             * TABLE uac_roles COLUMN status
             * NN UN DEFAULT '0' TINYINT(1) 
             */
            $status,
            /**
             * TABLE uac_roles COLUMN priority
             * NN UN DEFAULT '0' INT(11)
             */
            $priority,
             /**
             * TABLE uac_roles COLUMN group_id
             * NN UN TINYINT(3)
             */
            $group_id;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
