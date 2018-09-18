<?php
$eventBase = new EventBase();
$arr = [];

function add($fd,$func){

    global $arr,$eventBase;
    $event = new Event($eventBase, $fd, Event::READ | Event::PERSIST, $func, $fd);

    if (!$event||!$event->add()) {
        return false;
    }

    //关键点1
    $arr[posix_getpid()][] = $event;
}
function baseRead($socket){
    $buffer = @fread($socket, 2);
    echo $buffer."\n";
}

function acceptConnection($socket){

    $new_socket = @stream_socket_accept($socket, 0);
    // Thundering herd.
    if (!$new_socket) {
        return;
    }

    stream_set_blocking($new_socket, 0);
    //关键点2
    stream_set_read_buffer($new_socket, 0);

    add($new_socket,'baseRead');
}

$socketmain = stream_socket_server('tcp://127.0.0.1:4455', $errno, $errmsg, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);
//非阻塞
stream_set_blocking($socketmain,0);

add($socketmain,'acceptConnection');

$eventBase->loop();