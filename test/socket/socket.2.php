<?php
//参考: https://github.com/fireqong/workerman/blob/master/Socket.md

//异步非阻塞要配合Event来实现. stream_set_blocking($fd, 0);
$fd = stream_socket_server("tcp://0.0.0.0:9001", $errno, $errstr);

stream_set_blocking($fd, 0);

$event_base = new EventBase();

$event = new Event($event_base, $fd, Event::READ | Event::PERSIST, function ($fd) use (&$event_base) {
 $conn = stream_socket_accept($fd);

 fwrite($conn, "HTTP/1.0 200 OK\r\nContent-Length: 2\r\n\r\nHi");
 fclose($conn);
}, $fd);

$event->add();

$event_base->loop();

//为了利用CPU多核的优势, 往往会fork出好几个进程同时监听一个端口. 可以通过stream_context_set_option来进行设置.
//stream_context_set_option($fd, 'socket', 'so_reuseport', 1);