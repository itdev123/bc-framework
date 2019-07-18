<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;


final class TablePermissions
{
    public 
            
            /**
             * TABLE uac_permissions COLUMN id
             * PK NN AI INT(10)
             */
            $id,
            
            /**
             * TABLE uac_permissions COLUMN role_id
             * NN UN SAMLLINT(5)
             */
            $role_id,
            
            /**
             * TABLE uac_permissions COLUMN dispatcher_uuid
             * NN VARBINARY(36)
             */
            $dispatcher_uuid;
            
    
    
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
}