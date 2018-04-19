<?php
//Zend引擎每执行1条低级语句就去执行一次 register_tick_function() 注册的函数
declare(ticks=1);

function tick_handler(){
    echo "tick_handler() called\n";
}

//tick_handler() called
register_tick_function('tick_handler');

//tick_handler() called
$a = 1;

if ($a > 0){
    //tick_handler() called
    $a += 2;
    //3
    print($a);
}
//执行完if -> tick_handler() called