<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel;

final class TableAuth
{

    public

    /**
     * TABLE uac_auth COLUMN id
     * PK NN UN AI INT(10)
     */
            $id,
            /**
             * TABLE uac_auth COLUMN user
             * NN VARCHAR(60)
             */
            $user,
            /**
             * TABLE uac_auth COLUMN email
             * NN VARCHAR(60)
             */
            $email,
            /**
             * TABLE uac_auth COLUMN pass
             * NN VARBINARY(40)
             */
            $pass,
            /**
             * TABLE uac_auth COLUMN token
             * VARBINARY(40)
             */
            $token,
            /**
             * TABLE uac_auth COLUMN secret_answers
             * json_encoded array(auth_question_id => 'user-answer')
             * BLOB
             */
            $secret_answers,
            /**
             * TABLE uac_auth COLUMN status
             * NN DEFAULT '0' TINYINT(1)
             */
            $status,
            /**
             * TABLE uac_auth COLUMN language_id
             * NN SMALLINT(5)
             */
            $language_id,
            /**
             * TABLE uac_auth COLUMN online
             * DEFAULT '0 TINYINT(1)
             */
            $online,
            /**
             * TABLE uac_auth COLUMN last_ip
             * VARCHAR(45)
             */
            $last_ip,
            /**
             * TABLE uac_auth COLUMN last_activity
             * BIGINT(20)
             */
            $last_activity,
            /**
             * TABLE uac_auth COLUMN created
             * NN UN BIGINT(20)
             */
            $created,
            /**
             * TABLE uac_auth COLUMN modified
             * BIGINT(20)
             */
            $modified;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
