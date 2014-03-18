<?php
/*
__PocketMine Plugin__
name=ChatLog
description=ChatLog will log chat in a chat.log
version=0.1
author=Syriamanal
class=ChatLog
apiversion=12,13,14
*/
class ChatLog implements Plugin{
private $api, $path;
public function __construct(ServerAPI $api, $server = false){
$this->api = $api;
}

public function init(){

$this->api->addHandler("player.chat", array($this,"eventHandle"),50);
if (!file_exists(DATA_PATH . "ChatLog.log")) {
    file_put_contents(DATA_PATH . "ChatLog.log", "");
    console("[INFO] ChatLog.log file generated");
}
}

public function __destruct(){}

public function eventHandle($data, $event) {
file_put_contents(DATA_PATH . "ChatLog.log", " \n [ " . $data['player']->username . " ] " . $data['message'] . " \n \n", FILE_APPEND);
    }
}
