<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableRolesGroupsText
{

    public

    /**
     * TABLE uac_roles_groups_text COLUMN id
     * PK NN UN AI SMALLINT(7)
     */
            $id,
            /**
             * TABLE uac_roles_groups_text COLUMN groups_id
             * NN UN TINYINT(3)
             */
            $group_id,
            /**
             * TABLE uac_roles_groups_text COLUMN language_id
             * NN UN SMALLINT(5)
             */
            $language_id,
            /**
             * TABLE uac_roles_groups_text COLUMN name
             * NN VARCHAR(45)
             */
            $name,
            /**
             * TABLE uac_roles_groups_text COLUMN created
             * NN UN BIGINT(20)
             */
            $created,
            /**
             * TABLE uac_roles_groups_text COLUMN modified
             * UN BIGINT(20)
             */
            $modified;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
