<?php
//创建一个socket服务绑定9001端口
$fd = stream_socket_server("tcp://0.0.0.0:9001",$errno,$errstr);

//非阻塞模式
stream_set_blocking($fd,0);

$event_base = new EventBase();

/*
如果一个事件被设置了EV_PERSIST，那么这个事件就是持续化的，意思就是这个事件会保持挂起状态，即使回调函数被执行。
如果你想让它变为非挂起状态，可以在回调函数中调用event_del()。
*/
//第4个参数为执行事件后的触发的回调函数
$event = new Event($event_base, $fd, Event::READ | Event::PERSIST, function ($fd) use (&$event_base) {
    
    //接收创建的socket
    $conn = stream_socket_accept($fd);

    fwrite($conn, "this is server\n");
    fclose($conn);
}, $fd);

//上述绑定事件挂起
$event->add();

//调度在等待的事件
$event_base->loop();                                                                                                         

