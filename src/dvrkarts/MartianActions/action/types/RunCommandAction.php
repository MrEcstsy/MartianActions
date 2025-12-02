<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action\types;

use dvrkarts\MartianActions\action\Action;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

final class RunCommandAction implements Action {

    public function execute(Player $player, array $data): void
    {
        if (!isset($data["commands"]) || !is_array($data["commands"])) {
            return;
        }

        $runAs = strtolower($data["run-as"] ?? "console");

        foreach ($data["commands"] as $command) {
            $command = str_replace("{player}", $player->getName(), $command);

            switch ($runAs) {

                case "player":
                    $player->getServer()->dispatchCommand($player, $command);
                    break;
                case "console":
                default:
                    $console = new ConsoleCommandSender(
                        Server::getInstance(),
                        Server::getInstance()->getLanguage()
                    );
                    $player->getServer()->dispatchCommand($console, $command);
                    break;
            }
        }
    }
}
