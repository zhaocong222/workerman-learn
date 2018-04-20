<?php
$fd = stream_socket_client("tcp://0.0.0.0:9001",$errno,$errstr,30);

if (!$fd){
    echo "$errstr ($errno)<br/>\n";
} else {
    fwrite($fd,"hello world");
    //echo fread($fd,20);
    //fclose($fd);
}