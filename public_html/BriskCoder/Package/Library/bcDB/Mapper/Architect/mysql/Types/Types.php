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

namespace BriskCoder\Package\Library\bcDB\Mapper\Architect\mysql;

/* TODO 
 * 
 * THis will be inside RDBMS package and will load datatypes from specific driver
 * make this a master class so we match all datatypes  and naminconvention globally
 * independent of the RDBMS
 */

final class Types
{

    public

            /**
             * Column DataType
             * @var string
             */
            $TYPE,
            
            /**
             * Column Size
             * @var int
             */
            $SIZE,
            
            /**
             * Column Unsigned
             * @var string
             */
            $UNSIGNED,
            
            /**
             * Column Accepts Null
             * @var bool 
             */
            $IS_NULL = TRUE,
            
            /**
             * Column Is Primary Key
             * @var bool
             */
            $IS_PKEY = FALSE,
            
            /**
             * Column Default Value
             * @var string
             */
            $DEFAULT,
            
            /**
             * Column Extra Information
             * @var string
             */
            $EXTRA,
            
            /**
             * Column Privileges
             * @var string
             */
            $PRIVILEGES,
            
            /**
             * Column Comment
             * @var string
             */
            $COMMENT;


    public function __construct( array $_dataTypes )
    {
        
        $this->TYPE = $_dataTypes['type'];
        $this->SIZE = (int)$_dataTypes['size'];
        $this->UNSIGNED = $_dataTypes['unsigned'];
        $this->IS_NULL = $_dataTypes['null'];
        $this->IS_PKEY = $_dataTypes['key'];
        $this->DEFAULT = $_dataTypes['default'];
        $this->EXTRA = $_dataTypes['extra'];
        $this->PRIVILEGES = $_dataTypes['privileges'];
        $this->COMMENT = $_dataTypes['comment'];
        unset($_dataTypes);
        return $this;
    }

}