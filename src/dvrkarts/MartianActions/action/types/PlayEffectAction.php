<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action\types;

use dvrkarts\MartianActions\action\Action;
use ecstsy\MartianUtilities\utils\GeneralUtils;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\world\Position;

final class PlayEffectAction implements Action {

    public function execute(Player $player, array $data): void {

        $effect = $data["effect"] ?? null;

        if ($effect === null) {
            $player->sendMessage(C::colorize("&c[MartianActions] Missing 'effect' in play_effect action."));
            return;
        }

        $offsetX = GeneralUtils::parseRandomNumber($data["offset"]["x"] ?? 0);
        $offsetY = GeneralUtils::parseRandomNumber($data["offset"]["y"] ?? 0);
        $offsetZ = GeneralUtils::parseRandomNumber($data["offset"]["z"] ?? 0);

        $repeat = GeneralUtils::parseRandomNumber($data["repeat"] ?? 1);

        for ($i = 0; $i < $repeat; $i++) {

            $base = $player->getLocation();

            $position = new Position(
                $base->getX() + $offsetX,
                $base->getY() + $offsetY,
                $base->getZ() + $offsetZ,
                $base->getWorld()
            );

            GeneralUtils::addParticleToPosition($position, $effect);
        }
    }
}
