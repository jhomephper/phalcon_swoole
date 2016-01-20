<?php

/**
 * Class SwooleController
 */
class SwooleController extends ControllerBase
{

    public function indexAction()
    {
        echo json_encode(SunUser::findFirst());
    }

    public  function demoAction(){
        echo  'welcome, swoole_demo !';
    }


}





