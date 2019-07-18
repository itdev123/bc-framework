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

use BriskCoder\bc;

/**
 * Class Setter
 * BriskCoder Setter Class
 * @category BriskCoder
 * @package System
 */
final class Setter 
{

    private static $proj;
    
   
    public function __construct($CALLER, $URL_NAME, $PACKAGE_NAME,  $DEFAULT_DISPATCHER, $NAMING_CONVENTION )
    {
        if($CALLER !== 'BriskCoder\System\Project'):
            exit('Debug: Forbidden System class usage - Class Project');
        endif;
        
        self::$proj = $URL_NAME;
        bc::registry()->_PROJECTS[self::$proj]['PACKAGE_NAME'] = $PACKAGE_NAME;
        bc::registry()->_PROJECTS[self::$proj]['DEFAULT_DISPATCHER'] = $DEFAULT_DISPATCHER;
        bc::registry()->_PROJECTS[self::$proj]['NAMING_CONVENTION'] = $NAMING_CONVENTION;
        bc::registry()->_PROJECTS[self::$proj]['VALIDATE_EXTENSION'] = FALSE;
        bc::registry()->_PROJECTS[self::$proj]['EXTERNAL_TEMPLATE'] = NULL;
        bc::registry()->_PROJECTS[self::$proj]['MANUAL_ROUTING'] = FALSE;
        bc::registry()->_PROJECTS[self::$proj]['_DYNAMIC_SEGMENT'] = array();
        bc::registry()->_PROJECTS[self::$proj]['_DISPATCHER_ALIAS'] = array();
        bc::registry()->_PROJECTS[self::$proj]['_MEDIA_TIERS'] = array();
    }
    
    
    /**
     * Set and validates the URI extension to be routed throught the project.
     * Default is NULL which means URI will be formed as /segment/
     * The parameter must NOT contain period. Just pass the desired extension name as follows: $EXTENSION = 'php'.
     * Any name may be used. 
     * @param string $EXTENSION  
     */
    public function validateExtension($EXTENSION)
    {
        bc::registry()->_PROJECTS[self::$proj]['VALIDATE_EXTENSION'] = $EXTENSION; 
    }
    

    /**
     * Load template from another project
     * This feature can be overridden at _Global dispatcher and Application Dispatcher levels though bc::registry()->EXTERNAL_TEMPLATE  registry
     * @param string $PROJECT_URL_NAME Default is NULL. Set the $URL_NAME (segment name) of the project you want BriskCoder to load templates from. Only applicable for second project and beyound. 
     */
    public function externalTemplate($PROJECT_URL_NAME)
    {
        bc::registry()->_PROJECTS[self::$proj]['EXTERNAL_TEMPLATE'] = $PROJECT_URL_NAME; 
    }
    
    /**
     * @param bool $MANUAL_ROUTING Default is FALSE. Set to TRUE if you want to route all requests to Home dispatcher and define your own URL segment mprojing. 
     */
    public function manualRouting($MANUAL_ROUTING)
    {
        bc::registry()->_PROJECTS[self::$proj]['MANUAL_ROUTING'] = $MANUAL_ROUTING;  
    }
    
    /**
     * BC _DYNAMIC_SEGMENT: 
     * Multi Callable. bc::engine()->set()->dynamicSegment() for each line.
     * This feature can be overridden at _Global dispatcher though bc::registry()->_DYNAMIC_SEGMENT  registry
     * Except when expecting bc::publisher() to parse hyperlinks for all packages, then they all must be set by this method in your bootstrap file.
     * @param string $CODE MUST be lowercase. This will be verified against URL language segment and Language files structure.
     * @param mixed $DATA string || array containing needed data such as : Language ID, Title, Image etc.   
     */
    public function dynamicSegment($CODE, $DATA)
    {
        bc::registry()->_PROJECTS[self::$proj]['_DYNAMIC_SEGMENT'] += array($CODE => $DATA);  
    }
    
     /**
      * Set Dispatcher Translated Aliases. 
      * Useful for SEO Friendly URL Segment translation of physical dispatcher classes.
      * Multi Callable. bc::engine()->projectSetting()->translateDispatcher() for each line.
      * This feature can be overridden at _Global dispatcher though bc::registry()->_DISPATCHER_ALIAS<br>
      * Except when expecting bc::publisher() to parse hyperlinks for all packages, then they all must be set by this method in your bootstrap file.
      * IMPORTANT: must set at least bc::registry()->_DYNAMIC_SEGMENT['key'] where 'key' is the dynamicSegment code. Otherwise it will be igonored.<br>
      * When working with a system that will maintain only one language and for some reason it's necessary to translate dispatchers
      * from a virtual uri name, ie: /admin to /my-weekly-random-word  for security etc, then set bc::registry()->_DYNAMIC_SEGMENT['key'] where 'key' is any variable
      * or the default language code used: ie: en-us, pt-br etc, since default _DYNAMIC_SEGMENT keys are stripped from URI segment automaticaly by enforcing redirection ie:<br>
      * if only _DYNAMIC_SEGMENT 'key' is 'en-us' or the it is the first to be set and the current uri request points to /en-us/dispatcher-name it automatically removes en-us/ and redirects to /dispatcher-name
      * @param string $LOCALE_CODE  Dymamci URI segment set as _DYNAMIC_SEGMENT matching language codes for auto translation path
      * @param string $ALIAS Virtual New translation for the original URL segment.  
      * @param string $URI_SEGMENT Original URL segment that points to dispatcher. 
      */
    public function dispatcherAlias($LOCALE_CODE, $ALIAS, $URI_SEGMENT )
    {
        //do not set if _DYNAMIC_SEGMENT keys are not found
        if ( !array_key_exists( $LOCALE_CODE, bc::registry()->_PROJECTS[self::$proj]['_DYNAMIC_SEGMENT'])):
            return;
        endif;
        //All these might be removed on production class
        if ( isset(bc::registry()->_PROJECTS[self::$proj]['_DISPATCHER_ALIAS'][$LOCALE_CODE]) ):
            if (in_array($URI_SEGMENT, bc::registry()->_PROJECTS[self::$proj]['_DISPATCHER_ALIAS'][$LOCALE_CODE])):
                return;
            endif;
        endif;
       
        foreach ( bc::registry()->_PROJECTS[self::$proj]['_DISPATCHER_ALIAS'] as $_r):
            if ( isset($_r[$ALIAS]) ):
                return;
            endif;
        endforeach;
        //end All these

        bc::registry()->_PROJECTS[self::$proj]['_DISPATCHER_ALIAS'][$LOCALE_CODE][$ALIAS] = $URI_SEGMENT;
    }
    
    /**
     * 
     * This Feature is RUNTIME at _Global and Application Dispatcher levels
     * TODO like dispatcherAlias array treatment
     * @param array $_MEDIA_TIERS To randomly load remote addresses First Key must be 'SHUFFLE' and Value TRUE, then set as $_MEDIA_TIERS[] = 'www.myserver.com' for each remote server. 
     */
    public function mediaTiers($_MEDIA_TIERS)
    {
        bc::registry()->_PROJECTS[self::$proj]['_MEDIA_TIERS'] = $_MEDIA_TIERS;  
    }

}