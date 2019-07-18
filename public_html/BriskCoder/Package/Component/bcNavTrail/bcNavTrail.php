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
    BriskCoder\Package\Library\bcHTML;

final class bcNavTrail
{

    public static
            $TEMPLATE = 'default';
    private static
            $_ns = array(),
            $currNS = NULL;

    public static function useNamespace( $NAMESPACE )
    {
        self::$currNS = $NAMESPACE;
        //namespace exists?
        if ( !isset( self::$_ns[self::$currNS] ) ):
            self::$_ns[self::$currNS]['ITEMS'] = NULL;
            self::$_ns[self::$currNS]['ATTRIBUTES'] = NULL;
            self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'] = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
                    'Component' . DIRECTORY_SEPARATOR . 'bcNavTrail' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR .
                    self::$TEMPLATE . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.css';
            self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'] = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
                    'Component' . DIRECTORY_SEPARATOR . 'bcNavTrail' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR .
                    self::$TEMPLATE . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.js';

            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'], 'css' );
            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'], 'js' );
        endif;
    }

    /**
     * SETS NAVIGATION TRAIL ATTRIBUTES
     * @param String $FRIENDLY_TITLE Text describing the attribute
     * @param String $DIVIDER Divider character symbol or image separating items
     * @param String $URL_PARAM NOTE: Always concat the query string glue before each parameter<br>
     * ie: If using $_GET = '&param=value' | SEO Friendly URLs = '/your-friendly-parameter'.
     * @return Void
     */
    public static function addAttribute( $FRIENDLY_TITLE, $DIVIDER, $URL_PARAM )
    {
        bcHTML::tag()->span( $DIVIDER, array( 'class="bcNavTrail-attr-divider"' ) );
        self::$_ns[self::$currNS]['ATTRIBUTES'] .= bcHTML::tag()->getMarkup();
        bcHTML::tag()->span( NULL, array( 'class="bcNavTrail-attr-img"' ) );
        bcHTML::tag()->span( $FRIENDLY_TITLE . bcHTML::tag()->getMarkup(), array( 'class="bcNavTrail-attr" data-url-param="' . $URL_PARAM . '"' ) );
        self::$_ns[self::$currNS]['ATTRIBUTES'] .= bcHTML::tag()->getMarkup();
    }

    /**
     * SETS NAVIGATION TRAIL ITEM
     * @param String $CONTENT Text or Image Markup describing the item
     * @param String $URL URL Path when item is clicked/tapped, set as FALSE if last item and intended to be disabled.
     * @param String $DIVIDER Divider character symbol or image separating items, Hint: set as FALSE when last and not using addAttributes;
     * @return Void
     */
    public static function addItem( $CONTENT, $URL, $DIVIDER )
    {

        if ( $DIVIDER ):
            bcHTML::tag()->a( $CONTENT, array( 'class="bcNavTrail"', 'href="' . $URL . '"' ) );
        else:
            bcHTML::tag()->span( $CONTENT, array( 'class="bcNavTrail-disabled"' ) );
        endif;
        
        if ( $DIVIDER ):
            bcHTML::tag()->span( $DIVIDER, array( 'class="bcNavTrail-divider"' ) );
        endif;

        self::$_ns[self::$currNS]['ITEMS'] .= bcHTML::tag()->getMarkup();
    }

    /**
     * GETS COMPLETE NAVIGATION TRAIL MARKUP
     * @return String Complete Navigation Trail Markup
     */
    public static function getMarkup()
    {
        return self::$_ns[self::$currNS]['ITEMS'] . self::$_ns[self::$currNS]['ATTRIBUTES'];
    }

}
