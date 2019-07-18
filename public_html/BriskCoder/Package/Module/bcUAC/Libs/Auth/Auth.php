<?php

namespace BriskCoder\Package\Module\bcUAC\Libs;

use BriskCoder\bc,
    BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcUUID,
    BriskCoder\Package\Library\bcCrypt,
    BriskCoder\Package\Library\bcHTML,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\Config,
    BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel,
    BriskCoder\Package\Component\bcFormControl;

final class Auth
{

    private
            $_ns = array(),
            $currNS = NULL,
            $returnCode = 0,
            $failNumber = 0,
            $userAttributeName = 'username',
            $passAttributeName = 'password',
            $answerAttributeName = 'answer',
            $rememberAttributeName = 'remember';

    public function __construct( $CALLER )
    {var_dump($this->config()->STORAGE_RESOURCE);exit('here');
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * ADD USER
     * Add bcUAC::auth()->model()->uac_auth()
     * @param String $USER NN VARCHAR(45)
     * @param String $EMAIL NN VARCHAR(60)
     * @param String $PASS NN VARBINARY(40)
     * @param String $SECRET_ANSWERS TEXT
     * @param Integer $STATUS NN TINYINT(1)
     * @param Integer $LANGUAGE_ID NN UN INT(10) DEFAULT 0
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Interger|Boolean
     * @author Emily
     */
    public function addUser( $USER, $EMAIL, $PASS, $SECRET_ANSWERS, $STATUS, $LANGUAGE_ID, $RETURN_ID = FALSE )
    {
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns
        $_columns = array();
        $_columns[$authCol->user] = array( $USER, bcDB::TYPE_STRING );
        $_columns[$authCol->email] = array( $EMAIL, bcDB::TYPE_STRING );
        $_columns[$authCol->pass] = array( $PASS, bcDB::TYPE_STRING );
        $_columns[$authCol->secret_answers] = array( $SECRET_ANSWERS, bcDB::TYPE_STRING );
        $_columns[$authCol->status] = array( $STATUS, bcDB::TYPE_INTEGER );
        $_columns[$authCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$authCol->last_ip] = array( bc::registry()->CLIENT_IP, bcDB::TYPE_STRING );
        $_columns[$authCol->created] = array( time(), bcDB::TYPE_INTEGER );
        return $this->model()->uac_auth()->write( $_columns, $RETURN_ID );
    }

    /**
     * UPDATE USER
     * Update bcUAC::auth()->model()->uac_auth() columns value by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @param String $USER NN VARCHAR(45)
     * @param String $EMAIL NN VARCHAR(60)
     * @param String $PASS NN VARBINARY(40) 
     * @param String $SECRET_ANSWERS TEXT
     * @param Integer $STATUS NN TINYINT(1)
     * @param Integer $LANGUAGE_ID NN UN INT(10) DEFAULT 0
     * @return Boolean
     * @author Emily
     */
    public function updateUser( $ID, $USER, $EMAIL, $PASS, $SECRET_ANSWERS, $STATUS, $LANGUAGE_ID )
    {
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns
        $_columns = array();
        $_columns[$authCol->user] = array( $USER, bcDB::TYPE_STRING );
        $_columns[$authCol->email] = array( $EMAIL, bcDB::TYPE_STRING );
        $_columns[$authCol->pass] = array( $PASS, bcDB::TYPE_STRING );
        $_columns[$authCol->secret_answers] = array( $SECRET_ANSWERS, bcDB::TYPE_STRING );
        $_columns[$authCol->status] = array( $STATUS, bcDB::TYPE_INTEGER );
        $_columns[$authCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$authCol->last_ip] = array( bc::registry()->CLIENT_IP, bcDB::TYPE_STRING );
        $_columns[$authCol->modified] = array( time(), bcDB::TYPE_INTEGER );
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, FALSE, NULL );
        return $this->model()->uac_auth()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * DELETE USER
     * Delete  bcUAC::auth()->model()->uac_auth() by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Boolean
     * @author Emily
     */
    public function deleteUser( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth()->delete( $_filters, array(), NULL );
    }

    /**
     * GET USER
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getUser( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->user;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->user];
    }

    /**
     * GET USER EMAIL
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getUserEmail( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->email;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->email];
    }

    /**
     * GET USER STATUS
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getUserStatus( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->status;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->status];
    }

    /**
     * GET USER LANGUAGE ID
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getUseLanguageID( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->language_id;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->language_id];
    }

    /**
     * IS USER ONLINE
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function isUserOnline( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->online;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->online];
    }

    /**
     * GET USER LAST IP
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getUserLastIP( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->last_ip;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->last_ip];
    }

    /**
     * GET USER LAST ACTIVITY
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getUserLastActivity( $ID )
    {
        $authCol = $this->configModel()->uac_auth();
        $_columns = array();
        $_columns[] = $authCol->last_activity;
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authCol->last_activity];
    }

    /**
     * GET USER BY ID
     * Get all bcUAC::auth()->model()->uac_auth() columns by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getUserByID( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth()->read( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET USERS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Defalt array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getUsers( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_auth()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * GET TOTAL USERS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @return Integer
     * @author Emily
     */
    public function getTotalUsers( $_FILTERS = array(), $_ORDER_BY = array() )
    {
        $_columns = array();
        $_columns[] = 'COUNT(' . $this->configModel()->uac_auth()->id . ') as total';
        return $this->model()->uac_auth()->read( FALSE, $_columns, $_FILTERS, $_ORDER_BY, NULL );
    }

    /**
     * ADD QUESTION
     * Add bcUAC::auth()->model()->uac_auth_questions()
     * @param Integer $LANGUAGE_ID NN UN INT(10)
     * @param String $QUESTION VARCHAR(255)
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addQuestion( $LANGUAGE_ID, $QUESTION, $RETURN_ID = FALSE )
    {
        $authQuestionsCol = $this->configModel()->uac_auth_questions(); //assign Auth Questions Model Columns
        $_columns = array();
        $_columns[$authQuestionsCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$authQuestionsCol->question] = array( $QUESTION, bcDB::TYPE_STRING );
        return $this->model()->uac_auth_questions()->write( $_columns, $RETURN_ID );
    }

    /**
     * UPDATE QUESTION
     * Update bcUAC::auth()->model()->uac_auth_questions() columns value by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @param Integer $LANGUAGE_ID NN UN INT(10)
     * @param String $QUESTION VARCHAR(255)
     * @return Boolean
     * @author Emily
     */
    public function updateQuestion( $ID, $LANGUAGE_ID, $QUESTION )
    {
        $authQuestionsCol = $this->configModel()->uac_auth_questions(); //assign Auth Questions Model Columns
        $_columns = array();
        $_columns[$authQuestionsCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$authQuestionsCol->question] = array( $QUESTION, bcDB::TYPE_STRING );
        $_filters = array();
        $_filters[$authQuestionsCol->id] = array( '=', $ID, FALSE, NULL );
        return $this->model()->uac_auth_questions()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * DELETE QUESTION
     * Delete bcUAC::auth()->model()->uac_auth_questions() by id
     * @param Integer $ID PK NN UN AI BIGINT(20) 
     * @return Boolean
     * @author Emily
     */
    public function deleteQuestion( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth_questions()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth_questions()->delete( $_filters, array(), NULL );
    }

    /**
     * GET QUESTION
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getQuestion( $ID )
    {
        $authQuestionsCol = $this->configModel()->uac_auth_questions(); //assign Auth Questions Model Columns
        $_columns = array();
        $_columns[] = $authQuestionsCol->question;
        $_filters = array();
        $_filters[$authQuestionsCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_questions()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authQuestionsCol->question];
    }

    /**
     * GET QUESTION BY ID
     * Get all bcUAC::auth()->model()->uac_auth_questions() columns by id
     * @param Integer $ID PK NN UN AI BIGINT(20) 
     * @return String
     * @author Emily
     */
    public function getQuestionByID( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth_questions()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth_questions()->read( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET QUESTIONS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getQuestions( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_auth_questions()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * GET TOTAL QUESTIONS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @return Integer
     * @author Emily
     */
    public function getTotalQuestions( $_FILTERS = array(), $_ORDER_BY = array() )
    {
        $_columns = array();
        $_columns[] = 'COUNT(' . $this->configModel()->uac_auth_questions()->id . ') as total';
        return $this->model()->uac_auth_questions()->read( FALSE, $_columns, $_FILTERS, $_ORDER_BY, NULL );
    }

    /**
     * ADD LOCK
     * Add bcUAC::auth()->model()->uac_auth_lock()
     * @param String $IP VARCHAR(45)
     * @param String $USERNAME VARCHAR(60)
     * @param Integer $LOCKED TINYINT(1)
     * @param Integer $IP_BLACKLIST TINYINT(1)
     * @param Boolean $RETURN_ID Default FALSE
     * @return Boolean
     * @author Emily
     */
    public function addLock( $IP, $USERNAME, $LOCKED, $IP_BLACKLIST, $RETURN_ID = FALSE )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[$authLockCol->ip] = array( $IP, bcDB::TYPE_STRING );
        $_columns[$authLockCol->username] = array( $USERNAME, bcDB::TYPE_STRING );
        $_columns[$authLockCol->locked] = array( $locked, bcDB::TYPE_INTEGER );
        $_columns[$authLockCol->ip_blacklist] = array( $IP_BLACKLIST, bcDB::TYPE_INTEGER );
        return $this->model()->uac_auth_lock()->write( $_columns, $RETURN_ID );
    }

    /**
     * DELETE LOCK
     * Delete bcUAC::auth()->model()->uac_auth_lock() by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Boolean
     * @author Emily
     */
    public function deleteLock( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth_lock()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth_lock()->delete( $_filters, array(), NULL );
    }

    /**
     * GET LOCK USERNAME
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getLockUsername( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->username;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->username];
    }

    /**
     * GET LOCK BROWSER
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getLockBrowser( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->browser;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->browser];
    }

    /**
     * GET LOCK ATTEMPTS
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getLockAttempts( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->attempts;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->attempts];
    }

    /**
     * GET LOCK LOCKED STATUS
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getLockLockedStatus( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->locked;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->locked];
    }

    /**
     * GET LOCK IP BLACKLIST STATUS
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getLockIPblackListStatus( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->ip_blacklist;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->ip_blacklist];
    }

    /**
     * GET LOCK LAST ATTEMPT
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     * @author Emily
     */
    public function getLockLastAttempt( $ID )
    {
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $_columns = array();
        $_columns[] = $authLockCol->last_attempt;
        $_filters = array();
        $_filters[$authLockCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$authLockCol->last_attempt];
    }

    /**
     * GET LOCKS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getLocks( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_auth_lock()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * GET TOTAL LOCKS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @return Integer
     * @author Emily
     */
    public function getTotalLocks( $_FILTERS = array(), $_ORDER_BY = array() )
    {
        $_columns = array();
        $_columns[] = 'COUNT(' . $this->configModel()->uac_auth_lock()->id . ') as total';
        return $this->model()->uac_auth_lock()->read( FALSE, $_columns, $_FILTERS, $_ORDER_BY, NULL );
    }

    /**
     * Retuns the Authentication Code
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
     * @return int 
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Retuns the Authentication Attempt Fail Number
     * Fail Number always returns 0 if bcUAC::auth()->config()->AUTH_LOCKER is FALSE
     * @return int 
     */
    public function getFailNumber()
    {
        return $this->failNumber;
    }

    /**
     * AUTH CHECK IF CLIENT IS LOGGED IN
     * @return bool TRUE|FALSE
     */
    public function isLoggedIn()
    {
        $cfg = $this->config(); //assign Auth Config Object
        $model = $this->model(); //assign Auth Model Object
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns
        $sess = bcUAC::session(); //assin Auth Session Object
        $sess->useNamespace( $cfg->SESSION_NS );
        //runs Auth Locker clearMode if active
        $this->runAuthLocker( NULL, TRUE );

        if ( isset( $sess->_AUTH_QUESTIONS ) ):
            return FALSE;
        endif;

        //check if client session exists
        if ( (isset( $sess->AUTH ) && ($sess->AUTH === 'AUTHORIZED')) && isset( $sess->AUTH_LAST_ACTIVITY ) ):
            if ( isset( $sess->AUTH_USER_ID ) || isset( $sess->AUTH_SOCIAL ) ):
                //has been iddle?
                if ( ((int) $_SERVER['REQUEST_TIME'] - $sess->AUTH_LAST_ACTIVITY) > $cfg->MAX_IDLE_TIME ):
                    //logout
                    if ( isset( $sess->AUTH_USER_ID ) ):
                        $_columns = array();
                        $_columns[$authCol->online] = array( 0, bcDB::TYPE_INTEGER );
                        $_columns[$authCol->last_activity] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
                        $_filters = array();
                        $_filters[$authCol->id] = array( '=', $sess->AUTH_USER_ID, bcDB::TYPE_INTEGER, NULL );
                        $model->uac_auth()->update( $_columns, $_filters, array(), NULL );
                    endif;
                    $sess->destroy();
                    return FALSE;
                endif;
                /* TODO: All of the other social validation
                 * Check if user social tokens are still valid and if fails logout */
                if ( isset( $sess->AUTH_USER_ID ) ):
                    $_columns = array();
                    $_columns[$authCol->last_activity] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
                    $_filters = array();
                    $_filters[$authCol->id] = array( '=', $sess->AUTH_USER_ID, bcDB::TYPE_INTEGER, NULL );
                    $model->uac_auth()->update( $_columns, $_filters, array(), NULL );
                endif;
                $sess->AUTH_LAST_ACTIVITY = (int) $_SERVER['REQUEST_TIME'];
                return TRUE; //success
            endif;
        endif;

        //if remember is deactivated  expires cookies previously set
        if ( !$cfg->REMEMBER ):
            if ( isset( $_COOKIE[$sess->name() . '_AC'] ) ):
                $cookieExpire = (int) $_SERVER['REQUEST_TIME'] - 19999999;
                $_c = session_get_cookie_params();
                setcookie( $sess->name() . '_AC', NULL, $cookieExpire, $_c['path'], $_c['domain'], $_c['secure'], TRUE );
            endif;
            return FALSE;
        endif;

        return FALSE;
    }

    /**
     * GET SECURITY FORM HIDDEN FIELDS
     * When using AUTH_FORM_HIDDEN_EMPTY | AUTH_FORM_HIDDEN_NONCE  it returns the input hidden filled with hashed data
     * @return String Form Hidden Fields
     */
    public function getHiddenFields()
    {
        $sess = bcUAC::session();
        $sess->useNamespace( $this->config()->SESSION_NS );

        if ( $this->config()->AUTH_FORM_HIDDEN_EMPTY === TRUE ):
            $sess->AUTH_HIDDEN_EMPTY = base64_encode( bcUUID::v4() );
            $_attributes = array(
                'name="' . $sess->AUTH_HIDDEN_EMPTY . '"',
                'value=""'
            );
            bcHTML::form()->hidden( $_attributes );
        endif;

        if ( $this->config()->AUTH_FORM_HIDDEN_NONCE === TRUE ):
            $sess->AUTH_NONCE = base64_encode( bcUUID::v4() );
            $sess->AUTH_HIDDEN_NONCE = base64_encode( md5( $sess->AUTH_NONCE ) );
            $_attributes = array(
                'name="' . $sess->AUTH_HIDDEN_NONCE . '"',
                'value="' . $sess->AUTH_NONCE . '"'
            );
            bcHTML::form()->hidden( $_attributes );
        endif;

        return bcHTML::form()->getMarkup();
    }

    /**
     * 
     * 
     * @return string Javascript code that validates active session or log user off
     */
    public function getIdleValidationCode()
    {
        
    }

    /**
     * DEFINES CREDENTIALS FORM FIELDS ATTRIBUTE NAME FOR SIGN IN PROCCESS 
     * @param String $USER_ATTRIBUTE_NAME Username Form Field Attribute Name | Default: username
     * @param String $PASS_ATTRIBUTE_NAME Password Form Field Attribute Name | Default: password
     * @param String $ANSWER_ATTRIBUTE_NAME Security Question Answer Form Field Attribute Name | Default: answer
     * @param String $REMEMBER_ATTRIBUTE_NAME Remember Form Field Attribute Name | Default: remember
     * @return Void 
     */
    public function setAttributeName( $USER_ATTRIBUTE_NAME, $PASS_ATTRIBUTE_NAME, $ANSWER_ATTRIBUTE_NAME, $REMEMBER_ATTRIBUTE_NAME )
    {
        if ( !empty( $USER_ATTRIBUTE_NAME ) ):
            $this->userAttributeName = $USER_ATTRIBUTE_NAME;
        endif;

        if ( !empty( $PASS_ATTRIBUTE_NAME ) ):
            $this->passAttributeName = $PASS_ATTRIBUTE_NAME;
        endif;

        if ( !empty( $ANSWER_ATTRIBUTE_NAME ) ):
            $this->answerAttributeName = $ANSWER_ATTRIBUTE_NAME;
        endif;

        if ( !empty( $REMEMBER_ATTRIBUTE_NAME ) ):
            $this->rememberAttributeName = $REMEMBER_ATTRIBUTE_NAME;
        endif;
    }

    /**
     * GETS SECURITY QUESTION STRING 
     * Gets Random Security Question
     * @return String 
     */
    public function getSecurityQuestion()
    {
        $sess = bcUAC::session(); //assin Auth Session Object
        $sess->useNamespace( $this->config()->SESSION_NS );

        if ( !isset( $sess->_AUTH_QUESTIONS ) ):
            return NULL;
        endif;

        return $sess->AUTH_CURR_QUESTION = array_rand( $sess->_AUTH_QUESTIONS, 1 );
    }

    /**
     * @param string $USERNAME Auth User
     * @param bool $CLEAR_MODE If true, only clears old records, except bans and locks Default is FALSE
     * This method returns TRUE when returnCode needs to be externally specified after the method execution,
     * otherwise FALSE and returnCode is already read mode with the proper code value set
     * @return bool TRUE|FALSE 
     */
    private function runAuthLocker( $USERNAME, $CLEAR_MODE = FALSE )
    {

        $cfg = $this->config(); //assign Auth Config Object
        if ( !$cfg->AUTH_LOCKER ):
            return TRUE;
        endif;


        $model = $this->model(); //assign Auth Model Object
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns
        $reg = bc::registry(); //assign BC Registry Object

        if ( $CLEAR_MODE ):
            $_filters = array();
            $_filters[$authLockCol->last_attempt] = array( '<', ($_SERVER['REQUEST_TIME'] - $cfg->AUTH_LOCKER_PENALTY_TIME), bcDB::TYPE_INTEGER, 'AND' );
            $_filters[$authLockCol->locked] = array( '!=', 1, bcDB::TYPE_INTEGER, 'AND' );
            $_filters[$authLockCol->ip_blacklist] = array( '!=', 1, bcDB::TYPE_INTEGER, NULL );
            $model->uac_auth_lock()->delete( $_filters, array(), NULL );
            return TRUE;
        endif;

        //check IP is blacklisted
        $_columns = array();
        $_columns[] = $authLockCol->id;
        $_filters = array();
        $_filters[$authLockCol->ip] = array( '=', $reg->CLIENT_IP, bcDB::TYPE_STRING, 'AND' );
        $_filters[$authLockCol->ip_blacklist] = array( '=', 1, bcDB::TYPE_INTEGER, NULL );

        if ( $model->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL ) ):
            $this->returnCode = 9;
            $this->failNumber = 1; //Fail number
            return FALSE;
        endif;

        //check ip spamming activity against max tolerance
        $_columns = array();
        $_columns[] = 'SUM(' . $authLockCol->attempts . ') AS ' . $authLockCol->attempts;
        $_filters = array();
        $_filters[$authLockCol->ip] = array( '=', $reg->CLIENT_IP, bcDB::TYPE_STRING, 'AND' );
        $_filters[$authLockCol->last_attempt] = array( '>=', ($_SERVER['REQUEST_TIME'] - $cfg->AUTH_LOCKER_BRUTE_FORCE_TOLERANCE ), bcDB::TYPE_INTEGER, NULL );
        $_tolerance = $model->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        if ( $_tolerance[$authLockCol->attempts] >= $cfg->AUTH_LOCKER_BRUTE_FORCE_MAX_ATTEMPTS ):
            $_filters = array();
            $_filters[$authLockCol->ip] = array( '=', $reg->CLIENT_IP, bcDB::TYPE_INTEGER, NULL );
            $model->uac_auth_lock()->delete( $_filters, array(), NULL ); //cleanup all occurrencies            
            //add blacklist

            $_columns[$authLockCol->ip] = array( $reg->CLIENT_IP, bcDB::TYPE_STRING );
            $_columns[$authLockCol->username] = array( $USERNAME, bcDB::TYPE_STRING );
            $_columns[$authLockCol->browser] = array( $reg->USER_AGENT, bcDB::TYPE_STRING );
            $_columns[$authLockCol->attempts] = array( 1, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->locked] = array( 1, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->ip_blacklist] = array( 1, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->last_attempt] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
            $model->uac_auth_lock()->write( $_columns, FALSE );

            $this->returnCode = 9;
            $this->failNumber = 1; //Fail number
            return FALSE;
        endif;


        $_columns = array();
        $_columns[] = $authLockCol->id;
        $_columns[] = $authLockCol->ip;
        $_columns[] = $authLockCol->username;
        $_columns[] = $authLockCol->browser;
        $_columns[] = $authLockCol->attempts;
        $_columns[] = $authLockCol->locked;
        $_columns[] = $authLockCol->ip_blacklist;
        $_columns[] = $authLockCol->last_attempt;
        $_filters = array();
        $_filters[$authLockCol->ip] = array( '=', $reg->CLIENT_IP, bcDB::TYPE_STRING, 'AND' );
        $_filters[$authLockCol->username] = array( '=', $USERNAME, bcDB::TYPE_INTEGER, NULL );
        $_authLocker = $model->uac_auth_lock()->read( FALSE, $_columns, $_filters, array(), NULL );
        if ( !$_authLocker )://add 1st time
            $_columns = array();
            $_columns[$authLockCol->ip] = array( $reg->CLIENT_IP, bcDB::TYPE_STRING );
            $_columns[$authLockCol->username] = array( $USERNAME, bcDB::TYPE_STRING );
            $_columns[$authLockCol->browser] = array( $reg->USER_AGENT, bcDB::TYPE_STRING );
            $_columns[$authLockCol->attempts] = array( 1, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->locked] = array( 0, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->ip_blacklist] = array( 0, bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->last_attempt] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
            $model->uac_auth_lock()->write( $_columns, FALSE );
            return TRUE;
        endif;

        //check if client exceeded max attempts and is banned
        if ( (int) $_authLocker[$authLockCol->locked] === 1 ):
            $this->returnCode = 4;
            return FALSE;
        endif;

        //check authLockerPenaltyTime still valid then restart penalty time
        if ( ($_SERVER['REQUEST_TIME'] - $_authLocker[$authLockCol->last_attempt] ) < $cfg->AUTH_LOCKER_PENALTY_TIME ):
            //check attempt number against max attempts allowed
            if ( $_authLocker[$authLockCol->attempts] < $cfg->AUTH_LOCKER_MAX_ATTEMPTS ):
                //update attempts and return code 2

                $_columns = array();
                $_columns[$authLockCol->browser] = array( $reg->USER_AGENT, bcDB::TYPE_STRING );
                $_columns[$authLockCol->attempts] = array( $authLockCol->attempts . ' + 1 ', bcDB::TYPE_INTEGER );
                $_columns[$authLockCol->last_attempt] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
                $_filters = array();
                $_filters[$authLockCol->id] = array( '=', $_authLocker[$authLockCol->id], bcDB::TYPE_INTEGER, NULL );
                $model->uac_auth_lock()->update( $_columns, $_filters, array(), NULL );
                $this->failNumber = $_authLocker[$authLockCol->attempts] + 1; //Fail number
                return TRUE;
            endif;

            //max attempts exceeded, manage lock
            if ( $cfg->AUTH_LOCKER_LOCK === TRUE ):
                //is AUTH_LOCKER_LOCK is TRUE auth is locked afer AUTH_LOCKER_MAX_ATTEMPTS
                $_columns = array();
                $_columns[$authLockCol->attempts] = array( $authLockCol->attempts . ' + 1 ', bcDB::TYPE_INTEGER );
                $_columns[$authLockCol->locked] = array( 1, bcDB::TYPE_INTEGER );
                $_columns[$authLockCol->last_attempt] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
                $_filters = array();
                $_filters[$authLockCol->id] = array( '=', $_authLocker[$authLockCol->id], bcDB::TYPE_INTEGER, NULL );
                $model->uac_auth_lock()->update( $_columns, $_filters, array(), NULL );
                $this->returnCode = 4;
                $this->failNumber = $_authLocker[$authLockCol->attempts] + 1; //Fail number
                return FALSE;
            endif;
            //otherwise updates penalty time and fails
            $_columns = array();
            $_columns[$authLockCol->browser] = array( $reg->USER_AGENT, bcDB::TYPE_STRING );
            $_columns[$authLockCol->attempts] = array( $authLockCol->attempts . ' + 1 ', bcDB::TYPE_INTEGER );
            $_columns[$authLockCol->last_attempt] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
            $_filters = array();
            $_filters[$authLockCol->id] = array( '=', $_authLocker[$authLockCol->id], bcDB::TYPE_INTEGER, NULL );
            $model->uac_auth_lock()->update( $_columns, $_filters, array(), NULL );
            $this->returnCode = 5;
            $this->failNumber = $_authLocker[$authLockCol->attempts] + 1; //Fail number
            return FALSE;
        endif;

        return TRUE;
    }

    /**
     * Save Auth Security Answers
     * @param integer $AUTH_ID uac_auth_id
     * @param array $_ANSWERS  Array containing Pair Value of Security Questions ID and Answers Value
     * @return boolean
     */
    public function saveSecurityAnswers( $AUTH_ID, array $_ANSWERS )
    {
        if ( empty( $_ANSWERS ) ):
            return FALSE;
        endif;

        if ( bcCrypt::hasNamespace( $cfg->BC_CRYPT_NS ) ):
            bcCrypt::useNamespace( bc::registry()->cryptNS );
            $_ANSWERS = bcCrypt::encrypt( $_ANSWERS );
        else:
            $_ANSWERS = base64_encode( json_encode( $_ANSWERS ) );
        endif;

        $model = $this->model(); //assign Auth Model Object
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns

        $_columns = array();
        $_columns[$authCol->secret_answers] = array( $_ANSWERS, bcDB::TYPE_STRING );
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $AUTH_ID, bcDB::TYPE_INTEGER, NULL );
        $model->uac_auth()->update( $_columns, $_filters, array(), NULL );

        return TRUE;
    }

    /**
     * AUTHENTICATE USER
     * TIP: To implement custom error messages, logs or custom authentication steps, use bcUAC::auth()->getReturnCode() according to error types.<br>
     * IMPORTANT: <br>
     * Note that 'username' check is defined by bcUAC::auth()->config()->USER_ID_TYPE
     * when USER_ID_TYPE = 1 posted username will be verified against username db column otherwise email column<br>
     * When return is FALSE, just test bcUAC::auth()->getReturnCode() and diplay the auth form.
     * @return bool  TRUE|FALSE
     */
    public function signIn()
    {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ):
            return FALSE;
        endif;

        $this->returnCode = 0; //reset fail code
        $this->failNumber = 0; //reset fail number getter

        $cfg = $this->config(); //assign Auth Config Object
        $model = $this->model(); //assign Auth Model Object
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns
        $authLockCol = $this->configModel()->uac_auth_lock(); //assign Auth Lock Model Columns

        $sess = bcUAC::session(); //assin Auth Session Object
        $sess->useNamespace( $cfg->SESSION_NS );
        $sess->AUTH_LAST_ACTIVITY = (int) $_SERVER['REQUEST_TIME'];

        /**
         * SOCIAL MEDIA LOGIN 
         * Manage social media login
         * @author Emily
         */
        if ( isset( $_POST['app'] ) ):
            /* Inside each social class it will have its methods available to get the user infromation and other requests to the api using tokens stored in session.
             * The most important method to check is the user status, if users is logged in social media or not. If user is not logged in, log user out from software. */
            switch ( $_POST['app'] ):
                case 'facebook':
                    if ( $_POST['response'] !== 'false' ):
                        $_json = array();
                        $sess->AUTH_SOCIAL = array( 'app' => $_POST['app'], 'access_token' => $_POST['access_token'], 'signed_request' => $_POST['signed_request'] );
                        $sess->AUTH = 'AUTHORIZED'; /* auth ok status */
                        $sess->regenerateID( TRUE );
                        $_json['redirect'] = $_POST['redirect'];
                        exit( json_encode( $_json ) );
                    endif;
                    /* User denied software to login with facebook. */
                    break;
                case 'google':
                    if ( $_POST['response'] !== 'false' ):
                        $_json = array();
                        $sess->AUTH_SOCIAL = array( 'app' => $_POST['app'], 'id_token' => $_POST['id_token'] );
                        $sess->AUTH = 'AUTHORIZED'; /* auth ok status */
                        $sess->regenerateID( TRUE );
                        $_json['redirect'] = $_POST['redirect'];
                        exit( json_encode( $_json ) );
                    endif;
                    /* User denied software to login with google account. */
                    break;
                case 'twitter':
                    if ( $_POST['response'] !== 'false' ):
                        /* First store oauth_token and oauth_token_secret to use later
                         * Second get oauth_token and oauth_verifier compare oauth_token from post and oauth_token from session and then  
                         * Make Step 3: Converting the request token to an access token,
                         * and override session with 'oauth_token', 'oauth_token_secret' into a session */
                        $_json = array();
                        if ( isset( $_POST['oauth_token'] ) && isset( $_POST['oauth_token_secret'] ) ):
                            $sess->AUTH_SOCIAL = array( 'app' => $_POST['app'], 'oauth_token' => $_POST['oauth_token'], 'oauth_token_secret' => $_POST['oauth_token_secret'] );
                        endif;
                        if ( isset( $_POST['oauth_token'] ) && isset( $_POST['oauth_verifier'] ) ):
                            if ( $sess->AUTH_SOCIAL['oauth_token'] == $_POST['oauth_token'] ):
                                $twitterComponent = bcFormControl::uiWizard()->login()->twitter();
                                $randomStr = 'abcdefghijklmnopqrstuvwxyz0123456789';
                                $randomStrLength = strlen( $randomStr );
                                $random_str = '';
                                for ( $i = 0; $i < $randomStrLength; $i++ ):
                                    $random_str .= $randomStr[rand( 0, strlen( $randomStr ) - 1 )];
                                endfor;
                                $_oauth = array(
                                    'oauth_consumer_key' => $twitterComponent->CONSUMER_KEY,
                                    'oauth_token' => $sess->AUTH_SOCIAL['oauth_token'],
                                    'oauth_nonce' => base64_encode( $random_str ),
                                    'oauth_signature_method' => 'HMAC-SHA1',
                                    'oauth_timestamp' => time(),
                                    'oauth_version' => '1.0'
                                );
                                $baseURI = 'https://api.twitter.com/oauth/access_token';
                                $_baseString = array();
                                ksort( $_oauth );
                                foreach ( $_oauth as $key => $value ):
                                    $_baseString[] = "$key=" . rawurlencode( $value );
                                endforeach;
                                $hash_hmac_post = 'POST&' . rawurlencode( $baseURI ) . '&' . rawurlencode( implode( '&', $_baseString ) );
                                $hash_hmac_secret = rawurlencode( $twitterComponent->CONSUMER_SECRET ) . '&' . rawurlencode( null );
                                $hash_hmac = hash_hmac( 'sha1', $hash_hmac_post, $hash_hmac_secret, true );
                                $oauth_signature = base64_encode( $hash_hmac );
                                $_oauth['oauth_signature'] = $oauth_signature;
                                $_oauth['oauth_verifier'] = $_POST['oauth_verifier'];
                                $authHeader = 'Authorization: OAuth ';
                                $_values = array();
                                foreach ( $_oauth as $key => $value )
                                    $_values[] = "$key=\"" . rawurlencode( $value ) . "\"";
                                $authHeader .= implode( ', ', $_values );
                                $_options = array(
                                    CURLOPT_HTTPHEADER => array( $authHeader, 'Expect:' ),
                                    CURLOPT_HEADER => FALSE,
                                    CURLOPT_URL => $baseURI,
                                    CURLOPT_POST => TRUE,
                                    CURLOPT_RETURNTRANSFER => TRUE,
                                    CURLOPT_SSL_VERIFYPEER => FALSE
                                );
                                $ch = curl_init();
                                curl_setopt_array( $ch, $_options );
                                $response = curl_exec( $ch );
                                curl_close( $ch );
                                $request = $response;
                                $_request = explode( '&', $request );
                                $_response = array();
                                foreach ( $_request as $value ):
                                    $_v = explode( '=', $value );
                                    if ( $_v[0] !== 'oauth_token' && $_v[0] !== 'oauth_token_secret' ):
                                        continue;
                                    endif;
                                    $_response[$_v[0]] = $_v[1];
                                endforeach;
                                $sess->AUTH_SOCIAL = array( 'app' => 'twitter', 'oauth_token' => $_response['oauth_token'], 'oauth_token_secret' => $_response['oauth_token_secret'] );
                                $sess->AUTH = 'AUTHORIZED'; /* auth ok status */
                                $sess->regenerateID( TRUE );
                                $_json['redirect'] = $_POST['redirect'];
                            endif;
                        endif;
                        exit( json_encode( $_json ) );
                    endif;
                    /* User denied software to login with twitter. */
                    break;
            endswitch;
        endif;
        /* END SOCIAL MEDIA LOGIN */

        $reg = bc::registry(); //assign BC Registry Object
        //hidden fields validation against CSRF?       
        if ( $cfg->AUTH_FORM_HIDDEN_EMPTY && isset( $sess->AUTH_HIDDEN_EMPTY ) ):
            if ( !isset( $_POST[$sess->AUTH_HIDDEN_EMPTY] ) ||
                    ($_POST[$sess->AUTH_HIDDEN_EMPTY] !== '') ):
                $this->returnCode = 1; //BAD HIDDEN VALIDATION
                return FALSE;
            endif;
        endif;

        if ( $cfg->AUTH_FORM_HIDDEN_NONCE && isset( $sess->AUTH_HIDDEN_NONCE ) ):
            if ( empty( $_POST[$sess->AUTH_HIDDEN_NONCE] ) ||
                    ($_POST[$sess->AUTH_HIDDEN_NONCE] !== $sess->AUTH_NONCE) ):
                $this->returnCode = 1; //BAD HIDDEN VALIDATION
                return FALSE;
            endif;
        endif;

        //check if security answers are in use and posted
        if ( isset( $sess->_AUTH_QUESTIONS ) && (!empty( $sess->_AUTH_QUESTIONS )) ):
            unset( $sess->AUTH_REMEMBER );
            if ( !isset( $_POST[$this->answerAttributeName] ) || ($_POST[$this->answerAttributeName] !== $sess->_AUTH_QUESTIONS[$sess->AUTH_CURR_QUESTION]) ):
                if ( isset( $_POST[$this->rememberAttributeName] ) ):
                    $sess->AUTH_REMEMBER = TRUE;
                endif;

                //run auth_lock checks
                if ( $this->runAuthLocker( $sess->AUTH_USERNAME ) ):
                    $this->returnCode = 12; //WRONG SECURE ANSWERS;
                endif;
                return FALSE;
            //continue to //finally SIGN IN
            endif;
        endif;

        //run auth stage 1 when not testing questions
        if ( !isset( $sess->_AUTH_QUESTIONS ) )://AUTH_USERNAME is only set while processing securty questions
            //validate credentials          
            $username = isset( $_POST[$this->userAttributeName] ) ? trim( $_POST[$this->userAttributeName] ) : NULL;
            $password = isset( $_POST[$this->passAttributeName] ) ? trim( $_POST[$this->passAttributeName] ) : NULL;
            if ( ($username == NULL) || ($password == NULL) ):
                $this->returnCode = 2; //EMPTY OR MISSING USERNAME|PASSWORD 
                return FALSE;
            endif;

            //Check if USER_ID_TYPE is username | email and retrieve data
            $_columns = array();
            $_columns[] = $authCol->id;
            $_columns[] = $authCol->user;
            $_columns[] = $authCol->email;
            $_columns[] = $authCol->pass;
            $_columns[] = $authCol->token;
            $_columns[] = $authCol->secret_answers;
            $_columns[] = $authCol->status;
            $_columns[] = $authCol->language_id;
            $_columns[] = $authCol->online;
            $_columns[] = $authCol->last_ip;
            $_columns[] = $authCol->last_activity;
            $_columns[] = $authCol->created;
            $_columns[] = $authCol->modified;
            $_name_filters = array();
            $_name_filters[$authCol->user] = array( '=', $username, bcDB::TYPE_STRING, 'AND' );
            $_name_filters[$authCol->pass] = array( '=', sha1( $password ), bcDB::TYPE_STRING, NULL );
            $getuserbyname = $model->uac_auth()->read( FALSE, $_columns, $_name_filters, array(), NULL );
            $_email_filters = array();
            $_email_filters[$authCol->email] = array( '=', $username, bcDB::TYPE_STRING, 'AND' );
            $_email_filters[$authCol->pass] = array( '=', sha1( $password ), bcDB::TYPE_STRING, NULL );
            $getuserbyemail = $model->uac_auth()->read( FALSE, $_columns, $_email_filters, array(), NULL );

            $_user = $cfg->USER_ID_TYPE ?
                    $getuserbyname :
                    $getuserbyemail;

            //Auth Failed
            if ( empty( $_user ) ):
                //run auth_lock checks
                if ( $this->runAuthLocker( $username ) ):
                    $this->returnCode = 3; //WRONG USERNAME|PASSWORD 
                endif;
                return FALSE;
            endif;

            //check if auth user is active
            if ( (int) $_user[$authCol->status] === 0 ):
                $this->returnCode = 6; //Auth user is deactivated
                return FALSE;
            endif;

            //check if is already signed in if $cfg->UNIQUE_LOCATION is TRUE
            if ( $cfg->UNIQUE_LOCATION &&
                    ((int) $_user[$authCol->online] === 1) &&
                    (($_user[$authCol->last_activity] + $cfg->MAX_IDLE_TIME) > $_SERVER['REQUEST_TIME']) ):
                $this->returnCode = 8; //Auth session already active
                return FALSE;
            endif;

            //validate user against Apps domains list
            if ( !empty( $cfg->_VALID_DOMAINS ) ):
                if ( !array_key_exists( $reg->DOMAIN_FQDN, array_flip( $cfg->_VALID_DOMAINS ) ) ):
                    $this->returnCode = 7; //Auth domain is not whitelisted
                    return FALSE;
                endif;
            endif;

            //passed auth stage 1
            $sess->AUTH_USER_ID = $_user[$authCol->id];
            $sess->AUTH_USER_LANGUAGE_ID = $_user[$authCol->language_id];
            $sess->AUTH_USERNAME = $username; //current username succefully pass thru login and questions are set

            if ( $cfg->AUTH_SECURITY_QUESTIONS ):
                //check if previous cookie was set
                $cName = $sess->name() . '_AC';
                if ( !isset( $_COOKIE[$cName] ) || (base64_decode( $_COOKIE[$cName] ) !== $_user[$authCol->token]) ):
                    //cookie not set and does match then display questions
                    if ( bcCrypt::hasNamespace( $cfg->BC_CRYPT_NS ) ):
                        bcCrypt::useNamespace( bc::registry()->cryptNS );
                        $sess->_AUTH_QUESTIONS = bcCrypt::decrypt( $_user[$authCol->secret_answers] );
                    else:
                        $sess->_AUTH_QUESTIONS = json_decode( base64_decode( $_user[$authCol->secret_answers] ) );
                    endif;
                    if ( empty( $sess->_AUTH_QUESTIONS ) ):
                        unset( $sess->_AUTH_QUESTIONS );
                        $this->returnCode = 10; //SET SECURE ANSWERS
                        return FALSE;
                    endif;
                    $this->returnCode = 11; //DISPLAY SECURE ANSWERS
                    return FALSE;
                endif;
            endif;
        endif;

        if ( $cfg->AUTH_LOCKER )://on sucess remove any failed attempt with AUTH_LOCKER
            $_filters = array();
            $_filters[$authLockCol->ip] = array( '=', $reg->CLIENT_IP, bcDB::TYPE_STRING, 'AND' );
            $_filters[$authLockCol->username] = array( '=', $sess->AUTH_USERNAME, bcDB::TYPE_STRING, NULL );
            $model->uac_auth_lock()->delete( $_filters, array(), NULL ); //cleanup all occurrencies              
        endif;
        //finally SIGN IN
        unset( $sess->_AUTH_QUESTIONS, $sess->AUTH_CURR_QUESTION, $sess->AUTH_NONCE, $sess->AUTH_HIDDEN_NONCE, $sess->AUTH_HIDDEN_EMPTY );
        //generate a new Auth Token
        $authToken = sha1( bcUUID::v4() . $sess->AUTH_USERNAME );

        $_columns = array();
        $_columns[$authCol->token] = array( $authToken, bcDB::TYPE_STRING );
        $_columns[$authCol->online] = array( 1, bcDB::TYPE_INTEGER );
        $_columns[$authCol->last_ip] = array( $reg->CLIENT_IP, bcDB::TYPE_STRING );
        $_columns[$authCol->last_activity] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
        $_filters = array();
        $_filters[$authCol->id] = array( '=', $sess->AUTH_USER_ID, bcDB::TYPE_INTEGER, NULL );
        $model->uac_auth()->update( $_columns, $_filters, array(), NULL );

        //set AUTH_COOKIE
        $cName = $sess->name() . '_AC';
        if ( $cfg->REMEMBER && ( isset( $_POST[$this->rememberAttributeName] ) || isset( $_COOKIE[$cName] ) ) ):
            //encode $cookieData in case no encryption is used
            $cookieData = base64_encode( $authToken );
            $cookieExpire = (int) $_SERVER['REQUEST_TIME'] + (60 * 60 * 24 * (int) $cfg->REMEMBER);
            $_c = session_get_cookie_params();
            setcookie( $cName, $cookieData, $cookieExpire, $_c['path'], $_c['domain'], $_c['secure'], TRUE );
            unset( $_c );
        endif;

        //set session identifier
        $sess->AUTH = 'AUTHORIZED'; //auth ok status 
        $sess->regenerateID( TRUE );
        return TRUE;
    }

    /**
     * AUTH SIGN OUT
     * Automatically redirects to post signout page $this->redirect(4);
     * @return void
     */
    public function signOut()
    {
        $cfg = $this->config(); //assign Auth Config Object
        $model = $this->model(); //assign Auth Model Object
        $authCol = $this->configModel()->uac_auth(); //assign Auth Model Columns
        $sess = bcUAC::session(); //assin Auth Session Object
        $sess->useNamespace( $cfg->SESSION_NS );
        if ( isset( $sess->AUTH_USER_ID ) ):

            $_columns = array();
            $_columns[$authCol->online] = array( 0, bcDB::TYPE_INTEGER );
            $_columns[$authCol->last_activity] = array( $_SERVER['REQUEST_TIME'], bcDB::TYPE_INTEGER );
            $_filters = array();
            $_filters[$authCol->id] = array( '=', $sess->AUTH_USER_ID, bcDB::TYPE_INTEGER, NULL );
            $model->uac_auth()->update( $_columns, $_filters, array(), NULL );
        endif;
        $sess->destroy();
    }

    /**
     * AUTH LOGIN INTERFACE            
     * @return string html markup
     * @author Emily
     */
    public function getLoginInterface()
    {
        bcFormControl::useNamespace( 'auth' );
        $login = bcFormControl::uiWizard()->login();
        return $login->getMarkup( $this->getHiddenFields() );
    }

    /**
     * LIBRARY CONFIGURATION
     * Set before invoking bcUAC::auth()->useNamespace( $namespace ) for the 1st time
     * Connection namespace, table and columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Config
     */
    public function config()
    {
        return $this->resource( 'config' );
    }

    /**
     * MODEL CONFIGURATION
     * Set before invoking bcUAC::auth()->useNamespace( $namespace ) for the 1st time
     * Connection namespace, table and columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\ConfigModel
     */
    public function configModel()
    {
        return $this->resource( 'configModel' );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcUAC::auth()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_Model
     */
    public function model()
    {
        return $this->resource( 'model' );
    }

    /**
     * Current Authentication Resources
     * NAMESPACE
     * USER_ID_TYPE
     * @param String $TYPE Resource types(case insensitive)
     * @return Mixed 
     */
    private function resource( $TYPE )
    {

        if ( !isset( $this->_ns[$this->currNS] ) ):
        //bc::debugger()->CODE = 'DB-CONN:10000';
        // bc::debugger()->_SOLUTION[] = self::$currNS;
        //bc::debugger()->invoke();
        //todo
        endif;

        switch ( $TYPE ):
            case 'namespace':
                return $this->currNS;
            case 'config':
                return $this->_ns[$this->currNS]['config'];
            case 'configModel':
                return $this->_ns[$this->currNS]['configModel'];
            case 'model':
                if ( $this->_ns[$this->currNS]['model'] instanceof \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_Model ):
                    return $this->_ns[$this->currNS]['model'];
                endif;

                if ( $this->config()->STORAGE_RESOURCE === FALSE ):
                    bcDB::connection( $this->configModel()->bcDB_NS );
                    return $this->_ns[$this->currNS]['model'] = new Auth\Model\Model( __CLASS__ );
                endif;

                if ( !$this->config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_Model ):
                    //debug
                    exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_Model ' );
                endif;
                return $this->_ns[$this->currNS]['model'] = $this->config()->STORAGE_RESOURCE;
            default:
                return FALSE;
        endswitch;
    }

    /**
     * AUTH DOMAIN CONTROL
     * Starts a new authentication domain or restore an exising one based upon its namespace name.
     * Set all properties on bcUAC::auth()->config() and bcUAC::auth()->configModel() before starting a new auth namespace
     * ACL defines multidomains allowances or denials
     * When initializing the namespace, all settings such as bcUAC::auth()->STORAGE_RESOURCE etc are referent
     * to the namespace in use, which means that each namespace has the ability of its own settings and definitions therefore
     * allowing multiple authentication 
     * @param String $NAMESPACE
     * @return Boolean TRUE|FALSE TRUE if namespace already exists
     */
    public function useNamespace( $NAMESPACE )
    {
        $this->currNS = $NAMESPACE;
        //authentication namespace exists?
        if ( isset( $this->_ns[$this->currNS] ) ):
            return TRUE;
        endif;

        $this->_ns[$this->currNS]['config'] = new Config( __CLASS__ );
        $this->_ns[$this->currNS]['configModel'] = new ConfigModel( __CLASS__ );
        $this->_ns[$this->currNS]['model'] = FALSE;

        return FALSE;
    }

}
