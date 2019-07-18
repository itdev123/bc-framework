<?php

namespace BriskCoder\Package\Module\bcAMS\Libs;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcAMS\Libs\Builder\Config,
    BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel;

final class Builder
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * LIBRARY CONFIGURATION
     * Connection namespace, table and columns
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Builder\Config
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
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Builder\ConfigModel
     */
    public function configModel()
    {
        static $obj;
        return $obj instanceof ConfigModel ? $obj : $obj = new ConfigModel( __CLASS__ );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcAMS::builder()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \builder\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\i_Model
     */
    public function model()
    {
        static $obj;
        if ( $obj instanceof \BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\i_Model ):
            return $obj;
        endif;

        if ( $this->config()->STORAGE_RESOURCE === FALSE ):
            bcDB::connection( $this->configModel()->bcDB_NS );
            return $obj = new Builder\Model\Model( __CLASS__ );
        endif;

        if ( !$this->config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\i_Model ):
            //debug
            exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcAMS\Libs\Builder\Model\i_Model ' );
        endif;
        return $obj = $this->config()->STORAGE_RESOURCE;
    }

}
