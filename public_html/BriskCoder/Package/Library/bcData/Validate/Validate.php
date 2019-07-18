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

namespace BriskCoder\Package\Library\bcData;

final class Validate
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcData' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
     /**
     * VALIDATE URL ADDRESS
     * @param String $URL
     * @return boolean
     */
    public function domain($URL)
    {
        if(empty($URL)):
            return false;
        endif;
                
        if(filter_var($URL, FILTER_VALIDATE_URL )): 
            return true;
        endif;
        return false;
    }
    /**
     * VALIDATE EMAIL ADDRESS
     * @param String $EMAIL
     * @return boolean
     */
    public function email( $EMAIL )
    {
        if ( filter_var( $EMAIL, FILTER_VALIDATE_EMAIL ) ):
            return TRUE;
        endif;

        return FALSE;
    }

    /**
     * VALIDATE IP ADDRESS
     * @param String $IP_ADDRESS
     * @param Int $TYPE 0 = auto, 1 = IPV4, 2 = IPV6, default is 0
     * @return boolean
     */
    public function ipAddress( $IP_ADDRESS, $TYPE = 0 )
    {
        if ( !$TYPE ):
            if ( filter_var( $IP_ADDRESS, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ):
                return TRUE;
            elseif ( filter_var( $IP_ADDRESS, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ):
                return TRUE;
            endif;
            return FALSE;
        endif;

        if ( filter_var( $IP_ADDRESS, FILTER_VALIDATE_IP, ($TYPE === 2) ? FILTER_FLAG_IPV6 : FILTER_FLAG_IPV4  ) ):
            return TRUE;
        endif;
        return FALSE;
    }

    public function i18n()
    {
        static $obj;
        return $obj instanceof i18n ? $obj : $obj = new i18n( __CLASS__ );
    }

    /**
     * VALIDATE TYPE STRING ALPHANUMERIC
     * @param String $STRING
     * @return boolean
     */
    public function typeAlphaNumeric( $STRING )
    {
        if ( !$this->typeString( $STRING ) ):
            return FALSE;
        endif;

        return ctype_alnum($STRING);
    }
    
    /**
     * VALIDATE TYPE ARRAY  
     * @param Array $_ARRAY
     * @return Bool
     */
    public function typeArray( $_ARRAY )
    {
        return (array)$_ARRAY === $_ARRAY ? TRUE : FALSE;
    }
    
     /**
     * VALIDATE TYPE ARRAY RANGE 
     * If is type Array and In between min and max range
     * @param Array $_ARRAY
     * @param Integer $MIN
     * @param Integer $MAX
     * @return Bool
     */
    public function typeArrayRange( $_ARRAY, $MIN, $MAX )
    {
        $count = count($_ARRAY);
        return ( $this->typeArray( $_ARRAY ) && ( ($count >= $MIN) && ($count <= $MAX) ) ) ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE BOOLEAN  
     * @param Boolean $BOOLEAN
     * @return Bool
     */
    public function typeBoolean( $BOOLEAN )
    {
        return (boolean)$BOOLEAN === $BOOLEAN ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE DECIMAL
     * Differs than Float beause it will validate strings, as long is it's a decimal number  
     * @param Float $DECIMAL
     * @return Bool
     */
    public function typeDecimal( $DECIMAL )
    {
        return is_numeric( $DECIMAL ) && floor( $DECIMAL ) != $DECIMAL;
    }
    
    /**
     * VALIDATE TYPE DECIMAL RANGE 
     * If is type Decimal and In between min and max range
     * @param Decimal $DECIMAL
     * @param Decimal $MIN
     * @param Decimal $MAX
     * @return Bool
     */
    public function typeDecimalRange( $DECIMAL, $MIN, $MAX )
    {
        return ( $this->typeDecimal( $DECIMAL ) && ( ($DECIMAL >= $MIN) && ($DECIMAL <= $MAX) ) ) ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE FLOAT  
     * @param Float $FLOAT
     * @return Bool
     */
    public function typeFloat( $FLOAT )
    {
        return (float)$FLOAT === $FLOAT ? TRUE : FALSE;
    }
    
    /**
     * VALIDATE TYPE FLOAT RANGE 
     * If is type Float and In between min and max range
     * @param Float $FLOAT
     * @param Float $MIN
     * @param Float $MAX
     * @return Bool
     */
    public function typeFloatRange( $FLOAT, $MIN, $MAX )
    {
        return ( $this->typeFloat( $FLOAT ) && ( ($FLOAT >= $MIN) && ($FLOAT <= $MAX) ) ) ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE HEXADECIMAL 
     * Automatically Cleans 0x and # for CSS colors 
     * @param Hexadecimal $HEXADECIMAL
     * @return Bool
     */
    public function typeHex( $HEXADECIMAL )
    {
        if (!$this->typeString( $HEXADECIMAL ) || ! $this->typeInt( $INTEGER ) ):
            return FALSE;
        endif;
        return ctype_xdigit( str_replace( '0x', '', ltrim( $HEXADECIMAL, '#' ) ) );
    }

    /**
     * VALIDATE TYPE INTERGER  
     * @param Integer $INTEGER
     * @return Bool
     */
    public function typeInt( $INTEGER )
    {
        return (integer)$INTEGER === $INTEGER ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE INTERGER RANGE 
     * If is type Int and In between min and max range
     * @param Integer $INTEGER
     * @param Integer $MIN
     * @param Integer $MAX
     * @return Bool
     */
    public function typeIntRange( $INTEGER, $MIN, $MAX )
    {
        return ( $this->typeInt( $INTEGER ) && ( ($INTEGER >= $MIN) && ($INTEGER <= $MAX) ) ) ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE OBJECT
     * @param Mixed $OBJECT
     * @return Bool
     */
    public function typeObject( $OBJECT )
    {
        return (object)$OBJECT === $OBJECT ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE OCTAL
     * @param Mixed $OCTAL
     * @return Bool
     */
    public function typeOctal( $OCTAL )
    {
        if (!$this->typeString( $OCTAL ) || !$this->typeInt( $OCTAL ) ):
            return FALSE;
        endif;
        return decoct( octdec( $OCTAL ) ) == $OCTAL;
    }

    /**
     * VALIDATE TYPE NUMERIC
     * @param Mixed $NUMBER
     * @return Bool
     */
    public function typeNumeric( $NUMBER )
    {
        return is_numeric( $NUMBER );
    }

    /**
     * VALIDATE TYPE NUMERIC RANGE 
     * If is type Nummber and In between min and max range
     * @param Mixed $NUMBER
     * @param Mixed $MIN
     * @param Mixed $MAX
     * @return Bool
     */
    public function typeNumericRange( $NUMBER, $MIN, $MAX )
    {
        return ( $this->typeNumeric( $NUMBER ) && ( ($NUMBER >= $MIN) && ($NUMBER <= $MAX) ) ) ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE STRING  
     * @param String $STRING
     * @return Bool
     */
    public function typeString( $STRING )
    {
        return (string)$STRING === $STRING ? TRUE : FALSE;
    }

    /**
     * VALIDATE TYPE STRING RANGE  
     * If is type String and has characters in between min and max range 
     * @param String $STRING
     * @param Integer $MIN Minimum characters
     * @param Integer $MAX Maximum characters
     * @return Bool
     */
    public function typeStringRange( $STRING, $MIN, $MAX )
    {
        if( !$this->typeString( $STRING ) ):
             return FALSE;
        endif;
       
        $strLen = strlen( $STRING );
        return  ( ($strLen >= $MIN) && ($strLen <= $MAX) ) ? TRUE : FALSE;
    }
    
    
}
