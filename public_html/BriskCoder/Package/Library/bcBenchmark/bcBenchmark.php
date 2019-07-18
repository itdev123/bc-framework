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

class bcBenchmark
{

    private static
            $currNS = NULL,
            $_ns = array();

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    public static function start( $NAMESPACE = NULL )
    {
        self::$currNS = $NAMESPACE;

        if ( !self::$currNS ):
            self::$currNS = 'BC';
        endif;

        self::$_ns[self::$currNS]['END'] = 0;
        self::$_ns[self::$currNS]['START'] = microtime( TRUE );
    }

    public static function end()
    {
        self::$_ns[self::$currNS]['END'] = microtime( TRUE );
        return self::$_ns[self::$currNS]['RESULT'] = (self::$_ns[self::$currNS]['END'] - self::$_ns[self::$currNS]['START']);
    }

    /**
     * MICROTIME CONVERTION TO TIME UNITS
     * Array Keys Returned: h,m,s,ms   
     * @param Float $MICROTIME
     * @return Array 
     */
    public static function timeUnit( $MICROTIME )
    {
        $_p = explode( '.', round( $MICROTIME, 4 ) );
        $millisenconds = '000';

        $aSec = 0;
        if ( isset( $_p[1] ) ):
            if ( ( ($_p[1] > 1 ) && ($_p[1] < 9991) ) ):
                $millisenconds = (int) (strlen( $_p[1] ) > 3 ) ? substr( $_p[1], 0, -1 ) : $_p[1]; //;
            else:
                $aSec = 1;
            endif;
        endif;

        $val = (int) $_p[0];
        $hours = (int) ($val / 60 / 60);
        $minutes = (int) ($val / 60) - $hours * 60;
        $seconds = (int) ($val - $hours * 60 * 60) - ($minutes * 60) + $aSec;

        $_r['h'] = $hours;
        $_r['m'] = $minutes;
        $_r['s'] = $seconds;
        $_r['ms'] = $millisenconds;

        return $_r;
    }

    /**
     * GET DIGITAL UNIT
     * Bytes|Kilobytes|Megabytes|Gigabytes|Terabytes|Petabytes
     * @param Float $SIZE
     * @return Float 
     */
    public static function digitalUnit( $SIZE )
    {
        $unit = array( 'bytes', 'kilobytes', 'megabytes', 'gigabytes', 'terabytes', 'petabytes' );
        return @round( $SIZE / pow( 1024, ($i = floor( log( $SIZE, 1024 ) ) ) ), 2 ) . ' ' . $unit[$i];
    }

}
