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

final class Fetch
{

    private $ext = 'BriskCoder\Package\Library\bcDB\SQL\Ext\bcDB';

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
     * Sets the current fetch type mode to Associative
     * @return void
     */
    public function typeAssociative()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'assoc';
    }

    /**
     * Sets the current fetch type mode to Bound 
     * @return void
     */
    public function typeBound()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'bound';
    }

    /**
     * Sets the current fetch type mode to Both Num and Assoc
     * @return void
     */
    public function typeBoth()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'both';
    }

    /**
     * Sets the current fetch type mode to Class
     * @param string $class specifies the class to use 
     * @return void
     */
    public function typeClass( $class )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$typeClass = $class;
    }

    /**
     * Sets the current fetch type mode to ClassProperties
     * typees row values to properties
     * @param string $class specifies the class to use 
     * @param array $_parameters Class parameters  
     * @return void
     */
    public function typeClassProperties( $class, $_parameters )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'class_prop';
        $cls::$typeClass = $class;
        $cls::$_typeClassParams = $_parameters;
    }

    /**
     * Sets the current fetch type mode to ClassType
     * The name of the class is determined from a value of the first column
     * @return void
     */
    public function typeClassType()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'class_type';
    }

    /**
     * Sets the current fetch type mode to Column
     * @param int $offset Column offset number
     * @return void
     */
    public function typeColumn( $offset )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'column';
        $cls::$typeOffset = $offset;
    }

    /**
     * Sets the current fetch type mode to ColumnGroup
     * @param int $offset Column offset number
     * @return void
     */
    public function typeColumnGroup( $offset )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'column_group';
        $cls::$typeOffset = $offset;
    }

    /**
     * Sets the current fetch type mode to ColumnUnique
     * @param int $offset Column offset number
     * @return void
     */
    public function typeColumnUnique( $offset )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'column_unique';
        $cls::$typeOffset = $offset;
    }

    /**
     * Sets the current fetch type mode to Into
     * @param string $function specifies the function to use  
     * @return void
     */
    public function typeFunction( $function )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'func';
        $cls::$typeFunc = $function;
    }

    /**
     * Sets the current fetch type mode to Into
     * @param string $className Determines the class name 
     * @return void
     */
    public function typeInto( $className )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'into';
        $cls::$typeClass = $className;
    }

    /**
     * Sets the current fetch type mode to KeyPair
     * @return void
     */
    public function typeKeyPair()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'key_pair';
    }

    /**
     * Sets the current fetch type mode to Lazy
     * @return void
     */
    public function typeLazy()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'lazy';
    }

    /**
     * Sets the current fetch type mode to Named
     * @return void
     */
    public function typeNamed()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
         $cls::$FETCH_TYPE = 'named';
    }

    /**
     * Sets the current fetch type mode to Num
     * @return void
     */
    public function typeNum()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'num';
    }

    /**
     * Sets the current fetch type mode to Obj
     * @return void
     */
    public function typeObj()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'obj';
    }

    /**
     * Sets the current fetch type mode to Serialize
     * @param string $className Determines the class name 
     * @return void
     */
    public function typeSerialize( $className )
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::$FETCH_TYPE = 'serialize';
        $cls::$typeClass = $className;
    }

}
