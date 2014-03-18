<?php 

/*
 __PocketMine Plugin__
name=PocketMoney
description=PocketMoney introduces economy into your PocketMine world.
version=2.1.1
author=MinecrafterJPN
class=PocketMoney
apiversion=10,12
*/

class PocketMoney implements Plugin
{
	private $api, $config, $tmp;

	const DEFAULT_MONEY = 500;
	const TYPE_PLAYER = 0;
	const TYPE_NON_PLAYER = 1;

	public function __construct(ServerAPI $api, $server = false)
	{
		$this->api = $api;
	}

	public function init()
	{
		$this->config = new Config($this->api->plugin->configPath($this) . "config.yml", CONFIG_YAML);
		$this->tmp = new Config($this->api->plugin->configPath($this) . "tmp.yml", CONFIG_YAML, array("optimized" => 0));
		$this->api->addHandler("player.join", array($this, "eventHandler"));
		$this->api->addHandler("money.handle", array($this, "eventHandler"));
		$this->api->addHandler("money.player.get", array($this, "eventHandler"));
		$this->api->addHandler("money.create.account", array($this, "eventHandler"));
		$this->api->console->register("money", "PocketMoney master command", array($this, "commandHandler"));
		if (!$this->tmp->get("optimized")) $this->optimizeConfigFile();
	}

	public function eventHandler($data, $event)
	{
		switch ($event) {
			case "player.join":
				$target = $data->username;
				if (!$this->config->exists($target)) {
					$this->config->set($target, array('money' => self::DEFAULT_MONEY, 'type' => self::TYPE_PLAYER, 'hide' => 0));
					$this->api->chat->broadcast("[QNEconomy] $target has been registered");
					$this->config->save();
				}
				break;
			case "money.handle":
				if(!isset($data['username']) or !isset($data['method']) or !isset($data['amount']) or !is_numeric($data['amount'])) return false;
				$target = $data['username'];
				$method = $data['method'];
				$amount = $data['amount'];
				if (!$this->config->exists($target)) return false;
				switch ($method) {
					case "set":
						if ($amount < 0) {
							return false;
						}
						$this->config->set($target, array_merge($this->config->get($target), array('money' => $amount)));
						$this->config->save();
						break;
					case "grant":
						$targetMoney = $this->config->get($target)['money'] + $amount;
						if($targetMoney < 0) return false;
						$this->config->set($target, array_merge($this->config->get($target), array('money' => $targetMoney)));
						$this->config->save();
						break;
					default:
						return false;
				}
				return true;
			case "money.player.get":
				if (!isset($data['username'])) return false;
				if ($this->config->exists($data['username'])) return $this->config->get($data['username'])['money'];
				return false;
			case "money.create.account":
				if(!isset($data['account']) or !isset($data['hide'])) return false;
				$account = $data['account'];
				$hide = $data['hide'];
				if ($this->config->exist($account)) {
					return false;
				}
				if ($hide !== 0 and $hide !== 1) {
					return false;
				}
				$this->config->set($account, array('money' => self::DEFAULT_MONEY, 'type' => self::TYPE_NON_PLAYER, 'hide' => $hide));
				$this->config->save();
				return true;
		}
	}

	public function commandHandler($cmd, $args, $issuer, $alias)
	{
		$cmd = strtolower($cmd);
		if ($issuer !== "console") {
			return $this->userCommandHandler($cmd, $args, $issuer, $alias);
		}
		switch ($cmd) {
			case "money":
				$subCommand = strtolower($args[0]);
				switch ($subCommand) {
					case "":
					case "help":
						console("[Money]/money help( or /money )");
						console("[Money]/money view <account>");
						console("[Money]/money create <account>");
						console("[Money]/money hide <account>");
						console("[Money]/money set <target> <amount>");
						console("[Money]/money grant <target> <amount>");
						console("[Money]/money top <amount>");
						console("[Money]/money stat");
						break;
					case "view":
						$account = $args[1];
						if (!$this->config->exists($account)) {
							console("[Money] The account name dose not exist");
							break;
						}
						$money = $this->config->get($account)['money'];
						$type = $this->config->get($account)['type'] === self::TYPE_PLAYER ? "Player" : "Non-player";
						console("[PocketMoney] $account money:$money PM, type:$type");
						break;
					case "create":
						$account = $args[1];
						if ($this->config->exists($account)) {
							console("[Money] The account name already exists");
							break;
						}
						$this->config->set($account, array('money' => self::DEFAULT_MONEY, 'type' => self::TYPE_NON_PLAYER, 'hide' => 0));
						$this->config->save();
						console("[Money] Opening of $account has been completed");
						break;
					case "hide":
						$acount = $args[1];
						if (!$this->config->exists($account)) {
							console("[Money] The account name dose not exist");
							break;
						}
						if ($this->config->get($account)['hide']) {
							console("[Money] The account has already been hidden");
							break;
						}
						if ($this->config->get($account)['type'] !== self::TYPE_NON_PLAYER) {
							console("[Money] You can hide only Non-player account");
							break;
						}
						$this->config->set($account, array_merge($this->config->get($account), array('hide' => 1)));
						$this->config->save();
						console("[Money] Hiding of $account has been completed");
						break;
					case "set":
						$target = $args[1];
						$amount = $args[2];
						if (!$this->config->exists($target)) {
							console("[Money] The account name dose not exist");
							break;
						}
						if (!is_numeric($amount) or $amount < 0) {
							console("[Money] Invalid amount");
							break;
						}
						$this->config->set($target, array_merge($this->config->get($target), array('money' => $amount)));
						console("[Money][set] Done!");
						$this->api->chat->sendTo(false, "[PocketMoney][set] Your money was changed to $amount PM by admin", $target);
						$this->config->save();
						break;
					case "grant":
						$target = $args[1];
						if (!$this->config->exists($target)) {
							console("[Money] The account name dose not exist");
							break;
						}
						$amount = $args[2];
						$targetMoney = $this->config->get($target)['money'] + $amount;
						if (!is_numeric($amount) or $targetMoney < 0) {
							console("[Money] Invalid amount.");
							break;
						}
						$this->config->set($target, array_merge($this->config->get($target), array('money' => $targetMoney)));
						console("[Money][grant] Done!");
						$this->api->chat->sendTo(false, "[INFO][grant]Your money was changed to $targetMoney PM by admin", $target);
						$this->config->save();
						break;
					case "top":
						$amount = $args[1];
						$temp = array();
						foreach ($this->config->getAll() as $name => $value) {
							if (!$value['hide']) {
								$temp[$name] = $value['money'];
							}
						}
						arsort($temp);
						$i = 1;
						console("[Money] Millionaires");
						console("===========================");
						foreach ($temp as $name => $money) {
							if ($i > $amount) {
								break;
							}
							console("#$i : $name $money PM");
							$i++;
						}
						break;
					case "stat":
						$total = 0;
						$num = 0;
						foreach ($cfg as $k => $value) {
							$total += $value['money'];
							$num++;
						}
						$avr = floor($total / $num);
						console("[Money] Circulation:$total Average:$avr Accounts:$num");
						break;
					default:
						console("[Money] /money $subCommand dose not exist.");
						break;
				}
				break;
		}

	}

	public function userCommandHandler($cmd, $args, $issuer, $alias)
	{
		$output = "";
		$cmd = strtolower($cmd);
		switch ($cmd) {
			case "money":
				if ($this->config->get($issuer->username)['type'] !== self::TYPE_PLAYER) {
					$output .= "[Money][Error] Change your username or you can not use PocketMoney function";
					break;
				}
				$subCommand = $args[0];
				switch ($subCommand) {
					case "":
						$money = $this->config->get($issuer->username)['money'];
						$output .= "[Money] $money PM";
						break;
					case "help":
						$output .= "[Money]/money\n";
						$output .= "[Money]/money help\n";
						$output .= "[Money]/money pay <target> <amount>\n";
						$output .= "[Money]/money view <account>\n";
						$output .= "[Money]/money create <account>\n";
						$output .= "[Money]/money wd <account> <amount>\n";
						$output .= "[Money]/money hide <account>\n";
						$output .= "[Money]/money top <amount>\n";
						$output .= "[Money]/money stat\n";
						break;
					case "pay":
						$target = $args[1];
						$payer = $issuer->username;
						if ($target === $payer) {
							$output .= "[Money] Cannot pay yourself!";
							break;
						}
						if (!$this->config->exists($target)) {
							$output .= "[Money] The account name dose not exist";
							break;
						}
						$targetMoney = $this->config->get($target)['money'];
						$payerMoney = $this->config->get($payer)['money'];
						$amount = $args[2];
						if (!is_numeric($amount) or $amount < 0 or $amount > $payerMoney) {
							$output .= "[Money] Invalid amount";
							break;
						}
						$targetMoney += $amount;
						$payerMoney -= $amount;
						$this->config->set($target, array_merge($this->config->get($target), array('money' => $targetMoney)));
						$this->config->set($payer, array_merge($this->config->get($payer), array('money' => $payerMoney)));
						$output .= "[Money][pay] Done!";
						$this->api->chat->sendTo(false, "[PocketMoney] $payer -> you: $amount PM", $target);
						$this->config->save();
						break;
					case "view":
						$account = $args[1];
						if (!$this->config->exists($account)) {
							$output .= "[Money] The account name dose not exist";
							break;
						}
						if ($this->config->get($account)['type'] !== self::TYPE_NON_PLAYER) {
							$output .= "[Money] You can view only Non-player account";
							break;
						}
						$money = $this->config->get($account)['money'];
						$output .= "[Money] $account money: $money PM";
						break;
					case "create":
						$account = $args[1];
						if ($this->config->exists($account)) {
							$output .= "[Money] The account name already exists.";
							break;
						}
						$this->config->set($account, array('money' => self::DEFAULT_MONEY, 'type' => self::TYPE_NON_PLAYER, 'hide' => 0));
						$this->config->save();
						$output .= "[Money] Opening of $account has been completed";
						break;
					case "wd":
						$account = $args[1];
						$amount = $args[2];
						if (!$this->config->exists($account)) {
							$output .= "[Money] The account name dose not exist";
							break;
						}
						if ($this->config->get($account)['type'] !== self::TYPE_NON_PLAYER) {
							$output .= "[Money] You can withdraw money from only non-player account";
							break;
						}
						$balance = $this->config->get($account);
						if (!is_numeric($amount) or $amount < 0 or $amount > $balance) {
							$output .= "[Money] Invalid amount";
							break;
						}
						$remittee = $issuer->username;
						$remitteeMoney = $this->config->get($remittee)['money'];
						$this->config->set($account, array_merge($this->config->get($account), array('money' => $balance - $amount)));
						$this->config->set($remittee, array_merge($this->config->get($remittee), array('money' => $remitteeMoney + $amount)));
						$this->config->save();
						$output .= "[Money] $account -> you: $amount PM";
						break;
					case "hide":
						$acount = $args[1];
						if (!$this->config->exists($account)) {
							$output .= "[Money] The account name dose not exist";
							break;
						}
						if ($this->config->get($account)['hide']) {
							$output .= "[Money] The account has already been hidden";
							break;
						}
						if ($this->config->get($account)['type'] !== self::TYPE_NON_PLAYER) {
							$output .= "[Money] You can hide only Non-player account";
							break;
						}
						$this->config->set($account, array_merge($this->config->get($account), array('hide' => 1)));
						$this->config->save();
						$output .= "[Money] Hiding of $account has been completed";
						break;
					case "top":
						$amount = $args[1];
						$temp = array();
						foreach ($this->config->getAll() as $name => $value) {
							if (!$value['hide']) {
								$temp[$name] = $value['money'];
							}
						}
						arsort($temp);
						$i = 1;
						$output .= "[Money] Millionaires\n";
						$output .= "===========================\n";
						foreach ($temp as $name => $money) {
							if ($i > $amount) {
								break;
							}
							$output .= "#$i : $name $money PM\n";
							$i++;
						}
						break;
					case "stat":
						$total = 0;
						$num = 0;
						foreach($this->config->getAll() as $k => $value)
						{
							$total += $value['money'];
							$num++;
						}
						$avr = floor($total / $num);
						$output .= "[Money] Circ:$total Avr:$avr Accounts:$num";
						break;
					default:
						$output .= "[Money] /money $subCommand dose not exist.";
						break;
				}
				break;
		}
		return $output;
	}

	private function optimizeConfigFile()
	{
		foreach ($this->config->getAll() as $key => $val) {
			if (!array_key_exists("type", $val)) {
				$this->config->set($key, array_merge($this->config->get($key), array('type' => self::TYPE_PLAYER)));
			}
			if (!array_key_exists("hide", $val)) {
				$this->config->set($key, array_merge($this->config->get($key), array('hide' => 0)));
			}
		}
		$this->config->save();
		$this->tmp->set("optimized", 1);
		$this->tmp->save();
	}

	public function __destruct()
	{
		$this->config->save();
		$this->tmp->save();
	}
}
