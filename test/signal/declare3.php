<?php
/*
declare(ticks=1);每执行一次低级语句会检查一次该进程是否有未处理过的信号,测试代码如下：
运行 php signal.php 
然后CTL+c 或者 kill -SIGINT PID 会导致运行代码跳出死循环去运行pcntl_signal注册的函数，效果就是脚本exit打印“Get signal SIGINT and exi”退出
*/
declare(ticks=1);
pcntl_signal(SIGINT,function(){
    exit("Get signal SIGINT and exit\n");
});

//posix_getpid当前进程号
echo "Ctl + c or run cmd : kill -SIGINT " . posix_getpid(). "\n" ;

while(1){
    usleep(100);
}

