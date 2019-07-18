<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel;


final class TableAuthLock
{
    public 
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_id
             * PK NN UN AI INT(20)
             */
            $id,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_ip
             * VARCHAR(45)
             */
            $ip,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_username
             * VARCHAR(60)
             */
            $username,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_browser
             * VARCHAR(255)
             */
            $browser,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_attempts
             * TINYINT(2)
             */
            $attempts,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_locked
             * TINYINT(1)
             */
            $locked,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_lock_ip_blacklist
             * TINYINT(1)
             */
            $ip_blacklist,
            
            /**
             * TABLE uac_auth COLUMN uac_auth_status
             * UN BIGINT(20)
             */
            $last_attempt;
    
    
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
}