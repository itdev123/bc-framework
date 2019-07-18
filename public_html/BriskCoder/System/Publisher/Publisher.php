<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Presentation
 * @package     Engine
 * @subpackage  System
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.codebrisker.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\System;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcCache,
    BriskCoder\Package\Library\bcHTML;

/**
 * Publisher
 * Publisher Class
 * @category    Publisher
 * @package     Engine
 * @subpackage  System
 */
final class Publisher
{

    public

    /**
     * _PARSE 
     * <!--bc.IdentifierName-->replacement content<!--bc-->  Identifier is case sensitive
     * Notice: Replacements will be cached according to settings priority: 1st $CACHE_LIFETIME then template file modified time
     * @var array property used as bc::publisher()->_PARSE['Identifier'] = 'replacement';
     */
            $_PARSE = FALSE,
            /**
             * _PARSE_NOCACHE 
             * <!--bc.nocache.IdentifierName-->replacement content<!--bc--> It will be parsed even if cache mode is used. Useful for AJAX/DATA blocks that cannot be cached. 
             * property used as bc::publisher()->_PARSE['Identifier'] = 'replacement'
             * Tip: Since replacement is never cached, when using bc::publisher()->_PARSE_NOCACHE at _Global level and
             * if necessary it can be overridden at Dispatcher\ level 
             * by simply using the same key identifier with a null or different value. 
             * @var array 
             */
            $_PARSE_NOCACHE = FALSE,
            /**
             * TEMPLATE Name
             * Template Package Name
             * @var string
             */
            $TEMPLATE = 'Default',
            /**
             * CACHE_LIFETIME
             * Defines the Publisher Layer Cache System max lifetime in seconds, for Template, Language and Presentation files. Default 31536000 "1 year".
             * To rewrite an existing cache just set to 0 at runtime.
             * Cache system will prioritize original source last modified time vs cached, if ok then it also checks for $CACHE_LIFETIME integer.
             * @var int 
             */
            $CACHE_LIFETIME = 31536000,
            /**
             * TEMPLATE FILE EXTENSION 
             * If you need a diferent file extension to be parsed then call bc::publisher()->FILE_EXTENSION = 'xml'
             * It can be used at dispatcher _Global levels and then overridden at requested dispatcher level
             * DO NOT use period to form the extension name string 
             * Default is 'html' 
             * @var string  
             */
            $FILE_EXTENSION = 'html',
            /**
             * Load Files From BriskCoder Pub User Directory
             * @var bool $PUBLIC_ASSET load files from /BriskCoder/Pub/User/
             */
            $USER_ASSET = FALSE,
            /**
             * VIEW STATIC property
             * if set to TRUE parses the original static template, no cache or dynamic parsing system will take effect;
             * @var bool 
             */
            $VIEW_STATIC = FALSE,
            /**
             * PARSE CSS
             * Read, Parse, Compress and Cache ALL css files added by bc::publisher()->addHeadIncludes() as well as any
             * css code found within <!--bc.css><style>...</style><!--bc--> parse markups in ONE single global master file, stored
             * at BriskCoder/Pub/Cache/View/css. Cache system runs automatically for optimal performance  
             * Default is TRUE 
             * @var bool  
             */
            $PARSE_CSS = TRUE,
            /**
             * PARSE JS
             * Read, Parse, Compress and Cache ALL js files added by bc::publisher()->addHeadIncludes() as well as any
             * js code found within <!--bc.js><script>...</script><!--bc--> parse markups in ONE single global master file, stored
             * at BriskCoder/Pub/Cache/View/js. Cache system runs automatically for optimal performance 
             * Default is TRUE 
             * @var bool  
             */
            $PARSE_JS = TRUE,
            /**
             * PARSE HYPERLINKS
             * <a href="" ...></a> Do not place parameters between <a and href, put them after  
             * Ensure that Publisher Templates hyperlinks always contains the project Package name in the href preceded by the /
             * ie"  <a href="/myProject/page">hyperlink</a> where myProject is the physical directory name for your project.                  
             * Default is TRUE 
             * @var bool  
             */
            $PARSE_HYPERLINKS = TRUE;
    private $init = FALSE,
            $cachePath,
            $langPath,
            $tplPath,
            $pageIdentifier = '',
            $_fails = FALSE,
            $view = NULL,
            $_headInc_cssPath = array(),
            $_headInc_jsPath = array(),
            $_headInc_cssScript = array(),
            $_headInc_jsScript = array();

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\bc' ):
            exit( 'Debug: Forbidden System class usage' );
        endif;

        $this->cachePath = BC_PUBLIC_ASSETS_PATH . 'Cache' . DIRECTORY_SEPARATOR;
    }

    /**
     * Custom HTTP Error 
     * @param int $ERROR Code number. Default is 404. 403 Available
     * @param Mixed $DISPATCHER_DATA Any Information Desired to executed by the Custom Error Dispatchers
     * @return Void
     */
    public function throwCustomError( $ERROR = 404, $DISPATCHER_DATA = NULL )
    {
        if ( !$this->init ):
            //TODO implement other codes other than 403 and 404 existing in the BC
            switch ( $ERROR ):
                case 401:
                    header( "HTTP/1.1 401 Unauthorized" );
                    $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom401';
                    if ( class_exists( $CUR_DISPATCHER ) ):
                        $CUR_DISPATCHER = new $CUR_DISPATCHER();
                        $CUR_DISPATCHER->dispatch( $DISPATCHER_DATA );
                    else:
                        require_once 'BriskCoder/Pub/Media/Template/Errors/401.html';
                    endif;
                    break;
                case 403:
                    header( "HTTP/1.1 403 Forbidden" );
                    $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom403';
                    if ( class_exists( $CUR_DISPATCHER ) ):
                        $CUR_DISPATCHER = new $CUR_DISPATCHER();
                        $CUR_DISPATCHER->dispatch( $DISPATCHER_DATA );
                    else:
                        require_once 'BriskCoder/Pub/Media/Template/Errors/403.html';
                    endif;
                    break;
                case 404:
                    header( "HTTP/1.1 404 Not Found" );
                    $CUR_DISPATCHER = 'Dispatcher\\' . 'Custom404';
                    if ( class_exists( $CUR_DISPATCHER ) ):
                        $CUR_DISPATCHER = new $CUR_DISPATCHER();
                        $CUR_DISPATCHER->dispatch( $DISPATCHER_DATA );
                    else:
                        require_once 'BriskCoder/Pub/Media/Template/Errors/404.html';
                    endif;
                    break;
            endswitch;
            exit();
        endif;
    }

    /**
     * Languages are automatically parsed if in the same path as the Dispatcher
     * But there are cases where AJAX is in use and logic needs to apply to a proper translation
     * Option, then this function comes handy as it will load the referred language file and return an array 
     * @param bool $FILE_NAME must be informed and must respect current template/lang-code directory structure 
     * @return array
     */
    public function loadLanguage( $FILE_NAME )
    {
        $langPath = bc::registry()->MEDIA_PATH_SYSTEM . $this->TEMPLATE . DIRECTORY_SEPARATOR .
                '_Language' . DIRECTORY_SEPARATOR .
                bc::registry()->DYNAMIC_SEGMENT_KEY . DIRECTORY_SEPARATOR .
                $FILE_NAME . '.lang';
        if ( is_file( $langPath ) ):
            return parse_ini_file( $langPath );
        endif;
        return array();
    }

    /**
     * ADD HEAD LINKS
     * Add Head Links to be parsed in the <head> section.
     * @param string $RESOURCE 
     * @param bool $PATH TRUE|FALSE If it's a path or resource code, default TRUE "path"
     */

    /**
     * ADD HTML HEAD LINKS FOR DYNAMIC INCLUSION.
     * Requires <!--bc.head--><!--bc--> in the view to place the include master links if using this feature
     * This method will automatically parse and cache all included resource types in a single master file for any js and css source included within
     * It also makes internal use of <!--bc.css--><style>your code</style><!--bc--> and <!--bc.js--><script>your code</script><!--bc-->
     * @param string $RESOURCE real absolute path to the resource file | Script Code for the CSS or Javascript according to $TYPE.
     * @param string $TYPE css|js Defines $RESOURCE type.
     * @param boll $PATH TRUE|FALSE If it's a path or resource code, default TRUE "path"
     * @return void 
     */
    public function addHeadIncludes( $RESOURCE, $TYPE, $PATH = TRUE )
    {
        switch ( TRUE ):
            case ( strtolower( $TYPE ) === 'css' ) && $PATH:
                if ( isset( $this->_headInc_cssPath[$RESOURCE] ) ):
                    return;
                endif;
                $this->_headInc_cssPath[$RESOURCE] = NULL;
                break;
            case ( strtolower( $TYPE ) === 'css' ) && !$PATH:
                $key = md5( $RESOURCE );
                if ( isset( $this->_headInc_cssScript[$key] ) ):
                    return;
                endif;
                $this->_headInc_cssScript[$key] = $RESOURCE;
                break;
            case ( strtolower( $TYPE ) === 'js' ) && $PATH:
                if ( isset( $this->_headInc_jsPath[$RESOURCE] ) ):
                    return;
                endif;
                $this->_headInc_jsPath[$RESOURCE] = NULL;
                break;
            case ( strtolower( $TYPE ) === 'js' ) && !$PATH:
                $key = md5( $RESOURCE );
                if ( isset( $this->_headInc_jsScript[$key] ) ):
                    return;
                endif;
                $this->_headInc_jsScript[$key] = $RESOURCE;
                break;
        endswitch;
    }

    /**
     * Render Engine 
     * Template Engine will automatically render from Dispatcher layer. If template namespace matches dispatcher, then there's no need to assign $CUSTOM_FILE. <br>
     * Features:<br>
     * <!--bc.head--><link rel="stylesheet"... && <script type="text/javascript"...<!--bc-->, will load and parse css and javascript included files to a single, master cache controlled file.  <br>
     * <!--bc.inc-->/path/to/your/include<!--bc-->, will load html fragments and parse any other <!--bc. markup within the included file. <br>
     * <!--bc.css--><style type="text/css">your css code</style><!--bc-->, will be parsed to the end of master cache controlled file.  <br>
     * <!--bc.js--><script type="text/javascript">your js code</script><!--bc-->, will be parsed to the end of master cache controlled file.  <br>
     * @param string $CUSTOM_FILE Set a custom file to be loaded from '/PROJECT_NAME/Media/Template/TEMPLATE_NAME/ User defined from here
     * @param bool $MAIL_TEMPLATE Defines if render engine is parsing an email template otherwise default is FALSE; 
     * @param bool $RETURN_BUFFER It returns the buffer content rather then outputting default is FALSE;
     * @return string
     */
    public function render( $CUSTOM_FILE = FALSE, $MAIL_TEMPLATE = FALSE, $RETURN_BUFFER = FALSE )
    {

        if ( error_get_last() ):
            exit;
        endif;

        if ( $this->init && $RETURN_BUFFER === FALSE ):
            return;
        endif;

        //Lock render to prevent second call if $RETURN_BUFFER is FALSE
        $this->init = TRUE;

        //clean any buffer outside Render Engine
        if ( ob_get_level() ):
            ob_end_clean();
        endif;



        if ( $CUSTOM_FILE ):
            $class = str_replace( '/', DIRECTORY_SEPARATOR, $CUSTOM_FILE );
        else:
            $_trace = debug_backtrace( 2, 2 );
            if ( (!isset( $_trace[1] ) ) || (!isset( $_trace[1]['class'] ) ) ):
                exit( 'not a dispatcher, must be a custom name' );
                //call debug here inform its not a class, custom file must be passed
                return;
            endif;
            $_x = array();
            $_x[0][] = 'Dispatcher\\';
            $_x[0][] = 'Domain\\';
            $_x[0][] = '\\';
            $_x[1][] = '';
            $_x[1][] = '';
            $_x[1][] = '/';
            $class = str_replace( $_x[0], $_x[1], $_trace[1]['class'] );
        endif;


        if ( !$this->USER_ASSET )://not a User Asset load
            //check for external template override.
            if ( bc::registry()->EXTERNAL_TEMPLATE ):
                bc::registry()->MEDIA_PATH_SYSTEM = str_replace( bc::registry()->PROJECT_PACKAGE, bc::registry()->EXTERNAL_TEMPLATE, bc::registry()->MEDIA_PATH_SYSTEM );
            endif;
            //template base path
            $this->tplPath = bc::registry()->MEDIA_PATH_SYSTEM . $this->TEMPLATE . DIRECTORY_SEPARATOR;
        else:
            $this->tplPath = BC_PUBLIC_PATH . 'BriskCoder' . DIRECTORY_SEPARATOR . 'User' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . $this->TEMPLATE . DIRECTORY_SEPARATOR;
        endif;

        if ( $MAIL_TEMPLATE ):
            $this->tplPath .= '_Mail' . DIRECTORY_SEPARATOR . $class . '.' . $this->FILE_EXTENSION;
        else:
            $this->tplPath .= '_View' . DIRECTORY_SEPARATOR . $class . '.' . $this->FILE_EXTENSION;
        endif;



        if ( $RETURN_BUFFER ): //Called Buffer
            $this->init = FALSE; //reset INIT in case BUFFER was used before Render()
            $this->view = $this->tplParser( $this->tplPath );
            $this->parseMarkup( $MAIL_TEMPLATE );
            return $this->view;
        endif;

        if ( $this->VIEW_STATIC ):
            $this->view = $this->tplParser( $this->tplPath );
            $this->parseMarkup( $MAIL_TEMPLATE );
            //send buffer 
            echo $this->view;
            return; //Done 
        endif;

        //dev mode only
        if ( !is_dir( $this->cachePath ) ):
            bc::debugger()->CODE = 0;
            bc::debugger()->invoke();
        endif;
        //dev mode only
        if ( !is_writable( $this->cachePath ) ):
            bc::debugger()->CODE = 1;
            bc::debugger()->invoke();
            exit;
        endif;

        //allow language override
        bc::registry()->DYNAMIC_SEGMENT_KEY = bc::registry()->DYNAMIC_SEGMENT_KEY;

        //Registry all cache NS Settings
        //Language
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'Language' . DIRECTORY_SEPARATOR;
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-lang' );

        //Mail
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'Mail' . DIRECTORY_SEPARATOR;
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-mail' );

        //Template
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'Template' . DIRECTORY_SEPARATOR;
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-tpl' );

        //View
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'View' . DIRECTORY_SEPARATOR;
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-view' );


        //View css
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'View' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR;
        bcCache::$FILE_EXTENSION = 'css';
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-css' );

        //View js
        bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
        bcCache::$ENCODING = 0;
        bcCache::$STORAGE_RESOURCE = $this->cachePath . 'View' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR;
        bcCache::$FILE_EXTENSION = 'js';
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-js' );

        if ( $CUSTOM_FILE || $MAIL_TEMPLATE ):
            $cacheKey = md5( bc::registry()->DYNAMIC_SEGMENT_KEY . bc::registry()->DISPATCHER_NS . $this->pageIdentifier . $this->tplPath );
        else:
            $cacheKey = md5( bc::registry()->DYNAMIC_SEGMENT_KEY . bc::registry()->DISPATCHER_NS . $this->pageIdentifier );
        endif;

        //use view namespace before $this->readFromCache runs
        $MAIL_TEMPLATE ?
                        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-mail' ) :
                        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-view' );

        if ( $this->readFromCache( $cacheKey ) ):
            if ( (array) $this->_PARSE_NOCACHE === $this->_PARSE_NOCACHE ):
                $this->parseMarkup( $MAIL_TEMPLATE, FALSE );
            endif;

            if ( $RETURN_BUFFER ):
                //Called Buffer
                $this->init = FALSE; //reset INIT in case BUFFER was used before Render()
                return $this->view;
            endif;
            //send buffer 
            echo $this->view;
            return; //Done 
        endif;



        $this->langPath = bc::registry()->MEDIA_PATH_SYSTEM . $this->TEMPLATE . DIRECTORY_SEPARATOR .
                '_Language' . DIRECTORY_SEPARATOR .
                bc::registry()->DYNAMIC_SEGMENT_KEY . DIRECTORY_SEPARATOR . $class . '.lang';


        //REMINDER: when using remote servers, either for media or publisher layers,
        //the master server MUST always contain the original/updated files.
        //if is there a necessity of security and separation of Logic, Media and Pulisher
        //layer, then just allow access to the master server for staff that can access the whole
        //project and on all other slave servers only submit the desired layers accordingly.
        //Also it BriskCoder needs to create a library that copy from Master and distribute to 
        //slaves
        //Check for override
        if ( (array) bc::registry()->_REMOTE_MEDIA_TIERS === bc::registry()->_REMOTE_MEDIA_TIERS && bc::registry()->_REMOTE_MEDIA_TIERS ):
            bc::registry()->_REMOTE_MEDIA_TIERS = bc::registry()->_REMOTE_MEDIA_TIERS;
        endif;

        if ( !bc::registry()->_REMOTE_MEDIA_TIERS ):
            if ( is_file( $this->langPath ) ):
                $this->langParser();
            endif;
            $this->view = $this->tplParser( $this->tplPath );
        else:
            $shuffle = FALSE;
            if ( isset( bc::registry()->_REMOTE_MEDIA_TIERS['SHUFFLE'] ) &&
                    (bc::registry()->_REMOTE_MEDIA_TIERS['SHUFFLE'] === TRUE) ):
                $shuffle = TRUE;
                unset( bc::registry()->_REMOTE_MEDIA_TIERS['SHUFFLE'] );
            endif;

            if ( count( bc::registry()->_REMOTE_MEDIA_TIERS ) >= 1 ):
                if ( $shuffle ):
                    shuffle( bc::registry()->_REMOTE_MEDIA_TIERS );
                endif;
                bc::registry()->IS_REMOTE_MEDIA_TIER = TRUE;
            endif;

            $_url = FALSE;
            if ( $this->isRemoteLangCached() ):
                $_url['lang'] = $this->langPath;
            endif;

            if ( $this->isRemoteTplCached() ):
                $_url['tpl'] = $this->tplPath;
            endif;

            if ( $_url ):
                $n = 0;
                $this->loadRemote( $_url, $n );

                if ( $this->_fails !== FALSE ):
                    $c = count( bc::registry()->_REMOTE_MEDIA_TIERS ) - 1;
                    for ( $n = 1; $n <= $c; $n++ ):
                        $this->loadRemote( $this->_fails, $n );
                        if ( $this->_fails == NULL ):
                            break;
                        endif;
                        if ( $n == $c )://last resource after all fails
                            if ( array_key_exists( 'lang', $this->_fails ) ):
                                if ( is_file( $this->langPath ) ):
                                    $this->langParser();
                                endif;
                            endif;
                            if ( array_key_exists( 'tpl', $this->_fails ) ):
                                $this->view = $this->tplParser( $this->tplPath );
                            endif;
                        endif;
                    endfor;
                endif;
            endif;
        endif;

        if ( $this->view == NULL ):
            return;
        endif;

        //parse bc dynamic content
        $_pattern = array();
        $_replacement = array();
        $this->_PARSE['head'] = '';
        if ( $this->PARSE_CSS ):
            //Write CSS Dynamic Cache
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-css' );

//            bcCache::deleteNamespace( bc::registry()->PROJECT_PACKAGE . '-css' );
//            
//            bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
//            bcCache::$ENCODING = 0;
//            bcCache::$STORAGE_RESOURCE = $this->cachePath . 'View' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR;
//            bcCache::$FILE_EXTENSION = 'css';
//            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-css' );
            $cssKey = md5( serialize( $this->_headInc_cssPath ) );

            $cssData = '';
            if ( $this->_headInc_cssPath ):
                foreach ( $this->_headInc_cssPath as $path => $lvl ):
                    if ( !is_file( $path ) )://dev only
                        bc::debugger()->CODE = 4;
                        bc::debugger()->_PROBLEM[] = $path;
                        bc::debugger()->_SOLUTION[] = $path;
                        bc::debugger()->invoke();
                    endif;
                    $cssData .= file_get_contents( $path );
                endforeach;
            endif;

            if ( $this->_headInc_cssScript ):
                foreach ( $this->_headInc_cssScript as $hash => $resource ):
                    $cssData .= $resource;
                endforeach;
            endif;

            //parse all raw css from view
            $_pattern[] = '/<!--bc.css-->\s*<style>(.*?)<\/style>\s*<!--bc-->/s';
            $_replacement[] = '';
            preg_match_all( '/<!--bc.css-->\s*<style>(.*?)<\/style>\s*<!--bc-->/s', $this->view, $_m );
            if ( isset( $_m[1] ) ):
                foreach ( $_m[1] as $str ):
                    $cssData .= $str;
                endforeach;
            endif;

            if ( $cssData ):
                $cssData = preg_replace( array( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '#^\s*//.+$#m' ), '', $cssData ); // Remove comments
                $cssData = preg_replace( '/\s*([,;{}:=])\s*/', '$1', $cssData ); // Remove space after colons
                $cssData = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ' ), '', $cssData ); // Remove whitespace
            endif;
            bcCache::write( $cssKey, $cssData );
            unset( $cssData );
            bcHTML::head()->linkStyleSheet( '/BriskCoder/Pub/Cache/View/css/' . bc::registry()->PROJECT_PACKAGE . '-css-' . $cssKey . '.css?v=' . time() );
            $this->_PARSE['head'] .= bcHTML::head()->getMarkup();
        endif;


        if ( $this->PARSE_JS ):
            //Write JS Dynamic Cache
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-js' );
//            bcCache::deleteNamespace( bc::registry()->PROJECT_PACKAGE . '-js' );
//            
//            bcCache::$LIFE_DEFAULT = $this->CACHE_LIFETIME;
//            bcCache::$ENCODING = 0;
//            bcCache::$STORAGE_RESOURCE = $this->cachePath . 'View' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR;
//            bcCache::$FILE_EXTENSION = 'js';
//            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-js' );
            $jsKey = md5( serialize( $this->_headInc_cssPath ) );
            $jsData = '';
            if ( !empty( $this->_headInc_jsPath ) ):
                foreach ( $this->_headInc_jsPath as $path => $lvl ):
                    if ( !is_file( $path ) )://debug only
                        bc::debugger()->CODE = 4;
                        bc::debugger()->_PROBLEM[] = $path;
                        bc::debugger()->_SOLUTION[] = $path;
                        bc::debugger()->invoke();
                    endif;
                    $jsData .= file_get_contents( $path );
                endforeach;
            endif;

            if ( $this->_headInc_jsScript ):
                foreach ( $this->_headInc_jsScript as $hash => $resource ):
                    $jsData .= $resource;
                endforeach;
            endif;

            //parse all raw js from view
            $_pattern[] = '/<!--bc.js-->\s*<script>(.*?)<\/script>\s*<!--bc-->/s';
            $_replacement[] = '';
            preg_match_all( '/<!--bc.js-->\s*<script>(.*?)<\/script>\s*<!--bc-->/s', $this->view, $_m );
            if ( isset( $_m[1] ) ):
                foreach ( $_m[1] as $str ):
                    $jsData .= $str;
                endforeach;
            endif;

            if ( $jsData ):
                $jsData = preg_replace( '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $jsData ); // Remove comments
                $jsData = preg_replace( '/\s*([,;{}():=|-])\s*/', '$1', $jsData ); // Remove space after colons
                $jsData = str_replace( array( "\r\n", "\r", "\t", "\n" ), '', $jsData ); // Remove whitespace
            endif;

            //strip space and minimize
            bcCache::write( $jsKey, $jsData );
            unset( $jsData );
            bcHTML::head()->linkJavascript( '/BriskCoder/Pub/Cache/View/js/' . bc::registry()->PROJECT_PACKAGE . '-js-' . $cssKey . '.js?v=' . time() );
            $this->_PARSE['head'] .= bcHTML::head()->getMarkup();
        endif;

        $this->parseMarkup( $MAIL_TEMPLATE, TRUE, $_pattern, $_replacement );
        //whitespaces
        $this->view = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ' ), '', $this->view );

        if ( $MAIL_TEMPLATE ):
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-mail' );
            bcCache::write( $cacheKey, $this->view );
        else:
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-view' );
            bcCache::write( $cacheKey, $this->view );
        endif;

        if ( $RETURN_BUFFER ):
            //Called Buffer
            $this->init = FALSE; //reset INIT in case BUFFER was used before Render()
            return $this->view;
        endif;

        echo $this->view;
    }

    private function readFromCache( $cacheKey )
    {
        if ( (!$this->CACHE_LIFETIME) || (!is_file( $this->tplPath )) ):
            return FALSE;
        endif;

        $lastModified = bcCache::getLastModified( $cacheKey );
        if ( !$lastModified ):
            return FALSE;
        endif;

        if ( $lastModified < filemtime( $this->tplPath ) ):
            return FALSE;
        endif;


        if ( ($lastModified + $this->CACHE_LIFETIME) < time() ):
            return FALSE;
        endif;

        $this->view = bcCache::read( $cacheKey );

        if ( !$this->view ):
            return FALSE;
        endif;
        //END VIEW
        //HEAD INCLUDES

        if ( $this->PARSE_CSS ):
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-css' );
            $cssKey = md5( serialize( $this->_headInc_cssPath ) );

            $lastModified = bcCache::getLastModified( $cssKey );
            if ( !$lastModified ):
                return FALSE;
            endif;

            //check cache status
            foreach ( $this->_headInc_cssPath as $path => $lvl ):
                if ( !is_file( $path ) ):
                    return FALSE;
                endif;

                //checks if the cache file is older than original file 
                if ( $lastModified < filemtime( $path ) ):
                    return FALSE;
                endif;

                if ( ($lastModified + $this->CACHE_LIFETIME) < time() ):
                    return FALSE;
                endif;
            endforeach;
        endif;


        if ( $this->PARSE_JS ):
            bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-js' );
            $jsKey = md5( serialize( $this->_headInc_cssPath ) );

            $lastModified = bcCache::getLastModified( $jsKey );
            if ( !$lastModified ):
                return FALSE;
            endif;

            //check cache status
            foreach ( $this->_headInc_jsPath as $path => $lvl ):
                if ( !is_file( $path ) ):
                    return FALSE;
                endif;

                if ( $lastModified < filemtime( $path ) ):
                    return FALSE;
                endif;

                if ( $lastModified + $this->CACHE_LIFETIME < time() ):
                    return FALSE;
                endif;
            endforeach;
        endif;

        return TRUE;
    }

    /**
     * DUMP CACHE method
     * @param $ALL_PROJECTS bool Erase/Dump all projects. Default = FALSE
     * @return void Permanently dumps the current project cached files. 
     */
//    public function dumpCache( $ALL_PROJECTS = FALSE )
//    {
//        $cacheDirs[] = 'Language';
//        $cacheDirs[] = 'Mail';
//        $cacheDirs[] = 'Template';
//        $cacheDirs[] = 'View';
//        $cacheDirs[] = 'View/css';
//        $cacheDirs[] = 'View/js';
//
//        foreach ( $cacheDirs as $d ):
//            $path = $this->cachePath . $d . '/';
//            $handle = opendir( $path );
//            $match = bc::registry()->PROJECT_PACKAGE . '-';
//            while ( false !== ($file = readdir( $handle )) ):
//                if ( $file != "." && $file != ".." ):
//                    if ( !$ALL_PROJECTS ):
//                        if ( substr( $file, 0, strlen( $match ) ) === $match ):
//                            unlink( $path . $file );
//                        endif;
//                    else:
//                        unlink( $path . $file );
//                    endif;
//                endif;
//            endwhile;
//        endforeach;
//    }

    /**
     * DUMP CACHE method
     * @param $ALL_PROJECTS bool Erase/Dump all projects. Default = FALSE
     * @param $PROJECT bool Erase/Dump from specific project. Default = bc::registry()->PROJECT_PACKAGE
     * @param $NAME string Erase/Dump from specific project and specific name. ie: '-view', default = '-' means everyting after '-' from project.
     * @return void Permanently dumps the current project cached files. 
     */
    public function dumpCache( $ALL_PROJECTS = FALSE, $PROJECT = FALSE, $NAME = '-' )
    {
        $cacheDirs[] = 'Language';
        $cacheDirs[] = 'Mail';
        $cacheDirs[] = 'Template';
        $cacheDirs[] = 'View';
        $cacheDirs[] = 'View/css';
        $cacheDirs[] = 'View/js';

        $project = !($PROJECT) ? bc::registry()->PROJECT_PACKAGE : $PROJECT;

        foreach ( $cacheDirs as $d ):
            $path = $this->cachePath . $d . '/';
            $handle = opendir( $path );
            $match = $project . $NAME;
            while ( false !== ($file = readdir( $handle )) ):
                if ( $file != "." && $file != ".." ):
                    if ( !$ALL_PROJECTS ):
                        if ( substr( $file, 0, strlen( $match ) ) === $match ):
                            unlink( $path . $file );
                        endif;
                    else:
                        unlink( $path . $file );
                    endif;
                endif;
            endwhile;
        endforeach;
    }

    /**
     * SET PAGE IDENTIFIER     
     * Creates propper cache for dynamic pages by using specific identifier that generates the content<br>
     * which is usually the $_GET query_string parameter and value
     * ie: bc::publisher()->setPageIdentifier('cat_id=1');
     * @param String $IDENTIFIER 
     * @return Void
     */
    public function setPageIdentifier( $IDENTIFIER )
    {
        $this->pageIdentifier = $IDENTIFIER;
    }

    private function parseMarkup( $MAIL_TEMPLATE, $CACHE = TRUE, $_pattern = array(), $_replacement = array() )
    {
        if ( !$this->VIEW_STATIC ):
            if ( $CACHE ):
                if ( (array) $this->_PARSE === $this->_PARSE ):
                    foreach ( $this->_PARSE as $k => $v ):
                        if ( $v != NULL ):
                            $_pattern[] = '/<!--bc.' . $k . '-->(.*?)<!--bc-->/s';
                            $_replacement[] = $v;
                        endif;
                    endforeach;
                endif;
            endif;

            if ( (array) $this->_PARSE_NOCACHE === $this->_PARSE_NOCACHE ):
                foreach ( $this->_PARSE_NOCACHE as $k => $v ):
                    if ( $v != NULL ):
                        $_pattern = array_merge( $_pattern, array( '/<!--bc.nocache.' . $k . '-->(.*?)<!--bc-->/s' ) );
                        $_replacement = array_merge( $_replacement, array( '<!--bc.nocache.' . $k . '-->' . $v . '<!--bc-->' ) );
                    endif;
                endforeach;
            endif;
            $this->view = preg_replace( $_pattern, $_replacement, $this->view );
        endif;

        //parseLinks
        if ( $MAIL_TEMPLATE || ($this->PARSE_HYPERLINKS !== TRUE) ):
            return;
        endif;

        $link = bc::registry()->DEFAULT_PROJECT_ALIAS === bc::registry()->PROJECT_ALIAS ? NULL : '/' . bc::registry()->PROJECT_ALIAS;

        if ( bc::registry()->IS_DYNAMIC_SEGMENT_SUBDOMAIN == FALSE &&
                bc::registry()->DYNAMIC_SEGMENT_KEY != NULL &&
                bc::registry()->DYNAMIC_SEGMENT_KEY !== key( bc::registry()->_DYNAMIC_SEGMENT ) ):
            $link .= '/' . bc::registry()->DYNAMIC_SEGMENT_KEY;
        endif;
        //replace current App + Dynamic Segment if needed
        $_n[] = '<a href="/' . bc::registry()->PROJECT_PACKAGE;
        $_n[] = ' action="/' . bc::registry()->PROJECT_PACKAGE;
        $_r[] = '<a href="' . $link;
        $_r[] = ' action="' . $link;

        if ( isset( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) && !in_array( bc::registry()->DEFAULT_PROJECT_ALIAS, bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] ) ):
            /*             * removing default project dispatcher in the beggining of links with or without dynamic segment
             * @author Emily
             */
            $_n[] = '<a href="' . $link . '/' . bc::registry()->DEFAULT_PROJECT_ALIAS;
            $_n[] = ' action="' . $link . '/' . bc::registry()->DEFAULT_PROJECT_ALIAS;
            $_r[] = '<a href="' . $link;
            $_r[] = ' action="' . $link;
        endif;

        $this->view = str_replace( $_n, $_r, $this->view );

        // now replace _DISPATCHER_ALIAS
        if ( bc::registry()->DYNAMIC_SEGMENT_KEY != NULL && array_key_exists( bc::registry()->DYNAMIC_SEGMENT_KEY, bc::registry()->_DISPATCHER_ALIAS ) ):
            $_n = array();
            $_r = array();
            arsort( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] );
            foreach ( bc::registry()->_DISPATCHER_ALIAS[bc::registry()->DYNAMIC_SEGMENT_KEY] as $k => $v ):
                $_n[] = '<a href="' . $link . '/' . $v;
                $_n[] = ' action="' . $link . '/' . $v;
                $_r[] = '<a href="' . $link . '/' . $k;
                $_r[] = ' action="' . $link . '/' . $k;
            endforeach;
            $this->view = str_replace( $_n, $_r, $this->view );
        endif;
        //end parseLinks
        //parseMediaLinks
        //Parse domain names for remote email templates
        if ( bc::registry()->IS_REMOTE_MEDIA_TIER && $MAIL_TEMPLATE ):

            $domain = bc::registry()->IS_REMOTE_MEDIA_TIER ? bc::registry()->_REMOTE_MEDIA_TIERS[0] : bc::registry()->DOMAIN_FQDN;

            $url = bc::registry()->PROTOCOL . $domain . '/' . bc::registry()->PROJECT_PACKAGE . '/Media/';

            $_matches = array();
            if ( preg_match_all( '/\"\/' . bc::registry()->PROJECT_PACKAGE . '\/Media\/(.*?)\"/si', $this->view, $_matches ) ):
                $_pat = array_values( $_matches[0] );
                foreach ( $_matches[1] as $v ):
                    $_rep[] = '"' . $url . $v . '"';
                endforeach;
                $this->view = str_replace( $_pat, $_rep, $this->view );
            endif;
        endif;
    }

    private function isRemoteLangCached()
    {
        $cacheKey = md5( $this->langPath );
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-lang' );
        $cached = bcCache::read( $cacheKey );
        if ( $cached ):
            $this->langParser( $cached );
            return FALSE;
        endif;
        return TRUE;
    }

    private function isRemoteTplCached()
    {
        $cacheKey = md5( $this->tplPath );
        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-tpl' );
        $this->view = bcCache::read( $cacheKey );
        if ( $this->view ):
            return FALSE;
        endif;
        return TRUE;
    }

    private function loadRemote( $_url, $n )
    {
        //test curl
        if ( bc::registry()->IS_REMOTE_MEDIA_TIER ):
            if ( !extension_loaded( 'curl' ) ):
                //TODO need to write proper messages if no cURL loaded
                bc::debugger()->CODE = 2;
                bc::debugger()->invoke();
            endif;
        endif;

        $mh = curl_multi_init();

        //note: observe protocol, it may need to comply with remote server list, then pass a setter if SSL or not for each domain
        foreach ( $_url as $k => $v ):
            $_cURL[$k] = curl_init();
            curl_setopt( $_cURL[$k], CURLOPT_URL, bc::registry()->PROTOCOL . bc::registry()->_REMOTE_MEDIA_TIERS[$n] . '/' . $v );
            curl_setopt( $_cURL[$k], CURLOPT_HEADER, FALSE );
            curl_setopt( $_cURL[$k], CURLOPT_CONNECTTIMEOUT, 1 );
            curl_setopt( $_cURL[$k], CURLOPT_SSL_VERIFYHOST, 0 );
            curl_setopt( $_cURL[$k], CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt( $_cURL[$k], CURLOPT_FRESH_CONNECT, 1 );
            curl_setopt( $_cURL[$k], CURLOPT_RETURNTRANSFER, TRUE );
            curl_multi_add_handle( $mh, $_cURL[$k] );
        endforeach;

        $active = null;
        do {
            $status = curl_multi_exec( $mh, $active );
        } while ( $status === CURLM_CALL_MULTI_PERFORM || $active );

        foreach ( $_url as $k => $v ):
            $_r = curl_getinfo( $_cURL[$k] );
            if ( $_r['http_code'] === 200 ):
                switch ( $k ):
                    case 'lang':
                        $data = curl_multi_getcontent( $_cURL[$k] );
                        $cacheKey = md5( $this->langPath );
                        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-lang' );
                        bcCache::write( $cacheKey, $data );
                        $this->langParser( $data );
                        unset( $this->_fails[$k], $data, $cacheKey );
                        break;
                    case 'tpl':
                        $this->view = curl_multi_getcontent( $_cURL[$k] );
                        $cacheKey = md5( $this->tplPath );
                        bcCache::useNamespace( bc::registry()->PROJECT_PACKAGE . '-tpl' );
                        bcCache::write( $cacheKey, $this->view );
                        unset( $this->_fails[$k], $cacheKey );
                        break;
                endswitch;
            else:
                $this->_fails[$k] = $v;
            endif;
        endforeach;
    }

    private function langParser( $cached = FALSE )
    {
        if ( $cached ):
            $_lang = parse_ini_string( $cached );
        else:
            $_lang = parse_ini_file( $this->langPath );
        endif;

        if ( (array) $_lang === $_lang ):
            $this->_PARSE = ((array) $this->_PARSE === $this->_PARSE) ? array_merge( $_lang, $this->_PARSE ) : $_lang;
        endif;
    }

    /**
     * 
     * @param string $tplPath
     * @return string
     */
    private function tplParser( $tplPath )
    {
        //dev mode only
        if ( !is_file( $tplPath ) ):
            bc::debugger()->CODE = 3;
            bc::debugger()->_PROBLEM[] = $tplPath;
            bc::debugger()->_SOLUTION[] = $tplPath;
            bc::debugger()->invoke();
        endif;

        //if ( bc::publisher()->FILE_EXTENSION === 'html' ):
        return file_get_contents( $tplPath );
        //endif;
        //need to use file_get contents  via HTTP so SSI will work
        //php include does now parse SSI
        //return file_get_contents( bc::registry()->PROTOCOL . bc::registry()->DOMAIN_FQDN . '/' . str_replace( '\\', '/', str_replace( BC_PUBLIC_PATH, NULL, $tplPath ) ) );
    }

}
