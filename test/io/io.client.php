<?php
$fd = stream_socket_client("tcp://0.0.0.0:9001",$errno,$errstr,30);

if (!$fd){
    echo "$errstr ($errno)<br/>\n";
} else {
    echo fread($fd,20);
    fclose($fd);
}