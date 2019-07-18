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

namespace BriskCoder\Package\Library\bcDB\SQL;

use BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcDB\SQL\Mod\Cursor,
    BriskCoder\Package\Library\bcDB\SQL\Mod\Fetch,
    BriskCoder\Package\Library\bcDB\SQL\Mod\Attribute,
    BriskCoder\Package\Library\bcDB\SQL\Mod\Transaction;

final class Mod
{

    private $ext = 'BriskCoder\Package\Library\bcDB\SQL\Ext\bcDB';

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
     * DataSet Cursor
     * NOTE: MySQL, SQLite Does not support cursors and if used with a different RDBMS such as SQLSRV
     * and at a later time you switch you app to one of the above then all you code relying on cursors will break!
     * @static $obj
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Cursor
     */
    public function setCursor()
    {
        static $obj;
        return $obj instanceof Cursor ? $obj : $obj = new Cursor( __CLASS__ );
    }

    /**
     * Data Return Mode
     * Associative is default retun type
     * @static $obj
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Fetch
     */
    public function setFetch()
    {
        static $obj;
        return $obj instanceof Fetch ? $obj : $obj = new Fetch( __CLASS__ );
    }

    /**
     * Get RDBMS Attributes
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Attribute
     */
    public function getAttribute()
    {
        static $obj;
        return $obj instanceof Attribute ? $obj : $obj = new Attribute( __CLASS__ );
    }

    /**
     * SQL Transaction
     * @static $obj
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod\Transaction
     */
    public function transaction()
    {
        static $obj;
        return $obj instanceof Transaction ? $obj : $obj = new Transaction( __CLASS__ );
    }

    /**
     * Sanitizes the SQL value by quoting it when not using prepared statment
     * @return mixed Quoted Value
     */
    public function quote( $value )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::quote( $value );
    }

    /**
     * Executes a Query Statement
     * Remember to use ->quote( $value )  when executing SELECTS and dealing with untrusted data.
     * @param string $stmt to be executed
     * @return mixed Data | BOOL  Depending on the type of statement
     */
    public function query( $stmt )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::query( $stmt );
    }

    /**
     * Gets the last ID of an auto_increment primary key from an INSERT statement
     * if in a transaction invoke lastInsertID BEFORE a commit
     * @return int row ID
     */
    public function lastInsertID()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::lastInsertID();
    }

    /**
     * Prepares a Statement for execution
     * @return void
     */
    public function prepare( $stmt )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::prepare( $stmt );
    }

    /**
     * Dynamicaly binds value type data for multiquery execution <br>
     * @param mixed $value Value type data
     * @param string $type optional datatype bcDB::TYPE_*
     * @param int $size Optional datasize 
     * @return void
     */
    public function bind( $value, $type = NULL, $size = NULL )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$_BINDS[] = array(
            'value' => $value,
            'type' => $type,
            'size' => $size
        );
    }

    /**
     * Returns all bound values up to time invoked
     * This is very useful for Cache System when using prepared statements and need parameterized data
     * to be included as part of the cache index key
     * Array structure is Num index
     * @return array 
     */
    public function boundValues()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $_r = array();
        foreach ( $cls::$_BINDS as $_b ):
            $_r[] = $_b['value'];
        endforeach;
        return $_r;
    }

    /**
     * Executes a Prepared Stament
     * @return bool
     */
    public function execute()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::execute();
    }

    /**
     * Fetches next row
     * @return mixed FALSE on fail
     */
    public function fetchRow()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::fetchRow();
    }

    /**
     * Fetches All Records
     * @return mixed FALSE on fail
     */
    public function fetchAll()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::fetchAll();
    }

}
