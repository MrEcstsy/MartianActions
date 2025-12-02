<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action;

use pocketmine\player\Player;

interface Action {
    public function execute(Player $player, array $data): void;
}