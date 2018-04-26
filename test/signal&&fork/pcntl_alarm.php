<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-17
 * Time: 下午2:01
 */
//隔5s发一个信号的例子，通过pcntl_alarm实现
function signal_handler($signal){
    echo date('Y-m-d H:i:s')."\n";
    //print "Caught SIGALRM\n";
    //建一个计时器，在3后向进程发送一个SIGALRM信号
    pcntl_alarm(3);
}

pcntl_signal(SIGALRM,"signal_handler");
//建一个计时器，在3后向进程发送一个SIGALRM信号
pcntl_alarm(3);

while (1){
    pcntl_signal_dispatch();
    usleep(100);
}