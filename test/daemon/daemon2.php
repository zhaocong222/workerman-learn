<?php
//php代码实现守护进程(workerman源码)
function daemon(){
    //$pid > 0 父进程
    umask(0);
    $pid = pcntl_fork();
    if (-1 === $pid) {
        throw new Exception('fork fail');
    } elseif ($pid > 0) {
        //父进程直接退出
        exit(0);
    }

    //建立一个有别于终端的新session以脱离终端
    if (-1 === posix_setsid()) {
        throw new Exception("setsid fail");
    }
    // Fork again avoid SVR4 system regain the control of terminal.
    $pid = pcntl_fork();
    if (-1 === $pid) {
        throw new Exception("fork fail");
    } elseif (0 !== $pid) {
        exit(0);
    }
}

daemon();

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

while (true) {
    //echo 1; 不要任何输出echo 因为标准输入流关闭了，会异常导致进程终止
    $redis->set("name", "lemon".mt_rand());
    sleep(3);
}