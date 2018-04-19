<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 18-4-19
 * Time: 上午9:13
 */
$stdoutFile = '/dev/null';

$handle = fopen($stdoutFile, "a");
if ($handle){
    unset($handle);
    @fclose(STDOUT);
    @fclose(STDERR);
    $STDOUT = fopen($stdoutFile, "a");
    $STDERR = fopen($stdoutFile, "a");

    echo "hello world";

} else {
    throw new Exception('can not open stdoutFile ' . $stdoutFile);
}


