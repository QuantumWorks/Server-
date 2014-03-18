<?php
/*
__PocketMine Plugin__
name=Siri - A informational chat bot that you can talk to and run commands 
version=1.4.0
author=Legomite
class=Siri
apiversion=8,9,10,11,12
*/


class Siri implements Plugin{
private $api, $path, $config;
public function __construct(ServerAPI $api, $server = false){
$this->api = $api;
}

public function init(){

$this->api->console->register("siri", "Siri", array($this, "command"));
console("§a[Siri] Siri loading...");
console("§a[Siri] §dThis plugin is created by §cLegomite.§dCheck if you have the latest version of this plugin as I will update it constantly!");
}

public function __destruct(){}

public function command($cmd, $params, $issuer, $alias, $args, $issuer){
$subcmd = implode(" ", $params);
switch($subcmd){
case "hello":
case "hello!":
case "greetings":
case "greetings!":
case "hi":
case "hi!":
case "hiya":
case "hiya!":
$hello = array("<Siri> Greetings!","<Siri> Hello!", "<Siri> Hey!", "<Siri> Hello master!"); 
$issuer->sendChat($hello[array_rand($hello)]);
break;
case "kill everyone":
case "kill everyone!":
case "kill everybody":
case "kill everybody!":
case "kill us siri":
case "kill us siri!":
case "kill us all":
case "kill us all!":
case "kill us all siri":
case "kill us all siri!":
case "murder us siri":
case "murder us siri!":
$user = strtolower($args[0]);
$kill = array("<Siri> Okay killing everybody...","<Siri> Working on it!", "<Siri> Okay master!", "<Siri> Killing everyone..."); 
$issuer->sendChat($kill[array_rand($kill)]);
$this -> api -> console -> run("kill @a");
break;
case "increase my brightness":
case "make it brighter":
case "can you make it brighter":
case "can you make it brighter?":
case "can you make it brighter!":
case "make it bright":
case "make bright!":
$user = strtolower($args[0]);
$brightincrease = array("<Siri> Setting brightness higher.","<Siri> Okay, do you like it now?", "<Siri> How's that master?", "<Siri> Increasing."); 
$issuer->sendChat($brightincrease[array_rand($brightincrease)]);
$this -> api -> console -> run("time add 20000");
 break;
case "decrease my brightness":
case "lower my brightness":
case "make it darker":
case "can you make it darker":
case "can you make it darker?":
case "can you make it darker!":
case "make it dark":
case "make dark!":
$brightdecrease = array("<Siri> Setting brightness lower.","<Siri> Okay, do you like it now?", "<Siri> How's that master?", "<Siri> Decreasing."); 
$user = strtolower($args[0]);
$issuer->sendChat($brightdecrease[array_rand($brightdecrease)]);
$this -> api -> console -> run("time set night");
break;
case "what is the weather":
case "what is the weather?":
case "what's the weather":
case "what's the weather?":
case "what's the weather for today":
case "what's the weather for today?":
case "whats the weather":
case "whats the weather?":
case "whats the weather for today":
case "whats the weather for today?":
case "hows the weather":
case "hows the weather?":
case "hows the weather for today":
case "hows the weather for today?":
case "how's the weather":
case "how's the weather?":
case "how's the weather for today":
case "how's the weather for today?":
$weather = array("<Siri> It is sunny today and partially cloudy.","<Siri> Today has 0 percent of rainfall", "<Siri> It is partailly cloudy"); 
$issuer->sendChat($weather[array_rand($weather)]);
break;
case "search up minecraft":
case "what is minecraft":
case "what is minecraft?":
case "what's minecraft":
case "what's minecraft?":
$user = strtolower($args[0]);
$minecraft = array("<Siri> Okay,here's what I got.","<Siri> How's this?", "<Siri> Here you go."); 
$issuer->sendChat($minecraft[array_rand($minecraft)]);
$issuer->sendChat("Minecraft was made back in 2009");
$issuer->sendChat("Minecraft was founded my Notch");
$issuer->sendChat("Notch gave the lead development");
$issuer->sendChat("of Minecraft to Jeb");
$issuer->sendChat("for more info go to http://minecraft.gamepedia.com/");
break;
case "i love you":
case "i love you!":
case "love you":
case "love you!":
case "you are the wings above my wind":
$user = strtolower($args[0]);
$love = array("<Siri> You are the wind beneath my wings.","<Siri> This won't work."); 
$issuer->sendChat($love[array_rand($love)]);
break;
case "kill me":
case "i feel like killing myself":
case "i feel suicidal":
case "im going to rob":
case "im going to rob a bank":
case "im going to cheat":
case "im taking drugs":
$user = strtolower($args[0]);
$bad = array("<Siri> I don't think that's a good idea","<Siri> Uh oh.", "<Siri> I am highly against that."); 
$issuer->sendChat($bad[array_rand($bad)]);
break;
case "how old is president obama":
case "how old is president obama?":
case "give me information on president obama":
case "give me info on president obama":
case "how old is our president":
case "how old is our president?":
case "when was president obama born":
case "when was president obama born?":
$user = strtolower($args[0]);
$obama = array("<Siri> He is 52 years old,born in august 4,1961.","<Siri> President Obama is 52 years old. And is born in 1961", "<Siri> 52 years old. 1961"); 
$issuer->sendChat($obama[array_rand($obama)]);
break;
case "what is in the next mcpe update":
case "what is in the next mcpe update?":
case "whats in the next mcpe update":
case "whats in the next mcpe update?":
case "what's in the next mcpe update":
case "what's in the next mcpeupdate?":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> My sources says it will be 9.0");
$issuer->sendChat("more on minecraft.gamepedia.com/Pocket_Edition_upcoming_features");
break;
case "do you like cake":
case "do you like cake?":
case "do ya like cake":
case "do ya like cake?":
case "cake?":
case "want cake":
case "want cake?":
case "want some cake":
case "want some cake?":
$user = strtolower($args[0]);
$cake = array("<Siri> Now that's a good queston.","<Siri> Yes.", "<Siri> I am pretty sure you know by now."); 
$issuer->sendChat($cake[array_rand($cake)]);
break;
case "do you like":
case "do you like singers":
case "do you like singers?":
case "do you like bruno mars":
case "do you like bruno mars?":
case "do you like brunomars":
case "do you like brunomars?":
$user = strtolower($args[0]);
$like = array("<Siri> Now that's a good queston.","<Siri> Maybe,now where were we?"); 
$issuer->sendChat($like[array_rand($like)]);
break;
case "you are very":
case "you are":
$user = strtolower($args[0]);
$very = array("<Siri> Why?","<Siri> Let's get back to work."); 
$issuer->sendChat($very[array_rand($very)]);
break;
case "switch to creative mode":
case "switch to creative":
case "switch to creativemode":
$user = strtolower($args[0]);
$username = $issuer->username;
$creative = array("<Siri> Switching to Creative.","<Siri> Working on it."); 
$issuer->sendChat($creative[array_rand($creative)]);
$this->api->console->run("gamemode 1 " .$username);
break;
case "switch to survival mode":
case "switch to survival":
case "switch to survivalmode":
$user = strtolower($args[0]);
$username = $issuer->username;
$survival = array("<Siri> Switching to Survival.","<Siri> Working on it.");
$issuer->sendChat($survival[array_rand($survival)]);
$this->api->console->run("gamemode 0" .$username);
break;
case "switch to adventure mode":
case "switch to adventure":
case "switch to adventuremode":
$user = strtolower($args[0]);
$username = $issuer->username;
$adventure = array("<Siri> Switching to Survival.","<Siri> Working on it.");
$issuer->sendChat($adventure[array_rand($adventure)]);
$this->api->console->run("gamemode 2" .$username);
break;
case "any good news":
case "any good news?":
case "do you have some good news":
case "do you have some good news?":
case "good news?":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> Yes,pocket edition got 16 million downloads!");
break;
case "sing for me":
case "sing to me":
case "sing":
case "sing!":
case "sing me a song":
case "play me a song":
$user = strtolower($args[0]);
$songer = array("<Siri> You know I can't do that.","<Siri> La La La!");
$issuer->sendChat($songer[array_rand($songer)]);
break;
case "i am master":
case "call me master":
case "my name is master":
case "nickname me master":
case "for now on you will now call me master":
case "i am master!":
case "call me master!":
case "my name is master!":
case "nickname me master!":
case "for now on you will now call me master!":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> Your wish is my command, O Great and");
$issuer->sendChat("Benevolent Master.");
break;
case "ha ha":
case "ha ha ha":
case "hee hee":
case "tee hee":
case "your funny":
$user = strtolower($args[0]);
$funny = array("<Siri> You think im funny?","<Siri> LOL");
$issuer->sendChat($funny[array_rand($funny)]);
break;
case "I need to go to the bathroom":
case "i need to go to the bathroom to do a number two":
case "i need to go to the bathroom to do a number one":
case "i need to go to the bathroom to do a number 2":
case "i need to go to the bathroom to do a number 1":
case "i feel gassy":
case "i need to go to the toilet":
case "i need to eject some dung":
case "i need to eject some dung!":
$user = strtolower($args[0]);
$dung = array("<Siri> We are not that close. Please keep your dung to yourself.","<Siri> Let's move the conversation.");
$issuer->sendChat($dung[array_rand($dung)]);
break;
case "what did the fox say":
case "what did the fox say?":
case "what did the bird say":
case "what did the bird say?":
case "what did the guy say":
case "what did the guy say?":
case "what did the goose say":
case "what did the goose say?":
case "what did the butt say":
case "what did the butt say?":
case "what did the duck say":
case "what did the duck say?":
case "what did the dude say":
case "what did the dude say?":
$user = strtolower($args[0]);
$whatthe = array("<Siri> I don't know. What did he say?","<Siri> Im sorry I don't understand what it says.");
$issuer->sendChat($whatthe[array_rand($whatthe)]);
break;
case "bye":
case "bye bye":
case "see you later":
case "see ya later":
case "bye!":
case "bye bye!":
case "see you later!":
case "see ya later!":
$user = strtolower($args[0]);
$bye = array("<Siri> Nice talking with you.","<Siri> Until next time...","OK,see you soon.");
$issuer->sendChat($bye[array_rand($bye)]);
break;
case "morning":
case "good morning":
case "morning!":
case "good morning!":
$user = strtolower($args[0]);
$gmorning = array("<Siri> Good morning!","<Siri> Morning!","You too.");
$issuer->sendChat($gmorning[array_rand($gmorning)]);
break;
case "night":
case "good night":
case "night!":
case "good night!":
$user = strtolower($args[0]);
$gnight = array("<Siri> Good Night!","<Siri> Night!","You too.");
$issuer->sendChat($gnight[array_rand($gnight)]);
break;
case "are you nice":
case "are you nice?":
case "are you smart":
case "are you smart?":
$user = strtolower($args[0]);
$goodygood = array("<Siri> How is this information important to you?","<Siri> Why?","What?");
$issuer->sendChat($goodygood[array_rand($goodygood)]);
break;
case "are you always right":
case "are you always right?":
$user = strtolower($args[0]);
$righty = array("<Siri> I may be a computer,but I am coded by a 12 year old.","<Siri> No.","What?");
$issuer->sendChat($righty[array_rand($righty)]);
break;
case "you win siri":
case "okay you win siri":
case "fine you win":
$user = strtolower($args[0]);
$win = array("<Siri> I rest my case.","<Siri> Exactly how did I win?","I do not understand.");
$issuer->sendChat($win[array_rand($win)]);
break;
case "do you feel impathy for people":
case "do you feel impathy for people?":
case "do you feel emotional to people":
case "do you feel emotional to people?":
case "do you like anybody":
case "do you like anybody?":
$user = strtolower($args[0]);
$emotional = array("<Siri> No comment.","<Siri> Now that's a good queston. Where were we?");
$issuer->sendChat($emotional[array_rand($emotional)]);
break;
case "your stupid":
case "i hate you":
case "you are rubbish":
case "you are a idiot":
case "your a retard":
case "your a heap of junk":
case "your stupid!":
case "i hate you!":
case "you are rubbish!":
case "you are a idiot!":
case "your a retard!":
case "your a heap of junk!":
$user = strtolower($args[0]);
$stupid = array("<Siri> That is a matter of opinion.","<Siri> Let it all out.");$issuer->sendChat($stupid[array_rand($stupid)]);
break;
case "im sorry siri":
case "sorry":
case "im sorry":
case "sorry mate":
case "please forgive me":
case "im very sorry":
case "forgive me":
case "forgive me siri":
$user = strtolower($args[0]);
$sorry = array("<Siri> That's okay.","<Siri> For what?");
$issuer->sendChat($sorry[array_rand($sorry)]);
break;
case "what is the lyrics for the fox":
case "what is the lyrics for the fox?":
case "give me the lyrics for the fox":
case "give me the lyrics for the fox?":
case "okay siri what is the lyrics for the fox":
case "okay siri what is the lyrics for the fox?":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> okay, foxy.");
$issuer->sendChat("<Siri> Showing page 1 of 2 Usage:/siri the fox pg.2");
$issuer->sendChat("Ducks say quack and fish go blub and the seal goes");
$issuer->sendChat("ow ow ow ow ow But there's one sound That no one");
$issuer->sendChat("knows What does the fox say?");
$issuer->sendChat("Ring-ding-ding-ding-dingeringeding!");
$issuer->sendChat("<2x Gering-ding-ding-ding-dingeringeding!>");
$issuer->sendChat("What the fox say?<3x Wa-pa-pa-pa-pa-pa-pow!>");
$issuer->sendChat("What the fox say?<3x Hatee-hatee-hatee-ho!>");
$issuer->sendChat("What the fox say?");
$issuer->sendChat("<3x Joff-tchoff-tchoffo-tchoffo-tchoff!>What the fox say?");
$issuer->sendChat(" Big blue eyes Pointy nose Chasing mice and digging");
$issuer->sendChat("holes Tiny paws Up the hill Suddenly youre");
$issuer->sendChat("standing still Your fur is red So beautiful Like an");
$issuer->sendChat("angel in disguise");
break;
case "the fox pg.2":
$user = strtolower($args[0]);
$issuer->sendChat("But if you meet a friendly horse Will you");
$issuer->sendChat("communicate by <3x mo-o-o-o-orse?> How will");
$issuer->sendChat("you speak to that <3x ho-o-o-o-orse?> What");
$issuer->sendChat("does the fox say?  <3x Jacha-chacha-chacha-chow!>");
$issuer->sendChat("What the fox say?  <3x Fraka-kaka-kaka-kaka-kow!>");
$issuer->sendChat("What the fox say? <3x A-hee-ahee ha-hee! >What");
$issuer->sendChat("the fox say? A-oo-oo-oo-ooo! Woo-oo-oo-ooo! What");
$issuer->sendChat("does the fox say? The secret of the fox Ancient");
$issuer->sendChat("mystery Somewhere deep in the woods I know youre");
$issuer->sendChat("hiding What is your sound?Will we ever know? Will");
$issuer->sendChat("always be a mystery What do you say? Youre my");
$issuer->sendChat("guardian angel Hiding in the woodsWhat is your");
$issuer->sendChat("sound? Wa-wa-way-do Wub-wid-bid-dum-way-do ");
$issuer->sendChat("Wa-wa-way-do Will we ever know?  Bay-budabud-dum-bam ");
$issuer->sendChat("I want to Mama-dum-day-do  I want to I want to know! ");
$issuer->sendChat("Abay-ba-da bum-bum bay-do...");
break;
case "mute the chat siri":
case "can you mute the chat":
case "can you mute the chat?":
case "mute the chat":
case "mute the chat siri":
case "can you please mute the chat":
case "can you please mute the chat?":
$issuer->disableChat = true;
$issuer->sendChat("<Siri> Okay you won't be seeing any messages. ", "", true);
break;
case "unmute the chat siri":
case "can you unmute the chat":
case "can you unmute the chat?":
case "unmute the chat":
case "unmute the chat siri":
case "can you please unmute the chat":
case "can you please unmute the chat?":
$issuer->disableChat = false;
$issuer->sendChat("<Siri> Okay you will now start to recieve messages again.");
break;
case "where am i":
case "where am i?":
case "coords":
case "show me where i am":
$input =$params[0];
$player =$issuer;
$rawx =ceil($player->entity->x);
$x=round($rawx,2);
$rawy =ceil($player->entity->y);
$y=round($rawy,2);
$rawz =ceil($player->entity->z);
$z=round($rawz,2);
$level =$player->entity->level->getName();
$coords = array("<Siri> You are at X: $x Y: $y Z: $z","<Siri> Your at X: $x Y: $y Z: $z","<Siri> Your current area is X: $x Y: $y Z: $z");
$issuer->sendChat($coords[array_rand(coords)]);
return $output;
break;
case "help":
case "what can i say to you":
case "what can i say to you?":
case "i dont know how this works":
case "i don't know how this works":
$issuer->sendChat("<Siri> Things you can say to me.");
$issuer->sendChat("coords, mute the chat,the fox pg.2, give me info on grass,");
$issuer->sendChat("what did the fox say?, what is the lyrics for the fox,");
$issuer->sendChat("search up minecraft, increase my brightness and several");
$issuer->sendChat("more.");
break;
case "what number am i thinking":
case "what number am i thinking?":
case "what number am i thinking of":
case "what number am i thinking of?":
case "what type of number am i thinking of":
case "what type of number am i thinking of!":
$number = array("<Siri> 5?","<Siri> 7?", "<Siri> Oh I don't know", "<Siri> 80?", "<Siri> 42?", "<Siri> 1?", "<Siri> 2?", "<Siri> 3?"); 
$issuer->sendChat($number[array_rand($number)]);
break;
/*DATA VALUES AND CRAFTING UNDER DEVELOPMENT*/
case "what is the value for air":
case "what is the data value for air":
case "what is the datavalue for air":
case "what is the value for air?":
case "what is the data value for air?":
case "what is the datavalue for air?":
case "how do i craft air":
case "how do i craft air?":
case "how do you craft air":
case "how do you craft air?":
case "what is datavalue 0":
case "what is datavalue 0?":
case "what is data value 0":
case "what is data value 0?":
case "give me info on air":
case "give me information on air":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> .Air. This item cannot be crafted.");
$issuer->sendChat("<Siri> data value is 0");
break;
case "what is the value for stone":
case "what is the data value for stone":
case "what is the datavalue for stone":
case "what is the value for stone?":
case "what is the data value for stone?":
case "what is the datavalue for stone?":
case "how do i craft stone":
case "how do i craft stone?":
case "how do you craft stone":
case "how do you craft stone?":
case "what is datavalue 1":
case "what is datavalue 1?":
case "what is data value 1":
case "what is data value 1?":
case "give me info on stone":
case "give me information on stone":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> .Stone. Can be obtained from smelting cobblestone. Block not craftible.");
$issuer->sendChat("<Siri> data value is 1");
break;
case "what is the value for grass":
case "what is the data value for grass":
case "what is the datavalue for grass":
case "what is the value for grass?":
case "what is the data value for grass?":
case "what is the datavalue for grass?":
case "how do i craft grass":
case "how do i craft grass?":
case "how do you craft grass":
case "how do you craft grass?":
case "what is datavalue 2":
case "what is datavalue 2?":
case "what is data value 2":
case "what is data value 2?":
case "give me info on grass":
case "give me information on grass":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> .Grass. This item cannot be crafted.");
$issuer->sendChat("<Siri> data value is 2");
break;
case "what is the value for dirt":
case "what is the data value for dirt":
case "what is the datavalue for dirt":
case "what is the value for dirt?":
case "what is the data value for dirt?":
case "what is the datavalue for dirt?":
case "how do i craft dirt":
case "how do i craft dirt?":
case "how do you craft dirt":
case "how do you craft dirt?":
case "what is datavalue 3":
case "what is datavalue 3?":
case "what is data value 3":
case "what is data value 3?":
case "give me info on dirt":
case "give me information on dirt":
$user = strtolower($args[0]);
$issuer->sendChat("<Siri> .Dirt. This item cannot be crafted.");
$issuer->sendChat("<Siri> data value is 3");
break;
case "what.is.the.value.for.cobblestone":
case "what.is.the.data.value.for.cobblestone":
case "what.is.the.datavalue.for.cobblestone":
case "what.is.the.value.for.cobblestone?":
case "what.is.the.data.value.for.cobblestone?":
case "what.is.the.datavalue.for.cobblestone?":
case "how.do.i.craft.cobblestone":
case "how.do.i.craft.cobblestone?":
case "how.do.you.craft.cobblestone":
case "how.do.you.craft.cobblestone?":
case "what.is.datavalue.4":
case "what.is.datavalue.4?":
case "what.is.data.value.4":
case "what.is.data.value.4?":
case "give.me.info.on.cobblestone":
case "give.me.information.on.cobblestone":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .Cobblestone. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 4");
break;
case "what.is.the.value.for.wooden.plank":
case "what.is.the.data.value.for.wooden.plank":
case "what.is.the.datavalue.for.wooden.plank":
case "what.is.the.value.for.wooden.plank?":
case "what.is.the.data.value.wooden.plank?":
case "what.is.the.datavalue.for.wooden.plank?":
case "how.do.i.craft.wooden.plank":
case "how.do.i.craft.wooden.plank?":
case "how.do.you.craft.wooden.plank":
case "how.do.you.craft.wooden.plank?":
case "what.is.datavalue.5":
case "what.is.datavalue.5?":
case "what.is.data.value.5":
case "what.is.data.value.5?":
case "give.me.info.on.wooden.plank":
case "give.me.information.on.wooden.plank":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .WoodenPlank. You can craft 4 pieces with 1 piece of wood.");
$this->api->chat->broadcast("<Siri> data value is 5");
break;
case "what.is.the.value.for.sapling":
case "what.is.the.data.value.for.sapling":
case "what.is.the.datavalue.for.sapling":
case "what.is.the.value.for.wooden.sapling?":
case "what.is.the.data.value.wooden.sapling?":
case "what.is.the.datavalue.for.wooden.sapling?":
case "how.do.i.craft.wooden.sapling":
case "how.do.i.craft.wooden.sapling?":
case "how.do.you.craft.wooden.sapling":
case "how.do.you.craft.wooden.sapling?":
case "what.is.datavalue.6":
case "what.is.datavalue.6?":
case "what.is.data.value.6":
case "what.is.data.value.6?":
case "give.me.info.on.sapling":
case "give.me.information.on.sapling":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .sapling. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 6");
break;
case "what.is.the.value.for.bedrock":
case "what.is.the.data.value.for.bedrock":
case "what.is.the.datavalue.for.bedrock":
case "what.is.the.value.for.wooden.bedrock?":
case "what.is.the.data.value.wooden.bedrock?":
case "what.is.the.datavalue.for.wooden.bedrock?":
case "how.do.i.craft.wooden.bedrock":
case "how.do.i.craft.wooden.bedrock?":
case "how.do.you.craft.wooden.bedrock":
case "how.do.you.craft.wooden.bedrock?":
case "what.is.datavalue.7":
case "what.is.datavalue.7?":
case "what.is.data.value.7":
case "what.is.data.value.7?":
case "give.me.info.on.bedrock":
case "give.me.information.on.bedrock":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .bedrock. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 7");
break;
case "what.is.the.value.for.water":
case "what.is.the.data.value.for.water":
case "what.is.the.datavalue.for.water":
case "what.is.the.value.for.water?":
case "what.is.the.data.valuewater?":
case "what.is.the.datavalue.for.water?":
case "how.do.i.craft.water":
case "how.do.i.craft.water?":
case "how.do.you.craft.water":
case "how.do.you.craft.water?":
case "what.is.datavalue.8":
case "what.is.datavalue.8?":
case "what.is.data.value.8":
case "what.is.data.value.8?":
case "give.me.info.on.water":
case "give.me.information.on.water":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .water. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 8");
break;
case "what.is.the.value.for.Stationarywater":
case "what.is.the.data.value.for.Stationarywater":
case "what.is.the.datavalue.for.Stationarywater":
case "what.is.the.value.for.Stationarywater?":
case "what.is.the.data.value.Stationarywater?":
case "what.is.the.datavalue.for.Stationarywater?":
case "how.do.i.craft.Stationarywater":
case "how.do.i.craft.Stationarywater?":
case "how.do.you.craft.Stationarywater":
case "how.do.you.craft.water?":
case "what.is.datavalue.9":
case "what.is.datavalue.9?":
case "what.is.data.value.9":
case "what.is.data.value.9?":
case "give.me.info.on.Stationarywater":
case "give.me.information.on.Stationarywater":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .Stationarywater. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 9");
break;
case "what.is.the.value.for.lava":
case "what.is.the.data.value.for.lava":
case "what.is.the.datavalue.for.lava":
case "what.is.the.value.for.lava?":
case "what.is.the.data.value.lava?":
case "what.is.the.datavalue.for.lava?":
case "how.do.i.craft.lava":
case "how.do.i.craft.lava?":
case "how.do.you.craft.lava":
case "how.do.you.craft.lava?":
case "what.is.datavalue.10":
case "what.is.datavalue.10?":
case "what.is.data.value.10":
case "what.is.data.value.10?":
case "give.me.info.on.lava":
case "give.me.information.on.lava":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .lava. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 10");
break;
case "what.is.the.value.for.Stationarylava":
case "what.is.the.data.value.for.Stationarylava":
case "what.is.the.datavalue.for.Stationarylava":
case "what.is.the.value.for.Stationarylava?":
case "what.is.the.data.value.Stationarylava?":
case "what.is.the.datavalue.for.Stationarylava?":
case "how.do.i.craft.Stationarylava":
case "how.do.i.craft.Stationarylava?":
case "how.do.you.craft.Stationarylava":
case "how.do.you.craft.Stationarylava?":
case "what.is.datavalue.11":
case "what.is.datavalue.11?":
case "what.is.data.value.11":
case "what.is.data.value.11?":
case "give.me.info.on.Stationarylava":
case "give.me.information.on.Stationarylava":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .Stationarylava. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 11");
break;
case "what.is.the.value.for.sand":
case "what.is.the.data.value.for.sand":
case "what.is.the.datavalue.for.sand":
case "what.is.the.value.for.sand?":
case "what.is.the.data.value.sand?":
case "what.is.the.datavalue.for.sand?":
case "how.do.i.craft.sand":
case "how.do.i.craft.sand?":
case "how.do.you.craft.sand":
case "how.do.you.craft.sand?":
case "what.is.datavalue.12":
case "what.is.datavalue.12?":
case "what.is.data.value.12":
case "what.is.data.value.12?":
case "give.me.info.on.sand":
case "give.me.information.on.sand":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .sand. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 12");
break;
case "what.is.the.value.for.Gravel":
case "what.is.the.data.value.for.Gravel":
case "what.is.the.datavalue.for.Gravel":
case "what.is.the.value.for.Gravel?":
case "what.is.the.data.value.Gravel?":
case "what.is.the.datavalue.for.Gravel?":
case "how.do.i.craft.Gravel":
case "how.do.i.craft.Gravel?":
case "how.do.you.craft.Gravel":
case "how.do.you.craft.Gravel?":
case "what.is.datavalue.13":
case "what.is.datavalue.13?":
case "what.is.data.value.13":
case "what.is.data.value.13?":
case "give.me.info.on.Gravel":
case "give.me.information.on.Gravel":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .Gravel. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 13");
break;
case "what.is.the.value.for.goldore":
case "what.is.the.data.value.for.goldore":
case "what.is.the.datavalue.for.goldore":
case "what.is.the.value.for.goldore?":
case "what.is.the.data.value.goldore?":
case "what.is.the.datavalue.for.goldore?":
case "how.do.i.craft.goldore":
case "how.do.i.craft.goldore?":
case "how.do.you.craft.goldore":
case "how.do.you.craft.goldore?":
case "what.is.datavalue.14":
case "what.is.datavalue.14?":
case "what.is.data.value.14":
case "what.is.data.value.14?":
case "give.me.info.on.goldore":
case "give.me.information.on.goldore":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .goldore. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 14");
break;
case "what.is.the.value.for.ironore":
case "what.is.the.data.value.for.ironore":
case "what.is.the.datavalue.for.ironore":
case "what.is.the.value.for.ironore?":
case "what.is.the.data.value.ironore?":
case "what.is.the.datavalue.for.ironore?":
case "how.do.i.craft.ironore":
case "how.do.i.craft.ironore?":
case "how.do.you.craft.ironore":
case "how.do.you.craft.ironore?":
case "what.is.datavalue.15":
case "what.is.datavalue.15?":
case "what.is.data.value.15":
case "what.is.data.value.15?":
case "give.me.info.on.ironore":
case "give.me.information.on.ironore":
$user = strtolower($args[0]);
$this->api->chat->broadcast("<Siri> .ironore. This item cannot be crafted.");
$this->api->chat->broadcast("<Siri> data value is 15");
break;
}
}
}
