<?php

namespace perworldregister;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
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
}
