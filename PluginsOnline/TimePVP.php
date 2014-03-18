<?php

/*
__PocketMine Plugin__
name=Nightpvp
description=PVP only happensa at night :-)
version=1.0
author=Falk
class=tPVP
apiversion=12
*/

class tPVP implements Plugin{
	private $api, $path, $config;
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
	}
	
	public function init(){
		$this->api->addHandler("entity.health.change", array($this, "eventHandler"));
		$this->api->console->register("tpvp", "Set the pvp phase", array($this, "command"));
}
	
	public function __destruct() {}

	public function eventHandler($data, $event) {
		if (!$data['entity']->class === ENTITY_PLAYER) {
			return true;
		}
		$player = $this->api->player->getByEID($data['entity']->eid);
		if (is_numeric($data['cause'])) {
		if ($this->api->time->getPhase() == "night") {
			return true;
			}
			else {
				return false;
			}
		}
		else {
			return true;
		}
	}
	
}
