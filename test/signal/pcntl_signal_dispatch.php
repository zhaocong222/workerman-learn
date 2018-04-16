<?php
//pcntl_signal_dispatch 方式处理信号（推荐）
echo "安装信号处理器...\n";
pcntl_signal(SIGHUP,function(){
    echo "信号处理器被调用\n";
});

//当前进程pid
//echo posix_getpid();

echo "为自己生成SIGHUP信号...\n";
//发送信号给当前进程
posix_kill(posix_getpid(), SIGHUP);

//pcntl_signal_dispatch — 调用等待信号的处理器
echo "分发信号...\n";
pcntl_signal_dispatch();


echo "完成\n";