<?php

namespace Dispatcher;

use BriskCoder\bc;
use BriskCoder\Package\Module\bcUAC;
use BriskCoder\Package\Library\bcData;

class Home
{
    public function dispatch() {
    //    bc::debugger()->breakpoint (bcUAC::session()->domain);
        if (isset($_POST['content'])) {
            $code_arr = json_decode($_POST['content']);
            $code = '';

            foreach ($code_arr->blockList as $key => $code_obj) {
                $code .= $code_obj->html;
            }

            file_put_contents(BC_PUBLIC_ASSETS_PATH . md5(bcUAC::session()->domain) . '.preview', $code);
            //file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/4f8d91c3edf5d8afc9bf6447147b9737.preview');
        }
        else {
            
            $page = file_get_contents(BC_PUBLIC_ASSETS_PATH . md5(bcUAC::session()->domain) . '.preview');
            
            //$page = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/4f8d91c3edf5d8afc9bf6447147b9737.preview');
            include BC_PUBLIC_PATH.'/VB/build/php/vb.php';
            load($page);
            include BC_PUBLIC_PATH.'/VB/build/index.html';
        }
    	
    }

    private function validate()
    {
        //validate set all SEO meta & page & links to Domain
    }
}