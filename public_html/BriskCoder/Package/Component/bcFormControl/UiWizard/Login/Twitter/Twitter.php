<?php

/**
 * Twitter Component
 * @author Emily
 */

namespace BriskCoder\Package\Component\bcFormControl\UiWizard\Login;

use BriskCoder\Package\Library\bcHTML;

final class Twitter
{

    public
    /**
     * Login With Twitter Account
     * Set twitter client id to use twitter button. Default FALSE            
     * @var string $CONSUMER_KEY 
     */
            $CONSUMER_KEY = FALSE,
            /**
             * Login With Twitter Secret
             * Set twitter secret. Default FALSE            
             * @var string $CONSUMER_SECRET 
             */
            $CONSUMER_SECRET = NULL,
            /**
             * Login With Twitter Token
             * Set twitter token. Default FALSE            
             * @var string $TOKEN 
             */
            $TOKEN = NULL,
            /**
             * Login With Twitter Callback
             * Set callback to send response to. Default null
             * @var string $CALLBACK 
             */
            $CALLBACK = NULL,
            /**
             *  Login With Twitter Account Button Label
             * Set Twitter login button label
             * @var string $BUTTON_LABEL 
             */
            $BUTTON_LABEL = NULL,
            /**
             * Login With Twitter User Not Authorized Message Popup Title
             * Set popup title to use with the popup message if user deny your app to login with twitter
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_TITLE 
             */
            $NOT_AUTHORIZED_MSG_TITLE = '',
            /**
             * Login With Twitter User Not Authorized Message Popup Close Button title
             * Set popup close button title to use with the popup message if user deny your app to login with twitter
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CLOSE_BTN 
             */
            $NOT_AUTHORIZED_MSG_CLOSE_BTN = '',
            /**
             * Login With Twitter User Not Authorized Message Popup Confirm Button title
             * Set popup confirm button title to use with the popup message if user deny your app to login with twitter
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CONFIRM_BTN 
             */
            $NOT_AUTHORIZED_MSG_CONFIRM_BTN = '',
            /**
             * Login With Twitter User Not Authorized Message
             * Set popup message to display when the popup is shown if user deny your app to login with twitter
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG 
             */
            $NOT_AUTHORIZED_MSG = '',
            /**
             * Url to redirect after user is logged in
             * @var string $ON_SUCCESS_REDIRECT 
             */
            $ON_SUCCESS_REDIRECT = '/';

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Component\bcFormControl\UiWizard\Login' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Get Twiiter Button     
     * @return string
     */
    public function getMarkup()
    {
        if ( $this->CONSUMER_KEY !== FALSE ):
            if ( isset( $_GET['bc_twitter_login'] ) ):
                /* Before click, just giving authorization for twitter */
                $_r = '';

                $randomStr = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $randomStrLength = strlen( $randomStr );
                $random_str = '';
                for ( $i = 0; $i < $randomStrLength; $i++ ) {
                    $random_str .= $randomStr[rand( 0, strlen( $randomStr ) - 1 )];
                }

                $_oauth = array( 'oauth_callback' => $this->CALLBACK,
                    'oauth_consumer_key' => $this->CONSUMER_KEY,
                    'oauth_nonce' => base64_encode( $random_str ),
                    'oauth_signature_method' => 'HMAC-SHA1',
                    'oauth_timestamp' => time(),
                    'oauth_version' => '1.0'
                );

                $baseURI = 'https://api.twitter.com/oauth/request_token';

                $_baseString = array();
                ksort( $_oauth );
                foreach ( $_oauth as $key => $value ) {
                    $_baseString[] = "$key=" . rawurlencode( $value );
                }

                $hash_hmac_post = 'POST&' . rawurlencode( $baseURI ) . '&' . rawurlencode( implode( '&', $_baseString ) );
                $hash_hmac_secret = rawurlencode( $this->CONSUMER_SECRET ) . '&' . rawurlencode( null );
                $hash_hmac = hash_hmac( 'sha1', $hash_hmac_post, $hash_hmac_secret, true );
                $oauth_signature = base64_encode( $hash_hmac );

                $_oauth['oauth_signature'] = $oauth_signature;

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
                    $_response[$_v[0]] = $_v[1];
                endforeach;

                if ( $_response['oauth_callback_confirmed'] === 'true' ):
                    $_r['oauth_token'] = $_response['oauth_token'];
                    $_r['oauth_token_secret'] = $_response['oauth_token_secret'];
                    $_r['redirect'] = 'https://api.twitter.com/oauth/authenticate?oauth_token=' . $_response['oauth_token'];
                endif;

                exit( json_encode( $_r ) );
            endif;

            if ( isset( $_GET['bc_twitter_login_status'] ) ):
                /* on page load getting denied message */
                $_response = array();
                if ( isset( $_GET['denied'] ) ):
                    $_response['status'] = 'denied';
                    if ( !empty( $this->NOT_AUTHORIZED_MSG ) ):
                        $_response['message'] = 'denied msg';
                    endif;
                endif;
                exit( json_encode( $_response ) );
            endif;

            if ( !empty( $this->NOT_AUTHORIZED_MSG ) ):
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CLOSE_BTN, array( 'class="button-close"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_TITLE . bcHTML::tag()->getMarkup(), array( 'class="title"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG, array( 'class="text"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CONFIRM_BTN, array( 'class="button-confirm"' ) );
                bcHTML::tag()->div( bcHTML::tag()->getMarkup(), array( 'id="bcFormControl-login-twitter-msg"' ) );
            endif;
            bcHTML::tag()->div( $this->BUTTON_LABEL, array( 'class="bcFormControl-login-t"', 'data-bcFormControl-login-callback="' . $this->CALLBACK . '"', 'data-bcFormControl-login-redirect="' . $this->ON_SUCCESS_REDIRECT . '"', 'id="bcFormControl-login-t"' ) );
            return bcHTML::tag()->getMarkup();
        endif;
        return NULL;
    }

}
