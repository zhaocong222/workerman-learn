<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-18
 * Time: 下午4:28
 */
$fd = stream_socket_server("tcp://0.0.0.0:9001",$errno,$errstr);
$fd2 = stream_socket_server("tcp://0.0.0.0:9002",$errno,$errstr);
//echo (int)$fd."\n";
//echo (int)$fd2;

$config = \Event::READ | \Event::PERSIST ;
echo $config;