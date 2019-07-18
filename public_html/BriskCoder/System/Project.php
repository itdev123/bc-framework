<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 * 
 * @category    BriskCoder
 * @package     SYSTEM
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.codebrisker.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\System;

/**
 * Class Project
 * BriskCoder Project Class
 * @category BriskCoder
 * @package System
 */
final class Project
{

    private static $init = FALSE,
            $settingsInstance;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\bc' ):
            exit( 'Debug: Forbidden System Class Usage - Class Wizard' );
        endif;
    }

    /**
     * @tutorial The first project set will be the default for the domain name. That means it won't depend on domain.com/module segment to load.
     * DO NOT use $URL_NAME that matches any part of a domain name, always try unique and friendly names
     * @param string $URL_NAME Must be lower case and use dash - as word separation if needed. Do not use same name as $PACKAGE_NAME.
     * @param string $PACKAGE_NAME  Must be UPPERCASE or CamelCase, this reflects on both project directory name and global class found at Logic/Dispatcher
     * @param string $DEFAULT DISPATCHER defines the Index / Default loaded disptacher for the application. Deafult value is Home
     * @param integer $NAMING_CONVENTION Makes BriskCoder aware of preferred naming convention to porperly translate URI dynamic segments to Dispatchers <br>
     * Types available:<br> 0 = UpperCamelCase,<br> 1 = lowerCamelCase,<br> 2 = lower_underscore_case,<br> 3 = Ucfirst_Underscore_Case,<br> 4 = UPPER_UNDERSCORE_CASE. Default is 0
     */
    public function prepare( $URL_NAME, $PACKAGE_NAME, $DEFAULT_DISPATCHER = 'Home', $NAMING_CONVENTION = 0 )
    {

        self::$settingsInstance = new Setter( __CLASS__, $URL_NAME, $PACKAGE_NAME, (!empty( $DEFAULT_DISPATCHER ) ? $DEFAULT_DISPATCHER : 'Home' ), $NAMING_CONVENTION );
    }

    /**
     * Project Setup 
     * @tutorial Must be called after prepare method
     * @return Setter
     */
    public function set()
    {
        return self::$settingsInstance;
    }

    /**
     * Project Execution
     * Must be invoked once and only after all desired projects are prepared and set.
     * @return void
     */
    public function exec()
    {
        if ( self::$init === TRUE ):
            return;
        endif;

        Router::route( __CLASS__ );
        self::$init = TRUE;
    }

}
