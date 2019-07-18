<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 * RJ Anderson rj@xpler.com
 * Xpler Corporation 
 */

namespace BriskCoder;

use BriskCoder\System\Project,
    BriskCoder\System\Debugger,
    BriskCoder\System\Request,
    BriskCoder\System\Publisher,
    BriskCoder\System\Registry;

/**
 * Class BC
 * BriskCoder engine
 * URI SEGMENTS: are case sensitive and only observe - "dashes" as spaces and any UPPERCASE character will trigger a 404 call EXCEPT QUERY_STRINGS
 * LOGIC/DISPATCHERS: observe NAMING_CONVENTION and are case sesitive. 
 */
final class bc
{

    public static

    /**
     * SET PRIVATE PATH above server public root directory
     * @tutorial Set to TRUE and move the following above public root: <br>
     * BriskCoder/<br>
     *      --- Package/<br>
     *      --- Priv/<br>
     *      --- System/<br>
     *      --- BC.php<br>
     * YourProject/<br>
     *      --- YourProjectDependencies/<br>
     * NOTE: If you want the above structure entirely inside a diretory, then set
     * bc::$PRIVATE_PATH  = 'YourDirectoryContainer';
     * @var bool 
     */
            $PRIVATE_PATH = FALSE,
            /**
             * Only change this if your server public root folder is not "public_html"
             * IIS users might need to set this to "wwwroot"
             * Do not use DIRECTORY_SEPARATOR
             */
            $PUBLIC_PATH = 'public_html',
            /**
             * LIVE MODE
             * @tutorial Defines if BriskCoder is running on development or production mode. Default = FALSE
             * @var bool 
             */
            $LIVE_MODE = FALSE,
            /**
             * DEV LANGUAGE 
             * @tutorial Defines BriskCoder Developer Language. If language is not available then it will use 'en-us' as default.
             * @var string
             */
            $DEV_LANGUAGE = 'en-us';
    private static
            $starter = FALSE;

    /**
     * BC Starter
     * If invoked it will preload all necessary dependencies so Engine can be used even
     * before any Project runs(), such as autoloaders
     * @static
     * @return void
     */
    public static function start()
    {
        if ( self::$starter ):
            return;
        endif;


        //define private path
        define( 'BC_PRIVATE_PATH', str_replace( basename( dirname( __FILE__ ) ), NULL, dirname( __FILE__ ) ) );

        //define public path
        //is Above root?
        if ( self::$PRIVATE_PATH ):
            self::$PRIVATE_PATH = (self::$PRIVATE_PATH === TRUE) ? NULL : self::$PRIVATE_PATH . '\\';
            if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                define( 'BC_PUBLIC_PATH', strstr( dirname( __FILE__ ), self::$PUBLIC_PATH, TRUE ) . self::$PUBLIC_PATH . DIRECTORY_SEPARATOR );
            }else{
                define( 'BC_PUBLIC_PATH', str_replace( self::$PRIVATE_PATH . basename( dirname( __FILE__ ) ), self::$PUBLIC_PATH . '\\', dirname( __FILE__ ) ) );
            }
        else:
            define( 'BC_PUBLIC_PATH', strstr( dirname( __FILE__ ), self::$PUBLIC_PATH, TRUE ) . self::$PUBLIC_PATH . DIRECTORY_SEPARATOR );
        endif;


        set_include_path( get_include_path() . PATH_SEPARATOR . BC_PUBLIC_PATH );
        set_include_path( get_include_path() . PATH_SEPARATOR . BC_PRIVATE_PATH );


        //SET BC_PRIVATE_ASSETS_PATH 
        define( 'BC_PRIVATE_ASSETS_PATH', BC_PRIVATE_PATH . 'BriskCoder/Priv/' );
        //SET BC_PUBLIC_ASSETS_PATH 
        define( 'BC_PUBLIC_ASSETS_PATH', BC_PUBLIC_PATH . 'BriskCoder/Pub/' );
        //SET BC_COMPONENTS_PUBLIC_URI 
        define( 'BC_COMPONENTS_PUBLIC_URI', '/BriskCoder/Pub/Package/Component/' );


        require_once self::$LIVE_MODE ? 'System/Debugger.php' : 'System/Shutdown/Shutdown.php';
        require_once self::$LIVE_MODE ? 'System/Registry.php' : 'System/Registry/Registry.php';


        ini_set( 'display_errors', 0 ); //disable coz we have our own debugger
        ini_set( 'log_errors', 0 ); //FIX IIS7 not calling register_shutdown_function when this is set to ON



        register_shutdown_function( array( 'BriskCoder\System\Shutdown', 'coreDebugger' ), 'coreDebugger' );

        //IMPORTANT <-- 
        //This prevents any user buffer from being dispatched if any Core or BC error is found or dispatched
        ob_start();

        //start autoloader
        spl_autoload_register( function($cls) {
            $path = str_replace( '\\', DIRECTORY_SEPARATOR, $cls );
            $file = null;
            if ( bc::$LIVE_MODE ):
                $file = BC_PRIVATE_PATH . $path . '.php';

                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Logic' . DIRECTORY_SEPARATOR . $path . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . $path . DIRECTORY_SEPARATOR . basename( $path ) . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Logic' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . basename( $path ) . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;
            else:
                $file = BC_PRIVATE_PATH . $path . DIRECTORY_SEPARATOR . basename( $path ) . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Logic' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . basename( $path ) . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . $path . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;

                $file = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . DIRECTORY_SEPARATOR . 'Logic' . DIRECTORY_SEPARATOR . $path . '.php';
                if ( is_file( $file ) ):
                    return require_once $file;
                endif;
            endif;
        } );

        //set registry vars
        
        bc::registry()->URI = !empty( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : NULL;
        bc::registry()->URI_NO_QS = !empty( $_SERVER['REQUEST_URI'] ) ? rtrim(strtok( $_SERVER["REQUEST_URI"], '?' ), '/') : NULL;
        bc::registry()->URI_REFERER = !empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : NULL;
        
        
        bc::registry()->PROTOCOL = isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == "on" ? 'https://' : 'http://'; 
        bc::registry()->DOMAIN_FQDN = !empty( $_SERVER['HOST_NAME'] ) ? $_SERVER['HOST_NAME'] : $_SERVER['SERVER_NAME'];
        bc::registry()->USER_AGENT = !empty( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : NULL;//TODO create a lib for user agent definition
        bc::registry()->SERVER_IP = gethostbyname( bc::registry()->DOMAIN_FQDN );
        //Get clients IP
        if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ):
            bc::registry()->CLIENT_IP = $_SERVER['HTTP_CLIENT_IP'];
        elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ):
            bc::registry()->CLIENT_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        elseif ( !empty( $_SERVER['REMOTE_ADDR'] ) ):
            bc::registry()->CLIENT_IP = $_SERVER['REMOTE_ADDR'];
        else:
            bc::registry()->CLIENT_IP = '127.0.0.1';
        endif;
        
        
        
        //ready to fly!
        self::$starter = TRUE;
    }

    /**
     * Project Management
     * @static $obj
     * @return \BriskCoder\System\Project
     */
    public static function project()
    {
        static $obj;
        return $obj instanceof Project ? $obj : $obj = new Project( __CLASS__ );
    }

    /**
     * Debugger Object
     * @static $obj
     * @return \BriskCoder\System\Debugger
     */
    public static function debugger()
    {
        static $obj;
        return $obj instanceof Debugger ? $obj : $obj = new Debugger( __CLASS__, debug_backtrace() );
    }

    /**
     * Request Object
     * @static $obj
     * @return \BriskCoder\System\Request
     */
    public static function request()
    {
        static $obj;
        return $obj instanceof Request ? $obj : $obj = new Request( __CLASS__ );
    }

    /**
     * Publisher Object
     * @static
     * @return \BriskCoder\System\Publisher
     */
    public static function publisher()
    {
        static $obj;
        return $obj instanceof Publisher ? $obj : $obj = new Publisher( __CLASS__ );
    }

    /**
     * Registry Object
     * @static $obj
     * @return \BriskCoder\System\Registry
     */
    public static function registry()
    {
        static $obj;
        return $obj instanceof Registry ? $obj : $obj = new Registry( __CLASS__ );
    }

}
