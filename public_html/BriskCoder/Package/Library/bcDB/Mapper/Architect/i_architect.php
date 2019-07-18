<?php

namespace BriskCoder\Package\Library\bcDB\Mapper\Architect;

interface i_architect
{

    /**
     * Path to save the Schema Assets, otherwise
     * BriskCoder/Priv/ is default and will be used.
     * Make sure the Path is writable
     * To change default set it before using bcDB::mapper()->architect()->build()
     * @param string $save_path  Custom Path to save the Schema Assets
     */
    public function setSavePath( $save_path );

    /**
     * Build current Database Schema Class Interpreter . Default TRUE. 
     * To change default set it to FALSE and before using bcDB::mapper()->architect()->build()
     * @param Boolean $build_schema
     */
    public function setSchema( $build_schema );

    /**
     * Builds current Database Model Loader Class Interpreter. Default TRUE. 
     * To change default set it to FALSE and before using bcDB::mapper()->architect()->build()
     * @param Boolean $build_data_object
     */
    public function setDataObject( $build_data_object );

    /**
     * PROJECT_PACKAGE name that the Logic\Model namespace belongs to
     * Required and must be set before using bcDB::mapper()->architect()->build()
     * @param Boolean $project_package
     */
    public function setProjectPackage( $project_package );

    /**
     * EXECUTES THE BUILDER
     * If any previous structure exists and $CLEAR is FALSE then it does not run.
     * @param \BriskCoder\Package\Library\bcDB $bcDB 
     * @param bool $CLEAR Forces Delete Old Schema | Model Interpreters
     * @return bool
     */
    public function build( $CLEAR = FALSE );

    /**
     * Get SQL tables name from the current database connection
     * @return array
     */
    public function getTables();

    /**
     * Creates a SQL dump file from the current database connection 
     * Dumped File receives the current Catalog Name followed by .sql extension.
     * @param string $path FQN Path to save ending with trailing separator 
     * @param integer $type 1 = Dump structure and data | 2 = Dump data only | 3 = Dump structure only 
     * @param array $tables EXPORT specific tables only
     * @return void
     */
    public function exportFile( $path, $type = 1, $tables = array() );

    /**
     * Parses and Executes a SQL dump file to the current database connection 
     * @param string $file FileName of .SQL file to parse
     * @return void System Debugger is invoked if error
     */
    public function importFile( $file );
}
