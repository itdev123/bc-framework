<?php

namespace BriskCoder\Package\Library\bcDB\Mapper\Ext;

use BriskCoder\Package\Library\bcDB;

final class pdo_mysql
{

    private
            $stmt = '',
            $_binds = array(),
            $new_stmt = FALSE;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcDB\Mapper' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
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
        $this->stmt .= 'SELECT ' . (empty( $_columns ) ? '* ' : implode( ', ', $_columns ) . ' ') . 'FROM ' . $table . ' ';
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
        $this->stmt .= 'INSERT INTO ' . $table . ' ';
        self::setStatement( $_columns );
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
        $this->stmt .= 'UPDATE ' . $table . ' ';
        self::setStatement( $_columns );
    }

    /**
     * SQL DELETE STATEMENT
     * @param String $table Schema Table Name
     * @return Void
     */
    public function delete( $table )
    {
        $this->stmt .= 'DELETE FROM ' . $table . ' ';
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
        $this->stmt .= 'CREATE ' . $type . ' ' . $name . (empty( $_columns ) ? '' : ' (' . implode( ', ', $_columns ) . ') ');
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
        $this->stmt .= 'ALTER TABLE ' . $table . ' ' . $type . (empty( $_columns ) ? '' : ' ' . implode( ', ', $_columns ));
    }

    /**
     * SQL DROP STATEMENT
     * @param String $type DATABASE|TABLE|INDEX 
     * @param String $name Schema Database|Table|Index Name
     * @return Void
     */
    public function drop( $type, $name )
    {
        $this->stmt .= 'DROP ' . $type . ' ' . $name;
    }

    /**
     * SQL SHOW STATEMENT
     * @param String $type DATABASES|TABLES|COLUMNS|INDEX 
     * @param String $name columns name when using COLUMNS|INDEX TABLE type
     * @return Void
     */
    public function show( $type, $name = NULL )
    {
        switch ( strtoupper( $type ) ):
            case 'DATABASES':
                $this->stmt .= 'SHOW DATABASES';
                break;
            case 'TABLES':
                $this->stmt .= 'SHOW TABLES FROM ' . bcDB::resource( 'CATALOG' );
                break;
            case 'CREATE TABLE':
                $this->stmt .= 'SHOW CREATE TABLE ' . $name;
                break;
            case 'COLUMNS':
                $this->stmt .= 'SHOW COLUMNS FROM ' . bcDB::resource( 'CATALOG' ) . '.' . $name;
                break;
            case 'FULL COLUMNS':
                $this->stmt .= 'SHOW FULL COLUMNS FROM ' . bcDB::resource( 'CATALOG' ) . '.' . $name;
                break;
            case 'INDEXES':
                $this->stmt .= 'SHOW INDEXES FROM ' . bcDB::resource( 'CATALOG' ) . '.' . $name;
                break;
        endswitch;
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
        $key = key( $_conditions );
        $this->stmt .= $key . ' JOIN ' . $_conditions[$key][0] . ' ON (' . $_conditions[$key][1] . $_conditions[$key][2] . $_conditions[$key][3] . ') ';
    }

    /**
     * SQL WHERE STATEMENT 
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @return Void
     */
    public function where( $_filters )
    {
        if ( empty( $_filters ) ):
            return FALSE;
        endif;

        $this->stmt .= ' WHERE';

        foreach ( $_filters as $column => $_params ):
            //case in or not in
            if ( (strtoupper( $_params[0] ) === 'IN') || (strtoupper( $_params[0] ) === 'NOT IN') ):
                $condition = (strtoupper( $_params[0] ) === 'IN') ? 'IN' : 'NOT IN';
                if ( $_params[2] !== FALSE ):
                    $_val = explode( ',', $_params[1] );
                    $binds = '';
                    foreach ( $_val as $v ):
                        $binds .= ($binds === '') ? '?' : ',?';
                        $this->_binds[] = array( $v => $_params[2] );
                    endforeach;
                    $this->stmt .= ' ' . $column . ' ' . $condition . ' (' . $binds . ') ' . $_params[3];
                    continue;
                endif;

                $this->stmt .= ' ' . $column . ' ' . $condition . ' (' . $_params[1] . ') ' . $_params[3];
                continue;
            endif;

            //case BETWEEN
            if ( strtoupper( ( $_params[0] ) ) === 'BETWEEN' ):
                if ( $_params[2] !== FALSE ):
                    $_val = explode( 'AND', $_params[1] );
                    $binds = '';
                    foreach ( $_val as $v ):
                        $binds .= ($binds === '') ? '?' : ' AND ?';
                        $this->_binds[] = array( $v => $_params[2] );
                    endforeach;
                    $this->stmt .= ' ' . $column . ' BETWEEN ' . $binds . ' ' . $_params[3];
                    continue;
                endif;
                $_val = explode( 'AND', $_params[1] );
                $this->stmt .= ' ' . $column . ' BETWEEN ' . $_params[1] . ' ' . $_params[3];
                continue;
            endif;

            //regular operators
            if ( $_params[2] !== FALSE ):
                $this->stmt .= ' ' . $column . ' ' . $_params[0] . ' ? ' . $_params[3];
                $this->_binds[] = array( $_params[1] => $_params[2] );
                continue;
            endif;

            switch ( TRUE ):
                case (int) $_params[1] === $_params[1]:
                case (float) $_params[1] === $_params[1]:
                case (bool) $_params[1] === $_params[1]:
                    $val = $_params[1];
                    break;
                default:
                    $val = ( $_params[1] === NULL || $_params[1] === '') ? '' : "'" . $_params[1] . "'";
            endswitch;
            $this->stmt .= ' ' . $column . ' ' . $_params[0] . ' ' . $val . ' ' . $_params[3];
        endforeach;
    }

    /**
     * SQL STATEMENT GROUP BY CONDITION
     * STMT comma separated columns|* when empty array provided
     * @param Array $_columns DB Columns to group by, ie: $_columns[] = schema\table_name::column_name     
     * @return Void
     */
    public function groupBy( $_columns )
    {
        if ( empty( $_columns ) ):
            return FALSE;
        endif;
        $this->stmt .= ' GROUP BY ' . implode( ', ', $_columns ) . ' ';
    }

    /**
     * SQL STATEMENT ORDER BY CONDITION
     * @param Array $_order_by The specific column name as key and the ASC or DESC order as value for each column, ie: $_order_by = array('column_name' => 'ASC')
     * @return Void
     */
    public function orderBy( $_order_by )
    {
        if ( empty( $_order_by ) ):
            return FALSE;
        endif;

        $this->stmt .= ' ORDER BY ';
        foreach ( $_order_by as $column => $order ):
            $this->stmt .= $column . ' ' . $order . ', ';
        endforeach;
        $this->stmt = rtrim( $this->stmt, ', ' );
    }

    /**
     * SQL STATEMENT LIMIT OFFSET CONDITION
     * @param String $offset Start offset and record limit separated by comma, ie: $offset = '5,10'
     * @return Void
     */
    public function limit( $offset )
    {
        if ( empty( $offset ) ):
            return FALSE;
        endif;

        $this->stmt .= ' LIMIT ' . $offset;
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
        $this->stmt = $this->stmt . '; ';
        $this->new_stmt = TRUE;
    }

    /**
     * EXECUTES SQL QUERY AND FETCHES DATA
     * SELECT|SHOW|OPTIMIZE     
     * @param Boolean $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @return Array
     */
    public function fetch( $fetchAll )
    {
        try {
            $this->stmt = ($this->new_stmt ? rtrim( $this->stmt, '; ' ) . ';' : $this->stmt); //if newStatement has been previously used append semicolon                      
            $_binds = self::getBinds();
            $this->_binds = array();
            if ( $_binds ):
                bcDB::sql()->prepare( $this->stmt );
                foreach ( $_binds as $_bind ):
                    foreach ( $_bind as $val => $type ):
                        bcDB::sql()->bind( $val, $type );
                    endforeach;
                endforeach;
                bcDB::sql()->execute();
            else:
                bcDB::sql()->query( $this->stmt );
            endif;
            $this->stmt = '';
            $this->new_stmt = FALSE;
            return $fetchAll != 0 ? bcDB::sql()->fetchAll() : bcDB::sql()->fetchRow();
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
        }
    }

    /**
     * EXECUTES SQL QUERY RETURNS NUMBER OF AFFECTED ROWS | BOOLEAN WHEN USING PREPARED STATEMENT      
     * INSERT|UPDATE|DELETE|ALTER|DROP etc     
     * @return mixed integer|boolean
     */
    public function exec( $last_id = FALSE )
    {
        try {
            $this->stmt = ($this->new_stmt ? rtrim( $this->stmt, '; ' ) . ';' : $this->stmt); //if newStatement has been previously used append semicolon
            $_binds = self::getBinds();
            $this->_binds = array();
            if ( $_binds ):
                bcDB::sql()->prepare( $this->stmt );
                $this->stmt = '';
                $this->new_stmt = FALSE;
                foreach ( $_binds as $_bind ):
                    foreach ( $_bind as $val => $type ):
                        bcDB::sql()->bind( $val, $type );
                    endforeach;
                endforeach;

                if ( $last_id ):
                    bcDB::sql()->execute();
                    return bcDB::sql()->lastInsertID();
                else:
                    return bcDB::sql()->execute();
                endif;
            else:
                $_data = bcDB::sql()->query( $this->stmt );
                $this->stmt = '';
                $this->new_stmt = FALSE;
                if ( !$last_id ):
                    return $_data;
                endif;
                return bcDB::sql()->lastInsertID();
            endif;
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
        }
    }

    /**
     * HELPERS
     */

    /**
     * SQL SET STATEMENT
     * Private method to avoid the duplication of code.
     * Used on INSERT and UPDATE STATEMENT
     * @param Array $_columns to be INSERTED: <br>
     * $_columns['column'] = Array(value, schema::$TYPE_?|FALSE)<br>
     * if 2nd paramenter is FALSE then value is not bound.
     * @return Void
     */
    private function setStatement( $_columns )
    {
        $this->stmt .= 'SET ';

        foreach ( $_columns as $column => $_params ):
            if ( $_params[1] !== FALSE ):
                $this->stmt .= ' ' . $column . ' = ?, ';
                $this->_binds[] = array( $_params[0] => $_params[1] );
                continue;
            endif;

            switch ( TRUE ):
                case (int) $_params[0] === $_params[0]:
                case (float) $_params[0] === $_params[0]:
                case (bool) $_params[0] === $_params[0]:
                    $val = $_params[0];
                    break;
                default:
                    $val = "'" . $_params[0] . "'";
            endswitch;

            $this->stmt .= ' ' . $column . ' = ' . $val . ', ';
        endforeach;

        $this->stmt = rtrim( $this->stmt, ', ' );
    }

    /**
     * GET STATEMENT BOUND DATA
     * @return Array $_binds[] = array( 'value' => 'dataType' );
     */
    public function getBinds()
    {
        return $this->_binds;
    }

    /**
     * GET SQL STATEMENT STRING
     * Useful for checking statement string integrity prior to execution
     * @return String SQL STATEMENT
     */
    public function getSTMT()
    {
        return $this->stmt;
    }

}
