<?php
 
/*
__PocketMine Plugin__
name=ReservedSlot
description=This plugin make a reserve of the server slot for a VIP user.
version=1.3
apiversion=8,9,10,11,12
author=InusualZ, MoD By TrilogiForce
class=ReservedSlot
*/
 
class ReservedSlot implements Plugin{
    private $api, $count, $server,$config, $entered;
 
    public function __construct(ServerAPI $api, $server = false){
        $this->api  = $api;
        $this->server = ServerAPI::request();
    }

    public function __destruct(){}
     
    public function init(){                    
        $this->api->addHandler('player.join', array($this, 'handler'), 15);
        $this->api->addHandler('player.quit', array($this, 'handler'), 15);
        $this->api->addHandler('server.noauthpacket', array($this, 'handler'), 15);

        $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
            "plugin-version"    => 1.3,
            "list-size-limit"   => 5,
            "join-limit"        => 15,
            "kick-remove-list"  => false,
            "user-list"         => array()
         ));
                
        if($this->config->get('plugin-version') != 1.3)
        {
            unlink($this->api->plugin->configPath($this) . "config.yml");
            $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
                    "plugin-version"    => 1.3,
                    "list-size-limit"   => 0,
                    "join-limit"        => 0,
                    "kick-remove-list"  => false,
                    "user-list"         => array()
         ));
        }
        $this->api->console->register('user', '[ReservedSlot] Reserve a slot to a player.', array($this, 'command'));
    }

    public function handler(&$data, $event)
    {
        switch ($event) {
            case 'player.join':
                if(in_array($data->username, $this->config->get('user-list')) || $this->api->ban->isOp($data->username))
                {
                    if($this->count == true)
                    {
                        if($this->config->get("join-limit") == 0 || $this->config->get("join-limit") <= $this->entered)
                        {
                            $this->entered++;
                            return true;
                        }
                        else
                            return false;
                    }
                }
                elseif(!in_array($data->iusername, $this->config->get('user-list')) || !$this->api->ban->isOp($data->username))
                {
                    if($this->count == true)
                        return false;
                }
            break;

            case 'server.noauthpacket':
                if($data['pid'] == 0x07)
                {
                    if(count($this->server->clients) >= $this->server->maxClients)
                    {
                        $this->server->maxClients += 1;
                        $this->count = true;
                        $this->api->schedule(25, array($this, "deleteSlot"), array(), false);
                    }
                }
            break;

            case 'player.quit':
                if(in_array($data->username, $this->config->get('user-list')) || $this->api->ban->isOp($data->username))
                {
                    $this->entered--;
                }
                break;
        
        }
    }

    public function command($cmd, $params, $issuer)
    {
        if($cmd == 'user')
        {
            switch (array_shift($params)) {
                case 'add':
                    if($this->config->get("list-size-limit") == 0 || $this->config->get("list-size-limit") <= count($this->config->get('user-list')))
                    {
                        $id = (string) array_shift($params);
                        if(!in_array($id, $this->config->get('user-list')))
                        {
                            $c = $this->config->get('user-list');
                            $c[] = $id;
                            $this->config->set('user-list', $c);
                            $this->config->save();

                            if(!$issuer instanceof Player)
                                console("[QNRS] The username: {$id} have been added to the list.");
                            else
                                $issuer->sendChat("[QNRS] The username: {$id} have been added to the list.");

                            $p = $this->api->player->get($id);
                            if($p instanceof Player)
                                $this->entered++;

                            return;
                        }

                        if($issuer instanceof Player)
                            $issuer->sendChat("[QNRS] The username: {$id} is already in the list.");
                        else
                            console("[QNRS] The username: {$id} is already in the list.");
                    }
                    else
                    {
                        if($issuer instanceof Player)
                            $issuer->sendChat("[QNRS] The list has reached the limit.");
                        else
                            console("[QNRS] The list has reached the limit");
                    }

                break;
                
                case 'remove':
                    $id = (string) array_shift($params);
                    if(in_array($id, $this->config->get('user-list')))
                    {
                        $c = $this->config->get("user-list");
                        $key = array_search($id, $c);
                        unset($c[$key]);
                        $this->config->set("user-list", $c);
                        $this->config->save();

                        if(!$issuer instanceof Player)
                            console("[QNRS] The username: {$id} have been removed from list.");
                        else
                            $issuer->sendChat("[QNRS] The username: {$id} have been removed from list.");

                        $p = $this->api->player->get($id);
                        if($p instanceof Player)
                        {
                            if($this->config->get('kick-remove-list') == true)
                            {
                                if( $this->server->maxClients  == count($this->server->clients))
                                    $p->close("[QNRS] You have been removed from the list and the server have reach the limit");
                                return;
                            }
                            $this->entered--;
                        }

                        return;
                    }

                    if(!$issuer instanceof Player)
                        console("[QNRS] The username: {$id} is not on the list.");
                    else
                        $issuer->sendChat("[QNRS] The username: {$id} is not on the list.");

                break;
            default:
                if(!$issuer instanceof Player)
                    console("[QNRS] Usage: \user <add|remove> <username> ");
                else
                    $issuer->sendChat("[QNRS] Usage: \user <add|remove> <username> ");

            break;
            }
        }
    }

    public function deleteSlot()
    {
        $this->count = false;
        $this->server->maxClients -= 1;
    }
}
