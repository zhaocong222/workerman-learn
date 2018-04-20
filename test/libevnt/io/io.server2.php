<?php
//创建一个socket服务绑定9001端口
$fd = stream_socket_server("tcp://127.0.0.1:9001",$errno,$errstr);

//非阻塞模式
stream_set_blocking($fd,0);
$socket = socket_import_stream($fd);
@socket_set_option($socket, SOL_SOCKET, SO_KEEPALIVE, 1);
//禁止Nagle算法
@socket_set_option($socket, SOL_TCP, TCP_NODELAY, 1);


$event_base = new EventBase();

$event = new Event($event_base, $fd, Event::READ | Event::PERSIST, function ($fd) use (&$event_base) {
    
    //接收创建的socket
    $conn = stream_socket_accept($fd);
    stream_set_read_buffer($fd, 0);

    $event2 = new Event($event_base, $conn, Event::READ | Event::PERSIST, function ($conn) {
        echo 111;
        //$con = @fread($conn,2)."\n";
        //echo $con."\n";
    },$conn);

    $event2->add();

}, $fd);

$event->add();

//调度在等待的事件
$event_base->loop();

