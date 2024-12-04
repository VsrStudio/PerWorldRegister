<?php

namespace perworldregister;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\player\Player;

class EventListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $worldName = $player->getWorld()->getFolderName();

        if ($this->plugin->isWorldProtected($worldName)) {
            if (!$this->plugin->isPlayerRegistered($player->getName())) {
                $this->plugin->showRegisterForm($player);
            } elseif (!$this->plugin->isPlayerLoggedIn($player->getName())) {
                $this->plugin->showLoginForm($player);
            }
        }
    }

    public function onTeleport(EntityTeleportEvent $event): void {
        $entity = $event->getEntity();
        
        if ($entity instanceof Player) {
            $fromWorld = $event->getFrom()->getWorld()->getFolderName();
            $toWorld = $event->getTo()->getWorld()->getFolderName();

            if ($fromWorld !== $toWorld && $this->plugin->isWorldProtected($toWorld)) {
                if (!$this->plugin->isPlayerRegistered($entity->getName())) {
                    $this->plugin->showRegisterForm($entity);
                } elseif (!$this->plugin->isPlayerLoggedIn($entity->getName())) {
                    $this->plugin->showLoginForm($entity);
                }
            }
        }
    }
}
