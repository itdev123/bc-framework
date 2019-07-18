<?php

/**
 * bcUAC::auth()->config()->twitter()
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config;

use BriskCoder\Package\Component\bcFormControl;

final class Twitter
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Login With Twitter Account
     * Set twitter client id to use twitter button. Default FALSE            
     * @param string $CONSUMER_KEY
     */
    public function consumerKey( $CONSUMER_KEY )
    {
        bcFormControl::uiWizard()->login()->twitter()->CONSUMER_KEY = $CONSUMER_KEY;
    }

    /**
     * Login With Twitter Secret
     * Set twitter secret. Default FALSE     
     * @param string $CONSUMER_SECRET
     */
    public function consumerSecret( $CONSUMER_SECRET )
    {
        bcFormControl::uiWizard()->login()->twitter()->CONSUMER_SECRET = $CONSUMER_SECRET;
    }

    /**
     * Login With Twitter Token
     * Set twitter token. Default FALSE    
     * @param string $TOKEN
     */
    public function token( $TOKEN )
    {
        bcFormControl::uiWizard()->login()->twitter()->TOKEN = $TOKEN;
    }

    /**
     * Login With Twitter Callback
     * Set callback to send response to. Default null
     * @param string $CALLBACK
     */
    public function callback( $CALLBACK )
    {
        bcFormControl::uiWizard()->login()->twitter()->CALLBACK = $CALLBACK;
    }

    /**
     * Login With Twitter Account Button Label
     * Set Twitter login button label
     * @param string $BUTTON_LABEL
     */
    public function buttonLabel( $BUTTON_LABEL )
    {
        bcFormControl::uiWizard()->login()->twitter()->BUTTON_LABEL = $BUTTON_LABEL;
    }

    /**
     * Login With Twitter User Not Authorized Message
     *  Set popup message to display when the popup is shown if user deny your app to login with twitter
     * @param string $MSG
     *  Set popup close button title to use with the popup message if user deny your app to login with twitter
     * @param string $TITLE
     * Set popup close button title to use with the popup message if user deny your app to login with twitter
     * @param string $CLOSE_BTN
     * Set popup confirm button title to use with the popup message if user deny your app to login with twitter
     * @param string $CONFIRM_BTN
     */
    public function notAuthorizedMsg( $MSG, $TITLE, $CLOSE_BTN, $CONFIRM_BTN )
    {
        $bcFormControlLoginTwitter = bcFormControl::uiWizard()->login()->twitter();
        $bcFormControlLoginTwitter->NOT_AUTHORIZED_MSG = $MSG;
        $bcFormControlLoginTwitter->NOT_AUTHORIZED_MSG_TITLE = $TITLE;
        $bcFormControlLoginTwitter->NOT_AUTHORIZED_MSG_CLOSE_BTN = $CLOSE_BTN;
        $bcFormControlLoginTwitter->NOT_AUTHORIZED_MSG_CONFIRM_BTN = $CONFIRM_BTN;
    }

    /**
     * Url to redirect after user is logged in
     * @param string $URI
     */
    public function onSuccessRedirect( $URI )
    {
        bcFormControl::uiWizard()->login()->twitter()->ON_SUCCESS_REDIRECT = $URI;
    }

}
