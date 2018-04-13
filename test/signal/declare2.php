<?php
//Zend引擎每执行1条低级语句就去执行一次 register_tick_function() 注册的函数
declare(ticks=1);

//开始时间
$time_start = time();

//检查是否已超时
function check_timeout(){
    //开始时间
    global $time_start;
    //5秒超时
    $timeout = 5;
    if (time() - $time_start > $timeout){
        exit("超间{$timeout}秒");
    }
}

// Zend引擎每执行一次低级语句就执行一下check_timeout
register_tick_function('check_timeout');

//模拟一段耗时的业务逻辑，虽然是死循环，但是执行事件不会超过$timeout=5秒
while(1){
    $num = 1;
}