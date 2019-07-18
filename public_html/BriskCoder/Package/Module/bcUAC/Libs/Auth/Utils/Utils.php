<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\Auth;


final class Utils
{
    
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Auth' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
    
    /**
     * Handles Authentication Via AJAX
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Utils\AjaxHandler
     */
    public function ajaxHandler()
    {
        //TODO AjaxHandler
        static $obj;
        return $obj instanceof AjaxHandler ? $obj : $obj = new AjaxHandler( __CLASS__ );
    }
    
    //TODO implement other utilities for the Auth system such as Ajax login, session expiry timer check,
    //publisher forms,  etc
}