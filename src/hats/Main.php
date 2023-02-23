<?php

namespace hats;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\network\mcpe\JwtUtils;
use pocketmine\network\mcpe\JwtException;
use pocketmine\network\PacketHandlingException;
use pocketmine\network\mcpe\protocol\types\login\ClientData;
use pocketmine\plugin\PluginBase;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {
	
	/** @var self $instance */
    public static $instance;
    
    /** @var int*/
    public $json;
	
	public function onEnable(): void{
		self::$instance = $this;
    	$this->getServer()->getPluginManager()->registerEvents($this, $this);
    	$this->checkSkin();
    	$this->checkRequirement();
    	$this->getLogger()->info($this->json . " Geometry Skin Confirmed");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		if($sender instanceof Player){
			if($cmd->getName() == "hat"){
				$this->Form($sender, TextFormat::YELLOW . "Select Your Hats:");
				return true;
			}
		} else {
			$sender->sendMessage(TextFormat::RED . "You dont Have Permission to use this Command");
			return false;
		}
        return false;
	}
	
	public function dataReceiveEv(DataPacketReceiveEvent $ev)
    {
        $packet = $ev->getPacket();
        $player = $ev->getOrigin()->getPlayer();
        if ($packet instanceof LoginPacket) {
            $data = self::decodeClientData($packet->clientDataJwt);
            $name = $data->ThirdPartyName;
            if ($data->PersonaSkin) {
                if (!file_exists($this->getDataFolder() . "saveskin")) {
                    mkdir($this->getDataFolder() . "saveskin", 0777);
                }
                copy($this->getDataFolder()."steve.png",$this->getDataFolder() . "saveskin/{$name}.png");
                return;
            }
            if ($data->SkinImageHeight == 32) {
            }
            $saveSkin = new saveSkin();
            $saveSkin->saveSkin(base64_decode($data->SkinData, true), $name);
        }
    }
    
    public function onQuit(PlayerQuitEvent $ev)
    {
        $name = $ev->getPlayer()->getName();

        $willDelete = $this->getConfig()->getNested('DeleteSkinAfterQuitting');
        if ($willDelete) {
            if (file_exists($this->getDataFolder() . "saveskin/{$name}.png")) {
                unlink($this->getDataFolder() . "saveskin/{$name}.png");
            }
        }
    }
    
    public function Form($sender, string $txt){
    	$form = new SimpleForm(function (Player $sender, $data = null){
    		if($data === null){
    			return false;
    		}
    		switch($data){
    			case 0:
    			if($sender->hasPermission("cowboy.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "cowboy");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 1:
    			if($sender->hasPermission("crown.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "crown");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 2:
    			if($sender->hasPermission("glass.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "glass");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 3:
    			if($sender->hasPermission("magician.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "magician");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 4:
    			if($sender->hasPermission("melon.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "melon");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 5:
    			if($sender->hasPermission("pumpkin.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "pumpkin");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 6:
    			if($sender->hasPermission("tv.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "tv");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			case 7:
    			if($sender->hasPermission("witch.hats") or $sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){

    			    $setskin = new setSkin();
    			    $setskin->setSkin($sender, "witch");
    			  } else {
    			    $this->Form($sender, TextFormat::RED . "You dont have Permission to Use This Wing");
    			  }
    			break;
    			break;
    			case 11:
    			  $this->resetSkin($sender);
    			break;
    			case 12:
    			break;
    		}
            return false;
    	});
    	$form->setTitle(TextFormat::GREEN . "Hats");
    	$form->setContent($txt);
    	$form->addButton("§6Cowboy");
    	$form->addButton("§6Crown");
    	$form->addButton("§6Glass");
    	$form->addButton("§6Magician");
    	$form->addButton("§6Melon");
    	$form->addButton("§6Pumpkin");
    	$form->addButton("§6Tv");
    	$form->addButton("§6Witch");
    	$form->addButton("Reset Skin");
    	$form->addButton("Exit");
    	$form->sendToPlayer($sender);
    	return $form;
    }
    
    public function resetSkin(Player $player){
      $player->sendMessage("Reset To Original Skin Successfully");
      $reset = new resetSkin();
      $reset->setSkin($player);
    }
    
    public function checkSkin(){
		$Available = [];
		if(!file_exists($this->getDataFolder() . "skin")){
		  mkdir($this->getDataFolder() . "skin");
		}
		$path = $this->getDataFolder() . "skin/";
      $allskin = scandir($path);
      foreach($allskin as $file){
          array_push($Available, preg_replace("/.json/", "", $file));
      }
      foreach($Available as $value){
        if(!in_array($value . ".png", $allskin)){
          unset($Available[array_search($value, $Available)]);
        }
      }
      $this->json = count($Available);
      $Available = [];
    }
    
    public function checkRequirement(){
      if(!extension_loaded("gd")){
        $this->getServer()->getLogger()->info("§6Hats: Uncomment gd2.dll (remove symbol ';' in ';extension=php_gd2.dll') in bin/php/php.ini to make the plugin working");
        $this->getServer()->getPluginManager()->disablePlugin($this);
      }
      if(!class_exists(SimpleForm::class)){
        $this->getServer()->getLogger()->info("§6Hats: FormAPI class missing,pls use .phar from poggit!");
        $this->getServer()->getPluginManager()->disablePlugin($this);
        return;
      }
      if (!file_exists($this->getDataFolder() . "steve.png") || !file_exists($this->getDataFolder() . "steve.json") || !file_exists($this->getDataFolder() . "config.yml")) {
            if (file_exists(str_replace("config.yml", "", $this->getResources()["config.yml"]))) {
                $this->recurse_copy(str_replace("config.yml", "", $this->getResources()["config.yml"]), $this->getDataFolder());
            } else {
                $this->getServer()->getLogger()->info("§6Hats: Something wrong with the resources");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
      }
    }
    
    public function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public static function decodeClientData(string $clientDataJwt): ClientData{
        try{
            [, $clientDataClaims, ] = JwtUtils::parse($clientDataJwt);
        }catch(JwtException $e){
            throw PacketHandlingException::wrap($e);
        }

        $mapper = new \JsonMapper;
        $mapper->bEnforceMapType = false;
        $mapper->bExceptionOnMissingData = true;
        $mapper->bExceptionOnUndefinedProperty = true;
        try{
            $clientData = $mapper->map($clientDataClaims, new ClientData);
        }catch(\JsonMapper_Exception $e){
            throw PacketHandlingException::wrap($e);
        }
        return $clientData;
    }
}
