<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel;

final class TableSession
{

    public

    /**
     * COLUMN uac_session_id
     * PK NN VARNINARY(128)
     */
            $id,
            /**
             * COLUMN uac_session_data
             * BLOB
             */
            $data,
            /**
             * COLUMN uac_session_last_activity
             * UN BIGINT(20)
             */
            $last_activity;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
