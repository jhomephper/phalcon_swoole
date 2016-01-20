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

class TcpSocketCilent
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public $result;

    public function __construct() {
        $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        //设置事件回调函数
        $client->on("connect", function($cli) {
            //$cli->send("hello world swoole !\n");
            $cli->send("demo");
        });
        $client->on("receive", function($cli, $data){
            echo "Received: ".$data."\n";
        });
        $client->on("error", function($cli){
            echo "Connect failed\n";
        });
        $client->on("close", function($cli){
            echo "Connection close\n";
        });
        //发起网络连接
        $client->connect('0.0.0.0', 9500, 1);
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

TcpSocketCilent::getInstance();