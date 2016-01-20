<?php


/**
 * Class WebSocketController
 */
class WebSocketController extends ControllerBase
{

    public function indexAction()
    {
        echo json_encode(SunUser::findFirst());
        echo 'welcome  to  websocket !';
    }

    public  function demoAction(){
        echo  'welcome, swoole_demo !';
    }



}





