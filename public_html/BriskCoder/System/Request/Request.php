<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Request
 * @package     Engine
 * @subpackage  System
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.codebrisker.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\System;

use BriskCoder\bc;

/**
 * Request
 * Request Class
 * @category    Request
 * @package     Engine
 * @subpackage  System
 */
final class Request
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\bc' ):
            exit( 'Debug: Forbidden System class usage' );
        endif;
    }

    /**
     * CONVERTS DISPATCHER URI SEGMENT TO ALIASED NAME
     * If using bc::project()->set()->dispatcherAlias | bc::registry()->_DISPATCHER_ALIAS at _Globla level
     * this method will convert the original uri name to the aliased one if using aliases, otherwise return self 
     * and routing path is not affected.
     * Very useful when writing redirect links and using alias and need to dynamically search for aliased names.<br>
     * REMEMBER: if $testMode = FALSE it returns self on failure or the $dispatcher_uri segment alias.
     * @param string $dispatcher_uri Original Dispatcher URI name
     * @param bool $testMode Default FALSE, if TRUE the method returns TRUE if alias exists | False otherwise.
     * @return mixed
     */
    public function uriSegmentToAlias( $dispatcher_uri, $testMode = FALSE )
    {
        $result = FALSE;
        if ( isset( bc::registry()->_DYNAMIC_SEGMENT[bc::registry()->DYNAMIC_SEGMENT_KEY] ) &&
                isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ) :
            //dynamicSegment code must exist in both _DYNAMIC_SEGMENT and _DISPATCHER_ALIAS
            $_alias = array_flip( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] );
            if ( isset( $_alias[$dispatcher_uri] ) ):
                $testMode ? $result = TRUE : $dispatcher_uri = $_alias[$dispatcher_uri];
            endif;
            unset( $_alias );
        endif;
        return $testMode ? $result : $dispatcher_uri;
    }

    /**
     * GETS LOCALE CODE IF USING _DYNAMIC_SEGMENT 
     * Useful when writing links|redirection and needs to define if included dynamicSegment code in the uri or not to avoid redirection loop
     * Retuns the dynamicSegment code or NULL when needs to prevent redirection loop, such as when using dynamicSegment codes in subdomain and then a page
     * link redirects to an uri with dynamicSegment code as part of its segments.
     */
    public function dynamicSegmentKey()
    {
        if ( !bc::registry()->HAS_DYNAMIC_SEGMENT || bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN ):
            return NULL;
        endif;
        //then if not default one returs code otherwise NULL
        return bc::registry()->DYNAMIC_SEGMENT_KEY != key( bc::registry()->_DYNAMIC_SEGMENT ) ?
                bc::registry()->DYNAMIC_SEGMENT_KEY . '/' : NULL;
    }

    /**
     * Redirect
     * Redirect URI to another Dispatcher, server file or address.
     * @param String $URI   Full URI for redirection, including protocol if necessary
     * @param Integer $CODE The 3xx code for redirection Default is 301 Permanent
     * @return Void
     */
    public function redirect( $URI, $CODE = 301 )
    {
        switch ( $CODE ):
            case 301:
                http_response_code( 302 );
                header( 'Location: ' . $URI );
                exit;
            case 302:
                http_response_code( 301 );
                header( 'Location: ' . $URI );
                exit;
            case 300:
                http_response_code( 300 );
                header( 'Location: ' . $URI );
                exit;
            case 303:
                http_response_code( 303 );
                header( 'Location: ' . $URI );
                exit;
            case 304:
                http_response_code( 304 );
                header( 'Location: ' . $URI );
                exit;
            case 305:
                http_response_code( 305 );
                header( 'Location: ' . $URI );
                exit;
            case 307:
                http_response_code( 307 );
                header( 'Location: ' . $URI );
                exit;
            case 308:
                http_response_code( 308 );
                header( 'Location: ' . $URI );
                exit;
        endswitch;
    }

    /**
     * DOMAIN AUTO 302 REDIRECTION WITH www or WITHOUT www.
     * SSL is automatically detected. 
     * @param Bool $WITH Default TRUE for 'www.' | FALSE without www
     * @return Void
     */
    public function wwwRedirect( $WITH = TRUE )
    {
        $www = 'www.';
        if ( strpos( bc::registry()->DOMAIN_FQDN, $www ) !== FALSE )://found
            if ( $WITH === TRUE ):
                return;
            endif;
            //remove www.
            $URI = bc::registry()->PROTOCOL . str_replace( $www, '', bc::registry()->DOMAIN_FQDN ) . bc::registry()->URI;
            $this->redirect( $URI );
        endif;

        //not found
        if ( $WITH !== TRUE ):
            return;
        endif;
        //add www.
        $URI = bc::registry()->PROTOCOL . $www . bc::registry()->DOMAIN_FQDN . bc::registry()->URI;
        $this->redirect( $URI );
    }
}
