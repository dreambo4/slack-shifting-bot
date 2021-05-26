<?php
include 'Env.php';

class Lib {
    /**
     * 取得所有的值班者
     */
    public function getPeople() {
        $handle = fopen("people.txt", "r");
        if ($handle) {
            $people = [];
            while (($line = fgets($handle)) !== false) {
                array_push($people, $line);
            }
            fclose($handle);
            return $people;
        } else {
            return false;
        }
    }

    /**
     * 取的目前的指針(值班者的 index)
     * pointer start from 0
     */
    public function getPointer() {
        $handle = fopen("pointer.txt", "r");
        if ($handle) {
            $pointer = fgets($handle);
            $pointer = (int)str_replace("\n", "", $pointer);

            fclose($handle);
            return $pointer;
        } else {
            return false;
        }
    }

    /**
     * 目前的使用者
     */
    public function whoseTurn() {
        $people = $this->getPeople();
        $pointer = $this->getPointer();

        if ($people && ($pointer >= 0)) {
            return "目前值班: " . ($pointer + 1) . ".\t" . $people[$pointer];
        } else {
            return false;
        }
    }

    /**
     * 換下一位值班者
     */
    public function next() {
        $pointer = $this->getPointer();
        $people = $this->getPeople();

        if ($people === false || $pointer === false) {
            return false;
        }

        $max = sizeof($people) - 1;

        $pointer += 1;
        if ($pointer > $max) {
            $pointer = 0;
        }

        $handle = fopen("pointer.txt", "w");
        if ($handle && fwrite($handle, $pointer)) {
            return $pointer;
        } else {
            print_r(error_get_last());
            return false;
        }
    }

    /**
     * 使用cur，傳送訊息到slack。webhook URL 會存在 Env.php 長的像是
     * https://hooks.slack.com/services/xxxxxxx/xxxxxxx/xxxxxx
     */
    public function sendSlackMsg($msg) {
        $ch = curl_init();
        $headers[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_URL, Env::$slack['chanel_webhook']);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch); // 會輸出 curl 是否成功
        curl_close($ch);
    }
}