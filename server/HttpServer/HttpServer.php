<?php

/**
 * HttpSerever Swoole 服务器
 * User: Kp
 * Date: 2015/10/21
 * Time: 12:52
 *
 * @  demo:http://127.0.0.1:9502/swoole/demo
 */
define('APP_PATH', realpath('../..'));

class HttpServer
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public function __construct() {
        // 创建swoole_http_server对象
        $http = new swoole_http_server("0.0.0.0", 9502);
        // 设置参数
        $http->set(array(
            'worker_num' => 16,
            'daemonize' => false,
            'max_request' => 100000,
            'dispatch_mode' => 1
        ));
        $http->setGlobal(HTTP_GLOBAL_ALL);
        // 绑定WorkerStart
        $http->on('WorkerStart' , array( $this , 'onWorkerStart'));
        // 绑定request
        $http->on('request' , array( $this , 'onRequest'));
        //开启服务器
        $http->start();
    }

    // WorkerStart回调
    public function onWorkerStart() {
        //启动应用
        $config = include APP_PATH . "/api/config/config.php";
        $loader = include APP_PATH . "/api/config/loader.php";
        $this->di = include APP_PATH . "/api/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($this->di);
    }

    //处理Http请求
    public  function  onRequest($request, $response){
        ob_start();
        try {
            //注入uri
            $_GET['_url'] = $request->server['request_uri'];
            echo $this->application->handle()->getContent();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $result = ob_get_contents();
        ob_end_clean();
        $response->end($result);
    }

    // 获取实例对象
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

HttpServer::getInstance();