<?php
/*
__PocketMine Plugin__
name=Lag
version=1.0.0
author=Syriamanal
class=lag
apiversion=11,12
*/



class lag implements Plugin{
    private $server;
    private $api;

public function __construct(ServerAPI $api, $server = false){
        $this->server = ServerAPI::request();
$this->api = $api;
}

public function init(){
$this->api->schedule(10*60*20, array($this, "timerBeforeClear"), array(), true);
}

    public function timerBeforeClear(){
        $this->api->schedule(60*20, array($this, "timerClear"), array(), false);
        return;
    }
    
    public function timerClear(){
        $cnt = 0;
$l = $this->server->query("SELECT EID FROM entities WHERE class = ".ENTITY_ITEM.";");
if($l !== false and $l !== true){
while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
$e = $this->api->entity->get($e["EID"]);
if($e instanceof Entity){
$this->api->entity->remove($e->eid);
                    $cnt++;
}
}
}

        return;
    }
    
public function __destruct(){
}



}
?>
