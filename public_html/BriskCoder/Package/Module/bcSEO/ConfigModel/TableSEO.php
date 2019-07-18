<?php

namespace BriskCoder\Package\Module\bcSEO\ConfigModel;

final class TableSEO
{

    public
    /**
     * TABLE seo_url COLUMN id
     * INT(10) PK NN UN AI 
     */
            $id,
            /**
             * TABLE seo COLUMN dispatcher_uuid
             * VARBINARY(36) FK NN
             */
            $dispatcher_uuid,
            /**
             * TABLE seo COLUMN domain_id
             * SMALLINT(5) FK NN UN 
             */
            $domain_id,
            /**
             * TABLE seo COLUMN language_id
             * SMALLINT(5) FK NN UN
             */
            $language_id,
            /**
             * TABLE seo COLUMN app_uuid
             * VARBINARY(36) FK NN
             */
            $app_uuid,
            /**
             * TABLE seo COLUMN dispatcher
             * VARCHAR(255) NN
             */
            $dispatcher,
            /**
             * TABLE seo COLUMN page_identifier
             * VARCHAR(255)
             */
            $page_identifier,
            /**
             * TABLE seo COLUMN keyword
             * VARCHAR(255) 
             */
            $keyword,
            /**
             * TABLE seo COLUMN keyword_old
             * VARCHAR(255)
             */
            $keyword_old,
            /**
             * TABLE seo COLUMN meta_title
             * VARCHAR(60)
             */
            $meta_title,
            /**
             * TABLE seo COLUMN meta_description
             * VARCHAR(160)
             */
            $meta_description,
            /**
             * TABLE seo COLUMN canonical
             * VARCHAR(255)
             */
            $meta_canonical,
            /**
             * TABLE seo COLUMN meta_nofollow
             * NN DEFAULT '0' TINYINT(1)
             */
            $meta_nofollow,
            /**
             * TABLE seo COLUMN page_h1
             * VARCHAR(255)
             */
            $page_h1,
            /**
             * TABLE seo COLUMN page_content
             * TEXT
             */
            $page_content,
            /**
             * TABLE seo COLUMN link_title
             * VARCHAR(45)
             */
            $link_title,
            /**
             * TABLE seo COLUMN link_hint
             * VARCHAR(255)
             */
            $link_hint,
            /**
             * TABLE seo COLUMN link_icon
             * VARCHAR(255)
             */
            $link_icon, 
            /**
             * TABLE seo COLUMN created
             * BIGINT(20) NN
             */
            $created,
            /**
             * TABLE seo COLUMN modified
             * BIGINT(20) 
             */
            $modified;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcSEO\ConfigModel' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
