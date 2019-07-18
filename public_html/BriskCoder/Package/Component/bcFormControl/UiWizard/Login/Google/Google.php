<?php

/**
 * Google Component
 * @author Emily
 */

namespace BriskCoder\Package\Component\bcFormControl\UiWizard\Login;

use BriskCoder\Package\Library\bcHTML;

final class Google
{

    public
    /**
     * Login With Google Account
     * Set google client id to use google button. Default FALSE
     * Digits before the dot only, no need to enter(.apps.googleusercontent.com) only digits before that.
     * @var string $CLIENT_ID 
     */
            $CLIENT_ID = FALSE,
            /**
             * Login With Google Callback
             * Set callback to send response to. Default current url
             * @var string $CALLBACK 
             */
            $CALLBACK = '',
            /**
             *  Login With Google Account Button Label
             * Set Google login button label
             * @var string $BUTTON_LABEL 
             */
            $BUTTON_LABEL = NULL,
            /**
             * Login With Google User Not Authorized Message Popup Title
             * Set popup title to use with the popup message if user deny your app to login with google
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_TITLE 
             */
            $NOT_AUTHORIZED_MSG_TITLE = '',
            /**
             * Login With Google User Not Authorized Message Popup Close Button title
             * Set popup close button title to use with the popup message if user deny your app to login with google
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CLOSE_BTN 
             */
            $NOT_AUTHORIZED_MSG_CLOSE_BTN = '',
            /**
             * Login With Google User Not Authorized Message Popup Confirm Button title
             * Set popup confirm button title to use with the popup message if user deny your app to login with google
             * Default NULL           
             * @var string $NOT_AUTHORIZED_MSG_CONFIRM_BTN 
             */
            $NOT_AUTHORIZED_MSG_CONFIRM_BTN = '',
            /**
             * Login With Google User Not Authorized Message
             * Set popup message to display when the popup is shown if user deny your app to login with google
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
     * Get Google Button     
     * @return string
     */
    public function getMarkup()
    {
        if ( $this->CLIENT_ID !== FALSE ):
            if ( !empty( $this->NOT_AUTHORIZED_MSG ) ):
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CLOSE_BTN, array( 'class="button-close"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_TITLE . bcHTML::tag()->getMarkup(), array( 'class="title"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG, array( 'class="text"' ) );
                bcHTML::tag()->div( $this->NOT_AUTHORIZED_MSG_CONFIRM_BTN, array( 'class="button-confirm"' ) );
                bcHTML::tag()->div( bcHTML::tag()->getMarkup(), array( 'id="bcFormControl-login-google-msg"' ) );
            endif;
            bcHTML::tag()->div( $this->BUTTON_LABEL, array( 'data-bcFormControl-login-google-clientid="' . $this->CLIENT_ID . '"', 'data-bcFormControl-login-callback="' . $this->CALLBACK . '"', 'data-bcFormControl-login-redirect="' . $this->ON_SUCCESS_REDIRECT . '"', 'class="bcFormControl-login-g"', 'id="bcFormControl-login-g"' ) );
            return bcHTML::tag()->getMarkup();
        endif;
        return NULL;
    }

}
