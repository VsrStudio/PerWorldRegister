<?php

namespace perworldregister\forms;

use perworldregister\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class LoginForm implements Form {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function jsonSerialize(): array {
        return [
            "type" => "custom_form",
            "title" => "Login",
            "content" => [
                ["type" => "input", "text" => "Enter your password:", "placeholder" => "Password"]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) return;

        [$password] = $data;

        if (!$this->plugin->verifyPassword($player->getName(), $password)) {
            $player->sendMessage(TextFormat::RED . "Incorrect password!");
            return;
        }

        $this->plugin->setPlayerLoggedIn($player->getName());
        $player->sendMessage(TextFormat::GREEN . "Login successful!");
    }
}
