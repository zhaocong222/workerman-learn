<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-17
 * Time: 下午5:25
 */
//返回系统用户信息
$user_info = posix_getpwnam('lemon');

print_r($user_info);