<?php

namespace BriskCoder\System;

use BriskCoder\bc;

class Router
{

    private static
            $_Global = FALSE,
            $E_404 = FALSE,
            $E_403 = FALSE,
            $custom_dispatcher_path = 'BriskCoder' . DIRECTORY_SEPARATOR . 'Priv' . DIRECTORY_SEPARATOR . 'Ams' . DIRECTORY_SEPARATOR;

    public static function route( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\System\Project' ):
            exit( 'DEBUG: forbidden use system class - System\Router' );
        endif;


        /**
         * Set bc::registry()->URI_SEGMENT with url fragments without query string, if any segment
         */
        bc::registry()->URI_SEGMENT = strtolower( ltrim( rtrim( bc::registry()->URI_NO_QS, '/' ), '/' ) );

        /**
         * Fill $_SUBDOMAIN array with subdomain parts, if any
         */
        $_SUBDOMAIN = explode( '.', bc::registry()->DOMAIN_FQDN ); // SLD is like co.uk

        /**
         * Transfer bc::registry()->URI_SEGMENT string to $_SEGMENTS as array split by /, if any
         */
        $_SEGMENTS = array_filter( explode( '/', bc::registry()->URI_SEGMENT ) );

        /**
         * $_REDIR array is used to remove default package/dispatcher from url and redirect
         */
        $_REDIR = FALSE;


//        if ( bc::registry()->URI_SEGMENT ):
//            if ( !preg_match( '/^[a-z0-9_\/\.-]+$/', bc::registry()->URI_SEGMENT ) )://improper chars found or uppercase
//                self::$E_404 = TRUE;
//                self::runProject( NULL );
//            endif;
//        endif;

        /**
         * Search in bc::registry()->_PROJECTS array key for any $_SUBDOMAIN value matching, returns $_array matches if any
         */
        $_array = array_intersect_key( array_flip( $_SUBDOMAIN ), bc::registry()->_PROJECTS );

        /**
         * Set bc::registry()->DEFAULT_PROJECT_ALIAS with bc::registry()->_PROJECTS key alias
         */
        bc::registry()->DEFAULT_PROJECT_ALIAS = key( bc::registry()->_PROJECTS );

        /**
         * Set  bc::registry()->DEFAULT_PROJECT_PACKAGE with default package name bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['PACKAGE_NAME']
         */
        bc::registry()->DEFAULT_PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['PACKAGE_NAME'];

        /**
         * If $_array(bc::registry()->_PROJECTS array key matches any $_SUBDOMAIN value)
         */
        if ( $_array ):
            /**
             * Reset $_array with the value of the first array element or FALSE if array is empty
             */
            reset( $_array );
            /**
             * Set bc::registry()->PROJECT_ALIAS with $_array key(alias)
             */
            bc::registry()->PROJECT_ALIAS = key( $_array );
            /**
             * Set bc::registry()->PROJECT_PACKAGE with package name bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME']
             */
            bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
        endif;


        /**
         * If there are segments
         */
        if ( $_SEGMENTS ):
//            foreach ( $_SEGMENTS as $v ):
//                if ( !preg_match( '/(?=^[a-z_])(.*[a-z0-9_]$)/', $v ) )://improper chars found
//                    self::$E_404 = TRUE;
//                    self::runProject( NULL );
//                endif;
//            endforeach;

            /**
             * Search in bc::registry()->_PROJECTS array key for any $_SEGMENTS value matching, return $_array matches if any
             */
            $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_PROJECTS );
            /* NAMING CONVENTION */
            $_dispatcher_array = array();
            /**
             * Search in $_SEGMENTS for DEFAULT_DISPATCHER bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['DEFAULT_DISPATCHER'] 
             */
            foreach ( $_SEGMENTS as $segment ):
                $segment = self::namingConvention( bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['NAMING_CONVENTION'], $segment );
                if ( $segment !== bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['DEFAULT_DISPATCHER'] ):
                    continue;
                endif;
                $_dispatcher_array = array_flip( $_SEGMENTS );
            endforeach;
            /**
             * If $_array bc::registry()->_PROJECTS array key matches any $_SEGMENTS value
             */
            if ( $_array ):
                /**
                 * Reset $_array with the value of the first array element or FALSE if array is empty
                 */
                reset( $_array );
                /**
                 * Get $_array first key(alias)
                 */
                $key = key( $_array );
                /**
                 * If bc::registry()->PROJECT_ALIAS meaning (bc::registry()->_PROJECTS array key matches any $_SEGMENTS value)
                 */
                if ( bc::registry()->PROJECT_ALIAS ):
                    /**
                     * If  bc::registry()->PROJECT_ALIAS is equal $key(alias)
                     */
                    if ( bc::registry()->PROJECT_ALIAS === $key ):
                        /**
                         * Unset bc::registry()->PROJECT_ALIAS from $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] array, meaning removing alias from url
                         */
                        unset( $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] );
                        /**
                         * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS array
                         */
                        $_REDIR = $_SEGMENTS;
                    endif;
                else:
                    /**
                     * Set bc::registry()->PROJECT_ALIAS with $key alias 
                     */
                    bc::registry()->PROJECT_ALIAS = $key;
                    /**
                     * Set bc::registry()->PROJECT_PACKAGE with project package name bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME']
                     */
                    bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
                    /**
                     * Unset bc::registry()->PROJECT_ALIAS from $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] array, meaning removing alias from url
                     */
                    unset( $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] );
                    /**
                     * If $key alias is equal  bc::registry()->DEFAULT_PROJECT_ALIAS
                     */
                    if ( $key === bc::registry()->DEFAULT_PROJECT_ALIAS ):
                        /**
                         * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS array
                         */                                        
                        $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : (!empty($_GET) ? array() : array( '/' => '' ));//if there's get on the url keep default dispatcher on the url
                    endif;
                endif;
            elseif ( $_dispatcher_array )://not using alias on the url but using dispatcher                 
                /**
                 * Reset $_dispatcher_array with the value of the first array element or FALSE if array is empty
                 */
                reset( $_dispatcher_array );
                /**
                 * Get $_dispatcher_array first key(dispatcher)
                 */
                $key = key( $_dispatcher_array );

                /**
                 * Set bc::registry()->PROJECT_ALIAS with  bc::registry()->DEFAULT_PROJECT_ALIAS since $key is a dispatcher
                 */
                bc::registry()->PROJECT_ALIAS = bc::registry()->DEFAULT_PROJECT_ALIAS;
                /**
                 * Set bc::registry()->PROJECT_PACKAGE with project package name bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME']
                 */
                bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
                /**
                 * If $key alias is equal DEFAULT_DISPATCHER bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER']
                 */
                if ( self::namingConvention( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['NAMING_CONVENTION'], $key ) === bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER'] ):   //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                    
                    /**
                     * Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing dispatcher from url
                     */
                    unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                    /**
                     * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS array
                     */
                    $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : (!empty($_GET) ? array() : array( '/' => '' ));//if there's get on the url keep default dispatcher on the url
                endif;
            endif;
        endif;           
        /**
         * If different than bc::registry()->PROJECT_ALIAS
         * a-(bc::registry()->_PROJECTS array key for any $_SUBDOMAIN value DOES NOT MATCH) and
         * b-(using $_SEGMENTS but bc::registry()->_PROJECTS array key for any $_SEGMENTS value DOES NOT MATCH) and
         * c-(NOT using any $_SEGMENTS)
         */
        if ( !bc::registry()->PROJECT_ALIAS ):
            /**
             * Set bc::registry()->PROJECT_ALIAS with bc::registry()->DEFAULT_PROJECT_ALIAS
             */
            bc::registry()->PROJECT_ALIAS = bc::registry()->DEFAULT_PROJECT_ALIAS;
            /**
             * Set bc::registry()->PROJECT_PACKAGE with bc::registry()->DEFAULT_PROJECT_PACKAGE
             */
            bc::registry()->PROJECT_PACKAGE = bc::registry()->DEFAULT_PROJECT_PACKAGE;
        endif;
        /**
         * Set bc::registry()->MEDIA_PATH_SYSTEM with bc::registry()->PROJECT_PACKAGE Media BC_PUBLIC_PATH
         */
        bc::registry()->MEDIA_PATH_SYSTEM = BC_PUBLIC_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Media' . DIRECTORY_SEPARATOR;
        /**
         * Set bc::registry()->MEDIA_PATH_URI with bc::registry()->PROJECT_PACKAGE Media URI
         */
        bc::registry()->MEDIA_PATH_URI = '/' . bc::registry()->PROJECT_PACKAGE . '/Media/';
        /**
         * Set local the $NAMING_CONVENTION with Project NAMING_CONVENTION bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['NAMING_CONVENTION']
         */
        $NAMING_CONVENTION = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['NAMING_CONVENTION'];
        /**
         * Set local $DEFAULT_DISPATCHER with Project DEFAULT_DISPATCHER bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER']
         */
        $DEFAULT_DISPATCHER = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER'];
        /**
         * Set on bc::registry()->EXTERNAL_TEMPLATE with Project EXTERNAL_TEMPLATE bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['EXTERNAL_TEMPLATE']
         */
        bc::registry()->EXTERNAL_TEMPLATE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['EXTERNAL_TEMPLATE'];
        /**
         * Set bc::registry()->_REMOTE_MEDIA_TIERS with Project _MEDIA_TIERS bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_MEDIA_TIERS']         
         */
        bc::registry()->_REMOTE_MEDIA_TIERS = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_MEDIA_TIERS'];
        /**
         * Set bc::registry()->_DYNAMIC_SEGMENT with Project _DYNAMIC_SEGMENT bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DYNAMIC_SEGMENT']         
         */
        bc::registry()->_DYNAMIC_SEGMENT = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DYNAMIC_SEGMENT'];
        /**
         * Set bc::registry()->_DISPATCHER_ALIAS with Project _DISPATCHER_ALIAS bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DISPATCHER_ALIAS']
         */
        bc::registry()->_DISPATCHER_ALIAS = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DISPATCHER_ALIAS'];

        /**
         * Reset bc::registry()->HAS_DYNAMIC_SEGMENT to FALSE
         */
        bc::registry()->HAS_DYNAMIC_SEGMENT = FALSE; //reset to make sure
        /**
         * Set local variable $dynamicSegmentFingerPrint to NULL
         */
        $dynamicSegmentFingerPrint = NULL;
        /**
         * If bc::registry()->_DYNAMIC_SEGMENT is type array and is not empty menaing it does have dynamic segment
         */
        if ( ((array) bc::registry()->_DYNAMIC_SEGMENT === bc::registry()->_DYNAMIC_SEGMENT) && (!empty( bc::registry()->_DYNAMIC_SEGMENT )) ):
            /*
             * Set bc::registry()->HAS_DYNAMIC_SEGMENT to TRUE
             */
            bc::registry()->HAS_DYNAMIC_SEGMENT = TRUE;
            /**
             * Set local $dynamicSegmentFingerPrint to md5 Jason encoded  bc::registry()->_DYNAMIC_SEGMENT 
             */
            $dynamicSegmentFingerPrint = md5( json_encode( bc::registry()->_DYNAMIC_SEGMENT ) );
            /**
             * Search in bc::registry()->_DYNAMIC_SEGMENT array key for any $_SUBDOMAIN value matching, return $_array matches if any
             */
            $_array = array_intersect_key( array_flip( $_SUBDOMAIN ), bc::registry()->_DYNAMIC_SEGMENT );
            /**
             * If $_array meaning (bc::registry()->_DYNAMIC_SEGMENT array key for any $_SUBDOMAIN value matched)
             */
            if ( $_array ):
                /**
                 * Reset $_array with the value of the first array element or FALSE if array is empty
                 */
                reset( $_array );
                /**
                 * Set bc::registry()->DYNAMIC_SEGMENT_KEY with bc::registry()->_DYNAMIC_SEGMENT array key matched with $_SUBDOMAIN value
                 */
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( $_array );
                /**
                 * Set bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN to TRUE meaning Dynamic Segment is a subdomain
                 */
                bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN = TRUE;
            else:
                /**
                 * bc::registry()->_DYNAMIC_SEGMENT array key for any $_SUBDOMAIN value DOES NOT MATCH
                 */
                /**
                 * Reset  bc::registry()->_DYNAMIC_SEGMENT with the value of the first array element or FALSE if array is empty
                 */
                reset( bc::registry()->_DYNAMIC_SEGMENT );
                /**
                 * Set bc::registry()->DYNAMIC_SEGMENT_KEY with bc::registry()->_DYNAMIC_SEGMENT array key
                 */
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
            endif;
        endif;

        /**
         * If bc::registry()->HAS_DYNAMIC_SEGMENT and there are $_SEGMENTS
         */
        if ( bc::registry()->HAS_DYNAMIC_SEGMENT && (!empty( $_SEGMENTS )) ):
            /**
             * Search in bc::registry()->_DYNAMIC_SEGMENT array key for any $_SEGMENTS value matching, return $_array matches if any
             */
            $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_DYNAMIC_SEGMENT );
            /**
             * If $_array meaning (bc::registry()->_DYNAMIC_SEGMENT array key for any $_SEGMENTS value matched)
             */
            if ( $_array ):
                /**
                 * Reset $_array with the value of the first array element or FALSE if array is empty
                 */
                reset( $_array );
                /**
                 * Get $_array key(segment)
                 */
                $key = key( $_array );
                /**
                 * Check if segment is the first to remove for url, otherwise let it run and return dispatcher not found
                 * Meaning _DYNAMIC_SEGMENT must be firts of all segments
                 */
                if ( $_array[$key] === 0 ):
                    /**
                     * If bc::registry()->DYNAMIC_SEGMENT_KEY is equal $key(segment)
                     */
                    if ( bc::registry()->DYNAMIC_SEGMENT_KEY === $key ):
                        /**
                         * Unset bc::registry()->DYNAMIC_SEGMENT_KEY from $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] array
                         */
                        unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                        /**
                         * If bc::registry()->PROJECT_ALIAS is different than the bc::registry()->DEFAULT_PROJECT_ALIAS
                         */
                        if ( bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS ):
                            /**
                             * Set local $_array with the $_SEGMENTS array
                             */
                            $_array = $_SEGMENTS;
                            /**
                             * Prepending bc::registry()->PROJECT_ALIAS to the beginning of $_array
                             */
                            array_unshift( $_array, bc::registry()->PROJECT_ALIAS );
                            /**
                             * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_array array
                             * redirecting defaults
                             */
                            $_REDIR = $_array; //redirect defaults
                        else:
                            /*
                             * Check for dispatcher to remove from url
                             */
                            $_dispatcher_array = array();
                            foreach ( $_SEGMENTS as $segment ):
                                $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                if ( $segment !== $DEFAULT_DISPATCHER ):
                                    continue;
                                endif;
                                $_dispatcher_array = array_flip( $_SEGMENTS );
                            endforeach;
                            reset( $_dispatcher_array );
                            /**
                             * Get $_dispatcher_array first key(dispatcher)
                             */
                            $key = key( $_dispatcher_array );
                            if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                    
                                /**
                                 * Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing default dispatcher from url
                                 */
                                unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                            endif;
                            /**
                             * If bc::registry()->PROJECT_ALIAS is equal bc::registry()->DEFAULT_PROJECT_ALIAS
                             * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS array
                             */
                            $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : (!empty($_GET) ? array() : array( '/' => '' ));//if there's get on the url keep default dispatcher on the url
                        endif;
                    elseif ( !bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN ): // If different than bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN meaning Dynamic Segment is not a sub domain 
                        /**
                         * Set bc::registry()->DYNAMIC_SEGMENT_KEY with $key(segment)
                         */
                        bc::registry()->DYNAMIC_SEGMENT_KEY = $key;

                        /**
                         * Unset bc::registry()->DYNAMIC_SEGMENT_KEY from $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] array
                         */
                        unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                        /*
                         * Check for dispatcher to remove dispatcher from url
                         */
                        $_dispatcher_array = array();
                        foreach ( $_SEGMENTS as $segment ):
                            $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                            if ( $segment !== $DEFAULT_DISPATCHER ):
                                continue;
                            endif;
                            $_dispatcher_array = array_flip( $_SEGMENTS );
                        endforeach;
                        reset( $_dispatcher_array );
                        /**
                         * Get $_dispatcher_array first key(dispatcher)
                         */
                        $key = key( $_dispatcher_array );
                        if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                    
                            /**
                             * Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing dispatcher from url
                             */
                            unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                            /**
                             * Set local $_array with the $_SEGMENTS array
                             */
                            $_array = $_SEGMENTS;
                            /**
                             * Prepending bc::registry()->DYNAMIC_SEGMENT_KEY to the beginning of $_array
                             */
                            array_unshift( $_array, bc::registry()->DYNAMIC_SEGMENT_KEY );
                            /**
                             * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS including DYNAMIC_SEGMENT_KEY  array
                             */
                            $_REDIR = $_array;
                        endif;
                    endif;
                endif;
            endif;
            /**
             * If is different than bc::registry()->DYNAMIC_SEGMENT_KEY
             * a-(bc::registry()->_DYNAMIC_SEGMENT array key DOES NOT MATCH with $_SUBDOMAIN value) and
             * b-(it DOES NOT HAVE bc::registry()->_DYNAMIC_SEGMENT)     
             */
            if ( !bc::registry()->DYNAMIC_SEGMENT_KEY ):
                /**
                 * Reset bc::registry()->_DYNAMIC_SEGMENT with the value of the first array element or FALSE if array is empty
                 */
                reset( bc::registry()->_DYNAMIC_SEGMENT );
                /**
                 * Set bc::registry()->DYNAMIC_SEGMENT_KEY with bc::registry()->_DYNAMIC_SEGMENT key
                 */
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
            endif;
        endif;

        /**
         * Set bc::registry()->DISPATCHER_NS with '_Global' string with global class name,  so _Global is traceable when running
         */
        bc::registry()->DISPATCHER_NS = '_Global'; //important, so _Global is traceable when running
        //the above was added to define when bc::publisher()->addHeadIncludes() is _Global or Dispatcher levels
        //Check if using _Global then initialize
        $projGlobalClass = 'Dispatcher\\' . '_Global';
        if ( class_exists( $projGlobalClass ) ):
            self::$_Global = new $projGlobalClass();
        endif;
        //RUNS _GLOBAL Constructor
        self::run_GlobalConstructor();

        //check for overrides
        if ( $dynamicSegmentFingerPrint !== md5( json_encode( bc::registry()->_DYNAMIC_SEGMENT ) ) ):
            /**
             * If there are bc::registry()->_DYNAMIC_SEGMENT
             */
            if ( !empty( bc::registry()->_DYNAMIC_SEGMENT ) ):
                /**
                 * Set bc::registry()->HAS_DYNAMIC_SEGMENT to TRUE
                 */
                bc::registry()->HAS_DYNAMIC_SEGMENT = TRUE;
                /**
                 * Reset bc::registry()->_DISPATCHER_ALIAS with the value of the first array element or FALSE if array is empty
                 */
                reset( bc::registry()->_DISPATCHER_ALIAS );
                /**
                 * Set bc::registry()->DYNAMIC_SEGMENT_KEY with bc::registry()->_DYNAMIC_SEGMENT key
                 */
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
                /**
                 * If there are $_SEGMENTS
                 */
                if ( (!empty( $_SEGMENTS ) ) ):
                    /**
                     * Search in bc::registry()->_DYNAMIC_SEGMENT array key for any $_SEGMENTS value matching, return $_array matches if any
                     */
                    $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_DYNAMIC_SEGMENT );
                    /**
                     * If $_array meaning (bc::registry()->_DYNAMIC_SEGMENT array key for any $_SEGMENTS value DOES MATCH)
                     */
                    if ( $_array ):
                        /**
                         * Reset $_array with the value of the first array element or FALSE if array is empty
                         */
                        reset( $_array );
                        /**
                         * Set local $key with $_array key(segment)
                         */
                        $key = key( $_array );
                        /**
                         * Check if segment is the first to remove for url, otherwise let it run and return dispatcher not found
                         * Meaning _DYNAMIC_SEGMENT must be firts of all segments
                         */
                        if ( $_array[$key] === 0 ):
                            /**
                             * If bc::registry()->DYNAMIC_SEGMENT_KEY is equal $key(segment)
                             */
                            if ( bc::registry()->DYNAMIC_SEGMENT_KEY === $key ):
                                /**
                                 * Uset bc::registry()->DYNAMIC_SEGMENT_KEY from $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] array
                                 */
                                unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                                /**
                                 * If bc::registry()->PROJECT_ALIAS is different than the bc::registry()->DEFAULT_PROJECT_ALIAS
                                 */
                                if ( bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS ):
                                    /**
                                     * Set local $_array with the $_SEGMENTS array
                                     */
                                    $_array = $_SEGMENTS;
                                    /**
                                     * Prepending bc::registry()->PROJECT_ALIAS to the beginning of $_array
                                     */
                                    array_unshift( $_array, bc::registry()->PROJECT_ALIAS );
                                    /**
                                     * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_array array
                                     * redirecting defaults
                                     */
                                    $_REDIR = $_array; //redirect defaults
                                else:
                                    /*
                                     * Check for dispatcher to remove from url
                                     */
                                    $_dispatcher_array = array();
                                    foreach ( $_SEGMENTS as $segment ):
                                        $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                        if ( $segment !== $DEFAULT_DISPATCHER ):
                                            continue;
                                        endif;
                                        $_dispatcher_array = array_flip( $_SEGMENTS );
                                    endforeach;
                                    reset( $_dispatcher_array );
                                    /**
                                     * Get $_dispatcher_array first key(dispatcher)
                                     */
                                    $key = key( $_dispatcher_array );
                                    if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                    
                                        /**
                                         * Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing default dispatcher from url
                                         */
                                        unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                                    endif;
                                    /**
                                     * If bc::registry()->PROJECT_ALIAS is equal bc::registry()->DEFAULT_PROJECT_ALIAS
                                     * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS array
                                     */
                                    $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : (!empty($_GET) ? array() : array( '/' => '' ));//if there's get on the url keep default dispatcher on the url
                                endif;
                            elseif ( !bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN ):// If bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN meaning Dynamic Segment is not a sub domain                                                      
                                /**
                                 * Set bc::registry()->DYNAMIC_SEGMENT_KEY with $key(segment)
                                 */
                                bc::registry()->DYNAMIC_SEGMENT_KEY = $key;
                                /**
                                 * Unset bc::registry()->DYNAMIC_SEGMENT_KEY from $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] array
                                 */
                                unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                                /*
                                 * Check for dispatcher to remove from url
                                 */
                                $_dispatcher_array = array();
                                foreach ( $_SEGMENTS as $segment ):
                                    $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                    if ( $segment !== $DEFAULT_DISPATCHER ):
                                        continue;
                                    endif;
                                    $_dispatcher_array = array_flip( $_SEGMENTS );
                                endforeach;
                                reset( $_dispatcher_array );
                                /**
                                 * Get $_dispatcher_array first key(dispatcher)
                                 */
                                $key = key( $_dispatcher_array );
                                if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                    
                                    /**
                                     * Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing dispatcher from url
                                     */
                                    unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                                    /**
                                     * Set local $_array with the $_SEGMENTS array
                                     */
                                    $_array = $_SEGMENTS;
                                    /**
                                     * Prepending bc::registry()->DYNAMIC_SEGMENT_KEY to the beginning of $_array
                                     */
                                    array_unshift( $_array, bc::registry()->DYNAMIC_SEGMENT_KEY );
                                    /**
                                     * Set local $_REDIR(array used to remove default package/dispatcher from url and redirect) with $_SEGMENTS including DYNAMIC_SEGMENT_KEY  array
                                     */
                                    $_REDIR = $_array;
                                endif;
                            endif;
                        endif;
                    endif;
                    /**
                     * If is different than bc::registry()->DYNAMIC_SEGMENT_KEY
                     * (it DOES NOT HAVE bc::registry()->DYNAMIC_SEGMENT_KEY)
                     */
                    if ( !bc::registry()->DYNAMIC_SEGMENT_KEY ):
                        /**
                         * Reset bc::registry()->_DYNAMIC_SEGMENT with the value of the first array element or FALSE if array is empty
                         */
                        reset( bc::registry()->_DYNAMIC_SEGMENT );
                        /**
                         * Set  bc::registry()->DYNAMIC_SEGMENT_KEY with bc::registry()->_DYNAMIC_SEGMENT key
                         */
                        bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
                    endif;
                endif;
            endif;
        endif;
 
        /**
         * If different than empty $_REDIR array         
         */
        if ( !empty( $_REDIR ) ):
            /**
             * Transfer $_REDIR array into a string
             */
            $var = implode( '/', $_REDIR );
            /**
             * Concatenate $_REDIR with the $_SERVER['QUERY_STRING']
             */
            $var .= $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : NULL;
            /**
             * Redirect
             */
            bc::request()->redirect( '/' . $var, 301 );
        endif;



        //IF NO segments or Manual Routing requested then lets dispatch already ALL TO DEFAULT DISPATCHER
        if ( !bc::registry()->URI_SEGMENT || ( bc::registry()->URI_SEGMENT === bc::registry()->PROJECT_ALIAS ) || ( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['MANUAL_ROUTING'] === TRUE ) ):
            /**
             * Set bc::registry()->DISPATCHER_URI with $DEFAULT_DISPATCHER all in lowercase
             */
            bc::registry()->DISPATCHER_URI = strtolower( $DEFAULT_DISPATCHER );
            /**
             * Set local $CURR_DISPATCHER and bc::registry()->DISPATCHER_NS with $DEFAULT_DISPATCHER
             */
            $CURR_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = $DEFAULT_DISPATCHER;
            /**
             * If $CURR_DISPATCHER does not exist
             */
            if ( !class_exists( $CURR_DISPATCHER ) ):
                echo "Project: <b>" . bc::registry()->PROJECT_PACKAGE . "</b> has not found the Index Dispatcher: <b>" . $CURR_DISPATCHER . "</b>"; //call debug here
                exit;
            endif;
            /**
             * Run Project with $CURR_DISPATCHER
             */
            self::runProject( $CURR_DISPATCHER );
            return;
        endif;

        //validate URI TO FILE EXTENSION SETTING 
        if ( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['VALIDATE_EXTENSION'] ):
            /**
             * Set local  $CUR_URL_EXTENSION to FALSE
             */
            $CUR_URL_EXTENSION = FALSE;
            //TREAT extension if find any
            $_array = explode( '.', end( $_SEGMENTS ) );
            /**
             * If $_array length is equal 2
             */
            if ( count( $_array ) === 2 ):
                /**
                 * Set local $CUR_URL_EXTENSION with $_array removing last element of array
                 */
                $CUR_URL_EXTENSION = array_pop( $_array );
                /**
                 * Set local $var with extensions
                 */
                $var = implode( '.', $_array );
                /**
                 * Remove last element from $_SEGMENTS array
                 */
                array_pop( $_SEGMENTS );
                /**
                 * Add $var(extension) in the end of $_SEGMENTS
                 */
                array_push( $_SEGMENTS, $var );
            endif;
            /**
             * If there is $CUR_URL_EXTENSION and $CUR_URL_EXTENSION is different than Project Validate Extesion bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['VALIDATE_EXTENSION']
             */
            if ( $CUR_URL_EXTENSION && ( $CUR_URL_EXTENSION !== bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['VALIDATE_EXTENSION'] ) ):
                /*
                 * Set Error 404
                 */
                self::$E_404 = TRUE;
                /**
                 * Run project with error 404
                 */
                self::runProject( NULL );
            endif;
        endif;

        /**
         * Set local $CURR_DISPATCHER with $_SEGMENTS array traferred into a string separated with /
         */
        $CURR_DISPATCHER = implode( '/', $_SEGMENTS );
      
        /**
         * If local $CURR_DISPATCHER is NULL
         */
        if ( $CURR_DISPATCHER == NULL ):
            /**
             * Set local $CURR_DISPATCHER with $DEFAULT_DISPATCHER
             */
            $CURR_DISPATCHER = $DEFAULT_DISPATCHER;
        endif;

        //dynamic route beyond current dispatcher
        if ( !empty( bc::registry()->_DYNAMIC_ROUTE ) ):
            arsort( bc::registry()->_DYNAMIC_ROUTE );
            //Loop throughout bc::registry()->_DYNAMIC_ROUTE getting disptacher key($disp) and value $v
            foreach ( bc::registry()->_DYNAMIC_ROUTE as $disp => $permanent ):
                //If $disp is found in the beginning of the $CURR_DISPATCHER string: || if it's $DEFAULT_DISPATCHER   
                $_dispatcher_alias = !empty( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ? array_flip( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) : array();
                $DEFAULT_DISPATCHER_NAME = $DEFAULT_DISPATCHER;
                $defaultDispatcher = strtolower( $DEFAULT_DISPATCHER );
                if ( isset( $_dispatcher_alias[$defaultDispatcher] ) ):
                    $DEFAULT_DISPATCHER_NAME = self::namingConvention( $NAMING_CONVENTION, $_dispatcher_alias[$defaultDispatcher] );
                endif;
                if ( ( $DEFAULT_DISPATCHER_NAME === self::namingConvention( $NAMING_CONVENTION, $disp )) || strpos( $CURR_DISPATCHER, $disp ) === 0 ):
                    $isDefaultDispatcher = FALSE; //flag used to detect if it is $DEFAULT_DISPATCHER or $disp found in the beginning of the $CURR_DISPATCHER
                    $dynamic = ltrim( substr( $CURR_DISPATCHER, strlen( $disp ) ), '/' ); //dynamic segments without dispatcher
                    if ( $DEFAULT_DISPATCHER_NAME === self::namingConvention( $NAMING_CONVENTION, $disp ) ):
                        $isDefaultDispatcher = TRUE;
                        $dynamic = $CURR_DISPATCHER; //dynamic segments without dispatcher
                    endif;
                    if ( $permanent )://If it's permanent, evrything after it will be dynamic therefore stop in here         
                        bc::registry()->_DYNAMIC_ROUTE[$disp] = $dynamic; //Set bc::registry()->_DYNAMIC_ROUTE[$disp] with $CURR_DISPATCHER extracting $disp from string and removing all / from the left                    
                        bc::registry()->URI_NO_QS = str_replace( bc::registry()->_DYNAMIC_ROUTE[$disp], '', bc::registry()->URI_NO_QS ); //overriding  bc::registry()->URI_NO_QS
                        $CURR_DISPATCHER = $disp; //Set local $CURR_DISPATCHER with $disp key of bc::registry()->_DYNAMIC_ROUTE                        
                        break;
                    endif;
                    $_dynamic = explode( '/', $dynamic ); //explode dynamic segments                  
                    $currDispatcher = str_replace( '/', '\\', self::namingConvention( $NAMING_CONVENTION, $disp ) );  //Build current dispatcher in Class format
                    $currDispatcherPath = (!$isDefaultDispatcher ) ? 'Dispatcher\\' . $currDispatcher . '\\' : 'Dispatcher\\'; //Build dispatcher path
                    foreach ( $_dynamic as $segment )://loop $_dynamic to check if $segment is a dispatcher or not
                        $dipatcher = $currDispatcherPath . self::namingConvention( $NAMING_CONVENTION, $segment ); //Build $CURR_DISPATCHER full path including segment
                        $defaultDispatcher = 'Dispatcher\\' . $DEFAULT_DISPATCHER . '\\' . self::namingConvention( $NAMING_CONVENTION, $segment ); //Build $DEFAULT_DISPATCHER full path including segment                        
                        $s = trim( str_replace( $dynamic, '', $CURR_DISPATCHER ), '/' );
                        $alias = !empty( $s ) ? $s . '/' . $segment : $segment;
                        if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$alias] ) ):
                            $class = self::namingConvention( $NAMING_CONVENTION, bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$alias] );
                            $dipatcher = $defaultDispatcher = 'Dispatcher\\' . str_replace( '/', '\\', self::namingConvention( $NAMING_CONVENTION, $class ) );
                        endif;
                        $dipatcher = trim( $dipatcher, '\\' ); //remove backslash from dispatcher 
                        if ( class_exists( $dipatcher ) || $isDefaultDispatcher && class_exists( $defaultDispatcher ) || class_exists( self::$custom_dispatcher_path . $dipatcher ) )://if $CURR_DISPATCHER, $defaultDispatcher and self::$custom_dispatcher_path . $dipatcher class exist stops here                                                      
                            break;
                        endif;
                        bc::registry()->_DYNAMIC_ROUTE[$disp] = $dynamic; //Set bc::registry()->_DYNAMIC_ROUTE[$disp] with $CURR_DISPATCHER extracting $disp from string and removing all / from the left                    
                        bc::registry()->URI_NO_QS = str_replace( bc::registry()->_DYNAMIC_ROUTE[$disp], '', bc::registry()->URI_NO_QS );   //overriding  bc::registry()->URI_NO_QS                  
                        $CURR_DISPATCHER = $disp; //Set local $CURR_DISPATCHER with $disp key of bc::registry()->_DYNAMIC_ROUTE                        
                    endforeach;

                endif;
            endforeach;
        endif;
       
        //VERIFY DISPATCHER URI ALIASES 
        if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ):
            //get only first segment of uri, to check if $CURR_DISPATCHER has more than one segment and only the first one is an alias
            $first_dispatcher = key( array_flip( $_SEGMENTS ) );
            //VERIFY DISPATCHER URI ALIASES $CURR_DISPATCHER                       
            if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER] ) ):
                /**
                 * Set bc::registry()->DISPATCHER_ALIAS with $CURR_DISPATCHER
                 */
                bc::registry()->DISPATCHER_ALIAS = $CURR_DISPATCHER;
                /**
                 * Set local $CURR_DISPATCHER with bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER]
                 */
                $CURR_DISPATCHER = bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER];
            elseif ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$first_dispatcher] ) ):

                //check if only first segment of uri is an alias, it's neccessary if $CURR_DISPATCHER has more than one segment and only the first one is an alias
                /**
                 * Set curr dispatcher alias
                 */
                bc::registry()->DISPATCHER_ALIAS = $first_dispatcher;
                /**
                 * Get original dispatcher name
                 */
                $dispatcher = bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$first_dispatcher];
                /**
                 * Flip segment to get dispatcher alias name as key
                 */
                $_array = array_flip( $_SEGMENTS );
                /**
                 * Check if it is first segment inside $_SEGMENTS
                 */
                if ( $first_dispatcher == key( $_array ) ):
                    /**
                     * Remove dispatcher alias name from url
                     */
                    unset( $_array[$first_dispatcher] );
                    /**
                     * Flip array back to build dispatcher
                     */
                    $_array = array_flip( $_array );
                    /**
                     * Prepend original dispatcher name in url
                     */
                    array_unshift( $_array, $dispatcher );
                    /**
                     * Set $CURR_DISPATCHER with original dispatcher plus  all its following  segments
                     */
                    $CURR_DISPATCHER = implode( '/', $_array );
                endif;
            else:
                // DISPATCHER URI ALIASES $CURR_DISPATCHER IS NOT SET
                /**
                 * Set local $_alias with bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] values
                 */
                $_alias = array_flip( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] );

                /**
                 * Include dynamic segment if it is differrent than the firt and it's not included on the url
                 */
                $dynamicSegment = (bc::registry()->DYNAMIC_SEGMENT_KEY !== key( bc::registry()->_DYNAMIC_SEGMENT )) ? bc::registry()->DYNAMIC_SEGMENT_KEY . '/' : '';

                /**
                 * If $CURR_DISPATCHER exists in $_alias
                 */
                if ( array_key_exists( $CURR_DISPATCHER, $_alias ) ):
                    /**
                     * Set bc::registry()->DISPATCHER_ALIAS with $CURR_DISPATCHER
                     */
                    bc::registry()->DISPATCHER_ALIAS = $CURR_DISPATCHER;
                    /**
                     * Set local $projectAlias with bc::registry()->PROJECT_ALIAS if (bc::registry()->PROJECT_ALIAS is different than  bc::registry()->DEFAULT_PROJECT_ALIAS) else set it to NULL
                     */
                    $projectAlias = (bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS) ? bc::registry()->PROJECT_ALIAS . '/' : NULL;
                    /**
                     * Redirect to $projectAlias adding $_alias[$CURR_DISPATCHER] of current dispatcher
                     */
                    bc::request()->redirect( '/' . $projectAlias . $dynamicSegment . $_alias[$CURR_DISPATCHER], 301 );
                elseif ( array_key_exists( $first_dispatcher, $_alias ) ):
                    //Check if original dispatcher is an alias, it's neccessary if $CURR_DISPATCHER has more than one segment and only the first one is an alias
                    /**
                     * Set dispatcher alaias
                     */
                    $dispatcher_alias = $_alias[$first_dispatcher];
                    bc::registry()->DISPATCHER_ALIAS = $dispatcher_alias;

                    /**
                     * Set local $projectAlias with bc::registry()->PROJECT_ALIAS if (bc::registry()->PROJECT_ALIAS is different than  bc::registry()->DEFAULT_PROJECT_ALIAS) else set it to NULL
                     */
                    $projectAlias = (bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS) ? bc::registry()->PROJECT_ALIAS . '/' : NULL;
                    /**
                     * Flip segment to get original dispatcher name as key
                     */
                    $_array = array_flip( $_SEGMENTS );
                    /**
                     * Check if it is first segment inside $_SEGMENTS
                     */
                    if ( $first_dispatcher == key( $_array ) ):
                        /**
                         * Remove original dispatcher from url
                         */
                        unset( $_array[$first_dispatcher] );
                        /**
                         * Flip array back to build $dispatcher_alias url
                         */
                        $_array = array_flip( $_array );
                        /**
                         * Prepend dispatcher alias name in url
                         */
                        array_unshift( $_array, $dispatcher_alias );
                        /**
                         * Set $dispatcher_alias with dispatcher alias plus all its following segments
                         */
                        $dispatcher_alias = implode( '/', $_array );
                        /**
                         * Redirect to $projectAlias adding $dispatcher_alias of current dispatcher and  its following segments
                         */
                        bc::request()->redirect( '/' . $projectAlias . $dynamicSegment . $dispatcher_alias, 301 );
                    endif;
                endif;
                /**
                 * Uset $_alias
                 */
                unset( $_alias );
            endif;
        endif;
        
        /**
         * Set bc::registry()->DISPATCHER_URI with $CURR_DISPATCHER
         */
        bc::registry()->DISPATCHER_URI = $CURR_DISPATCHER;

        //NAMING CONVENTION
        /**
         * If There is $NAMING_CONVENTION default always 0 UpperCamelCase
         */
        $CURR_DISPATCHER = self::namingConvention( $NAMING_CONVENTION, $CURR_DISPATCHER );

        /**
         * Set $CURR_DEFAULT_DISPATCHER with $DEFAULT_DISPATCHER plus $CURR_DISPATCHER
         * It's only used if $CURR_DISPATCHER DOES NOT EXIST
         */
        $curr_disp = str_replace( '/', '\\', $CURR_DISPATCHER );
        $CURR_DEFAULT_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = (($curr_disp !== $DEFAULT_DISPATCHER) ? $DEFAULT_DISPATCHER : '') . '\\' . str_replace( '/', '\\', $CURR_DISPATCHER );

        /**
         * Set $CURR_DISPATCHER with 'Dispatcher\\' plus bc::registry()->DISPATCHER_NS
         * bc::registry()->DISPATCHER_NS value is setted with $CURR_DISPATCHER replacing forward slash with back slash
         */
        $CURR_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = str_replace( '/', '\\', $CURR_DISPATCHER );        
        /**
         * If $CURR_DISPATCHER DOES NOT EXIST
         */
        if ( !class_exists( $CURR_DISPATCHER ) ):
            /**
             * If $CURR_DISPATCHER DOES NOT EXIST try to see if DOES EXIST into $CURR_DEFAULT_DISPATCHER
             */
            if ( class_exists( $CURR_DEFAULT_DISPATCHER ) ):
                self::runProject( $CURR_DEFAULT_DISPATCHER );
                return;
            elseif ( class_exists( self::$custom_dispatcher_path . $CURR_DISPATCHER ) ):
                //If $CURR_DISPATCHER DOES NOT EXIST try to find if EXISTS into $CURR_DEFAULT_DISPATCHER
                //If $CURR_DEFAULT_DISPATCHER DOES NOT EXIT try self::$custom_dispatcher_path . $CURR_DISPATCHER
                //from BriskCoder\Priv\Ams 
                self::runProject( self::$custom_dispatcher_path . $CURR_DISPATCHER );
                return;
            endif;
            /**
             * Set Error 404
             */
            self::$E_404 = TRUE;
            /**
             * Run project with error 404
             */
            self::runProject( NULL );
            return;
        endif;
        /**
         *  If $CURR_DISPATCHER DOES EXIST run Project with $CURR_DISPATCHER
         */
        self::runProject( $CURR_DISPATCHER );
    }

    private static function run_GlobalConstructor()
    {
        if ( (object) self::$_Global === self::$_Global ):
            if ( method_exists( self::$_Global, 'constructor' ) ):
                self::$_Global->constructor();
            endif;
        endif;
    }

    private static function run_GlobalDestructor()
    {
        if ( (object) self::$_Global === self::$_Global ):
            if ( method_exists( self::$_Global, 'destructor' ) ):
                self::$_Global->destructor();
            endif;
        endif;
    }

    private static function runProject( $CURR_DISPATCHER )
    {


        if ( self::$E_403 ):
            //Forbidden access The Dispacther Class has been locked by BC.
            bc::debugger()->CODE = 0;
            bc::debugger()->invoke();
        //TODO the bellow will be run on production MODE classes.
        //TODO TODO TODO
        /*
          header('HTTP/1.1 403 Forbidden');
          $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom403';
          if ( class_exists($CUR_DISPATCHER) ):
          $CUR_DISPATCHER = new $CUR_DISPATCHER();
          $CUR_DISPATCHER->dispatch();
          else:
          //BriskCoder/Pub/BC wont be remote and must resides in the root of every logic server
          require_once  'BriskCoder/Pub/Media/Template/Errors/403.shtml';
          //echo file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/BriskCoder/Pub/Media/Template/Errors/403.shtml');
          endif;
         * */
        endif;

        if ( self::$E_404 ):
            //404 prints 
            bc::debugger()->CODE = 1; //TODO create proper debugger code here Inform that Template is missing or a request to a non existing file such includes are missing path or files
            bc::debugger()->_PROBLEM[] = $_SERVER['REQUEST_URI'];
            bc::debugger()->_SOLUTION[] = $_SERVER['REQUEST_URI'];
            bc::debugger()->invoke();
            return;

        //TODO the bellow will be run on production MODE classes.
        //TODO TODO TODO

        /*
          $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom404';
          if ( class_exists($CUR_DISPATCHER)  ):
          $CUR_DISPATCHER = new $CUR_DISPATCHER();
          $CUR_DISPATCHER->dispatch();
          else:
          //BriskCoder/Pub/BC wont be remote and must resides in the root of every logic server
          require_once  'BriskCoder/Pub/Media/Template/Errors/404.shtml';
          //echo file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/BriskCoder/Pub/Media/Template/Errors/404.shtml');
          endif;
         */
        endif;

        // EXEC APPLICATION
        ob_start();
        $CURR_DISPATCHER = new $CURR_DISPATCHER();
        $CURR_DISPATCHER->dispatch();

        //RUNS _GLOBAL Destructor
        self::run_GlobalDestructor();
        return;
    }

    private static function namingConvention( $NAMING_CONVENTION, $STRING )
    {
        switch ( $NAMING_CONVENTION ):
            case 0://UpperCamelCase             
                $STRING = str_replace( '/', ' ', $STRING ); // split / to spaces and make all lower              
                $STRING = ucwords( $STRING ); //convert uc first               
                $STRING = str_replace( ' ', '/', $STRING ); // put / back
                $STRING = str_replace( '-', ' ', $STRING ); //replace - with space
                $STRING = ucwords( $STRING ); //convert uc first(uppercase first character of each word )               
                $STRING = str_replace( ' ', '', $STRING ); //remove spaces                
                break;
            case 1://lowerCamelCase
                $STRING = str_replace( '-', ' ', $STRING ); //replace - with space
                $STRING = ucwords( $STRING ); //convert uc first(uppercase first character of each word )
                $STRING = lcfirst( str_replace( ' ', '', $STRING ) ); //remove spaces and make a string's first character lowercase
                break;
            case 2://lower_userscore_case
                $STRING = str_replace( '-', '_', $STRING ); //replace - with _
                break;
            case 3://Ucfirst_Underscore_Case
                $STRING = str_replace( '/', ' ', $STRING ); // split / to spaces and make all lower
                $STRING = ucwords( $STRING ); //convert uc first
                $STRING = str_replace( ' ', '/', $STRING ); // put / back
                $STRING = str_replace( '-', ' ', $STRING ); //replace - with space
                $STRING = ucwords( $STRING ); //convert uc first(uppercase first character of each word )
                $STRING = str_replace( ' ', '_', $STRING ); //convert spaces into _
                break;
            case 4: //UPPER_UNDERSCORE_CASE;
                $STRING = strtoupper( str_replace( '-', '_', $STRING ) ); //convert - into _ and make string uppercase
                break;
        endswitch;
        return $STRING;
    }

}
