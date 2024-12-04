<?php

namespace perworldregister\forms;

use perworldregister\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class RegisterForm implements Form {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function jsonSerialize(): array {
        return [
            "type" => "custom_form",
            "title" => "Register",
            "content" => [
                ["type" => "input", "text" => "Enter your password:", "placeholder" => "Password"],
                ["type" => "input", "text" => "Confirm your password:", "placeholder" => "Confirm Password"]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) return;

        [$password, $confirmPassword] = $data;

        if ($password !== $confirmPassword) {
            $player->sendMessage(TextFormat::RED . "Passwords do not match!");
            return;
        }

        $this->plugin->registerPlayer($player->getName(), $password);
        $player->sendMessage(TextFormat::GREEN . "Registration successful! Please log in.");
    }
}
