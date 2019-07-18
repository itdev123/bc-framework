<?php

namespace Dispatcher;

use BriskCoder\bc;

class Home
{

    public function dispatch()
    {

        bc::publisher()->render();
    }

    private function validate()
    {
        //validate set all SEO meta & page & links to Domain
    }
}