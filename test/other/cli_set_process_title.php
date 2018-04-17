<?php
//设置当前进程名
$title = 'php -> test';
if (function_exists('cli_set_process_title')){
    @cli_set_process_title($title);
} elseif (extension_loaded('proctitle') && function_exists('setproctitle')) {
    @setproctitle($title);
}

while (1){
    sleep(1);
}

//测试命令 ps -ef | grep php