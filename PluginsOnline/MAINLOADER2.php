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
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/BeareaGurd.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/ChatGroups.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/ChatLoger.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/ChestShop.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/Medic.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/NickNames.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/Pocketmine.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/SignPortal.php");
	                        $this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/SimpleAUTH.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/SimpleWarp.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/Siri.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/TimeCap.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/TimePVP.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/TimerBan.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/WPortal.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/Warp.php");
				$this->api->plugin->load("https://raw.github.com/QuantumWorks/Server-/master/PluginsOnline/reservedslot.php");
																				$this->api->plugin->load("");
																						$this->api->plugin->load("");
	}
	
	public function init()
	{
		
	}
	
	public function __destruct(){

	}
}
