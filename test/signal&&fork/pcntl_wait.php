<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-19
 * Time: 上午11:41
 */

$pid = pcntl_fork();

if($pid == -1) {
    die('fork error');
}elseif($pid) {
    // 父进程一直阻塞,等待子进程退出
    //WUNTRACED 表示除了返回终止子进程的信息外，还返回因信号而停止的子进程信息
    //pcntl_wait($status);
    $pid = pcntl_wait($status,WUNTRACED);
    echo $pid;
}else{
    echo "child \r\n";
    sleep(10);
    exit();
}