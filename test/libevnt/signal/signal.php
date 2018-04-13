<?php
$pid = pcntl_fork();

if ($pid > 0){
    //父进程
    sleep(5);
    //发送SIGINT信号
    posix_kill($pid,SIGINT);
    exit(0);
} elseif ($pid == 0){

    //子进程
    $event_base = new EventBase();
    //收到SIGINT信号触发
    $event = Event::signal($event_base,SIGINT,function() use (&$event,&$event_base){
        echo 'sigint',PHP_EOL;
        $event->del();
        $event_base->free();
        exit(0);
    });

    $event->add();
    $event_base->loop();

} else {
    printf("fork failed");
}

