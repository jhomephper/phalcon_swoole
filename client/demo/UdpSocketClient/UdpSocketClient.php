<?php

/**
 * HttpSerever Swoole 服务器
 * User: Kp
 * Date: 2015/10/21
 * Time: 12:52
 *
 * @  demo:http://127.0.0.1:9502/swoole/demo
 */
define('APP_PATH', realpath('../../..'));

class TdpSocketCilent
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public $result;

    public function __construct() {
        $client = new swoole_client(SWOOLE_SOCK_UDP);         //默认是同步，第二个参数可以选填异步
        //发起网络连接
        $client->connect('0.0.0.0', 9504, 0.5);
        $client->send('demo');
        echo $client->recv();
    }

    // WorkerStart回调
    public function onWorkerStart() {
        //启动应用
        $config = include APP_PATH . "/api/config/config.php";
        $loader = include APP_PATH . "/api/config/loader.php";
        $this->di = include APP_PATH . "/api/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($this->di);
    }

    // 获取实例对象
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}

TdpSocketCilent::getInstance();