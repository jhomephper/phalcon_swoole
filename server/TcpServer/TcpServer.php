<?php

/**
 * TcpServer Swoole 服务器
 * User: Kp
 * Date: 2015/10/21
 * Time: 12:52
 *
 * @  demo:http://127.0.0.1:9502/swoole/demo
 */
define('APP_PATH', realpath('../..'));

class TcpServer
{
    public static $instance;

    private $application;

    public $config;

    public $di;

    public $result;

    public function __construct() {
        //初始化应用
        $this->initializationOfApp();

        // 创建swoole_http_server对象
        $server = new swoole_server("0.0.0.0", 9500);

        $server->on('connect' , array( $this , 'onConnect'));

        $server->on('receive' , array( $this , 'onReceive'));

        $server->on('close' , array( $this , 'onClose'));

        $server->start();
    }

    // 初始化应用
    public function initializationOfApp() {
        $config = include APP_PATH . "/api/config/config.php";
        $loader = include APP_PATH . "/api/config/loader.php";
        $this->di = include APP_PATH . "/api/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($this->di);
    }

    //连接时触发
    public  function onConnect($serv, $fd, $from_id){
        echo "Client:Connect.\n";
    }

    //接受数据处理
    public function  onReceive($serv, $fd, $from_id, $data){
            if($data=='demo'){
                $this->callControllerAction('tcp-socket',demo,'');
                $serv->send($fd, 'Tcp  server return  message: '.$this->result);
            }
            $serv->close($fd);
    }

    public function onClose($serv, $fd, $from_id){
        echo "Client: Close.\n";
    }

    //接受参数并交由相应路由处理,处理完成后返回结果或者结果集
    public function callControllerAction($controller,$action,$parameter){
        ob_start();
        try {
            $_GET['_url'] = '/'.$controller.'/'.$action.'/parameter/'.$parameter;
            echo $this->application->handle()->getContent();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->result = ob_get_contents();
        ob_end_clean();
    }

    // 获取实例对象
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}
TcpServer::getInstance();