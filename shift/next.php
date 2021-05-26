<?php
/**
 * 換到新值班者，並印出新值班者。
 */
include 'Lib.php';

$lib = new Lib();

$lib->next();

$result = $lib->whoseTurn();
$msg = [];
if ($result) {
    $msg['text'] = "換你了!\n";
    $msg['text'] .= $result;
} else {
    $msg['text'] = "error";
}
$msg = json_encode($msg);

$lib->sendSlackMsg($msg);
