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

namespace BriskCoder\Package\Library;

/**
 * Cookie
 * @category    Library
 * @package     Package
 */
final class bcCookie
{

    public
    /**
     * Cookie name
     *
     * @var string
     */
            $NAME = null,
            /**
             * Cookie value
             *
             * @var string
             */
            $VALUE = null,
            /**
             * Version
             * 
             * @var integer
             */
            $VERSION = null,
            /**
             * Max Age
             * 
             * @var integer
             */
            $MAX_AGE = null,
            /**
             * Cookie expiry date
             *
             * @var int
             */
            $EXPIRES = null,
            /**
             * Cookie domain
             *
             * @var string
             */
            $DOMAIN = null,
            /**
             * Cookie path
             *
             * @var string
             */
            $PATH = null,
            /**
             * Whether the cookie is secure or not
             *
             * @var boolean
             */
            $SECURE = null,
            /**
             * @var true
             */
            $HTTP_ONLY = null;

    public function __construct()
    {
        
    }

}
