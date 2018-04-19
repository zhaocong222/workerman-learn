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

function moniterWorker(){
    while (1){
        //父进程阻塞着等待子进程的退出,防止僵死进程
        //WUNTRACED	 如果子进程进入暂停执行情况则马上返回，但结束状态不予以理会
        $pid    = pcntl_wait($status, WUNTRACED);
        if ($pid > 0){
            echo '子进程是',$pid,',状态是exit';
        }
    }
}

//后台运行
daemon();

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

//监控进程
moniterWorker();