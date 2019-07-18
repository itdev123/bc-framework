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

/**
 * Mail
 * @category    Library
 * @package     Package
 */
class bcMail
{

    public static
    /**
     * Sets the email sender.
     * @var string 
     */
            $FROM = NULL,
            /**
             * Sets the email's recipient.
             * If multiple then use CSV.
             * @var string 
             */
            $TO = NULL,
            /**
             * Sets the email's return envelope.
             * @var string 
             */
            $REPLY_TO = NULL,
            /**
             * Sets the email SUBJECT
             * @var string 
             */
            $SUBJECT = NULL,
            /**
             * Sets the email message
             * @var string 
             */
            $MESSAGE = NULL,
            /**
             * Sets email sender's organisation
             * @var string  
             */
            $ORGANIZATION = NULL,
            /**
             * Sets charset encoding
             * @var string
             */
            $CHARSET = 'utf-8',
            /**
             * Sets email receipt request
             * @var bool  
             */
            $RECEIPT = FALSE,
            /**
             * Sets email priority level
             * @var int 1=Highest, 2=High, 3=Normal, 4=Low, 5=Lowest
             */
            $PRIORITY = 3;
    private static
            $_headers = array(),
            $_attachments = array(),
            $mailer = 'BriskCoder Mail - Xpler Corporation/1.0.0';

    private function __construct()
    {
        
    }

    /**
     * Sets the email carbon copies. If multiple then use CSV.
     * @param string $CC 
     */
    public static function cc( $CC )
    {
        self::$_headers['CC'] = $CC;
    }

    /**
     * Sets the email blind carbon copies. If multiple then use CSV.
     * @param string $BCC 
     */
    public static function bcc( $BCC )
    {
        self::$_headers['BCC'] = $BCC;
    }

    /**
     * Sets email attachments. If multiple then
     */
    public static function attachment( $FILENAME )
    {
        self::$_attachments[] = $FILENAME;
    }

    /**
     * Sends the email.
     * @return bool 
     */
    public static function send()
    {
        $headers = self::buildMail();
        mail( self::$TO, self::$SUBJECT, self::$MESSAGE, $headers );
    }

    /**
     * Build mail headers
     * @return string 
     */
    private static function buildMail()
    {
        $h = '';
        if ( isset( self::$REPLY_TO ) ):
            $h .= 'Reply-To: ' . self::$REPLY_TO . PHP_EOL;
        endif;

        if ( isset( self::$FROM ) ):
            $h .= 'From: ' . self::$FROM . PHP_EOL;
        endif;

        foreach ( self::$_headers as $k => $v ):
            $h .= $k . ': ' . $v . PHP_EOL;
        endforeach;

        if ( isset( self::$ORGANIZATION ) ):
            $h .= 'Organization: ' . self::$ORGANIZATION . PHP_EOL;
        endif;

        $h .= 'MIME-Version: 1.0' . PHP_EOL;


        if ( count( self::$_attachments ) != 0 ):
            $mix = TRUE;

            $boundary = 'BriskCoder_' . mt_rand( 100, 999 ) . '_' . md5( $_SERVER['REQUEST_TIME'] ) . '_' . mt_rand( 100000, 999999 );

            $h .= 'Content-type: multipart/mixed; boundary="' . $boundary . '"' . PHP_EOL;

            $message = 'This is a multi-part message in MIME format.' . PHP_EOL . PHP_EOL;
            $message .= '--' . $boundary . PHP_EOL;
            $message .= self::typeHTML() . PHP_EOL;
            $message .= self::$MESSAGE . PHP_EOL;

            $f = new \finfo( \FILEINFO_MIME_TYPE );

            foreach ( self::$_attachments as $att ):
                $message .= '--' . $boundary . PHP_EOL;
                $message .= 'Content-type: ' . $f->file( $att ) . '; name="' . basename( $att ) . '"' . PHP_EOL;
                $message .= 'Content-Transfer-Encoding: base64' . PHP_EOL;
                $message .= 'Content-Disposition: attachment; filename="' . basename( $att ) . '"' . PHP_EOL . PHP_EOL;
                $message .= chunk_split( base64_encode( file_get_contents( $att ) ) ) . PHP_EOL;
            endforeach;

            $message .= '--' . $boundary . '--' . PHP_EOL;
            self::$MESSAGE = $message;

        else:
            $h .= self::typeHTML();
        endif;

        $h .= 'X-Priority: ' . self::$PRIORITY . PHP_EOL;
        $h .= 'X-Mailer: ' . self::$mailer . PHP_EOL;

        $receipt = isset( self::$_headers['Reply-To'] ) ? self::$_headers['Reply-To'] : self::$FROM;
        $h .= 'Disposition-Notification-To: ' . $receipt . PHP_EOL . PHP_EOL;

        return $h;
    }

    /**
     * Mail HTML Header parser
     * @return string
     */
    private static function typeHTML()
    {
        $h = 'Content-type: text/html; charset="' . self::$CHARSET . '"' . PHP_EOL;
        $bit = (strtolower( self::$CHARSET ) === 'utf-8') ? '8bit' : '7bit';
        $h .= 'Content-Transfer-Encoding: ' . $bit . PHP_EOL;
        return $h;
    }

}
