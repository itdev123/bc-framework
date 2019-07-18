<?php

/**
 * bcAMS Module
 * Manage bcAMS Builder and Layout
 * @author Emily
 */

namespace BriskCoder\Package\Module;

use BriskCoder\Package\Module\bcAMS\Libs\Builder,
    BriskCoder\Package\Module\bcAMS\Libs\Layout,
    BriskCoder\Package\Module\bcAMS\Libs\Design;

/**
 * BC Application Management System 
 * If using bcDB, set desired connection namespace before operations.
 * Only once is necessary if not working with muliple databases.
 */
final class bcAMS
{

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * bcAMS Architecture
     * @static $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Builder
     */
    public static function builder()
    {
        static $obj;
        return $obj instanceof Builder ? $obj : $obj = new Builder( __CLASS__ );
    }

    /**
     * bcAMS Layout
     * @static $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Layout
     */
    public static function layout()
    {
        static $obj;
        return $obj instanceof Layout ? $obj : $obj = new Layout( __CLASS__ );
    }

    /**
     * bcAMS Design
     * @static $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Design
     */
    public static function design()
    {
        static $obj;
        return $obj instanceof Design ? $obj : $obj = new Design( __CLASS__ );
    }

}
