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

namespace BriskCoder\Package\Library\bcHTML;

class Head
{

    private $html = NULL,
            $_linkCSS = array(),
            $_linkCSSBuffer = array(),
            $_linkJS = array(),
            $_linkJSBuffer = array();

    private function __clone()
    {
        
    }

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcHTML' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Get Head Markup
     * @return void
     */
    public function getMarkup()
    {
        $return = $this->html;
        $this->html = NULL;
        return $return;
    }

    /**
     * Page Title
     * <title>Your Title</title>
     * @param string $TITLE Page Title
     * @return void
     */
    public function title( $TITLE )
    {
        $this->html .= '<title>' . $TITLE . '</title>' . PHP_EOL;
    }

    /**
     * Meta Name Application-Name
     * Specifies the name of the Web application that the page represents
     * <meta name="application-name" content="your content">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaApplicationName( $CONTENT )
    {
        $this->html .= '<meta name="application-name" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Name Author
     * Specifies the name of the author of the document.
     * <meta name="author" content="your content">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaAuthor( $CONTENT )
    {
        $this->html .= '<meta name="author" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Name Description
     * Specifies a description of the page. Search engines can pick up this description to show with the results of searches.
     * <meta name="description" content="your content">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaDescription( $CONTENT )
    {
        $this->html .= '<meta name="description" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Name Generator
     * Specifies one of the software packages used to generate the document (not used on hand-authored pages)
     * <meta name="generator" content="your content">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaGenerator( $CONTENT )
    {
        $this->html .= '<meta name="generator" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Name GoogleBot
     * Provides a list of search engine directives,<br>
     * consisting of special predefined terms separated by commas, that provide instructions for Google's search engine crawler.
     * noarchive|nofollow|noindex|NOODP|nosnippet
     * <meta name="googlebot" content="noindex,nofollow">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaGoogleBot( $CONTENT )
    {
        $this->html .= '<meta name="googlebot" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Name Keywords
     * Specifies a comma-separated list of keywords - relevant to the page (Informs search engines what the page is about).
     * <meta name="keywords" content="your content">
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaKeywords( $CONTENT )
    {
        $this->html .= '<meta name="keywords" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Property by Open Graph Tags
     * Allows you to specify metadata to optimize how your content appears on social media websites
     * <meta property="og:title" content="your title"> <br>
     * <meta property="og:type" content="content type"> <br>
     * <meta property="og:image" content="your image path"> <br>
     * <meta property="og:url" content="your url"> <br>
     * <meta property="og:description" content="your content description"> <br>
     * <meta property="fb:admins" content="USER_ID"> <br>
     * @param String $PROPERTY 
     * @param String $CONTENT 
     * @return void
     */
    public function metaProperty( $PROPERTY, $CONTENT )
    {
        $this->html .= '<meta property="' . $PROPERTY . '"  content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Refresh
     * Refresh document according to time as well as sending custom get to the server specified as content, ie: $content ="0; url=/?javascript=false"
     * <meta http-equiv="refresh" content="0; url=/?javascript=false" >
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaRefresh( $CONTENT )
    {
        $this->html .= '<meta http-equiv="refresh" content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Meta Viewport
     * Gives the browser instructions on how to adjust the dimensions and scaling of the page to the width of the device
     * <meta name="viewport" content="width=device-width, initial-scale=1.0"> In this example it signals to browsers that your page will adapt to all devices
     * @param string $CONTENT Meta Content
     * @return void
     */
    public function metaViewport( $CONTENT )
    {
        $this->html .= '<meta name="viewport"  content="' . $CONTENT . '">' . PHP_EOL;
    }

    /**
     * Link Canonical
     * <link rel="canonical" href="path">
     * @param string $HREF path
     * @return void
     */
    public function linkCanonical( $HREF )
    {
        $this->html .= '<link rel="canonical" href="' . $HREF . '">' . PHP_EOL;
    }

    /**
     * Link Icon
     * <link rel="icon" href="path">
     * @param string $HREF path
     * @return void
     */
    public function linkIcon( $HREF )
    {
        $this->html .= '<link rel="icon" href="' . $HREF . '"  type="image/x-icon">' . PHP_EOL;
    }

    /**
     * Link StyleSheet
     * <link rel="stylesheet" type="text/css" href="path">
     * @param string $HREF path
     * @param String $MEDIA Media Types screen|print|tv|projection| etc, Default: "screen" 
     * @return void
     */
    public function linkStyleSheet( $HREF, $MEDIA = 'screen' )
    {
        $this->html .= '<link rel="stylesheet" type="text/css" href="' . $HREF . '" media="' . $MEDIA . '">' . PHP_EOL;
    }

    /**
     * Link Javascript  
     * <script type="text/javascript" src="path"></script>
     * @param string $SRC path
     * @return void
     */
    public function linkJavascript( $SRC )
    {
        $this->html .= '<script type="text/javascript" src="' . $SRC . '"></script>' . PHP_EOL;
    }

    /**
     * Script Javascript
     * <script type="text/javascript">$JAVASCRIPT_CODE</script>
     * @param string $JAVASCRIPT_CODE 
     * @return void
     */
    public function script( $JAVASCRIPT_CODE )
    {
        $this->html .= '<script type="text/javascript">' . PHP_EOL . $JAVASCRIPT_CODE . PHP_EOL . '</script>' . PHP_EOL;
    }

    /**
     * Style
     * <style type="text/css">$CSS_CODE</style>
     * @param string $CSS_CODE 
     * @return void
     */
    public function style( $CSS_CODE )
    {
        $this->html .= '<style type="text/css">' . PHP_EOL . $CSS_CODE . PHP_EOL . '</style>' . PHP_EOL;
    }

}
