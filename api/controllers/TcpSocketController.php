<?php

/**
 * Class TcpSocketController
 */
class TcpSocketController extends ControllerBase
{

    public function indexAction()
    {
        echo  '这里是TcpSocket测试方法  index';
    }


    /**
     * TcpSocket测试样例
     */
    public function demoAction(){
        echo json_encode(SunUser::findFirst());
    }


}





