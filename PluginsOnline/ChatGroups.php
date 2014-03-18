<?php

/*
__PocketMine Plugin__
name=Chat Channels
description=Allows you to channel the chat
version=0.1
author=Falk
class=chan
apiversion=12 
*/
		
class chan implements Plugin{	
	private $api;

	private $server;
		
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$server = ServerAPI::request();
	}
	
	public function init(){	
			$this->api->addHandler("player.chat", array($this, "eventHandler"), 100);
			$this->api->console->register("chan", "Select a chat channel", array($this, "command"));
			$this->api->ban->cmdWhitelist("chan");
			}
	public function __destruct(){}
	public function command($cmd, $params, $issuer, $alias, $args, $issuer){
	if ($params[0] == "main") {
		unset($this->chan[$issuer->username]);
		$issuer->sendChat("You are now on main channel");
	}
	else {
	$this->chan[$issuer->username] = $params[0];
	$issuer->sendChat($params[0] . ' is your new channel');
	}
}
	public function eventHandler($data, $event){
	switch ($event) {
	case "player.chat": 
	if (isset($this->chan[$data['player']->username])) {
    $message = $data['message'];
    $username = $data['player']->username;
    $chan = $this->chan[$username];
    $users = array_keys($this->chan,$chan);
    $this->api->chat->send($username,$message,$users);
    
    return false;
    }
    else {
    	return true;
    }
    break;
	}

}
}
