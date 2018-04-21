<?php

namespace Main;

use Slim\App;
use Main\Controller\IndexController;
use Main\Controller\XcrudAjaxAction;
use Main\Controller\AdminController;
use Main\Controller\ApiController;
class Route
{
    private $slim;

    public function __construct(App $slim)
    {
        $this->slim = $slim;
    }

    public function run()
    {
        $this->slim->get('/', IndexController::class.':getIndex');

        // xcrud ajax handler
        $this->slim->any('/xcrud/ajax', XcrudAjaxAction::class);



    }
}
