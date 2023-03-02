<?php

namespace DeathMCPE;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\Block;
use pocketmine\item\ItemBlock;
use pocketmine\plugin\PluginBase;
use pocketmine\item\ItemFactory;
use pocketmine\world\World;
use pocketmine\world\Position;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Chest;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\block\BlockBreakEvent;
use Vecnavium\FormUI\libFormsUI;
use Vecnavium\FormsUI\SimpleForm;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\enchantment\EnchantmentInstance;

class Wand extends PluginBase implements Listener {
	
	public function onEnable() : void {
      $this->getLogger()->info("DragonWand (Made By LunarBoyMCPe 🚩) Is Enabled ✅️");
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->saveResource("config.yml");
      $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    }
    
  public function onDisable() : void {
      $this->getLogger()->info("DragonWand (Made By LunarBoyMCPE 🚩) Is Disabled ✅️");
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
    
      if($cmd->getName() == "builderwand"){
          $this->builderwand($sender);
      }
    
      return true;
    }
		
		public function builderwand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						switch($result){
					  	case 0:
						  $this->dirtwand($gamer);
              break;
              
              case 1:
						  $this->stonewand($gamer);
              break;
              
              case 2:
						  $this->brickswand($gamer);
              break;
              
              case 3:
						  $this->glasswand($gamer);
              break;
              
              //case 4:
						//  $this->quartzwand($gamer);
           //   break;
              
              case 4:
						  $this->woodwand($gamer);
              break;
			   		}
					});					
					$form->setTitle("§l§bWAND SHOP");
          $form->setContent("§dSelect The Which Wand You Want To Purchase:", 0, );
          $form->addButton("§r§l§eDIRT BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
          $form->addButton("§r§l§eSTONE BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
          $form->addButton("§r§l§eBRICKS BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
          $form->addButton("§r§l§eGLASS BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
        //  $form->addButton("§r§l§eQUARTZ BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
          $form->addButton("§r§l§eWOOD BUILDER WAND\n§r§l§c»» §l§6Tap To View Info", 1, "https://cdn-icons-png.flaticon.com/512/3230/3230652.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function dirtwand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
           $money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					  	if($money >= $this->config->get("Dirt_Wand_Price")) {
				      EconomyApi::getInstance()->reduceMoney($gamer, $this->config->get("Dirt_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(1101, 0, 1);;
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("dirtbuilderwand", "gems");
              $wand->setCustomName("§r§l§6DIRT BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Dirt Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bDirt Builder Wand");
					  	} else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE DIRT BUILDER WAND?");
          $form->setContent("§dName: §fDirt Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Dirt Usages.\n\n§dPrice: §f" . $this->config->get("Dirt_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function stonewand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					  	if($money >= $this->config->get("Stone_Wand_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($gamer, $this->config->get("Stone_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(1101, 0, 1);;
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("stonebuilderwand", "gems");
              $wand->setCustomName("§r§l§6STONE BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Stone Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bStone Builder Wand");
					  	} else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE STONE BUILDER WAND?");
          $form->setContent("§dName: §fStone Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Stone Usages.\n\n§dPrice: §f" . $this->config->get("Stone_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function brickswand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					   if($money >= $this->config->get("Bricks_Wand_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($gamer, $this->config->get("Bricks_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(1101, 0, 1);;
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("bricksbuilderwand", "gems");
              $wand->setCustomName("§r§l§6BRICKS BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Bricks Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bBricks Builder Wand");
					   } else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE BRICKS BUILDER WAND?");
          $form->setContent("§dName: §fBricks Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Bricks Usages.\n\n§dPrice: §f" . $this->config->get("Bricks_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function glasswand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					  	 if($money >= $this->config->get("Glass_Wand_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($gamer, $this->config->get("Glass_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(1101, 0, 1);;
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("glassbuilderwand", "gems");
              $wand->setCustomName("§r§l§6GLASS BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Glass Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bGlass Builder Wand");
					  	 } else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE GLASS BUILDER WAND?");
          $form->setContent("§dName: §fGlass Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Glass Usages.\n\n§dPrice: §f" . $this->config->get("Glass_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function quartzwand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					  	  if($money >= $this->config->get("Quartz_Wand_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($gamer, $this->config->get("Quartz_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(ItemIds::BLAZE_ROD);
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("quartzbuilderwand", "gems");
              $wand->setCustomName("§r§l§6QUARTZ BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Quartz Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bQuartz Builder Wand");
					  	  } else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE QUARTZ BUILDER WAND?");
          $form->setContent("§dName: §fQuartz Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Quartz Usages.\n\n§dPrice: §f" . $this->config->get("Quartz_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function woodwand(Player $gamer) {
					$form = new SimpleForm(function (Player $gamer, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($gamer);
						switch($result){
					  	case 0:
					  	  if($money >= $this->config->get("Wood_Wand_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($gamer, $this->config->get("Wood_Wand_Price"));
					    $wand = ItemFactory::getInstance()->get(ItemIds::BLAZE_ROD);
						  $glow = VanillaEnchantments::UNBREAKING();
              $wand->addEnchantment(new EnchantmentInstance($glow, 1));
              $wand->getNamedTag()->setString("woodbuilderwand", "gems");
              $wand->setCustomName("§r§l§6WOOD BUILDER WAND\n§r§7You Can Build Big Builds With\n§r§7This Wand And This Wand Provides\n§r§7You Unlimited Wood Usages.\n\n§r§eLeft-Click To Use");
              $wand->setLore(["§r§l§eLEGENDARY"]);
              $gamer->getInventory()->addItem($wand);
              $gamer->sendMessage("§l§aSuccess! §r§eYou Purchased §bWood Builder Wand");
					  	  } else {
						    $gamer->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
              break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE WOOD BUILDER WAND?");
          $form->setContent("§dName: §fWood Builder Wand\n\n§dDescription: §fYou Can Build Big Builds With This Wand And This Wand Provides You Unlimited Wood Usages.\n\n§dPrice: §f" . $this->config->get("Dirt_Wand_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §l§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($gamer);
            return $form;
		}
		
		public function onItemUse(PlayerItemUseEvent $event) {
		  $player = $event->getPlayer();
		  $item = $event->getItem();
		  $world = $player->getWorld();
		  $x = $player->getPosition()->getX();
      $y = $player->getPosition()->getY();
      $z = $player->getPosition()->getZ();
      $blockedWorlds = ["Hypixel - Skyblock Hub", "normal"];
       if (in_array($player->getWorld()->getFolderName(), $blockedWorlds)) {
                $player->sendMessage("§cYou can't use builderwand here!");
                    return;
                }
                $event->cancel();
		  
      if ($item->getNamedTag()->getTag("dirtbuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::GRASS());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::GRASS());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::GRASS());
		  }
		  
		  if ($item->getNamedTag()->getTag("stonebuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::STONE());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::STONE());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::STONE());
		  }
		  
		  if ($item->getNamedTag()->getTag("bricksbuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::STONE_BRICKS());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::STONE_BRICKS());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::STONE_BRICKS());
		  }
       
       if ($item->getNamedTag()->getTag("glassbuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::GLASS());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::GLASS());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::GLASS());
		  }
		  
		  if ($item->getNamedTag()->getTag("quartzbuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::Block_of_Quartz());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::Block_of_Quartz());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::Block_of_Quartz());
		  }
		  
		  if ($item->getNamedTag()->getTag("woodbuilderwand")) {
		    $world->setBlockAt($x + 1, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 2, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 3, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 4, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 5, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 6, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 7, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 8, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 9, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 10, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 11, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 12, $y, $z, VanillaBlocks::Oak_Log());
        $world->setBlockAt($x + 13, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 14, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 15, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 16, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 17, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 18, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 19, $y, $z, VanillaBlocks::Oak_Log());
       $world->setBlockAt($x + 20, $y, $z, VanillaBlocks::Oak_Log());
		  }
	 }
}
