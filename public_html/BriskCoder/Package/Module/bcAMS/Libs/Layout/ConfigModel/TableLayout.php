<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel;

final class TableLayout
{

    public
    /**
     * TABLE ams_layout COLUMN id
     * INT(10) PK NN UN AI 
     */
            $id,
            /**
             * TABLE ams_layout COLUMN dispatcher_uuid
             * VARBINARY(36) NN
             */
            $dispatcher_uuid,
            /**
             * TABLE ams_layout COLUMN dispatcher_app_uuid
             * VARBINARY(36) NN
             */
            $dispatcher_app_uuid,
            /**
             * TABLE ams_layout COLUMN dispatcher_block_uuid
             * VARBINARY(36) NN
             */
            $dispatcher_block_uuid,
            /**
             * TABLE ams_layout COLUMN domain_id
             * SMALLINT(5) NN UN
             */
            $domain_id,
            /**
             * TABLE ams_layout COLUMN dispatcher_block
             * VARCHAR(255) NN
             */
            $dispatcher_block,
            /**
             * TABLE ams_layout COLUMN template_filename
             * VARCHAR(255) 
             */
            $template_filename,
            /**
             * TABLE ams_layout COLUMN user_asset
             * TINYINT(1) NN UN DEFAULT '0'
             */
            $user_asset,
            /**
             * TABLE ams_layout COLUMN display_section
             * VARCHAR(20) NN
             */
            $display_section,
            /**
             * TABLE ams_layout COLUMN page_identifier
             * DEFAULT '0' VARCHAR(255)
             */
            $page_identifier,
            /**
             * TABLE ams_layout COLUMN sort
             * INTEGER(10) NN DEFAULT '0' 
             */
            $sort,
            /**
             * TABLE ams_layout COLUMN status
             * TINYINT(1) NN DEFAULT '1' 
             */
            $status;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
