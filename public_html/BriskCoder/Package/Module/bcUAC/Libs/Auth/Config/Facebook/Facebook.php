<?php

/**
 * bcUAC::auth()->config()->facebook()
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config;

use BriskCoder\Package\Component\bcFormControl;

final class Facebook
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Login With Facebook
     * Set facebook app id to use facebook button. Default FALSE
     * @param string $APP_ID 
     */
    public function appID( $APP_ID )
    {
        bcFormControl::uiWizard()->login()->facebook()->APP_ID = $APP_ID;
    }

    /**
     * Login With Facebook App Scret
     * Set facebook app secret . Default NULL
     * @param string $APP_SECRET
     */
    public function appSecret( $APP_SECRET )
    {
        bcFormControl::uiWizard()->login()->facebook()->APP_SECRET = $APP_SECRET;
    }

    /**
     *  Login With Facebook Callback
     * Set callback to send response to. Default current url
     * @param string $CALLBACK
     */
    public function callback( $CALLBACK )
    {
        bcFormControl::uiWizard()->login()->facebook()->CALLBACK = $CALLBACK;
    }

    /**
     * Login With Facebook Button Label
     * Set facebook login button label
     * @param string $BUTTON_LABEL
     */
    public function buttonLabel( $BUTTON_LABEL )
    {
        bcFormControl::uiWizard()->login()->facebook()->BUTTON_LABEL = $BUTTON_LABEL;
    }

    /**
     * Login With Facebook User Not Authorized Message
     *  Set popup message to display when the popup is shown if user deny your app to login with facebook
     * @param string $MSG
     *  Set popup close button title to use with the popup message if user deny your app to login with facebook
     * @param string $TITLE
     * Set popup close button title to use with the popup message if user deny your app to login with facebook
     * @param string $CLOSE_BTN
     * Set popup confirm button title to use with the popup message if user deny your app to login with facebook
     * @param string $CONFIRM_BTN
     */
    public function notAuthorizedMsg( $MSG, $TITLE, $CLOSE_BTN, $CONFIRM_BTN )
    {
        $bcFormControlLoginFacebook = bcFormControl::uiWizard()->login()->facebook();
        $bcFormControlLoginFacebook->NOT_AUTHORIZED_MSG = $MSG;
        $bcFormControlLoginFacebook->NOT_AUTHORIZED_MSG_TITLE = $TITLE;
        $bcFormControlLoginFacebook->NOT_AUTHORIZED_MSG_CLOSE_BTN = $CLOSE_BTN;
        $bcFormControlLoginFacebook->NOT_AUTHORIZED_MSG_CONFIRM_BTN = $CONFIRM_BTN;
    }

    /**
     * Url to redirect after user is logged in
     * @param string $URI
     */
    public function onSuccessRedirect( $URI )
    {
        bcFormControl::uiWizard()->login()->facebook()->ON_SUCCESS_REDIRECT = $URI;
    }

}
