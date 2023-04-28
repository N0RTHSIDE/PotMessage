<?php

namespace MyPlugin;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class MyPlugin extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $cause = $player->getLastDamageCause();

        if ($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();

            if ($killer instanceof Player) {
                $killerName = $killer->getName();
                $killerPots = $killer->getInventory()->getContents()[Item::SPLASH_POTION] ?? 0;

                $playerName = $player->getName();
                $playerPots = $player->getInventory()->getContents()[Item::SPLASH_POTION] ?? 0;

                $message = $this->formatMessage($killerName, $killerPots, $playerName, $playerPots);
                $this->getServer()->broadcastMessage($message);
            }
        }
    }

    private function formatMessage($killerName, $killerPots, $playerName, $playerPots) {
        $message = "§a" . $killerName . "§2[" . $killerPots . "]§r killed §7" . $playerName . "§4[" . $playerPots . "]§r";
        return $message;
    }

}