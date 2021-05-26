<?php
/**
 * 印出現在的值班者
 */
include 'Lib.php';

$lib = new Lib();

$msg = [];
$result = $lib->whoseTurn();
if ($result) {
    $msg['text'] = $result;
} else {
    $msg['text'] = "error";
}
$msg = json_encode($msg);

$lib->sendSlackMsg($msg);
