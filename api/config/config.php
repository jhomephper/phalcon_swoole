<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => '127.0.0.1',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'phalcon',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/api/controllers/',
        'modelsDir'      => APP_PATH . '/api/models/',
        'viewsDir'       => APP_PATH . '/api/views/',
        'baseUri'        => '../../',
        'encryptKey'     => 'sjdbhabd_'
    )
));
