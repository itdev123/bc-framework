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

namespace BriskCoder\Package\Component;

use BriskCoder\bc,
    BriskCoder\Package\Component\bcFormControl\Types,
    BriskCoder\Package\Component\bcFormControl\UiWizard;

final class bcFormControl
{

    const
            TYPE_ALPHANUMERIC = 'TYPE_ALPHANUMERIC',
            TYPE_DECIMAL = 'TYPE_DECIMAL',
            TYPE_HEXDECIMAL = 'TYPE_HEXDECIMAL',
            TYPE_NUMERIC = 'TYPE_NUMERIC',
            TYPE_OCTAL = 'TYPE_OCTAL',
            TYPE_STRING = 'TYPE_STRING';

    public static
    /**
     * @var Boolean If TRUE it binds form elements for request submission
     */
            $BIND = FALSE, // ??
            $TEMPLATE = 'default';

    /** ??????
     * MESSAGE TO BE DISPLAYED WHEN REQUIRED FIELD IS LEFT EMPTY
     * VALID FOR ALL NAMESPACES
     * It may be a simple text or an html element, including image
     */
    /* $REQUIRED_FAIL_MESSAGE = NULL; */
    private static
            $_ns = array(),
            $currNS = NULL,
            $template_path = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
                    'Component' . DIRECTORY_SEPARATOR . 'bcFormControl' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR;

    /**
     * Use Namespace
     * @param string $NAMESPACE
     */
    public static function useNamespace( $NAMESPACE )
    {
        self::$currNS = $NAMESPACE;
        //namespace exists?
        if ( !isset( self::$_ns[self::$currNS] ) ):
            self::$_ns[self::$currNS]['NAMESPACE'] = self::$currNS;
            self::$_ns[self::$currNS]['TEMPLATE'] = self::$TEMPLATE;
            self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'] = self::$template_path . self::$TEMPLATE . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.css';
            self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'] = self::$template_path . self::$TEMPLATE . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.js';
            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'], 'css' );
            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'], 'js' );
        endif;
    }

    /**
     * Get Current Namespace settings
     * @return array
     */
    public static function getSettings()
    {
        return self::$_ns[self::$currNS];
    }

// ????
//    /** ????
//     * SET RESPONSE DATA ON SERVER VALIDATION FAIL
//     * @param String $NAMESPACE JS uses data-ns- to set data 
//     * @param Array $_VALUES array('attr_name' => 'value')
//     * @param Array $_MESSAGES $_MESSAGES['attr_name'] = array( 'text|markup', 'css_class_to_append'))
//     */
//    public static function responseData( $NAMESPACE, $_VALUES, $_MESSAGES )
//    {
//
//        //this will be sent as JS array for the Plugin function that receices response during
//        //document ready so it can print all values, messages for all fields present in namespace
//    }

    /**
     * Types
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\Types
     */
    public static function types()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Types( __CLASS__ );
    }

    /**
     * Ui Wizard
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\UiWizard
     */
    public static function uiWizard()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new UiWizard( __CLASS__ );
    }

}
