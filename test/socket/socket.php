<?php
//参考:https://github.com/fireqong/workerman/blob/master/Socket.md
/*
 * 创建socket
 * 调用stream_socket_accept, 进程阻塞在这里.
 * 当有新请求发起时, fork一个子进程进行处理.
 * 子进程处理完毕后, 结束进程, 释放资源. 
 * 下述代码是同步阻塞的方式, 高并发的时候效率低下, 现在最流行的方式是异步非阻塞.
 */

$fd = stream_socket_server("tcp://0.0.0.0:8090", $errno, $errstr);

//省略错误处理

while (true) {
    $conn = stream_socket_accept($fd);

    $pid = pcntl_fork();
    if ($pid == 0) {
        $message = "Hi";
        $len = strlen($message);
        fwrite($conn, "HTTP/1.0 200 OK\r\nContent-Length: $len\r\n\r\n$message");
        fclose($conn);
        exit(0);
    } elseif ($pid > 0) {
        continue;
    } else {
        printf("fork failed");
    }
} 