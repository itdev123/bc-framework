<?php

namespace BriskCoder\Package\Module;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcSEO\Config,
    BriskCoder\Package\Module\bcSEO\ConfigModel;

final class bcSEO
{

    private static
            $init = FALSE,
            /**
             * @var \BriskCoder\Package\Module\bcSEO\ConfigModel\TableSEO
             */
            $col,
            $_seoData = array();

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * TRANSLATE URI
     * Translates Friendly URL back to Query String<br>
     * Use bcSEO::getPageIdentifier() to get translation result as URL Query String parameter and value that generates dynamic content.<br>
     * Use bcSEO::getKeyword() to get translation result as the keyword used for translation.<br>
     * NOTE: Use bcSEO::config()->setDynamicRoute() to stop in a specific dispatcher and route dynamic segments as friendly url<br>
     * It Requires bc::registry()->DOMAIN_ID & bc::registry()->LANGUAGE_ID which are automatically set by BC router to 1 if not using these features<br>
     * This method automaticaly 301 redirects from old URL to the new one if old is found in the record of current request.<br>
     * IMPORTANT: When translation is succesfull If bc::registry()->DISPATCHER_NS does not match the colum dispatcher from seo table<br>
     * then this method will automatically instanciate and call the dispatch() method of next dispatcher.
     * @param String $DISPATCHER_UUID 
     * @return Void
     */
    public static function translate( $DISPATCHER_UUID )
    {
        if ( self::$init === TRUE ):
            return;
        endif;

        self::$init = TRUE;

        $disp = isset( bc::registry()->DISPATCHER_ALIAS ) ? bc::registry()->DISPATCHER_ALIAS : bc::registry()->DISPATCHER_URI;

        self::$col = self::configModel()->seo();
        $_filters[self::$col->dispatcher_uuid] = array( '=', $DISPATCHER_UUID, bcDB::TYPE_STRING, 'AND' );
        $_filters[self::$col->domain_id] = array( '=', bc::registry()->DOMAIN_ID, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[self::$col->language_id] = array( '=', bc::registry()->LANGUAGE_ID, bcDB::TYPE_INTEGER, 'AND' );


        //make sure we have a keyword to proceed.
        if ( empty( bc::registry()->_DYNAMIC_ROUTE[$disp] ) ):
            $_filters[self::$col->page_identifier] = array( '=', '', bcDB::TYPE_INTEGER, NULL );
            self::$_seoData = self::model()->read( FALSE, array(), $_filters, array(), NULL );
            return;
        endif;

        $keyword = bc::registry()->_DYNAMIC_ROUTE[$disp] . '/';

        //empty globals to free memory
        bc::registry()->_DYNAMIC_SEGMENT = array();
        bc::registry()->_DISPATCHER_ALIAS = array();
        bc::registry()->_DYNAMIC_ROUTE = array();

        self::$col = self::configModel()->seo(); //assign Seo URL url Model Columns

        $_filters[self::$col->keyword] = array( '=', $keyword, bcDB::TYPE_STRING, 'OR' );
        $_filters[self::$col->keyword_old] = array( '=', $keyword, bcDB::TYPE_STRING, NULL );

        self::$_seoData = self::model()->read( FALSE, array(), $_filters, array(), NULL );

        if ( empty( self::$_seoData ) )://nothing found on either keyword and keyword_old
            bc::publisher()->throwCustomError();
            return;
        endif;

        //has data, ckeck old first
        if ( isset( self::$_seoData[self::$col->keyword_old] ) && self::$_seoData[self::$col->keyword_old] === $keyword ):
            //TODO: decide if current query string is required to be appended at the end.            
            bc::request()->redirect( bc::registry()->URI_NO_QS . self::$_seoData[self::$col->keyword] );
        endif;

        //if dispatcher is different than the requested, invoke.
        if ( !empty( self::$_seoData[self::$col->dispatcher] ) && (bc::registry()->DISPATCHER_NS !== self::$_seoData[self::$col->dispatcher]) ):
            $dispatcher = 'Dispatcher\\' . self::$_seoData[self::$col->dispatcher];
            $class = new $dispatcher();
            $class->dispatch();
        endif;
        $_seo = null;
    }

    /**
     * GET SEO  DATE CREATED
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo date created. 
     * @return Integer | 0
     */
    public static function getDateCreated()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->created] ) ? self::$_seoData[self::$col->created] : 0;
    }

    /**
     * GET SEO DATE MODIFIED
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo date created. 
     * @return Integer | 0
     */
    public static function getDateModified()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->modified] ) ? self::$_seoData[self::$col->modified] : 0;
    }

    /**
     * GET DISPATCHER NAMESPACE
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo dispatcher. 
     * @return String
     */
    public static function getDispatcher()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->dispatcher] ) ? self::$_seoData[self::$col->dispatcher] : '';
    }

    /**
     * GET DISPATCHER ALIAS
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo dispatcher alias. 
     * @return String
     */
    public static function getDispatcherAlias()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->dispatcher_alias] ) ? self::$_seoData[self::$col->dispatcher_alias] : '';
    }

    /**
     * GET DISPATCHER UUID
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo dispatcher uuid. 
     * @return String
     */
    public static function getDispatcherUUID()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->dispatcher_uuid] ) ? self::$_seoData[self::$col->dispatcher_uuid] : '';
    }

    /**
     * GET SEO  DOMAIN ID
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo domain id. 
     * @return Integer | 0
     */
    public static function getDomainId()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->domain_id] ) ? self::$_seoData[self::$col->domain_id] : 0;
    }

    /**
     * GET SEO ID
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo id. 
     * @return Integer | 0
     */
    public static function getID()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->id] ) ? self::$_seoData[self::$col->id] : 0;
    }

    /**
     * GET SEO KEYWORD
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the friendly url keyword used in the request. 
     * @return String
     */
    public static function getKeyword()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->keyword] ) ? self::$_seoData[self::$col->keyword] : '';
    }

    /**
     * GET SEO KEYWORD OLD
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the old friendly url keyword. 
     * @return String
     */
    public static function getKeywordOld()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->keyword_old] ) ? self::$_seoData[self::$col->keyword_old] : '';
    }

    /**
     * GET SEO LANGUAGE ID
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo language id. 
     * @return Integer | 0
     */
    public static function getLanguageId()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->language_id] ) ? self::$_seoData[self::$col->language_id] : 0;
    }

    /**
     * GET LINK HINT
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo link hint. 
     * @return String
     */
    public static function getLinkHint()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->link_hint] ) ? self::$_seoData[self::$col->link_hint] : '';
    }

    /**
     * GET LINK ICON
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo link icon. 
     * @return String
     */
    public static function getLinkIcon()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->link_icon] ) ? self::$_seoData[self::$col->link_icon] : '';
    }

    /**
     * GET LINK TITLE
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo link title. 
     * @return String
     */
    public static function getLinkTitle()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->link_title] ) ? self::$_seoData[self::$col->link_title] : '';
    }

    /**
     * GET META CANONICAL
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo meta canonical. 
     * @return String
     */
    public static function getMetaCanonical()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->meta_canonical] ) ? self::$_seoData[self::$col->meta_canonical] : '';
    }

    /**
     * GET META DESCRIPTION
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo meta title. 
     * @return String
     */
    public static function getMetaDescription()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->meta_description] ) ? self::$_seoData[self::$col->meta_description] : '';
    }

    /**
     * GET META TITLE
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo meta title. 
     * @return String
     */
    public static function getMetaTitle()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->meta_title] ) ? self::$_seoData[self::$col->meta_title] : '';
    }

    /**
     * GET META NOFOLLOW
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo meta nofollow. 
     * @return Boolean
     */
    public static function getMetaNofollow()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->meta_canonical] ) && self::$_seoData[self::$col->meta_canonical] == 1 ? TRUE : FALSE;
    }

    /**
     * GET PAGE CONTENT
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo page content. 
     * @return String
     */
    public static function getPageContent()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->page_content] ) ? self::$_seoData[self::$col->page_content] : '';
    }

    /**
     * GET PAGE H1
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the seo page h1. 
     * @return String
     */
    public static function getPageH1()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->page_h1] ) ? self::$_seoData[self::$col->page_h1] : '';
    }

    /**
     * GET PAGE IDENTIFIER
     * After bcSEO::translate( $DISPATCHER_UUID ) it returns the query string param value of friendly url keyword. 
     * @return String
     */
    public static function getPageIdentifier()
    {
        self::$col = self::configModel()->seo();
        return !empty( self::$_seoData[self::$col->page_identifier] ) ? self::$_seoData[self::$col->page_identifier] : '';
    }

    /**
     * LIBRARY CONFIGURATION
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcSEO\Config
     */
    public static function config()
    {
        static $obj;
        return $obj instanceof Config ? $obj : $obj = new Config( __CLASS__ );
    }

    /**
     * MODEL CONFIGURATION  
     * Connection namespace, table and columns
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcSEO\ConfigModel
     */
    public static function configModel()
    {
        static $obj;
        return $obj instanceof ConfigModel ? $obj : $obj = new ConfigModel( __CLASS__ );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed<br>
     * via bcSEO::configModel()->seo()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet<br>
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use<br>
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence<br>
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that<br>
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each,<br>
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcSEO\Libs\URL\Model\i_Model
     */
    public static function model()
    {
        static $obj;
        if ( $obj instanceof \BriskCoder\Package\Module\bcSEO\Model\i_model ):
            return $obj;
        endif;
        if ( self::config()->STORAGE_RESOURCE === FALSE ):
            bcDB::connection( self::configModel()->bcDB_NS );
            $class = 'BriskCoder\Package\Module\bcSEO\Model\\' . bcDB::resource( 'RDBMS' ) . '\Model';
            return $obj = new $class( __CLASS__ );
        endif;
        if ( !self::config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcSEO\Model\i_model ):
            exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcSEO\Model\i_model ' ); //debug
        endif;
        return $obj = self::config()->STORAGE_RESOURCE;
    }

}
