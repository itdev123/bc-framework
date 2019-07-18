<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel;

final class TableAuthQuestions
{

    public

    /**
     * TABLE uac_auth_questions COLUMN id
     * PK NN UN AI MEDIUMINT(7)
     */
            $id,
            /**
             * TABLE uac_auth_questions COLUMN language_id
             * NN UN DEFAULT '0' SAMLLINT(5) 
             */
            $language_id,
            /**
             * TABLE uac_auth_questions COLUMN secret_answers
             * VARCHAR(255)
             */
            $question;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
