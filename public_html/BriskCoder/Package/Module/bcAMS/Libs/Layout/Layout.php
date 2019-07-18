<?php

/**
 * bcAMS Layout Module
 * Manage bcAMS Layout
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcAMS\Libs;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcAMS\Libs\Layout\Config,
    BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel;

final class Layout
{

    private $section,
            $_sections = array();

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SET LAYOUT SECTION NAME<br>
     * Use bcAMS::layout()->setSection with section name that your layout will be expecting to parse<br>
     * ie: bcAMS::layout()->setSection('top');
     * @param String $NAME Section name<br>
     * @return Void
     */
    public function setSection( $NAME )
    {
        $this->_sections[$NAME] = '';
    }

    /**
     * SET LAYOUT SECTION CUSTOM CONTENT BEFOER ADDING BLOCKS<br>
     * Use bcAMS::layout()->setSectionCustomContent after bcAMS::layout()->setSection and before bcAMS::layout()->render<br>
     * ie: bcAMS::layout()->setSectionCustomContent('MAIN', 'PAGE CONTENT');  
     * @param type $NAME
     * @param type $CONTENT
     * @return Void
     */
    public function setSectionCustomContent( $NAME, $CONTENT )
    {
        $this->_sections[$NAME] .= $CONTENT;
    }

    /**
     * GET LAYOUT CURRENT SECTION NAME
     * @return String
     */
    public function getCurrentSection()
    {
        return $this->section;
    }

    /**
     * PARSE AND RENDER LAYOUT PAGES <br>
     * Set bc::registry()->DOMAIN_ID|bc::publisher()->TEMPLATE with its current values
     * and bcAMS::layout()->setSection('sectionName') before using bcAMS::layout()->render().    
     * It will always try to parse current dispatcher layout first, if not found it will parse global layout. 
     * For each html file parse all you sections name, and for each dispatcher use bcAMS::layout()->render().  
     * ie: Home.php bcAMS::layout()->render($DISPATCHER_UUID, $DISPATCHER_UUID_GLOBAL, $IDENTIFIER);
     * ie: Home.html Parsing: <!--bc.section-name--><!--bc-->
     * @param String $DISPATCHER_UUID Current Dispatcher UUID   
     * @param String $DISPATCHER_UUID_GLOBAL Global Dispatcher UUID   
     * @param String $DISPATCHER Dispatcher Name
     * @param String $IDENTIFIER Set $IDENTIFIER to parse layout from a dynamic page of a dispatcher.<br>
     * @return Boolean
     */
    public function render( $DISPATCHER_UUID, $DISPATCHER_GLOBAL_UUID, $DOMAIN_ID, $TEMPLATE, $DISPATCHER, $IDENTIFIER = '' )
    {

        //IS BEING CALLED WITHIN ANOTHER DISPATCHER, DO NOT PARSE IT. ONLY PARSE IT WHEN CURRENT DISPATCHER IS LOADED
        if ( $DISPATCHER !== bc::registry()->DISPATCHER_NS ):
            return FALSE;
        endif;

        $col = $this->configModel()->ams_layout(); //ASSIGN bcAMS LAYOUT MODEL COLUMNS
        //look for DISPATCHER_UUID data
        $_columns[] = $col->id;
        $_columns[] = $col->dispatcher_block;
        $_columns[] = $col->user_asset;
        $_columns[] = $col->template_filename;
        $_columns[] = $col->display_section;
        $_columns[] = $col->page_identifier;

        $_filters[$col->dispatcher_uuid] = array( 'IN', $DISPATCHER_UUID, bcDB::TYPE_STRING, 'AND' );
        $_filters[$col->domain_id] = array( '=', bc::registry()->DOMAIN_ID, bcDB::TYPE_INTEGER, 'AND' );
        if ( !empty( $IDENTIFIER ) ):
            $_filters[$col->page_identifier] = array( '=', $IDENTIFIER, bcDB::TYPE_STRING, NULL );
        else:
            $_filters[$col->page_identifier] = array( 'IS NULL', NULL, FALSE, NULL );
        endif;

        $_blocks = $this->model()->ams_layout()->read( TRUE, $_columns, $_filters, array( $col->sort => 'ASC' ), NULL );

        //no blocks for this record (indetifier)? Then try _Global UUID value  with empty identifier          
        //Always load _global, because if it's _global it's to display on every dispatchers, regardless dispatcher blocks
        //if ( !$_blocks ):
        $_filters[$col->dispatcher_uuid][1] = $DISPATCHER_GLOBAL_UUID;
        $_filters[$col->page_identifier] = array( 'IS NULL', NULL, FALSE, NULL );
        $_global_blocks = $this->model()->ams_layout()->read( TRUE, $_columns, $_filters, array( $col->sort => 'ASC' ), NULL );
        //endif;

        $_blocks = array_merge( $_global_blocks, $_blocks );

        //check on first record id is there a page identifier
        if ( isset( $_blocks[0] ) && !empty( $_blocks[0][$col->page_identifier] ) ):
            //bc::debugger()->breakPoint( $_blocks[0][$col->page_identifier] );
            bc::publisher()->setPageIdentifier( $IDENTIFIER );
        endif;

        foreach ( $_blocks as $_block ):
            bc::publisher()->USER_ASSET = ($_block[$col->user_asset] == 1) ? TRUE : FALSE;
            $disp = 'Dispatcher\\' . $_block[$col->dispatcher_block];
            $block = new $disp();
            $this->section = $_block[$col->display_section];
            $this->_sections[$this->section] .= $block->dispatch( $_block[$col->template_filename], $_block[$col->id] ); //CONCATENATE ALL BLOCKS THAT BELONG TO A SECTION                
        endforeach;
        //PARSE ALL SECTIONS AND ITS BLOCKS
        //IT MUST MERGE ARRAYS, OTHERWISE ALL bc::publisher()->_PARSE THAT WAS SET in the _GLOBAL WILL BE LOST         
        bc::publisher()->_PARSE = array_merge( bc::publisher()->_PARSE, $this->_sections );
        bc::publisher()->USER_ASSET = FALSE; //RESET bc::publisher()->USER_ASSET TO FALSE, SO IT LOADS PATH FROM DISPATCHERS        
        bc::publisher()->render( bc::registry()->DISPATCHER_NS ); //RENDER DISPATCHER OR DYNAMIC PAGE
        return TRUE;
    }

    /**
     * LIBRARY CONFIGURATION
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout\Config
     */
    public function config()
    {
        static $obj;
        return $obj instanceof Config ? $obj : $obj = new Config( __CLASS__ );
    }

    /**
     * MODEL CONFIGURATION     
     * Connection namespace, table and columns
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout\ConfigModel
     */
    public function configModel()
    {
        static $obj;
        return $obj instanceof ConfigModel ? $obj : $obj = new ConfigModel( __CLASS__ );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcAMS::layout()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_Model
     */
    public function model()
    {
        static $obj;
        if ( $obj instanceof \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_Model ):
            return $obj;
        endif;

        if ( $this->config()->STORAGE_RESOURCE === FALSE ):
            bcDB::connection( $this->configModel()->bcDB_NS );
            return $obj = new Layout\Model\Model( __CLASS__ );
        endif;

        if ( !$this->config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_Model ):
            exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_Model ' ); //debug
        endif;
        return $obj = $this->config()->STORAGE_RESOURCE;
    }

}
