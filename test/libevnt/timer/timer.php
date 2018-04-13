<?php
//定时器示例
function setTimeOut($second,$callback){
    
    $event_base = new EventBase();
    $event = Event::timer($event_base,$callback);
    //加参数可以理解为多少秒以后deal
    $event->addTimer($second);
    $event_base->loop();

}

function setInterval($second,$callback){
    $func = function() use ($second,$callback,&$func){
        call_user_func($callback);
        setTimeOut($second,$func);
    };

    setTimeOut($second,$func);
}

setInterval(1,function(){
    echo "hello",PHP_EOL;
});