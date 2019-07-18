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

use BriskCoder\bc,
    BriskCoder\Package\Library\bcImage\Filters;

class bcImage
{

    public static
    /**
     * JPG QUALITY<br>
     * 0 - 100  Default is 75 
     * @var Integer $JPG_QUALITY Default 75
     */
            $JPG_QUALITY = 80,
            /**
             * PNG COMPRESSION LEVEL<br>
             * It only affect file size and not image quality.<br>
             * 0 - 9  Default is 4 
             *  @var Integer $PNG_COMPRESSION Default 4
             */
            $PNG_COMPRESSION = 0,
            /**
             * PNG FILTERS<br>
             * Options are: <br>
             * PNG_ALL_FILTERS Default <br>
             * PNG_FILTER_AVG <br>
             * PNG_FILTER_NONE <br>
             * PNG_FILTER_PAETH <br>
             * PNG_FILTER_SUB <br>
             * PNG_FILTER_UP <br>
             * PNG_NO_FILTER <br>
             * @var Integer $PNG_FILTER PNG_ALL_FILTERS Default
             */
            $PNG_FILTER = PNG_ALL_FILTERS;
    private static
    /**
     * CURRENT IMAGE RESOURCE IDENTIFIER
     * @var String $img
     */
            $newImg = FALSE,
            $newImgWidth,
            $newImgHeight,
            $_newImgCanvas = array( 'r' => 0, 'g' => 0, 'b' => 0, 'a' => 0 ),
            $srcImg = FALSE,
            $_srcImgData;

    /**
     * CREATE NEW IMAGE
     * @param Integer $WIDTH Image Width
     * @param Integer $HEIGHT Image Height
     * @param Integer $R 0-255 Red 
     * @param Integer $G 0-255 Green
     * @param Integer $B 0-255 Blue
     * @param Integer $A 0-100 Alpha Transparency 0 = solid | 100 transparent or 1-99 alpha channels for png
     * @return Void
     */
    public static function create( $WIDTH, $HEIGHT, $R, $G, $B, $A )
    {

        self::$newImgWidth = $WIDTH;
        self::$newImgHeight = $HEIGHT;
        self::$newImg = imagecreatetruecolor( self::$newImgWidth, self::$newImgHeight );

        self::$_newImgCanvas['r'] = (int) $R;
        self::$_newImgCanvas['g'] = (int) $G;
        self::$_newImgCanvas['b'] = (int) $B;
        self::$_newImgCanvas['a'] = (int) round( (127 / 100) * (int) $A );
    }

    /**
     * RESIZE IMAGE FROM SOURCE<br>
     * If both $WIDTH & $HEIGHT are set, then aspect ratio will not be maintained.
     * @param Integer $WIDTH New Image Width | NULL if aspect ration will use height as constraint.
     * @param Integer $HEIGHT New Image Height | NULL if aspect ration will use Width as constraint.
     * @return Void
     */
    public static function resize( $WIDTH, $HEIGHT )
    {
        if ( !self::$srcImg ):
            return FALSE;
        endif;

        $srcWidth = (int) self::$_srcImgData[0];
        $srcHeight = (int) self::$_srcImgData[1];

        if ( $WIDTH && empty( $HEIGHT ) ):
            $f = (float) $WIDTH / (float) $srcWidth;
            $HEIGHT = $f * $srcHeight;
        elseif ( empty( $WIDTH ) && $HEIGHT ):
            $f = (float) $HEIGHT / (float) $srcHeight;
            $WIDTH = $f * $srcWidth;
        endif;

        self::$newImgWidth = $WIDTH;
        self::$newImgHeight = $HEIGHT;
        self::$newImg = imagecreatetruecolor( self::$newImgWidth, self::$newImgHeight );

        imagecopyresampled( self::$newImg, self::$srcImg, 0, 0, 0, 0, $WIDTH, $HEIGHT, $srcWidth, $srcHeight );
    }

    /**
     * OPEN IMAGE FROM SOURCE
     * For now only supports PNG|GIF|JPG
     * @return Boolean FALSE on fail
     */
    public static function open( $FILENAME )
    {
        if ( !is_file( $FILENAME ) ):
            return FALSE;
        endif;

        self::$_srcImgData = getimagesize( $FILENAME );
        //depends on the extension type
        switch ( self::$_srcImgData['mime'] ):
            case 'image/png':
                self::$srcImg = imagecreatefrompng( $FILENAME );
                break;
            case 'image/jpeg':
                self::$srcImg = imagecreatefromjpeg( $FILENAME );
                break;
            case 'image/gif':
                self::$srcImg = imagecreatefromgif( $FILENAME );
                break;
        //todo other types
        endswitch;

        return TRUE;
    }

    /**
     * SAVE IMAGE
     * For now only supports PNG|GIF|JPG
     * @return Boolean FALSE on fail
     */
    public static function save( $FILENAME )
    {
        if ( !self::$newImg && !self::$srcImg ):
            return FALSE;
        endif;
        //depends on the extension type
        switch ( pathinfo( $FILENAME, PATHINFO_EXTENSION ) ):
            case 'png':
                if ( self::$newImg && self::$srcImg )://both new and existing

                    imagepng( self::$newImg, $FILENAME, self::$PNG_COMPRESSION, self::$PNG_FILTER );

                elseif ( self::$newImg && !self::$srcImg )://new image only
                    //handle background colors and alpha channel

                    $bg = imagecolorallocatealpha( self::$newImg, self::$_newImgCanvas['r'], self::$_newImgCanvas['g'], self::$_newImgCanvas['b'], self::$_newImgCanvas['a'] );
                    imagefill( self::$newImg, 0, 0, $bg );
                    imagealphablending( self::$newImg, FALSE );
                    imagesavealpha( self::$newImg, TRUE );

                    imagepng( self::$newImg, $FILENAME, self::$PNG_COMPRESSION, self::$PNG_FILTER );
                elseif ( !self::$newImg && self::$srcImg )://existing image

                    imagealphablending( self::$srcImg, FALSE );
                    imagesavealpha( self::$srcImg, TRUE );

                    imagepng( self::$srcImg, $FILENAME, self::$PNG_COMPRESSION, self::$PNG_FILTER );
                endif;

                break;
            case 'jpg':
                if ( self::$newImg && self::$srcImg )://both new and existing

                    imagejpeg( self::$newImg, $FILENAME, self::$JPG_QUALITY );

                elseif ( self::$newImg && !self::$srcImg )://new image only
                    //handle background colors
                    $bg = imagecolorallocate( self::$newImg, self::$_newImgCanvas['r'], self::$_newImgCanvas['g'], self::$_newImgCanvas['b'] );
                    imagefill( self::$newImg, 0, 0, $bg );


                    imagejpeg( self::$newImg, $FILENAME, self::$JPG_QUALITY );
                elseif ( !self::$newImg && self::$srcImg )://existing image


                    imagejpeg( self::$srcImg, $FILENAME, self::$JPG_QUALITY );
                endif;
                break;
            case 'gif':
                if ( self::$newImg && self::$srcImg )://both new and existing

                    imagegif( self::$newImg, $FILENAME );

                elseif ( self::$newImg && !self::$srcImg )://new image only
                    //handle background tranparency
                    if ( self::$_newImgCanvas['a'] !== 0 ):
                        imagecolortransparent( self::$newImg, imagecolorallocatealpha( self::$newImg, 0, 0, 0, 0 ) );
                        imagealphablending( self::$newImg, FALSE );
                        imagesavealpha( self::$newImg, TRUE );
                    else:
                        //colorfull background
                        $bg = imagecolorallocate( self::$newImg, self::$_newImgCanvas['r'], self::$_newImgCanvas['g'], self::$_newImgCanvas['b'] );
                        imagefill( self::$newImg, 0, 0, $bg );
                    endif;

                    imagegif( self::$newImg, $FILENAME );
                elseif ( !self::$newImg && self::$srcImg )://existing image

                    imagealphablending( self::$srcImg, FALSE );
                    imagesavealpha( self::$srcImg, TRUE );

                    imagegif( self::$srcImg, $FILENAME );
                endif;
                break;
        //todo other types
        endswitch;

        if ( self::$newImg ):
            imagedestroy( self::$newImg );
        endif;
        if ( self::$srcImg ):
            imagedestroy( self::$srcImg );
        endif;
        return TRUE;
    }

    /**
     * IMAGE FILTERS
     * @staticvar Filter $obj
     * @return \BriskCoder\Package\Library\bcImage\Filters
     */
    public static function filter()
    {
        static $obj;
        return $obj instanceof Filters ? $obj : $obj = new Filters( __CLASS__ );
    }

}
