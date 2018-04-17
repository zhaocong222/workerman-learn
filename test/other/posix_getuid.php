<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-17
 * Time: 下午3:06
 */
//获取当前进程用户信息
$user_info = posix_getpwuid(posix_getuid());

print_r($user_info);
/*
 * Array
(
    [name] => lemon
    [passwd] => x
    [uid] => 1000
    [gid] => 1000
    [gecos] => lemon,,,
    [dir] => /home/lemon
    [shell] => /bin/bash
)
*
 */