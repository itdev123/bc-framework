<?php

/**
 * bcUAC::auth()->config()->google()
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Config;

use BriskCoder\Package\Component\bcFormControl;

final class Google
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth\Config' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Login With Google Account
     * Set google client id to use google button. Default FALSE
     * Digits before the dot only, no need to enter(.apps.googleusercontent.com) only digits before that.
     * @param string $CLIENT_ID
     */
    public function clientID( $CLIENT_ID )
    {
        bcFormControl::uiWizard()->login()->google()->CLIENT_ID = $CLIENT_ID;
    }

    /**
     * Login With Google Callback     
     *  Set callback to send response to. Default current url
     * @param string $CALLBACK
     */
    public function callback( $CALLBACK )
    {
        bcFormControl::uiWizard()->login()->google()->CALLBACK = $CALLBACK;
    }

    /**
     * Login With Google Account Button Label
     * Set Google login button label
     * @param string $BUTTON_LABEL
     */
    public function buttonLabel( $BUTTON_LABEL )
    {
        bcFormControl::uiWizard()->login()->google()->BUTTON_LABEL = $BUTTON_LABEL;
    }

    /**
     * Login With Google User Not Authorized Message
     *  Set popup message to display when the popup is shown if user deny your app to login with google
     * @param string $MSG
     *  Set popup close button title to use with the popup message if user deny your app to login with google
     * @param string $TITLE
     * Set popup close button title to use with the popup message if user deny your app to login with google
     * @param string $CLOSE_BTN
     * Set popup confirm button title to use with the popup message if user deny your app to login with google
     * @param string $CONFIRM_BTN
     */
    public function notAuthorizedMsg( $MSG, $TITLE, $CLOSE_BTN, $CONFIRM_BTN )
    {
        $bcFormControlLoginGoogle = bcFormControl::uiWizard()->login()->google();
        $bcFormControlLoginGoogle->NOT_AUTHORIZED_MSG = $MSG;
        $bcFormControlLoginGoogle->NOT_AUTHORIZED_MSG_TITLE = $TITLE;
        $bcFormControlLoginGoogle->NOT_AUTHORIZED_MSG_CLOSE_BTN = $CLOSE_BTN;
        $bcFormControlLoginGoogle->NOT_AUTHORIZED_MSG_CONFIRM_BTN = $CONFIRM_BTN;
    }

    /**
     * Url to redirect after user is logged in
     * @param string $URI
     */
    public function onSuccessRedirect( $URI )
    {
        bcFormControl::uiWizard()->login()->google()->ON_SUCCESS_REDIRECT = $URI;
    }

}
