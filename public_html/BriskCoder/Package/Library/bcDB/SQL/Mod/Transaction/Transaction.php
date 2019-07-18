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

final class Transaction
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
     * Begin Transaction
     * @return bool
     */
    public function begin()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::transactionBegin();
    }

    /**
     * Commit Transaction
     * @return bool
     */
    public function commit()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
         $cls::transactionCommit();
    }

    /**
     * RollBack Transaction
     * @return bool
     */
    public function rollBack()
    {
        $cls = $this->ext . strtoupper( bcDB::resource( 'EXTENSION' ) );
        $cls::transactionRollback();
    }

}
