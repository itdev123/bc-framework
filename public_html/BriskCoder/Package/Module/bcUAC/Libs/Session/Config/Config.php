<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Session;

final class Config
{

    //BCsession Ini Runtime Configuration
    //Any property set as FALSE will be preserve .ini settings
    public
    /**
     * NAME
     * Sets the BCsession Cookie Name Default is php.ini
     * @var string $NAME 
     */
            $NAME = FALSE,
            /**
             * GC_LIFETIME
             * Sets the BCsession Garbage Collector Max Lifetime. Default is php.ini
             * Max value for "session.gc_maxlifetime" is 65535
             * @var integer $GC_LIFETIME 
             */
            $GC_MAX_LIFETIME = FALSE,
            $GC_PROBABILITY = FALSE,
            $GC_DIVISOR = FALSE,
            /**
             * COOKIE_LIFETIME
             * Sets the BCsession Cookie Max Lifetime. Default is php.ini
             * @var integer $COOKIE_LIFETIME 
             */
            $COOKIE_LIFETIME = 0,
            /**
             * COOKIE_DOMAIN
             * Sets the BCsession Cookie Domain restriction. Use .domain.com for subdomains. Default is php.ini
             * @var string $COOKIE_DOMAIN 
             */
            $COOKIE_DOMAIN = FALSE,
            /**
             * COOKIE_PATH
             * Specifies path to set in the session cookie. Default is php.ini
             * @var boolean $COOKIE_SECURE 
             */
            $COOKIE_PATH = FALSE,
            /**
             * COOKIE_SECURE
             * Only uses Cookies IF via HTTPS protocol. Default is php.ini
             * @var boolean $COOKIE_SECURE 
             */
            $COOKIE_SECURE = FALSE,
            /**
             * COOKIE_HTTP
             * Only uses Cookies Transported VIA HTTP protocol. Default is php.ini
             * @var boolean $COOKIE_HTTP 
             */
            $COOKIE_HTTP_ONLY = 1,
            /**
             * USE_COOKIES
             * Use Cookies with Sessions
             * @var boolean Default is TRUE
             */
            $USE_COOKIES = 1,
            /**
             * COOKIE_ONLY
             * Only uses Cookies to store ID on client side. Default is php.ini
             * @var boolean $COOKIE_ONLY default is TRUE
             */
            $USE_ONLY_COOKIES = 1,
            /**
             * HASH_FUNCTION
             * specify the hash algorithm used to generate the session IDs. Default is php.ini
             * 0 = MD5, 1 = SHA1 (Default)
             * @var integer $HASH_FUNCTION SHA1 (Default)
             */
            $HASH_FUNCTION = 1,
            /**
             * HASH_BITS_PER_CHAR
             * Define how many bits are stored in each character when converting the binary hash data to something readable. Default is php.ini
             * The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
             * @var integer $HASH_BITS_PER_CHAR 5 Default
             */
            $HASH_BITS_PER_CHARACTER = 5;

    //TODO IMPLEMENT OTHER OPTIONS


    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Session' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

}
