<?php
/*
__PocketMine Plugin__
name=Medic
version=0.0.4
description=Plugin to allow Ops to heal other players
author=linuxboytoo
class=Medic
apiversion=10,12
*/


class Medic implements Plugin{
        private $api, $path, $config;
        public function __construct(ServerAPI $api, $server = false){
                $this->api = $api;
                $this->config['pluginname'] = get_class($this);
                $this->config['pluginpath'] = $this->path.'plugins/'.$this->config['pluginname'].'/';

                if(!file_exists($this->config['pluginpath'])) { mkdir($this->config['pluginpath'],755,true); }
        }

        public function init() {
                $this->api->console->register("heal", "Heal a User", array($this, "heal"));
        }

        public function __destruct(){
        }

        public function heal($cmd, $params, $issuer, $alias) {

                if(!($issuer instanceof Player)){ return "Please run this command in-game.\n"; }

                $username = $issuer->username;
                if($this->api->ban->isOp($username)) {
                        if(intval($params[1])<1) { $params[1]=20; }

                        $player = $this->api->player->get($params[0]);
                        if(!($player instanceof Player)){ return "Invalid Player."; }

                        $player->entity->heal($params[1], $username, true);

                        $this->api->chat->sendTo(false, '[Medic] '.$username.' healed you of '.$params[1].' health!', $params[1]);

                        return 'You healed '.$player->username;
                }
        }
}
