<?php

/**
 * Class TcpSocketController
 */
class UdpSocketController extends ControllerBase
{

    public function indexAction()
    {
        echo  '这里是UdpSocket测试方法  index';
    }


    /**
     * UdpSocket测试样例
     */
    public function demoAction(){
        echo json_encode(SunUser::findFirst());
    }


}





