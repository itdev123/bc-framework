<?php

/**
 * Facebook Component
 * @author Emily
 */

namespace BriskCoder\Package\Component\bcFormControl\UiWizard\Login;

use BriskCoder\Package\Library\bcHTML;

final class Facebook
{

    public
    /**
     * Login With Facebook
     * Set facebook app id to use facebook button. Default FALSE
     * @var string $APP_ID 
     */
            $APP_ID = FALSE,
            /**
             * Login With Facebook App Scret
             * Set facebook app secret . Default NULL
             * @var string $APP_SECRET
             */
            $APP_SECRET = '',
            /**
             * Login With Facebook Callback
             * Set callback to send response to. Default current url
             * @var string $CALLBACK 
             */
            $CALLBACK = '',
            /**
             * Login With Facebook Button Label
             * Set facebook login button label
             * @var string $BUTTON_LABEL
             */
            $BUTTON_LABEL = NULL,
            /**
             * Login With Facebook User Not Authorized Message Popup Title
             * Set popup title to use with the popup message if user deny your app to login with facebook
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_TITLE
             */
            $NOT_AUTHORIZED_MSG_TITLE = '',
            /**
             * Login With Facebook User Not Authorized Message Popup Close Button title
             * Set popup close button title to use with the popup message if user deny your app to login with facebook
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CLOSE_BTN 
             */
            $NOT_AUTHORIZED_MSG_CLOSE_BTN = '',
            /**
             * Login With Facebook User Not Authorized Message Popup Confirm Button title
             * Set popup confirm button title to use with the popup message if user deny your app to login with facebook
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CONFIRM_BTN 
             */
            $NOT_AUTHORIZED_MSG_CONFIRM_BTN = '',
            /**
             * Login With Facebook User Not Authorized Message
             * Set popup message to display when the popup is shown if user deny your app to login with facebook
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
     * Get Facebook Button     
     * @return string
     */
    public function getMarkup()
    {
        if ( $this->APP_ID !== FALSE ):
            if ( !empty( $this->NOT_AUTHORIZED_MSG ) ):
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CLOSE_BTN, array( 'class="button-close"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_TITLE . bcHTML::tag()->getMarkup(), array( 'class="title"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG, array( 'class="text"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CONFIRM_BTN, array( 'class="button-confirm"' ) );
                bcHTML::tag()->div( bcHTML::tag()->getMarkup(), array( 'id="bcFormControl-login-fb-msg"' ) );
            endif;
            bcHTML::tag()->div( $this->BUTTON_LABEL, array( 'data-bcFormControl-login-fb-appid="' . $this->APP_ID . '"', 'data-bcFormControl-login-callback="' . $this->CALLBACK . '"', 'data-bcFormControl-login-redirect="' . $this->ON_SUCCESS_REDIRECT . '"', 'class="bcFormControl-login-fb"' ) );
            return bcHTML::tag()->getMarkup();
        endif;
        return NULL;
    }

}
