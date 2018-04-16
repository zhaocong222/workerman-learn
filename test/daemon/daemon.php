<?php
//详细：http://www.cnblogs.com/loveyouyou616/p/7867132.html
//参考：https://github.com/fireqong/workerman/blob/master/Daemon.md#%E5%AE%88%E6%8A%A4%E8%BF%9B%E7%A8%8B

//php代码实现守护进程
function daemon(){
    $pid = pcntl_fork();
    if($pid < 0){
        die("fork(1) failed!\n");
    }elseif($pid > 0){
        //1.父进程直接退出
        exit;
    }

    //执行到这里就是子进程
    //2.建立一个有别于终端的新session以脱离终端
    $sid = posix_setsid();
    if (!$sid) {
        die("setsid failed!\n");
    }

    //这一步不是必须的
    $pid = pcntl_fork();
    if($pid < 0){
        die("fork(1) failed!\n");
    }elseif($pid > 0){
        exit; //父进程退出, 剩下子进程成为最终的独立进程
    }


    //3.设置当前进程的工作目录为根目录,不依赖于其他
    chdir("/");
    //4.umask设置为0确保将来进程有最大的文件操作权限
    umask(0);

    //5.关闭标准I/O流
    if (defined('STDIN'))
        fclose(STDIN);
    if (defined('STDOUT'))
        fclose(STDOUT);
    if (defined('STDERR'))
        fclose(STDERR);
}

daemon();

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

while (true) {
    //echo 1; 不要任何输出echo 因为标准输入流关闭了，会异常导致进程终止
    $redis->set("name", "lemon".mt_rand());
    sleep(3);
}