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
 * @author RJ Anderson <rj@xpler.com>
 */

namespace BriskCoder\Package\Library;

use BriskCoder\bc;

class bcUpload
{

    public static

    /**
     * DIRECTORY PATH TO STORE UPLOADED CONTENT
     * @var string $DIR_PATH Default is NULL
     */
            $DIR_PATH = NULL,
            /**
             * NONE OF MULTIPLE FILES IS UPLOADED IF ANY FAILS 
             * @var Boolean $HALT_ON_FAIL 
             */
            $HALT_ON_FAIL = TRUE,
            /**
             * EXTENTION TYPES ALLOWED
             * Default array( 'jpg', 'png', 'gif', 'pdf', 'txt', 'csv' );
             * @var Array $_MIME_TYPES  
             */
            $_MIME_TYPES = array(),
            /**
             * MULTIPLE UPLOAD MAX FILES
             * NOTE: php ini max_file_uploads limits the amount of files when multiple uploads.<br>
             * @var Int $MAX_FILES Default is 5
             */
            $MAX_FILES = 5,
            /**
             * UPLOAD MAX SIZE
             * NOTE: This is limited by upload_max_filesize and post_max_size in php ini.<br>
             * Accepted Array Types: array( 10 => 'M')<br>
             * digital unit values are:<br>
             * K|k = Kilobytes<br>
             * M|m = Megabytes<br> 
             * G|g = Gigabytes<br>
             * T\t = Terabytes<br>    
             * @var Array $_MAX_SIZE Default is array( 'M' => 10 ) accepts decimals
             */
            $_MAX_SIZE = array();
    private static
            $_ns = array(),
            $currNS = NULL,
            $_errors = array();

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    /**
     * bcUpload NAMESPACE
     * Namespaces must match each input type file parameter name.<br>
     * Each namespace may have its own group of settings:<br>
     * bcUpload::$DIR_PATH, bcUpload::$_MIME_TYPES, bcUpload::$MAX_FILES, bcUpload::$_MAX_SIZE etc...<br>
     * @return Void
     */
    public static function useNamespace( $NAMESPACE )
    {
        self::$currNS = $NAMESPACE;
        //namespace exists?
        if ( isset( self::$_ns[$NAMESPACE] ) ):
            return;
        endif;

        self::$_ns[self::$currNS]['DIR_PATH'] = self::$DIR_PATH;
        self::$_ns[self::$currNS]['HALT_ON_FAIL'] = self::$HALT_ON_FAIL;
        self::$_ns[self::$currNS]['_MIME_TYPES'] = empty( self::$_MIME_TYPES ) ? array( 'jpg', 'png', 'gif', 'pdf', 'txt', 'csv' ) : self::$_MIME_TYPES;
        self::$_ns[self::$currNS]['MAX_FILES'] = self::$MAX_FILES;
        self::$_ns[self::$currNS]['_MAX_SIZE'] = empty( self::$_MAX_SIZE ) ? array( 'M' => 10 ) : self::$_MAX_SIZE;


        //reset to defaults
        self::$DIR_PATH = NULL;
        self::$HALT_ON_FAIL = TRUE;
        self::$_MIME_TYPES = array();
        self::$MAX_FILES = '5';
        self::$_MAX_SIZE = array();
    }

    /**
     * Checks if bcUpload Namespace is set
     * @param string $namespace bcUpload namespace
     * @return bool
     */
    public static function hasNamespace( $NAMESPACE )
    {
        return isset( self::$_ns[$NAMESPACE] ) ? TRUE : FALSE;
    }

    /**
     * Gets current namespace
     * @return string 
     */
    public static function getNamespace()
    {
        return self::$currNS;
    }

    /**
     * Gets Errors By Current Namespace ERROR_MAX_FILES<br>
     * [index]['ERROR_EMPTY'] = 'namespace' //nothing posted<br>
     * [index]['ERROR_MAX_FILES'] = 'max_files_number' //exceeded max files <br>
     * [index]['ERROR_FILE'] = 'field number' //empty field<br>
     * [index]['ERROR_EXT'] = 'field number' //extension not allowed<br>
     * [index]['ERROR_MAX_SIZE'] = 'field number' //file max size exceeded<br>
     * [index]['ERROR_TMP'] = 'field number' //temp file not found<br>
     * @return Array 
     */
    public static function getErrors()
    {
        //namespace exists?
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'bcUpload::1000';
            bc::debugger()->invoke();
            return FALSE;
        endif;

        return self::$_errors;
    }

    /**
     * UPLOAD FILE 
     * Returns: <br>
     * $_uploads[namespace][index_order]['NAME'], original file name <br>
     * $_uploads[namespace][index_order]['HASH'], md5 hash name<br>
     * $_uploads[namespace][index_order]['EXT'], extension name<br>
     * $_uploads[namespace][index_order]['TMP'], temp php file name<br>
     * or empty array when failed
     * @return Array
     */
    public static function move()
    {
        //namespace exists?
        if ( !isset( self::$_ns[self::$currNS] ) ):
            bc::debugger()->CODE = 'bcUpload::1000';
            bc::debugger()->invoke();
            return FALSE;
        endif;

        if ( empty( $_POST ) || empty( $_FILES ) ):
            self::$_errors[self::$currNS][0]['ERROR_EMPTY'] = self::$currNS;
            return FALSE;
        endif;

        if ( !empty( array_diff_key( $_FILES, self::$_ns ) ) ):
            bc::debugger()->CODE = 'bcUpload::1001';
            bc::debugger()->invoke();
        endif;

        $error = FALSE;
        $_uploads = array();
        foreach ( $_FILES as $ns => $_input ):
            $c = count( $_FILES[$ns]['name'] );

            //exceeded max files upload number?
            if ( $c > self::$MAX_FILES ):
                self::$_errors[$ns][0]['ERROR_MAX_FILES'] = self::$_ns[$ns]['MAX_FILES'];
                continue;
            endif;


            for ( $i = 0; $i < $c; $i++ ):

                $idx = ($i + 1);
                //empty?
                if ( empty( $_FILES[$ns]['name'][$i] ) ):
                    //collect error messages
                    self::$_errors[$ns][0]['ERROR_FILE'] = $idx;
                    continue;
                endif;

                //is tmp in the server
                if ( !is_uploaded_file( $_FILES[$ns]['tmp_name'][$i] ) || !file_exists( $_FILES[$ns]['tmp_name'][$i] ) ):
                    self::$_errors[$ns][$idx]['ERROR_TMP'] = $_FILES[$ns]['name'][$i];
                    $error = TRUE;
                endif;

                //file extension allowed?
                $fname = pathinfo( $_FILES[$ns]['name'][$i], PATHINFO_FILENAME );
                $ext = pathinfo( $_FILES[$ns]['name'][$i], PATHINFO_EXTENSION );
                if ( !in_array( $ext, self::$_ns[$ns]['_MIME_TYPES'] ) ):
                    self::$_errors[$ns][$idx]['ERROR_EXT'] = $_FILES[$ns]['name'][$i];
                    $error = TRUE;
                endif;

                //file size allowed?
                $unity = key( self::$_ns[$ns]['_MAX_SIZE'] );
                $size = self::$_ns[$ns]['_MAX_SIZE'][$unity];

                switch ( strtolower( $unity ) ):
                    case 'k':
                        if ( $_FILES[$ns]['size'][$i] > ($size * 1024) ):
                            self::$_errors[$ns][$idx]['ERROR_MAX_SIZE'] = $_FILES[$ns]['name'][$i];
                            $error = TRUE;
                        endif;
                        break;
                    case 'm':
                        if ( $_FILES[$ns]['size'][$i] > ($size * 1024 * 1024) ):
                            self::$_errors[$ns][$idx]['ERROR_MAX_SIZE'] = $_FILES[$ns]['name'][$i];
                            $error = TRUE;
                        endif;
                        break;
                    case 'g':
                        if ( $_FILES[$ns]['size'][$i] > ($size * 1024 * 1024 * 1024) ):
                            self::$_errors[$ns][$idx]['ERROR_MAX_SIZE'] = $_FILES[$ns]['name'][$i];
                            $error = TRUE;
                        endif;
                        break;
                    case 't':
                        if ( $_FILES[$ns]['size'][$i] > ($size * 1024 * 1024 * 1024 * 1024) ):
                            self::$_errors[$ns][$idx]['ERROR_MAX_SIZE'] = $_FILES[$ns]['name'][$i];
                            $error = TRUE;
                        endif;
                        break;
                endswitch;

                //has any error?
                if ( $error ):
                    continue;
                endif;

                //add to $_uploads collection
                $_uploads[$ns][$idx]['NAME'] = $fname;
                $_uploads[$ns][$idx]['HASH'] = hash( 'md5', time() . mt_rand( 1, mt_getrandmax() ) . $fname );
                $_uploads[$ns][$idx]['EXT'] = $ext;
                $_uploads[$ns][$idx]['TMP'] = $_FILES[$ns]['tmp_name'][$i];
            endfor;
            //reference
            //$_input['name'][]
            //$_input['tmp_name'][]
            //$_input['size'][]
            //$_input['type'][]
            //current ns has errors and should halt?
            if ( !empty( self::$_errors[$ns] ) && self::$_ns[$ns]['HALT_ON_FAIL'] ):
                continue;
            endif;

            foreach ( $_uploads as $n => $_f ):
                foreach ( $_f as $o => $k ):
                    move_uploaded_file( $k['TMP'], self::$_ns[$n]['DIR_PATH'] . $k['HASH'] . '.' . $k['EXT'] );
                endforeach;
            endforeach;

        endforeach;

        return $_uploads;
    }
}