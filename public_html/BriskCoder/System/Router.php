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

        bc::registry()->URI_SEGMENT = strtolower( ltrim( rtrim( bc::registry()->URI_NO_QS, '/' ), '/' ) );
        $_SUBDOMAIN = explode( '.', bc::registry()->DOMAIN_FQDN );
        $_SEGMENTS = array_filter( explode( '/', bc::registry()->URI_SEGMENT ) );
        $_REDIR = FALSE;
        $_array = array_intersect_key( array_flip( $_SUBDOMAIN ), bc::registry()->_PROJECTS );
        bc::registry()->DEFAULT_PROJECT_ALIAS = key( bc::registry()->_PROJECTS );
        bc::registry()->DEFAULT_PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['PACKAGE_NAME'];

        if ( $_array ):
            reset( $_array );
            bc::registry()->PROJECT_ALIAS = key( $_array );
            bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
        endif;

        if ( $_SEGMENTS ):
            $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_PROJECTS );
            $_dispatcher_array = array();
            foreach ( $_SEGMENTS as $segment ):
                $segment = self::namingConvention( bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['NAMING_CONVENTION'], $segment );
                if ( $segment !== bc::registry()->_PROJECTS[bc::registry()->DEFAULT_PROJECT_ALIAS]['DEFAULT_DISPATCHER'] ):
                    continue;
                endif;
                $_dispatcher_array = array_flip( $_SEGMENTS );
            endforeach;
            if ( $_array ):
                reset( $_array );
                $key = key( $_array );
                if ( bc::registry()->PROJECT_ALIAS ):
                    if ( bc::registry()->PROJECT_ALIAS === $key ):
                        unset( $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] );
                        $_REDIR = $_SEGMENTS;
                    endif;
                else:
                    bc::registry()->PROJECT_ALIAS = $key;
                    bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
                    unset( $_SEGMENTS[$_array[bc::registry()->PROJECT_ALIAS]] );
                    if ( $key === bc::registry()->DEFAULT_PROJECT_ALIAS ):
                        $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : array( '/' => '' );
                    endif;
                endif;
            elseif ( $_dispatcher_array ):
                reset( $_dispatcher_array );
                $key = key( $_dispatcher_array );
                bc::registry()->PROJECT_ALIAS = bc::registry()->DEFAULT_PROJECT_ALIAS;
                bc::registry()->PROJECT_PACKAGE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['PACKAGE_NAME'];
                if ( self::namingConvention( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['NAMING_CONVENTION'], $key ) === bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER'] ):
                    unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                    $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : array( '/' => '' );
                endif;
            endif;
        endif;

        if ( !bc::registry()->PROJECT_ALIAS ):
            bc::registry()->PROJECT_ALIAS = bc::registry()->DEFAULT_PROJECT_ALIAS;
            bc::registry()->PROJECT_PACKAGE = bc::registry()->DEFAULT_PROJECT_PACKAGE;
        endif;

        bc::registry()->MEDIA_PATH_SYSTEM = BC_PUBLIC_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Media' . DIRECTORY_SEPARATOR;
        bc::registry()->MEDIA_PATH_URI = '/' . bc::registry()->PROJECT_PACKAGE . '/Media/';
        $NAMING_CONVENTION = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['NAMING_CONVENTION'];
        $DEFAULT_DISPATCHER = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['DEFAULT_DISPATCHER'];
        bc::registry()->EXTERNAL_TEMPLATE = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['EXTERNAL_TEMPLATE'];
        bc::registry()->_REMOTE_MEDIA_TIERS = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_MEDIA_TIERS'];
        bc::registry()->_DYNAMIC_SEGMENT = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DYNAMIC_SEGMENT'];
        bc::registry()->_DISPATCHER_ALIAS = bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['_DISPATCHER_ALIAS'];
        bc::registry()->HAS_DYNAMIC_SEGMENT = FALSE;
        $dynamicSegmentFingerPrint = NULL;

        if ( ((array) bc::registry()->_DYNAMIC_SEGMENT === bc::registry()->_DYNAMIC_SEGMENT) && (!empty( bc::registry()->_DYNAMIC_SEGMENT )) ):
            bc::registry()->HAS_DYNAMIC_SEGMENT = TRUE;
            $dynamicSegmentFingerPrint = md5( json_encode( bc::registry()->_DYNAMIC_SEGMENT ) );
            $_array = array_intersect_key( array_flip( $_SUBDOMAIN ), bc::registry()->_DYNAMIC_SEGMENT );
            if ( $_array ):
                reset( $_array );
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( $_array );
                bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN = TRUE;
            else:
                reset( bc::registry()->_DYNAMIC_SEGMENT );
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
            endif;
        endif;

        if ( bc::registry()->HAS_DYNAMIC_SEGMENT && (!empty( $_SEGMENTS )) ):
            $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_DYNAMIC_SEGMENT );
            if ( $_array ):
                reset( $_array );
                $key = key( $_array );
                if ( $_array[$key] === 0 ):
                    if ( bc::registry()->DYNAMIC_SEGMENT_KEY === $key ):
                        unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                        if ( bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS ):
                            $_array = $_SEGMENTS;
                            array_unshift( $_array, bc::registry()->PROJECT_ALIAS );
                            $_REDIR = $_array; //redirect defaults
                        else:
                            // Check for dispatcher to remove from url                      
                            $_dispatcher_array = array();
                            foreach ( $_SEGMENTS as $segment ):
                                $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                if ( $segment !== $DEFAULT_DISPATCHER ):
                                    continue;
                                endif;
                                $_dispatcher_array = array_flip( $_SEGMENTS );
                            endforeach;
                            reset( $_dispatcher_array );
                            $key = key( $_dispatcher_array );
                            if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                                                
                                //Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing default dispatcher from url                       
                                unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                            endif;
                            $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : array( '/' => '' );
                        endif;
                    elseif ( !bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN ):
                        bc::registry()->DYNAMIC_SEGMENT_KEY = $key;
                        unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                        $_dispatcher_array = array();
                        foreach ( $_SEGMENTS as $segment ):
                            $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                            if ( $segment !== $DEFAULT_DISPATCHER ):
                                continue;
                            endif;
                            $_dispatcher_array = array_flip( $_SEGMENTS );
                        endforeach;
                        reset( $_dispatcher_array );
                        $key = key( $_dispatcher_array );
                        if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ):
                            unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                            $_array = $_SEGMENTS;
                            array_unshift( $_array, bc::registry()->DYNAMIC_SEGMENT_KEY );
                            $_REDIR = $_array;
                        endif;
                    endif;
                endif;
            endif;
            if ( !bc::registry()->DYNAMIC_SEGMENT_KEY ):
                reset( bc::registry()->_DYNAMIC_SEGMENT );
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
            endif;
        endif;

        bc::registry()->DISPATCHER_NS = '_Global';
        $projGlobalClass = 'Dispatcher\\' . '_Global';

        if ( class_exists( $projGlobalClass ) ):
            self::$_Global = new $projGlobalClass();
        endif;

        self::run_GlobalConstructor();

        if ( $dynamicSegmentFingerPrint !== md5( json_encode( bc::registry()->_DYNAMIC_SEGMENT ) ) ):
            if ( !empty( bc::registry()->_DYNAMIC_SEGMENT ) ):
                bc::registry()->HAS_DYNAMIC_SEGMENT = TRUE;
                reset( bc::registry()->_DISPATCHER_ALIAS );
                bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
                if ( (!empty( $_SEGMENTS ) ) ):
                    $_array = array_intersect_key( array_flip( $_SEGMENTS ), bc::registry()->_DYNAMIC_SEGMENT );
                    if ( $_array ):
                        reset( $_array );
                        $key = key( $_array );
                        if ( $_array[$key] === 0 ):
                            if ( bc::registry()->DYNAMIC_SEGMENT_KEY === $key ):
                                unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                                if ( bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS ):
                                    $_array = $_SEGMENTS;
                                    array_unshift( $_array, bc::registry()->PROJECT_ALIAS );
                                    $_REDIR = $_array;
                                else:
                                    // Check for dispatcher to remove from url                      
                                    $_dispatcher_array = array();
                                    foreach ( $_SEGMENTS as $segment ):
                                        $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                        if ( $segment !== $DEFAULT_DISPATCHER ):
                                            continue;
                                        endif;
                                        $_dispatcher_array = array_flip( $_SEGMENTS );
                                    endforeach;
                                    reset( $_dispatcher_array );
                                    $key = key( $_dispatcher_array );
                                    if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ): //Unset only if $key matches DEFAULT_DISPATCHER to make sure $key(dispatcher) is the first                                                                                                                
                                        //Unset $key(DISPATCHER) from $_SEGMENTS[$_dispatcher_array[$key]]] array, meaning removing default dispatcher from url                       
                                        unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                                    endif;
                                    $_REDIR = !empty( $_SEGMENTS ) ? $_SEGMENTS : array( '/' => '' );
                                endif;
                            elseif ( !bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN ):
                                bc::registry()->DYNAMIC_SEGMENT_KEY = $key;
                                unset( $_SEGMENTS[$_array[bc::registry()->DYNAMIC_SEGMENT_KEY]] );
                                $_dispatcher_array = array();
                                foreach ( $_SEGMENTS as $segment ):
                                    $segment = self::namingConvention( $NAMING_CONVENTION, $segment );
                                    if ( $segment !== $DEFAULT_DISPATCHER ):
                                        continue;
                                    endif;
                                    $_dispatcher_array = array_flip( $_SEGMENTS );
                                endforeach;
                                reset( $_dispatcher_array );
                                $key = key( $_dispatcher_array );
                                if ( self::namingConvention( $NAMING_CONVENTION, $key ) === $DEFAULT_DISPATCHER ):
                                    unset( $_SEGMENTS[$_dispatcher_array[$key]] );
                                    $_array = $_SEGMENTS;
                                    array_unshift( $_array, bc::registry()->DYNAMIC_SEGMENT_KEY );
                                    $_REDIR = $_array;
                                endif;
                            endif;
                        endif;
                    endif;
                    if ( !bc::registry()->DYNAMIC_SEGMENT_KEY ):
                        reset( bc::registry()->_DYNAMIC_SEGMENT );
                        bc::registry()->DYNAMIC_SEGMENT_KEY = key( bc::registry()->_DYNAMIC_SEGMENT );
                    endif;
                endif;
            endif;
        endif;

        if ( !empty( $_REDIR ) ):
            $var = implode( '/', $_REDIR );
            $var .= $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : NULL;
            bc::request()->redirect( '/' . $var, 301 );
        endif;

        if ( !bc::registry()->URI_SEGMENT || ( bc::registry()->URI_SEGMENT === bc::registry()->PROJECT_ALIAS ) || ( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['MANUAL_ROUTING'] === TRUE ) ):
            bc::registry()->DISPATCHER_URI = strtolower( $DEFAULT_DISPATCHER );
            $CURR_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = $DEFAULT_DISPATCHER;
            if ( !class_exists( $CURR_DISPATCHER ) ):
                echo "Project: <b>" . bc::registry()->PROJECT_PACKAGE . "</b> has not found the Index Dispatcher: <b>" . $CURR_DISPATCHER . "</b>"; //call debug here
                exit;
            endif;
            self::runProject( $CURR_DISPATCHER );
            return;
        endif;

        if ( bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['VALIDATE_EXTENSION'] ):
            $CUR_URL_EXTENSION = FALSE;
            $_array = explode( '.', end( $_SEGMENTS ) );
            if ( count( $_array ) === 2 ):
                $CUR_URL_EXTENSION = array_pop( $_array );
                $var = implode( '.', $_array );
                array_pop( $_SEGMENTS );
                array_push( $_SEGMENTS, $var );
            endif;
            if ( $CUR_URL_EXTENSION && ( $CUR_URL_EXTENSION !== bc::registry()->_PROJECTS[bc::registry()->PROJECT_ALIAS]['VALIDATE_EXTENSION'] ) ):
                self::$E_404 = TRUE;
                self::runProject( NULL );
            endif;
        endif;

        $CURR_DISPATCHER = implode( '/', $_SEGMENTS );

        if ( $CURR_DISPATCHER == NULL ):
            $CURR_DISPATCHER = $DEFAULT_DISPATCHER;
        endif;

        if ( !empty( bc::registry()->_DYNAMIC_ROUTE ) ):
            arsort( bc::registry()->_DYNAMIC_ROUTE );
            foreach ( bc::registry()->_DYNAMIC_ROUTE as $disp => $v ):
                $_dispatcher_alias = !empty( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ? array_flip( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) : array();
                $DEFAULT_DISPATCHER_NAME = $DEFAULT_DISPATCHER;
                $defaultDispatcher = strtolower( $DEFAULT_DISPATCHER );
                if ( isset( $_dispatcher_alias[$defaultDispatcher] ) ):
                    $DEFAULT_DISPATCHER_NAME = self::namingConvention( $NAMING_CONVENTION, $_dispatcher_alias[$defaultDispatcher] );
                endif;
                if ( ( $DEFAULT_DISPATCHER_NAME === self::namingConvention( $NAMING_CONVENTION, $disp )) || strpos( $CURR_DISPATCHER, $disp ) === 0 ):
                    $isDefaultDispatcher = FALSE;
                    $dynamic = ltrim( substr( $CURR_DISPATCHER, strlen( $disp ) ), '/' );
                    if ( $DEFAULT_DISPATCHER_NAME === self::namingConvention( $NAMING_CONVENTION, $disp ) ):
                        $isDefaultDispatcher = TRUE;
                        $dynamic = $CURR_DISPATCHER;
                    endif;
                    if ( $permanent ):
                        bc::registry()->_DYNAMIC_ROUTE[$disp] = $dynamic;
                        bc::registry()->URI_NO_QS = str_replace( bc::registry()->_DYNAMIC_ROUTE[$disp], '', bc::registry()->URI_NO_QS );
                        $CURR_DISPATCHER = $disp;
                        break;
                    endif;
                    $_dynamic = explode( '/', $dynamic );
                    $currDispatcher = str_replace( '/', '\\', self::namingConvention( $NAMING_CONVENTION, $disp ) );
                    $currDispatcherPath = (!$isDefaultDispatcher ) ? 'Dispatcher\\' . $DEFAULT_DISPATCHER . '\\' : 'Dispatcher\\';
                    foreach ( $_dynamic as $segment ):
                        $dipatcher = $currDispatcherPath . self::namingConvention( $NAMING_CONVENTION, $segment );
                        $defaultDispatcher = 'Dispatcher\\' . $currDispatcher . '\\' . self::namingConvention( $NAMING_CONVENTION, $segment );
                        if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER] ) ):
                            $class = self::namingConvention( $NAMING_CONVENTION, bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER] );
                            $dipatcher = $defaultDispatcher = 'Dispatcher\\' . str_replace( '/', '\\', self::namingConvention( $NAMING_CONVENTION, $class ) );
                        endif;
                        $dipatcher = trim( $dipatcher, '\\' );
                        if ( class_exists( $dipatcher ) || $isDefaultDispatcher && class_exists( $defaultDispatcher ) || class_exists( self::$custom_dispatcher_path . $dipatcher ) ):
                            break;
                        endif;
                        bc::registry()->_DYNAMIC_ROUTE[$disp] = $dynamic;
                        bc::registry()->URI_NO_QS = str_replace( bc::registry()->_DYNAMIC_ROUTE[$disp], '', bc::registry()->URI_NO_QS );
                        $CURR_DISPATCHER = $disp;
                    endforeach;
                endif;
            endforeach;
        endif;

        if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ):
            $first_dispatcher = key( array_flip( $_SEGMENTS ) );
            if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER] ) ):
                bc::registry()->DISPATCHER_ALIAS = $CURR_DISPATCHER;
                $CURR_DISPATCHER = bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$CURR_DISPATCHER];
            elseif ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$first_dispatcher] ) ):
                bc::registry()->DISPATCHER_ALIAS = $first_dispatcher;
                $dispatcher = bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY][$first_dispatcher];
                $_array = array_flip( $_SEGMENTS );
                if ( $first_dispatcher == key( $_array ) ):
                    unset( $_array[$first_dispatcher] );
                    $_array = array_flip( $_array );
                    array_unshift( $_array, $dispatcher );
                    $CURR_DISPATCHER = implode( '/', $_array );
                endif;
            else:
                $_alias = array_flip( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] );
                $dynamicSegment = (bc::registry()->DYNAMIC_SEGMENT_KEY !== key( bc::registry()->_DYNAMIC_SEGMENT )) ? bc::registry()->DYNAMIC_SEGMENT_KEY . '/' : '';
                if ( array_key_exists( $CURR_DISPATCHER, $_alias ) ):
                    bc::registry()->DISPATCHER_ALIAS = $CURR_DISPATCHER;
                    $projectAlias = (bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS) ? bc::registry()->PROJECT_ALIAS . '/' : NULL;
                    bc::request()->redirect( '/' . $projectAlias . $dynamicSegment . $_alias[$CURR_DISPATCHER], 301 );
                elseif ( array_key_exists( $first_dispatcher, $_alias ) ):
                    $dispatcher_alias = $_alias[$first_dispatcher];
                    bc::registry()->DISPATCHER_ALIAS = $dispatcher_alias;
                    $projectAlias = (bc::registry()->PROJECT_ALIAS !== bc::registry()->DEFAULT_PROJECT_ALIAS) ? bc::registry()->PROJECT_ALIAS . '/' : NULL;
                    $_array = array_flip( $_SEGMENTS );
                    if ( $first_dispatcher == key( $_array ) ):
                        unset( $_array[$first_dispatcher] );
                        $_array = array_flip( $_array );
                        array_unshift( $_array, $dispatcher_alias );
                        $dispatcher_alias = implode( '/', $_array );
                        bc::request()->redirect( '/' . $projectAlias . $dynamicSegment . $dispatcher_alias, 301 );
                    endif;
                endif;
                unset( $_alias );
            endif;
        endif;

        bc::registry()->DISPATCHER_URI = $CURR_DISPATCHER;
        $CURR_DISPATCHER = self::namingConvention( $NAMING_CONVENTION, $CURR_DISPATCHER );
        $CURR_DEFAULT_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = $DEFAULT_DISPATCHER . '\\' . str_replace( '/', '\\', $CURR_DISPATCHER );
        $CURR_DISPATCHER = 'Dispatcher\\' . bc::registry()->DISPATCHER_NS = str_replace( '/', '\\', $CURR_DISPATCHER );

        if ( !class_exists( $CURR_DISPATCHER ) ):
            if ( class_exists( $CURR_DEFAULT_DISPATCHER ) ):
                self::runProject( $CURR_DEFAULT_DISPATCHER );
                return;
            elseif ( class_exists( self::$custom_dispatcher_path . $CURR_DISPATCHER ) ):
                self::runProject( self::$custom_dispatcher_path . $CURR_DISPATCHER );
                return;
            endif;
            self::$E_404 = TRUE;
            self::runProject( NULL );
            return;
        endif;

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

    private static function runProject( $CUR_DISPATCHER )
    {
        if ( self::$E_403 ):
            $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom403';
            if ( class_exists( $CUR_DISPATCHER ) ):
                $CUR_DISPATCHER = new $CUR_DISPATCHER();
                $CUR_DISPATCHER->dispatch();
                self::run_GlobalDestructor();
                return;
            else:
                bc::debugger()->CODE = 0;
                bc::debugger()->invoke();
            endif;
        endif;

        if ( self::$E_404 ):
            $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom404';
            if ( class_exists( $CUR_DISPATCHER ) ):
                $CUR_DISPATCHER = new $CUR_DISPATCHER();
                $CUR_DISPATCHER->dispatch();
                self::run_GlobalDestructor();
                return;
            else:
                bc::debugger()->CODE = 1;
                bc::debugger()->_PROBLEM[] = $_SERVER['REQUEST_URI'];
                bc::debugger()->_SOLUTION[] = $_SERVER['REQUEST_URI'];
                bc::debugger()->invoke();
                return;
            endif;
        endif;

        ob_start();
        $CUR_DISPATCHER = new $CUR_DISPATCHER();
        $CUR_DISPATCHER->dispatch();
        self::run_GlobalDestructor();
        return;
    }

    private static function namingConvention( $NAMING_CONVENTION, $STRING )
    {
        switch ( $NAMING_CONVENTION ):
            case 0:
                $STRING = str_replace( '/', ' ', $STRING );
                $STRING = ucwords( $STRING );
                $STRING = str_replace( ' ', '/', $STRING );
                $STRING = str_replace( '-', ' ', $STRING );
                $STRING = ucwords( $STRING );
                $STRING = str_replace( ' ', '', $STRING );
                break;
            case 1:
                $STRING = str_replace( '-', ' ', $STRING );
                $STRING = ucwords( $STRING );
                $STRING = lcfirst( str_replace( ' ', '', $STRING ) );
                break;
            case 2:
                $STRING = str_replace( '-', '_', $STRING );
                break;
            case 3:
                $STRING = str_replace( '/', ' ', $STRING );
                $STRING = ucwords( $STRING );
                $STRING = str_replace( ' ', '/', $STRING );
                $STRING = str_replace( '-', ' ', $STRING );
                $STRING = ucwords( $STRING );
                $STRING = str_replace( ' ', '_', $STRING );
                break;
            case 4:
                $STRING = strtoupper( str_replace( '-', '_', $STRING ) );
                break;
        endswitch;
        return $STRING;
    }

}
