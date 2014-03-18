<?php

/*
__PocketMine Plugin__
name=ONLINE LOADER
description=A Dynamic Loader 
version=2.0.0
author=Syriamanal
class=ONLINE
apiversion=8,9,10,11,12,13,14
*/



class ONLINE implements Plugin
{
	private $api, $server;
	
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$server = ServerAPI::request();
		
		$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/BanItem.php");
		$this->api->plugin->load("");
				$this->api->plugin->load("");
	}
	
	public function init()
	{
		
	}
	
	public function __destruct(){

	}
}
