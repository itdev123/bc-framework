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

namespace BriskCoder\Package\Library\bcDB\SQL\Mod;

use BriskCoder\Package\Library\bcDB;

final class Attribute
{

    private static $ext = 'BriskCoder\Package\Library\bcDB\SQL\Ext\bcDB';

    private function __clone()
    {
        
    }

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcDB\SQL\Mod' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Get RDBMS autocommit status
     * @return Boolean
     */
    public function autocommit()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'autocommit' );
    }

    /**
     * Get RDBMS case status
     * @return Boolean
     */
    public function _case()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'case' );
    }

    /**
     * Get RDBMS client version
     * @return Boolean
     */
    public function clientVesrion()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'client_version' );
    }

    /**
     * Get RDBMS connection status
     * @return Boolean
     */
    public function connectionStatus()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'connection_status' );
    }

    /**
     * Get RDBMS cursor status
     * @return Boolean
     */
    public function cursor()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'cursor' );
    }

    /**
     * Get RDBMS cursor name
     * @return Boolean
     */
    public function cursorName()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'cursor_name' );
    }

    /**
     * Get RDBMS default fetch mode
     * @return Boolean
     */
    public function defaultFetchMode()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'default_fetch_mode' );
    }

    /**
     * Get RDBMS driver name
     * @return Boolean
     */
    public function driverName()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'driver_name' );
    }

    /**
     * Get RDBMS emulate prepares
     * @return Boolean
     */
    public function emulatePrepares()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'emulate_prepares' );
    }

    /**
     * Get RDBMS errmode status
     * @return Boolean
     */
    public function errMode()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'errmode' );
    }

    /**
     * Get RDBMS fetch catalog names
     * @return Boolean
     */
    public function fetchCatalogNames()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'fetch_catalog_names' );
    }

    /**
     * Get RDBMS fetch table names
     * @return Boolean
     */
    public function fetchTableNames()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'fetch_table_names' );
    }

    /**
     * Get RDBMS max column len
     * @return Boolean
     */
    public function maxColumnLen()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'max_column_len' );
    }

    /**
     * Get RDBMS oracle nulls
     * @return Boolean
     */
    public function oracleNulls()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'oracle_nulls' );
    }

    /**
     * Get RDBMS persistent status
     * @return Boolean
     */
    public function persistent()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'persistent' );
    }

    /**
     * Get RDBMS prefetch status
     * @return Boolean
     */
    public function prefetch()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'prefetch' );
    }

    /**
     * Get RDBMS server_info status
     * @return Boolean
     */
    public function serverInfo()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'server_info' );
    }

    /**
     * Get RDBMS server version
     * @return Boolean
     */
    public function serverVersion()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'server_version' );
    }

    /**
     * Get RDBMS statement class
     * @return Boolean
     */
    public function statementClass()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'statement_class' );
    }

    /**
     * Get RDBMS stringify fetches
     * @return Boolean
     */
    public function stringifyFetches()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'stringify_fetches' );
    }

    /**
     * Get RDBMS timeout
     * @return Boolean
     */
    public function timeout()
    {
        $cls = self::$ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        return $cls::getAttribute( 'timeout' );
    }

}
