<?php

namespace Dispatcher;

use BriskCoder\bc;
use BackEnd\Logic\Subroutine\External\Config;
use BriskCoder\Package\Component\bcJSInc;
use BriskCoder\Package\Library\bcHTML;


class _Global
{
    public function constructor()
    {

        //global config
        Config::init();

        bc::publisher()->CACHE_LIFETIME = 0;

//        bc::publisher()->TEMPLATE = 'Template_3'; //load system default template
//
//        /* TEMPLATE GLOBAL INCLUDES */
//        bcHTML::head()->metaViewport( "width=device-width, initial-scale=1.0" );
//        bc::publisher()->_PARSE['HEAD_LINKS'] = bcHTML::head()->getMarkup();
//        bcHTML::head()->linkIcon( bc::registry()->MEDIA_PATH_URI . bc::publisher()->TEMPLATE . '/img/favicon.png' );
//        bc::publisher()->_PARSE['HEAD_LINKS'] .= bcHTML::head()->getMarkup();
//
//        //bcJSInc::briskCoder(); //BriskCoder JS Library Loader
//
//        bc::publisher()->addHeadIncludes( bc::registry()->MEDIA_PATH_SYSTEM . bc::publisher()->TEMPLATE . '/css/font-awesome.min.css', 'css' );
//        bc::publisher()->addHeadIncludes( bc::registry()->MEDIA_PATH_SYSTEM . bc::publisher()->TEMPLATE . '/css/bootstrap.min.css', 'css' );
//        bc::publisher()->addHeadIncludes( bc::registry()->MEDIA_PATH_SYSTEM . bc::publisher()->TEMPLATE . '/css/Global.css', 'css' );
//
//        bc::publisher()->_PARSE['header'] = bc::publisher()->render( '_inc/header', FALSE, TRUE );
//        bc::publisher()->_PARSE['footer'] = bc::publisher()->render( '_inc/footer', FALSE, TRUE );
//        bc::publisher()->_PARSE['footer_year'] = date( 'Y' );

    }

    public function destructor()
    {
        
    }

}
