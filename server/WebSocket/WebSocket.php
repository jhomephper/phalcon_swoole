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

class WebSocket
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public function __construct() {
        //启动应用
        $this->initializationOfApp();
        // 创建swoole_http_server对象
        $server = new swoole_websocket_server("0.0.0.0", 9507);
        //$server->setGlobal(WEBSOCKET_OPCODE_TEXT);

        $server->on('open' , array( $this , 'onOpen'));
        $server->on('message' , array( $this , 'onMessage'));
        $server->on('close' , array( $this , 'onClose'));
        //$server->on('shutdown', array($this, 'onShutdown'));
        $server->start();
    }

    // 初始化应用
    public function initializationOfApp() {
        $config = include APP_PATH . "/api/config/config.php";
        $loader = include APP_PATH . "/api/config/loader.php";
        $this->di = include APP_PATH . "/api/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($this->di);
    }

    public function onOpen($server, $request){
        ob_start();
        try {
            //注入uri
            $_GET['_url'] = $request->server['request_uri'];
            echo $this->application->handle()->getContent();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->result = ob_get_contents();
        ob_end_clean();
        echo "server: handshake success with fd{$request->fd}\n";
        $server->push($request->fd, $this->result);
    }

    public function onMessage( $server, $frame){
        //print_r($server->connection_info($frame->fd));
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $server->push($frame->fd, json_encode(['a'=>'demo']));
    }

    public  function onClose($ser, $fd){
        print_r($ser->connection_info($fd->fd));
        echo "client {$fd} closed\n";
    }

    public function onShutdown($serv)
    {
        echo PHP_EOL . date("Y-m-d H:i:s") . " server shutdown!" . PHP_EOL;
    }

    // 获取实例对象
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}

WebSocket::getInstance();