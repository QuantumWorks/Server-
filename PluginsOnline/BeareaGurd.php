<?php
/*
 __PocketMine Plugin__
name=beAreaGuard
description=Private Area Protection with Builder Privileges
version=1.0
author=Blue Electric
class=beAreaGuard
apiversion=12
*/

$checkcount = 0;
$checktime = 0;

//ë³´í˜¸ ê³µê°„
class Area
{
	//ì£¼ì¸ì´ë¦„, ì„¸ê³„ì´ë¦„, ì²«ë²ˆì§¸ í¬ì¸íŠ¸, ë‘ë²ˆì§¸ í¬ì¸íŠ¸, í—ˆê°€ëœ ì‚¬ëžŒ(AllowedPerson), ì „ì²´ë°©ë¬¸ ê°€ëŠ¥ ì—¬ë¶€
	public $ownername,$worldname,$ax,$ay,$az,$bx,$by,$bz,$allowed,$visitall,$noy;
	
	public function __construct()
	{
		//ì´ˆê¸°í™”
		$this->ownername = "";
		$this->worldname = "world";
		$this->ax = 0;
		$this->ay = 0;
		$this->az = 0;
		$this->bx = 0;
		$this->by = 0;
		$this->bz = 0;
		$this->allowed = array();
		$this->visitall = false;
	}
	
	//ê³„ì‚°ì„ ìœ„í•´ a? < b? ë¡œ ì •ë ¬ (bê°€ aë³´ë‹¤ í¬ê²Œ)
	public function soft()
	{
		$temp = max($this->ax, $this->bx);
		$this->ax = min($this->ax, $this->bx);
		$this->bx = $temp;
		
		$temp = max($this->ay, $this->by);
		$this->ay = min($this->ay, $this->by);
		$this->by = $temp;
		
		$temp = max($this->az, $this->bz);
		$this->az = min($this->az, $this->bz);
		$this->bz = $temp;
	}
	
	//ëŒ€ìƒ x,y,zê°€ ë³´í˜¸ì§€ì—­ ì•ˆì—ìžˆëŠ”ì§€ í™•ì¸
	public function checkInside($x, $y, $z)
	{
		//global $checkcount, $checktime;
		//$start = microtime();
		//$checkcount += 1;
		//console("checkInside: xyz:" . $x . "." . $y . "." . $z . " axyz:" . $this->ax . "." . $this->ay . "." . $this->az . " bxyz:" . $this->bx . "." . $this->by . "." . $this->bz);
		if($this->ax <= $x && $this->bx >= $x &&
			( ( $this->ay <= $y && $this->by >= $y ) || $this->noy) &&
			$this->az <= $z && $this->bz >= $z)
		{
			//$checktime += (microtime() - $start);
			return true;
		}
		//$checktime += (microtime() - $start);
		return false;
	}
}

//ë°©ë¬¸/ê±´ì¶•ì´ í—ˆìš©ëœ ì‚¬ëžŒ (Area->allowed)
class AllowedPerson
{
	//ê±´ì¶•ê°€ëŠ¥ ì—¬ë¶€, ê¸°ë³¸ì ìœ¼ë¡œ ë°©ë¬¸ê°€ëŠ¥
	public $build = false;
}

//í˜„ìž¬ ê³µê°„ì„ ì§€ì •í•˜ê³  ìžˆëŠ”ì‚¬ëžŒ
class AreaBuilder
{
	public $builder = ""; //ìƒì„±ì¤‘ì¸ ì‚¬ëžŒì´ë¦„
	public $world = ""; //ì²«ë²ˆì§¸ ì„ íƒëœ ì§€ì—­ì˜ ì´ë¦„
	public $noy = false;
	private $building; //ìƒì„±ì¤‘ì¸ ì§€ì—­
	private $second = false; //ë‘ë²ˆìž¬ í¬ì¸íŠ¸ ì„¤ì • ì—¬ë¶€
	private $complete = false; //í¬ì¸íŠ¸ ì„¤ì •ì™„ë£Œ ì—¬ë¶€
	
	//ê³µê°„ ìƒì„±ìžì™€ ì†Œìœ ìžê°€ ë‹¤ë¥¼ìˆ˜ ìžˆìŒ. ë”°ë¼ì„œ ìƒì„±ìžì™€ ì£¼ì¸ë¥¼ ë‹¤ë¥´ê²Œ ì²˜ë¦¬
	public function __construct($maker, $owner)
	{
		$this->builder = $maker;
		$this->building = new Area();
		$this->building->ownername = $owner;
	}
	
	//í¬ì¸íŠ¸ ì§€ì •
	public function setPoint($x,$y,$z)
	{
		//ì™„ë£Œë¬ìœ¼ë©´ ì•„ë¬´ê²ƒë„ ì•ˆí•¨
		if($this->complete) { return; }
		
		//ë‘ë²ˆì§¸ë¥¼ í¬ì¸íŠ¸ ì„ íƒì¤‘ì´ë©´ ë‘ë²ˆì§¸
		if($this->second)
		{
			$this->building->bx = $x;
			$this->building->by = $y;
			$this->building->bz = $z;
			$this->complete = true; //ì„ íƒ ì™„ë£Œ
		}
		else //ì•„ë‹ˆë¼ë©´ ì²«ë²ˆì§¸ ì§€ì—­ ì„ íƒ
		{
			$this->building->ax = $x;
			$this->building->ay = $y;
			$this->building->az = $z;
			$this->second = true; //ë‘ë²ˆì§¸ ì§€ì—­ ì„ íƒ
		}
	}
	
	//Builderê°€ ë§Œë“ (ë§Œë“œëŠ”ì¤‘ì¸) ì§€ì—­ ë°˜í™˜
	public function getResult()
	{
		$this->building->worldname = $this->world;
		return $this->building; //Building ë°˜í™˜
	}
	
	//ìž‘ì—…ì™„ë£Œ í™•ì¸
	public function isComplete()
	{
		return $this->complete;
	}
}

class BadAccesser
{
	public $tick, $name;
	
	public function __construct($name)
	{
		$this->name = $name;
	}
}

//í”ŒëŸ¬ê·¸ì¸ìš© í´ëž˜ìŠ¤
class beAreaGuard implements Plugin
{
	//API ì˜¤ë¸Œì íŠ¸
	private $api;
	//ìž‘ì—… í´ë”
	private $path;
	//ë³´í˜¸ì§€ì—­ ëª©ë¡
	private $areas;
	//ë³´í˜¸ì§€ì—­ ì§€ì •ì¤‘ì¸ ì‚¬ëžŒ ëª©ë¡
	private $areasetters;
	//ë³´í˜¸ì§€ì—­ì— ê¶Œí•œì—†ì´ ì§„ìž…ì¤‘ì¸ ì‚¬ëžŒ ëª©ë¡
	private $badaccessers;
	//í™•ì¸ì¤‘ì¸ ìœ ì € ëª©ë¡
	private $checkplayers;
	
	//ê·¸ì™¸ ì„¤ì •ë“¤
	//ëª©ë¡
	//area_whiteworld = array( $string = username that builder on whiteworld );
	private $config;

	//í”ŒëŸ¬ê·¸ì¸ ìƒì„±ìž
	public function __construct(ServerAPI $api, $server = false)
	{
		//ì„œë²„ apië¥¼ ì‚¬ìš©í•˜ê¸° ìœ„í•œ api ê°ì²´ë¥¼ ë°›ì•„ì˜¤ê³ 
		$this->api = $api;
		//ì‹œê°„ëŒ€ë¥¼ ê³ ì¹œë‹¤
		date_default_timezone_set("Asia/Seoul");
	}
	
	//í”ŒëŸ¬ê·¸ì¸ ì´ˆê¸°í™” ìž‘ì—…
	public function init()
	{
		//ìž‘ì—…ì„ í•˜ê¸°ìœ„í•œ í´ë”ë¥¼ ê°€ì ¸ì˜¤ê³ 
		$this->path = $this->api->plugin->configPath($this);
		
		//ëª…ë ¹ì„ ë°›ì„ í•¸ë“¤ëŸ¬ ë“±ë¡í•˜ê³ 
		//ê³µê°„ ì§€ì •
		$this->api->console->register("AreaSet", "<Owner> <No Y> Define a private area for <player> or self.", array($this, "cmdHandler"));
		//ê³µê°„ ì‚­ì œ
		$this->api->console->register("AreaDel", "Delete private in which you are currently standing.", array($this, "cmdHandler"));
		//ì§€ì •ëœ ê³µê°„ìœ¼ë¡œ ì§€ì—­ ìƒì„±
		$this->api->console->register("AreaMake", "Commit private area created with /AreaSet.", array($this, "cmdHandler"));
		//ì„ íƒì¤‘ì¸ ê³µê°„ ë²„ë¦¼
		$this->api->console->register("AreaCancel", "Cancel selection of private area.", array($this, "cmdHandler"));
		//íŠ¹ì • ìœ ì € ì ‘ê·¼/ê±´ì¶• í—ˆìš©
		$this->api->console->register("AreaAllow", "[Name|All] <Build|Delete> Add or remove build rights of a <player> for the area in which you are standing.", array($this, "cmdHandler"));
		//í˜„ìž¬ ì„¸ìƒì„ Whitelistì— ì¶”ê°€
		$this->api->console->register("AreaWorld", "<Delete> Enable/disable build privilege whiteworld.", array($this, "cmdHandler"));
		//í˜„ìž¬ ì„¸ìƒì—ì„œ ë¹„ë³´í˜¸ ì§€ì—­ì„ ìˆ˜ì •í• ìˆ˜ ìžˆëŠ” ì‚¬ëžŒ ì¶”ê°€
		$this->api->console->register("AreaBuilder", "[Name] <Delete> Enable/disable build privileges for <player> in whiteworld.", array($this, "cmdHandler"));
		//$this->api->console->register("AreaSet", "Set Area for Someone or Self", array($this, "cmdHandler"));
		
		$this->api->ban->cmdWhitelist("areadel");
		$this->api->ban->cmdWhitelist("areaallow");
		
		//ìœ ì €ì˜ í–‰ë™ì„ í•¸ë“¤ë§í•  í•¸ë“¤ëŸ¬ ë“±ë¡í•˜ê³ 
		$this->api->addHandler("tile.update", array($this, "handler"));
		$this->api->addHandler("entity.move", array($this, "handler"));
		$this->api->addHandler("player.quit", array($this, "handler"));
		$this->api->addHandler("player.block.activate", array($this, "handler"));
		$this->api->addHandler("player.block.place", array($this, "handler"));
		$this->api->addHandler("player.block.break", array($this, "handler"));
		$this->api->addHandler("player.block.touch", array($this, "handler"));
		
		//data
		//x -> check x
		//y -> check y
		//z -> check z
		//result : exist 'forsell' space for given position(x,y,z)
		$this->api->addHandler("be.monitor.sellspace.exist", array($this, "handler"));
		
		//data
		//x -> pos x
		//y -> pos y
		//z -> pos z
		//buyer -> Player->username
		$this->api->addHandler("be.monitor.sellspace.buy", array($this, "handler"));
		
		//íŠ¹ì •ì‹œê°„ë§ˆë‹¤ ë³´í˜¸ì§€ì—­ ì ‘ê·¼ìž í™•ì¸
		$this->api->schedule(20, array($this, "tick"), array(), true);
		
		//ëª©ë¡ì„ ì´ˆê¸°í™”í•˜ê³ 
		$this->areasetters = array();
		$this->badaccessers = array();
		$this->checkplayers = array();
		$this->traces = array();
		
		//íŒŒì¼ë¡œ ë¶€í„° ì „ì— ê¸°ë¡ë˜ì–´ ìžˆë˜ ëª©ë¡ì„ ë¶ˆëŸ¬ì˜¨ë‹¤
		//ë§Œì•½ íŒŒì¼ì´ ì—†ë‹¤ë©´, ë¹ˆ ëª©ë¡ìœ¼ë¡œ ì„¤ì •í•œë‹¤
		$this->readArea();
		$this->readConfig();
	}
	
	public function __destruct()
	{
		
	}
	
	public function readArea()
	{
		//ì§€ì—­ íŒŒì¼ ì—†ìœ¼ë©´ ë¹ˆ ëª©ë¡, ìžˆìœ¼ë©´ ë¶ˆëŸ¬ì˜¤ê¸°
		if(!file_exists($this->path . "area.bin")) { $this->areas = array(); return; }
		$result = file_get_contents($this->path . "area.bin");
		$this->areas = unserialize($result);
	}
	
	public function writeArea()
	{
		//ì§€ì—­ ëª©ë¡ ì“°ê¸°
		file_put_contents($this->path . "area.bin", serialize($this->areas));
	}
	
	public function readConfig()
	{
		//ì„¤ì • íŒŒì¼ ì—†ìœ¼ë©´ ê¸°ë³¸ê°’, ìžˆìœ¼ë©´ ë¶ˆëŸ¬ì˜¤ê¸°
		if(!file_exists($this->path . "config.bin"))
		{
			$this->config = array();
			$this->config["area_whiteworld"] = array();
			return;
		}
		$result = file_get_contents($this->path . "config.bin");
		$this->config = unserialize($result);
	}
	
	public function writeConfig()
	{
		//ì„¤ì • íŒŒì¼ ìž‘ì„±
		file_put_contents($this->path . "config.bin", serialize($this->config));
	}
	
	public function tick()
	{
		$online = $this->api->player->online();
		
		//ìœ ì € 10ëª…
		//ë³´í˜¸ 20ê°œ
		foreach($online as $name)
		{
			$player = $this->api->player->get($name);
			if($player === false) { unset($this->badaccessers[$name]); continue; }
			
			if($this->api->ban->isOP( $player ) ) { continue; }
			
			foreach ($this->areas as $area)
			{
				if(	$player->level->getName() != $area->worldname ||
					$area->ownername == $player->username || $area->visitall ||
					$area->ownername == "forsell" || isset($area->allowed[ $player->username ]) )
				{
					continue;
				}
				
			}
		}
	}
	
	public function cmdHandler($cmd, $argments, $issuer, $alias)
	{
		return "[-] " . $this->cmdHandle($cmd, $argments, $issuer, $alias);
	}
	
	//ëª…ë ¹ í•¸ë“¤ë§
	public function cmdHandle($cmd, $argments, $user, $alias)
	{
		switch ($cmd)
		{
			case "areaset": //ì§€ì—­ ì„¤ì •
				//í”Œë ˆì´ì–´ë§Œ ì´ ëª…ë ¹ì–´ë¥¼ ì“¸ìˆ˜ ìžˆìŒ (ë¸”ëŸ­ì„ ë¶€ìˆ´ì•¼ í•˜ê¸° ë•Œë¬¸ì—)
				if ( $user instanceof Player ){ }
				else{
					return "This Command Is In-Game Only";
				}
				//í˜„ìž¬ ì„¤ì •ì¤‘ì¸ì§€ í™•ì¸
				foreach ($this->areasetters as &$setter)
				{
					//í˜„ìž¬ ì„¤ì •ìž ëª©ë¡ì¤‘ì— ëª…ë ¹ì–´ ì‚¬ìš©ìžëž‘ ê°™ì€ ì‚¬ëžŒì´ ìžˆìœ¼ë©´
					//ë‹¤ì‹œë§í•´, ì´ë¯¸ ì„ íƒì¤‘ì¸ ì‚¬ëžŒì´ ë‹¤ì‹œ ì„ íƒí•˜ë ¤ê³  í•œê²½ìš°
					if($setter->builder == $user->username)
					{
						//ê²½ê³ 
						return "You're Already Selecting An Area";
					}
				}
				//ì£¼ì¸ì„ ë”°ë¡œ ì§€ì •í•œê²½ìš° ê·¸ ê°’ì„ ì‚¬ìš©
				//ì•„ë‹Œê²½ìš° ìš”ì²­ìžì˜ ì´ë¦„ì„ ì‚¬ìš©
				$owner = "";
				if(isset($argments[0]))
				{
					$owner = $argments[0];
				}
				else
				{
					$owner = $user->username;
				}
				$builder = new AreaBuilder($user->username, $owner);
				if(isset($argments[1]))
				{
					$builder->noy = true;
				}
				//ê³µê°„ ì„¤ì • ì‹œìž‘
				$this->areasetters[] = $builder;
				return "Start Select Area for " . $owner;
				break;
			case "areamake":
				//ì„¤ì •ìž ëª©ë¡ì—ì„œ ëª…ë ¹ ì‚¬ìš©ìžë¥¼ ì°¾ìŒ
				foreach ($this->areasetters as $key => &$setter)
				{
					if($setter->builder == $user->username)
					{
						//ì°¾ì€ê²½ìš°, ì„ íƒì„ ì™„ë£Œí–ˆëŠ”ì§€ í™•ì¸
						if($setter->isComplete())
						{
							//ì™„ë£Œëœê²½ìš° ì •ë ¬í•˜ê³  ê³µê°„ ëª©ë¡ì— ì¶”ê°€
							$setter->getResult()->soft();
							$setter->getResult()->noy = $setter->noy;
							$this->areas[] = $setter->getResult();
							$this->writeArea();
							//ìƒì„±ìž ëª©ë¡ì—ì„œ ì´ í”Œë ˆì´ì–´ë¥¼ ì œê±°
							unset( $this->areasetters[$key] );
							//ì¶”ê°€ ì™„ë£Œ ì•Œë¦¼
							return "Area Created with Your Selection";
						}
						else
						{
							//ì„ íƒì„ ì™„ë£Œë˜ì§€ ì•Šì€ê²½ìš° ê²½ê³ 
							return "Select Not Completed";
						}
					}
				}
				//ë§Œì•½ ì°¾ì•˜ë‹¤ë©´, returnì„ ë§Œë‚˜ ì´ìª½ìœ¼ë¡œ ì˜¬ìˆ˜ ì—†ìŒ
				//ë”°ë¼ì„œ, ì°¾ì§€ëª»í•œ ê²½ìš°ê°€ ë˜ê¸° ë–„ë¬¸ì— ì´ë¥¼ ì•Œë¦¼
				return "You Are Not Selecting";
				break;
			case "areacancel":
				foreach ($this->areasetters as $key => &$setter)
				{
					if($setter->builder == $user->username)
					{
						unset( $this->areasetters[$key] );
						return "Your Selection Ignored, /areaset for Reselect";
					}
				}
				return "You Are Not Selecting";
				break;
			case "areaallow":
				if ( $user instanceof Player ){ }
				else{
					return "This Command In-Player Only";
				}
				if ( !isset($argments[0]) )
				{
					return "Usage: /areaallow [Name|All] [Build|Delete]";
				}
				
				foreach ($this->areas as &$area)
				{
					if( $area->checkInside($user->entity->x, $user->entity->y, $user->entity->z) )
					{
						if($area->ownername != $user->username)
						{
							return "This Area Not for You!";
						}
						else
						{
							if(!isset($argments[1]))
							{
								$argments[1] = "";
							}
							switch ( strtolower($argments[0]) )
							{
								case "all":
									switch ( strtolower($argments[1]) )
									{
										case "build":
											return "You Are Kidding? Use /areadel for Unprotect the Area";
											break;
										case "delete":
											$area->visitall = false;
											$this->writeArea();
											return "Your Request Processed";
											break;
										default:
											$area->visitall = true;
											$this->writeArea();
											return "Your Request Processed";
											break;
									}
									break;
								default:
									switch ( strtolower($argments[1]) )
									{
										case "build":
											if(isset($area->allowed[ $argments[0] ]))
											{
												$area->allowed[ $argments[0] ]->build = true;
											}
											else
											{
												$allowed = new AllowedPerson();
												$allowed->build = true;
												$area->allowed[ $argments[0] ] = $allowed;
											}
											$this->writeArea();
											return "Your Request Processed";
											break;
										case "delete":
											if( !isset($area->allowed[ $argments[0] ]) )
											{
												return "Unknown Allowed Person";
											}
											unset($area->allowed[ $argments[0] ]);
											$this->writeArea();
											return "Your Request Processed";
											break;
										default:
											if(isset($area->allowed[ $argments[0] ]))
											{
												return "Already Allowed Person";
											}
											$area->allowed[ $argments[0] ] = new AllowedPerson();
											$this->writeArea();
											return "Your Request Processed";
											break;
									}
									break;
							}
						}
					}
				}
				return "Must be standing INSIDE your protected area.";
				break;
			case "areadel":
				if ( $user instanceof Player ){ }
				else{
					return "This Command In-Player Only";
				}
				foreach ($this->areas as $key => &$area)
				{
					if( $area->checkInside($user->entity->x, $user->entity->y, $user->entity->z) )
					{
						if($area->ownername != $user->username && !$this->api->ban->isOP( $user ))
						{
							return "This Area Not for You!";
						}
						else
						{
							unset($this->areas[$key]);
							$this->writeArea();
							return "Your Request Processed";
						}
					}
				}
				return "Must be standing INSIDE your protected area.";
				break;
			case "areaworld":
				if ( $user instanceof Player ){ }
				else {
					return "This Command In-Player Only";
				}
				
				if( isset( $this->config["area_whiteworld"][$user->level->getName()] ) )
				{
					if( isset( $argments[0] ) )
					{
						unset( $this->config["area_whiteworld"][$user->level->getName()] );
						$this->writeConfig();
						return $user->level->getName() . " No longer WhiteWorld";
					}
					return "Already Protected";
				}
				else
				{
					if( isset( $argments[0] ) )
					{
						return $user->level->getName() . " Not WhiteWorld";
					}
					$this->config["area_whiteworld"][$user->level->getName()] = array();
					$this->writeConfig();
					return "Added to WhiteWorld";
				}
				break;
			case "areabuilder":
				if ( $user instanceof Player ){ }
				else {
					return "This Command In-Player Only";
				}
				
				if( !isset( $argments[0] ) ) { return "Invalid"; }
			
				if( isset( $argments[1] ) )
				{
					foreach ($this->config["area_whiteworld"][$user->level->getName()] as $key => $builder)
					{
						if($builder == $user->username)
						{
							unset( $this->config["area_whiteworld"][$user->level->getName()][$key] );
							$this->writeConfig();
						}
					}
					return "Removed";
				}
			
				if( isset( $this->config["area_whiteworld"][$user->level->getName()] ) )
				{
					$this->config["area_whiteworld"][$user->level->getName()][] = $argments[0];
					$this->writeConfig();
					return $argments[0] . " Added to Builder on This World";
				}
				else
				{
					return "Your World Not WhiteWorld";
				}
				break;
		}
		
		return "Unknown Command";
	}
	
	public function handler($data, $event)
	{
		switch($event)
		{
			case "player.block.activate":
			case "player.block.place":
			case "player.block.break":
			case "player.block.touch":
			$player = $data["player"];
			$target = null;
			if($event == "player.block.place")
			{
				$target = $data["block"];
			}
			else
			{
				$target = $data["target"];
			}
			
			if($target->getID() == SIGN_POST && $event == "player.block.touch")
			{
				break;
			}
			
			//ê³µê°„ ìˆ˜ì • ë¶ˆëŠ¥
			foreach ($this->areas as &$area)
			{
				if($player->level->getName() != $area->worldname || $area->ownername == $player->username)
				{
					continue;
				}
				else if( $this->api->ban->isOP($player) && $area->ownername == "forsell" )
				{
					continue;
				}
				$know = false;
				foreach($area->allowed as $key => $allowed)
				{
					if($key == $player->username)
					{
						$know = true;
						break;
					}
				}
				if($know) { continue; }
				if($area->checkInside($target->x, $target->y, $target->z))
				{
					$this->chatTo($player, "This Area Protected by " . $area->ownername);
					return false;
				}
			}
			if( isset( $this->config["area_whiteworld"][$player->level->getName()] ) )
			{
				$issetter = false;
				foreach ( $this->config["area_whiteworld"][$player->level->getName()] as $builder)
				{
					if($player->username == $builder)
					{
						$issetter = true;
						break;
					}
				}
				foreach ($this->areasetters as &$setter)
				{
					if($issetter) { break; }
					//console("setter:" . $setter->builder . " player:" . $player->username);
					if($setter->builder == $player->username)
					{
						$issetter = true;
						break;
					}
				}
				if(!$issetter)
				{
					foreach ($this->areas as &$area)
					{
						if($area->ownername != $player->username) { continue; }
						if($area->checkInside($target->x, $target->y, $target->z))
						{
							goto end;
						}
					}
					$this->chatTo($player, "You Not Allowed to Access/Edit This Block");
					$this->chatTo($player, "This World is WhiteWorld, Build In Your Area");
					return false;
				}
			}
			break;
		}
		
		next:
		
		switch($event)
		{
			case "player.quit":
				unset( $this->checkplayers[ $data->username ] );
				break;
			case "player.block.break":
				//ë¸”ëŸ­ í™œë™ ê¸°ë¡
				$player = $data["player"];
				$target = $data["target"];
				if( strtolower( $target->getName() ) == "air")
				{
					continue;
				}
				
				//ê³µê°„ ì„¤ì •ìž ì²˜ë¦¬
				foreach ($this->areasetters as &$setter)
				{
					//console("setter:" . $setter->builder . " player:" . $player->username);
					if($setter->builder == $player->username)
					{
						if($setter->isComplete())
						{
							$this->chatTo($player, "You already selected two points for area.");
							$this->chatTo($player, "Type '/areamake' to commit or '/areacancel' to start over.");
							return false;
						}
						else
						{
							$x = $target->x;
							$y = $target->y;
							$z = $target->z;
							$setter->setPoint($x, $y, $z);
							if($setter->isComplete())
							{
								if($setter->world != $player->level->getName())
								{
									$this->chatTo($player, "Warning: Second point selected in another world");
								}
								$this->chatTo($player, "2nd Point(" . $x . "," . $y . "," . $z . ")");
								$this->chatTo($player, "You Just Selected Two Point for Area");
								$this->chatTo($player, "Type '/areamake' or '/areacancel' to complete selection");
							}
							else
							{
								$this->chatTo($player, "1st Point(" . $x . "," . $y . "," . $z . ")");
								$this->chatTo($player, "Please select 2nd point");
								$setter->world = $player->level->getName();
							}
						}
						return false;
					}
				}
				
				break;
			case "be.monitor.sellspace.exist":
				if( !isset($data["x"]) || !isset($data["y"]) || !isset($data["z"]) )
				{
					var_dump($data);
					console("[-]Bad Handle");
					return false;
				}
				foreach($this->areas as &$area)
				{
					if($area->ownername == "forsell" && $area->checkInside($data["x"], $data["y"], $data["z"]))
					{
						return true;
					}
				}
				return false;
				break;
			case "be.monitor.sellspace.buy":
				if( !isset($data["x"]) || !isset($data["y"]) || !isset($data["z"]) || !isset($data["buyer"]) )
				{
					var_dump($data);
					console("[-]Bad Handle");
					return false;
				}
				foreach($this->areas as &$area)
				{
					if($area->ownername == "forsell" && $area->checkInside($data["x"], $data["y"], $data["z"]))
					{
						$area->ownername = $data["buyer"];
						$this->writeArea();
						return true;
					}
				}
				return false;
				break;
		}
		end:
	}
	
	public function chatTo($player, $chat)
	{
		$player->sendChat("[-]" . $chat);
	}
}

?>
