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

class UdpServer
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
        $server = new swoole_server("0.0.0.0", 9504, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

        // 设置参数
        $server->set(array(
            'worker_num' => 4,
            'dispatch_mode'=> 2,           //1:轮循  2：固定分配  3：争抢
            'task_worker_num'=> 4
        ));
        $server->on('receive' , array( $this , 'onReceive'));
        $server->on('task' , array( $this , 'onTask'));
        $server->on('finish' , array( $this , 'onFinish'));
        $server->start();
    }

    // 初始化应用
    public function initializationOfApp() {
        //启动应用
        $config = include APP_PATH . "/api/config/config.php";
        $loader = include APP_PATH . "/api/config/loader.php";
        $this->di = include APP_PATH . "/api/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($this->di);
    }

    //接受数据处理
    public function onReceive($serv, $fd, $from_id, $data){
        //$connection_info = $serv->connection_info($fd,$from_id);
        //var_dump($connection_info);
        if($data=='demo'){
            $this->callControllerAction('udp-socket',demo,'');
            $serv->send($fd, 'Tcp  server return  message: '.$this->result);
        }

        //此处调用异步task
        $task_id = $serv->task("Async");
        $serv->send($fd, 'Swoole: '.$data, $from_id);
    }

    //异步任务处理开始
    public function  onTask($serv, $task_id, $from_id, $data){
        echo "New AsyncTask[id=$task_id]".PHP_EOL;
        $serv->finish("$data -> OK");
    }

    //异步任务处理结束
    public function onFinish($serv, $task_id, $data){
        echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
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

UdpServer::getInstance();