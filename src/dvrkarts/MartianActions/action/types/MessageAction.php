<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action\types;

use dvrkarts\MartianActions\action\Action;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

final class MessageAction implements Action {

    public function execute(Player $player, array $data): void
    {
        if (!isset($data["text"])) {
            return;
        }

        $text = C::colorize($data["text"]);
        $type = strtolower($data["message-type"] ?? "chat");

        switch ($type) {

            case "title":
                $subtitle = isset($data["subtitle"])
                    ? C::colorize($data["subtitle"])
                    : "";
                $player->sendTitle($text, $subtitle);
                break;

            case "actionbar":
                $player->sendActionBarMessage($text);
                break;

            case "chat":
            default:
                $player->sendMessage($text);
                break;
        }
    }
}
