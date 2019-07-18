<?php

namespace Dispatcher;

use BriskCoder\bc;
use BriskCoder\Package\Module\bcUAC;
use BackEnd\Logic\Subroutine\External\Config;
use BriskCoder\Package\Component\bcJSInc;
use BriskCoder\Package\Library\bcHTML;
use FrontEnd\Logic\Subroutine\Internal\PreviewTheme;

class _Global
{
    public function constructor()
    {
        //global config
        Config::init();

        bc::publisher()->CACHE_LIFETIME = 0;
        bc::publisher()->TEMPLATE = 'DigiSpider'; //template setter
        
        bcUAC::session()->start();
        if( isset($_POST['theme_switch']) )
        {
            PreviewTheme::change($_POST['theme_switch']);
            bcUAC::session()->__set('current_theme', $_POST['theme_switch']);
        } else {
            if(bcUAC::session()->__isset('current_theme')) {
                bc::publisher()->TEMPLATE = bcUAC::session()->__get('current_theme'); //template setter        
            }
        }

        //bcJSInc::briskCoder(); //BriskCoder JS Library Loader


        bc::publisher()->_PARSE['head_includes'] = bc::publisher()->render( '_inc/head_includes', FALSE, TRUE );
        bc::publisher()->_PARSE['header'] = bc::publisher()->render( '_inc/header', FALSE, TRUE );
        bc::publisher()->_PARSE['footer'] = bc::publisher()->render( '_inc/footer', FALSE, TRUE );
        bc::publisher()->_PARSE['footer_year'] = date( 'Y' );
        bc::publisher()->_PARSE['view-theme'] = PreviewTheme::load();
    }

    public function destructor()
    {
        
    }

}
