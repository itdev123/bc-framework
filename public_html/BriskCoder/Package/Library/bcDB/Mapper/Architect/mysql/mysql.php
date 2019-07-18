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

namespace BriskCoder\Package\Library\bcDB\Mapper\Architect;

use BriskCoder\Package\Library\bcDB;

final class mysql implements i_architect
{

    private
    /**
     * @var string $SAVE_PATH Custom Path to save the Schema Assets, otherwise
     * BriskCoder/Priv/ is default and will be used.
     * Make sure the Path is writable
     */
            $SAVE_PATH,
            /**
             * Build current Database Schema Class Interpreter
             */
            $schema = TRUE,
            /**
             * Builds current Database Model Loader Class Interpreter
             */
            $data_object = TRUE,
            /**
             * PROJECT_PACKAGE name that the Logic\Model namespace belongs to
             */
            $project_package;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcDB\Mapper' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
        $this->SAVE_PATH = BC_PRIVATE_ASSETS_PATH;
    }

    private function __clone()
    {
        
    }

    /**
     * Path to save the Schema Assets, otherwise
     * BriskCoder/Priv/ is default and will be used.
     * Make sure the Path is writable
     * To change default set it before using bcDB::mapper()->architect()->build()
     * @param string $save_path  Custom Path to save the Schema Assets
     */
    public function setSavePath( $save_path )
    {
        $this->SAVE_PATH = $save_path;
    }

    /**
     * Build current Database Schema Class Interpreter . Default TRUE. 
     * To change default set it to FALSE and before using bcDB::mapper()->architect()->build()
     * @param Boolean $build_schema
     */
    public function setSchema( $build_schema )
    {
        $this->schema = $build_schema;
    }

    /**
     * Builds current Database Model Loader Class Interpreter. Default TRUE. 
     * To change default set it to FALSE and before using bcDB::mapper()->architect()->build()
     * @param Boolean $build_data_object
     */
    public function setDataObject( $build_data_object )
    {
        $this->data_object = $build_data_object;
    }

    /**
     * PROJECT_PACKAGE name that the Logic\Model namespace belongs to
     * Required and must be set before using bcDB::mapper()->architect()->build()
     * @param Boolean $project_package
     */
    public function setProjectPackage( $project_package )
    {
        $this->project_package = $project_package;
    }

    /**
     * EXECUTES THE BUILDER
     * Set  bcDB::mapper()->architect()->projectPackage() name that the Logic\Model belongs to before using bcDB::mapper()->architect()->build()
     * @param Boolean $CLEAR
     * If any previous structure exists and $CLEAR is FALSE then it does not run.    
     * @param \BriskCoder\Package\Library\bcDB $bcDB 
     * @param bool $CLEAR Forces Delete Old Schema | Model Interpreters
     * @return bool
     */
    public function build( $CLEAR = FALSE )
    {
        $class = bcDB::resource( 'NAMESPACE' );
        $pathSchema = $this->SAVE_PATH . 'Schema' . DIRECTORY_SEPARATOR;
        $pathDataObject = $this->SAVE_PATH . 'DataObject' . DIRECTORY_SEPARATOR;

        if ( $CLEAR === FALSE &&
                (is_file( $pathSchema . $class . '.php' ) ||
                is_file( $pathDataObject . $class . '.php' )) ):
            return;
        endif;

        //is writable?
        if ( !is_writable( $this->SAVE_PATH ) ):
            //bc::debugger()->CODE
            // bc::debugger()->PROBLEM
            //bc::debugger()->SOLUTION
            // bc::debugger()->invoke();
            exit( 'call debugger line 80 Architect' );
        endif;

        if ( $CLEAR ):
            //clear schema
            $_files = glob( $pathSchema . $class . DIRECTORY_SEPARATOR . '*' );
            if ( $_files ):
                foreach ( $_files as $f ):
                    unlink( $f );
                endforeach;
                rmdir( $pathSchema . $class );
            endif;
            $f = $pathSchema . $class . '.php';
            if ( is_file( $f ) ):
                unlink( $f );
            endif;

            //Model Loader
            $f = $pathDataObject . $class . '.php';
            if ( is_file( $f ) ):
                unlink( $f );
            endif;

        endif;


        //make Main dirs
        if ( !is_dir( $pathSchema ) ):
            mkdir( $pathSchema );
        endif;

        if ( !is_dir( $pathSchema . $class ) ):
            mkdir( $pathSchema . $class );
        endif;

        if ( !is_dir( $pathDataObject ) ):
            mkdir( $pathDataObject );
        endif;

        //select all tables
        $_tables = array();
        $_columns = array();

        try {
            bcDB::mapper()->setFetch()->typeNum();
            bcDB::mapper()->show( 'TABLES' );
            $_tbl = bcDB::mapper()->fetch( TRUE );
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
        }

        foreach ( $_tbl as $tbl ):

            $_tables[] = $tbl[0];

            //fill columns with tables as ids
            try {
                bcDB::mapper()->show( 'FULL COLUMNS', $tbl[0] );
                $_cls = bcDB::mapper()->fetch( TRUE );
                foreach ( $_cls as $col ):
                    $match = array();
                    $t = $col['Type'];
                    preg_match( '/\((.*?)\)/', $t, $match );
                    if ( isset( $match[0] ) ):
                        $t = str_replace( $match[0], NULL, $t );
                    endif;
                    $s = isset( $match[1] ) ? $match[1] : NULL;
                    $u = NULL;
                    if ( strpos( $t, 'unsigned' ) ) :
                        $t = str_replace( ' unsigned', NULL, $t );
                        $u = 'unsigned';
                    endif;
                    $_columns[$tbl[0]][$col['Field']]['type'] = $t;
                    $_columns[$tbl[0]][$col['Field']]['size'] = $s;
                    $_columns[$tbl[0]][$col['Field']]['unsigned'] = $u;
                    $_columns[$tbl[0]][$col['Field']]['collation'] = $col['Collation'];
                    $_columns[$tbl[0]][$col['Field']]['null'] = $col['Null'];
                    $_columns[$tbl[0]][$col['Field']]['key'] = $col['Key'];
                    $_columns[$tbl[0]][$col['Field']]['default'] = $col['Default'];
                    $_columns[$tbl[0]][$col['Field']]['extra'] = $col['Extra'];
                    $_columns[$tbl[0]][$col['Field']]['privileges'] = $col['Privileges'];
                    $_columns[$tbl[0]][$col['Field']]['comment'] = $col['Comment'];
                endforeach;


//                while ( $col = bcDB::mapper()->fetch( FALSE ) ):
//                    $match = array();
//                    $t = $col['Type'];
//                    preg_match( '/\((.*?)\)/', $t, $match );
//                    if ( isset( $match[0] ) ):
//                        $t = str_replace( $match[0], NULL, $t );
//                    endif;
//                    $s = isset( $match[1] ) ? $match[1] : NULL;
//                    $u = NULL;
//                    if ( strpos( $t, 'unsigned' ) ) :
//                        $t = str_replace( ' unsigned', NULL, $t );
//                        $u = 'unsigned';
//                    endif;
//                    $_columns[$tbl[0]][$col['Field']]['type'] = $t;
//                    $_columns[$tbl[0]][$col['Field']]['size'] = $s;
//                    $_columns[$tbl[0]][$col['Field']]['unsigned'] = $u;
//                    $_columns[$tbl[0]][$col['Field']]['collation'] = $col['Collation'];
//                    $_columns[$tbl[0]][$col['Field']]['null'] = $col['Null'];
//                    $_columns[$tbl[0]][$col['Field']]['key'] = $col['Key'];
//                    $_columns[$tbl[0]][$col['Field']]['default'] = $col['Default'];
//                    $_columns[$tbl[0]][$col['Field']]['extra'] = $col['Extra'];
//                    $_columns[$tbl[0]][$col['Field']]['privileges'] = $col['Privileges'];
//                    $_columns[$tbl[0]][$col['Field']]['comment'] = $col['Comment'];
//                endwhile;
            } catch ( \PDOException $e ) {
                bcDB::throwError( $e->getMessage() );
            }
        endforeach;
        unset( $tbl, $col );

        //Important  THIS SHOULD BE IN THE FILESYSTE Lib as a method
        //list of forbidden names from schema that would cause problem to php
        //ie. table return, cannot be a class name, properties or functions
        $_forbidden = array(
            'abstract' => NULL,
            'and' => NULL,
            'array' => NULL,
            'as' => NULL,
            'break' => NULL,
            'callable' => NULL,
            'case' => NULL,
            'catch' => NULL,
            'class' => NULL,
            'clone' => NULL,
            'const' => NULL,
            'continue' => NULL,
            'declare' => NULL,
            'default' => NULL,
            'die' => NULL,
            'do' => NULL,
            'echo' => NULL,
            'else' => NULL,
            'elseif' => NULL,
            'empty' => NULL,
            'enddeclare' => NULL,
            'endfor' => NULL,
            'endforeach' => NULL,
            'endif' => NULL,
            'endswitch' => NULL,
            'endwhile' => NULL,
            'eval' => NULL,
            'exit' => NULL,
            'extends' => NULL,
            'final' => NULL,
            'for' => NULL,
            'foreach' => NULL,
            'function' => NULL,
            'global' => NULL,
            'goto' => NULL,
            'if' => NULL,
            'implements' => NULL,
            'include' => NULL,
            'include_once' => NULL,
            'instanceof' => NULL,
            'insteadof' => NULL,
            'interface' => NULL,
            'isset' => NULL,
            'list' => NULL,
            'namespace' => NULL,
            'new' => NULL,
            'or' => NULL,
            'print' => NULL,
            'private' => NULL,
            'protected' => NULL,
            'public' => NULL,
            'require' => NULL,
            'require_once' => NULL,
            'return' => NULL,
            'static' => NULL,
            'switch' => NULL,
            'throw' => NULL,
            'trait' => NULL,
            'try' => NULL,
            'unset' => NULL,
            'use' => NULL,
            'var' => NULL,
            'while' => NULL,
            'xor' => NULL,
        );

        if ( $this->schema ):
            $this->buildSchemas( $pathSchema, $class, $_tables, $_columns, $_forbidden );
        endif;

        if ( $this->data_object ):
            $this->buildModels( $pathDataObject, $class, $_tables, $_forbidden );
        endif;
    }

    private function buildModels( $pathModel, $className, $_tables, $_forbidden )
    {
        //build Model class
        $model = '<?php' . PHP_EOL;
        $model .= 'namespace BriskCoder\Priv\DataObject;' . PHP_EOL;
        $model .= PHP_EOL;
        $model .= 'use BriskCoder\Package\Library\bcDB;' . PHP_EOL;
        $model .= PHP_EOL;
        $model .= 'final class ' . bcDB::resource( 'NAMESPACE' ) . PHP_EOL;
        $model .= '{' . PHP_EOL;
        $model .= PHP_EOL;



        //write properties as table names;
        $schemaMethods = null;

        foreach ( $_tables as $t ):
            $sanitizedT = $t;
            //if table has a forbidden name then add a prefix '_BC' to the right of it. !IMPORTANT
            if ( array_key_exists( $t, $_forbidden ) ):
                $sanitizedT = $t . '_BC';
            endif;

            $schemaMethods .= '    /**' . PHP_EOL;
            $schemaMethods .= '    * DataObject ' . $t . PHP_EOL;
            $schemaMethods .= '    * @return \\' . $this->project_package . '\Logic\Model\\' . bcDB::resource( 'NAMESPACE' ) . '\\' . $sanitizedT . PHP_EOL;
            $schemaMethods .= '    */' . PHP_EOL;
            $schemaMethods .= PHP_EOL;
            $schemaMethods .= '    public static function ' . $sanitizedT . '()' . PHP_EOL;
            $schemaMethods .= '    {' . PHP_EOL;
            $schemaMethods .= '        static $obj;' . PHP_EOL;
            $schemaMethods .= '        if ( (object) $obj === $obj ) return $obj;' . PHP_EOL;
            $schemaMethods .= '        $model = ' . "'\\" . $this->project_package . "\Logic\Model\\" . bcDB::resource( 'NAMESPACE' ) . "\\\'. __FUNCTION__;" . PHP_EOL;
            $schemaMethods .= '        return $obj = new $model();' . PHP_EOL;
            $schemaMethods .= '    }' . PHP_EOL;



        endforeach;
        $model .= $schemaMethods;
        $model .= PHP_EOL;
        $model .= '    private function __construct(){}' . PHP_EOL;
        $model .= '    private function __clone(){}' . PHP_EOL;
        $model .= PHP_EOL;
        $model .= '}' . PHP_EOL;

        //write Schema
        file_put_contents( $pathModel . $className . '.php', $model );
    }

    private function buildSchemas( $pathSchema, $class, $_tables, $_columns, $_forbidden )
    {
        //build schema class
        $schema = '<?php' . PHP_EOL;
        $schema .= 'namespace BriskCoder\Priv\Schema;' . PHP_EOL;
        $schema .= PHP_EOL;
        $schema .= 'final class ' . $class . PHP_EOL;
        $schema .= '{' . PHP_EOL;
        $schema .= PHP_EOL;


        //define FQN
        $fqn = NULL;
        $useFQN = bcDB::resource( 'FQN' );
        if ( $useFQN ):
            switch ( bcDB::resource( 'RDBMS' ) ):
                case 'mysql':
                    $fqn .= bcDB::resource( 'CATALOG' ) . '.';
                    break;
                case 'sqlsrv':
                    if ( bcDB::resource( 'SCHEMA' ) ):
                        $fqn .= '[' . bcDB::resource( 'SCHEMA' ) . '].';
                    endif;
                    break;
                case 'sqlite':
                    //not supported, only tbl.column
                    break;
                case 'pgsql':
                    //todo
                    break;
                case 'oci':
                    //todo
                    break;
            endswitch;
        endif;


        //write properties as table names;
        $schemaConstants = null;

        //PHP DATA TYPES
        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP STRING DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_STRING' . ' = \'' . bcDB::TYPE_STRING . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP INTEGER DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_INTEGER' . ' = \'' . bcDB::TYPE_INTEGER . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP BOOLEAN DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_BOOLEAN' . ' = \'' . bcDB::TYPE_BOOL . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP FLOAT DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_FLOAT' . ' = \'' . bcDB::TYPE_FLOAT . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP LOB DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_LOB' . ' = \'' . bcDB::TYPE_LOB . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        $schemaConstants .= '    /**' . PHP_EOL;
        $schemaConstants .= '    * PHP NULL DATA TYPE ' . PHP_EOL;
        $schemaConstants .= '    * @var string' . PHP_EOL;
        $schemaConstants .= '    */' . PHP_EOL;
        $schemaConstants .= '    public static $TYPE_NULL' . ' = \'' . bcDB::TYPE_NULL . '\';' . PHP_EOL;
        $schemaConstants .= PHP_EOL;

        foreach ( $_tables as $t ):

            $sanitizedT = $t;
            //if table has a forbidden name then add a prefix '_BC' to the right of it. !IMPORTANT
            if ( array_key_exists( $t, $_forbidden ) ):
                $sanitizedT = $t . '_BC';
            endif;

            $schemaConstants .= '    /**' . PHP_EOL;
            $schemaConstants .= '    * TABLE ' . $t . PHP_EOL;
            $schemaConstants .= '    * @var string' . PHP_EOL;
            $schemaConstants .= '    */' . PHP_EOL;
            $schemaConstants .= '    const ' . $sanitizedT . ' = \'' . $fqn . $t . '\';' . PHP_EOL;
            $schemaConstants .= PHP_EOL;


            //start Table classes
            $tables = '<?php' . PHP_EOL;
            $tables .= 'namespace BriskCoder\Priv\Schema\\' . $class . ';' . PHP_EOL;
            $tables .= PHP_EOL;
            $tables .= 'final class ' . $sanitizedT . PHP_EOL;
            $tables .= '{' . PHP_EOL;
            $tables .= PHP_EOL;

            $tablesConstants = NULL;
            $tablesMethods = NULL;

            //built table column objects

            foreach ( $_columns[$t] as $c => $_types ):


                $tablesConstants .= '    /**' . PHP_EOL;
                $tablesConstants .= '    * TABLE ' . $t . ' COLUMN ' . $c . PHP_EOL;

                $tbl = $t . '.';
                if ( !$useFQN ):
                    $tbl = NULL;
                endif;

                $tablesConstants .= '    * @var string ' . $c . PHP_EOL;
                $tablesConstants .= '    */' . PHP_EOL;
                $tablesConstants .= '    const ' . $c . ' = \'' . $fqn . $tbl . $c . '\';' . PHP_EOL;
                $tablesConstants .= PHP_EOL;

                $tablesMethods .= '    /**' . PHP_EOL;
                $tablesMethods .= '    * TABLE ' . $t . ' COLUMN ' . $c . ' DATATYPES' . PHP_EOL;
                $tablesMethods .= '    * @return \BriskCoder\Package\Library\bcDB\Mapper\Architect\\' . bcDB::resource( 'RDBMS' ) . '\Types' . PHP_EOL;
                $tablesMethods .= '    */' . PHP_EOL;
                $tablesMethods .= '    public static function ' . $c . '()' . PHP_EOL;
                $tablesMethods .= '    {' . PHP_EOL;
                $tablesMethods .= '        $_dataTypes = array( ' . PHP_EOL;
                $tablesMethods .= '           \'type\' => \'' . $_types['type'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'size\' => \'' . $_types['size'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'unsigned\' => \'' . $_types['unsigned'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'collation\' => \'' . $_types['collation'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'null\' => \'' . $_types['null'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'key\'  => \'' . $_types['key'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'default\' => \'' . $_types['default'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'extra\' => \'' . $_types['extra'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'privileges\' => \'' . $_types['privileges'] . '\',' . PHP_EOL;
                $tablesMethods .= '           \'comment\' => \'' . $_types['comment'] . '\'' . PHP_EOL;
                $tablesMethods .= '        );' . PHP_EOL;
                $tablesMethods .= '        return new \BriskCoder\Package\Library\bcDB\Mapper\Architect\\' . bcDB::resource( 'RDBMS' ) . '\Types( $_dataTypes );' . PHP_EOL;
                $tablesMethods .= '    }' . PHP_EOL;
                $tablesMethods .= PHP_EOL;

            endforeach;

            $tables .= $tablesConstants;
            $tables .= '    private function __construct(){}' . PHP_EOL;
            $tables .= '    private function __clone(){}' . PHP_EOL;
            $tables .= PHP_EOL;
            $tables .= $tablesMethods;
            $tables .= '}' . PHP_EOL;

            //write Table classes
            file_put_contents( $pathSchema . $class . DIRECTORY_SEPARATOR . $sanitizedT . '.php', $tables );
        endforeach;

        $schema .= $schemaConstants;
        $schema .= PHP_EOL;
        $schema .= '    private function __construct(){}' . PHP_EOL;
        $schema .= '    private function __clone(){}' . PHP_EOL;
        $schema .= PHP_EOL;
        $schema .= '}' . PHP_EOL;
        //write Schema
        file_put_contents( $pathSchema . $class . '.php', $schema );
    }

    /**
     * Get SQL tables name from the current database connection
     * @return array
     */
    public function getTables()
    {
        try {
            $_tables = array();
            bcDB::mapper()->setFetch()->typeNum();
            bcDB::mapper()->show( 'TABLES' );
            $_tbl = bcDB::mapper()->fetch( TRUE );
            foreach ( $_tbl as $tbl ):
                $_tables[] = $tbl[0];
            endforeach;
            return $_tables;
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
        }
    }

    /**
     * Creates a SQL dump file from the current database connection 
     * Dumped File receives the current Catalog Name followed by .sql extension.
     * @param string $path FQN Path to save ending with trailing separator 
     * @param integer $type 1 = Dump structure and data | 2 = Dump data only | 3 = Dump structure only 
     * @param array $tables EXPORT specific tables only
     * @return void
     */
    public function exportFile( $path, $type = 1, $tables = array() )
    {
        $_tables = array();
        try {
            bcDB::mapper()->setFetch()->typeNum();
            bcDB::mapper()->show( 'TABLES' );
            $_t = bcDB::mapper()->fetch( TRUE );
            $i = 0;
            foreach ( $_t as $table ):
                if ( !empty( $tables ) && !in_array( $table[0], $tables ) ):
                    continue;
                endif;
                $_tables[$i]['name'] = $table[0];
                $_tables[$i]['create'] = $this->getColumns( $table[0] );
                $_tables[$i]['data'] = $this->getData( $table[0] );
                $i++;
            endforeach;
            unset( $_t );
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
            return;
        }

        $output = '-- BriskCoder::bcDB SQL Dump File' . PHP_EOL;
        $output .= '-- visit www.BriskCoder.com for license and information' . PHP_EOL;
        $output .= '-- -----------------------------------' . PHP_EOL . PHP_EOL;
        $output .= '-- TIME: ' . date( "Y-m-d H:i:s", time() ) . '   ZONE: ' . date_default_timezone_get() . PHP_EOL;
        $output .= '-- DSN: ' . bcDB::resource( 'HOST' ) . PHP_EOL;
        $output .= '-- SERVER VERSION: ' . bcDB::mapper()->getAttribute()->serverVersion() . PHP_EOL . PHP_EOL;
        foreach ( $_tables as $tbl ):
            if ( (int) $type === 1 || (int) $type === 3 ):
                $output .= 'DROP TABLE IF EXISTS `' . $tbl['name'] . '`;' . PHP_EOL;
                $output .= '-- Table structure for table `' . $tbl['name'] . '`' . PHP_EOL;
                $output .= $tbl['create'] . ";" . PHP_EOL . PHP_EOL;
            endif;
            if ( !empty( $tbl['data'] ) ):
                if ( (int) $type === 1 || (int) $type === 2 ):
                    $output .= '-- Dumping data for table `' . $tbl['name'] . '`' . PHP_EOL;
                    $output .= 'LOCK TABLES `' . $tbl['name'] . '` WRITE;' . PHP_EOL;
                    $output .= '/*!40000 ALTER TABLE `' . $tbl['name'] . '` DISABLE KEYS */;' . PHP_EOL;
                    $output .= $tbl['data'];
                    $output .= '/*!40000 ALTER TABLE `' . $tbl['name'] . '` ENABLE KEYS */;' . PHP_EOL;
                    $output .= 'UNLOCK TABLES;' . PHP_EOL . PHP_EOL;
                endif;
            endif;
        endforeach;
        $output .= '-- END OF SCRIPT';
        file_put_contents( $path . bcDB::resource( 'CATALOG' ) . '.sql', $output );
    }

    /**
     * Parses and Executes a SQL dump file to the current database connection 
     * @param string $file FileName of .SQL file to parse
     * @return void System Debugger is invoked if error
     */
    public function importFile( $file )
    {
        $handle = fopen( $file, "r" );
        $_lines = array();
        if ( $handle ) {
            while ( !feof( $handle ) ) {
                $_lines[] = fgets( $handle );
            }
            fclose( $handle );
        }

        $stmt = NULL;
        foreach ( $_lines as $query ) {
            $query = trim( $query );
            if ( ($query != NULL) && ('--' != substr( $query, 0, 2 )) && ('#' != substr( $query, 0, 2 )) ) {
                $stmt .= $query;
                if ( ';' === (substr( trim( $stmt ), -1 )) ):
                    try {
                        bcDB::sql()->query( $stmt );
                    } catch ( \PDOException $e ) {
                        bcDB::throwError( $e->getMessage() );
                        return;
                    }
                    $stmt = NULL;
                endif;
            }
        }
    }

    private function getColumns( $table )
    {
        try {
            bcDB::mapper()->show( 'CREATE TABLE', $table );
            $_cols = bcDB::mapper()->fetch( TRUE );
            $_cols[0][1] = preg_replace( "/AUTO_INCREMENT=[\w]*./", '', $_cols[0][1] );
            return $_cols[0][1];
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
            return FALSE;
        }
    }

    private function getData( $table )
    {
        try {
            bcDB::mapper()->setFetch()->typeNum();
            bcDB::mapper()->select( array(), $table );
            $_q = bcDB::mapper()->fetch( TRUE );
            $data = '';
            if ( $_q ):
                $c = count( $_q );
                $i = 1;
                foreach ( $_q as $pieces ):
                    foreach ( $pieces as &$value ):
                        if ( empty( $value ) ):
                            $value = 0;
                            continue;
                        endif;
                        $value = htmlentities( addslashes( $value ) );
                    endforeach;
                    if ( $i === 1 && $i === $c ):
                        $data .= 'INSERT INTO `' . $table . '` VALUES (\'' . implode( '\',\'', $pieces ) . '\');' . PHP_EOL;
                        $i++;
                        continue;
                    endif;

                    if ( $i === 1 ):
                        $data .= 'INSERT INTO `' . $table . '` VALUES (\'' . implode( '\',\'', $pieces ) . '\'),';
                        $i++;
                        continue;
                    endif;

                    if ( $i < $c ):
                        $data .= '(\'' . implode( '\',\'', $pieces ) . '\'),';
                        $i++;
                        continue;
                    endif;

                    $data .= '(\'' . implode( '\',\'', $pieces ) . '\');' . PHP_EOL;

                endforeach;
            endif;
            return $data;
        } catch ( \PDOException $e ) {
            bcDB::throwError( $e->getMessage() );
            return FALSE;
        }
    }

}
