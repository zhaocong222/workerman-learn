<?php
use Workerman\Worker;
require_once __DIR__ . '/../Autoloader.php';

// 注意：这里与上个例子不通，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

//设置Worker子进程启动时的回调函数，每个子进程启动时都会执行
$ws_worker->onWorkerStart = function($worker){
    echo "worker starting...\n";
};

$ws_worker->onConnect = function($connection)
{
    echo "new connection from ip".$connection->getRemoteIp()."\n";
};

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
    // 向客户端发送hello $data
    $connection->send('hello ' . $data);
};

// 运行worker
Worker::runAll();