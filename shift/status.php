<?php
/**
 * 印出值班狀況列表
 */
include 'Lib.php';

$lib = new Lib();

$pointer = $lib->getPointer();
$people = $lib->getPeople();

$numOfPeople = sizeof($people);

$msg['text'] = "";
for ($i = 1; $i <= $numOfPeople; $i += 1) {
    if ($i == $pointer + 1) {
        $msg['text'] .= "[*]\t";
    } else {
        $msg['text'] .= "[ ]\t";
    }
    $msg['text'] .= $i . ". " . $people[$i-1] . "\n";
}

$msg = json_encode($msg);

$lib->sendSlackMsg($msg);
