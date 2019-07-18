<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Registry
 * @package     Engine
 * @subpackage  System
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.`briskcoder.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\System;

/**
 * Registry
 * Global Registry Class
 * @category    Registry
 * @package     Engine
 * @subpackage  System
 */
class Registry
{

    public
    /**
     * BC Applications Array
     * @var array Returns Applications key value pair (uri-name => NameConvention) 
     */
            $_PROJECTS,
            /**
             * BC DEFAULT_PROJECT_ALIAS String
             * @var type $name Description string Returns Application URL segment key. 
             */
            $DEFAULT_PROJECT_ALIAS,
            /**
             * BC DEFAULT_PROJECT_PACKAGE String
             * @var string Returns Application Class Name. 
             */
            $DEFAULT_PROJECT_PACKAGE,
            /**
             * BC DEFAULT_PROJECT_PACKAGE_UUID String
             * Default = 1
             */
            $DEFAULT_PROJECT_PACKAGE_UUID = 1,
            /**
             * CURRENT CLIENT IP ADDRESS
             * @var string Returns CLIENT IP ADDRESS. 
             */
            $CLIENT_IP,
            /**
             * CURRENT SERVER IP ADDRESS
             * @var string Returns SERVER IP ADDRESS. 
             */
            $SERVER_IP,
            /**
             * CURRENT PROTOCOL HTTP | HTTPS
             * @var string Returns http:// | https:// according to request. 
             */
            $PROTOCOL,
            /**
             * CURRENT FULLY QUALIFIED DOMAIN NAME FROM URI
             * IE: www.mydonain.co.uk
             * @var string Returns Fuly Qualified Domain Name. 
             */
            $DOMAIN_FQDN,
            /**
             * CURRENT DOMAIN_ID
             * Default = 1
             */
            $DOMAIN_ID = 1,
            /**
             * DOMAINS
             * Default = array()
             */
            $_DOMAINS = array(),
            /**
             * CURRENT LANGUAGE_ID
             * Default = 1
             */
            $LANGUAGE_ID = 1,
            /**
             * CURRENT URI SEGMENTS INCLUDING QUERY STRING
             * left forward slash is not stripped and domain name is not included 
             * @var string /uri/segments/?query=string_included
             */
            $URI,
            /**
             *  CURRENT URI SEGMENTS WITHOUT QUERY STRING
             * left forward slash is not stripped, domain name and query string are not included 
             * right forward slash is stripped
             * @var string /uri/segments
             */
            $URI_NO_QS,
            /**
             * URI REFERER TO CURRENT PAGE IF EXISTING 
             * @var string Returns URI referer Protocol + DOMAIN_FQDN + segments + Query String. 
             */
            $URI_REFERER,
            /**
             * URI_SEGMENT 
             * Similar to $URI_NO_QS except that string is forced to lowercase and starting and ending forward slash "/" are stripped. 
             * @var string url/segment/path
             */
            $URI_SEGMENT,
            /**
             * CURRENT USER AGENT
             * @var string Returns User Agent Information (Browser Data). 
             */
            $USER_AGENT,
            /**
             * BC PROJECT_ALIAS String
             * @var string Returns Application URL segment key. 
             */
            $PROJECT_ALIAS,
            /**
             * BC PROJECT_PACKAGE String
             * @var string Returns Application Class Name. 
             */
            $PROJECT_PACKAGE,
            /**
             * BC DISPATCHER ALIAS
             * WHEN using DISPATCHER ALIAS feature it will return the current dispatcher alias without the PROJECT and LOCALE segments.<br>
             * Also, when using _DYNAMIC_ROUTE feature it will not glue the dynamic segments to the $DISPATCHER_ALIAS, which then can be used as a key<br>
             * of bc::registry()->_DYNAMIC_ROUTE[bc::registry()->DISPATCHER_ALIAS] which tnen return the dynamic path only.
             * @var String
             */
            $DISPATCHER_ALIAS,
            /**
             * BC DISPATCHER NAMESPACE 
             * NOTE: Dispatcher\ namespace gets removed and just original ClassName\Levels are presented. if full path is intented then Use __CLASS__  instead.
             * @var string Returns Current Requested URL Segment converted to dispatcher Class. Caught @ Dispatcher levels only
             */
            $DISPATCHER_NS,
            /**
             * DISPATCHER URI
             * Similar to DISPATCHER_NS except that dispatcher path is using forward slashes "/"
             * @var string Returns Current Requested URL Segment referencing to dispatcher ie: dev/dispatcher
             */
            $DISPATCHER_URI,
            /**
             * EXTERNAL_TEMPLATE
             * Load template from other project
             * This Feature is RUNTIME at _Global and Application Dispatcher levels
             * @var string $EXTERNAL_TEMPLATE  Set the $URL_NAME (segment name) of the project you want BriskCoder to load templates from. 
             */
            $EXTERNAL_TEMPLATE,
            /**
             * MEDIA PATH SYSTEM
             * @var string $MEDIA_PATH_SYSTEM 
             */
            $MEDIA_PATH_SYSTEM,
            /**
             * MEDIA PATH URI
             * @var string $MEDIA_PATH_URI 
             */
            $MEDIA_PATH_URI,
            /**
             * BriskCoder MEDIA TIER Servers
             * This Feature is RUNTIME at _Global and Application Dispatcher levels
             * First Key must be 'SHUFFLE' and Value TRUE or FALSE
             * Then set as bc::registry()->_REMOTE_MEDIA_TIERS[] = 'www.myserver.com' or '192.168.0.1' for each remote server. 
             */
            $_REMOTE_MEDIA_TIERS = array(),
            /**
             * BC DYNAMIC URI SEGMENTS 
             * Returns Custom URL Segment key value pair ie:(en-us => US English)
             * It can overridden bc::engine()->projectSetting()->dynamicSegment( 'en-us', 'US English' ) by the _Global dispatcher
             * Thi smight be used with any value pair as long as the Key is passed thru URL and respects naming convention lowercase
             * Array must be formed as follows:  bc::registry()->_DYNAMIC_SEGMENT[$VIRTUAL_DIR_CODE] = $VIRTUAL_DIR_VALUE; 
             * @var array  
             */
            $_DYNAMIC_SEGMENT,
            /**
             * DYNAMIC URI KEY
             * Also used by the Publisher to construct and load .lang translation files path. 
             * If needed anything else othe than default it might be overridden 
             * @var string Current Dynamic Uri Key (en-us) if in use 
             */
            $DYNAMIC_SEGMENT_KEY,
            /**
             * BC HAS_DYNAMIC_SEGMENT
             * Returns TRUE or FALSE if current app is using _DYNAMIC_SEGMENT codes
             */
            $HAS_DYNAMIC_SEGMENT = FALSE,
            /**
             * BC IS_DYNAMIC_SEGMENT_SUBDOMAIN
             * Returns TRUE or FALSE if current app is using subdomain
             */
            $IS_DYNAMIC_SEGMENT_SUBDOMAIN = FALSE,
            /**
             * BC _DISPATCHER_ALIAS 
             * It overrides bc::engine()->set()->dispatcherAlias( $VIRTUAL_DIR, $ALIAS, $URI_SEGMENT );
             * Also overriddens $_DYNAMIC_SEGMENT if empty otherwise it will match _DYNAMIC_SEGMENT code keys for alias translation
             * Useful for SEO Friendly URL Segment translation and routing of physical dispatcher classes.
             * Array must be formed as follows:  bc::registry()->_DISPATCHER_ALIAS[$LOCALE_CODE][$NEW_URL_ALIAS] = $ORIGINAL_URL_SEGMENT;
             * NOTE: once aliased a original URL segment that translates to a dispatcher gets automatically locked and calls Custom403 dispatcher when in production mode
             * $LOCALE_CODE Even if not used for translation purposes the 1st key will be always default and wont be used as URI segment
             * $ALIAS Virtual SEO Friendly translation for the current $URL_SEGMENT. 
             * $URL_SEGMENT Name of the dispatcher class. Remember that this is attached to $NAMING_CONVENTION ie: /my-class/ will route to dispatcher 
             * MyClass if using $NAMING_CONVENTION = 0 UpperCamelCase
             * @var array  
             */
            $_DISPATCHER_ALIAS = array(),
            /**
             * BC IS_REMOTE_MEDIA_TIER
             * Returns TRUE or FALSE if current app is using remote MEDIA tiers
             */
            $IS_REMOTE_MEDIA_TIER = FALSE,
            /**
             * BC _LANGUAGES
             * BC System Languages
             */
            $_LANGUAGES = array( 1 => array(
                    'languages_tag' => 'en-us',
                    'languages_name' => 'US English',
                    'languages_name_en' => 'US English',
                    'languages_status' => 1,
                    'languages_created' => '',
                    'languages_modified' => '',
                ) ),
            /**
             * 
             * BC _DYNAMIC_ROUTE
             * Applies at _Global Dispatchers
             * Useful for SEO Friendly URL by stopping routing and converting segments to _DYNAMIC_ROUTE['url-segment'] = 'seo-url/captured/values'
             * $URI_SEGMENT string Url segment that will call a Dispatcher class
             * bc::registry()->_DYNAMIC_ROUTE['uri-segment']
             * NOTE: when using $_DISPATCHER_ALIAS then _DYNAMIC_ROUTE key must be the $ALIAS so it can collect the extra segments before alias translation occurs
             * @tutorial bc::registry()->_DYNAMIC_ROUTE: /company/your-custom/query-string/ normally would point to Dispatcher\Company and treated as ERROR 404 
             * Due to the fact that YourCustom/QueryString is NOT a Dispatcher Class under /Company such as Dispatcher\Company\YourCustom\QueryString
             * By setting bc::registry()->_DYNAMIC_ROUTE['company'] = NULL; BriskCoder will stop routing at Dispatcher\Company and treat
             * anything beyond as _DYNAMIC_ROUTE which in this case bc::registry()->_DYNAMIC_ROUTE['company'] would return string "your-custom/query-string".
             * Use full path for 'url-segment' name ie:  about/company-america
             * The returning value will automatically remove slashes from begining and ending of a string
             * NOTE: If using _DISPATCHER_ALIAS then the Alias name referring to the Dispatcher target class must be the also passed as _DYNAMIC_ROUTE['url-segment']
             * so both feature can work together. _DYNAMIC_ROUTE does not return results at _Global level. 
             * @var array  
             */
            $_DYNAMIC_ROUTE = array();
    private $_magic = array();

    /**
     * Set Function
     * @param string $caller
     */
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\bc' ):
            //call wizard here
            exit( 'Debug: Forbidden System class usage' );
        endif;
    }

    public function __set( $name, $value )
    {
        $this->_magic[$name] = $value;
    }

    public function &__get( $name )
    {
        // if ( array_key_exists($name, $this->_R) ):
        return $this->_magic[$name];
        //endif;
    }

    public function __isset( $name )
    {
        return isset( $this->_magic[$name] );
    }

    public function __unset( $name )
    {
        unset( $this->_magic[$name] );
    }

    /**
     * Prints a Friendly Table with all the containing magic properties and its values
     * @return string 
     */
    public function explain()
    {
        ob_start();
        echo '<table cellpadding="5" cellspacing="0" border="0">';
        echo '<tr><th>CLASS PROPERTIES</th><th></th><th>VALUES</th></tr>';
        echo '<tr><td colspan="3" style="border-bottom:1px dotted red;"></td></tr>';
        foreach ( get_object_vars( $this ) as $k => $v ):
            if ( $k == '_magic' ):
                continue;
            endif;
            echo '<tr><td style="border-bottom:1px dotted red;">';
            echo '<b>' . $k . '</b>';
            echo '</td><td style="border-bottom:1px dotted red;">';
            echo ' => ';
            echo '</td><td style="border-bottom:1px dotted red;">';
            var_dump( $v );
            echo '<br>';
            echo '</td></tr>';
        endforeach;
        echo '<tr><td colspan="3" style="height:50px;"></td></tr>';
        echo '<tr><th>MAGIC PROPERTIES</th><th></th><th>VALUES</th></tr>';
        echo '<tr><td colspan="3" style="border-bottom:1px dotted red;"></td></tr>';
        foreach ( $this->_magic as $k => $v ):
            echo '<tr><td style="border-bottom:1px dotted red;">';
            echo '<b>' . $k . '</b>';
            echo '</td><td style="border-bottom:1px dotted red;">';
            echo ' => ';
            echo '</td><td style="border-bottom:1px dotted red;">';
            var_dump( $v );
            echo '<br>';
            echo '</td></tr>';
        endforeach;
        echo '</table>';
        $r = ob_get_contents();
        ob_end_clean();
        return $r;
    }

}
