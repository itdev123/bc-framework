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
 * @author Emily
 */

namespace BriskCoder\Package\Component;

use BriskCoder\bc;

final class bcJSInc
{

    private static
            $template_path = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
            'Component' . DIRECTORY_SEPARATOR . 'bcJSInc' . DIRECTORY_SEPARATOR;

    /**
     * Add BriskCoder JS
     * Add BriskCoder.js to head includes
     */
    public static function briskCoder()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'css' . DIRECTORY_SEPARATOR . 'BriskCoder.css', 'css' );
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoder.js', 'js' );
    }

    /**
     * Add briskCoderCanvas JS
     * Add briskCoderCanvas.js to head includes
     */
    public static function briskCoderCanvas()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'briskCoderCanvas.js', 'js' );
    }

    /**
     * Add BrisCoderDataGrid JS
     * Add BrisCoderDataGrid.js to head includes
     */
    public static function briskCoderDataGrid()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderDataGrid.js', 'js' );
    }

    /**
     * Add BriskCoderDatePicker JS
     * Add BriskCoderDatePicker.js to head includes
     */
    public static function briskCoderDatePicker()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'css' . DIRECTORY_SEPARATOR . 'BriskCoderDatePicker.css', 'css' );
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderDatePicker.js', 'js' );
    }

    /**
     * Add BriskCoderDialog JS
     * Add BriskCoderDialog.js to head includes
     */
    public static function briskCoderDialog()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'css' . DIRECTORY_SEPARATOR . 'BriskCoderDialog.css', 'css' );
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderDialog.js', 'js' );
    }

    /**
     * Add BrisCoderEffects JS
     * Add BrisCoderEffects.js to head includes
     */
    public static function briskCoderEffects()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderEffects.js', 'js' );
    }

    /**
     * Add BriskCoder JS
     * Add BriskCoder.js to head includes
     */
    public static function briskCoderFormControl()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderFormControl.js', 'js' );
    }

    /**
     * Add BrisCoderIO JS
     * Add BrisCoderIO.js to head includes
     */
    public static function briskCoderIO()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderIO.js', 'js' );
    }

    /**
     * Add BrisCoderLayout JS
     * Add BrisCoderLayout.js to head includes
     */
    public static function briskCoderLayout()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderLayout.js', 'js' );
    }

    /**
     * Add BriskCoderTabs JS
     * Add BriskCoderTabs.js to head includes
     */
    public static function briskCoderTabs()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'css' . DIRECTORY_SEPARATOR . 'BriskCoderTabs.css', 'css' );
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderTabs.js', 'js' );
    }

    /**
     * Add BriskCoderUploader JS
     * Add BriskCoderUploader.js to head includes
     */
    public static function briskCoderUploader()
    {
        bc::publisher()->addHeadIncludes( self::$template_path . 'css' . DIRECTORY_SEPARATOR . 'BriskCoderUploader.css', 'css' );
        bc::publisher()->addHeadIncludes( self::$template_path . 'js' . DIRECTORY_SEPARATOR . 'BriskCoderUploader.js', 'js' );
    }

}
