<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     Package
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\Package\Library\bcDB\SQL\Ext;

use BriskCoder\Package\Library\bcDB;

final class bcDBPDO
{

    public static
            $CURSOR_MODE = FALSE,
            $CURSOR_POS = FALSE,
            $CURSOR_TYPE = FALSE,
            $CURSOR_OFFSET = FALSE,
            $FETCH_TYPE, //assoc is default
            $FETCH_CLASS = FALSE,
            $_FETCH_CLASS_PARAMS = array(),
            $FETCH_FUNC = FALSE,
            $FETCH_OFFSET = FALSE,
            $_BINDS = array();
    private static $stmt;

    /**
     * Begin Transaction
     * @return bool
     */
    public static function transactionBegin()
    {
        return bcDB::resource( 'CONNECTION' )->beginTransaction();
    }

    /**
     * Commit Transaction
     * @return bool
     */
    public static function transactionCommit()
    {
        return bcDB::resource( 'CONNECTION' )->commit();
    }

    /**
     * RollBack Transaction
     * @return bool
     */
    public static function transactionRollback()
    {
        return bcDB::resource( 'CONNECTION' )->rollBack();
    }

    /**
     * Quote String
     * @return bool
     */
    public static function quote( $string )
    {
        return bcDB::resource( 'CONNECTION' )->quote( $string, \PDO::PARAM_STR );
    }

    /**
     * Executes a single sql statement
     * @return bool
     */
    public static function query( $stmt )
    {
        $link = bcDB::resource( 'CONNECTION' );
        $sqlType = explode( ' ', $stmt, 2 );
        //exec or query
        switch ( $sqlType[0] ):
            //all known to not return result set then exec
            case 'SELECT':
            case 'SHOW':
            case 'OPTIMIZE':
            case 'PRAGMA'://sqlite
                self::$stmt = $link->query( $stmt );
                return TRUE;
        endswitch;

        return $link->exec( $stmt );
    }

    public static function lastInsertID()
    {
        $link = bcDB::resource( 'CONNECTION' );
        $id = 0;
        switch ( bcDB::resource( 'RDBMS' ) ):
            case 'mysql':
            case 'sqlsrv':
                $id = $link->lastInsertId();
                break;
            case 'sqlite':
                $result = $link->query( 'SELECT last_insert_rowid() as last_insert_rowid' )->fetch();
                $id = $result['last_insert_rowid'];
                break;
        //todo other driver
        endswitch;
        return $id;
    }

    public static function prepare( $stmt )
    {
        //check for cursor options
        $_options = array();
        if ( self::$CURSOR_MODE ):
            switch ( self::$CURSOR_MODE ):
                case 'fw':
                    $_options[\PDO::ATTR_CURSOR] = \PDO::CURSOR_FWDONLY;
                    break;
                case 'scroll':
                    $_options[\PDO::ATTR_CURSOR] = \PDO::CURSOR_SCROLL;
                    break;
            endswitch;

            // has type?
            if ( self::$CURSOR_TYPE ):
                //SQL_SRV 
                if ( bcDB::resource( 'RDBMS' ) === 'sqlsrv' ):
                    switch ( self::$CURSOR_TYPE ):
                        case 'static':
                            $_options[\PDO::SQLSRV_ATTR_CURSOR_SCROLL_TYPE] = \PDO::SQLSRV_CURSOR_STATIC;
                            break;
                        case 'dynamic':
                            $_options[\PDO::SQLSRV_ATTR_CURSOR_SCROLL_TYPE] = \PDO::SQLSRV_CURSOR_DYNAMIC;
                            break;
                        case 'keyset':
                            $_options[\PDO::SQLSRV_ATTR_CURSOR_SCROLL_TYPE] = \PDO::SQLSRV_CURSOR_KEYSET_DRIVEN;
                            break;
                        case 'buffered':
                            $_options[\PDO::SQLSRV_ATTR_CURSOR_SCROLL_TYPE] = \PDO::SQLSRV_CURSOR_BUFFERED;
                            break;
                    endswitch;
                endif;
            //todo other drivers if any
            endif;
        endif;

        self::$stmt = bcDB::resource( 'CONNECTION' )->prepare( $stmt, $_options );
    }

    public static function fetchRow()
    {
        //check cursor
        $cursorPos = NULL;
        $cursorOffset = NULL;
        if ( self::$CURSOR_MODE === 'scroll' ):
            if ( self::$CURSOR_POS ):
                $cursorPos = self::getCursorPos( self::$CURSOR_POS );
                $cursorOffset = self::$CURSOR_POS === 'abs' || self::$CURSOR_POS === 'rel' ? self::$CURSOR_OFFSET : NULL;
            endif;
        endif;

        //set fetch mode
        self::setFetchType( self::$FETCH_TYPE );
        $_d = self::$stmt->fetch( NULL, $cursorPos, $cursorOffset );
        self::$FETCH_TYPE = 'assoc';
        self::setFetchType( self::$FETCH_TYPE );
        return $_d;
    }

    public static function fetchAll()
    {
        self::setFetchType( self::$FETCH_TYPE );
        $_d = self::$stmt->fetchAll();
        self::$FETCH_TYPE = 'assoc';
        self::setFetchType( self::$FETCH_TYPE );
        return $_d;
    }

    /**
     * Executes a Prepared Statememt
     * @return bool
     */
    public static function execute()
    {
        //bind params
        foreach ( self::$_BINDS as $k => $_b ):
            $type = \PDO::PARAM_STR;
            if ( $_b['type'] ):
                $type = self::getDataType( $_b['type'] );
            endif;

            $length = NULL;
            if ( $_b['size'] ):
                $length = (int) $_b['size'];
            endif;
            $k++;
            self::$stmt->bindParam( $k, $_b['value'], $type, $length );
        endforeach;
        self::$_BINDS = array(); //reset
        return self::$stmt->execute();
    }

    public static function getAttribute( $attr )
    {
        switch ( $attr ):
            case 'autocommit':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_AUTOCOMMIT );
            case 'case':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_CASE );
            case 'client_version':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_CLIENT_VERSION );
            case 'connection_status':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_CONNECTION_STATUS );
            case 'cursor':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_CURSOR );
            case 'cursor_name':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_CURSOR_NAME );
            case 'default_fetch_mode':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_DEFAULT_FETCH_MODE );
            case 'driver_name':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_DRIVER_NAME );
            case 'emulate_prepares':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_EMULATE_PREPARES );
            case 'errmode':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_ERRMODE );
            case 'fetch_catalog_names':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_FETCH_CATALOG_NAMES );
            case 'fetch_table_names':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_FETCH_TABLE_NAMES );
            case 'max_column_len':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_MAX_COLUMN_LEN );
            case 'oracle_nulls':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_ORACLE_NULLS );
            case 'persistent':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_PERSISTENT );
            case 'prefetch':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_PREFETCH );
            case 'server_info':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_SERVER_INFO );
            case 'server_version':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_SERVER_VERSION );
            case 'statement_class':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_STATEMENT_CLASS );
            case 'stringify_fetches':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_STRINGIFY_FETCHES );
            case 'timeout':
                return bcDB::resource( 'CONNECTION' )->getAttribute( \PDO::ATTR_TIMEOUT );
        endswitch;
    }

    private static function getDataType( $type )
    {
        switch ( $type ):
            case bcDB::TYPE_BOOL:
                return \PDO::PARAM_BOOL;
            case bcDB::TYPE_FLOAT://being said it should be PDO::PARAM_STR
            case bcDB::TYPE_INTEGER:
                return \PDO::PARAM_INT;
            case bcDB::TYPE_NULL:
                return \PDO::PARAM_NULL;
            case bcDB::TYPE_LOB:
                return \PDO::PARAM_LOB;
            default:
                return \PDO::PARAM_STR;
        endswitch;
    }

    private static function getCursorPos( $pos )
    {
        switch ( $pos ):
            case 'next':
                return \PDO::FETCH_ORI_NEXT;
            case 'prior':
                return \PDO::FETCH_ORI_PRIOR;
            case 'first':
                return \PDO::FETCH_ORI_FIRST;
            case 'last':
                return \PDO::FETCH_ORI_LAST;
            case 'abs':
                return \PDO::FETCH_ORI_ABS;
            case 'rel':
                return \PDO::FETCH_ORI_REL;
        endswitch;
    }

    /**
     * 
     * Each database extension has their own ways.
     * When not PDO it will emulates the same feature for PGSQL, SQLSRV etc if 
     * fetch mode is not supported
     * @return bool Returns 1 on success or FALSE on failure.
     */
    private static function setFetchType( $mode )
    {
        switch ( $mode ):
            case 'assoc':
                return self::$stmt->setFetchMode( \PDO::FETCH_ASSOC );
            case 'bound':
                return self::$stmt->setFetchMode( \PDO::FETCH_BOUND );
            case 'both':
                return self::$stmt->setFetchMode( \PDO::FETCH_BOTH );
            case 'class':
                return self::$stmt->setFetchMode( \PDO::FETCH_CLASS, self::$FETCH_CLASS );
            case 'class_prop':
                return self::$stmt->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::$FETCH_CLASS, self::$_FETCH_CLASS_PARAMS );
            case 'class_type':
                return self::$stmt->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_CLASSTYPE );
            case 'column':
                return self::$stmt->setFetchMode( \PDO::FETCH_COLUMN, self::$FETCH_OFFSET );
            case 'column_group':
                return self::$stmt->setFetchMode( \PDO::FETCH_GROUP, self::$FETCH_OFFSET );
            case 'column_unique':
                return self::$stmt->setFetchMode( \PDO::FETCH_UNIQUE, self::$FETCH_OFFSET );
            case 'func':
                return self::$stmt->setFetchMode( \PDO::FETCH_FUNC, self::$FETCH_FUNC );
            case 'into':
                return self::$stmt->setFetchMode( \PDO::FETCH_INTO, self::$FETCH_CLASS );
            case 'key_pair':
                return self::$stmt->setFetchMode( \PDO::FETCH_KEY_PAIR );
            case 'lazy':
                return self::$stmt->setFetchMode( \PDO::FETCH_LAZY );
            case 'named':
                return self::$stmt->setFetchMode( \PDO::FETCH_NAMED );
            case 'num':
                return self::$stmt->setFetchMode( \PDO::FETCH_NUM );
            case 'obj':
                return self::$stmt->setFetchMode( \PDO::FETCH_OBJ );
            case 'serialize':
                return self::$stmt->setFetchMode( \PDO::FETCH_SERIALIZE );
            default:
                return self::$stmt->setFetchMode( \PDO::FETCH_ASSOC );
        endswitch;
    }

}
