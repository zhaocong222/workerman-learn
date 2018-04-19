<?php
//如果父进程不关心子进程什么时候结束，那么可以用 pcntl_signal(SIGCHLD, SIG_IGN) 通知内核，自己对子进程的结束不感兴趣，
//那么子进程结束后，内核会回收，并不再给父进程发送信号。
declare(ticks = 1);

pcntl_signal(SIGCHLD, SIG_IGN);

$pid = pcntl_fork();

if($pid == -1) {
    die('fork error');
} else if ($pid) {
    for(;;) {
        sleep(3);
    }
} else {
    echo "child \r\n";
    exit;
}