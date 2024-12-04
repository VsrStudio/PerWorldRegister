<?php

namespace perworldregister;

use pocketmine\player\Player;
use perworldregister\forms\RegisterForm;
use perworldregister\forms\LoginForm;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private array $registeredPlayers = [];
    private array $loginStatus = [];

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getLogger()->info("PerWorldRegister Plugin Enabled!");
    }

    public function isWorldProtected(string $worldName): bool {
        return in_array($worldName, $this->getConfig()->get("protected-worlds", []), true);
    }

    public function isPlayerRegistered(string $playerName): bool {
        return isset($this->registeredPlayers[$playerName]);
    }

    public function isPlayerLoggedIn(string $playerName): bool {
        return isset($this->loginStatus[$playerName]) && $this->loginStatus[$playerName] === true;
    }

    public function setPlayerLoggedIn(string $playerName): void {
        $this->loginStatus[$playerName] = true;
    }

    public function registerPlayer(string $playerName, string $password): void {
        $this->registeredPlayers[$playerName] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $playerName, string $password): bool {
        return password_verify($password, $this->registeredPlayers[$playerName] ?? '');
    }

    public function showRegisterForm(Player $player): void {
        $form = new RegisterForm($this);
        $player->sendForm($form);
    }

    public function showLoginForm(Player $player): void {
        $form = new LoginForm($this);
        $player->sendForm($form);
    }
}
