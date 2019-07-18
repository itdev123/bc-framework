<?php

namespace BriskCoder\Package\Module\bcUAC\Libs;

use BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcUAC\Libs\Session\Config,
    BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel,
    BriskCoder\Package\Module\bcUAC\Libs\Session\APChandler;

final class Session
{

    public
    /**
     * SESSION HANDLER TYPE
     * Supported Types: memcache, apc, db, files <br>
     * HANDLER_TYPE:  1 = 'files'<br>
     * HANDLER_TYPE:  2 = 'db' <br>
     * HANDLER_TYPE:  3 = 'apc' <br>
     * HANDLER_TYPE:  4 = 'memcache' <br>
     * Gracefully falls back from memcache, apc, db to files unless $SESSION_HANDLER_FALLBACK is set to FALSE
     * then bcUAC::session()->start() returns FALSE
     * @var string $SESSION_HANDLER_TYPE default 1 'files'
     */
            $HANDLER_TYPE = 1,
            /**
             * SESSION HANDLER STORAGE RESOURCE
             * if HANDLER_TYPE:  1 = 'files' then $HANDLER_RESOURCE = 'save path' <br>
             * if HANDLER_TYPE:  2 = 'db' and $HANDLER_RESOURCE = FALSE then built-in Model is used, use bcUAC->session()->configModel()
             * to setup the model, otherwise $HANDLER_RESOURCE must be an object implementing \SessionHandlerInterface from your Project's Logic\Model layer
             * TIP: To set  bcUAC->session()->configModel() properties, use BriskCoder\Priv\DataObject\{your_db_ns} if you used bcDB::architect.
             * if HANDLER_TYPE:  3 = 'apc' then $HANDLER_RESOURCE = FALSE since BriskCoder\Package\Module\Libs\Session\APChandler is auloloaded<br>
             * if HANDLER_TYPE:  4 = 'memcache' then $HANDLER_RESOURCE = tcp:// connection settings<br>
             * Default save path is BC_PRIVATE_ASSETS_PATH  . 'Session';
             * @var mixed $SESSION_HANDLER_RESOURCE
             */
            $HANDLER_RESOURCE = FALSE,
            /**
             * SESSION HANDLER FALLBACK
             * FALLS BACK starting from 'memcache', 'apc', 'db' and if all fails then 'files' .
             * Default is TRUE for auto fallback mode, otherwise it fails if no resource available.
             */
            $HANDLER_FALLBACK = TRUE;
    //TODO  here all other session features if any


    private
            $_namespaces,
            $currentNS;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;

        //Sets Default Namespace
        $this->currentNS = 'NS_AUTH';
        $this->_namespaces[$this->currentNS] = FALSE;
    }

    final private function __clone()
    {
        
    }

    /**
     * terminate $_SESSION
     * Cleans and Destroy Current BCsession Entirely inluding all Namespaces
     * @return void
     */
    public function destroy()
    {
        if ( !$this->exists() ):
            return;
        endif;

        $_SESSION = array();
        //clear namespaces
        $this->currentNS = FALSE;
        $this->_namespaces = array();

        //expire cookie
        if ( ini_get( "session.use_cookies" ) ):
            $params = session_get_cookie_params();
            setcookie( $this->name(), '', $_SERVER['REQUEST_TIME'] - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        endif;

        session_destroy();
    }

    /**
     * Is session Already Started
     * @return boolean
     */
    public function exists()
    {
        if ( $this->id() || headers_sent() ):
            return TRUE;
        endif;
        return FALSE;
    }

    /**
     * Session ID
     * @return string
     */
    public function id()
    {
        return session_id();
    }

    /**
     * Get session Name
     * @return string
     */
    public function name()
    {
        return session_name();
    }

    /**
     * Destroy Session Namespace 
     * @return void
     */
    public function namespaceDestroy( $NAMESPACE )
    {
        unset( $_SESSION['NS_' . $NAMESPACE] );
    }

    /**
     * Get all Session Namespaces in use
     * @return array
     */
    public function namespacePool()
    {
        return str_replace( 'NS_', '', array_keys( $this->_namespaces ) );
    }

    /**
     * regenerateID 
     * Regeneretes Current BCsession ID
     * @return void
     */
    public function regenerateID( $DELETE_OLD = TRUE )
    {
        session_regenerate_id( (bool) $DELETE_OLD );
    }

    /**
     * Starts Session
     * @return boolean FALSE is already started
     */
    public function start()
    {
        if ( $this->exists() ):
            return FALSE;
        endif;

        //set all ini options
        foreach ( get_object_vars( $this->config() ) as $k => $v ):
            if ( $v === FALSE )://preserve ini defaults
                continue;
            endif;
            ini_set( 'session.' . strtolower($k), $v );
        endforeach;

        $handler = NULL;

        //DEFINE HANDLER TYPES
        switch ( TRUE ):
            case $this->HANDLER_TYPE == 2 && ((object) $this->HANDLER_RESOURCE !== $this->HANDLER_RESOURCE ):
                $handler = $this->model();
                break;
            case $this->HANDLER_TYPE == 2 && $this->HANDLER_RESOURCE instanceof \SessionHandlerInterface:
                $handler = $this->HANDLER_RESOURCE;
                break;
            case $this->HANDLER_TYPE == 1 && ($this->HANDLER_RESOURCE):
                if ( !is_dir( $this->HANDLER_RESOURCE ) ):
                    mkdir( $this->HANDLER_RESOURCE );
                endif;
                ini_set( 'session.save_path', $this->HANDLER_RESOURCE );
                session_start();
                return TRUE;
            case $this->HANDLER_TYPE == 3 && extension_loaded( 'apc' ) && ini_get( 'apc.enabled' ):
                $handler = new APChandler();
                break;
            case $this->HANDLER_TYPE == 4 && $this->HANDLER_RESOURCE instanceof \Memcache:
                ini_set( 'session.save_handler', 'memcache' );
                ini_set( 'session.save_path', $this->HANDLER_RESOURCE );
                session_start();
                return TRUE;
            default:
                if ( $this->HANDLER_FALLBACK == FALSE ):
                    return FALSE;
                endif;
                session_start();
                return TRUE;
        endswitch;

        session_set_save_handler( $handler, TRUE );
        session_start();
        return TRUE;
    }

    public function __set( $NAME, $VALUE )
    {
        if ( $this->exists() ):
            $_SESSION[$this->currentNS][$NAME] = $VALUE;
        endif;
    }

    public function __get( $NAME )
    {
        if ( $this->exists() && isset( $_SESSION[$this->currentNS][$NAME] ) ):
            return $_SESSION[$this->currentNS][$NAME];
        endif;
        return NULL;
    }

    public function __isset( $NAME )
    {
        return isset( $_SESSION[$this->currentNS][$NAME] );
    }

    public function __unset( $NAME )
    {
        unset( $_SESSION[$this->currentNS][$NAME] );
    }

    /**
     * Prints a Friendly Table with all the containing session data from current namespace
     * @return string
     */
    public function explain()
    {
        if ( !isset( $_SESSION[$this->currentNS] ) || ((array) $_SESSION[$this->currentNS] !== $_SESSION[$this->currentNS]) ):
            return FALSE;
        endif;
        ob_start();
        echo '<table cellpadding="5" cellspacing="0" border="0">';
        echo '<tr><td colspan="3" style="height:50px;"></td></tr>';
        echo '<tr><th>MAGIC PROPERTIES</th><th></th><th>VALUES</th></tr>';
        echo '<tr><td colspan="3" style="border-bottom:1px dotted #ff0000;"></td></tr>';
        foreach ( $_SESSION[$this->currentNS] as $k => $v ):
            echo '<tr><td style="border-bottom:1px dotted #ff0000;">';
            echo '<b>' . $k . '</b>';
            echo '</td><td style="border-bottom:1px dotted #ff0000;">';
            echo ' => ';
            echo '</td><td style="border-bottom:1px dotted #ff0000;">';
            var_dump( $v );
            echo '<br>';
            echo '</td></tr>';
        endforeach;
        echo '</table>';
        $r = ob_get_contents();
        ob_end_clean();
        return $r;
    }

    /**
     * PHP INI CONFIG
     * Set Runtime Ini Configuration
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Session\Config
     */
    public function config()
    {
        static $ci;
        return (object) $ci === $ci ? $ci : $ci = new Config( __CLASS__ );
    }

    /**
     * MODEL CONFIGURATION
     * Connection namespace, table and columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel
     */
    public function configModel()
    {
        static $cm;
        return (object) $cm === $cm ? $cm : $cm = new ConfigModel( __CLASS__ );
    }

    /**
     * MODEL Object
     * Retunrs the Model Object and its methods according to current bcDB Namespace and RDBMS
     * This is not used when dev uses their own SESSION_HANDLER_RESOURCE from Project's Logic\Model layer.<br>
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcUAC::auth()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Session\Model\i_Model
     */
    private function model()
    {
        static $md;
        bcDB::connection( $this->configModel()->bcDB_NS );
        $cls = 'BriskCoder\Package\Module\bcUAC\Libs\Session\Model\\' . bcDB::resource( 'RDBMS' );
        return (object) $md === $md ? $md : $md = new $cls( __CLASS__ );
    }

    /**
     * Sets Session Namespace container or create a new one
     * @param string $NAMESPACE Session Namespace to use
     * @return  void
     */
    public function useNamespace( $NAMESPACE )
    {
        $NAMESPACE = 'NS_' . $NAMESPACE;
        if ( !isset( $_SESSION[$NAMESPACE] ) ):
            $_SESSION[$NAMESPACE] = array();
        endif;
        $this->currentNS = $NAMESPACE;
    }

}
