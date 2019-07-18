<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class TableRolesText
{

    public

    /**
     * TABLE uac_roles_text COLUMN id
     * PK NN UN AI INT(10)
     */
            $id,
            /**
             * TABLE uac_roles_text COLUMN role_id
             * NN UN SMALLINT(5)
             */
            $role_id,
            /**
             * TABLE uac_roles_text COLUMN language_id
             * NN UN SMALLINT(5)
             */
            $language_id,
            /**
             * TABLE uac_roles_text COLUMN name
             * NN VARCHAR(45)
             */
            $name,
            /**
             * TABLE uac_roles_text COLUMN description
             * VARCHAR(255)
             */
            $description,
            /**
             * TABLE uac_roles_text COLUMN created
             * NN UN BIGINT(20)
             */
            $created,
            /**
             * TABLE uac_roles_text COLUMN modified
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
