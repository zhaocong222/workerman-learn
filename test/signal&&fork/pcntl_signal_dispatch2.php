<?php
//利用pcntl_signal_dispatch处理(推荐) 无需declare

pcntl_signal(SIGINT,function(){
    exit("Get signal SIGINT and exit\n");
});

//posix_getpid当前进程号
echo "Ctl + c or run cmd : kill -SIGINT " . posix_getpid(). "\n" ;

while(1){
    //调用每个等待信号通过pcntl_signal() 安装的处理器
    pcntl_signal_dispatch();
    usleep(100);
}

