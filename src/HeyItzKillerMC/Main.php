<?php

namespace HeyItzKillerMC;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\TextFormat;
use pocketmine\item\ItemFactory;

class Main extends PluginBase implements Listener{

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        $looser = $player->getName();
        $looser_pots = count($player->getInventory()->all(ItemFactory::getInstance()->get(438, 22))); // 438:22 is the item ID of the potion

        $cause = $player->getLastDamageCause();

        if($cause instanceof EntityDamageByEntityEvent){
            $killer = $cause->getDamager();
            $killer_pots = count($killer->getInventory()->all(ItemFactory::getInstance()->get(438, 22)));
            $message = TextFormat::GREEN . $killer->getName() . TextFormat::DARK_GREEN . "[" . $killer_pots . "] " . TextFormat::GRAY . "killed " . TextFormat::RED . $looser . TextFormat::DARK_RED . "[" . $looser_pots . "]";
            $event->setDeathMessage($message);
        }
    }
}
