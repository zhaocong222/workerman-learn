<?php
use Workerman\Worker;

require_once __DIR__ . '/../Autoloader.php';

// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

Worker::$logFile = './workerman.log';

// 启动3个进程对外提供服务
$http_worker->count = 3;

//设置Worker子进程启动时的回调函数，每个子进程启动时都会执行
$http_worker->onWorkerStart = function($worker){
    //echo "worker starting...\n";
};

$http_worker->onConnect = function($connection)
{
    //echo "new connection from ip".$connection->getRemoteIp()."\n";
};

// 接收到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection, $data)
{
    //print_r($data);
    //$data -> $parser::decode($one_request_buffer, $this)返回的 array('get' => $_GET, 'post' => $_POST, 'cookie' => $_COOKIE, 'server' => $_SERVER, 'files' => $_FILES);
    // 向浏览器发送hello world
    //$connection -> \Workerman\Connection\{协议}Connection
    $connection->send('hello world');
};

// 运行worker
Worker::runAll();