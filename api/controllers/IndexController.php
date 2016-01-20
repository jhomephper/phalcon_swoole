<?php


class IndexController extends ControllerBase
{
    public function  initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        echo  'welcome to  phalcon_swoole_HttpServer !';
    }


}

