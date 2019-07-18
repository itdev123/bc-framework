<?php

namespace BriskCoder\Package\Library\bcDB;

use BriskCoder\Package\Library\bcDB;

final class Mapper
{

    private $ext = 'BriskCoder\Package\Library\bcDB\Mapper\Ext\\',
            $obj;

    private function __clone()
    {
        
    }

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcDB' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * SQL ARCHITECT
     * @staticvar $obj
     * @return \BriskCoder\Package\Library\bcDB\Mapper\Architect\i_architect
     */
    public function architect()
    {
        static $obj;
        $cls = 'BriskCoder\Package\Library\bcDB\Mapper\Architect\\' . strtolower( bcDB::resource( 'RDBMS' ) );
        return ( $obj instanceof $cls ) ? $obj : $obj = new $cls( __CLASS__ );
    }

    /**
     * SQL SELECT STATEMENT
     * STMT comma separated columns|* when empty array provided     
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param String $table Schema Table Name
     * @return Void
     */
    public function select( $_columns, $table )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->select( $_columns, $table );
    }

    /**
     * SQL INSERT STATEMENT
     * @param String $table Schema Table Name
     * @param Array $_columns to be INSERTED: <br>
     * $_columns['column'] = Array(value, schema::$TYPE_?|FALSE)<br>
     * if 2nd paramenter is FALSE then value is not bound.
     * @return Void
     */
    public function insert( $table, $_columns )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->insert( $table, $_columns );
    }

    /**
     * SQL UPDATE STATEMENT
     * @param String $table Schema Table Name
     * @param Array $_columns to be UPDATED: <br>
     * $_columns['column'] = Array(value, schema::$TYPE_?|FALSE)<br>
     * if 2nd paramenter is FALSE then value is not bound.
     * @return Void
     */
    public function update( $table, $_columns )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        $this->obj = ($this->obj instanceof $cls) ? $this->obj : new $cls( __CLASS__ );
        return $this->obj->update( $table, $_columns );
    }

    /**
     * SQL DELETE STATEMENT
     *  @param String $table Schema Table Name
     * @return Void
     */
    public function delete( $table )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->delete( $table );
    }

    /**
     * SQL CREATE STATEMENT
     * @param String $type DATABASE|TABLE|INDEX 
     * @param String $name Schema Database|Table Name
     * @param Array $_columns  Key = Column Name Val = Column Datatype <br>
     * ie: $_columns[] = 'name INTEGER PRIMARY KEY AUTOINCREMENT'
     * @return Void
     */
    public function create( $type, $name, $_columns )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->create( $type, $name, $_columns );
    }

    /**
     * SQL ALTER STATEMENT
     * @param String $table Schema Table Name
     * @param String $type ADD|DROP COLUMN|MODIFY COLUMN
     * @param Array $_columns  Key = empty Val = Column Name  New Colum Name|Column Datatype <br>
     * ie: $_columns[] = 'columnName newColumnName|datatype(INTEGER PRIMARY KEY AUTOINCREMENT)'
     * Use columnName only when DROP type
     * ie: $_columns[] = 'columnName'
     * @return Void
     */
    public function alter( $table, $type, $_columns )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->alter( $table, $type, $_columns );
    }

    /**
     * SQL DROP STATEMENT
     * @param String $type DATABASE|TABLE|INDEX Default=TABLE
     * @param String $name Schema Database|Table|Index Name
     * @return Void
     */
    public function drop( $type, $name )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->drop( $type, $name );
    }

    /**
     * SQL SHOW STATEMENT
     * @param String $type DATABASES|TABLES|COLUMNS|INDEX 
     * @param String $name columns name when using COLUMNS|INDEX TABLE type
     * @return Void
     */
    public function show( $type, $name = NULL )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->show( $type, $name );
    }

    /**
     * SQL JOIN STATEMENT
     * @param Array $_conditions
     * ie: $_conditions['LEFT'] = array('tbl_name', 'col1', '=', 'col2' );<br>
     * note: CROSS condition requires only table name<br>
     * ie: $_conditions['CROSS'] = array('tbl_name');
     * @return Void
     */
    public function join( $_conditions )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->join( $_conditions );
    }

    /**
     * SQL WHERE STATEMENT 
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @return String
     */
    public function where( $_filters )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->where( $_filters );
    }

    /**
     * SQL STATEMENT GROUP BY CONDITION
     * STMT comma separated columns|* when empty array provided
     * @param Array $_columns DB Columns to group by, ie: $_columns[] = schema\table_name::column_name     
     * @return Void
     */
    public function groupBy( $_columns )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->groupBy( $_columns );
    }

    /**
     * SQL STATEMENT ORDER BY CONDITION
     * @param Array $_order_by The specific column name as key and the ASC or DESC order as value for each column, ie: $_order_by = array('column_name' => 'ASC')
     * @return String
     */
    public function orderBy( $_order_by )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->orderBy( $_order_by );
    }

    /**
     * SQL STATEMENT LIMIT OFFSET CONDITION
     * @param String $offset Start offset and record limit separated by comma, ie: $limit_offset = '5,10'
     * @return String
     */
    public function limit( $offset )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->limit( $offset );
    }

    /**
     * SQL NEW STATEMENT
     * It sets a semicolon at the end of previous statement indicating that there will be a new statement.<br>
     * Use it before each statement, execpt the firt. Do not use after last statement if bcDB::mapper()->newStatement() has been previously used<br>
     * because when executing bcDB::mapper()->fetch() or bcDB::mapper()->exec() method the semicolon is automatically added at the end of the statement.
     * @return Void
     */
    public function newStmt()
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->newStmt();
    }

    /**
     * SQL SET FETCH TYPE
     * Data Return Mode<br>
     * Associative is default retun type
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Fetch
     */
    public function setFetch()
    {
        return bcDB::sql()->setFetch();
    }

    /**
     * SQL GET ATTRIBUTE
     * Get RDBMS ATTRIBUTES<br>
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Attribute
     */
    public function getAttribute()
    {
        return bcDB::sql()->getAttribute();
    }

    /**
     * EXECUTES SQL QUERY AND FETCHES DATA
     * SELECT|SHOW|OPTIMIZE     
     * @param Boolean $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @return Array
     */
    public function fetch( $fetchAll )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->fetch( $fetchAll );
    }

    /**
     * EXECUTES SQL QUERY RETURNS NUMBER OF AFFECTED ROWS | BOOLEAN WHEN USING PREPARED STATEMENT      
     * INSERT|UPDATE|DELETE|ALTER|DROP etc     
     * @return mixed integer|boolean
     */
    public function exec( $last_id = FALSE )
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->exec( $last_id );
    }

    /**
     * GET STATEMENT BOUND DATA
     * @return Array $_binds[] = array( 'value' => 'dataType' );
     */
    public function getBinds()
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->getBinds();
    }

    /**
     * GET SQL STATEMENT STRING
     * Useful for checking statement string integrity prior to execution
     * @return String SQL STATEMENT
     */
    public function getSTMT()
    {
        $cls = $this->ext . strtolower( bcDB::resource( 'DRIVER' ) );
        ($this->obj instanceof $cls) ? NULL : $this->obj = new $cls( __CLASS__ );
        return $this->obj->getSTMT();
    }

}
