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

namespace BriskCoder\Package\Component\bcFormControl\UiWizard;

use BriskCoder\Package\Library\bcHTML;

final class Contact
{

    public
    /**
     * Set Request URI to post form or ajax
     */
            $REQUEST = '',
            /**
             * Set $FORM_MARKUP to TRUE to send post with form 
             * FALSE to send it with ajax.
             * NULL to not include tag form in case you're already using it in your template
             * When using ajax add our class to your button to trigger the post: '.bcFormControl-login-button'  
             * Default value is TRUE        
             */
            $FORM_MARKUP = TRUE,
            /**
             * $_MESSAGE Set message of curr step as key and message as a value ie: $_MESSAGE[1] = 'already logged in';$_MESSAGE[2] = 'BAD AUTH_NONCE';              
             */
            $_MESSAGE = array(),
            /**
             * Set all buttons for all steps or reset it for next step.
             */
            $BUTTONS = '';
    private
            $curr_step = NULL,
            $curr_message = NULL,
            $markup = '',
            $_steps = array();

    public function __construct( $CALLER )
    {
        if ( ($CALLER !== 'BriskCoder\Package\Component\bcFormControl\UiWizard' ) ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Set Step to be Displayed
     * @param int $STEP Step number
     */
    public function useStep( $STEP )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        $this->curr_step[$currNS] = $STEP;
    }

    /**
     * Set Message to be Displayed
     * @param int $MESSAGE Message number
     */
    public function useMessage( $MESSAGE )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        $this->curr_message[$currNS] = $MESSAGE;
    }

    /**
     * Set Fields to post on the current step.
     * To break in lines use setMarkup() multiple times     
     * @param string $MARKUP Html Markup
     */
    public function setMarkup( $MARKUP )
    {
        bcHTML::tag()->div( $MARKUP, array( 'class="bcFormControl-contact-markup"' ) );
        $this->markup .= bcHTML::tag()->getMarkup();
    }

    /**
     * Set Step Configuration
     * @param int $STEP Set the step numbers ie: 1      
     */
    public function configStep( $STEP )
    {
        $settings = bcFormControl::getSettings();
        $currNS = $settings['NAMESPACE'];
        $this->_steps[$currNS][$STEP]['uri'] = $this->REQUEST;
        $this->_steps[$currNS][$STEP]['form'] = $this->FORM_MARKUP;
        $this->_steps[$currNS][$STEP]['markup'] = $this->markup;
        $this->_steps[$currNS][$STEP]['_message'] = $this->_MESSAGE;
        $this->_steps[$currNS][$STEP]['buttons'] = $this->BUTTONS;
        /* reset markup for next step */
        $this->markup = '';
    }

    /**
     * Get Markup
     * @param string $MARKUP Set global markupt for all of the steps. It's added after the curr step markup
     * @return strinh HTML markup
     */
    public function getMarkup( $MARKUP = '' )
    {
        $settings = bcFormControl::getSettings();
        $markup = '';
        $currNS = $settings['NAMESPACE'];
        if ( isset( $this->curr_step[$currNS] ) && !empty( $this->_steps[$currNS][$this->curr_step[$currNS]] ) ):
            $data = '';
            if ( !empty( $this->_steps[$currNS][$this->curr_step[$currNS]]['_message'] ) ):
                if ( isset( $this->curr_message[$currNS] ) && !empty( $this->_steps[$currNS][$this->curr_step[$currNS]]['_message'][$this->curr_message[$currNS]] ) ):
                    bcHTML::tag()->div( $this->_steps[$currNS][$this->curr_step[$currNS]]['_message'][$this->curr_message[$currNS]], array( 'class="bcFormControl-contact-status"' ) );
                    $data .= bcHTML::tag()->getMarkup();
                endif;
            endif;
            $data .= $this->_steps[$currNS][$this->curr_step[$currNS]]['markup'] . $MARKUP;
            $buttons = $this->_steps[$currNS][$this->curr_step[$currNS]]['buttons'];
            if ( !empty( $buttons ) ):
                bcHTML::tag()->div( $buttons, array( 'class="bcFormControl-contact-submit"' ) );
                $data .= bcHTML::tag()->getMarkup();
            endif;
            if ( $this->_steps[$currNS][$this->curr_step[$currNS]]['form'] === FALSE ):
                $data .= bcHTML::form()->hidden( array( 'name="uri"', 'value="' . $this->_steps[$currNS][$this->curr_step[$currNS]]['uri'] . '"', 'class="bcFormControl-contact-uri"' ) );
            endif;
            if ( $this->_steps[$currNS][$this->curr_step[$currNS]]['form'] !== NULL ):
                bcHTML::form()->form( $data, array( 'action="' . $this->_steps[$currNS][$this->curr_step[$currNS]]['uri'] . '"', 'method="POST"' ) );
                $data = bcHTML::form()->getMarkup();
            endif;
            bcHTML::tag()->div( $data, array( 'class="bcFormControl-contact-wrapper"' ) );
            $markup .= bcHTML::tag()->getMarkup();
            bcHTML::tag()->div( $markup, array( 'class="bcFormControl-contact-box"' ) );
            $markup = bcHTML::tag()->getMarkup();
        endif;
        return $markup;
    }

    /**
     * Get Current Step of current namespace
     * Used if want to make custom code outside that is not included on get markup when current step happens
     */
    public function getStep()
    {
        $settings = bcFormControl::getSettings();
        return $this->curr_step[$settings['NAMESPACE']];
    }

    /**
     * Get Current Message Number of current namespace
     * Used if want to make custom code outside that is not included on get markup when current message of a step happens
     */
    public function getMessage()
    {
        $settings = bcFormControl::getSettings();
        return $this->curr_message[$settings['NAMESPACE']];
    }

}
