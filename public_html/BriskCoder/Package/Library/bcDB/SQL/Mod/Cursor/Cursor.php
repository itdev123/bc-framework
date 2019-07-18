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

final class Cursor 
{
    
    private $ext = 'BriskCoder\Package\Library\bcDB\SQL\Ext\bcDB';
    
    private function __clone(){}
    
    public function __construct( $CALLER )
    {
        if ( $CALLER !==  'BriskCoder\Package\Library\bcDB\SQL\Mod'  ):
            exit('DEBUG: forbidden use of internal class class: ' . __CLASS__);
        endif;
    }
    
    /**
     * Sets cursor mode to forward. Default Mode
     * @return void
     */
    public function modeForward()
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_MODE = 'fw';
        
    }
    
     /**
     * Sets cursor mode to forward. Default Mode
     * @param string $type Sets scrollable cursor type if RDBMS supports it.
     * ie: for SQLSRV driver set $type as "static", "dynamic", "keyset", "buffered"
     * @return void
     */
    public function modeScroll( $type = FALSE )
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_MODE = 'scroll';
        
        if ( $type ):
            $cls::$CURSOR_TYPE = $type;
        endif;
    }
    
    /**
     * Sets cursor mode to scrollable mode and orients it to fetch Next
     * @return void
     */
    public function scrollNext()
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'next';
    }
    
    /**
     * Sets cursor mode to scrollable mode and orients it to fetch Prior
     * @return void
     */
    public function scrollPrior()
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'prior';
    }
    
    /**
     * Sets cursor mode to scrollable and orientation to fetch First
     * @return void
     */
    public function scrollFirst()
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'first';
    }
    
    /**
     * Sets cursor mode to scrollable mode and orients it to fetch Last
     * @return void
     */
    public function scrollLast()
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'last';
    }
    
    /**
     * Sets cursor mode to scrollable mode and orients it to fetch Absolute
     * @param type $offset Offset parameter from the current row
     * @return void
     */
    public function scrollAbsolute( $offset )
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'abs';
        $cls::$CURSOR_OFFSET = $offset;
    }
    
    /**
     * Sets cursor mode to scrollable mode and orients it to fetch Relative
     * @param type $offset Offset parameter 
     * @return void
     */
    public function scrollRelative( $offset )
    {
        $cls = $this->ext . strtoupper(bcDB::resource( 'EXTENSION' ));  
        $cls::$CURSOR_POS = 'rel';
        $cls::$CURSOR_OFFSET = $offset;
    }
}