<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Component\bcFormControl,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Facebook,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Google,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Twitter;

final class Config
{

    public
    /**
     * AUTH FORM HIDDEN EMPTY
     * Helps against CSRF (Cross Site Request Forgery)
     * The authentication system will check if $_POST contains
     * a submitted hidden field with empty value, if not empty authentication will not proceed 
     * Default is TRUE
     * @var bool $AUTH_FORM_HIDDEN_EMPTY
     */
            $AUTH_FORM_HIDDEN_EMPTY = TRUE,
            /**
             * AUTH FORM HIDDEN NONCE NAME
             * Helps against CSRF (Cross Site Request Forgery)
             * The Authentication form must collect a hidden field with a nonce key
             * that will be matched server side before auth routines are executed.
             * Default is TRUE
             * @var mixed $AUTH_FORM_HIDDEN_NONCE 
             */
            $AUTH_FORM_HIDDEN_NONCE = TRUE,
            /**
             * AUTH LOCKER FEATURE
             * Protects Against Brute Force attacks
             * Make sure to set bcUAC::auth()->configModel()->tbl_auth_lock and columns
             * Default is TRUE
             * @var bool $AUTH_LOCKER 
             */
            $AUTH_LOCKER = TRUE,
            /**
             * AUTH LOCKER MAX ATTEMPS
             * If $AUTH_LOCKER is TRUE $AUTH_LOCKER_MAX_ATTEMPTS defines the maximum allowed times authentication
             * can fail before $AUTH_LOCKER_PENALTY_TIME starts
             * Int 0-99 Default is 5
             * @var int $AUTH_LOCKER_MAX_ATTEMPTS 
             */
            $AUTH_LOCKER_MAX_ATTEMPTS = 5,
            /**
             * AUTH LOCKER PENALTY TIME
             * If $AUTH_LOCKER is TRUE and $AUTH_LOCKER_MAX_ATTEMPTS reach its set limit, then  $AUTH_LOCKER_PENALTY_TIME
             * will prevent a new authentication until penalty time expires and resets
             * IF a new attempt is made, time restart counter
             * IF $AUTH_LOCKER_LOCK is TRUE then after $AUTH_LOCKER_MAX_ATTEMPTS limit is exceeded within a valid penalty time, authentication
             * is locked disregarding this timer feature.  
             * Int representing Seconds Default is 600 (10 min.)
             * @var int $AUTH_LOCKER_PENALTY_TIME 
             */
            $AUTH_LOCKER_PENALTY_TIME = 600,
            /**
             * AUTH LOCKER BRUTE FORCE TOLERANCE TIME
             * If $AUTH_LOCKER is TRUE and same IP attempts to login with multiple usernames within  tolerance time and reaches
             * $AUTH_LOCKER_BRUTE_FORCE_MAX_ATTEMPTS, then it will backlist IP
             * NOTE: the higher the time, the longer it will monitor against brute force.
             *  Int representing Seconds Default is  (30 min.)
             * @var int $AUTH_LOCKER_BRUTE_FORCE_TOLERANCE
             */
            $AUTH_LOCKER_BRUTE_FORCE_TOLERANCE = 1800,
            /**
             * AUTH LOCKER BRUTE FORCE MAX ATTEMPTS
             * If $AUTH_LOCKER is TRUE and same IP attempts to login with multiple usernames within max tolerance time and reaches
             * $AUTH_LOCKER_MAX_ATTEMPTS, then it will backlist IP
             * Int representing Max Attempts number, Default is 15
             * @var int $AUTH_LOCKER_BRUTE_FORCE_MAX_ATTEMPTS 
             */
            $AUTH_LOCKER_BRUTE_FORCE_MAX_ATTEMPTS = 15,
            /**
             * AUTH LOCKER LOCK
             * If $AUTH_LOCKER is TRUE and $AUTH_LOCKER_MAX_ATTEMPTS reach its set limit authentication is locked
             * until access permission is given.
             * TRUE if activate this feature, Default is TRUE
             * @var bool $AUTH_LOCKER_Ban 
             */
            $AUTH_LOCKER_LOCK = TRUE,
            /**
             * AUTH SECURE QUESTIONS
             * If TRUE, Auth System will request secure questions/asnwers pair from uac_auth 
             * secure answers. Min is 2 pairs, recommended is 3 and above, 2 are always displayed and requested
             * for validation and when > 2 then Auth System will ramdomly select 2.
             * If TRUE by no questions/asnwers pair found, 
             * bcUAC::auth()->signIn( $username, $password ) will return Code 9 = SET SECURE ANSWERS
             * If TRUE when it's 1st execution,  
             * bcUAC::auth()->signIn( $username, $password ) will return Code 10 = DISPLAY SECURE ANSWERS
             * If TRUE but answers did not match, 
             * bcUAC::auth()->signIn( $username, $password ) will return Code 11 = WRONG SECURE ANSWERS
             * @var bool $AUTH_SECURITY_QUESTIONS TRUE|FALSE
             */
            $AUTH_SECURITY_QUESTIONS = TRUE,
            /**
             * bcCrypt NAMESPACE
             * If using bcCrypt Library then set its namespace
             *  Default is NULL
             * @var string $BC_CRYPT_NS
             */
            $BC_CRYPT_NS = NULL,
            /**
             * AUTH REMEMBER 
             * Defines authentication will remember user and provide quicker sign in.
             * Int value is in Days, To deactivate this feature set to 0.
             * Default is 7 (Days)
             * @var int $REMEMBER 
             */
            $REMEMBER = 7,
            /**
             * bcUAC Session NAMESPACE
             * Default is AUTH if none was added during session initialization
             * Defaulr is 'NS_AUTH'
             * @var string $SESSION_NS
             */
            $SESSION_NS = 'NS_AUTH',
            /**
             * Auth Session Max Idle Time Before Expires for inactivity
             * Int value in seconds
             * Default is 600 (10 min)
             * @var int $MAX_IDLE_TIME 
             */
            $MAX_IDLE_TIME = 600,
            /**
             * AUTH DB STORAGE RESOURCE
             * If FALSE then built-in Model is used, use bcUAC->auth()->configModel() to setup Connection NS and table structure,
             * Otherwise must implement \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_Model from your Project's Logic\Model layer
             * Default FALSE
             * @var bool $STORAGE_RESOURCE
             */
            $STORAGE_RESOURCE = FALSE,
            /**
             * AUTH UNIQUE LOCATION
             * Defines if authentication is allowed from one unique location until remains valid.
             * While authenticated, if $UNIQUE_LOCATION is set to TRUE, it will not be possible for a new authentication.
             * Default TRUE
             * @var bool $UNIQUE_LOCATION 
             */
            $UNIQUE_LOCATION = TRUE,
            /**
             * AUTH USER ID TYPE
             * Defines the default user credential type for authentication
             * 1 = username (Default), 2 = email
             * Default 1
             * @var int $USER_ID_TYPE
             */
            $USER_ID_TYPE = 1,
            /**
             * AUTH VALID DOMAINS LIST
             * Defines if the authenticated user has permission to access the current domain
             * NOTE: Domains name must be DOMAIN_FQDN, when using subdomains, assign both for validation, ie:
             * mydomain.com, www.mydomain.com, name.domain.com are all treated as individual names.
             * Empty array if feature is deactivated, ARRAY( 'domainname.com' ) with all authorized domain access.
             * Default is array() empty
             * @var array $_VALID_DOMAINS
             */
            $_VALID_DOMAINS = array();
    private
            $step = 0;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
        bcFormControl::useNamespace( 'auth' );
    }

    /**
     * Login with Facebook Config
     * Set facebook configuration
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Facebook
     * @author Emily
     */
    public function facebook()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Facebook( __CLASS__ );
    }

    /**
     * Login with Google Config
     * Set facebook configuration
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Google
     * @author Emily
     */
    public function google()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Google( __CLASS__ );
    }

    /**
     * Login with Twitter Config
     * Set twitter configuration
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Twitter
     * @author Emily
     */
    public function twitter()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Twitter( __CLASS__ );
    }

    /**
     * Set Desired bcFormControl Template Style. 
     * Default values is 'default'
     * @param string $TEMPLATE
     * @author Emily
     */
    public function setTemplate( $TEMPLATE )
    {
        bcFormControl::$TEMPLATE = $TEMPLATE;
    }

    /**
     * Set Request URI to post form or ajax  
     * @param string $URI
     * @author Emily
     */
    public function request( $URI )
    {
        bcFormControl::uiWizard()->login()->REQUEST = $URI;
    }

    /**
     * Set form to TRUE to send post with form
     * FALSE to send it with ajax.
     * NULL to not include tag form in case you're already using it in your template             
     * When using ajax add our class to your button to trigger the post: '.bcFormControl-login-button'  
     * Default value is TRUE
     * @param type $FORM
     * @author Emily
     */
    public function form_markup( $FORM )
    {
        bcFormControl::uiWizard()->login()->FORM_MARKUP = $FORM;
    }

    /**
     * Buttons
     * To add multiple buttons use buttons mutiple times.
     * Set class 'bcFormControl-login-button' if bcUAC::auth()->config()->form() value is FALSE(ajax) to trigger the ajax to post
     * @param string $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param string $VALUE Button value
     * @param Array $_ATTRIBUTES Set Button attribites such as CLASS|ID|DATA-
     * @param boolean $SUBMIT Set to FALSE to use type button. TRUE type submit.
     * @author Emily
     */
    public function buttons( $IDENTIFIER, $VALUE, $_ATTRIBUTES, $SUBMIT )
    {
        bcFormControl::uiWizard()->login()->BUTTONS .= bcFormControl::types()->button()->getMarkup( $IDENTIFIER, $VALUE, $_ATTRIBUTES, $SUBMIT );
    }

    /**
     * Set Steps messages
     * To set messages use bcUAC Authentication Code as key and message as value.
     * Message only displays when Authentication Code match with the key.
     * CODES:
     * 0 = FIRST RUN
     * 1 = BAD HIDDEN VALIDATION when using bcUAC::auth()->config()->AUTH_FORM_HIDDEN_EMPTY and bcUAC::auth()->config()->authFormHiddenNonceName 
     * 2 = EMPTY OR MISSING USERNAME|PASSWORD 
     * 3 = WRONG USERNAME|PASSWORD 
     * 4 = AUTH LOCKED Too many failed attempts and bcUAC::auth()->config()->AUTH_LOCKER_LOCK is TRUE 
     * 5 = PENALTY TIME RESTARTED Max limit attempts exceeded and bcUAC::auth()->config()->AUTH_LOCKER_LOCK is FALSE so timer restarts
     * 6 = AUTH USER IS DEACTIVATED Auth Access is Deactivated
     * 7 = AUTH DOMAIN IS NOT WITHIN THE WHITELIST  bcUAC::auth()->config()->_VALID_DOMAINS[] = 'mydomain.com'
     * 8 = AUTH SESSION ACTIVE When using bcUAC::auth()->config()->UNIQUE_LOCATION TRUE and Auth Session is still active
     * 9 = IP BLACKLISTED
     * 10 = SET SECURE ANSWERS, USING FEATURE BUT NO QUESTIONS|ANSWERS FOUND IN DATABASE
     * 11 = DISPLAY SECURE ANSWERS
     * 12 = WRONG SECURE ANSWERS
     * @param array $_MESSAGES
     * @author Emily
     */
    public function messages( $_MESSAGES )
    {
        $login = bcFormControl::uiWizard()->login();
        $login->_MESSAGE = array();
        foreach ( $_MESSAGES as $key => $value ):
            $login->_MESSAGE[$key] = $value;
        endforeach;
    }

    /**
     * Set Step Configurations
     * @param array $_CODES Set all bcUAC Authentication Codes that this step will be shown
     * Step only displays when Authentication Code is found in array setted for this step.
     * CODES:
     * 0 = FIRST RUN
     * 1 = BAD HIDDEN VALIDATION when using bcUAC::auth()->config()->AUTH_FORM_HIDDEN_EMPTY and bcUAC::auth()->config()->authFormHiddenNonceName 
     * 2 = EMPTY OR MISSING USERNAME|PASSWORD 
     * 3 = WRONG USERNAME|PASSWORD 
     * 4 = AUTH LOCKED Too many failed attempts and bcUAC::auth()->config()->AUTH_LOCKER_LOCK is TRUE 
     * 5 = PENALTY TIME RESTARTED Max limit attempts exceeded and bcUAC::auth()->config()->AUTH_LOCKER_LOCK is FALSE so timer restarts
     * 6 = AUTH USER IS DEACTIVATED Auth Access is Deactivated
     * 7 = AUTH DOMAIN IS NOT WITHIN THE WHITELIST  bcUAC::auth()->config()->_VALID_DOMAINS[] = 'mydomain.com'
     * 8 = AUTH SESSION ACTIVE When using bcUAC::auth()->config()->UNIQUE_LOCATION TRUE and Auth Session is still active
     * 9 = IP BLACKLISTED
     * 10 = SET SECURE ANSWERS, USING FEATURE BUT NO QUESTIONS|ANSWERS FOUND IN DATABASE
     * 11 = DISPLAY SECURE ANSWERS
     * 12 = WRONG SECURE ANSWERS  
     * @param boolean $SOCIAL_BUTTONS Set to TRUE to display social button in this step
     * @author Emily
     */
    public function configStep( $_CODES, $SOCIAL_BUTTONS = FALSE )
    {
        $this->step++;
        $login = bcFormControl::uiWizard()->login();
        $login->configStep( $this->step, $SOCIAL_BUTTONS );
        if ( in_array( bcUAC::auth()->getReturnCode(), $_CODES ) ):
            $login->useStep( $this->step );
            $login->useMessage( bcUAC::auth()->getReturnCode() );
        endif;
    }

    /**
     * Set User Field
     * @param string $LABEL Set user label
     * @param string $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param array $_ATTRIBUTES Set Button attribites such as CLASS|ID|DATA-
     * @param boolean $CUSTOM Set to TRUE to use custom field instead of an input
     * @author Emily
     */
    public function user( $LABEL, $IDENTIFIER, $_ATTRIBUTES, $CUSTOM )
    {
        $login = bcFormControl::uiWizard()->login();
        $login->setMarkup( $LABEL );
        $login->setMarkup( bcFormControl::types()->text()->getMarkup( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM ) );
    }

    /**
     * Set Password Field
     * @param string $LABEL Set password label
     * @param string $IDENTIFIER  ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param array $_ATTRIBUTES Set Button attribites such as CLASS|ID|DATA-
     * @param boolean $CUSTOM Set to TRUE to use custom field instead of an input
     * @author Emily
     */
    public function password( $LABEL, $IDENTIFIER, $_ATTRIBUTES, $CUSTOM )
    {
        $login = bcFormControl::uiWizard()->login();
        $login->setMarkup( $LABEL );
        $login->setMarkup( bcFormControl::types()->password()->getMarkup( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM ) );
    }

    /**
     * Set Rememeber Field
     * @param string $LABEL Set remember label
     * @param string $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param array $_ATTRIBUTES Set Button attribites such as CLASS|ID|DATA-
     * @param boolean $CUSTOM Set to TRUE to use custom field instead of an input
     * @author Emily
     */
    public function remember( $LABEL, $IDENTIFIER, $_ATTRIBUTES, $CUSTOM )
    {
        if ( $this->REMEMBER ):
            bcFormControl::uiWizard()->login()->setMarkup( bcFormControl::types()->checkbox()->getMarkup( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM ) . $LABEL );
        endif;
    }

    /**
     * Set Security Answers Field
     * @param string $IDENTIFIER ATTR_NAME|ID|CLASS of HTML to reference with Javascript
     * @param array $_ATTRIBUTES Set Button attribites such as CLASS|ID|DATA-
     * @param boolean $CUSTOM Set to TRUE to use custom field instead of an input
     * @author Emily
     */
    public function securityAnswers( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM )
    {
        if ( $this->AUTH_SECURITY_QUESTIONS ):
            $login = bcFormControl::uiWizard()->login();
            $login->setMarkup( bcUAC::auth()->getSecurityQuestion() );
            $login->setMarkup( bcFormControl::types()->text()->getMarkup( $IDENTIFIER, $_ATTRIBUTES, $CUSTOM ) );
        endif;
    }

    /**
     * Types
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config\Types
     * @author Emily     
     */
    public static function types()
    {
        static $obj;
        return (object) $obj === $obj ? $obj : $obj = new Types( __CLASS__ );
    }

}
