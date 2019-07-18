<?php

namespace BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\mysql;

use BriskCoder\Package\Module\bcAMS,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcCache;

final class ams_layout implements \BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\i_ams_layout
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS\Libs\Layout\Model\Model' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;

        //cache defaults
        bcCache::$STORAGE_RESOURCE = FALSE;
        bcCache::$LIFE_DEFAULT = 31536000; //year
        bcCache::$ENCODING = 2; //serialize

        $tbl = bcAMS::layout()->configModel();
        bcCache::useNamespace( $tbl->tbl_ams_layout );
    }

    /**
     * ams_layout TABLE SQL ALTER OPERATION
     * @param String $type $type ADD|DROP COLUMN|MODIFY COLUMN
     * @param Array $_columns Key = empty Val = Column Name  New Column Name|Column Datatype <br>
     * @return Mixed
     */
    public function alter( $type, $_columns )
    {
        $tbl = bcAMS::layout()->configModel();
        bcCache::deleteNamespace( $tbl->tbl_ams_layout, TRUE );
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->alter( $tbl->tbl_ams_layout, $type, $_columns );
        return bcDB::mapper()->exec();
    }

    /**
     * ams_layout TABLE SQL DELETE OPERATION
     * @param Array $_filters WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Mixed
     */
    public function delete( $_filters, $_order_by, $offset )
    {
        $tbl = bcAMS::layout()->configModel();
        bcCache::deleteNamespace( $tbl->tbl_ams_layout, TRUE );
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->delete( $tbl->tbl_ams_layout );
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        return bcDB::mapper()->exec();
    }

    /**
     * ams_layout TABLE SQL READ OPERATION
     * @param Boolean $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array
     */
    public function read( $fetchAll, $_columns, $_filters, $_order_by, $offset )
    {
        $tbl = bcAMS::layout()->configModel();
        bcCache::useNamespace( $tbl->tbl_ams_layout );
        $cacheKey = md5( 'SELECT' . $fetchAll . serialize( $_columns ) . serialize( $_filters ) . serialize( $_order_by ) . $offset );
        $_data = bcCache::read( $cacheKey );
        if ( $_data ):
            return $_data;
        endif;
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->select( $_columns, $tbl->tbl_ams_layout );
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        $_data = bcDB::mapper()->fetch( $fetchAll );
        bcCache::write( $cacheKey, $_data );
        return $_data;
    }

    /**
     * ams_layout TABLE SQL UPDATE OPERATION
     * @param Array $_columns SET statement constructor <br>
     * ie: $_columns[schema\table_name::column_name] =  array(value, schema::$TYPE_?|FALSE) <br>
     * if 2nd paramenter is FALSE then value is not bound.
     * @param Array $_filters WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Mixed
     */
    public function update( $_columns, $_filters, $_order_by, $offset )
    {
        $tbl = bcAMS::layout()->configModel();
        bcCache::deleteNamespace( $tbl->tbl_ams_layout, TRUE );
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->update( $tbl->tbl_ams_layout, $_columns );
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        return bcDB::mapper()->exec();
    }

    /**
     * ams_layout TABLE SQL WRITE OPERATION
     * @param Array $_columns SET statement constructor ie: <br>
     * $_columns['column'] =  Array(value, schema::$TYPE_?|FALSE)<br>
     *  if 2nd paramenter is FALSE then value is not bound.
     * @param Boolean $last_id Return Last Inserted Id <br>
     * @return Mixed
     */
    public function write( $_columns, $last_id )
    {
        $tbl = bcAMS::layout()->configModel();
        bcCache::deleteNamespace( $tbl->tbl_ams_layout, TRUE );
        bcDB::connection( $tbl->bcDB_NS );        
        bcDB::mapper()->insert( $tbl->tbl_ams_layout, $_columns );
        return bcDB::mapper()->exec( $last_id );
    }

}
