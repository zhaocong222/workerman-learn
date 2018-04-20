<?php
//创建一个socket服务绑定9001端口
$fd = stream_socket_server("tcp://0.0.0.0:9001",$errno,$errstr);

//非阻塞模式
stream_set_blocking($fd,0);

$event_base = new EventBase();

$event = new Event($event_base, $fd, Event::READ | Event::PERSIST, function ($fd) use (&$event_base) {
    
    //接收创建的socket
    $conn = stream_socket_accept($fd);
    stream_set_read_buffer($fd, 0);

    $event2 = new Event($event_base, $fd, Event::READ | Event::PERSIST, function ($conn) {
        $con = @fread($conn,2)."\n";
        echo $con."\n";
    });

    $event2->add();

}, $fd);

$event->add();

//调度在等待的事件
$event_base->loop();

