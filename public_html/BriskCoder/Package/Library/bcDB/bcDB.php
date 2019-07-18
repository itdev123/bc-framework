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

namespace BriskCoder\Package\Library;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcDB\Architect\bcDBArchitect,
    BriskCoder\Package\Library\bcDB\SQL\Mod,
    BriskCoder\Package\Library\bcDB\Mapper;

class bcDB
{

    const
            TYPE_BOOL = 'bool',
            TYPE_FLOAT = 'float',
            TYPE_INTEGER = 'int',
            TYPE_LOB = 'lob',
            TYPE_NULL = 'null',
            TYPE_STRING = 'str';

    public static


    /**
     * DATABASE | CATALOG NAME
     * @var string $CATALOG Current Database Name
     */
            $CATALOG,
            /**
             * SCHEMA | OWNER NAME
             * If database type does not support schemas and a $SCHEMA name
             * is assigned, then it will be used as a table prefix and underline
             * will be automatically inserted after $SCHEMA name ie: <br>
             * MySQL (catalog.schema_tableName)<br>
             * SQLite3 (schema_tableName)
             * @var string $SCHEMA Current Schema Name
             */
            $SCHEMA,
            /**
             * RDBMS DRIVER
             * Available:<br> 
             * pdo_mysql 
             * pdo_sqlite 
             * pdo_pgsql 
             * pdo_mssql
             * pdo_oci
             * mysqli
             * pgsql
             * sqlsrv
             * oci
             * sqlite 
             * Default pdo_mysql
             * @var string $DRIVER Current DB Drive in use
             */
            $DRIVER = 'pdo_mysql',
            /**
             * CUSTOM DSN
             * If used anything but $NAMESPACE, $USER, $PASSWORD, $_OPTIONS will be  ignored
             * @var string $HOST Current DB host
             */
            $DSN,
            /**
             * DB HOST
             * Default 127.0.0.1
             * @var string $HOST Current DB host
             */
            $HOST,
            /**
             * DB USER
             * Default FALSE
             * @var string $USER Current DB User
             */
            $USER,
            /**
             * DB PASSWORD
             * Default FALSE
             * @var string $PASS Current DB Password
             */
            $PASS,
            /**
             * DB PORT
             * Default FALSE
             * @var string $PORT Current Database Port
             */
            $PORT,
            /**
             * DB CHARSET
             * NOTE PHP < 5.3.6 It needs to be set through $_OPTIONS by using PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET NAMES utf8';
             * Default FALSE 
             * @var string $CHARSET Current Database Charset 
             */
            $CHARSET,
            /**
             * DB OPTIONS
             * Default FALSE
             * @var Array $_OPTIONS Current DB PDO Options
             */
            $_OPTIONS = array(),
            /**
             * Fully Qualified Name
             * Defines if bcDB::architect() will build Schema and Models with FQN names.
             * This feature has Pros/Cons<br>
             * PRO: When using Schema\tbl::column to build model sql queries, there's no concern about aliases and colisions when 
             * handling multiple database connection since Schema provides FQN dbname.(schemaname).tblname.colname  (schemaname) for DBs
             * with support to this feature such as SQLSR, then set bcDB::$SCHEMA <br>
             * CON: By Using FQN feature, the returned data when retrieved by fetch mode Associative, cannot make use of
             * Schema\tbl::column since DB returns only the column name. ie: $_data['colname'] and not $_data['dbname.tblname.colname']
             * @var bool $FQN Use Fully Qualified Name for Tables and Columns, Default is FALSE
             */
            $FQN = FALSE;
    private static
            $_ns = array(),
            $currNS = NULL;

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * Connect to DB if $NAMESPACE exists or established a new one.
     * Only invoke after setting parameters for connection based upon $NAMESPACE
     * Or if multiple connections already established it will set the $NAMESPACE invoked to
     * the pointer so all executions will refer to the connection set for the specified $NAMESPACE
     * @param string $NAMESPACE
     * @return bool TRUE|FALSE False if a DB connection was not established 
     */
    public static function connection( $NAMESPACE )
    {
        self::$currNS = $NAMESPACE;

        //connection namespace exists?
        if ( isset( self::$_ns[self::$currNS] ) ):
            return TRUE;
        endif;

        //flag to identify is is extension PDO, mysqli or other native drivers available
        $extension = 'pdo'; //default
        $rdbms = 'mysql'; //default
        //
        //build connection DSN
        switch ( self::$DRIVER ):
            case 'pdo_mysql':
                if ( !self::$DSN ):
                    if ( self::$PORT ):
                        self::$PORT = 'port=' . self::$PORT . ';';
                    endif;

                    if ( self::$CHARSET ):
                        self::$CHARSET = ';charset=' . self::$CHARSET;
                    endif;

                    self::$DSN = 'mysql:host=' . self::$HOST . ';' . self::$PORT . 'dbname=' . self::$CATALOG . self::$CHARSET;
                endif;
                break;
            case 'pdo_pgsql':
                $rdbms = 'pgsql';
                if ( !self::$DSN ):
                    self::$DSN = 'pgsql:dbname=' . self::$CATALOG . ';host=' . self::$HOST;
                endif;
                break;
            case 'pdo_sqlite'://SQLITE 
                $rdbms = 'sqlite';
                if ( !self::$DSN ):
                    if ( self::$HOST === 'memory' ):
                        self::$DSN = 'sqlite::' . self::$HOST . ':';
                    else:
                        self::$DSN = 'sqlite:' . self::$HOST;
                    endif;
                endif;
                break;
            case 'pdo_sqlsrv'://MSSQL
                $rdbms = 'sqlsrv';
                if ( !self::$DSN ):
                    self::$DSN = 'sqlsrv:server=' . self::$HOST . ';Database=' . self::$CATALOG;
                endif;
                break;
            case 'pdo_oci'://Oracle 
                $rdbms = 'oci';
                if ( !self::$DSN ):
                    if ( self::$CHARSET ):
                        self::$CHARSET = ';charset=' . self::$CHARSET;
                    endif;

                    self::$DSN = 'oci:dbname=' . self::$CATALOG . self::$CHARSET;
                endif;

                break;
            case 'mysqli':
                $extension = 'mysqli';
                //TODO Other drivers implementation
                break;
            case 'sqlsrv':
                $rdbms = $extension = 'sqlsrv';
            //TODO Other drivers implementation
            case 'pgsql':
                $rdbms = $extension = 'pgsql';
                //TODO Other drivers implementation
                break;
            case 'sqlite':
                $rdbms = $extension = 'sqlite';
                //TODO Other drivers implementation
                break;
            //more todos ...
            default:
                //REMEMBER production class will not call debugger..but a friendly page
                //when in production Log system may record what dev debugger mode would say.
                bc::debugger()->CODE = 'DB-CONN:10001';
                bc::debugger()->_PROBLEM[] = self::$DRIVER;
                bc::debugger()->_PROBLEM[] = self::$CATALOG;
                bc::debugger()->_SOLUTION[] = self::$CATALOG;
                bc::debugger()->invoke();
        endswitch;

        //start new connection
        switch ( $extension ):
            case 'pdo':

                try {
                    self::$_ns[self::$currNS]['CONNECTION'] = new \PDO( self::$DSN, self::$USER, self::$PASS, self::$_OPTIONS );
                    self::$_ns[self::$currNS]['HOST'] = self::$DSN;
                    self::$_ns[self::$currNS]['EXTENSION'] = $extension;
                    self::$_ns[self::$currNS]['DRIVER'] = self::$DRIVER;
                    self::$_ns[self::$currNS]['RDBMS'] = $rdbms;
                    self::$_ns[self::$currNS]['CATALOG'] = self::$CATALOG;
                    self::$_ns[self::$currNS]['SCHEMA'] = self::$SCHEMA;
                    self::$_ns[self::$currNS]['FQN'] = self::$FQN;
                    self::$_ns[self::$currNS]['SQL_PATH'] = BC_PRIVATE_ASSETS_PATH . 'SQL' . DIRECTORY_SEPARATOR . self::$currNS . DIRECTORY_SEPARATOR . $rdbms . DIRECTORY_SEPARATOR;
                    self::$_ns[self::$currNS]['CACHE'] = FALSE;
                } catch ( \PDOException $e ) {
                    // bc::debugger()->CODE = 'DB-CONN:10000';
                    // bc::debugger()->_PROBLEM[] = $e->getMessage();
                    // bc::debugger()->_SOLUTION[] = self::$currNS;
                    // bc::debugger()->invoke();
                    return FALSE; //production mode 
                }
                break;
            case 'mysqli':
                //todo connection
                break;
            case 'sqlsrv':
                //todo connection
                break;
            case 'pgsql':
                //todo connection
                break;
            case 'sqlite':
                //todo connection
                break;
        endswitch;

        //reset flags so it prevents garbage creating if non proper database conection is made
        //except $NAMESPACE
        self::$CATALOG = NULL;
        self::$SCHEMA = NULL;
        self::$DRIVER = 'pdo_mysql'; //sets default
        self::$DSN = NULL;
        self::$HOST = NULL;
        self::$USER = NULL;
        self::$PASS = NULL;
        self::$PORT = NULL;
        self::$CHARSET = NULL;
        self::$_OPTIONS = array();
        self::$FQN = TRUE;

        //reset fetch mode
        self::sql()->setFetch()->typeAssociative();

        return TRUE;
    }

    /**
     * SQL Object
     * @return \BriskCoder\Package\Library\bcDB\SQL\Mod
     */
    public static function sql()
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;
        static $sql;
        return ( $sql instanceof Mod ) ? $sql : $sql = new Mod( __CLASS__ );
    }

    /**
     * SQL Query Builder Object
     * @return \BriskCoder\Package\Library\bcDB\Mapper
     */
    public static function mapper()
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;

        static $sql;
        return ( $sql instanceof Mapper ) ? $sql : $sql = new Mapper( __CLASS__ );
    }

    /**
     * TODO validation occurs here and before DML or SQL is executed since we will use Schema which contains
     * datatypes, this will improve performance since no DML will be constructed or SQL executed if validation fails
     * for such we need a public flag  that can be checked by dependent classes
     * @param string $COLUMN Database column to be validated against
     * @param mixed $DATA Data to be compared against column datatype
     * @return \BriskCoder\Package\Library\bcDB\bcDBValidate $validate
     */
    public static function validate( $COLUMN, $DATA )
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;

        //TODO also check if schema exists otherwise validation will not work
        // returns true or false
    }

    /**
     * Schema and Model builder from Current Database Namespace 
     * @return \BriskCoder\Package\Library\bcDB\Architect\bcDBArchitect
     */
    public static function architect()
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;

        static $sCls;
        return ( $sCls instanceof bcDBArchitect ) ? $sCls : $sCls = new bcDBArchitect( __CLASS__ );
    }

    /**
     * Checks whether the provided namespace is an active connection
     * @param string $NAMESPACE Connection Namespace to verify
     * @return bool
     */
    public static function hasNamespace( $NAMESPACE )
    {
        return (!isset( self::$_ns[$NAMESPACE] ) ) ? FALSE : TRUE;
    }

    /**
     * Current Database Connection Resources
     * This should be used only if you are writting your own CRUD operations
     * @param string $TYPE Resource types (insensitive case): <br>
     * HOST current DSN
     * NAMESPACE current namespace <br>
     * CONNECTION current connection link <br>
     * EXTENSION current extension pdo || mysqli || sqlsrv || oci8 || pgsql <br>
     * DRIVER current driver <br>
     * RDBMS current database brand <br>
     * CATALOG current database name <br>
     * SCHEMA current schema | owner | prefix names <br>
     * FQN current Fully Qualified Name status <br>
     * SQL_PATH current statements save path <br>
     * CACHE current cache mode <br>
     * @return \PDO|\mysqli| 
     */
    public static function resource( $TYPE )
    {
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'DB-CONN:10000';
            bc::debugger()->_SOLUTION[] = self::$currNS;
            bc::debugger()->invoke();
        endif;

        $resource = strtoupper( $TYPE );

        if ( $resource === 'NAMESPACE' ):
            return self::$currNS;
        endif;

        if ( isset( self::$_ns[self::$currNS][$resource] ) ):
            return self::$_ns[self::$currNS][$resource];
        endif;
        return FALSE;
    }

    /**
     * Throw a catchable error through BriskCoder Debugger. 
     * @param $ERROR_INFO The caught exception error $e->getMessage(); 
     * @return void Haults the script and displays BriskCoder Debugger or the friendly error page if running on production mode.
     */
    public static function throwError( $ERROR_INFO )
    {
        //TODO   when running production mode must not throw debugger, rather show a friendly DB error message with no compromising information
        bc::debugger()->CODE = 'DB-CONN:10002';
        bc::debugger()->_PROBLEM[] = $ERROR_INFO;
        bc::debugger()->invoke();
    }

    /**
     * Closes current DB connection and removes $NAMESPACE.
     * @return void 
     */
    public static function disconnect()
    {
        unset( self::$_ns[self::$currNS] );
    }

}
