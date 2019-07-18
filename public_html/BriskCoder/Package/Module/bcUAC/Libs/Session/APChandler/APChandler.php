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

namespace BriskCoder\Package\Module\Libs\Session;

class APChandler implements \SessionHandlerInterface
{

    private $sessionName;

    public function __construct()
    {
        
    }

    public function open( $SAVE_PATH, $SESSION_NAME )
    {
        $this->sessionName = $SESSION_NAME;

        if ( !apc_exists( $this->sessionName ) ) {
            return apc_store( $this->sessionName, array( '' ) );
        }

        return TRUE;
    }

    public function close()
    {
        return TRUE;
    }

    public function read( $SID )
    {
        $key = $this->sessionName . '/' . $SID;

        return apc_exists( $key ) ? apc_fetch( $key ) : NULL;
    }

    public function write( $SID, $DATA )
    {
        $_cData = apc_fetch( $this->sessionName );
        $_cData[$SID] = $_SERVER['REQUEST_TIME'];
        return apc_store( $this->sessionName . '/' . $SID, $DATA, (int) ini_get( 'session.gc_maxlifetime' ) ) && apc_store( $this->sessionName, $_cData );
    }

    public function destroy( $SID )
    {
        $_cData = apc_fetch( $this->sessionName );
        unset( $_cData[$SID] );
        return apc_delete( $this->sessionName . '/' . $SID ) && apc_store( $this->sessionName, $_cData );
    }

    public function gc( $MAXLIFETIME )
    {
        $_cData = apc_fetch( $this->sessionName );
        foreach ( $_cData as $sid => $time ):
            if ( $time + $MAXLIFETIME < $_SERVER['REQUEST_TIME'] && apc_exists( $sid ) ):
                apc_delete( $key );
            endif;
        endforeach;
    }

}
