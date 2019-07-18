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

final class bcNavPager
{

    public static
            $TEMPLATE = 'default',
            /**
             * @var Integer $PAGE Current Page Index
             */
            $PAGE = 1,
            /**
             * @var Integer $PAGE_SIZE Total records per page<br>
             * NOTE: If using with bcNavPager::getPageSizeSelector feature, always assure that bcNavPager::$PAGE_SIZE is set with the current
             * {limit} value from URL. ie: on page loads, validate your {limit} query string parameter and set value here: bcNavPager::$PAGE_SIZE = $_GET['limit'];
             */
            $PAGE_SIZE = 6,
            /**
             * @var Integer $TOTAL_RECORDS Total data records
             */
            $TOTAL_RECORDS = 0,
            /**
             * Full URI path to request
             * @var String $URL Always wrap the {page} word for the page parameter value,<br>
             * ie: GET = page_param={page}| SEO URL = page-param-{page}
             */
            $URL;
    private static
            $_ns = array(),
            $currNS = NULL;

    public static function useNamespace( $NAMESPACE )
    {
        self::$currNS = $NAMESPACE;
        //namespace exists?
        if ( !isset( self::$_ns[self::$currNS] ) ):
            self::$_ns[self::$currNS]['PAGE_INDEX_RANGE'] = 5;
            self::$_ns[self::$currNS]['FIRST_PAGE_BUTTON'] = '<<';
            self::$_ns[self::$currNS]['NEXT_PAGE_BUTTON'] = '>';
            self::$_ns[self::$currNS]['PREV_PAGE_BUTTON'] = '<';
            self::$_ns[self::$currNS]['LAST_PAGE_BUTTON'] = '>>';
            self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'] = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
                    'Component' . DIRECTORY_SEPARATOR . 'bcNavPager' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR .
                    self::$TEMPLATE . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.css';
            self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'] = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
                    'Component' . DIRECTORY_SEPARATOR . 'bcNavPager' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR .
                    self::$TEMPLATE . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . self::$TEMPLATE . '.js';

            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_CSS_PATH'], 'css' );
            bc::publisher()->addHeadIncludes( self::$_ns[self::$currNS]['TEMPLATE_JS_PATH'], 'js' );
        endif;
    }

    /**
     * SET NAVIGATION PAGER CONTROLS
     * @param Interger $PAGE_INDEX_RANGE Displays number of page indexes to navigate, min is 3, default is 5. ODD numbers $PAGE_INDEX_RANGE value including the index.
     * EVEN numbers $PAGE_INDEX_RANGE value not including the index. ie: 5 = 5 | 6 = 7
     * @param String $FIRST_PAGE_BUTTON Button symbol or image to navigate to first page, Set to FALSE to deactivate this feature || NULL to use default value. 
     * @param String $NEXT_PAGE_BUTTON Button symbol or image to navigate to next page, Set to FALSE to deactivate this feature || NULL to use default value. 
     * @param String $PREV_PAGE_BUTTON Button symbol or image to navigate to previous page, Set to FALSE to deactivate this feature || NULL to use default value. 
     * @param String $LAST_PAGE_BUTTON Button symbol or image to navigate to last page, Set to FALSE to deactivate this feature || NULL to use default value. 
     * @return Void
     */
    public static function setMainControls( $PAGE_INDEX_RANGE, $FIRST_PAGE_BUTTON, $NEXT_PAGE_BUTTON, $PREV_PAGE_BUTTON, $LAST_PAGE_BUTTON )
    {
        self::$_ns[self::$currNS]['PAGE_INDEX_RANGE'] = $PAGE_INDEX_RANGE >= 3 ? (int) $PAGE_INDEX_RANGE : self::$_ns[self::$currNS]['PAGE_INDEX_RANGE'];
        self::$_ns[self::$currNS]['FIRST_PAGE_BUTTON'] = $FIRST_PAGE_BUTTON === FALSE ? NULL : ($FIRST_PAGE_BUTTON !== NULL ? $FIRST_PAGE_BUTTON : self::$_ns[self::$currNS]['FIRST_PAGE_BUTTON']);
        self::$_ns[self::$currNS]['NEXT_PAGE_BUTTON'] = $NEXT_PAGE_BUTTON === FALSE ? NULL : ($NEXT_PAGE_BUTTON !== NULL ? $NEXT_PAGE_BUTTON : self::$_ns[self::$currNS]['NEXT_PAGE_BUTTON'] );
        self::$_ns[self::$currNS]['PREV_PAGE_BUTTON'] = $PREV_PAGE_BUTTON === FALSE ? NULL : ($PREV_PAGE_BUTTON !== NULL ? $PREV_PAGE_BUTTON : self::$_ns[self::$currNS]['PREV_PAGE_BUTTON']);
        self::$_ns[self::$currNS]['LAST_PAGE_BUTTON'] = $LAST_PAGE_BUTTON === FALSE ? NULL : ($LAST_PAGE_BUTTON !== NULL ? $LAST_PAGE_BUTTON : self::$_ns[self::$currNS]['LAST_PAGE_BUTTON']);
    }

    /**
     * GET PAGE SELECTOR MARKUP
     * @param String $URL Always wrap the {page} word for the page parameter value,<br>
     * ie: GET = page_param={page}| SEO URL = page-param-{page}
     * @param String $LABEL Text describing page selector feature
     * @param String $BUTTON_VALUE Text|Image for the action button
     * @return String 
     */
    public static function getPageSelector( $URL, $LABEL, $BUTTON_VALUE )
    {
        $total_pages = ceil( self::$TOTAL_RECORDS / self::$PAGE_SIZE );
        if ( $LABEL ):
            bcHTML::form()->label( 'bcNavPager-page-selector', $LABEL, array( 'class="bcNavPager-page-selector-label"' ) );
        endif;

        bcHTML::form()->text( array( 'name="bcNavPager-page-selector"', 'value="' . self::$PAGE . '"', 'class="bcNavPager-page-selector"', 'data-bcNavPager-page-selector-url="' . $URL . '"', 'data-bcNavPager-total-pages=' . $total_pages ) );
        bcHTML::form()->button( $BUTTON_VALUE, array( 'value="button"', 'class="bcNavPager-page-selector-btn"' ) );
        return bcHTML::form()->getMarkup();
    }

    /**
     * GET PAGE SIZE CONTROL MARKUP.
     * @param Array $_LIMITS Array containing limit numbers as value, Default is array( 5,10,25,50 ) when empty array() is passed; 
     * @param String $URL Always wrap the {limit} word for the page parameter value,<br>
     * ie: GET = limit_param={limit}| SEO URL = limit-param-{limit}
     * @param String $LABEL Text describing page size selector feature
     * @param Boolean $TYPE_SELECT If TRUE then a form select with options is returned, otherwise custom UI markup is returned
     * @return String 
     */
    public static function getPageSizeSelector( $_LIMITS, $URL, $LABEL, $TYPE_SELECT )
    {
        if ( empty( $_LIMITS ) ):
            $_LIMITS = array( 5 => 5, 10 => 10, 25 => 25, 50 => 50 );
        else:
            $_data = array();
            foreach ( $_LIMITS as $v ):
                $_data[$v] = $v;
            endforeach;
            $_LIMITS = $_data;
            unset( $_data );
        endif;
        $key = array_search( self::$PAGE_SIZE, $_LIMITS );
        if ( $TYPE_SELECT ):
            if ( $LABEL ):
                bcHTML::form()->label( 'bcNavPager-page-size-selector', $LABEL, array( 'class="bcNavPager-page-size-selector-label"' ) );
            endif;
            $_option_attributes = $key ? array( $key => array( 'selected="selected"' ) ) : array();
            bcHTML::form()->select( $_LIMITS, array( 'name="bcNavPager-page-size-selector"', 'class="bcNavPager-page-size-selector"', 'data-bcNavPager-page-size-selector-url="' . $URL . '"' ), $_option_attributes );
            return bcHTML::form()->getMarkup();
        endif;

        //custom markup
        if ( $LABEL ):
            bcHTML::tag()->span( $LABEL, array( 'class="bcNavPager-page-size-selector-label"' ) );
        endif;

        bcHTML::tag()->div( self::$PAGE_SIZE, array( 'class="bcNavPager-page-size-selector"', 'data-bcNavPager-page-size-selector-url="' . $URL . '"' ) );
        $_li_attributes = $key ? array( $key => array( 'class="bcNavPager-page-size-selector-list-selected"' ) ) : array();
        bcHTML::tag()->ul( $_LIMITS, array( 'class="bcNavPager-page-size-selector-list"' ), $_li_attributes );
        bcHTML::tag()->div( bcHTML::tag()->getMarkup(), array( 'class="bcNavPager-page-size-wrapper"' ) );
        return bcHTML::tag()->getMarkup();
    }

    /**
     * GET RECORDS INFORMATION MARKUP
     * {Showing} 1 {to} 10 {of} 200 {records} 10 {pages}
     * @param String $TEXT_DISPLAY ie:
     * @param String $TEXT_TO
     * @param String $TEXT_OF
     * @param String $TEXT_RECORDS
     * @param String $TEXT_PAGES
     * @return String
     */
    public static function getRecordsInfo( $TEXT_DISPLAY, $TEXT_TO, $TEXT_OF, $TEXT_RECORDS, $TEXT_PAGES )
    {
        if ( $TEXT_DISPLAY ):
            bcHTML::tag()->span( $TEXT_DISPLAY, array( 'class="bcNavPager-records-info-text-display"' ) );
        endif;

        bcHTML::tag()->span( self::$TOTAL_RECORDS ? ((self::$PAGE - 1) * self::$PAGE_SIZE) + 1 : 0, array( 'class="bcNavPager-records-info-start"' ) );

        if ( $TEXT_TO ):
            bcHTML::tag()->span( $TEXT_TO, array( 'class="bcNavPager-records-info-text-to"' ) );
        endif;

        bcHTML::tag()->span( ((self::$PAGE - 1) * self::$PAGE_SIZE) > (self::$TOTAL_RECORDS - self::$PAGE_SIZE) ? self::$TOTAL_RECORDS : ((self::$PAGE - 1) * self::$PAGE_SIZE) + self::$PAGE_SIZE, array( 'class="bcNavPager-records-info-end"' ) );

        if ( $TEXT_OF ):
            bcHTML::tag()->span( $TEXT_OF, array( 'class="bcNavPager-records-info-text-of"' ) );
        endif;

        bcHTML::tag()->span( self::$TOTAL_RECORDS, array( 'class="bcNavPager-records-info-total"' ) );

        if ( $TEXT_RECORDS ):
            bcHTML::tag()->span( $TEXT_RECORDS, array( 'class="bcNavPager-records-info-text-records"' ) );
        endif;

        bcHTML::tag()->span( ceil( self::$TOTAL_RECORDS / self::$PAGE_SIZE ), array( 'class="bcNavPager-records-info-pages"' ) );

        if ( $TEXT_PAGES ):
            bcHTML::tag()->span( $TEXT_PAGES, array( 'class="bcNavPager-records-info-text-pages"' ) );
        endif;

        bcHTML::tag()->div( bcHTML::tag()->getMarkup(), array( 'class="bcNavPager-records-info-wrapper"' ) );
        return bcHTML::tag()->getMarkup();
    }

    /**
     * GET NAVIGATION PAGER MARKUP
     * @return String
     */
    public static function getMarkup()
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            //TODO create debugger file 
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;

        $markUp = NULL;

        //first and previous pages
        if ( self::$PAGE > 1 ) :
            //first page
            if ( self::$_ns[self::$currNS]['FIRST_PAGE_BUTTON'] ):
                bcHTML::tag()->span( self::$_ns[self::$currNS]['FIRST_PAGE_BUTTON'], array( 'class="bcNavPager-btn-first"' ) );
                bcHTML::tag()->a( bcHTML::tag()->getMarkup(), array( 'href="' . str_replace( '{page}', 1, self::$URL ) . '"', 'class="bcNavPager-btn"' ) );
                $markUp .= bcHTML::tag()->getMarkup();
            endif;
            //previous page
            if ( self::$_ns[self::$currNS]['PREV_PAGE_BUTTON'] ):
                bcHTML::tag()->span( self::$_ns[self::$currNS]['PREV_PAGE_BUTTON'], array( 'class="bcNavPager-btn-prev"' ) );
                bcHTML::tag()->a( bcHTML::tag()->getMarkup(), array( 'href="' . str_replace( '{page}', self::$PAGE - 1, self::$URL ) . '"', 'class="bcNavPager-btn"' ) );
                $markUp .= bcHTML::tag()->getMarkup();
            endif;
        endif;

        //number paging
        $total_pages = ceil( self::$TOTAL_RECORDS / self::$PAGE_SIZE );
        $factor = floor( self::$_ns[self::$currNS]['PAGE_INDEX_RANGE'] / 2 );
        $initial_num = self::$PAGE - $factor;
        $condition_limit_num = (self::$PAGE + $factor) + 1;
        //USE $n for the href later
        for ( $n = $initial_num; $n < $condition_limit_num; $n++ ):
            if ( ($n > 0) && ($n <= $total_pages) ):
                if ( (int) $n === (int) self::$PAGE ):
                    bcHTML::tag()->span( $n, array( 'class="bcNavPager-btn-current"', 'data-bcNavPager-total-pages=' . $total_pages ) );
                else:
                    bcHTML::tag()->a( $n, array( 'href="' . str_replace( '{page}', $n, self::$URL ) . '"', 'class="bcNavPager-btn"' ) );
                endif;
            endif;
        endfor;
        $markUp .= bcHTML::tag()->getMarkup();

        //next and last pages
        if ( self::$PAGE < $total_pages ):
            //next page
            if ( self::$_ns[self::$currNS]['NEXT_PAGE_BUTTON'] ):
                bcHTML::tag()->span( self::$_ns[self::$currNS]['NEXT_PAGE_BUTTON'], array( 'class="bcNavPager-btn-next"' ) );
                bcHTML::tag()->a( bcHTML::tag()->getMarkup(), array( 'href="' . str_replace( '{page}', self::$PAGE + 1, self::$URL ) . '"', 'class="bcNavPager-btn"' ) );
                $markUp .= bcHTML::tag()->getMarkup();
            endif;
            //last page
            if ( self::$_ns[self::$currNS]['LAST_PAGE_BUTTON'] ):
                bcHTML::tag()->span( self::$_ns[self::$currNS]['LAST_PAGE_BUTTON'], array( 'class="bcNavPager-btn-last"' ) );
                bcHTML::tag()->a( bcHTML::tag()->getMarkup(), array( 'href="' . str_replace( '{page}', $total_pages, self::$URL ) . '"', 'class="bcNavPager-btn"' ) );
                $markUp .= bcHTML::tag()->getMarkup();
            endif;
        endif;
        return $markUp;
    }

}
