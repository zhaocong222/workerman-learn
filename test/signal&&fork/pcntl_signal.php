<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-19
 * Time: 上午11:41
 */
// 每执行一次低级语句会检查一次该进程是否有未处理过的信号
declare(ticks = 1);

//信号处理函数
function sig_func(){
    echo "SIGCHLD \r\n";
    //阻塞
    $pid = pcntl_wait($status);
    echo $pid."\n";
    echo $status;
    //pcntl_waitpid(-1, $status);

    // 非阻塞
    //pcntl_wait($status, WNOHANG);
    //pcntl_waitpid(-1, $status, WNOHANG);

    //进程退出
    exit(0);
}

pcntl_signal(SIGCHLD, 'sig_func');

$pid = pcntl_fork();

if($pid == -1) {
    die('fork error');
}elseif($pid) {
    // 父进程一直执行
    while(1) {
        sleep(1);
    }
}else{
    echo "child \r\n";
    sleep(10);
    exit(0);
}