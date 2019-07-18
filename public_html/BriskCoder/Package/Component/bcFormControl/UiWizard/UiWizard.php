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
 * @author Emily
 */

namespace BriskCoder\Package\Component\bcFormControl;

use BriskCoder\bc,
    BriskCoder\Package\Component\bcFormControl,
    BriskCoder\Package\Component\bcFormControl\UiWizard\Login,
    BriskCoder\Package\Component\bcFormControl\UiWizard\Register,
    BriskCoder\Package\Component\bcFormControl\UiWizard\Contact,
    BriskCoder\Package\Component\bcFormControl\UiWizard\Custom;

final class UiWizard
{

    private $template_path = BC_PUBLIC_ASSETS_PATH . 'Package' . DIRECTORY_SEPARATOR .
            'Component' . DIRECTORY_SEPARATOR . 'bcFormControl' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR;

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * UiWizard Login Style and Settings
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\UiWizard\Login
     */
    public function login()
    {
        static $obj;
        if ( (object) $obj === $obj ):
            return $obj;
        else:
            $obj = new Login( __CLASS__ );
            $_settings = bcFormControl::getSettings();
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Login' . DIRECTORY_SEPARATOR . 'login.css', 'css' );
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Login' . DIRECTORY_SEPARATOR . 'login.js', 'js' );
            return $obj;
        endif;
    }

    /**
     * UiWizard Register Style and Settings
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\UiWizard\Register
     */
    public function register()
    {
        static $obj;
        if ( (object) $obj === $obj ):
            return $obj;
        else:
            $obj = new Register( __CLASS__ );
            $_settings = bcFormControl::getSettings();
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Register' . DIRECTORY_SEPARATOR . 'register.css', 'css' );
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Register' . DIRECTORY_SEPARATOR . 'register.js', 'js' );
            return $obj;
        endif;
    }

    /**
     * UiWizard Contact Style and Settings
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\UiWizard\Contact
     */
    public function contact()
    {
        static $obj;
        if ( (object) $obj === $obj ):
            return $obj;
        else:
            $obj = new Contact( __CLASS__ );
            $_settings = bcFormControl::getSettings();
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Contact' . DIRECTORY_SEPARATOR . 'contact.css', 'css' );
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Contact' . DIRECTORY_SEPARATOR . 'contact.js', 'js' );
            return $obj;
        endif;
    }

    /**
     * UiWizard Custom Style and Settings
     * @static $obj
     * @return \BriskCoder\Package\Component\bcFormControl\UiWizard\Custom
     */
    public function custom()
    {
        static $obj;
        if ( (object) $obj === $obj ):
            return $obj;
        else:
            $obj = new Custom( __CLASS__ );
            $_settings = bcFormControl::getSettings();
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Custom' . DIRECTORY_SEPARATOR . 'custom.css', 'css' );
            bc::publisher()->addHeadIncludes( $this->template_path . $_settings['TEMPLATE'] . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'UiWizard' . DIRECTORY_SEPARATOR . 'Custom' . DIRECTORY_SEPARATOR . 'custom.js', 'js' );
            return $obj;
        endif;
    }

}
