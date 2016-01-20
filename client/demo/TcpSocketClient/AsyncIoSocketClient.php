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

class AsyncIoSocketCilent
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public $result;

    public function __construct() {
        $fp = stream_socket_client("tcp://127.0.0.1:9500", $code, $msg, 3);
        $http_request = "GET /index.html HTTP/1.1\r\n\r\n";                     //塞入socket_io
        fwrite($fp, $http_request);
        swoole_event_add($fp, function($fp){
            echo fread($fp, 8192)."\n";                                           //只获取10个字节,最大8192
            swoole_event_del($fp);
            fclose($fp);
        });
        swoole_timer_after(2000, function() {
            echo "2000ms timeout\n";
        });
        swoole_timer_tick(1000, function() {
            echo "1000ms interval\n";
        });

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

AsyncIoSocketCilent::getInstance();