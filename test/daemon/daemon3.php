<?php
//设置进程名
cli_set_process_title('zclemon: master');

function daemon(){

    umask(0);
    $pid = pcntl_fork();
    if (-1 === $pid) {
        throw new Exception('fork fail');
    } elseif ($pid > 0) {
        exit(0);
    }
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

//后台运行
daemon();

/*
while (1){
    sleep(1);
}
*/


$num = 3;
$_pid = posix_getpid();
$pidMap[$_pid] = [];

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


while (count($pidMap[$_pid]) < $num){

    $pid = pcntl_fork();
    cli_set_process_title('zclemon: work'.count($pidMap[$_pid]));
    $l = count($pidMap[$_pid]);

    if ($pid > 0) {
        $pidMap[$_pid][] = $l;
    } elseif (0 === $pid) {

        while (true) {
            $redis->set("name".$l, "lemon".mt_rand());
            sleep(3);
        }
    } else{
        throw new Exception("forkOneWorker fail");
    }
}

